<?php
/**
 * Contact form + lead capture (AUD-001 / AUD-002).
 *
 * - Registers a private `stretch_lead` CPT so every submission is stored in
 *   the database regardless of email deliverability.
 * - Handles POSTs from the contact page, the blog newsletter form, and the
 *   exit-intent popup via admin-post.php (logged-in and logged-out).
 * - Attempts a wp_mail() notification to the site admin; the lead is saved
 *   either way, so no submission is ever lost to a mail failure.
 *
 * Templates using this:
 * - page-contact.php  (lead_type=contact)
 * - single.php        (lead_type=newsletter, lead_type=exit_intent)
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Recipient for lead-notification emails. Defaults to cole@stretchcreative.co.
 * Override with the STRETCH_LEAD_NOTIFY_EMAIL constant (e.g. in wp-config.php)
 * or the `stretch_lead_notify_email` filter; falls back to the WordPress admin
 * email if the configured value isn't a valid address.
 */
if (!defined('STRETCH_LEAD_NOTIFY_EMAIL')) {
    define('STRETCH_LEAD_NOTIFY_EMAIL', 'cole@stretchcreative.co');
}

function stretch_lead_notify_email() {
    $default = STRETCH_LEAD_NOTIFY_EMAIL ?: get_option('admin_email');
    $email   = (string) apply_filters('stretch_lead_notify_email', $default);
    return is_email($email) ? $email : get_option('admin_email');
}

/**
 * Register the Leads post type. Not publicly queryable — admin-only storage.
 */
function stretch_register_lead_cpt() {
    register_post_type('stretch_lead', [
        'labels' => [
            'name'               => 'Leads',
            'singular_name'      => 'Lead',
            'menu_name'          => 'Leads',
            'all_items'          => 'All Leads',
            'edit_item'          => 'Lead Details',
            'view_item'          => 'View Lead',
            'search_items'       => 'Search Leads',
            'not_found'          => 'No leads captured yet.',
            'not_found_in_trash' => 'No leads in Trash.',
        ],
        'public'              => false,
        'publicly_queryable'  => false,
        'exclude_from_search' => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'show_in_admin_bar'   => false,
        'show_in_rest'        => false,
        'has_archive'         => false,
        'rewrite'             => false,
        'query_var'           => false,
        'menu_position'       => 26,
        'menu_icon'           => 'dashicons-email-alt',
        'supports'            => ['title', 'custom-fields'],
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        // Leads come from the public forms, not the editor.
        'capabilities'        => ['create_posts' => 'do_not_allow'],
    ]);
}
add_action('init', 'stretch_register_lead_cpt');

/**
 * Core capture logic: validate, store a stretch_lead post, then attempt an
 * admin email notification. Kept separate from the request handler so it can
 * be exercised directly (e.g. via `wp eval`).
 *
 * @param array $data { type, name, email, company, message, source } — raw values.
 * @return int|WP_Error Lead post ID on success.
 */
function stretch_capture_lead(array $data) {
    $type = isset($data['type']) ? sanitize_key($data['type']) : 'contact';
    if (!in_array($type, ['contact', 'newsletter', 'exit_intent'], true)) {
        $type = 'contact';
    }

    $email   = isset($data['email']) ? sanitize_email($data['email']) : '';
    $name    = isset($data['name']) ? sanitize_text_field($data['name']) : '';
    $company = isset($data['company']) ? sanitize_text_field($data['company']) : '';
    $message = isset($data['message']) ? sanitize_textarea_field($data['message']) : '';
    $source  = isset($data['source']) ? esc_url_raw($data['source']) : '';

    $message = function_exists('mb_substr') ? mb_substr($message, 0, 5000) : substr($message, 0, 5000);

    if (!$email || !is_email($email)) {
        return new WP_Error('invalid_email', 'Please enter a valid email address.');
    }
    if ($type === 'contact' && ($name === '' || $message === '')) {
        return new WP_Error('missing_fields', 'Please fill in your name, email, and message.');
    }

    $who     = ($name !== '') ? $name : $email;
    $lead_id = wp_insert_post([
        'post_type'   => 'stretch_lead',
        'post_status' => 'publish', // CPT is not publicly queryable, so never exposed
        'post_title'  => sprintf('%s — %s', $who, date_i18n('Y-m-d H:i')),
        'meta_input'  => [
            'stretch_name'    => $name,
            'stretch_email'   => $email,
            'stretch_company' => $company,
            'stretch_message' => $message,
            'stretch_type'    => $type,
            'stretch_source'  => $source,
        ],
    ], true);

    if (is_wp_error($lead_id)) {
        return $lead_id;
    }

    // Notify the site admin. The lead is already stored, so a mail failure is
    // non-fatal; record the outcome on the lead for debugging.
    $subject_map = [
        'contact'     => 'New contact form message',
        'newsletter'  => 'New newsletter signup',
        'exit_intent' => 'New newsletter signup (exit popup)',
    ];
    $subject = sprintf('[%s] %s — %s', wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES), $subject_map[$type], $who);

    $body  = 'Type: ' . $type . "\n";
    $body .= 'Name: ' . ($name !== '' ? $name : '—') . "\n";
    $body .= 'Email: ' . $email . "\n";
    if ($company !== '') {
        $body .= 'Company: ' . $company . "\n";
    }
    if ($source !== '') {
        $body .= 'Page: ' . $source . "\n";
    }
    $body .= 'Lead: ' . admin_url('post.php?post=' . $lead_id . '&action=edit') . "\n";
    if ($message !== '') {
        $body .= "\nMessage:\n" . $message . "\n";
    }

    $headers   = ['Content-Type: text/plain; charset=UTF-8'];
    $headers[] = sprintf('Reply-To: %s <%s>', $who, $email);

    $mail_sent = wp_mail(stretch_lead_notify_email(), $subject, $body, $headers);
    update_post_meta($lead_id, 'stretch_mail_sent', $mail_sent ? '1' : '0');

    return $lead_id;
}

/**
 * admin-post.php handler for all three public forms.
 * Verifies nonce + honeypot, captures the lead, then responds with JSON
 * (fetch submissions) or a redirect back to the source page
 * (?sent=1 / ?lead_error=1, plus lead=<type>).
 */
function stretch_contact_handler() {
    $is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower(sanitize_text_field(wp_unslash($_SERVER['HTTP_X_REQUESTED_WITH']))) === 'xmlhttprequest';

    $type = isset($_POST['lead_type']) ? sanitize_key(wp_unslash($_POST['lead_type'])) : 'contact';
    if (!in_array($type, ['contact', 'newsletter', 'exit_intent'], true)) {
        $type = 'contact';
    }

    $nonce = isset($_POST['stretch_contact_nonce']) ? sanitize_text_field(wp_unslash($_POST['stretch_contact_nonce'])) : '';
    if (!wp_verify_nonce($nonce, 'stretch_contact')) {
        stretch_contact_respond(false, 'Your session expired. Please reload the page and try again.', $type, $is_ajax);
    }

    // Honeypot: hidden "website" field. Humans never see it; bots fill it.
    // Accept silently (so bots learn nothing) but store nothing.
    if (!empty($_POST['website'])) {
        stretch_contact_respond(true, '', $type, $is_ajax);
    }

    $source = isset($_POST['source']) ? esc_url_raw(wp_unslash($_POST['source'])) : '';
    if ($source === '') {
        $source = (string) wp_get_referer();
    }

    $result = stretch_capture_lead([
        'type'    => $type,
        'name'    => isset($_POST['name']) ? wp_unslash($_POST['name']) : '',
        'email'   => isset($_POST['email']) ? wp_unslash($_POST['email']) : '',
        'company' => isset($_POST['company']) ? wp_unslash($_POST['company']) : '',
        'message' => isset($_POST['message']) ? wp_unslash($_POST['message']) : '',
        'source'  => $source,
    ]);

    if (is_wp_error($result)) {
        stretch_contact_respond(false, $result->get_error_message(), $type, $is_ajax);
    }

    stretch_contact_respond(true, '', $type, $is_ajax);
}
add_action('admin_post_nopriv_stretch_contact', 'stretch_contact_handler');
add_action('admin_post_stretch_contact', 'stretch_contact_handler');

/**
 * Send the response for stretch_contact_handler(). Always exits.
 *
 * @param bool   $ok      Whether the submission was accepted.
 * @param string $message Error message (error responses only).
 * @param string $type    Lead type (contact|newsletter|exit_intent).
 * @param bool   $is_ajax True for fetch/XHR submissions → JSON response.
 */
function stretch_contact_respond($ok, $message, $type, $is_ajax) {
    if ($is_ajax) {
        if ($ok) {
            wp_send_json_success(['message' => 'Thanks — we received your submission.']);
        }
        wp_send_json_error(['message' => $message], 400);
    }

    $target = isset($_POST['source']) ? esc_url_raw(wp_unslash($_POST['source'])) : '';
    if ($target === '') {
        $target = (string) wp_get_referer();
    }
    $target = wp_validate_redirect($target, home_url('/'));
    $target = remove_query_arg(['sent', 'lead_error', 'lead'], $target);
    // Note: `lead_error` rather than `error` — WP core reserves `error` as a
    // public query var and strips it from $_GET (class-wp.php parse_request).
    $target = add_query_arg($ok ? ['sent' => 1, 'lead' => $type] : ['lead_error' => 1, 'lead' => $type], $target);

    // Land the visitor on the relevant form so the status message is visible.
    $anchors = [
        'contact'     => '#contact-form',
        'newsletter'  => '#newsletter-signup',
        'exit_intent' => '#newsletter-signup',
    ];
    if (isset($anchors[$type])) {
        $target .= $anchors[$type];
    }

    wp_safe_redirect($target);
    exit;
}

/**
 * Print the shared hidden fields for a lead-capture form:
 * admin-post action, lead type, source URL, nonce, and honeypot.
 * Call inside a <form method="post" action="admin_url('admin-post.php')">.
 *
 * @param string $type contact|newsletter|exit_intent
 */
function stretch_lead_form_fields($type = 'contact') {
    if (!in_array($type, ['contact', 'newsletter', 'exit_intent'], true)) {
        $type = 'contact';
    }
    $source = is_singular() ? get_permalink() : '';
    if (!$source) {
        $source = home_url('/');
    }

    echo '<input type="hidden" name="action" value="stretch_contact">' . "\n";
    echo '<input type="hidden" name="lead_type" value="' . esc_attr($type) . '">' . "\n";
    echo '<input type="hidden" name="source" value="' . esc_url($source) . '">' . "\n";
    wp_nonce_field('stretch_contact', 'stretch_contact_nonce');

    // Honeypot — visually hidden and out of the tab order; bots fill it.
    echo '<div style="position:absolute !important;left:-9999px !important;top:auto;width:1px;height:1px;overflow:hidden;" aria-hidden="true">';
    echo '<label for="stretch-hp-' . esc_attr($type) . '">Website</label>';
    echo '<input type="text" id="stretch-hp-' . esc_attr($type) . '" name="website" tabindex="-1" autocomplete="off" value="">';
    echo '</div>' . "\n";
}

/**
 * Admin list columns for Leads so submissions are scannable at a glance.
 */
function stretch_lead_admin_columns($columns) {
    return [
        'cb'              => isset($columns['cb']) ? $columns['cb'] : '<input type="checkbox" />',
        'title'           => 'Lead',
        'stretch_type'    => 'Type',
        'stretch_email'   => 'Email',
        'stretch_company' => 'Company',
        'stretch_source'  => 'Source',
        'date'            => isset($columns['date']) ? $columns['date'] : 'Date',
    ];
}
add_filter('manage_stretch_lead_posts_columns', 'stretch_lead_admin_columns');

function stretch_lead_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'stretch_type':
            echo esc_html(get_post_meta($post_id, 'stretch_type', true));
            break;
        case 'stretch_email':
            $email = get_post_meta($post_id, 'stretch_email', true);
            if ($email) {
                echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
            }
            break;
        case 'stretch_company':
            echo esc_html(get_post_meta($post_id, 'stretch_company', true));
            break;
        case 'stretch_source':
            echo esc_html(get_post_meta($post_id, 'stretch_source', true));
            break;
    }
}
add_action('manage_stretch_lead_posts_custom_column', 'stretch_lead_admin_column_content', 10, 2);

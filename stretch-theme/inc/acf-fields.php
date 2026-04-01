<?php
/**
 * ACF Flexible Content field group registration.
 * Registers all section layouts for the page builder.
 */

// ACF check is inside the acf/init hook below — no early return needed.

/**
 * Shared section settings fields (reused in every layout).
 */
function stretch_section_settings_fields($prefix) {
    return [
        [
            'key'     => "field_{$prefix}_bg_style",
            'label'   => 'Background Style',
            'name'    => 'background_style',
            'type'    => 'select',
            'choices' => ['white' => 'White', 'light' => 'Light', 'dark' => 'Dark', 'purple' => 'Purple'],
            'default_value' => 'white',
        ],
        [
            'key'   => "field_{$prefix}_bg_custom",
            'label' => 'Custom Background Color',
            'name'  => 'custom_background_color',
            'type'  => 'color_picker',
            'instructions' => 'Leave blank to use the selected style.',
        ],
        [
            'key'   => "field_{$prefix}_section_id",
            'label' => 'Section ID',
            'name'  => 'section_id',
            'type'  => 'text',
            'instructions' => 'For anchor links (e.g., "about" creates #about).',
        ],
        [
            'key'     => "field_{$prefix}_padding",
            'label'   => 'Padding',
            'name'    => 'padding_style',
            'type'    => 'select',
            'choices' => ['default' => 'Default', 'compact' => 'Compact', 'none' => 'None'],
            'default_value' => 'default',
        ],
    ];
}

add_action('acf/init', function () {

    acf_add_local_field_group([
        'key'      => 'group_page_sections',
        'title'    => 'Page Sections',
        'fields'   => [
            [
                'key'        => 'field_page_sections',
                'label'      => 'Sections',
                'name'       => 'page_sections',
                'type'       => 'flexible_content',
                'button_label' => 'Add Section',
                'layouts'    => [

                    // ── 1. Hero ──
                    'hero' => [
                        'key'        => 'layout_hero',
                        'name'       => 'hero',
                        'label'      => 'Hero',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_hero_overline',   'label' => 'Overline',        'name' => 'overline',        'type' => 'text'],
                                ['key' => 'field_hero_headline',   'label' => 'Headline',        'name' => 'headline',        'type' => 'text',     'required' => 1],
                                ['key' => 'field_hero_accent',     'label' => 'Accent Word(s)',   'name' => 'accent_text',     'type' => 'text',     'instructions' => 'Word(s) in headline that get the gradient accent. Leave blank for no accent.'],
                                ['key' => 'field_hero_subtitle',   'label' => 'Subtitle',        'name' => 'subtitle',        'type' => 'textarea', 'rows' => 2],
                                ['key' => 'field_hero_supporting', 'label' => 'Supporting Text',  'name' => 'supporting_text', 'type' => 'textarea', 'rows' => 2],
                                ['key' => 'field_hero_cta',        'label' => 'CTA Button',      'name' => 'cta_button',      'type' => 'link'],
                                ['key' => 'field_hero_cta2',       'label' => 'Secondary CTA',   'name' => 'secondary_cta',   'type' => 'link'],
                                ['key' => 'field_hero_bg_image',   'label' => 'Background Image', 'name' => 'bg_image',       'type' => 'image',    'return_format' => 'url'],
                                ['key' => 'field_hero_bg_video',   'label' => 'Background Video URL', 'name' => 'bg_video',   'type' => 'url'],
                                ['key' => 'field_hero_shapes',     'label' => 'Show Animated Shapes', 'name' => 'show_shapes', 'type' => 'true_false', 'default_value' => 1],
                            ],
                            stretch_section_settings_fields('hero')
                        ),
                    ],

                    // ── 2. Content Block ──
                    'content-block' => [
                        'key'        => 'layout_content_block',
                        'name'       => 'content-block',
                        'label'      => 'Content Block',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_cb_overline',  'label' => 'Overline',        'name' => 'overline',        'type' => 'text'],
                                ['key' => 'field_cb_heading',   'label' => 'Heading',         'name' => 'heading',         'type' => 'text'],
                                ['key' => 'field_cb_body',      'label' => 'Body Content',    'name' => 'body_content',    'type' => 'wysiwyg',  'toolbar' => 'full', 'media_upload' => 1],
                                ['key' => 'field_cb_highlight', 'label' => 'Pull Highlight',  'name' => 'pull_highlight',  'type' => 'textarea', 'rows' => 3, 'instructions' => 'Displays as a left-bordered pullquote. Leave blank to skip.'],
                                ['key' => 'field_cb_width',     'label' => 'Max Width',       'name' => 'max_width',       'type' => 'select',   'choices' => ['normal' => 'Normal (780px)', 'wide' => 'Wide (1100px)'], 'default_value' => 'normal'],
                            ],
                            stretch_section_settings_fields('cb')
                        ),
                    ],

                    // ── 3. Card Grid ──
                    'card-grid' => [
                        'key'        => 'layout_card_grid',
                        'name'       => 'card-grid',
                        'label'      => 'Card Grid',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_cg_overline', 'label' => 'Overline',  'name' => 'overline', 'type' => 'text'],
                                ['key' => 'field_cg_heading',  'label' => 'Heading',   'name' => 'heading',  'type' => 'text'],
                                ['key' => 'field_cg_columns',  'label' => 'Columns',   'name' => 'columns',  'type' => 'select', 'choices' => ['2' => '2 Columns', '3' => '3 Columns', '4' => '4 Columns'], 'default_value' => '3'],
                                ['key' => 'field_cg_featured', 'label' => 'Featured First Card', 'name' => 'featured_first', 'type' => 'true_false', 'instructions' => 'First card spans full width with dark background.'],
                                [
                                    'key'        => 'field_cg_cards',
                                    'label'      => 'Cards',
                                    'name'       => 'cards',
                                    'type'       => 'repeater',
                                    'layout'     => 'block',
                                    'button_label' => 'Add Card',
                                    'sub_fields' => [
                                        ['key' => 'field_cg_card_icon',  'label' => 'Icon',        'name' => 'icon',        'type' => 'image', 'return_format' => 'array', 'instructions' => 'Upload SVG or image for card icon.'],
                                        ['key' => 'field_cg_card_svg',   'label' => 'SVG Code',    'name' => 'svg_code',    'type' => 'textarea', 'rows' => 3, 'instructions' => 'Paste raw SVG markup. Used if no icon image is uploaded.'],
                                        ['key' => 'field_cg_card_tag',   'label' => 'Tag Label',   'name' => 'tag_label',   'type' => 'text', 'instructions' => 'Small tag above title (e.g., "The Centerpiece"). Only shows on featured cards.'],
                                        ['key' => 'field_cg_card_title', 'label' => 'Title',       'name' => 'title',       'type' => 'text', 'required' => 1],
                                        ['key' => 'field_cg_card_desc',  'label' => 'Description', 'name' => 'description', 'type' => 'textarea'],
                                        ['key' => 'field_cg_card_link',  'label' => 'Link',        'name' => 'link',        'type' => 'link'],
                                    ],
                                ],
                            ],
                            stretch_section_settings_fields('cg')
                        ),
                    ],

                    // ── 4. Pull Quote Banner ──
                    'pull-quote-banner' => [
                        'key'        => 'layout_pull_quote',
                        'name'       => 'pull-quote-banner',
                        'label'      => 'Pull Quote Banner',
                        'sub_fields' => [
                            ['key' => 'field_pq_quote',  'label' => 'Quote Text',    'name' => 'quote_text',   'type' => 'textarea', 'required' => 1],
                            ['key' => 'field_pq_accent', 'label' => 'Accent Phrase', 'name' => 'accent_phrase', 'type' => 'text', 'instructions' => 'Word(s) to highlight in cyan.'],
                        ],
                    ],

                    // ── 5. Logo Carousel ──
                    'logo-carousel' => [
                        'key'        => 'layout_logo_carousel',
                        'name'       => 'logo-carousel',
                        'label'      => 'Logo Carousel',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_lc_heading',    'label' => 'Heading',    'name' => 'heading',    'type' => 'text'],
                                ['key' => 'field_lc_subheading', 'label' => 'Subheading', 'name' => 'subheading', 'type' => 'text'],
                                [
                                    'key'          => 'field_lc_logos',
                                    'label'        => 'Logos',
                                    'name'         => 'logos',
                                    'type'         => 'repeater',
                                    'layout'       => 'table',
                                    'button_label' => 'Add Logo',
                                    'sub_fields'   => [
                                        ['key' => 'field_lc_logo_image', 'label' => 'Logo Image',   'name' => 'logo_image',   'type' => 'image', 'return_format' => 'array'],
                                        ['key' => 'field_lc_logo_name',  'label' => 'Company Name', 'name' => 'company_name', 'type' => 'text'],
                                    ],
                                ],
                            ],
                            stretch_section_settings_fields('lc')
                        ),
                    ],

                    // ── 6. Testimonials ──
                    'testimonials' => [
                        'key'        => 'layout_testimonials',
                        'name'       => 'testimonials',
                        'label'      => 'Testimonials',
                        'sub_fields' => array_merge(
                            [
                                [
                                    'key'          => 'field_tm_items',
                                    'label'        => 'Testimonials',
                                    'name'         => 'testimonials',
                                    'type'         => 'repeater',
                                    'layout'       => 'block',
                                    'button_label' => 'Add Testimonial',
                                    'sub_fields'   => [
                                        ['key' => 'field_tm_quote',   'label' => 'Quote',   'name' => 'quote',   'type' => 'textarea', 'required' => 1],
                                        ['key' => 'field_tm_name',    'label' => 'Name',    'name' => 'name',    'type' => 'text',     'required' => 1],
                                        ['key' => 'field_tm_title',   'label' => 'Title',   'name' => 'title',   'type' => 'text'],
                                        ['key' => 'field_tm_company', 'label' => 'Company', 'name' => 'company', 'type' => 'text'],
                                        ['key' => 'field_tm_photo',   'label' => 'Photo',   'name' => 'photo',   'type' => 'image', 'return_format' => 'array'],
                                    ],
                                ],
                            ],
                            stretch_section_settings_fields('tm')
                        ),
                    ],

                    // ── 7. Process Steps ──
                    'process-steps' => [
                        'key'        => 'layout_process_steps',
                        'name'       => 'process-steps',
                        'label'      => 'Process Steps',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_ps_overline', 'label' => 'Overline', 'name' => 'overline', 'type' => 'text'],
                                ['key' => 'field_ps_heading',  'label' => 'Heading',  'name' => 'heading',  'type' => 'text'],
                                [
                                    'key'          => 'field_ps_steps',
                                    'label'        => 'Steps',
                                    'name'         => 'steps',
                                    'type'         => 'repeater',
                                    'layout'       => 'block',
                                    'button_label' => 'Add Step',
                                    'sub_fields'   => [
                                        ['key' => 'field_ps_step_title', 'label' => 'Title',       'name' => 'title',       'type' => 'text', 'required' => 1],
                                        ['key' => 'field_ps_step_desc',  'label' => 'Description', 'name' => 'description', 'type' => 'textarea'],
                                        ['key' => 'field_ps_step_icon',  'label' => 'Icon',        'name' => 'icon',        'type' => 'image', 'return_format' => 'array'],
                                    ],
                                ],
                            ],
                            stretch_section_settings_fields('ps')
                        ),
                    ],

                    // ── 8. CTA Section ──
                    'cta-section' => [
                        'key'        => 'layout_cta_section',
                        'name'       => 'cta-section',
                        'label'      => 'CTA Section',
                        'sub_fields' => [
                            ['key' => 'field_cta_heading',   'label' => 'Heading',          'name' => 'heading',        'type' => 'text',     'required' => 1],
                            ['key' => 'field_cta_body',      'label' => 'Body Text',        'name' => 'body_text',      'type' => 'textarea'],
                            ['key' => 'field_cta_button',    'label' => 'CTA Button',       'name' => 'cta_button',     'type' => 'link',     'required' => 1],
                            ['key' => 'field_cta_button2',   'label' => 'Secondary Button', 'name' => 'secondary_button', 'type' => 'link'],
                            ['key' => 'field_cta_bg',        'label' => 'Background',       'name' => 'bg_style',       'type' => 'select',   'choices' => ['purple' => 'Purple', 'dark' => 'Dark', 'custom' => 'Custom Color'], 'default_value' => 'purple'],
                            ['key' => 'field_cta_bg_custom', 'label' => 'Custom Background Color', 'name' => 'custom_bg_color', 'type' => 'color_picker', 'conditional_logic' => [[ ['field' => 'field_cta_bg', 'operator' => '==', 'value' => 'custom'] ]]],
                        ],
                    ],

                    // ── 9. Image + Text ──
                    'image-text' => [
                        'key'        => 'layout_image_text',
                        'name'       => 'image-text',
                        'label'      => 'Image + Text',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_it_image',     'label' => 'Image',          'name' => 'image',          'type' => 'image', 'return_format' => 'array', 'required' => 1],
                                ['key' => 'field_it_position',  'label' => 'Image Position', 'name' => 'image_position', 'type' => 'select', 'choices' => ['left' => 'Left', 'right' => 'Right'], 'default_value' => 'right'],
                                ['key' => 'field_it_overline',  'label' => 'Overline',       'name' => 'overline',       'type' => 'text'],
                                ['key' => 'field_it_heading',   'label' => 'Heading',        'name' => 'heading',        'type' => 'text'],
                                ['key' => 'field_it_body',      'label' => 'Body',           'name' => 'body_content',   'type' => 'wysiwyg', 'toolbar' => 'full'],
                                ['key' => 'field_it_cta',       'label' => 'CTA Button',     'name' => 'cta_button',     'type' => 'link'],
                            ],
                            stretch_section_settings_fields('it')
                        ),
                    ],

                    // ── 10. Accordion / FAQ ──
                    'accordion-faq' => [
                        'key'        => 'layout_accordion_faq',
                        'name'       => 'accordion-faq',
                        'label'      => 'Accordion / FAQ',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_faq_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'],
                                [
                                    'key'          => 'field_faq_items',
                                    'label'        => 'Items',
                                    'name'         => 'items',
                                    'type'         => 'repeater',
                                    'layout'       => 'block',
                                    'button_label' => 'Add Item',
                                    'sub_fields'   => [
                                        ['key' => 'field_faq_q', 'label' => 'Question / Title', 'name' => 'question', 'type' => 'text',    'required' => 1],
                                        ['key' => 'field_faq_a', 'label' => 'Answer / Content', 'name' => 'answer',   'type' => 'wysiwyg', 'toolbar' => 'basic', 'media_upload' => 0],
                                    ],
                                ],
                            ],
                            stretch_section_settings_fields('faq')
                        ),
                    ],

                    // ── 11. Team Grid ──
                    'team-grid' => [
                        'key'        => 'layout_team_grid',
                        'name'       => 'team-grid',
                        'label'      => 'Team Grid',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_tg_heading', 'label' => 'Heading',    'name' => 'heading',    'type' => 'text'],
                                ['key' => 'field_tg_intro',   'label' => 'Intro Text', 'name' => 'intro_text', 'type' => 'textarea'],
                                [
                                    'key'          => 'field_tg_members',
                                    'label'        => 'Team Members',
                                    'name'         => 'team_members',
                                    'type'         => 'repeater',
                                    'layout'       => 'block',
                                    'button_label' => 'Add Member',
                                    'sub_fields'   => [
                                        ['key' => 'field_tg_photo', 'label' => 'Photo', 'name' => 'photo', 'type' => 'image', 'return_format' => 'array'],
                                        ['key' => 'field_tg_name',  'label' => 'Name',  'name' => 'name',  'type' => 'text', 'required' => 1],
                                        ['key' => 'field_tg_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                                        ['key' => 'field_tg_bio',   'label' => 'Bio',   'name' => 'bio',   'type' => 'textarea'],
                                    ],
                                ],
                            ],
                            stretch_section_settings_fields('tg')
                        ),
                    ],

                    // ── 12. Contact Block ──
                    'contact-block' => [
                        'key'        => 'layout_contact_block',
                        'name'       => 'contact-block',
                        'label'      => 'Contact Block',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_ct_heading',   'label' => 'Heading',        'name' => 'heading',        'type' => 'text'],
                                ['key' => 'field_ct_address',   'label' => 'Address',        'name' => 'address',        'type' => 'textarea'],
                                ['key' => 'field_ct_phone',     'label' => 'Phone',          'name' => 'phone',          'type' => 'text'],
                                ['key' => 'field_ct_email',     'label' => 'Email',          'name' => 'email',          'type' => 'email'],
                                [
                                    'key'          => 'field_ct_social',
                                    'label'        => 'Social Links',
                                    'name'         => 'social_links',
                                    'type'         => 'repeater',
                                    'layout'       => 'table',
                                    'button_label' => 'Add Link',
                                    'sub_fields'   => [
                                        ['key' => 'field_ct_social_platform', 'label' => 'Platform', 'name' => 'platform', 'type' => 'select', 'choices' => ['linkedin' => 'LinkedIn', 'twitter' => 'Twitter/X', 'instagram' => 'Instagram', 'facebook' => 'Facebook']],
                                        ['key' => 'field_ct_social_url',      'label' => 'URL',      'name' => 'url',      'type' => 'url'],
                                    ],
                                ],
                                ['key' => 'field_ct_form',   'label' => 'Form Shortcode', 'name' => 'form_shortcode', 'type' => 'text', 'instructions' => 'Paste the form plugin shortcode (e.g., [wpforms id="123"]).'],
                                ['key' => 'field_ct_layout', 'label' => 'Layout',         'name' => 'layout',         'type' => 'select', 'choices' => ['form-right' => 'Form Right', 'form-left' => 'Form Left'], 'default_value' => 'form-right'],
                            ],
                            stretch_section_settings_fields('ct')
                        ),
                    ],

                    // ── 13. Blog Preview ──
                    'blog-preview' => [
                        'key'        => 'layout_blog_preview',
                        'name'       => 'blog-preview',
                        'label'      => 'Blog Preview',
                        'sub_fields' => array_merge(
                            [
                                ['key' => 'field_bp_heading',    'label' => 'Heading',             'name' => 'heading',      'type' => 'text'],
                                ['key' => 'field_bp_subheading', 'label' => 'Subheading',          'name' => 'subheading',   'type' => 'text'],
                                ['key' => 'field_bp_count',      'label' => 'Number of Posts',     'name' => 'post_count',   'type' => 'number', 'default_value' => 3, 'min' => 1, 'max' => 12],
                                ['key' => 'field_bp_category',   'label' => 'Category Filter',     'name' => 'category',     'type' => 'taxonomy', 'taxonomy' => 'category', 'field_type' => 'select', 'allow_null' => 1, 'return_format' => 'id'],
                                ['key' => 'field_bp_filters',    'label' => 'Show Filter Buttons', 'name' => 'show_filters', 'type' => 'true_false'],
                            ],
                            stretch_section_settings_fields('bp')
                        ),
                    ],

                ], // end layouts
            ],
        ],
        'location' => [
            [['param' => 'post_type', 'operator' => '==', 'value' => 'page']],
        ],
        'style'           => 'seamless',
        'label_placement' => 'top',
    ]);
});

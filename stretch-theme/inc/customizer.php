<?php
/**
 * Theme Customizer: brand colors, typography, header, footer.
 */

function stretch_customize_register($wp_customize) {

    // ── Brand Colors Panel ──
    $wp_customize->add_panel('stretch_brand', [
        'title'    => __('Brand Settings', 'stretch'),
        'priority' => 30,
    ]);

    // Colors section
    $wp_customize->add_section('stretch_colors', [
        'title' => __('Brand Colors', 'stretch'),
        'panel' => 'stretch_brand',
    ]);

    $colors = [
        'stretch_color_primary'   => ['label' => 'Primary (Purple)',   'default' => '#8560A8'],
        'stretch_color_secondary' => ['label' => 'Secondary (Blue)',   'default' => '#5674B9'],
        'stretch_color_accent'    => ['label' => 'Accent (Cyan)',      'default' => '#00BFF3'],
        'stretch_color_dark'      => ['label' => 'Dark Background',    'default' => '#252C3A'],
        'stretch_color_body'      => ['label' => 'Body Text',          'default' => '#323A51'],
    ];

    foreach ($colors as $id => $config) {
        $wp_customize->add_setting($id, [
            'default'           => $config['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ]);
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, [
            'label'   => __($config['label'], 'stretch'),
            'section' => 'stretch_colors',
        ]));
    }

    // Typography section
    $wp_customize->add_section('stretch_typography', [
        'title' => __('Typography', 'stretch'),
        'panel' => 'stretch_brand',
    ]);

    $fonts = [
        'stretch_font_heading' => ['label' => 'Heading Font',  'default' => 'Poppins'],
        'stretch_font_body'    => ['label' => 'Body Font',     'default' => 'Assistant'],
        'stretch_font_nav'     => ['label' => 'Nav Font',      'default' => 'Montserrat'],
    ];

    foreach ($fonts as $id => $config) {
        $wp_customize->add_setting($id, [
            'default'           => $config['default'],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control($id, [
            'label'   => __($config['label'], 'stretch'),
            'section' => 'stretch_typography',
            'type'    => 'text',
        ]);
    }

    $wp_customize->add_setting('stretch_font_size_base', [
        'default'           => '18',
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control('stretch_font_size_base', [
        'label'   => __('Base Font Size (px)', 'stretch'),
        'section' => 'stretch_typography',
        'type'    => 'number',
        'input_attrs' => ['min' => 14, 'max' => 24, 'step' => 1],
    ]);

    // Header section
    $wp_customize->add_section('stretch_header', [
        'title' => __('Header', 'stretch'),
        'panel' => 'stretch_brand',
    ]);

    $wp_customize->add_setting('stretch_sticky_nav', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('stretch_sticky_nav', [
        'label'   => __('Enable Sticky Navigation', 'stretch'),
        'section' => 'stretch_header',
        'type'    => 'checkbox',
    ]);

    // Footer section
    $wp_customize->add_section('stretch_footer', [
        'title' => __('Footer', 'stretch'),
        'panel' => 'stretch_brand',
    ]);

    $wp_customize->add_setting('stretch_footer_tagline', [
        'default'           => 'The trusted partner for producing publish-ready content at scale — your story, your voice, on time.',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('stretch_footer_tagline', [
        'label'   => __('Footer Tagline', 'stretch'),
        'section' => 'stretch_footer',
        'type'    => 'textarea',
    ]);

    $wp_customize->add_setting('stretch_footer_copyright', [
        'default'           => '© Copyright ' . date('Y') . ' Stretch Creative',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control('stretch_footer_copyright', [
        'label'   => __('Copyright Text', 'stretch'),
        'section' => 'stretch_footer',
        'type'    => 'text',
    ]);
}
add_action('customize_register', 'stretch_customize_register');

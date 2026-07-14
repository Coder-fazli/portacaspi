<?php
/**
 * Theme functions and definitions.
 */

add_action('elementor/frontend/after_register_scripts', function () {
    $js_path  = get_stylesheet_directory() . '/assets/js/building-selector.js';
    $css_path = get_stylesheet_directory() . '/assets/css/building-selector.css';

    wp_register_script(
        'westio-child-building-selector',
        get_stylesheet_directory_uri() . '/assets/js/building-selector.js',
        ['jquery'],
        file_exists($js_path) ? filemtime($js_path) : '1.0.0',
        true
    );
    wp_register_style(
        'westio-child-building-selector',
        get_stylesheet_directory_uri() . '/assets/css/building-selector.css',
        [],
        file_exists($css_path) ? filemtime($css_path) : '1.0.0'
    );
});

add_action('elementor/widgets/register', function ($widgets_manager) {
    require_once get_stylesheet_directory() . '/inc/elementor/widget-building-selector.php';
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'westio-child-google-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300..800;1,300..800&display=swap',
        [],
        null
    );

    $typo_path = get_stylesheet_directory() . '/assets/css/typography.css';
    wp_enqueue_style(
        'westio-child-typography',
        get_stylesheet_directory_uri() . '/assets/css/typography.css',
        [],
        file_exists($typo_path) ? filemtime($typo_path) : '1.0.0'
    );

    $header_path = get_stylesheet_directory() . '/assets/css/header.css';
    wp_enqueue_style(
        'westio-child-header',
        get_stylesheet_directory_uri() . '/assets/css/header.css',
        [],
        file_exists($header_path) ? filemtime($header_path) : '1.0.0'
    );

    $footer_path = get_stylesheet_directory() . '/assets/css/footer.css';
    wp_enqueue_style(
        'westio-child-footer',
        get_stylesheet_directory_uri() . '/assets/css/footer.css',
        [],
        file_exists($footer_path) ? filemtime($footer_path) : '1.0.0'
    );
}, 20);

// Footer menu locations for the three "Explore" columns.
add_action('after_setup_theme', function () {
    register_nav_menus([
        'footer-1' => __('Footer Column 1', 'westio-child'),
        'footer-2' => __('Footer Column 2', 'westio-child'),
        'footer-3' => __('Footer Column 3', 'westio-child'),
    ]);
});

// Customizer: Footer section (address, copyright, watermark, social links).
add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_section('wc_footer', [
        'title'    => __('Footer', 'westio-child'),
        'priority' => 160,
    ]);

    // Parallax background image (media picker).
    $wp_customize->add_setting('wc_footer_bg_image', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'wc_footer_bg_image', [
        'label'   => __('Parallax background image', 'westio-child'),
        'section' => 'wc_footer',
    ]));

    $fields = [
        'wc_footer_address'   => [__('Address', 'westio-child'), "2972 Westheimer Rd.\nSanta Ana, Illinois 85486", 'textarea'],
        'wc_footer_copyright' => [__('Copyright', 'westio-child'), '© ' . date('Y') . ' Portacaspia', 'text'],
        'wc_footer_watermark' => [__('Watermark text', 'westio-child'), get_bloginfo('name'), 'text'],
        'wc_footer_facebook'  => [__('Facebook URL', 'westio-child'), '', 'url'],
        'wc_footer_twitter'   => [__('Twitter URL', 'westio-child'), '', 'url'],
        'wc_footer_instagram' => [__('Instagram URL', 'westio-child'), '', 'url'],
        'wc_footer_youtube'   => [__('Youtube URL', 'westio-child'), '', 'url'],
    ];

    foreach ($fields as $id => $data) {
        list($label, $default, $type) = $data;
        $wp_customize->add_setting($id, [
            'default'           => $default,
            'sanitize_callback' => ($type === 'url') ? 'esc_url_raw' : ($type === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field'),
        ]);
        $wp_customize->add_control($id, [
            'label'   => $label,
            'section' => 'wc_footer',
            'type'    => ($type === 'textarea') ? 'textarea' : 'text',
        ]);
    }
});

// Make custom header strings translatable in Polylang (Languages → Translations).
add_action('init', function () {
    if (function_exists('pll_register_string')) {
        pll_register_string('header-phone', get_theme_mod('wc_header_phone', '+994 12 345 67 89'), 'westio-child');
        pll_register_string('header-cta-label', 'Əlaqə', 'westio-child');
        pll_register_string('header-cta-url', '/elaqe/', 'westio-child');
    }
});

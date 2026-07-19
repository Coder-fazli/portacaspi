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

// Footer settings admin page (per-language content).
require_once get_stylesheet_directory() . '/inc/footer-settings.php';

// Override the parent's button-hover script with a Unicode-safe capitalization
// fix, without editing parent theme files. Same handle + dependencies.
add_action('wp_enqueue_scripts', function () {
    if (!wp_script_is('westio-button-hover', 'registered')) {
        return;
    }
    wp_deregister_script('westio-button-hover');

    $path = get_stylesheet_directory() . '/assets/js/frontend/button-hover.js';
    wp_register_script(
        'westio-button-hover',
        get_stylesheet_directory_uri() . '/assets/js/frontend/button-hover.js',
        ['jquery', 'westio-gsap', 'westio-splittext'],
        file_exists($path) ? filemtime($path) : '1.0.0',
        true
    );
    wp_enqueue_script('westio-button-hover');
}, 100);

// Header CTA / phone are now edited per-language in the Header & Footer
// admin page (see inc/footer-settings.php), no Polylang string scan needed.

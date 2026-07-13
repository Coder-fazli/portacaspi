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
}, 20);

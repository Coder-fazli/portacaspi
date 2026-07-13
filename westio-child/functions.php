<?php
/**
 * Theme functions and definitions.
 */

add_action('elementor/frontend/after_register_scripts', function () {
    wp_register_script(
        'westio-child-building-selector',
        get_stylesheet_directory_uri() . '/assets/js/building-selector.js',
        ['jquery'],
        '1.0.0',
        true
    );
    wp_register_style(
        'westio-child-building-selector',
        get_stylesheet_directory_uri() . '/assets/css/building-selector.css',
        [],
        '1.0.0'
    );
});

add_action('elementor/widgets/register', function ($widgets_manager) {
    require_once get_stylesheet_directory() . '/inc/elementor/widget-building-selector.php';
});

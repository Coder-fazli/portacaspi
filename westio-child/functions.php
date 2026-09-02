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

    $hero_js_path  = get_stylesheet_directory() . '/assets/js/hero-video.js';
    $hero_css_path = get_stylesheet_directory() . '/assets/css/hero-video.css';

    wp_register_script(
        'westio-child-hero-video',
        get_stylesheet_directory_uri() . '/assets/js/hero-video.js',
        [],
        file_exists($hero_js_path) ? filemtime($hero_js_path) : '1.0.0',
        true
    );
    wp_register_style(
        'westio-child-hero-video',
        get_stylesheet_directory_uri() . '/assets/css/hero-video.css',
        [],
        file_exists($hero_css_path) ? filemtime($hero_css_path) : '1.0.0'
    );

    $gallery_js_path  = get_stylesheet_directory() . '/assets/js/gallery-masonry.js';
    $gallery_css_path = get_stylesheet_directory() . '/assets/css/gallery-masonry.css';

    wp_register_script(
        'westio-child-gallery-masonry',
        get_stylesheet_directory_uri() . '/assets/js/gallery-masonry.js',
        [],
        file_exists($gallery_js_path) ? filemtime($gallery_js_path) : '1.0.0',
        true
    );
    wp_register_style(
        'westio-child-gallery-masonry',
        get_stylesheet_directory_uri() . '/assets/css/gallery-masonry.css',
        [],
        file_exists($gallery_css_path) ? filemtime($gallery_css_path) : '1.0.0'
    );

    $neighborhood_css_path = get_stylesheet_directory() . '/assets/css/neighborhood-map.css';

    wp_register_style(
        'westio-child-neighborhood-map',
        get_stylesheet_directory_uri() . '/assets/css/neighborhood-map.css',
        [],
        file_exists($neighborhood_css_path) ? filemtime($neighborhood_css_path) : '1.0.0'
    );

    $success_css_path = get_stylesheet_directory() . '/assets/css/success-message.css';

    wp_register_style(
        'westio-child-success-message',
        get_stylesheet_directory_uri() . '/assets/css/success-message.css',
        [],
        file_exists($success_css_path) ? filemtime($success_css_path) : '1.0.0'
    );
});

add_action('elementor/widgets/register', function ($widgets_manager) {
    require_once get_stylesheet_directory() . '/inc/elementor/widget-building-selector.php';
    require_once get_stylesheet_directory() . '/inc/elementor/widget-hero-video.php';
    require_once get_stylesheet_directory() . '/inc/elementor/widget-gallery-masonry.php';
    require_once get_stylesheet_directory() . '/inc/elementor/widget-neighborhood-map.php';
    require_once get_stylesheet_directory() . '/inc/elementor/widget-success-message.php';
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'westio-child-google-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300..800;1,300..800&family=Roboto:wght@300;400;500;600&display=swap',
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

    $header_js_path = get_stylesheet_directory() . '/assets/js/header.js';
    wp_enqueue_script(
        'westio-child-header',
        get_stylesheet_directory_uri() . '/assets/js/header.js',
        [],
        file_exists($header_js_path) ? filemtime($header_js_path) : '1.0.0',
        true
    );

    if (function_exists('wcf_get_header_logo_width')) {
        $logo_width = wcf_get_header_logo_width();
        wp_add_inline_style('westio-child-header', ".header-1 .site-branding img { width: {$logo_width}px; }");
    }

    $footer_path = get_stylesheet_directory() . '/assets/css/footer.css';
    wp_enqueue_style(
        'westio-child-footer',
        get_stylesheet_directory_uri() . '/assets/css/footer.css',
        [],
        file_exists($footer_path) ? filemtime($footer_path) : '1.0.0'
    );

    // Redirects to the matching language's success page after any Contact
    // Form 7 submission on the page — see assets/js/contact-redirect.js.
    $redirect_path = get_stylesheet_directory() . '/assets/js/contact-redirect.js';
    wp_enqueue_script(
        'westio-child-contact-redirect',
        get_stylesheet_directory_uri() . '/assets/js/contact-redirect.js',
        [],
        file_exists($redirect_path) ? filemtime($redirect_path) : '1.0.0',
        true
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

// If a language has no menu assigned to the "Handheld Menu" (mobile) theme
// location, WordPress's default behavior for wp_nav_menu() is to silently
// fall back to wp_list_pages() — a flat list of every published page, with
// no submenu structure at all (no menu-item-has-children, so the mobile
// nav's dropdown-toggle JS has nothing to attach to). Reuse whatever menu
// IS assigned to Primary instead, so mobile submenus keep working for any
// language without a separate Handheld assignment ever having to exist.
add_filter('wp_nav_menu_args', function ($args) {
    if (($args['theme_location'] ?? '') !== 'handheld') {
        return $args;
    }
    $locations = get_nav_menu_locations();
    if (!empty($locations['handheld']) || empty($locations['primary'])) {
        return $args;
    }
    $args['menu'] = $locations['primary'];
    return $args;
});

// Google Tag Manager.
add_action('wp_head', function () {
    ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MVK8Z6ST');</script>
<!-- End Google Tag Manager -->
    <?php
}, 1);

add_action('wp_body_open', function () {
    ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MVK8Z6ST"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <?php
});

<?php
$theme = wp_get_theme( 'westio' );
define( 'WESTIO_VERSION', $theme['Version'] );
define( 'WESTIO_SUFFIX', ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? "" : ".min" );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 980; /* pixels */
}
// Core includes
require_once get_theme_file_path( 'inc/class-tgm-plugin-activation.php' );
require_once get_theme_file_path( 'inc/functions.php' );
require_once get_theme_file_path( 'inc/template-hooks.php' );
require_once get_theme_file_path( 'inc/template-functions.php' );
require_once get_theme_file_path( 'inc/class-customize.php' );
require_once get_theme_file_path( 'inc/core/security/access-control.php' );

// Main class init
require_once get_theme_file_path( 'inc/class-main.php' );

if ( westio_is_cmb2_activated() ) {
    require_once get_theme_file_path( 'inc/cmb2_field_ajax_search/cmb2-field-ajax-search.php' );
}

if ( westio_is_elementor_activated() ) {
    require_once get_theme_file_path( 'inc/elementor/query-control/query-content.php' );
    require_once get_theme_file_path( 'inc/elementor/query-control/query-control.php' );

    if ( is_admin() ) {
        require_once get_theme_file_path( 'inc/elementor/class-admin.php' );
    }
    require_once get_theme_file_path( 'inc/elementor/functions-elementor.php' );

    require_once get_theme_file_path( 'inc/elementor/class-elementor.php' );
    //====start_premium
    require_once get_theme_file_path( 'inc/megamenu/megamenu.php' );
    //====end_premium
    require_once get_theme_file_path( 'inc/elementor/breadcrumb-settings.php' );
    require_once get_theme_file_path( 'inc/elementor/class-section-parallax.php' );
    require_once get_theme_file_path( 'inc/merlin/includes/base/class-multi-parallax.php' );
    require_once get_theme_file_path( 'inc/merlin/includes/base/class-custom-shapes.php' );


    if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
        require_once get_theme_file_path( 'inc/elementor/functions-elementor-pro.php' );
    }
}

if ( ! is_user_logged_in() ) {
    require get_theme_file_path( 'inc/modules/class-login.php' );
}
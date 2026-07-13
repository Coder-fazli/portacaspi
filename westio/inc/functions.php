<?php

if ( ! function_exists( 'westio_is_bcn_nav_activated' ) ) {
    function westio_is_bcn_nav_activated() {
        return function_exists( 'bcn_display' ) ? true : false;
    }
}

if ( ! function_exists( 'westio_is_cmb2_activated' ) ) {
    function westio_is_cmb2_activated() {
        return defined( 'CMB2_LOADED' ) ? true : false;
    }
}

if ( ! function_exists( 'westio_is_revslider_activated' ) ) {
    function westio_is_revslider_activated() {
        return class_exists( 'RevSliderBase' );
    }
}

if ( ! function_exists( 'westio_is_wpml_activated' ) ) {
    function westio_is_wpml_activated() {
        return class_exists( 'SitePress' ) ? true : false;
    }
}

if ( ! function_exists( 'westio_is_tribe_event_activated' ) ) {
    /**
     * Query Tribe__Events__Main activation
     */
    function westio_is_tribe_event_activated() {
        return class_exists( 'Tribe__Events__Main' ) ? true : false;
    }
}

if ( ! function_exists( 'westio_is_wcmp_activated' ) ) {
    /**
     * Query WooCommerce activation
     */
    function westio_is_wcmp_activated() {
        return class_exists( 'WCMp' ) ? true : false;
    }
}

if ( ! function_exists( 'westio_is_elementor_activated' ) ) {
    function westio_is_elementor_activated() {
        return defined( 'ELEMENTOR_VERSION' ) ? true : false;
    }
}

if ( ! function_exists( 'westio_is_elementor_pro_activated' ) ) {
    function westio_is_elementor_pro_activated() {
        return defined( 'ELEMENTOR_PRO_VERSION' ) ? true : false;
    }
}

if ( ! function_exists( 'westio_is_redux_activated' ) ) {
    function westio_is_redux_activated() {
        return class_exists( 'Redux' ) ? true : false;
    }
}

if ( ! function_exists( 'westio_is_contactform_activated' ) ) {
    function westio_is_contactform_activated() {
        return class_exists( 'WPCF7' );
    }
}

if ( ! function_exists( 'westio_is_mailchimp_activated' ) ) {
    function westio_is_mailchimp_activated() {
        return class_exists( 'MC4WP_MailChimp' );
    }
}

if ( ! function_exists( 'westio_is_get_a_quote_button_for_woocommerce_activated' ) ) {
    function westio_is_get_a_quote_button_for_woocommerce_activated() {
        return function_exists( 'WPB_Get_Quote_Button' );
    }
}

if ( ! function_exists( 'westio_elementor_check_type' ) ) {
    function westio_elementor_check_type( $type = '' ) {
        if ( $type ) {
            $data = get_post_meta( get_the_ID(), '_elementor_data', true );
            if ( $data ) {
                return preg_match( '/' . $type . '/', $data );
            }
        }

        return false;
    }
}


/**
 * Call a shortcode function by tag name.
 *
 * @param string $tag The shortcode whose function to call.
 * @param array $atts The attributes to pass to the shortcode function. Optional.
 * @param array $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 * @since  1.4.6
 *
 */
function westio_do_shortcode( $tag, array $atts = array(), $content = null ) {
    global $shortcode_tags;

    if ( ! isset( $shortcode_tags[ $tag ] ) ) {
        return false;
    }

    return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}


/**
 * Adjust a hex color brightness
 * Allows us to create hover styles for custom link colors
 *
 * @param strong $hex hex color e.g. #111111.
 * @param integer $steps factor by which to brighten/darken ranging from -255 (darken) to 255 (brighten).
 *
 * @return string        brightened/darkened hex color
 * @since  1.0.0
 */
function westio_adjust_color_brightness( $hex, $steps ) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter.
    $steps = max( - 255, min( 255, $steps ) );

    // Format the hex color string.
    $hex = str_replace( '#', '', $hex );

    if ( 3 === strlen( $hex ) ) {
        $hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
    }

    // Get decimal values.
    $r = hexdec( substr( $hex, 0, 2 ) );
    $g = hexdec( substr( $hex, 2, 2 ) );
    $b = hexdec( substr( $hex, 4, 2 ) );

    // Adjust number of steps and keep it inside 0 to 255.
    $r = max( 0, min( 255, $r + $steps ) );
    $g = max( 0, min( 255, $g + $steps ) );
    $b = max( 0, min( 255, $b + $steps ) );

    $r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
    $g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
    $b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

    return '#' . $r_hex . $g_hex . $b_hex;
}

/**
 * Sanitizes choices (selects / radios)
 * Checks that the input matches one of the available choices
 *
 * @param array $input the available choices.
 * @param array $setting the setting object.
 *
 * @since  1.3.0
 */
function westio_sanitize_choices( $input, $setting ) {
    // Ensure input is a slug.
    $input = sanitize_key( $input );

    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Checkbox sanitization callback.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 *
 * @return bool Whether the checkbox is checked.
 * @since  1.5.0
 */
function westio_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Westio Sanitize Hex Color
 *
 * @param string $color The color as a hex.
 *
 * @todo remove in 2.1.
 */
function westio_sanitize_hex_color( $color ) {
    _deprecated_function( 'westio_sanitize_hex_color', '2.0', 'sanitize_hex_color' );

    if ( '' === $color ) {
        return '';
    }

    // 3 or 6 hex digits, or the empty string.
    if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
        return $color;
    }

    return null;
}

/*
 * get theme option redux
 * @param string $option_name
 * @param mix $default
 * @return mix
 *
 * */

if ( ! function_exists( 'westio_get_theme_option' ) ) {
    function westio_get_theme_option( $option_name, $default = false ) {

        if ( $option = get_option( 'westio_options_' . $option_name ) ) {
            $default = $option;
        }

        return $default;
    }
}

if ( ! function_exists( 'westio_gqb_get_option' ) ) {
    function westio_gqb_get_option( $option, $section, $default = '' ) {

        $options = get_option( $section );

        if ( isset( $options[ $option ] ) ) {
            return $options[ $option ];
        }

        return $default;
    }
}

if ( ! function_exists( 'westio_get_post_meta' ) ) {
    function westio_get_post_meta( $post_id, $meta_name, $default = false ) {
        $value = get_post_meta( $post_id, $meta_name, true );
        if ( ! $value ) {
            return $default;
        }

        return $value;
    }
}

/**
 * @param $value
 *
 * @return string
 */
function westio_sanitize_editor( $value ) {
    return force_balance_tags( apply_filters( 'the_content', $value ) );
}

function westio_sanitize_input( $input ) {
    return strip_tags( stripslashes( $input ) );
}

function westio_sanitize_select( $input, $setting ) {
    // Ensure input is a slug.
    $input = sanitize_key( $input );
    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function westio_parse_text_editor( $content ) {

    $content = shortcode_unautop( $content );
    $content = do_shortcode( $content );
    $content = wptexturize( $content );

    if ( $GLOBALS['wp_embed'] instanceof \WP_Embed ) {
        $content = $GLOBALS['wp_embed']->autoembed( $content );
    }

    return $content;
}

/**
 * Validation: image
 * Control: text, WP_Customize_Image_Control
 *
 * @uses    wp_check_filetype()        https://developer.wordpress.org/reference/functions/wp_check_filetype/
 * @uses    in_array()                http://php.net/manual/en/function.in-array.php
 */
function westio_sanitize_image( $file, $setting ) {

    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );

    //check file type from file name
    $file_ext = wp_check_filetype( $file, $mimes );

    //if file has a valid mime type return it, otherwise return default
    return ( $file_ext['ext'] ? $file : $setting->default );
}

if ( ! function_exists( 'westio_put_file_contents' ) ) {
    function westio_put_file_contents( $file_path, $content ) {
        if ( ! function_exists( 'WP_Filesystem' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        global $wp_filesystem;
        if ( ! WP_Filesystem() ) {
            return false;
        }

        return $wp_filesystem->put_contents( $file_path, $content, FS_CHMOD_FILE );
    }
}

if ( ! function_exists( 'westio_get_file_contents' ) ) {
    function westio_get_file_contents( $file ) {
        if ( ! function_exists( 'WP_Filesystem' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        global $wp_filesystem;
        if ( ! WP_Filesystem() ) {
            return false;
        }

        return $wp_filesystem->get_contents( $file );
    }
}
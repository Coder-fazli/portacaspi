<?php

use Elementor\Controls_Manager;
use Elementor\Core\Files\File_Types\Svg;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Westio_Elementor' ) ) :

    /**
     * The Westio Elementor Integration class
     */
    class Westio_Elementor {

        public function __construct() {
            add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'register_auto_scripts_swiper' ] );
            add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'register_auto_scripts_frontend' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'add_scripts' ], 15 );
            add_action( 'elementor/elements/categories_registered', [ $this, 'create_custom_category' ], 999 );
            add_action( 'elementor/widgets/register', array( $this, 'include_widgets' ) );

            add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'add_js' ] );

            // Custom Animation Scroll
            add_filter( 'elementor/controls/animations/additional_animations', [ $this, 'add_animations_scroll' ] );
            add_filter( 'wp_enqueue_scripts', [ $this, 'add_animations_scroll_style' ] );

            // Backend
            add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'add_style_editor' ], 99 );
            add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'add_scripts_editor' ], 99 );

            // Add Icon Custom
            add_action( 'elementor/icons_manager/native', [ $this, 'add_icons_native' ] );
            add_action( 'elementor/controls/controls_registered', [ $this, 'add_icons' ] );

            // Add Breakpoints
            add_action( 'wp_enqueue_scripts', 'westio_elementor_breakpoints', 9999 );
            add_action( 'elementor/init', function () {
                if ( ! function_exists( 'westio_is_elementor_pro_activated' ) || ! westio_is_elementor_pro_activated() ) {
                    require_once get_theme_file_path( 'inc/elementor/motion-fx/controls-group.php' );
                    require_once get_theme_file_path( 'inc/elementor/motion-fx/module.php' );
                }
            } );

            if ( ! westio_is_elementor_pro_activated() ) {
                require trailingslashit( get_template_directory() ) . 'inc/elementor/class-custom-css.php';
                require trailingslashit( get_template_directory() ) . 'inc/elementor/class-section-sticky.php';
                require get_theme_file_path( 'inc/elementor/motion-fx/controls-group.php' );
                require get_theme_file_path( 'inc/elementor/motion-fx/module.php' );
            }

            add_filter( 'elementor/fonts/additional_fonts', [ $this, 'additional_fonts' ] );
        }


        public function additional_fonts( $fonts ) {
            $fonts["Vend Sans"] = 'system';

            return $fonts;
        }


        public function add_js() {
            wp_enqueue_script( 'westio-elementor-frontend', get_theme_file_uri( '/assets/js/elementor-frontend' . WESTIO_SUFFIX . '.js' ), '', WESTIO_VERSION );
            wp_enqueue_script( 'westio-elementor-swiper-tabs-fix', get_theme_file_uri( '/assets/js/elementor-swiper-tabs-fix' . WESTIO_SUFFIX . '.js' ), '', WESTIO_VERSION );
        }

        public function add_style_editor() {
            wp_enqueue_style( 'westio-icon', get_template_directory_uri() . '/assets/css/icons.css', '', WESTIO_VERSION );
        }

        public function add_scripts_editor() {
            if ( Plugin::instance()->editor->is_edit_mode() ) {
                wp_enqueue_script( 'westio-elementor-nested-element', get_theme_file_uri( '/assets/js/elementor-nested-element.js' ), [ 'elementor-common' ], WESTIO_VERSION );
            }
        }

        public function add_scripts() {
            wp_enqueue_style( 'westio-elementor', get_template_directory_uri() . '/assets/css/elementor.css', '', WESTIO_VERSION );
            wp_style_add_data( 'westio-elementor', 'rtl', 'replace' );

            // Add Scripts
            wp_register_script( 'tweenmax', get_theme_file_uri( '/assets/js/libs/TweenMax.min.js' ), array( 'jquery' ), '1.11.1' );
            wp_register_script( 'multi-parallax', get_theme_file_uri( '/assets/js/frontend/multi-parallax' . WESTIO_SUFFIX . '.js' ), array( 'jquery' ), WESTIO_VERSION );
            if ( westio_elementor_check_type( 'animated-bg-parallax' ) ) {
                wp_enqueue_script( 'tweenmax' );
                wp_enqueue_script( 'jquery-panr', get_theme_file_uri( '/assets/js/libs/jquery-panr' . WESTIO_SUFFIX . '.js' ), array( 'jquery' ), '0.0.1' );
            }
        }


        public function register_auto_scripts_swiper() {
            wp_register_script( 'westio-elementor-swiper', get_theme_file_uri( '/assets/js/elementor-swiper' . WESTIO_SUFFIX . '.js' ), array(
                'jquery',
                'elementor-frontend'
            ), WESTIO_VERSION, true );
            // Register auto scripts frontend
        }

        public function register_auto_scripts_frontend() {
        // JS registration code
wp_register_script('westio-elementor-availability', get_theme_file_uri('/assets/js/elementor/availability' . WESTIO_SUFFIX . '.js'), array('jquery','elementor-frontend'), WESTIO_VERSION, true);
wp_register_script('westio-elementor-button-popup', get_theme_file_uri('/assets/js/elementor/button-popup' . WESTIO_SUFFIX . '.js'), array('jquery','elementor-frontend'), WESTIO_VERSION, true);
wp_register_script('westio-elementor-image-carousel', get_theme_file_uri('/assets/js/elementor/image-carousel' . WESTIO_SUFFIX . '.js'), array('jquery','elementor-frontend'), WESTIO_VERSION, true);
wp_register_script('westio-elementor-image-gallery', get_theme_file_uri('/assets/js/elementor/image-gallery' . WESTIO_SUFFIX . '.js'), array('jquery','elementor-frontend'), WESTIO_VERSION, true);
wp_register_script('westio-elementor-image-switcher', get_theme_file_uri('/assets/js/elementor/image-switcher' . WESTIO_SUFFIX . '.js'), array('jquery','elementor-frontend'), WESTIO_VERSION, true);
wp_register_script('westio-elementor-landing-scroll', get_theme_file_uri('/assets/js/elementor/landing-scroll' . WESTIO_SUFFIX . '.js'), array('jquery','elementor-frontend'), WESTIO_VERSION, true);
wp_register_script('westio-elementor-neighborhood', get_theme_file_uri('/assets/js/elementor/neighborhood' . WESTIO_SUFFIX . '.js'), array('jquery','elementor-frontend'), WESTIO_VERSION, true);
wp_register_script('westio-elementor-nested-slides', get_theme_file_uri('/assets/js/elementor/nested-slides' . WESTIO_SUFFIX . '.js'), array('jquery','elementor-frontend'), WESTIO_VERSION, true);
wp_register_script('westio-elementor-posts-grid', get_theme_file_uri('/assets/js/elementor/posts-grid' . WESTIO_SUFFIX . '.js'), array('jquery','elementor-frontend'), WESTIO_VERSION, true);
wp_register_script('westio-elementor-room-space', get_theme_file_uri('/assets/js/elementor/room-space' . WESTIO_SUFFIX . '.js'), array('jquery','elementor-frontend'), WESTIO_VERSION, true);
wp_register_script('westio-elementor-slide-overlay', get_theme_file_uri('/assets/js/elementor/slide-overlay' . WESTIO_SUFFIX . '.js'), array('jquery','elementor-frontend'), WESTIO_VERSION, true);
wp_register_script('westio-elementor-team-box', get_theme_file_uri('/assets/js/elementor/team-box' . WESTIO_SUFFIX . '.js'), array('jquery','elementor-frontend'), WESTIO_VERSION, true);
wp_register_script('westio-elementor-testimonial', get_theme_file_uri('/assets/js/elementor/testimonial' . WESTIO_SUFFIX . '.js'), array('jquery','elementor-frontend'), WESTIO_VERSION, true);
wp_register_script('westio-elementor-work-process', get_theme_file_uri('/assets/js/elementor/work-process' . WESTIO_SUFFIX . '.js'), array('jquery','elementor-frontend'), WESTIO_VERSION, true);
           
    }

        public function create_custom_category( $elements_manager ) {
            $elements_manager->add_category(
                'westio-addons',
                array(
                    'title' => esc_html__( 'Westio Addons', 'westio' ),
                    'icon'  => 'fa fa-plug',
                )
            );
        }

        public function get_animations_scroll() {
            $animations = [
                'pavo-move-up'    => 'Move Up',
                'pavo-move-down'  => 'Move Down',
                'pavo-move-left'  => 'Move Left',
                'pavo-move-right' => 'Move Right',
                'pavo-flip'       => 'Flip',
                'pavo-helix'      => 'Helix',
                'pavo-scale-up'   => 'Scale',
                'pavo-am-popup'   => 'Popup',
            ];

            return $animations;
        }

        public function add_animations_scroll( $animations ) {
            $animations['Westio Animation'] = $this->get_animations_scroll();

            return $animations;
        }

        public function add_animations_scroll_style() {
            $animations = $this->get_animations_scroll();
            foreach ( $animations as $animation => $name ) {
                wp_deregister_style( 'e-animation-' . $animation );
                wp_register_style( 'e-animation-' . $animation, get_theme_file_uri( '/assets/css/animations/' . $animation . '.css' ), [], WESTIO_SUFFIX );
            }
        }

        /**
         * @param $widgets_manager Elementor\Widgets_Manager
         */
        public function include_widgets( $widgets_manager ) {
            require_once get_theme_file_path( '/inc/elementor/trait/carousel-trait.php' );
            require_once get_theme_file_path( '/inc/elementor/base/widget-base.php' );
            require_once get_theme_file_path( '/inc/elementor/base/widget-nested-base.php' );

            $files_custom = glob( get_theme_file_path( '/inc/elementor/custom-widgets/*.php' ) );
            foreach ( $files_custom as $file ) {
                if ( file_exists( $file ) ) {
                    require_once $file;
                }
            }

            $files = glob( get_theme_file_path( '/inc/elementor/widgets/*.php' ) );
            foreach ( $files as $file ) {
                if ( file_exists( $file ) ) {
                    require_once $file;

                }
            }
        }

        public function add_icons( $manager ) {
            $new_icons = json_decode( '{"westio-icon-call":"call","westio-icon-check1":"check1","westio-icon-link":"link","westio-icon-mail":"mail","westio-icon-menu":"menu","westio-icon-message":"message","westio-icon-phone-call":"phone-call","westio-icon-360":"360","westio-icon-add-line":"add-line","westio-icon-add-to-cart":"add-to-cart","westio-icon-angle-double-down":"angle-double-down","westio-icon-angle-double-left":"angle-double-left","westio-icon-angle-double-right":"angle-double-right","westio-icon-angle-double-up":"angle-double-up","westio-icon-angle-down":"angle-down","westio-icon-angle-left":"angle-left","westio-icon-angle-right":"angle-right","westio-icon-angle-up":"angle-up","westio-icon-arrow-alt-circle-down":"arrow-alt-circle-down","westio-icon-arrow-alt-circle-left":"arrow-alt-circle-left","westio-icon-arrow-alt-circle-right":"arrow-alt-circle-right","westio-icon-arrow-alt-circle-up":"arrow-alt-circle-up","westio-icon-arrow-alt-down":"arrow-alt-down","westio-icon-arrow-alt-from-bottom":"arrow-alt-from-bottom","westio-icon-arrow-alt-from-left":"arrow-alt-from-left","westio-icon-arrow-alt-from-right":"arrow-alt-from-right","westio-icon-arrow-alt-from-top":"arrow-alt-from-top","westio-icon-arrow-alt-left":"arrow-alt-left","westio-icon-arrow-alt-right":"arrow-alt-right","westio-icon-arrow-alt-square-down":"arrow-alt-square-down","westio-icon-arrow-alt-square-left":"arrow-alt-square-left","westio-icon-arrow-alt-square-right":"arrow-alt-square-right","westio-icon-arrow-alt-square-up":"arrow-alt-square-up","westio-icon-arrow-alt-to-bottom":"arrow-alt-to-bottom","westio-icon-arrow-alt-to-left":"arrow-alt-to-left","westio-icon-arrow-alt-to-right":"arrow-alt-to-right","westio-icon-arrow-alt-to-top":"arrow-alt-to-top","westio-icon-arrow-alt-up":"arrow-alt-up","westio-icon-arrow-circle-down":"arrow-circle-down","westio-icon-arrow-circle-left":"arrow-circle-left","westio-icon-arrow-circle-right":"arrow-circle-right","westio-icon-arrow-circle-up":"arrow-circle-up","westio-icon-arrow-down":"arrow-down","westio-icon-arrow-dropdown":"arrow-dropdown","westio-icon-arrow-from-bottom":"arrow-from-bottom","westio-icon-arrow-from-left":"arrow-from-left","westio-icon-arrow-from-right":"arrow-from-right","westio-icon-arrow-from-top":"arrow-from-top","westio-icon-arrow-left":"arrow-left","westio-icon-arrow-right":"arrow-right","westio-icon-arrow-square-down":"arrow-square-down","westio-icon-arrow-square-left":"arrow-square-left","westio-icon-arrow-square-right":"arrow-square-right","westio-icon-arrow-square-up":"arrow-square-up","westio-icon-arrow-to-bottom":"arrow-to-bottom","westio-icon-arrow-to-left":"arrow-to-left","westio-icon-arrow-to-right":"arrow-to-right","westio-icon-arrow-to-top":"arrow-to-top","westio-icon-arrow-up":"arrow-up","westio-icon-arrows-alt-h":"arrows-alt-h","westio-icon-arrows-alt-v":"arrows-alt-v","westio-icon-arrows-alt":"arrows-alt","westio-icon-arrows-h":"arrows-h","westio-icon-arrows-v":"arrows-v","westio-icon-arrows":"arrows","westio-icon-calendar":"calendar","westio-icon-call-calling":"call-calling","westio-icon-call-history":"call-history","westio-icon-caret-circle-down":"caret-circle-down","westio-icon-caret-circle-left":"caret-circle-left","westio-icon-caret-circle-right":"caret-circle-right","westio-icon-caret-circle-up":"caret-circle-up","westio-icon-caret-down":"caret-down","westio-icon-caret-left":"caret-left","westio-icon-caret-right":"caret-right","westio-icon-caret-square-down":"caret-square-down","westio-icon-caret-square-left":"caret-square-left","westio-icon-caret-square-right":"caret-square-right","westio-icon-caret-square-up":"caret-square-up","westio-icon-caret-up":"caret-up","westio-icon-cart-arrow-down":"cart-arrow-down","westio-icon-cart-empty":"cart-empty","westio-icon-cart-s":"cart-s","westio-icon-chat":"chat","westio-icon-check-circle":"check-circle","westio-icon-check-double":"check-double","westio-icon-check-fill":"check-fill","westio-icon-check-s":"check-s","westio-icon-check-square":"check-square","westio-icon-check":"check","westio-icon-checkbox-circle-fill":"checkbox-circle-fill","westio-icon-chevron-circle-down":"chevron-circle-down","westio-icon-chevron-circle-left":"chevron-circle-left","westio-icon-chevron-circle-right":"chevron-circle-right","westio-icon-chevron-circle-up":"chevron-circle-up","westio-icon-chevron-double-down":"chevron-double-down","westio-icon-chevron-double-left":"chevron-double-left","westio-icon-chevron-double-right":"chevron-double-right","westio-icon-chevron-double-up":"chevron-double-up","westio-icon-chevron-down":"chevron-down","westio-icon-chevron-left":"chevron-left","westio-icon-chevron-right":"chevron-right","westio-icon-chevron-square-down":"chevron-square-down","westio-icon-chevron-square-left":"chevron-square-left","westio-icon-chevron-square-right":"chevron-square-right","westio-icon-chevron-square-up":"chevron-square-up","westio-icon-chevron-up":"chevron-up","westio-icon-close":"close","westio-icon-cloud-download-alt":"cloud-download-alt","westio-icon-comment-info":"comment-info","westio-icon-comments-alt":"comments-alt","westio-icon-compare":"compare","westio-icon-compress-arrows-alt":"compress-arrows-alt","westio-icon-credit-card":"credit-card","westio-icon-dot-circle":"dot-circle","westio-icon-dot":"dot","westio-icon-dotfour":"dotfour","westio-icon-down-filled-arrow":"down-filled-arrow","westio-icon-edit":"edit","westio-icon-envelope":"envelope","westio-icon-equalizer-line":"equalizer-line","westio-icon-expand-arrows-alt":"expand-arrows-alt","westio-icon-expand-arrows":"expand-arrows","westio-icon-eye-dropper":"eye-dropper","westio-icon-eye-slash":"eye-slash","westio-icon-eye":"eye","westio-icon-facebook-cicrle":"facebook-cicrle","westio-icon-facebook":"facebook","westio-icon-file-alt":"file-alt","westio-icon-file-archive":"file-archive","westio-icon-filter":"filter","westio-icon-frown-open":"frown-open","westio-icon-frown":"frown","westio-icon-gift-card":"gift-card","westio-icon-gift":"gift","westio-icon-gifts":"gifts","westio-icon-globe":"globe","westio-icon-heart":"heart","westio-icon-home":"home","westio-icon-info-circle":"info-circle","westio-icon-instagram":"instagram","westio-icon-layout-grid":"layout-grid","westio-icon-layout-list":"layout-list","westio-icon-linkedin":"linkedin","westio-icon-liquid":"liquid","westio-icon-location-arrow":"location-arrow","westio-icon-location":"location","westio-icon-long-arrow-alt-down":"long-arrow-alt-down","westio-icon-long-arrow-alt-left":"long-arrow-alt-left","westio-icon-long-arrow-alt-right":"long-arrow-alt-right","westio-icon-long-arrow-alt-up":"long-arrow-alt-up","westio-icon-long-arrow-down":"long-arrow-down","westio-icon-long-arrow-left":"long-arrow-left","westio-icon-long-arrow-right-up":"long-arrow-right-up","westio-icon-long-arrow-right":"long-arrow-right","westio-icon-long-arrow-up":"long-arrow-up","westio-icon-mail-send-line":"mail-send-line","westio-icon-map-marker-alt":"map-marker-alt","westio-icon-map-marker-check":"map-marker-check","westio-icon-map-marker-times":"map-marker-times","westio-icon-map-marker":"map-marker","westio-icon-meh-blank":"meh-blank","westio-icon-meh-rolling-eyes":"meh-rolling-eyes","westio-icon-meh":"meh","westio-icon-minus-circle":"minus-circle","westio-icon-minus":"minus","westio-icon-mobile":"mobile","westio-icon-money-check-alt":"money-check-alt","westio-icon-overlap":"overlap","westio-icon-paper-plane":"paper-plane","westio-icon-pen-tool":"pen-tool","westio-icon-pen":"pen","westio-icon-phone":"phone","westio-icon-pin":"pin","westio-icon-plane-arrival":"plane-arrival","westio-icon-plane":"plane","westio-icon-play-circle":"play-circle","westio-icon-play":"play","westio-icon-plus-circle":"plus-circle","westio-icon-plus":"plus","westio-icon-question":"question","westio-icon-quickview":"quickview","westio-icon-quotation":"quotation","westio-icon-quotes":"quotes","westio-icon-rating-start":"rating-start","westio-icon-repeat":"repeat","westio-icon-reply-line":"reply-line","westio-icon-reply":"reply","westio-icon-search-plus":"search-plus","westio-icon-search":"search","westio-icon-share-all":"share-all","westio-icon-share":"share","westio-icon-shopping-bag":"shopping-bag","westio-icon-shopping-basket":"shopping-basket","westio-icon-shopping-cart":"shopping-cart","westio-icon-sign-out-alt":"sign-out-alt","westio-icon-smile":"smile","westio-icon-sp-cart":"sp-cart","westio-icon-spinner-third":"spinner-third","westio-icon-spinner":"spinner","westio-icon-square-fill":"square-fill","westio-icon-square-full":"square-full","westio-icon-star-exclamation":"star-exclamation","westio-icon-star-half-alt":"star-half-alt","westio-icon-star-half":"star-half","westio-icon-star-o":"star-o","westio-icon-star":"star","westio-icon-stars":"stars","westio-icon-sub-line":"sub-line","westio-icon-sync-alt":"sync-alt","westio-icon-sync":"sync","westio-icon-th-list":"th-list","westio-icon-time-line":"time-line","westio-icon-times-circle":"times-circle","westio-icon-times":"times","westio-icon-twitter":"twitter","westio-icon-unlock-alt":"unlock-alt","westio-icon-unlock":"unlock","westio-icon-user-circle":"user-circle","westio-icon-user":"user","westio-icon-video":"video","westio-icon-wishlist":"wishlist","westio-icon-world":"world","westio-icon-youtube-alt":"youtube-alt","westio-icon-youtube":"youtube","westio-icon-zoom-in":"zoom-in"}', true );
			$icons     = $manager->get_control( 'icon' )->get_settings( 'options' );
			$new_icons = array_merge(
				$new_icons,
				$icons
			);
			// Then we set a new list of icons as the options of the icon control
			$manager->get_control( 'icon' )->set_settings( 'options', $new_icons ); 
        }

        public function add_icons_native( $tabs ) {
            $tabs['pavo-custom'] = [
                'name'          => 'westio-icon',
                'label'         => esc_html__( 'Westio Icon', 'westio' ),
                'prefix'        => 'westio-icon-',
                'displayPrefix' => 'westio-icon-',
                'labelIcon'     => 'fab fa-font-awesome-alt',
                'ver'           => WESTIO_VERSION,
                'fetchJson'     => get_theme_file_uri( '/inc/elementor/icons.json' ),
                'native'        => true,
            ];

            return $tabs;
        }
    }

endif;

return new Westio_Elementor();

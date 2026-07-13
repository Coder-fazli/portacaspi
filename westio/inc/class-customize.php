<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists( 'Westio_Customize' ) ) {

    class Westio_Customize {


        public function __construct() {
            add_action( 'customize_register', array( $this, 'customize_register' ) );
        }

        public function customize_register( $wp_customize ) {
            /**
             * Theme options.
             */
            $this->init_westio_blog( $wp_customize );
            $this->westio_register_theme_customizer( $wp_customize );

            do_action( 'westio_customize_register', $wp_customize );
        }

        function westio_register_theme_customizer( $wp_customize ) {
            $wp_customize->add_setting(
                'page_for_404',
                array(
                    'type'              => 'option',
                    'capability'        => 'manage_options',
                    'sanitize_callback' => 'absint', // Ensure it's a valid integer
                )
            );

            $wp_customize->add_control(
                'page_for_404',
                array(
                    'label'          => esc_html__( '404 page', 'westio' ),
                    'section'        => 'static_front_page',
                    'type'           => 'dropdown-pages',
                    'allow_addition' => true,
                )
            );
        } // end westio_register_theme_customizer

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_westio_blog( $wp_customize ) {
            // =========================================
            // Blog Archive
            // =========================================
            $wp_customize->add_section( 'westio_blog', array(
                'title'      => esc_html__( 'Blog', 'westio' ),
                'capability' => 'edit_theme_options',
            ) );

            $wp_customize->add_setting( 'westio_options_blog_sidebar', array(
                'type'              => 'option',
                'default'           => 'right',
                'sanitize_callback' => 'sanitize_text_field',
            ) );

            $wp_customize->add_control( 'westio_options_blog_sidebar', array(
                'section' => 'westio_blog',
                'label'   => esc_html__( 'Sidebar Archive', 'westio' ),
                'type'    => 'select',
                'choices' => array(
                    'none'  => esc_html__( 'None', 'westio' ),
                    'left'  => esc_html__( 'Left', 'westio' ),
                    'right' => esc_html__( 'Right', 'westio' ),
                ),
            ) );

            // =========================================
            // Blog Single
            // =========================================

            $wp_customize->add_setting( 'westio_options_blog_single_sidebar', array(
                'type'              => 'option',
                'default'           => 'right',
                'sanitize_callback' => 'sanitize_text_field',
            ) );

            $wp_customize->add_control( 'westio_options_blog_single_sidebar', array(
                'section' => 'westio_blog',
                'label'   => esc_html__( 'Sidebar Single', 'westio' ),
                'type'    => 'select',
                'choices' => array(
                    'none'  => esc_html__( 'None', 'westio' ),
                    'left'  => esc_html__( 'Left', 'westio' ),
                    'right' => esc_html__( 'Right', 'westio' ),
                ),
            ) );
        }
    }
}

return new Westio_Customize();

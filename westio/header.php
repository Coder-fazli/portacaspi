<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <link rel="profile" href="//gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <?php do_action( 'wp_body_open' ); ?>

        <div id="page" class="hfeed site">
            <?php
            if (class_exists('ETB_Elementor')  && (etb_header_enabled() || etb_after_header_enabled()) ) {
                do_action('etb_header');

            } else {
                get_template_part('template-parts/header');
            }
            ?>

            <?php


            /**
             * Functions hooked in to westio_before_content action
             *
             */
            do_action('westio_before_content');
            ?>
            <div id="content" class="site-content" tabindex="-1">
                <div class="col-full">

            <?php
            /**
             * Functions hooked in to westio_content_top action
             *
             * @see westio_shop_messages - 10 - woo
             *
             */
            do_action('westio_content_top');


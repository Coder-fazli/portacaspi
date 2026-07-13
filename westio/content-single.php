<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="single-content">
        <?php
        if (class_exists('ETB_Elementor') && (etb_single_enabled())) {
            do_action('etb_single');
        } else {

            /**
             * Functions hooked in to westio_single_post_top action
             *
             */
            do_action('westio_single_post_top');

            /**
             * Functions hooked in to westio_single_post action
             * @see westio_post_header         - 5
             * @see westio_post_thumbnail      - 10
             * @see westio_post_wrapper_start  - 20
             * @see westio_post_content        - 30
             */
            do_action('westio_single_post');

            /**
             * Functions hooked in to westio_single_post_bottom action
             *
             * @see westio_post_taxonomy                 - 10
             * @see westio_post_nav                      - 15
             * @see westio_display_comments              - 20
             * @see westio_post_wrapper_end              - 30
             *
             */
            do_action('westio_single_post_bottom');
        }
        ?>

    </div>
</article><!-- #post-## -->

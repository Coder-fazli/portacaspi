<?php
get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php if (have_posts()) : ?>

                <header class="page-header">
                    <?php
                    the_archive_description('<div class="taxonomy-description">', '</div>');
                    ?>
                </header><!-- .page-header -->
                <?php

                if (class_exists('ETB_Elementor') && (etb_archive_enabled())) {

                    do_action('etb_archive');
                } else {
                    get_template_part('loop');

                }

            else :
                get_template_part('content', 'none');
            endif;
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php

do_action('westio_sidebar');

get_footer();

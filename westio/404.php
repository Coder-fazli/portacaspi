<?php
get_header(); ?>
    <div id="primary" class="content">
        <main id="main" class="site-main">
            <?php
            $errorpage_id = get_option('page_for_404');
            if ($errorpage_id) :
                $query = new WP_Query(array('page_id' => $errorpage_id));
                while ($query->have_posts()) {
                    $query->the_post();
                    get_template_part('content', 'page');
                }
                wp_reset_postdata();
            else:?>
                <div class="error-404 not-found">
                    <div class="page-content">

                        <h2 class="error-title">
                            <?php printf('%s', esc_html__('404', 'westio')); ?>
                        </h2>

                        <h3 class="error-sub-title">
                            <?php printf('%s', esc_html__('Opps! That Links Is Broken.', 'westio')); ?>
                        </h3>

                        <p class="error-content">
                            <?php esc_html_e("Page does not exist or some other error occured. Go to our Home Page", 'westio'); ?>
                        </p>

                        <div class="button-wrapper">
                            <a class="elementor-button elementor-size-md" href="<?php echo esc_url(home_url('/')); ?>">
                                <div class="elementor-button-content-wrapper">
                                    <span class="elementor-button-text"><?php esc_html_e('Back to home', 'westio') ?></span>
                                </div>
                            </a>
                        </div>

                    </div><!-- .page-content -->
                </div><!-- .error-404 -->
            <?php endif; ?>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php
get_footer();
<?php
/**
 * The loop template file.
 *
 * Included on pages like index.php, archive.php and search.php to display a loop of posts
 * Learn more: https://codex.wordpress.org/The_Loop
 *
 * @package westio
 */

do_action('westio_loop_before');

$class = apply_filters('westio_loop_blog', array());
$class = esc_attr(implode(' ', array_unique($class)));
?>

    <div class="<?php echo esc_attr($class) ?>">
        <div class="elementor-grid">
            <?php
            $count = 0;
            while (have_posts()) :
                the_post();
                /**
                 * Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 */
                get_template_part('content', get_post_format());

                $count++;
            endwhile; ?>
        </div>
    </div>
<?php

/**
 * Functions hooked in to westio_loop_after action
 *
 * @see westio_paging_nav - 10
 */
do_action('westio_loop_after');
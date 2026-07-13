<?php

class Westio_WP_Widget_Recent_Posts extends WP_Widget_Recent_Posts {
    public function widget($args, $instance) {
        if (!isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }

        $title = (!empty($instance['title'])) ? $instance['title'] : esc_html__('Recent Posts', 'westio');

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);

        $number = (!empty($instance['number'])) ? absint($instance['number']) : 5;
        if (!$number) {
            $number = 5;
        }
        $show_date = isset($instance['show_date']) ? $instance['show_date'] : false;

        /**
         * Filters the arguments for the Recent Posts widget.
         *
         * @param array $args An array of arguments used to retrieve the recent posts.
         * @param array $instance Array of settings for the current widget.
         * @see WP_Query::get_posts()
         *
         * @since 3.4.0
         * @since 4.9.0 Added the `$instance` parameter.
         *
         */
        $r = new WP_Query(
            apply_filters(
                'widget_posts_args',
                array(
                    'posts_per_page'      => $number,
                    'no_found_rows'       => true,
                    'post_status'         => 'publish',
                    'ignore_sticky_posts' => true,
                ),
                $instance
            )
        );

        if (!$r->have_posts()) {
            return;
        }
        ?>
        <?php echo sprintf('%s', $args['before_widget']); ?>
        <?php
        if ($title) {
            echo sprintf('%s', $args['before_title'] . $title . $args['after_title']);
        }
        ?>
        <ul class="recent-posts">
            <?php foreach ($r->posts as $recent_post) : ?>
                <?php
                $post_title = get_the_title($recent_post->ID);
                $title      = (!empty($post_title)) ? $post_title : esc_html__('(no title)', 'westio');

                ?>
                <li>
                    <div class="recent-posts-thumbnail">
                        <a href="<?php the_permalink($recent_post->ID); ?>">
                            <?php echo get_the_post_thumbnail($recent_post->ID, 'thumbnail') ?>
                        </a>
                    </div>
                    <div class="recent-posts-info">
                        <h4 class="entry-title">
                            <a href="<?php the_permalink($recent_post->ID); ?>"<?php if (get_queried_object_id() === $recent_post->ID) {
                                echo ' aria-current="page"';
                            } ?>><?php echo sprintf('%s', $title); ?></a>
                        </h4>

                        <?php if ($show_date) : ?>
                            <div class="post-meta-group">
                                <div class="posted-on">
                                    <?php echo sprintf('<a href="%1$s" rel="bookmark">%2$s</a>', esc_url(get_permalink()), get_the_date('j M, Y', $recent_post->ID)) ?>
                                </div>
                                <span class="meta-separator"></span>
                                <?php
                                    $author_id = $recent_post->post_author;
                                    echo sprintf(
                                        '<div class="post-author"><span>'.esc_html__('By', 'westio').' <a href="%1$s" class="url fn" rel="author">%2$s</a></span></div>',
                                        esc_url( get_author_posts_url( $author_id ) ),
                                        esc_html( get_the_author_meta( 'display_name', $author_id ) )
                                    );
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>

                </li>
            <?php endforeach; ?>
        </ul>
        <?php
        echo sprintf('%s', $args['after_widget']); // WPCS: XSS ok.
    }
}

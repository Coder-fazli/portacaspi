<article <?php post_class('post-style-grid', get_the_ID()); ?>>
    <div class="post-inner">
        <div class="post-image">

            <div class="entry-meta">
                <?php westio_post_meta(['show_cat' => true, 'show_author' => false, 'show_date' => false, 'show_comment' => false]); ?>
            </div>

            <?php if (has_post_thumbnail()) : ?>
                <?php
                $image_size = isset($settings['post_image_size']) ? $settings['post_image_size'] : 'post-medium-portrait';

                if ($image_size === 'custom') {
                    $custom_size = isset($settings['post_image_custom_dimension']) && is_array($settings['post_image_custom_dimension'])
                        ? $settings['post_image_custom_dimension']
                        : ['width' => 300, 'height' => 300];

                    $width      = !empty($custom_size['width']) ? $custom_size['width'] : 300;
                    $height     = !empty($custom_size['height']) ? $custom_size['height'] : 300;
                    $image_size = [$width, $height];
                }

                westio_post_thumbnail($image_size);
                ?>
            <?php endif; ?>
        </div>

        <div class="post-content">

            <h3 class="entry-title">
                <a href="<?php echo esc_url(get_permalink()) ?>" rel="bookmark"><?php echo wp_trim_words(get_the_title(), 8) ?></a>
            </h3>

            <?php westio_post_meta(['show_cat' => false, 'show_author' => true, 'show_date' => true, 'show_comment' => false]); ?>
        </div>
    </div>
</article>
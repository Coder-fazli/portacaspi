<article <?php post_class('post-style-special', get_the_ID()); ?>>
    <div class="post-inner">
        <div class="entry-meta">
            <?php westio_post_meta(['show_cat' => true, 'show_author' => false, 'show_date' => false, 'show_comment' => false]); ?>
        </div>

        <div class="post-content">

            <h3 class="entry-title">
                <a href="<?php echo esc_url(get_permalink()) ?>" rel="bookmark"><?php echo wp_trim_words(get_the_title(), 8) ?></a>
            </h3>

            <?php westio_post_meta(['show_cat' => false, 'show_author' => true, 'show_date' => true, 'show_comment' => false]); ?>
        </div>
    </div>
</article>
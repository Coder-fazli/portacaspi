<?php if ((bool)get_the_author_meta('description')) : ?>
    <div class="author-wrapper">
        <div class="author-avatar">
            <img src="<?php echo esc_url(get_avatar_url(get_the_author_meta('ID'))); ?>"/>
        </div>
        <div class="author-caption">
            <?php
            // Get the author's website URL
            $author_website = get_the_author_meta('user_url');

            // Display the author's name and website URL
            printf(
                '<div class="author-name"><a class="author-link" href="%s" rel="author">%s</a></div>',
                esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                get_the_author()
            );

            // Display the author's website URL
            if ($author_website) {
                printf(
                    '<div class="author-website"><a href="%s">%s</a></div>',
                    esc_url($author_website),
                    esc_html($author_website)
                );
            }
            ?>
            <p class="author-description">
                <?php the_author_meta('description'); ?>
            </p>
        </div>
    </div>
<?php endif; ?>

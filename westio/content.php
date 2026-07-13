<article <?php post_class('article-default', get_the_ID()); ?>>
    <div class="post-inner">
        <div class="post-image">
            <?php westio_post_thumbnail('post-thumbnail'); ?>
        </div>
        <div class="post-content">
            <?php
            /**
             * Functions hooked in to westio_loop_post action.
             *
             * @see westio_post_loop          - 15
             */
            do_action('westio_loop_post');
            ?>
        </div>
    </div>
</article><!-- #post-## -->

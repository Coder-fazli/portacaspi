<?php
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<section id="comments" class="comments-area" aria-label="<?php esc_attr_e('Post Comments', 'westio'); ?>">
    <?php
    if (have_comments()) :
        ?>
        <div class="comment-list-wrap">
            <h2 class="comments-title">
				<?php
                printf( // WPCS: XSS OK.
                /* translators: 1: number of comments, 2: post title */
                    esc_html(_nx('Comment (%1$s)', 'Comments (%1$s)', get_comments_number(), 'comments title', 'westio')),
                    sprintf('%02d', get_comments_number())
                );
                ?>
            </h2>
            <?php
            if (get_option('page_comments')) {
                ?>
                <div class="comment-result">
                    <?php
                    $total    = get_comments_number();
                    $per_page = get_query_var('comments_per_page');
                    $current  = get_query_var('cpage');
                    if (1 === intval($total)) {
                        esc_html_e('Showing the single comment', 'westio');
                    } elseif ($total <= $per_page || -1 === $per_page) {
                        /* translators: %d: total results */
                        printf(_n('Showing all %d comment', 'Showing all %d comments', $total, 'westio'), $total);
                    } else {
                        $first = ($per_page * $current) - $per_page + 1;
                        $last  = min($total, $per_page * $current);
                        /* translators: 1: first result 2: last result 3: total results */
                        printf(_nx('Showing %1$d &ndash; %2$d of %3$d comment', 'Showing %1$d&ndash;%2$d of %3$d comments', $total, 'with first and last result', 'westio'), $first, $last, $total);
                    }
                    ?>
                </div>
                <?php
            }
            ?>

            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through. ?>
                <nav id="comment-nav-above" class="comment-navigation" role="navigation" aria-label="<?php esc_attr_e('Comment Navigation Above', 'westio'); ?>">
                    <span class="screen-reader-text"><?php esc_html_e('Comment navigation', 'westio'); ?></span>
                    <div class="nav-previous"><?php previous_comments_link('<i class="westio-icon-arrow-left"></i><span>' . esc_html__('Older Comments', 'westio') . '</span>'); ?></div>
                    <div class="nav-next"><?php next_comments_link('<span>' . esc_html__('Newer Comments', 'westio') . '</span><i class="westio-icon-arrow-right"></i>'); ?></div>
                </nav><!-- #comment-nav-above -->
            <?php endif; // Check for comment navigation.
            ?>

            <ol class="comment-list">
                <?php
                wp_list_comments(
                    array(
                        'style'      => 'ol',
                        'short_ping' => true,
                        'callback'   => 'westio_comment',
                    )
                );
                ?>
            </ol><!-- .comment-list -->

            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through. ?>
                <nav id="comment-nav-below" class="comment-navigation" role="navigation" aria-label="<?php esc_attr_e('Comment Navigation Below', 'westio'); ?>">
                    <span class="screen-reader-text"><?php esc_html_e('Comment navigation', 'westio'); ?></span>
                    <div class="nav-previous"><?php previous_comments_link('<i class="westio-icon-arrow-left"></i><span>' . esc_html__('Older Comments', 'westio') . '</span>'); ?></div>
                    <div class="nav-next"><?php next_comments_link('<span>' . esc_html__('Newer Comments', 'westio') . '</span><i class="westio-icon-arrow-right"></i>'); ?></div>
                </nav><!-- #comment-nav-below -->
            <?php endif; // Check for comment navigation.
            ?>
        </div>
    <?php

    endif;

    if (!comments_open() && 0 !== intval(get_comments_number()) && post_type_supports(get_post_type(), 'comments')) :
        ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'westio'); ?></p>
    <?php
    endif;
    $args = apply_filters(
        'westio_comment_form_args', array(
            'title_reply'        => __('Leave A Reply', 'westio'),
            'title_reply_before' => '<span id="reply-title" class="gamma comment-reply-title">',
            'title_reply_after'  => '</span>',
            'comment_field'      => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="3" maxlength="65525" required="required" placeholder="' . esc_attr__('Comments...', 'westio') . '"></textarea></p>',
            'submit_button'      => '<button type="submit" id="%2$s" class="%3$s elementor-button elementor-size-md" value="%4$s">
                                        <span class="elementor-button-content-wrapper">
                                            <span class="elementor-button-text">%4$s</span>
                                            <span class="elementor-button-icon"><i class="westio-icon-right-chevron"></i></span>
                                        </span>
                                     </button>',
            'submit_field'       => '<p class="form-submit button-wrapper elementor-button-default">%1$s %2$s</p>',
        )
    );
    comment_form($args);

    ?>

</section><!-- #comments -->


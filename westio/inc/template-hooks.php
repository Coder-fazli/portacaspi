<?php
/**
 * =================================================
 * Hook westio_page
 * =================================================
 */
add_action('westio_page', 'westio_page_header', 10);
add_action('westio_page', 'westio_page_content', 20);

/**
 * =================================================
 * Hook westio_single_post_top
 * =================================================
 */

/**
 * =================================================
 * Hook westio_single_post
 * =================================================
 */
add_action('westio_single_post', 'westio_post_header', 5);
add_action('westio_single_post', 'westio_post_thumbnail', 10);
add_action('westio_single_post', 'westio_post_wrapper_start', 20);
add_action('westio_single_post', 'westio_post_content', 30);

/**
 * =================================================
 * Hook westio_single_post_bottom
 * =================================================
 */
add_action('westio_single_post_bottom', 'westio_post_taxonomy', 10);
add_action('westio_single_post_bottom', 'westio_post_nav', 15);
add_action('westio_single_post_bottom', 'westio_display_comments', 20);
add_action('westio_single_post_bottom', 'westio_post_wrapper_end', 30);

/**
 * =================================================
 * Hook westio_loop_post
 * =================================================
 */
add_action('westio_loop_post', 'westio_post_loop', 15);

/**
 * =================================================
 * Hook westio_before_footer
 * =================================================
 */

/**
 * =================================================
 * Hook westio_after_footer
 * =================================================
 */

/**
 * =================================================
 * Hook wp_footer
 * =================================================
 */
add_action('wp_footer', 'westio_template_account_dropdown', 1);
add_action('wp_footer', 'westio_mobile_nav', 1);

/**
 * =================================================
 * Hook westio_before_content
 * =================================================
 */

/**
 * =================================================
 * Hook westio_content_top
 * =================================================
 */

/**
 * =================================================
 * Hook westio_loop_after
 * =================================================
 */
add_action('westio_loop_after', 'westio_paging_nav', 10);

/**
 * =================================================
 * Hook westio_post_content_before
 * =================================================
 */

/**
 * =================================================
 * Hook westio_post_content_after
 * =================================================
 */

/**
 * =================================================
 * Hook westio_sidebar
 * =================================================
 */
add_action('westio_sidebar', 'westio_get_sidebar', 10);

/**
 * =================================================
 * Hook westio_page_after
 * =================================================
 */
add_action('westio_page_after', 'westio_display_comments', 10);

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to westio_page action
	 *
	 * @see westio_page_header          - 10
	 * @see westio_page_content         - 20
	 *
	 */
	do_action( 'westio_page' );
	?>
</article><!-- #post-## -->

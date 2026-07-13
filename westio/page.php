<?php

get_header(); ?>

	<div id="primary">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) :
				the_post();

				do_action( 'westio_page_before' );

				get_template_part( 'content', 'page' );

				/**
				 * Functions hooked in to westio_page_after action
				 *
				 * @see westio_display_comments - 10
				 */
				do_action( 'westio_page_after' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'westio_sidebar' );
get_footer();

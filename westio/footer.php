</div><!-- .col-full -->
</div><!-- #content -->

<?php
/**
 * Functions hooked in to westio_before_footer action
 * @see westio_sticky_single_add_to_cart    - 999 - woo
 */
do_action('westio_before_footer');

if (class_exists('ETB_Elementor')  && (etb_footer_enabled() || etb_is_before_footer_enabled())) {
    do_action('etb_footer_before');
    do_action('etb_footer');
} else {
    get_template_part('template-parts/footer');
}

/**
 * Functions hooked in to westio_after_footer action
 * @see westio_sticky_single_add_to_cart    - 999 - woo
 */
do_action('westio_after_footer');
?>

</div><!-- #page -->

<?php

/**
 * Functions hooked in to wp_footer action
 * @see westio_template_account_dropdown    - 1
 * @see westio_mobile_nav - 1
 * @see westio_render_woocommerce_shop_canvas - 1 - woo
 */

wp_footer();
?>
</body>
</html>

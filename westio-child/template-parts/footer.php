<?php
/**
 * Custom footer (child theme override of template-parts/footer.php).
 * Recreates the Westio demo footer: a contained white rounded card floating
 * over a full-width parallax background image, with logo + address, three
 * "Explore" menu columns, watermark, copyright and social links.
 *
 * Editable via Appearance → Menus (footer columns) and Customizer → Footer.
 * If no menu is assigned to a column, the demo default links are shown.
 */

$wc_bg_image  = get_theme_mod('wc_footer_bg_image', '');
$wc_address   = get_theme_mod('wc_footer_address', "2972 Westheimer Rd.\nSanta Ana, Illinois 85486");
$wc_copyright = get_theme_mod('wc_footer_copyright', '© ' . date('Y') . ' Portacaspia');
$wc_watermark = get_theme_mod('wc_footer_watermark', get_bloginfo('name'));

$wc_socials = [
    'facebook'  => ['label' => 'Facebook',  'url' => get_theme_mod('wc_footer_facebook', '#')],
    'twitter'   => ['label' => 'Twitter',   'url' => get_theme_mod('wc_footer_twitter', '#')],
    'instagram' => ['label' => 'Instagram', 'url' => get_theme_mod('wc_footer_instagram', '#')],
    'youtube'   => ['label' => 'Youtube',   'url' => get_theme_mod('wc_footer_youtube', '')],
];

// Default "Explore" links shown when a column has no assigned menu.
$wc_default_cols = [
    'footer-1' => ['Architecture' => '#', 'Amenities' => '#', 'Residences' => '#'],
    'footer-2' => ['Neighborhood' => '#', 'Availability' => '#', 'Gallery' => '#'],
    'footer-3' => ['About Us' => '#', 'Blog' => '#', 'Contact' => '#'],
];

$wc_explore_label = function_exists('pll__') ? pll__('EXPLORE') : 'EXPLORE';
$wc_address_label = function_exists('pll__') ? pll__('ADDRESS') : 'ADDRESS';

$wc_footer_style = $wc_bg_image ? ' style="background-image:url(' . esc_url($wc_bg_image) . ');"' : '';
?>
<footer id="colophon" class="site-footer wc-footer<?php echo $wc_bg_image ? ' has-bg' : ''; ?>" role="contentinfo"<?php echo $wc_footer_style; ?>>
    <div class="wc-footer-card">

        <?php if (!empty($wc_watermark)) : ?>
            <div class="wc-footer-watermark" aria-hidden="true"><?php echo esc_html($wc_watermark); ?></div>
        <?php endif; ?>

        <div class="wc-footer-content">

            <div class="wc-footer-top">
                <div class="wc-footer-brand">
                    <?php
                    if (function_exists('the_custom_logo') && has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<a class="wc-footer-sitename" href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a>';
                    }
                    ?>
                </div>

                <div class="wc-footer-address">
                    <h4 class="wc-footer-heading"><?php echo esc_html($wc_address_label); ?></h4>
                    <p><?php echo nl2br(esc_html($wc_address)); ?></p>
                </div>

                <div class="wc-footer-explore">
                    <h4 class="wc-footer-heading"><?php echo esc_html($wc_explore_label); ?></h4>
                    <div class="wc-footer-menus">
                        <?php foreach ($wc_default_cols as $loc => $defaults) : ?>
                            <div class="wc-footer-menu-col">
                                <?php if (has_nav_menu($loc)) : ?>
                                    <?php
                                    wp_nav_menu([
                                        'theme_location' => $loc,
                                        'container'      => false,
                                        'menu_class'     => 'wc-footer-menu',
                                        'depth'          => 1,
                                        'fallback_cb'    => '__return_empty_string',
                                    ]);
                                    ?>
                                <?php else : ?>
                                    <ul class="wc-footer-menu">
                                        <?php foreach ($defaults as $label => $url) : ?>
                                            <li><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="wc-footer-bottom">
                <div class="wc-footer-copyright"><?php echo wp_kses_post($wc_copyright); ?></div>
                <div class="wc-footer-social">
                    <?php foreach ($wc_socials as $key => $s) : ?>
                        <?php if (!empty($s['url'])) : ?>
                            <a class="wc-social-link wc-social-<?php echo esc_attr($key); ?>" href="<?php echo esc_url($s['url']); ?>" target="_blank" rel="noopener"><?php echo esc_html(strtoupper($s['label'])); ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</footer><!-- #colophon -->

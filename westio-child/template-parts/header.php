<?php
/**
 * Custom header (child theme override of template-parts/header.php).
 *
 * Reuses the parent theme's structure and helpers so it inherits Westio's
 * styling, and adds a Polylang language switcher + phone + CTA on the right.
 * Menus assigned per language in Appearance → Menus swap automatically.
 */

$wc_phone     = function_exists('pll__') ? pll__(get_theme_mod('wc_header_phone', '+994 12 345 67 89')) : get_theme_mod('wc_header_phone', '+994 12 345 67 89');
$wc_cta_label = function_exists('pll__') ? pll__('Əlaqə') : 'Əlaqə';
$wc_cta_url   = function_exists('pll__') ? pll__('/elaqe/') : '/elaqe/';
?>
<header id="masthead" class="site-header header-1 wc-header" role="banner">
    <div class="header-container">
        <div class="header-main">
            <div class="header-left">
                <?php
                westio_site_branding();
                westio_mobile_nav_button();
                ?>
            </div>
            <div class="header-center">
                <?php westio_primary_navigation(); ?>
            </div>
            <div class="header-right desktop-hide-down">
                <div class="header-group-action wc-header-actions">

                    <?php if (function_exists('pll_the_languages')) : ?>
                        <nav class="wc-lang-switcher" aria-label="<?php esc_attr_e('Language', 'westio-child'); ?>">
                            <ul>
                                <?php pll_the_languages([
                                    'show_flags'       => 0,
                                    'display_names_as' => 'slug',
                                    'hide_if_empty'    => 0,
                                ]); ?>
                            </ul>
                        </nav>
                    <?php endif; ?>

                    <a class="wc-header-phone" href="tel:<?php echo esc_attr(preg_replace('/[^+\d]/', '', $wc_phone)); ?>">
                        <?php echo esc_html($wc_phone); ?>
                    </a>

                    <a class="wc-header-cta" href="<?php echo esc_url($wc_cta_url); ?>">
                        <?php echo esc_html($wc_cta_label); ?>
                    </a>

                </div>
            </div>
        </div>
    </div>
</header><!-- #masthead -->

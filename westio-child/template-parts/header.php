<?php
/**
 * Custom header (child theme override of template-parts/header.php).
 *
 * Reuses the parent theme's structure and helpers so it inherits Westio's
 * styling, and adds a Polylang language switcher + phone + CTA on the right.
 * Menus assigned per language in Appearance → Menus swap automatically.
 */

$wc_hd        = function_exists('wcf_get_lang_data') ? wcf_get_lang_data() : [];
$wc_phone     = $wc_hd['header_phone'] ?? '+994 12 345 67 89';
$wc_cta_label = $wc_hd['header_cta_label'] ?? 'Əlaqə';
$wc_cta_url   = $wc_hd['header_cta_url'] ?? '/elaqe/';
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

                    <?php if (function_exists('pll_the_languages') && function_exists('pll_current_language')) : ?>
                        <nav class="wc-lang-switcher" aria-label="<?php esc_attr_e('Language', 'westio-child'); ?>">
                            <button type="button" class="wc-lang-current" aria-haspopup="true" aria-expanded="false" aria-label="<?php esc_attr_e('Choose language', 'westio-child'); ?>">
                                <svg class="wc-lang-globe" aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M2 12h20M12 2c2.7 2.9 4 6.4 4 10s-1.3 7.1-4 10c-2.7-2.9-4-6.4-4-10s1.3-7.1 4-10z"/>
                                </svg>
                                <span class="wc-lang-arrow" aria-hidden="true"></span>
                            </button>
                            <ul class="wc-lang-dropdown">
                                <?php pll_the_languages([
                                    'show_flags'       => 0,
                                    'display_names_as' => 'slug',
                                    'hide_current'     => 1,
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

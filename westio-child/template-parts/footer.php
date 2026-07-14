<?php
/**
 * Custom footer (child theme override of template-parts/footer.php).
 * A contained white rounded card floating over a full-width parallax
 * background image. All text/links come from the Footer admin page
 * (per-language), via wcf_get_lang_data() / wcf_get_bg_image().
 */

$d        = function_exists('wcf_get_lang_data') ? wcf_get_lang_data() : [];
$bg_image = function_exists('wcf_get_bg_image') ? wcf_get_bg_image() : '';

$address_label = $d['address_label'] ?? 'ADDRESS';
$address_text  = $d['address_text'] ?? '';
$explore_label = $d['explore_label'] ?? 'EXPLORE';
$columns       = !empty($d['columns']) && is_array($d['columns']) ? $d['columns'] : [];
$copyright     = $d['copyright'] ?? '';
$socials       = !empty($d['socials']) && is_array($d['socials']) ? $d['socials'] : [];
$watermark     = get_bloginfo('name');

$footer_style = $bg_image ? ' style="background-image:url(' . esc_url($bg_image) . ');"' : '';
?>
<footer id="colophon" class="site-footer wc-footer<?php echo $bg_image ? ' has-bg' : ''; ?>" role="contentinfo"<?php echo $footer_style; ?>>
    <div class="wc-footer-card">

        <?php if (!empty($watermark)) : ?>
            <div class="wc-footer-watermark" aria-hidden="true"><?php echo esc_html($watermark); ?></div>
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
                    <?php if ($address_label) : ?>
                        <h4 class="wc-footer-heading"><?php echo esc_html($address_label); ?></h4>
                    <?php endif; ?>
                    <p><?php echo nl2br(esc_html($address_text)); ?></p>
                </div>

                <div class="wc-footer-explore">
                    <?php if ($explore_label) : ?>
                        <h4 class="wc-footer-heading"><?php echo esc_html($explore_label); ?></h4>
                    <?php endif; ?>
                    <div class="wc-footer-menus">
                        <?php foreach ($columns as $col) : ?>
                            <div class="wc-footer-menu-col">
                                <ul class="wc-footer-menu">
                                    <?php foreach ((array) $col as $item) : ?>
                                        <?php if (!empty($item['label'])) : ?>
                                            <li><a href="<?php echo esc_url($item['url'] ?: '#'); ?>"><?php echo esc_html($item['label']); ?></a></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="wc-footer-bottom">
                <div class="wc-footer-copyright"><?php echo wp_kses_post($copyright); ?></div>
                <div class="wc-footer-social">
                    <?php foreach ($socials as $s) : ?>
                        <?php if (!empty($s['label'])) : ?>
                            <a class="wc-social-link" href="<?php echo esc_url($s['url'] ?: '#'); ?>" target="_blank" rel="noopener"><?php echo esc_html(strtoupper($s['label'])); ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</footer><!-- #colophon -->

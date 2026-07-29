<?php
/**
 * Footer settings — admin page with per-language content (AZ/EN/RU tabs),
 * manual link repeaters, editable address / headings / copyright / socials,
 * and a shared parallax background image.
 *
 * Data is stored in the option WCF_OPTION as:
 *   [ 'bg_image' => url, 'langs' => [ slug => [ ...content... ] ] ]
 */

if (!defined('ABSPATH')) {
    exit;
}

define('WCF_OPTION', 'wc_footer_settings');

/* ---------------- Helpers ---------------- */

function wcf_languages() {
    $slugs = [];
    $names = [];
    if (function_exists('pll_languages_list')) {
        $slugs = pll_languages_list(['fields' => 'slug']);
        $names = pll_languages_list(['fields' => 'name']);
    }
    if (empty($slugs)) {
        $slugs = ['default'];
        $names = ['Default'];
    }
    return array_combine($slugs, $names);
}

function wcf_lang_defaults() {
    return [
        'header_phone'     => '+994 12 345 67 89',
        'header_cta_label' => 'Əlaqə',
        'header_cta_url'   => '/elaqe/',
        'address_label' => 'ADDRESS',
        'address_text'  => "2972 Westheimer Rd.\nSanta Ana, Illinois 85486",
        'explore_label' => 'EXPLORE',
        'columns'       => [
            [['label' => 'Architecture', 'url' => '#'], ['label' => 'Amenities', 'url' => '#'], ['label' => 'Residences', 'url' => '#']],
            [['label' => 'Neighborhood', 'url' => '#'], ['label' => 'Availability', 'url' => '#'], ['label' => 'Gallery', 'url' => '#']],
        ],
        'copyright'     => '© ' . date('Y') . ' Portacaspia',
        'socials'       => [
            ['label' => 'Facebook', 'url' => '#'],
            ['label' => 'Twitter', 'url' => '#'],
            ['label' => 'Instagram', 'url' => '#'],
        ],
    ];
}

/**
 * Returns the footer content for the current (or given) language,
 * falling back to the first configured language, then to defaults.
 */
function wcf_get_lang_data($lang = null) {
    $opt   = get_option(WCF_OPTION, []);
    $langs = isset($opt['langs']) && is_array($opt['langs']) ? $opt['langs'] : [];

    if ($lang === null) {
        $lang = function_exists('pll_current_language') ? pll_current_language('slug') : 'default';
    }

    if (!empty($langs[$lang])) {
        return wp_parse_args($langs[$lang], wcf_lang_defaults());
    }
    // Fallback: first configured language, else defaults.
    if (!empty($langs)) {
        return wp_parse_args(reset($langs), wcf_lang_defaults());
    }
    return wcf_lang_defaults();
}

function wcf_get_bg_image() {
    $opt = get_option(WCF_OPTION, []);
    return !empty($opt['bg_image']) ? $opt['bg_image'] : '';
}

function wcf_get_header_logo_width() {
    $opt = get_option(WCF_OPTION, []);
    return !empty($opt['header_logo_width']) ? (int) $opt['header_logo_width'] : 126;
}

/**
 * Returns inline SVG markup for a known social network, matched against the
 * admin-entered label (e.g. "Facebook", "Instagram DM"). Returns '' if the
 * label doesn't match a known network, so callers can fall back to a letter.
 */
function wcf_social_icon_svg($label) {
    $key = strtolower(trim($label));
    $icons = [
        'facebook' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12a10 10 0 1 0-11.5 9.95v-7.04H7.9V12h2.6V9.8c0-2.56 1.53-3.97 3.87-3.97 1.12 0 2.3.2 2.3.2v2.5h-1.3c-1.28 0-1.68.8-1.68 1.62V12h2.85l-.46 2.91h-2.39v7.04A10 10 0 0 0 22 12Z"/></svg>',
        'instagram' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4.2"/><circle cx="17.3" cy="6.7" r="1.1" fill="currentColor" stroke="none"/></svg>',
        'linkedin' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5ZM3 9.98h4v10.52H3V9.98Zm7.5 0h3.83v1.44h.05c.53-1 1.83-2.06 3.77-2.06 4.03 0 4.78 2.65 4.78 6.1v6.04h-4v-5.36c0-1.28-.02-2.93-1.78-2.93-1.78 0-2.06 1.4-2.06 2.84v5.45h-4V9.98Z"/></svg>',
        'twitter' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.9 4h2.9l-6.3 7.2L23 20h-5.8l-4.5-5.9L7.5 20H4.6l6.7-7.7L4 4h5.9l4.1 5.4L18.9 4Z"/></svg>',
        'x' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.9 4h2.9l-6.3 7.2L23 20h-5.8l-4.5-5.9L7.5 20H4.6l6.7-7.7L4 4h5.9l4.1 5.4L18.9 4Z"/></svg>',
        'youtube' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 12s0-3.4-.43-5.02a2.94 2.94 0 0 0-2.07-2.08C18.9 4.46 12 4.46 12 4.46s-6.9 0-8.5.44a2.94 2.94 0 0 0-2.07 2.08C1 8.6 1 12 1 12s0 3.4.43 5.02c.24.9 1 1.6 1.9 1.84 1.6.44 8.5.44 8.5.44s6.9 0 8.5-.44a2.94 2.94 0 0 0 2.07-1.84C23 15.4 23 12 23 12ZM9.75 15.4V8.6L15.5 12l-5.75 3.4Z"/></svg>',
        'tiktok' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16.6 3c.4 2.2 1.8 3.8 4.2 4v3.1c-1.5 0-2.9-.4-4.1-1.2v6.4a6 6 0 1 1-6-6c.3 0 .5 0 .8.05v3.2a2.8 2.8 0 1 0 2 2.7V3h3.1Z"/></svg>',
    ];
    foreach ($icons as $needle => $svg) {
        if (strpos($key, $needle) !== false) {
            return $svg;
        }
    }
    return '';
}

/* ---------------- Admin ---------------- */

class WC_Footer_Settings {

    public function __construct() {
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_init', [$this, 'register']);
        add_action('admin_enqueue_scripts', [$this, 'assets']);
    }

    public function menu() {
        add_menu_page(
            __('Header & Footer', 'westio-child'),
            __('Header & Footer', 'westio-child'),
            'manage_options',
            'wc-footer',
            [$this, 'page'],
            'dashicons-align-center',
            61
        );
    }

    public function register() {
        register_setting('wc_footer_group', WCF_OPTION, [$this, 'sanitize']);
    }

    public function sanitize($input) {
        $clean = ['bg_image' => '', 'header_logo_width' => 126, 'langs' => []];
        $clean['bg_image'] = isset($input['bg_image']) ? esc_url_raw($input['bg_image']) : '';
        $clean['header_logo_width'] = isset($input['header_logo_width']) && (int) $input['header_logo_width'] > 0
            ? (int) $input['header_logo_width']
            : 126;

        if (!empty($input['langs']) && is_array($input['langs'])) {
            foreach ($input['langs'] as $slug => $data) {
                $slug = sanitize_key($slug);
                $lang = [
                    'header_phone'     => sanitize_text_field($data['header_phone'] ?? ''),
                    'header_cta_label' => sanitize_text_field($data['header_cta_label'] ?? ''),
                    'header_cta_url'   => $this->clean_url($data['header_cta_url'] ?? ''),
                    'address_label' => sanitize_text_field($data['address_label'] ?? ''),
                    'address_text'  => sanitize_textarea_field($data['address_text'] ?? ''),
                    'explore_label' => sanitize_text_field($data['explore_label'] ?? ''),
                    'copyright'     => sanitize_text_field($data['copyright'] ?? ''),
                    'columns'       => [],
                    'socials'       => [],
                ];

                if (!empty($data['columns']) && is_array($data['columns'])) {
                    foreach ($data['columns'] as $col) {
                        $items = [];
                        if (!empty($col['items']) && is_array($col['items'])) {
                            foreach ($col['items'] as $it) {
                                if (empty($it['label']) && empty($it['url'])) {
                                    continue;
                                }
                                $items[] = [
                                    'label' => sanitize_text_field($it['label'] ?? ''),
                                    'url'   => $this->clean_url($it['url'] ?? ''),
                                ];
                            }
                        }
                        $lang['columns'][] = $items;
                    }
                }

                if (!empty($data['socials']) && is_array($data['socials'])) {
                    foreach ($data['socials'] as $s) {
                        if (empty($s['label']) && empty($s['url'])) {
                            continue;
                        }
                        $lang['socials'][] = [
                            'label' => sanitize_text_field($s['label'] ?? ''),
                            'url'   => $this->clean_url($s['url'] ?? ''),
                        ];
                    }
                }

                $clean['langs'][$slug] = $lang;
            }
        }
        return $clean;
    }

    private function clean_url($url) {
        $url = trim($url);
        if ($url === '#' || $url === '') {
            return $url;
        }
        if (preg_match('#^tel:#i', $url)) {
            return 'tel:' . preg_replace('/[^0-9+]/', '', substr($url, 4));
        }
        if (preg_match('#^mailto:#i', $url)) {
            return 'mailto:' . sanitize_email(substr($url, 7));
        }
        return esc_url_raw($url);
    }

    public function assets($hook) {
        if ($hook !== 'toplevel_page_wc-footer') {
            return;
        }
        wp_enqueue_media();
        wp_enqueue_style('wc-footer-admin', get_stylesheet_directory_uri() . '/assets/css/footer-admin.css', [], '1.0.0');
        wp_enqueue_script('wc-footer-admin', get_stylesheet_directory_uri() . '/assets/js/footer-admin.js', ['jquery'], '1.0.0', true);
    }

    public function page() {
        $opt         = get_option(WCF_OPTION, []);
        $bg_image    = !empty($opt['bg_image']) ? $opt['bg_image'] : '';
        $logo_width  = wcf_get_header_logo_width();
        $langs       = wcf_languages();
        ?>
        <div class="wrap wcf-wrap">
            <h1><?php esc_html_e('Header & Footer', 'westio-child'); ?></h1>
            <form method="post" action="options.php">
                <?php settings_fields('wc_footer_group'); ?>

                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><?php esc_html_e('Parallax background image', 'westio-child'); ?></th>
                        <td>
                            <div class="wcf-media">
                                <input type="hidden" class="wcf-media-input" name="<?php echo WCF_OPTION; ?>[bg_image]" value="<?php echo esc_attr($bg_image); ?>">
                                <img class="wcf-media-preview" src="<?php echo esc_url($bg_image); ?>" alt="" style="<?php echo $bg_image ? '' : 'display:none;'; ?>max-width:220px;height:auto;display:block;margin-bottom:8px;">
                                <button type="button" class="button wcf-media-select"><?php esc_html_e('Choose image', 'westio-child'); ?></button>
                                <button type="button" class="button wcf-media-remove" style="<?php echo $bg_image ? '' : 'display:none;'; ?>"><?php esc_html_e('Remove', 'westio-child'); ?></button>
                                <p class="description"><?php esc_html_e('Shared across all languages.', 'westio-child'); ?></p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Header logo width (px)', 'westio-child'); ?></th>
                        <td>
                            <input type="number" min="20" max="600" class="small-text" name="<?php echo WCF_OPTION; ?>[header_logo_width]" value="<?php echo esc_attr($logo_width); ?>">
                            <p class="description"><?php esc_html_e('Width of the logo in the site header, in pixels.', 'westio-child'); ?></p>
                        </td>
                    </tr>
                </table>

                <h2 class="nav-tab-wrapper wcf-tabs">
                    <?php $first = true; foreach ($langs as $slug => $name) : ?>
                        <a href="#" class="nav-tab <?php echo $first ? 'nav-tab-active' : ''; ?>" data-lang="<?php echo esc_attr($slug); ?>"><?php echo esc_html($name); ?></a>
                        <?php $first = false; endforeach; ?>
                </h2>

                <?php $first = true; foreach ($langs as $slug => $name) : ?>
                    <?php
                    $saved = !empty($opt['langs'][$slug]) ? wp_parse_args($opt['langs'][$slug], wcf_lang_defaults()) : wcf_lang_defaults();
                    ?>
                    <div class="wcf-lang-panel" data-lang="<?php echo esc_attr($slug); ?>" style="<?php echo $first ? '' : 'display:none;'; ?>">
                        <?php $this->lang_fields($slug, $saved); ?>
                    </div>
                    <?php $first = false; endforeach; ?>

                <?php submit_button(); ?>
            </form>

            <script type="text/template" id="wcf-link-item-tpl">
                <?php $this->link_item_row('__LANG__', '__COL__', '__I__', ['label' => '', 'url' => '#']); ?>
            </script>
            <script type="text/template" id="wcf-social-item-tpl">
                <?php $this->social_row('__LANG__', '__I__', ['label' => '', 'url' => '#']); ?>
            </script>
        </div>
        <?php
    }

    private function lang_fields($slug, $data) {
        $base = WCF_OPTION . '[langs][' . $slug . ']';
        ?>
        <h3><?php esc_html_e('Header', 'westio-child'); ?></h3>
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><?php esc_html_e('Phone', 'westio-child'); ?></th>
                <td><input type="text" class="regular-text" name="<?php echo esc_attr($base); ?>[header_phone]" value="<?php echo esc_attr($data['header_phone']); ?>"></td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Contact button label', 'westio-child'); ?></th>
                <td><input type="text" class="regular-text" name="<?php echo esc_attr($base); ?>[header_cta_label]" value="<?php echo esc_attr($data['header_cta_label']); ?>"></td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Contact button link', 'westio-child'); ?></th>
                <td><input type="text" class="regular-text" name="<?php echo esc_attr($base); ?>[header_cta_url]" value="<?php echo esc_attr($data['header_cta_url']); ?>"></td>
            </tr>
        </table>

        <h3><?php esc_html_e('Footer', 'westio-child'); ?></h3>
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><?php esc_html_e('Address heading', 'westio-child'); ?></th>
                <td><input type="text" class="regular-text" name="<?php echo esc_attr($base); ?>[address_label]" value="<?php echo esc_attr($data['address_label']); ?>"></td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Address text', 'westio-child'); ?></th>
                <td><textarea class="large-text" rows="3" name="<?php echo esc_attr($base); ?>[address_text]"><?php echo esc_textarea($data['address_text']); ?></textarea></td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Explore heading', 'westio-child'); ?></th>
                <td><input type="text" class="regular-text" name="<?php echo esc_attr($base); ?>[explore_label]" value="<?php echo esc_attr($data['explore_label']); ?>"></td>
            </tr>
        </table>

        <h3><?php esc_html_e('Link columns', 'westio-child'); ?></h3>
        <div class="wcf-columns">
            <?php for ($c = 0; $c < 2; $c++) :
                $items = isset($data['columns'][$c]) && is_array($data['columns'][$c]) ? $data['columns'][$c] : [];
                ?>
                <div class="wcf-column">
                    <h4><?php printf(esc_html__('Column %d', 'westio-child'), $c + 1); ?></h4>
                    <div class="wcf-items" data-lang="<?php echo esc_attr($slug); ?>" data-col="<?php echo esc_attr($c); ?>">
                        <?php foreach ($items as $i => $it) : ?>
                            <?php $this->link_item_row($slug, $c, $i, $it); ?>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="button wcf-add-link" data-lang="<?php echo esc_attr($slug); ?>" data-col="<?php echo esc_attr($c); ?>"><?php esc_html_e('+ Add link', 'westio-child'); ?></button>
                </div>
            <?php endfor; ?>
        </div>

        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><?php esc_html_e('Copyright', 'westio-child'); ?></th>
                <td><input type="text" class="large-text" name="<?php echo esc_attr($base); ?>[copyright]" value="<?php echo esc_attr($data['copyright']); ?>"></td>
            </tr>
        </table>

        <h3><?php esc_html_e('Social links', 'westio-child'); ?></h3>
        <div class="wcf-socials" data-lang="<?php echo esc_attr($slug); ?>">
            <?php foreach ($data['socials'] as $i => $s) : ?>
                <?php $this->social_row($slug, $i, $s); ?>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button wcf-add-social" data-lang="<?php echo esc_attr($slug); ?>"><?php esc_html_e('+ Add social', 'westio-child'); ?></button>
        <?php
    }

    private function link_item_row($slug, $col, $index, $it) {
        $name = WCF_OPTION . '[langs][' . $slug . '][columns][' . $col . '][items][' . $index . ']';
        ?>
        <div class="wcf-item">
            <input type="text" placeholder="<?php esc_attr_e('Label', 'westio-child'); ?>" name="<?php echo esc_attr($name); ?>[label]" value="<?php echo esc_attr($it['label']); ?>">
            <input type="text" placeholder="<?php esc_attr_e('URL', 'westio-child'); ?>" name="<?php echo esc_attr($name); ?>[url]" value="<?php echo esc_attr($it['url']); ?>">
            <button type="button" class="button wcf-remove-row">&times;</button>
        </div>
        <?php
    }

    private function social_row($slug, $index, $s) {
        $name = WCF_OPTION . '[langs][' . $slug . '][socials][' . $index . ']';
        ?>
        <div class="wcf-item">
            <input type="text" placeholder="<?php esc_attr_e('Label (e.g. Facebook)', 'westio-child'); ?>" name="<?php echo esc_attr($name); ?>[label]" value="<?php echo esc_attr($s['label']); ?>">
            <input type="text" placeholder="<?php esc_attr_e('URL', 'westio-child'); ?>" name="<?php echo esc_attr($name); ?>[url]" value="<?php echo esc_attr($s['url']); ?>">
            <button type="button" class="button wcf-remove-row">&times;</button>
        </div>
        <?php
    }
}

new WC_Footer_Settings();

<?php
/**
 * Theme Options — admin page for the few sitewide look/behavior toggles
 * that don't belong to a specific widget or to the Header & Footer page:
 *   - H1 / H2 font size, overriding the theme's own default tag styling
 *     (westio/style.css `h1, .alpha` / `h2, .beta`) — this is what sizes
 *     a plain H1/H2 typed into the block editor, or any Elementor heading
 *     left at its default size, plus a couple of the theme's own named
 *     headings (single post title, page-title/comments-title fallbacks)
 *     that have their own dedicated rule. Does NOT touch a heading given
 *     its own custom size in Elementor — that rule is always more specific
 *     than this override.
 *   - Hide comments sitewide.
 *   - Hide the post meta line (author/date/category) above post titles.
 */

if (!defined('ABSPATH')) {
    exit;
}

define('WCTO_OPTION', 'wc_theme_options');

function wcto_defaults() {
    return [
        'h1_size'         => 80,
        'h2_size'         => 50,
        'hide_comments'   => false,
        'hide_post_meta'  => false,
    ];
}

function wcto_get_options() {
    return wp_parse_args(get_option(WCTO_OPTION, []), wcto_defaults());
}

class WC_Theme_Options {

    public function __construct() {
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_init', [$this, 'register']);
        add_action('wp_enqueue_scripts', [$this, 'frontend_css'], 40); // After westio-child-style is enqueued (parent registers it at priority 30).
        add_action('init', [$this, 'maybe_hide_comments']);
    }

    public function menu() {
        add_menu_page(
            __('Theme Options', 'westio-child'),
            __('Theme Options', 'westio-child'),
            'manage_options',
            'wc-theme-options',
            [$this, 'page'],
            'dashicons-admin-customizer',
            62
        );
    }

    public function register() {
        register_setting('wc_theme_options_group', WCTO_OPTION, [$this, 'sanitize']);
    }

    public function sanitize($input) {
        $defaults = wcto_defaults();
        return [
            'h1_size'        => isset($input['h1_size']) && (int) $input['h1_size'] > 0 ? min(300, (int) $input['h1_size']) : $defaults['h1_size'],
            'h2_size'        => isset($input['h2_size']) && (int) $input['h2_size'] > 0 ? min(300, (int) $input['h2_size']) : $defaults['h2_size'],
            'hide_comments'  => !empty($input['hide_comments']),
            'hide_post_meta' => !empty($input['hide_post_meta']),
        ];
    }

    public function page() {
        $opt = wcto_get_options();
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Theme Options', 'westio-child'); ?></h1>
            <form method="post" action="options.php">
                <?php settings_fields('wc_theme_options_group'); ?>
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><?php esc_html_e('H1 font size (px)', 'westio-child'); ?></th>
                        <td>
                            <input type="number" min="16" max="300" class="small-text" name="<?php echo WCTO_OPTION; ?>[h1_size]" value="<?php echo esc_attr($opt['h1_size']); ?>">
                            <p class="description"><?php esc_html_e('The theme\'s default H1 size — applies to plain H1 headings (e.g. typed into a post with the block editor) and any Elementor heading left at its default size, plus the single blog post title and page-title fallbacks (empty blog archive, search results). Does not affect a heading you\'ve given its own custom size in Elementor.', 'westio-child'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('H2 font size (px)', 'westio-child'); ?></th>
                        <td>
                            <input type="number" min="16" max="300" class="small-text" name="<?php echo WCTO_OPTION; ?>[h2_size]" value="<?php echo esc_attr($opt['h2_size']); ?>">
                            <p class="description"><?php esc_html_e('The theme\'s default H2 size — applies to plain H2 headings (e.g. typed into a post with the block editor) and any Elementor heading left at its default size, plus the "Comments" section heading. Does not affect a heading you\'ve given its own custom size in Elementor.', 'westio-child'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Comments', 'westio-child'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="<?php echo WCTO_OPTION; ?>[hide_comments]" value="1" <?php checked($opt['hide_comments']); ?>>
                                <?php esc_html_e('Hide the comment form and comment list on posts and pages', 'westio-child'); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Post meta', 'westio-child'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="<?php echo WCTO_OPTION; ?>[hide_post_meta]" value="1" <?php checked($opt['hide_post_meta']); ?>>
                                <?php esc_html_e('Hide the author / date / category line above post titles (blog listing and single post)', 'westio-child'); ?>
                            </label>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function frontend_css() {
        $opt = wcto_get_options();
        $css = '';

        if ($opt['h1_size'] !== 80) {
            $h1 = (int) $opt['h1_size'];
            // h1, .alpha is the theme's own generic default H1 size (westio/style.css)
            // — governs plain content headings (Gutenberg heading blocks, Elementor
            // headings left at their default size) that don't have a specific rule
            // of their own. .single-post .entry-title / .page-header h1.page-title
            // are separate, more specific theme headings with their own dedicated
            // rule, so they need overriding too.
            $css .= 'h1, .alpha, .single-post .entry-title, .page-header h1.page-title { font-size: ' . $h1 . 'px; }';
            $css .= '@media (min-width: 568px) { h1, .alpha, .single-post .entry-title, .page-header h1.page-title { font-size: ' . $h1 . 'px; } }';
        }

        if ($opt['h2_size'] !== 50) {
            $h2 = (int) $opt['h2_size'];
            // h2, .beta is the generic default; #comments .comments-title has its
            // own dedicated rule and needs overriding separately.
            $css .= 'h2, .beta, #comments .comments-title { font-size: ' . $h2 . 'px; }';
            $css .= '@media (min-width: 568px) { h2, .beta, #comments .comments-title { font-size: ' . $h2 . 'px; } }';
        }

        if (!empty($opt['hide_post_meta'])) {
            $css .= '.entry-meta { display: none !important; }';
        }

        if ($css !== '' && wp_style_is('westio-child-style', 'enqueued')) {
            wp_add_inline_style('westio-child-style', $css);
        }
    }

    public function maybe_hide_comments() {
        $opt = wcto_get_options();
        if (empty($opt['hide_comments'])) {
            return;
        }
        remove_action('westio_single_post_bottom', 'westio_display_comments', 20);
        remove_action('westio_page_after', 'westio_display_comments', 10);
    }
}

new WC_Theme_Options();

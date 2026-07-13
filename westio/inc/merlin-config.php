<?php

class Westio_Merlin_Config {

    private $wizard;

    public function __construct() {
        $this->init();
        add_filter('merlin_import_files', [$this, 'import_files']);
        add_action('merlin_after_all_import', [$this, 'after_import_setup'], 10, 1);
        add_filter('merlin_generate_child_functions_php', [$this, 'render_child_functions_php']);

        add_action('import_start', function () {
            add_filter('wxr_importer.pre_process.post_meta', [$this, 'fiximport_elementor'], 10, 1);
            update_option('elementor_experiment-container', 'active');
            update_option('elementor_experiment-nested-elements', 'active');
            update_option('elementor_experiment-e_optimized_css_loading', 'inactive');
            update_option('elementor_experiment-e_font_icon_svg', 'inactive');
            update_option('elementor_unfiltered_files_upload', 1);
        });

        add_action('import_end', function () {
            update_option('elementor_experiment-container', 'active');
            update_option('elementor_experiment-nested-elements', 'active');
        });
    }

    public function fiximport_elementor($post_meta) {
        if ('_elementor_data' === $post_meta['key']) {
            $post_meta['value'] = wp_slash($post_meta['value']);
        }

        return $post_meta;
    }

    public function import_files() {
            
        return array(
            array(
                'import_file_name'           => 'home 1',
                'home'                       => 'home-1',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-1.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home-1.jpg'),
                'preview_url'                => 'https://demo2.pavothemes.com/westio/home-1',
                'elementor'                  => '{"system_colors":[{"_id":"primary","title":"Primary","color":"#BDAD7B"},{"_id":"secondary","title":"Secondary","color":"#000000"},{"_id":"text","title":"Text","color":"#555555"},{"_id":"accent","title":"Accent","color":"#BDAD7B"},{"_id":"border","title":"Border","color":"#DCE0E3"},{"_id":"lighter","title":"Lighter","color":"#8C8C8C"},{"_id":"dark","title":"Dark","color":"#000"},{"_id":"highlight","title":"Highlight","color":"#96FE81"}],"custom_colors":[],"system_typography":[{"_id":"primary","title":"Primary","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"600"},{"_id":"secondary","title":"Secondary(Heading)","typography_typography":"custom","typography_font_family":"Space Grotesk","typography_font_weight":"400"},{"_id":"text","title":"Text","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"400"},{"_id":"accent","title":"Accent","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"600"}],"custom_typography":[],"default_generic_fonts":"Sans-serif","site_name":"Westio","site_description":"Real Estate & Apartment Landing Page WordPress Theme","page_title_selector":"h1.entry-title","activeItemIndex":1,"active_breakpoints":["viewport_mobile","viewport_mobile_extra","viewport_tablet","viewport_tablet_extra","viewport_laptop"],"viewport_md":768,"viewport_lg":1025,"container_width":{"unit":"px","size":1300,"sizes":[]},"space_between_widgets":{"column":"20","row":"20","isLinked":true,"unit":"px","size":0,"sizes":[]},"body_background_background":"classic","body_background_color":"#F4F0E9","viewport_laptop":1440}',
                'themeoptions'               => '{}',
            ),

            array(
                'import_file_name'           => 'home 2',
                'home'                       => 'home-2',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-2.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home-2.jpg'),
                'preview_url'                => 'https://demo2.pavothemes.com/westio/home-2',
                'elementor'                  => '{"system_colors":[{"_id":"primary","title":"Primary","color":"#BDAD7B"},{"_id":"secondary","title":"Secondary","color":"#000000"},{"_id":"text","title":"Text","color":"#555555"},{"_id":"accent","title":"Accent","color":"#BDAD7B"},{"_id":"border","title":"Border","color":"#DCE0E3"},{"_id":"lighter","title":"Lighter","color":"#8C8C8C"},{"_id":"dark","title":"Dark","color":"#000"},{"_id":"highlight","title":"Highlight","color":"#96FE81"}],"custom_colors":[],"system_typography":[{"_id":"primary","title":"Primary","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"600"},{"_id":"secondary","title":"Secondary(Heading)","typography_typography":"custom","typography_font_family":"Space Grotesk","typography_font_weight":"400"},{"_id":"text","title":"Text","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"400"},{"_id":"accent","title":"Accent","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"600"}],"custom_typography":[],"default_generic_fonts":"Sans-serif","site_name":"Westio","site_description":"Real Estate & Apartment Landing Page WordPress Theme","page_title_selector":"h1.entry-title","activeItemIndex":1,"active_breakpoints":["viewport_mobile","viewport_mobile_extra","viewport_tablet","viewport_tablet_extra","viewport_laptop"],"viewport_md":768,"viewport_lg":1025,"container_width":{"unit":"px","size":1300,"sizes":[]},"space_between_widgets":{"column":"20","row":"20","isLinked":true,"unit":"px","size":0,"sizes":[]},"body_background_background":"classic","body_background_color":"#F4F0E9","viewport_laptop":1440}',
                'themeoptions'               => '{}',
            ),

            array(
                'import_file_name'           => 'home 3',
                'home'                       => 'home-3',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-3.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home-3.jpg'),
                'preview_url'                => 'https://demo2.pavothemes.com/westio/home-3',
                'elementor'                  => '{"system_colors":[{"_id":"primary","title":"Primary","color":"#BDAD7B"},{"_id":"secondary","title":"Secondary","color":"#000000"},{"_id":"text","title":"Text","color":"#555555"},{"_id":"accent","title":"Accent","color":"#BDAD7B"},{"_id":"border","title":"Border","color":"#DCE0E3"},{"_id":"lighter","title":"Lighter","color":"#8C8C8C"},{"_id":"dark","title":"Dark","color":"#000"},{"_id":"highlight","title":"Highlight","color":"#96FE81"}],"custom_colors":[],"system_typography":[{"_id":"primary","title":"Primary","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"600"},{"_id":"secondary","title":"Secondary(Heading)","typography_typography":"custom","typography_font_family":"Space Grotesk","typography_font_weight":"400"},{"_id":"text","title":"Text","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"400"},{"_id":"accent","title":"Accent","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"600"}],"custom_typography":[],"default_generic_fonts":"Sans-serif","site_name":"Westio","site_description":"Real Estate & Apartment Landing Page WordPress Theme","page_title_selector":"h1.entry-title","activeItemIndex":1,"active_breakpoints":["viewport_mobile","viewport_mobile_extra","viewport_tablet","viewport_tablet_extra","viewport_laptop"],"viewport_md":768,"viewport_lg":1025,"container_width":{"unit":"px","size":1300,"sizes":[]},"space_between_widgets":{"column":"20","row":"20","isLinked":true,"unit":"px","size":0,"sizes":[]},"body_background_background":"classic","body_background_color":"#F4F0E9","viewport_laptop":1440}',
                'themeoptions'               => '{}',
            ),

            array(
                'import_file_name'           => 'home 4',
                'home'                       => 'home-4',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-4.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home-4.jpg'),
                'preview_url'                => 'https://demo2.pavothemes.com/westio/home-4',
                'elementor'                  => '{"system_colors":[{"_id":"primary","title":"Primary","color":"#BDAD7B"},{"_id":"secondary","title":"Secondary","color":"#000000"},{"_id":"text","title":"Text","color":"#555555"},{"_id":"accent","title":"Accent","color":"#BDAD7B"},{"_id":"border","title":"Border","color":"#DCE0E3"},{"_id":"lighter","title":"Lighter","color":"#8C8C8C"},{"_id":"dark","title":"Dark","color":"#000"},{"_id":"highlight","title":"Highlight","color":"#96FE81"}],"custom_colors":[],"system_typography":[{"_id":"primary","title":"Primary","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"600"},{"_id":"secondary","title":"Secondary(Heading)","typography_typography":"custom","typography_font_family":"Space Grotesk","typography_font_weight":"400"},{"_id":"text","title":"Text","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"400"},{"_id":"accent","title":"Accent","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"600"}],"custom_typography":[],"default_generic_fonts":"Sans-serif","site_name":"Westio","site_description":"Real Estate & Apartment Landing Page WordPress Theme","page_title_selector":"h1.entry-title","activeItemIndex":1,"active_breakpoints":["viewport_mobile","viewport_mobile_extra","viewport_tablet","viewport_tablet_extra","viewport_laptop"],"viewport_md":768,"viewport_lg":1025,"container_width":{"unit":"px","size":1300,"sizes":[]},"space_between_widgets":{"column":"20","row":"20","isLinked":true,"unit":"px","size":0,"sizes":[]},"body_background_background":"classic","body_background_color":"#F4F0E9","viewport_laptop":1440}',
                'themeoptions'               => '{}',
            ),

        );           
    }// end import_files

    public function after_import_setup($selected_import) {
        $selected_import = ($this->import_files())[$selected_import];

        // setup Home page
        $home = get_page_by_path($selected_import['home']);
        $blog = get_page_by_path('blog');

        if ($home && $home->ID) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home->ID);
        }

        if ($blog && $blog->ID) {
            update_option('page_for_posts', $blog->ID);
        }

        $this->set_demo_menus();

        // Setup Options
        $options       = $this->get_all_options();
        $theme_options = $options['options'];
        foreach ($theme_options as $key => $option) {
            update_option($key, $option);
        }

        $active_kit_id = Elementor\Plugin::$instance->kits_manager->get_active_id();
        update_post_meta($active_kit_id, '_elementor_page_settings', json_decode($selected_import['elementor'], true));
        set_theme_mod('custom_logo', $this->get_attachment('_logo'));

        // Header Footer Builder
        $this->reset_header_footer();
        $this->set_hf($selected_import['home']);


        //if exists, assign to $cpt_support var
        $cpt_support = get_option('elementor_cpt_support');
        //check if option DOESN'T exist in db
        if (!$cpt_support) {
            $cpt_support = ['page', 'post', 'etb_library']; //create array of our default supported post types
            update_option('elementor_cpt_support', $cpt_support); //write it to the database
        } //if it DOES exist, but trainer is NOT defined
        else if (!in_array('etb_library', $cpt_support)) {
            $cpt_support[] = 'etb_library'; //append to array
            update_option('elementor_cpt_support', $cpt_support); //write it to the database
        }
        $mailchimp = $this->get_mailchimp_id();
        if ($mailchimp) {
            update_option('mc4wp_default_form_id', $mailchimp);
        }

        $this->update_nav_menu_item();
        \Elementor\Utils::replace_urls('http://source.wpopal.com/westio', site_url());
        \Elementor\Plugin::instance()->files_manager->clear_cache();
    }

    private function update_nav_menu_item($from = 'http://source.wpopal.com/westio') {
        $from = trim($from);
        $to   = trim(site_url());

        $params = array(
            'posts_per_page' => -1,
            'post_type'      => [
                'nav_menu_item',
            ],
        );
        $query  = new WP_Query($params);
        while ($query->have_posts()): $query->the_post();
            wp_update_post(array(
                // Update the `nav_menu_item` Post Title
                'ID'         => get_the_ID(),
                'post_title' => get_the_title()
            ));

            if (get_post_meta(get_the_ID(), '_menu_item_type', true) == 'custom') {
                $url = get_post_meta(get_the_ID(), '_menu_item_url', true);
                $url = str_replace($from, $to, $url);
                update_post_meta(get_the_ID(), '_menu_item_url', esc_url_raw($url));
            }
        endwhile;
        wp_reset_postdata();
    }

    private function update_page() {
        $pages = array(
            array(
                "ID"           => wc_get_page_id('cart'),
                "post_content" => "<!-- wp:shortcode -->[woocommerce_cart]<!-- /wp:shortcode -->"
            ),
            array(
                "ID"           => wc_get_page_id('checkout'),
                "post_content" => "<!-- wp:shortcode -->[woocommerce_checkout]<!-- /wp:shortcode -->"
            ),
            array(
                "ID"           => wc_get_page_id('my-account'),
                "post_content" => "<!-- wp:shortcode -->[woocommerce_my_account]<!-- /wp:shortcode -->"
            )
        );
        foreach ($pages as $page) {
            if ($page['ID']) {
                wp_update_post($page);
            }
        }
    }

    //remove quick_table_enable
    private function remove_quick_table_enable() {
        $qte = get_option('woosc_settings');
        if ($qte) {
            if ($qte['quick_table_enable'] == 'yes') {
                $qte['quick_table_enable'] = 'no';
                update_option('woosc_settings', $qte);
            }
        } else {
            $qte                       = array();
            $qte['quick_table_enable'] = 'no';
            add_option('woosc_settings', $qte);
        }

    }

    private function update_elementor_widget_cf_id($post_id, $widget_id, $new_cf_id) {
        $meta_key = '_elementor_data';
        $data     = get_post_meta($post_id, $meta_key, true);

        if (!empty($data)) {
            $data = json_decode($data, true);
            foreach ($data as &$section) {
                if (isset($section['elements'])) {
                    foreach ($section['elements'] as &$element) {
                        if ($element['id'] === $widget_id) {
                            $element['settings']['cf_id'] = $new_cf_id;
                        }
                    }
                }
            }
            update_post_meta($post_id, $meta_key, json_encode($data));
        }
    }

    private function get_mailchimp_id() {
        $params = array(
            'post_type'      => 'mc4wp-form',
            'posts_per_page' => 1,
        );
        $post   = get_posts($params);

        return isset($post[0]) ? $post[0]->ID : 0;
    }

    private function get_attachment($key) {
        $params = array(
            'post_type'      => 'attachment',
            'post_status'    => 'inherit',
            'posts_per_page' => 1,
            'meta_key'       => $key,
        );
        $post   = get_posts($params);
        if ($post) {
            return $post[0]->ID;
        }

        return 0;
    }

    private function init() {
        $this->wizard = new Merlin(
            $config = array(
                // Location / directory where Merlin WP is placed in your theme.
                'merlin_url'         => 'merlin',
                // The wp-admin page slug where Merlin WP loads.
                'parent_slug'        => 'themes.php',
                // The wp-admin parent page slug for the admin menu item.
                'capability'         => 'manage_options',
                // The capability required for this menu to be displayed to the user.
                'dev_mode'           => true,
                // Enable development mode for testing.
                'license_step'       => false,
                // EDD license activation step.
                'license_required'   => false,
                // Require the license activation step.
                'license_help_url'   => '',
                'directory'          => '/inc/merlin',
                // URL for the 'license-tooltip'.
                'edd_remote_api_url' => '',
                // EDD_Theme_Updater_Admin remote_api_url.
                'edd_item_name'      => '',
                // EDD_Theme_Updater_Admin item_name.
                'edd_theme_slug'     => '',
                // EDD_Theme_Updater_Admin item_slug.
            ),
            $strings = array(
                'admin-menu'          => esc_html__('Theme Setup', 'westio'),

                /* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
                'title%s%s%s%s'       => esc_html__('%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'westio'),
                'return-to-dashboard' => esc_html__('Return to the dashboard', 'westio'),
                'ignore'              => esc_html__('Disable this wizard', 'westio'),

                'btn-skip'                 => esc_html__('Skip', 'westio'),
                'btn-next'                 => esc_html__('Next', 'westio'),
                'btn-start'                => esc_html__('Start', 'westio'),
                'btn-no'                   => esc_html__('Cancel', 'westio'),
                'btn-plugins-install'      => esc_html__('Install', 'westio'),
                'btn-child-install'        => esc_html__('Install', 'westio'),
                'btn-content-install'      => esc_html__('Install', 'westio'),
                'btn-import'               => esc_html__('Import', 'westio'),
                'btn-license-activate'     => esc_html__('Activate', 'westio'),
                'btn-license-skip'         => esc_html__('Later', 'westio'),

                /* translators: Theme Name */
                'license-header%s'         => esc_html__('Activate %s', 'westio'),
                /* translators: Theme Name */
                'license-header-success%s' => esc_html__('%s is Activated', 'westio'),
                /* translators: Theme Name */
                'license%s'                => esc_html__('Enter your license key to enable remote updates and theme support.', 'westio'),
                'license-label'            => esc_html__('License key', 'westio'),
                'license-success%s'        => esc_html__('The theme is already registered, so you can go to the next step!', 'westio'),
                'license-json-success%s'   => esc_html__('Your theme is activated! Remote updates and theme support are enabled.', 'westio'),
                'license-tooltip'          => esc_html__('Need help?', 'westio'),

                /* translators: Theme Name */
                'welcome-header%s'         => esc_html__('Welcome to %s', 'westio'),
                'welcome-header-success%s' => esc_html__('Hi. Welcome back', 'westio'),
                'welcome%s'                => esc_html__('This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'westio'),
                'welcome-success%s'        => esc_html__('You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'westio'),

                'child-header'         => esc_html__('Install Child Theme', 'westio'),
                'child-header-success' => esc_html__('You\'re good to go!', 'westio'),
                'child'                => esc_html__('Let\'s build & activate a child theme so you may easily make theme changes.', 'westio'),
                'child-success%s'      => esc_html__('Your child theme has already been installed and is now activated, if it wasn\'t already.', 'westio'),
                'child-action-link'    => esc_html__('Learn about child themes', 'westio'),
                'child-json-success%s' => esc_html__('Awesome. Your child theme has already been installed and is now activated.', 'westio'),
                'child-json-already%s' => esc_html__('Awesome. Your child theme has been created and is now activated.', 'westio'),

                'plugins-header'         => esc_html__('Install Plugins', 'westio'),
                'plugins-header-success' => esc_html__('You\'re up to speed!', 'westio'),
                'plugins'                => esc_html__('Let\'s install some essential WordPress plugins to get your site up to speed.', 'westio'),
                'plugins-success%s'      => esc_html__('The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'westio'),
                'plugins-action-link'    => esc_html__('Advanced', 'westio'),

                'import-header'      => esc_html__('Import Content', 'westio'),
                'import'             => esc_html__('Let\'s import content to your website, to help you get familiar with the theme.', 'westio'),
                'import-action-link' => esc_html__('Advanced', 'westio'),

                'ready-header'      => esc_html__('All done. Have fun!', 'westio'),

                /* translators: Theme Author */
                'ready%s'           => esc_html__('Your theme has been all set up. Enjoy your new theme by %s.', 'westio'),
                'ready-action-link' => esc_html__('Extras', 'westio'),
                'ready-big-button'  => esc_html__('View your website', 'westio'),
                'ready-link-1'      => sprintf('<a href="%1$s" target="_blank">%2$s</a>', 'https://wordpress.org/support/', esc_html__('Explore WordPress', 'westio')),
                'ready-link-2'      => sprintf('<a href="%1$s" target="_blank">%2$s</a>', 'https://themebeans.com/contact/', esc_html__('Get Theme Support', 'westio')),
                'ready-link-3'      => sprintf('<a href="%1$s">%2$s</a>', admin_url('customize.php'), esc_html__('Start Customizing', 'westio')),
            )
        );
        if (westio_is_elementor_activated() && function_exists('pavo_add_widget')) {
            add_action('widgets_init', [$this, 'widgets_init']);
        }
    }

    public function widgets_init() {
        require_once get_parent_theme_file_path('/inc/merlin/includes/base/recent-post.php');
        pavo_add_widget('Westio_WP_Widget_Recent_Posts');
    }

    private function get_all_header_footer() {
        return [
            'home-1' => [
                'header' => [
                    [
                        'slug'                         => 'header-1',
                        'etb_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                    ]
                ],
                'footer' => [
                    [
                        'slug'                         => 'footer-1',
                        'etb_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                    ],
                ]
            ],
            'home-2' => [
                'header' => [
                    [
                        'slug'                         => 'header-1',
                        'etb_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                    ]
                ],
                'footer' => [
                    [
                        'slug'                         => 'footer-1',
                        'etb_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                    ]
                ]
            ],
            'home-3' => [
                'header' => [
                    [
                        'slug'                         => 'header-2',
                        'etb_target_include_locations' => ['rule' => ['specifics'], 'specific' => ['post-37']],
                    ],
                    [
                        'slug'                         => 'header-1',
                        'etb_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                        'etb_target_exclude_locations' => ['rule' => ['specifics'], 'specific' => ['post-37']],
                    ]
                ],
                'footer' => [
                    [
                        'slug'                         => 'footer-1',
                        'etb_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                    ],
                ]
            ],
            'home-4' => [
                'header' => [
                    [
                        'slug'                         => 'header-2',
                        'etb_target_include_locations' => ['rule' => ['specifics'], 'specific' => ['post-39']],
                    ],
                    [
                        'slug'                         => 'header-1',
                        'etb_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                        'etb_target_exclude_locations' => ['rule' => ['specifics'], 'specific' => ['post-39']],
                    ]
                ],
                'footer' => [
                    [
                        'slug'                         => 'footer-1',
                        'etb_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                    ]
                ]
            ],
        ];
    }


    private function reset_header_footer() {
        $footer_args = array(
            'post_type'      => 'etb_library',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => 'etb_template_type',
                    'compare' => 'IN',
                    'value'   => ['type_footer', 'type_header']
                ),
            )
        );
        $footer      = new WP_Query($footer_args);
        while ($footer->have_posts()) : $footer->the_post();
            update_post_meta(get_the_ID(), 'etb_target_include_locations', []);
            update_post_meta(get_the_ID(), 'etb_target_exclude_locations', []);
        endwhile;
        wp_reset_postdata();
    }

    public function set_demo_menus() {
        $main_menu = get_term_by('name', 'Main Menu', 'nav_menu');

        set_theme_mod(
            'nav_menu_locations',
            array(
                'primary'  => $main_menu->term_id,
                'handheld' => $main_menu->term_id,
            )
        );
    }

    private function set_hf($home) {
        $all_hf = $this->get_all_header_footer();
        $datas  = $all_hf[$home];
        foreach ($datas as $item) {
            foreach ($item as $object) {
                $hf = get_page_by_path($object['slug'], OBJECT, 'etb_library');
                if ($hf) {
                    update_post_meta($hf->ID, 'etb_target_include_locations', $object['etb_target_include_locations']);
                    if (isset($object['etb_target_exclude_locations'])) {
                        update_post_meta($hf->ID, 'etb_target_exclude_locations', $object['etb_target_exclude_locations']);
                    }
                }
            }
        }
    }

    public function render_child_functions_php() {
        $output
            = "<?php
/**
 * Theme functions and definitions.
 */
		 ";

        return $output;
    }

    public function get_all_options(){
        $options = [];
        $options['options']   = json_decode('{"westio_options_blog_sidebar":"none","westio_options_blog_single_sidebar":"none"}', true);
        $options['elementor']   = json_decode('{"system_colors":[{"_id":"primary","title":"Primary","color":"#BDAD7B"},{"_id":"secondary","title":"Secondary","color":"#000000"},{"_id":"text","title":"Text","color":"#555555"},{"_id":"accent","title":"Accent","color":"#BDAD7B"},{"_id":"border","title":"Border","color":"#DCE0E3"},{"_id":"lighter","title":"Lighter","color":"#8C8C8C"},{"_id":"dark","title":"Dark","color":"#000"},{"_id":"highlight","title":"Highlight","color":"#96FE81"}],"custom_colors":[],"system_typography":[{"_id":"primary","title":"Primary","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"600"},{"_id":"secondary","title":"Secondary(Heading)","typography_typography":"custom","typography_font_family":"Space Grotesk","typography_font_weight":"400"},{"_id":"text","title":"Text","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"400"},{"_id":"accent","title":"Accent","typography_typography":"custom","typography_font_family":"Vend Sans","typography_font_weight":"600"}],"custom_typography":[],"default_generic_fonts":"Sans-serif","site_name":"Westio","site_description":"Real Estate & Apartment Landing Page WordPress Theme","page_title_selector":"h1.entry-title","activeItemIndex":1,"active_breakpoints":["viewport_mobile","viewport_mobile_extra","viewport_tablet","viewport_tablet_extra","viewport_laptop"],"viewport_md":768,"viewport_lg":1025,"container_width":{"unit":"px","size":1300,"sizes":[]},"space_between_widgets":{"column":"20","row":"20","isLinked":true,"unit":"px","size":0,"sizes":[]},"body_background_background":"classic","body_background_color":"#F4F0E9","viewport_laptop":1440}', true);
        return $options;
    } // end get_all_options
}

return new Westio_Merlin_Config();

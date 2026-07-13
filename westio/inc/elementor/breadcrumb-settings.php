<?php

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;

if (!class_exists('Westio_Elementor_Breadcrumb_Settings')) {

    class Westio_Elementor_Breadcrumb_Settings {

        public function __construct() {
            // Hook into Elementor's document control registration
            add_action('elementor/documents/register_controls', [$this, 'register_controls']);

            // Add custom wrapper classes based on breadcrumb settings
            add_filter('elementor/document/wrapper_attributes', [$this, 'add_wrapper_classes']);

            // Inject background image style if featured image is available
            add_action('wp_enqueue_scripts', [$this, 'add_background_image_style'], 9999);
        }

        /**
         * Inject background image CSS inline for the breadcrumbs wrapper
         * if the current page has a featured image.
         */
        public function add_background_image_style() {
            $style = '';
            if (has_post_thumbnail(get_queried_object_id())) {
                $url = wp_get_attachment_url(get_post_thumbnail_id(get_queried_object_id()), 'full');
                if ($url) {
                    $style .= '.elementor-breadcrumbs-wrapper.bg-has-post-thumbnail { background-image: url(' . esc_url($url) . '); }';
                }
            }
            wp_add_inline_style('westio-style', $style);
        }

        /**
         * Add wrapper classes based on post meta and Elementor settings.
         */
        public function add_wrapper_classes($attributes): array {
            $doc_id = absint($attributes['data-elementor-id']);
            $template_type = get_post_meta($doc_id, 'etb_template_type', true);

            // Add breadcrumbs wrapper class if the template type matches
            if ($template_type === 'type_after_header') {
                $attributes['class'] .= ' elementor-breadcrumbs-wrapper';
            }

            // Add background image class if breadcrumb feature is enabled
            $document = Plugin::instance()->documents->get($doc_id);
            if ($document && 'yes' === $document->get_settings('westio_breadcrumb_feature_switch')) {
                $attributes['class'] .= ' bg-has-post-thumbnail';
            }

            return $attributes;
        }

        /**
         * Register custom controls for breadcrumbs in Elementor settings panel.
         */
        public function register_controls($document) {
            $main_id = $document->get_main_id();
            $template_type = get_post_meta($main_id, 'etb_template_type', true);

            $document->start_controls_section(
                'westio_breadcrumb_settings',
                [
                    'label' => esc_html__('Breadcrumb Settings', 'westio'),
                    'tab'   => Controls_Manager::TAB_SETTINGS,
                ]
            );

            if ($template_type === 'type_after_header') {

                $document->add_control(
                    'westio_breadcrumb_feature_switch',
                    [
                        'label'        => esc_html__('Feature Post Image', 'westio'),
                        'type'         => Controls_Manager::SWITCHER,
                    ]
                );

                // Background controls
                $document->add_control('westio_breadcrumb_background_heading', [
                    'label'     => esc_html__('Background', 'westio'),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]);

                $document->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name'     => 'westio_breadcrumb_background',
                        'selector' => '.elementor-breadcrumbs-wrapper.elementor-' . $main_id,
                    ]
                );

                // Background overlay controls
                $document->add_control('westio_breadcrumb_background_overlay_heading', [
                    'label'     => esc_html__('Background Overlay', 'westio'),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]);

                $document->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name'     => 'westio_breadcrumb_background_overlay',
                        'selector' => '.elementor-' . $main_id . '.elementor-breadcrumbs-wrapper:before',
                        'fields_options' => [
                            'background' => [
                                'selectors' => [
                                    '.elementor-' . $main_id . '.elementor-breadcrumbs-wrapper:before' => '--background-overlay: \'\';',
                                ],
                            ],
                        ],
                    ]
                );

                // Overlay opacity control
                $document->add_control('westio_breadcrumb_background_overlay_opacity', [
                    'label'     => esc_html__('Opacity', 'westio'),
                    'type'      => Controls_Manager::SLIDER,
                    'default'   => ['size' => 0.5],
                    'range'     => ['px' => ['max' => 1, 'step' => 0.01]],
                    'selectors' => [
                        '.elementor-' . $main_id . '.elementor-breadcrumbs-wrapper:before' => 'opacity: {{SIZE}};',
                    ],
                ]);

            } else {
                // Toggle to hide breadcrumbs on templates that aren't "after header"
                $document->add_control('westio_breadcrumb_switch', [
                    'label'     => esc_html__('Hide Breadcrumb', 'westio'),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '.elementor-page-' . $main_id => '--page-breadcrumb-display: none',
                        '.elementor-' . $main_id => '--page-breadcrumb-display: none',
                        '.elementor-page-' . $main_id . ' .elementor-breadcrumbs-wrapper' => 'display: none',
                    ],
                ]);
            }

            $document->end_controls_section();
        }
    }

    // Instantiate the breadcrumb settings class
    new Westio_Elementor_Breadcrumb_Settings();
}

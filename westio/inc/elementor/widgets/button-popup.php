<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Westio_Elementor_Button_Popup extends Elementor\Widget_Base {

    public function get_name() {
        return 'westio-button-popup';
    }

    public function get_title() {
        return esc_html__('Westio Button Popup', 'westio');
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return array('westio-addons');
    }

    public function get_script_depends() {
        return ['westio-elementor-button-popup', 'magnific-popup'];
    }

    public function get_style_depends() {
        return ['magnific-popup'];
    }

    public function get_info() {
        global $post;

        $options[''] = esc_html__('Select Popup', 'westio');
        if (!westio_is_elementor_activated()) {
            return;
        }
        $args = array(
            'post_type'      => 'elementor_library',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            's'              => 'Popup',
            'order'          => 'ASC',
        );

        $query1 = new WP_Query($args);
        while ($query1->have_posts()) {
            $query1->the_post();
            $options[$post->ID] = $post->post_title;
        }

        wp_reset_postdata();
        return $options;
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_config',
            [
                'label' => esc_html__('Main Config', 'westio'),
            ]
        );

        $this->add_control(
            'heading_line',
            [
                'label' => esc_html__('Line Color', 'westio'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'line_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .line' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_button',
            [
                'label' => esc_html__('Main Button', 'westio'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'text',
            [
                'label'       => esc_html__('Text', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('Click here', 'westio'),
            ]
        );

        $this->add_control(
            'selected_icon',
            [
                'label'            => esc_html__('Icon', 'westio'),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin'             => 'inline',
                'label_block'      => false,
            ]
        );

        $this->add_control(
            'effect_button',
            [
                'label'   => esc_html__('Effect Button', 'westio'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'effect_pulse',
            [
                'label'        => esc_html__('Effect Pulse', 'westio'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'prefix_class' => 'effect-pulse-'
            ]
        );

        $this->add_control(
            'effect_line',
            [
                'label'        => esc_html__('Line', 'westio'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'prefix_class' => 'effect-line-'
            ]
        );

        $this->add_control(
            'heading_close',
            [
                'label'     => esc_html__('Close Button', 'westio'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'close_text',
            [
                'label'       => esc_html__('Close Text', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('Close', 'westio'),
            ]
        );

        $this->add_control(
            'close_icon',
            [
                'label'            => esc_html__('Close Icon', 'westio'),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'          => [
                    'value'   => 'westio-icon- westio-icon-close',
                    'library' => 'westio-icon',
                ],
                'skin'             => 'inline',
                'label_block'      => false,
            ]
        );

        $this->add_control(
            'template_id',
            [
                'label'       => esc_html__('Choose Popup', 'westio'),
                'default'     => '',
                'type'        => Controls_Manager::SELECT,
                'options'     => $this->get_info(),
                'description' => esc_html__('The templates for Info Page will utilize the elementor library with the prefix name of "Popup"', 'westio'),
                'label_block' => 'true',
                'separator'   => 'before'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_popup',
            [
                'label' => esc_html__('Popup Config', 'westio'),
            ]
        );

        $this->add_control(
            'zoom_effect',
            [
                'label'   => esc_html__('Popup effect', 'westio'),
                'default' => 'mfp-slide-bottom',
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'mfp-zoom-in'              => esc_html__('Zoom in', 'westio'),
                    'mfp-fade'                 => esc_html__('Fade', 'westio'),
                    'mfp-slide-top'            => esc_html__('Move to top', 'westio'),
                    'mfp-slide-right'          => esc_html__('Move to right', 'westio'),
                    'mfp-slide-bottom'         => esc_html__('Move to bottom', 'westio'),
                    'mfp-slide-left'           => esc_html__('Move to left', 'westio'),
                    'mfp-slide-bottom-special' => esc_html__('Westio move', 'westio'),
                ],
            ]
        );


        $this->add_responsive_control(
            'popup_width', [
            'label'      => esc_html__('Width', 'westio'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['%', 'px', 'vw', 'em', 'rem'],
            'selectors'  => [
                '.button-popup-content.button-popup-content-{{ID}}' => 'width: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control(
            'popup_height', [
            'label'      => esc_html__('Height', 'westio'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['%', 'px', 'vh', 'em', 'rem'],
            'selectors'  => [
                '.button-popup-content.button-popup-content-{{ID}}' => 'height: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_control(
            'popup_vertical',
            [
                'label'       => esc_html__('Prev Vertical', 'westio'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'render_type' => 'ui',
                'options'     => [
                    'top'    => [
                        'title' => esc_html__('Top', 'westio'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'westio'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'popup_vertical_value',
            [
                'type'       => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => ['%', 'px', 'vw', 'em', 'rem', 'custom'],
                'selectors'  => [
                    '.button-popup-content.button-popup-content-{{ID}}' => 'top: unset; bottom: unset; {{popup_vertical.value}}: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'popup_horizontal',
            [
                'label'       => esc_html__('Prev Horizontal', 'westio'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'left'  => [
                        'title' => esc_html__('Left', 'westio'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'westio'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
            ]
        );
        $this->add_responsive_control(
            'popup_horizontal_value',
            [
                'type'       => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => ['%', 'px', 'vw', 'em', 'rem', 'custom'],
                'selectors'  => [
                    '.button-popup-content.button-popup-content-{{ID}}' => 'left: unset; right: unset; {{popup_horizontal.value}}: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            "_transform_translateX",
            [
                'label'      => esc_html__('Offset X', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range'      => [
                    '%'  => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    ".button-popup-content.button-popup-content-{{ID}}" => '--transform-translateX: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            "_transform_translateY",
            [
                'label'      => esc_html__('Offset Y', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'custom'],
                'range'      => [
                    '%'  => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    ".button-popup-content.button-popup-content-{{ID}}" => '--transform-translateY: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Button', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'selector' => '{{WRAPPER}} .button-popup .elementor-button-text',
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label'     => esc_html__('Icon Position', 'westio'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'left',
                'options'   => [
                    'left'  => esc_html__('Before', 'westio'),
                    'right' => esc_html__('After', 'westio'),
                ],
                'condition' => [
                    'selected_icon[value]!' => '',
                ],
            ]
        );


        $this->add_control(
            'icon_indent',
            [
                'label'     => esc_html__('Icon Spacing', 'westio'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'condition' => [
                    'selected_icon[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .button-popup .elementor-button-content-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'     => esc_html__('Icon Size', 'westio'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'selected_icon[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .button-popup .elementor-button-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__('Normal', 'westio'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => esc_html__('Text Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .button-popup'                              => 'fill: {{VALUE}}; color: {{VALUE}};',
                    '{{WRAPPER}} .button-popup .elementor-button-text:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_icon_color',
            [
                'label'     => esc_html__('Icon Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'condition' => [
                    'selected_icon[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .button-popup .elementor-button-icon i'   => 'fill: {{VALUE}}; color: {{VALUE}};',
                    '{{WRAPPER}} .button-popup .elementor-button-icon svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_pulse-color',
            [
                'label'     => esc_html__('Pulse Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'condition' => [
                    'effect_pulse' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}}.effect-pulse-yes' => '--pulse-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'background',
                'label'          => esc_html__('Background', 'westio'),
                'types'          => ['classic', 'gradient'],
                'exclude'        => ['image'],
                'selector'       => '{{WRAPPER}} .button-popup',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__('Hover', 'westio'),
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label'     => esc_html__('Text Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .button-popup:hover'                              => 'color: {{VALUE}};',
                    '{{WRAPPER}} .button-popup:hover .elementor-button-text:after' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .button-popup:hover .elementor-button-text'       => 'text-shadow: 0 1.5em 0 {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_icon_color_hover',
            [
                'label'     => esc_html__('Icon Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'condition' => [
                    'selected_icon[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .button-popup:hover .elementor-button-icon i'   => 'fill: {{VALUE}}; color: {{VALUE}};',
                    '{{WRAPPER}} .button-popup:hover .elementor-button-icon svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'button_background_hover',
                'label'          => esc_html__('Background', 'westio'),
                'types'          => ['classic', 'gradient'],
                'exclude'        => ['image'],
                'selector'       => '{{WRAPPER}} .button-popup:hover',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .button-popup:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'border',
                'selector'  => '{{WRAPPER}} .button-popup',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label'      => esc_html__('Border Radius', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .button-popup' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .button-popup',
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .button-popup' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_close_style',
            [
                'label' => esc_html__('Button Close', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'close_typography',
                'selector' => '.button-popup-content.button-popup-content-{{ID}} .mfp-close',
            ]
        );

        $this->add_control(
            'close_icon_align',
            [
                'label'     => esc_html__('Icon Position', 'westio'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'left',
                'options'   => [
                    'left'  => esc_html__('Before', 'westio'),
                    'right' => esc_html__('After', 'westio'),
                ],
                'condition' => [
                    'selected_icon[value]!' => '',
                ],
            ]
        );


        $this->add_control(
            'close_icon_indent',
            [
                'label'     => esc_html__('Icon Spacing', 'westio'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '.button-popup-content.button-popup-content-{{ID}} .mfp-close .elementor-button-content-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'close_icon_size',
            [
                'label'     => esc_html__('Icon Size', 'westio'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '.button-popup-content.button-popup-content-{{ID}} .mfp-close i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'close_text_shadow',
                'selector' => '.button-popup-content.button-popup-content-{{ID}} .mfp-close .elementor-button-content-wrapper',
            ]
        );

        $this->start_controls_tabs('tabs_button_close_style');

        $this->start_controls_tab(
            'tab_close_button_normal',
            [
                'label' => esc_html__('Normal', 'westio'),
            ]
        );

        $this->add_control(
            'button_colse_text_color',
            [
                'label'     => esc_html__('Text Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.button-popup-content.button-popup-content-{{ID}} .mfp-close' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'close_background',
                'label'          => esc_html__('Background', 'westio'),
                'types'          => ['classic', 'gradient'],
                'exclude'        => ['image'],
                'selector'       => '.button-popup-content.button-popup-content-{{ID}} .mfp-close',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_close_button_hover',
            [
                'label' => esc_html__('Hover', 'westio'),
            ]
        );

        $this->add_control(
            'close_hover_color',
            [
                'label'     => esc_html__('Text Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.button-popup-content.button-popup-content-{{ID}} .mfp-close:hover'     => 'color: {{VALUE}};',
                    '.button-popup-content.button-popup-content-{{ID}} .mfp-close:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'button_close_background_hover',
                'label'          => esc_html__('Background', 'westio'),
                'types'          => ['classic', 'gradient'],
                'exclude'        => ['image'],
                'selector'       => '.button-popup-content.button-popup-content-{{ID}} .mfp-close:hover',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color'      => [
                        'label'     => esc_html__('Background Color', 'westio'),
                        'selectors' => [
                            '{{SELECTOR}}' => 'background-color: {{VALUE}} !important;',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'button_close_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '.button-popup-content.button-popup-content-{{ID}} .mfp-close:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'close_border',
                'selector'  => '.button-popup-content.button-popup-content-{{ID}} .mfp-close',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'close_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '.button-popup-content.button-popup-content-{{ID}} .mfp-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_close_box_shadow',
                'selector' => '.button-popup-content.button-popup-content-{{ID}} .mfp-close',
            ]
        );

        $this->add_responsive_control(
            'close_text_padding',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '.button-popup-content.button-popup-content-{{ID}} .mfp-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('wrapper', 'class', 'westio-button-popup');
        $this->add_render_attribute('button', [
            'class'       => [
                'button-popup',
                $settings['effect_button'] == 'yes' ? 'elementor-button' : '',
            ],
            'href'        => [
                '#westio-button-popup-' . esc_attr($this->get_id())
            ],
            'role'        => [
                'button'
            ],
            'data-effect' => [
                $settings['zoom_effect']
            ]
        ]);

        $this->add_render_attribute('popup', [
            'class' => [
                'mfp-hide',
                'button-popup-content',
                'button-popup-content-' . $this->get_id()
            ],
            'id'    => [
                'westio-button-popup-' . $this->get_id()
            ]
        ]);

        ?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <a <?php $this->print_render_attribute_string('button'); ?>>
                <?php if ($settings['effect_pulse'] == 'yes') : ?>
                    <div class="pulse-dot"></div>
                <?php endif; ?>

                <?php $this->render_text(); ?>
            </a>
        </div>
        <div <?php $this->print_render_attribute_string('popup'); ?>>
            <div class="button-popup-content-inner">
                <div class="button-popup-content-wrapper">
                    <button title="Close (Esc)" type="button" class="mfp-close"><?php $this->render_close(); ?></button>
                    <?php
                    if (!empty($settings['template_id'])) {
                        echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($settings['template_id']);
                    } else {
                        echo esc_html__('No Templates', 'westio');
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php

    }

    protected function render_close() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute(
            [
                'close-button-wrapper' => [
                    'class' => [
                        'elementor-button-content-wrapper',
                        'elementor-align-icon-' . $settings['close_icon_align'],
                    ],
                ]
                ,
                'close-icon-align'     => [
                    'class' => [
                        'elementor-close-button-icon',
                    ],
                ],
                'close-text'           => [
                    'class' => 'elementor-close-button-text',
                ],
            ]);

        $this->add_inline_editing_attributes('text', 'none');
        ?>
        <span <?php $this->print_render_attribute_string('close-button-wrapper'); ?>>
			<?php if (!empty($settings['close_icon']['value'])) : ?>
                <span <?php $this->print_render_attribute_string('close-icon-align'); ?>>
				<?php Elementor\Icons_Manager::render_icon($settings['close_icon'], ['aria-hidden' => 'true']); ?>
			</span>
            <?php endif; ?>
            <?php if (!empty($settings['close_text'])) : ?>
                <span <?php $this->print_render_attribute_string('close-text'); ?>><?php echo esc_html($settings['close_text']); ?></span>
            <?php endif; ?>
		</span>
        <?php
    }

    protected function render_text() {
        $settings = $this->get_settings_for_display();


        $is_new = Elementor\Icons_Manager::is_migration_allowed();
        if (!$is_new && empty($settings['icon_align'])) {
            $settings['icon_align'] = $this->get_settings('icon_align');
        }

        $this->add_render_attribute([
            'content-wrapper' => [
                'class' => [
                    'elementor-button-content-wrapper',
                    'elementor-align-icon-' . $settings['icon_align'],
                ]
            ],
            'icon-align'      => [
                'class' => [
                    'elementor-button-icon',
                ],
            ],
            'text'            => [
                'class' => 'elementor-button-text',
            ],
        ]);

        $this->add_inline_editing_attributes('text', 'none');
        ?>
        <span <?php $this->print_render_attribute_string('content-wrapper'); ?>>
            <?php if (empty($settings['selected_icon']['value']) && empty($settings['text'])) : ?>
                <span class="line-container">
                <span class="line line1"></span>
                <span class="line line2"></span>
            </span>
            <?php endif; ?>

            <?php if (!empty($settings['selected_icon']['value'])) : ?>
                <span <?php $this->print_render_attribute_string('icon-align'); ?>><?php Elementor\Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']); ?></span>
            <?php endif; ?>

            <?php if (!empty($settings['text'])) : ?>
                <span <?php $this->print_render_attribute_string('text'); ?>><?php echo esc_html($settings['text']); ?></span>
            <?php endif; ?>
		</span>
        <?php
    }

}

$widgets_manager->register(new Westio_Elementor_Button_Popup());

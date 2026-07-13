<?php
// Button
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

add_action('elementor/element/button/section_button/after_section_end', function ($element, $args) {
    $default_args = [
        'section_condition' => [],
    ];

    $args = wp_parse_args($args, $default_args);
    $element->update_control(
        'button_type',
        [
            'label' => esc_html__('Type', 'westio'),
            'type' => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => esc_html__('Default', 'westio'),
                'outline' => esc_html__('OutLine', 'westio'),
                'info' => esc_html__('Info', 'westio'),
                'success' => esc_html__('Success', 'westio'),
                'warning' => esc_html__('Warning', 'westio'),
                'danger' => esc_html__('Danger', 'westio'),
                'link' => esc_html__('Link', 'westio'),

            ],
            'prefix_class' => 'elementor-button-',
        ]
    );

    $element->update_control(
        'size',
        [
            'condition' => array_merge( $args['section_condition'], [ 'size[value]!' => '' ] ),
        ]
    );
}, 10, 2);

add_action('elementor/element/button/section_style/before_section_end', function ($element, $args) {

    $element->update_control(
        'background_color',
        [
            'default' => '',
            'global' => ['default' => ''],
        ]
    );

}, 10, 2);

add_action('elementor/element/button/section_style/after_section_end', function ($element, $args) {

    $element->update_control(
        'button_text_color',
        [
            'label' => esc_html__( 'Text Shadow Color', 'westio' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF',
            'selectors' => [
                '{{WRAPPER}} .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
                '{{WRAPPER}} .elementor-button .elementor-button-content-wrapper .elementor-button-text' => 'text-shadow: 0 1.5em 0 {{VALUE}};',
            ],
        ]
    );
    $element->update_control(
        'hover_color',
        [
            'label' => esc_html__( 'Text Color', 'westio' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
                '{{WRAPPER}} .elementor-button:hover svg, {{WRAPPER}} .elementor-button:focus svg' => 'fill: {{VALUE}};',
                '{{WRAPPER}} .elementor-button .elementor-button-content-wrapper .elementor-button-text' => 'text-shadow: 0 1.5em 0 {{VALUE}};',

            ],
        ]
    );

    $element->start_controls_section(
        'button_icon_custom_section',
        [
            'label' => esc_html__('Icon', 'westio'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'selected_icon[value]!' => '',
            ],
        ]
    );

    $element->add_responsive_control(
        'icon_button_size',
        [
            'label' => esc_html__('Icon size', 'westio'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
            'default' => [
                'size' => 16,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button-content-wrapper .elementor-button-icon i:before' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .elementor-button-content-wrapper .elementor-button-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $element->add_responsive_control(
        'icon_size_wrapper',
        [
            'label' => esc_html__('Size Background', 'westio'),
            'type' => Controls_Manager::SLIDER,
            'frontend_available' => true,
            'selectors' => [
                '{{WRAPPER}} .elementor-button-content-wrapper .elementor-button-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $element->add_control(
        'button_icon_radius',
        [
            'label' => esc_html__('Border Radius', 'westio'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .elementor-button-content-wrapper .elementor-button-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $element->start_controls_tabs('color_icon_tabs');
    $element->start_controls_tab('colors_icon_normal',
        [
            'label' => esc_html__('Normal', 'westio'),
        ]
    );

    $element->add_control(
        'icon_button_color',
        [
            'label' => esc_html__('Icon Color', 'westio'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-button-content-wrapper .elementor-button-icon i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .elementor-button-content-wrapper .elementor-button-icon svg' => 'fill: {{VALUE}};',
            ],
        ]
    );

    $element->add_control(
        'icon_button_background_color',
        [
            'label' => esc_html__('Background Icon', 'westio'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-button-content-wrapper .elementor-button-icon' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    $element->end_controls_tab();

    $element->start_controls_tab('colors_icon_hover',
        [
            'label' => esc_html__('Hover', 'westio'),
        ]
    );

    $element->add_control(
        'icon_button_color_hover',
        [
            'label' => esc_html__('Icon Color Hover', 'westio'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-button:hover .elementor-button-icon i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .elementor-button:hover .elementor-button-icon svg' => 'fill: {{VALUE}};',
                '{{WRAPPER}} .elementor-button:focus .elementor-button-icon i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .elementor-button:focus .elementor-button-icon svg' => 'fill: {{VALUE}};',
            ],
        ]
    );

    $element->add_control(
        'icon_button_background_color_hover',
        [
            'label' => esc_html__('Background Icon Hover', 'westio'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-button:hover .elementor-button-icon' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    $element->end_controls_tab();
    $element->end_controls_tabs();
    $element->end_controls_section();
}, 10, 2);

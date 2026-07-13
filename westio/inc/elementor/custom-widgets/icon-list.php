<?php

use Elementor\Controls_Manager;

add_action('elementor/element/icon-list/section_icon_list/before_section_end', function ($element, $args) {
    $element->add_control(
        'effect_line',
        [
            'label'        => esc_html__('Effect', 'westio'),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'no',
            'prefix_class' => 'list-effect-'
        ]
    );

    $element->start_controls_tabs('icon_list_tabs');
    $element->start_controls_tab('icon_list_normal',
        [
            'label' => esc_html__('Normal', 'westio'),
        ]
    );

    $element->add_responsive_control(
        'radius_wrapper',
        [
            'label'      => esc_html__('Border Radius', 'westio'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors'  => [
                '{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $element->add_control(
        'wrapper_background_color',
        [
            'label'     => __('Background Color', 'westio'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    $element->end_controls_tab();

    $element->start_controls_tab('icon_list_hover',
        [
            'label' => esc_html__('Hover', 'westio'),
        ]
    );

    $element->add_responsive_control(
        'radius_wrapper_hover',
        [
            'label'      => esc_html__('Border Radius', 'westio'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors'  => [
                '{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $element->add_control(
        'wrapper_background_color_hover',
        [
            'label'     => __('Background Color', 'westio'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item:hover' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    $element->end_controls_tab();
    $element->end_controls_tabs();

    $element->add_responsive_control(
        'padding_wrapper',
        [
            'label'      => esc_html__('Padding', 'westio'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'separator'  => 'before',
            'selectors'  => [
                '{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $element->add_responsive_control(
        'margin_wrapper',
        [
            'label'      => esc_html__('Margin', 'westio'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors'  => [
                '{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

}, 10, 2);

add_action('elementor/element/icon-list/section_text_style/before_section_end', function ($element, $args) {

    $element->add_control(
        'effect_pulse',
        [
            'label'        => esc_html__('Effect Pulse', 'westio'),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'no',
            'prefix_class' => 'effect-pulse-'
        ]
    );

    $element->add_control(
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

    $element->update_control(
        'text_color',
        [
            'selectors' => [
                '{{WRAPPER}}' => '--icon-list-text-color: {{VALUE}};',
            ],
        ]
    );

    $element->update_control(
        'text_color_hover',
        [
            'selectors' => [
                '{{WRAPPER}}' => '--icon-list-text-color-hover: {{VALUE}};',
            ],
        ]
    );
}, 10, 2);
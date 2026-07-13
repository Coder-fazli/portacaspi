<?php
// Image Box
use Elementor\Controls_Manager;

add_action('elementor/element/image-box/section_style_box/before_section_end', function ($element, $args) {
    $element->add_control(
        'effect',
        [
            'label'        => esc_html__('Use Effect Hover', 'westio'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'westio'),
            'label_off'    => esc_html__('No', 'westio'),
            'return_value' => 'yes',
            'default'      => 'yes',
            'prefix_class' => 'effects-',
            'condition'    => [
                'link[url]!' => '',
            ],
        ]
    );

    $element->add_control(
        'effect_color',
        [
            'label'     => esc_html__('Effect Color', 'westio'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.effects-yes .elementor-image-box-content .elementor-image-box-title a:before' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'effect!' => '',
            ],
        ]
    );

}, 10, 2);

add_action('elementor/element/image-box/section_style_image/before_section_end', function ($element, $args) {
    $element->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name'     => 'box_shadow',
            'selector' => '{{WRAPPER}} .elementor-image-box-img img',
        ]
    );
}, 10, 2);

add_action('elementor/element/image-box/section_style_content/before_section_end', function ($element, $args) {
    $element->update_control( 'hover_title_color', [
        'selectors' => [
            '{{WRAPPER}}:hover .elementor-image-box-title' => 'color: {{VALUE}};',
            '{{WRAPPER}}:focus .elementor-image-box-title' => 'color: {{VALUE}};',
        ],
    ] );
}, 10, 2);
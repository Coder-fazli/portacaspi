<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Border;

add_action('elementor/element/nested-tabs/section_tabs/before_section_end', function ($element, $args) {
    $default_args = [
        'section_condition' => [],
    ];

    $args          = wp_parse_args($args, $default_args);
    $start_logical = is_rtl() ? 'end' : 'start';
    $end_logical   = is_rtl() ? 'start' : 'end';
    $responsive_variants = [
        'tabs_justify_horizontal',
        'tabs_justify_horizontal_laptop',
        'tabs_justify_horizontal_tablet_extra',
        'tabs_justify_horizontal_tablet',
        'tabs_justify_horizontal_mobile_extra',
        'tabs_justify_horizontal_mobile',
    ];
    foreach ($responsive_variants as $id) {
        if ($element->get_controls($id)) {
            $element->remove_control($id);
        }
    }

    $element->add_responsive_control('tabs_justify_horizontal', [
        'label' => esc_html__('Justify', 'westio'),
        'type'  => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'start' => [
                'title' => esc_html__('Start', 'westio'),
                'icon'  => "eicon-align-$start_logical-h",
            ],
            'center' => [
                'title' => esc_html__('Center', 'westio'),
                'icon'  => 'eicon-align-center-h',
            ],
            'end' => [
                'title' => esc_html__('End', 'westio'),
                'icon'  => "eicon-align-$end_logical-h",
            ],
            'stretch' => [
                'title' => esc_html__('Stretch', 'westio'),
                'icon'  => 'eicon-align-stretch-h',
            ],
        ],
        'selectors_dictionary' => [
            'start'   => '--n-tabs-heading-justify-content: flex-start; --n-tabs-title-width: initial; --n-tabs-title-height: initial; --n-tabs-title-align-items: center; --n-tabs-title-flex-grow: 0;',
            'center'  => '--n-tabs-heading-justify-content: center; --n-tabs-title-width: initial; --n-tabs-title-height: initial; --n-tabs-title-align-items: center; --n-tabs-title-flex-grow: 0;',
            'end'     => '--n-tabs-heading-justify-content: flex-end; --n-tabs-title-width: initial; --n-tabs-title-height: initial; --n-tabs-title-align-items: center; --n-tabs-title-flex-grow: 0;',
            'stretch' => '--n-tabs-heading-justify-content: initial; --n-tabs-title-width: 100%; --n-tabs-title-height: initial; --n-tabs-title-align-items: center; --n-tabs-title-flex-grow: 1;',
        ],
        'selectors' => [
            '{{WRAPPER}}' => '{{VALUE}}',
        ],
        'condition' => [
            'tab_background_style!' => 'yes',
            'tabs_direction' => [ '', 'block-start', 'block-end', 'top', 'bottom' ],
        ],
        'frontend_available' => true,
    ]);

    $element->update_control('title_alignment', [
        'condition' => array_merge(
            $args['section_condition'],
            [ 'tab_background_style!' => [ 'yes' ] ]
        ),
    ]);

    $element->update_control('tabs_direction', [
        'condition' => array_merge(
            $args['section_condition'],
            [ 'tab_background_style!' => [ 'yes' ] ]
        ),
    ]);

    $element->add_responsive_control('align_caption', [
        'label'   => esc_html__('Alignment Info', 'westio'),
        'type'    => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
            'left' => [
                'title' => esc_html__('Left', 'westio'),
                'icon'  => 'eicon-h-align-left',
            ],
            'center' => [
                'title' => esc_html__('Center', 'westio'),
                'icon'  => 'eicon-h-align-center',
            ],
            'right' => [
                'title' => esc_html__('Right', 'westio'),
                'icon'  => 'eicon-h-align-right',
            ],
        ],
        'prefix_class' => 'elementor%s-align-',
        'condition' => [
            'tab_background_style' => 'yes',
        ],
    ]);

    if ( ! $element->get_controls('tab_background_style') ) {
        $element->add_control('tab_background_style', [
            'label'        => esc_html__('Style Background', 'westio'),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'no',
            'prefix_class' => 'style-background-',
        ]);
    }
}, 10, 2);

add_action('elementor/element/nested-tabs/section_tabs_style/before_section_end', function ($element, $args) {
    $controls_to_update = [
        'tabs_title_background_color_active_color' => [
            '{{WRAPPER}}.elementor-widget-n-tabs > .e-n-tabs > .e-n-tabs-heading > .e-n-tab-title[aria-selected="true"], 
             {{WRAPPER}}.elementor-widget-n-tabs > .e-n-tabs[data-touch-mode="true"] > .e-n-tabs-heading > .e-n-tab-title[aria-selected="false"]:hover'
            => 'background-color: {{VALUE}} !important;',
        ],
        'tabs_title_background_color_hover_color' => [
            '{{WRAPPER}}.elementor-widget-n-tabs > .e-n-tabs[data-touch-mode="false"] > .e-n-tabs-heading > .e-n-tab-title[aria-selected="false"]:hover'
            => 'background-color: {{VALUE}} !important;',
        ],
    ];

    foreach ( $controls_to_update as $control_id => $selectors ) {
        if ( $element->get_controls( $control_id ) ) {
            $element->update_control( $control_id, [
                'selectors' => $selectors,

            ] );
        }
    }

    $element->add_responsive_control(
        'tabs_background_color',
        [
            'label'     => esc_html__('Background Color', 'westio'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}}.style-background-yes .e-n-tabs-heading' => 'background-color: {{VALUE}};',
            ],
            'condition' => [
                'tab_background_style' => 'yes',
            ],
        ]
    );
    $element->add_control(
        'backdrop_blur_background_tab',
        [
            'label' => esc_html__('Backdrop Blur', 'westio'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}}.style-background-yes .e-n-tabs-heading' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
            ],
            'condition' => [
                'tab_background_style' => 'yes',
            ],
        ]
    );

    $element->add_responsive_control(
        'border_radius_tab_background',
        [
            'label'      => esc_html__('Border Radius', 'westio'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem', 'custom'],
            'selectors'  => [
                '{{WRAPPER}}.style-background-yes .e-n-tabs-heading' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'tab_background_style' => 'yes',
            ],
        ]

    );
    $element->add_control(
        'tab_translate_mode',
        [
            'label' => esc_html__('Translate Mode', 'westio'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'transform',
            'options' => [
                'transform' => esc_html__('Transform', 'westio'),
                'position'  => esc_html__('Position', 'westio'),
                'margin'    => esc_html__('Margin', 'westio'),
            ],
            'prefix_class' => 'translate-mode-',
            'condition' => [
                'tab_background_style' => 'yes',
            ],
        ]
    );
    $element->add_responsive_control(
        'tab_translate_x',
        [
            'label'      => esc_html__('Translate X', 'westio'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'range'      => [
                'px' => [ 'min' => -500, 'max' => 500 ],
                '%'  => [ 'min' => -100, 'max' => 100 ],
                'vw' => [ 'min' => -100, 'max' => 100 ],
            ],
            'size_units' => ['px', '%', 'vw'],
            'selectors'  => [
                '{{WRAPPER}}.style-background-yes.translate-mode-transform .e-n-tabs-heading' => 'transform: translateX({{SIZE}}{{UNIT}});',
                '{{WRAPPER}}.style-background-yes.translate-mode-position .e-n-tabs-heading'
                => 'position: absolute; left: 50%; transform: translateX(calc(-50% + {{SIZE}}{{UNIT}}));',
                '{{WRAPPER}}.style-background-yes.translate-mode-margin .e-n-tabs-heading'    => 'margin-left: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'tab_background_style' => 'yes',
            ],
        ]
    );
    $element->add_responsive_control(
        'tab_translate_y',
        [
            'label'      => esc_html__('Translate Y', 'westio'),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'range'      => [
                'px' => [ 'min' => -500, 'max' => 500 ],
                '%'  => [ 'min' => -100, 'max' => 100 ],
                'vh' => [ 'min' => -100, 'max' => 100 ],
            ],
            'size_units' => ['px', '%', 'vh'],
            'selectors'  => [
                '{{WRAPPER}}.style-background-yes.translate-mode-transform .e-n-tabs-heading' => 'transform: translateY({{SIZE}}{{UNIT}});',
                '{{WRAPPER}}.style-background-yes.translate-mode-position .e-n-tabs-heading'  => 'position: absolute; top: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}.style-background-yes.translate-mode-margin .e-n-tabs-heading'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'tab_background_style' => 'yes',
            ],
        ]
    );
    $element->add_group_control(
        Group_Control_Border::get_type(),
        [
            'name'        => 'wrapper_tab_border',
            'placeholder' => '1px',
            'default'     => '1px',
            'selector'    => '{{WRAPPER}}.style-background-yes .e-n-tabs-heading',
            'separator'   => 'before',
        ]
    );
    $element->add_responsive_control(
        'padding_tab_heading',
        [
            'label'      => esc_html__('Padding Heading', 'westio'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors'  => [
                '{{WRAPPER}}.style-background-yes .e-n-tabs-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'tab_background_style' => 'yes',
            ],
        ]
    );

}, 10, 2);


add_action('elementor/element/nested-tabs/section_title_style/after_section_start', function ($element, $args) {

    $element->add_control(
        'effect_line',
        [
            'label'        => esc_html__('Effect', 'westio'),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'no',
            'prefix_class' => 'tabs-effect-'
        ]
    );
}, 10, 2);
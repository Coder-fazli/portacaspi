<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

trait Westio_Carousel_Trait {
    protected function add_control_carousel( $condition_value = [], $condition_key = 'condition' ) {
        $this->start_controls_section(
            'section_carousel_options',
            [
                'label'        => esc_html__( 'Carousel Options', 'westio' ),
                'type'         => Controls_Manager::SECTION,
                $condition_key => $condition_value
            ]
        );

        $slides_to_show = range( 1, 10 );
        $slides_to_show = array_combine( $slides_to_show, $slides_to_show );

        $this->add_responsive_control(
            'slides_to_show',
            [
                'label'              => esc_html__( 'Slides to Show', 'westio' ),
                'type'               => Controls_Manager::TEXT,
                'frontend_available' => true,
                'default'            => 3,
                'render_type'        => 'template',
                'selectors'          => [
                    '{{WRAPPER}} .swiper:not(.swiper-initialized) .swiper-slide' => 'width: calc((100% - {{spaceBetween.SIZE}}{{spaceBetween.UNIT}}*({{VALUE}} - 1)) / {{VALUE}}); margin-right:{{spaceBetween.SIZE}}{{spaceBetween.UNIT}}',
                ],
                'condition'          => [
                    'direction' => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'slides_to_scroll',
            [
                'label'              => esc_html__( 'Slides to Scroll', 'westio' ),
                'type'               => Controls_Manager::SELECT,
                'description'        => esc_html__( 'Set how many slides are scrolled per swipe.', 'westio' ),
                'options'            => [
                                            '' => esc_html__( 'Default', 'westio' ),
                                        ] + $slides_to_show,
                'frontend_available' => true,
                'condition'          => [
                    'slides_to_show!' => '1',
                    'direction'       => ''
                ],
            ]
        );

        $this->add_responsive_control(
            'spaceBetween',
            [
                'label'              => esc_html__( 'Space Between', 'westio' ),
                'type'               => Controls_Manager::SLIDER,
                'range'              => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'default'            => [
                    'size' => 30
                ],
                'size_units'         => [ 'px' ],
                'render_type'        => 'template',
                'selectors'          => [
                    '{{WRAPPER}} .products' => '--gutter-width: {{SIZE}}{{UNIT}};',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'swiper_overflow',
            [
                'label'              => esc_html__( 'Overflow', 'westio' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'none',
                'options'            => [
                    'none'  => esc_html__( 'None', 'westio' ),
                    'left'  => esc_html__( 'Overflow to the left', 'westio' ),
                    'right' => esc_html__( 'Overflow to the right', 'westio' ),
                    'both'  => esc_html__( 'Visible both', 'westio' ),
                ],
                'frontend_available' => true,
                'prefix_class'       => 'overflow-to-',
            ]
        );


        $this->add_control(
            'navigation',
            [
                'label'              => esc_html__( 'Navigation', 'westio' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'none',
                'options'            => [
                    'both'   => esc_html__( 'Arrows and Dots', 'westio' ),
                    'arrows' => esc_html__( 'Arrows', 'westio' ),
                    'dots'   => esc_html__( 'Dots', 'westio' ),
                    'none'   => esc_html__( 'None', 'westio' ),
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'style_dot',
            [
                'label'              => esc_html__( 'Dots Type', 'westio' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'bullets',
                'options'            => [
                    'bullets'  => esc_html__( 'Bullets', 'westio' ),
                    'fraction' => esc_html__( 'Fraction', 'westio' ),
                ],
                'conditions'         => [
                    'relation' => 'or',
                    'terms'    => [
                        [
                            'name'     => 'navigation',
                            'operator' => '==',
                            'value'    => 'both',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '==',
                            'value'    => 'dots',
                        ],
                    ],
                ],
                'frontend_available' => true,
            ]
        );
        $this->add_control( 'custom_navigation',
            [
                'label'              => esc_html__( 'Custom Navigation', 'westio' ),
                'type'               => Controls_Manager::SWITCHER,
                'frontend_available' => true,
                'conditions'         => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'enable_carousel',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                        [
                            'relation' => 'or',
                            'terms'    => [
                                [
                                    'name'     => 'navigation',
                                    'operator' => '==',
                                    'value'    => 'both',
                                ],
                                [
                                    'name'     => 'navigation',
                                    'operator' => '==',
                                    'value'    => 'arrows',
                                ],
                            ],
                        ]
                    ],

                ],
            ]
        );
        $this->add_control(
            'custom_navigation_previous',
            [
                'label'              => esc_html__( 'Class Navigation Previous', 'westio' ),
                'type'               => Controls_Manager::TEXT,
                'frontend_available' => true,
                'default'            => 'swiper-button-prev-' . rand(),
                'conditions'         => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'enable_carousel',
                            'operator' => '=',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'custom_navigation',
                            'operator' => '=',
                            'value'    => 'yes',
                        ],
                        [
                            'relation' => 'or',
                            'terms'    => [
                                [
                                    'name'     => 'navigation',
                                    'operator' => '=',
                                    'value'    => 'both',
                                ],
                                [
                                    'name'     => 'navigation',
                                    'operator' => '=',
                                    'value'    => 'bars',
                                ],
                                [
                                    'name'     => 'navigation',
                                    'operator' => '=',
                                    'value'    => 'arrows',
                                ],
                            ],
                        ]
                    ],

                ],
            ]
        );
        $this->add_control(
            'custom_navigation_next',
            [
                'label'              => esc_html__( 'Class Navigation Next', 'westio' ),
                'type'               => Controls_Manager::TEXT,
                'frontend_available' => true,
                'default'            => 'swiper-button-next-' . rand(),
                'conditions'         => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'enable_carousel',
                            'operator' => '=',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'custom_navigation',
                            'operator' => '=',
                            'value'    => 'yes',
                        ],
                        [
                            'relation' => 'or',
                            'terms'    => [
                                [
                                    'name'     => 'navigation',
                                    'operator' => '=',
                                    'value'    => 'both',
                                ],
                                [
                                    'name'     => 'navigation',
                                    'operator' => '=',
                                    'value'    => 'bars',
                                ],
                                [
                                    'name'     => 'navigation',
                                    'operator' => '=',
                                    'value'    => 'arrows',
                                ],
                            ],
                        ]
                    ],

                ],
            ]
        );

        $this->add_control(
            'navigation_previous_icon',
            [
                'label'            => esc_html__( 'Previous Arrow Icon', 'westio' ),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin'             => 'inline',
                'label_block'      => false,
                'skin_settings'    => [
                    'inline' => [
                        'none' => [
                            'label' => 'Default',
                            'icon'  => is_rtl() ? 'eicon-angle-right' : 'eicon-angle-left',
                        ],
                        'icon' => [
                            'icon' => 'eicon-star',
                        ],
                    ],
                ],
                'recommended'      => [
                    'fa-regular' => [
                        'arrow-alt-circle-left',
                        'caret-square-left',
                    ],
                    'fa-solid'   => [
                        'angle-double-left',
                        'angle-left',
                        'arrow-alt-circle-left',
                        'arrow-circle-left',
                        'arrow-left',
                        'caret-left',
                        'caret-square-left',
                        'angle-circle-left',
                        'angle-left',
                        'long-arrow-alt-left',
                    ],
                ],
                'conditions'       => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'enable_carousel',
                            'operator' => '=',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'custom_navigation',
                            'operator' => '!=',
                            'value'    => 'yes',
                        ],
                        [
                            'relation' => 'or',
                            'terms'    => [
                                [
                                    'name'     => 'navigation',
                                    'operator' => '=',
                                    'value'    => 'both',
                                ],
                                [
                                    'name'     => 'navigation',
                                    'operator' => '=',
                                    'value'    => 'bars',
                                ],
                                [
                                    'name'     => 'navigation',
                                    'operator' => '=',
                                    'value'    => 'arrows',
                                ],
                            ],
                        ]
                    ],

                ],
            ]
        );

        $this->add_control(
            'navigation_next_icon',
            [
                'label'            => esc_html__( 'Next Arrow Icon', 'westio' ),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin'             => 'inline',
                'label_block'      => false,
                'skin_settings'    => [
                    'inline' => [
                        'none' => [
                            'label' => 'Default',
                            'icon'  => is_rtl() ? 'eicon-angle-left' : 'eicon-angle-right',
                        ],
                        'icon' => [
                            'icon' => 'eicon-star',
                        ],
                    ],
                ],
                'recommended'      => [
                    'fa-regular' => [
                        'arrow-alt-circle-right',
                        'caret-square-right',
                    ],
                    'fa-solid'   => [
                        'angle-double-right',
                        'angle-right',
                        'arrow-alt-circle-right',
                        'arrow-circle-right',
                        'arrow-right',
                        'caret-right',
                        'caret-square-right',
                        'angle-circle-right',
                        'angle-right',
                        'long-arrow-alt-right',
                    ],
                ],
                'conditions'       => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'enable_carousel',
                            'operator' => '=',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'custom_navigation',
                            'operator' => '!=',
                            'value'    => 'yes',
                        ],
                        [
                            'relation' => 'or',
                            'terms'    => [
                                [
                                    'name'     => 'navigation',
                                    'operator' => '=',
                                    'value'    => 'both',
                                ],
                                [
                                    'name'     => 'navigation',
                                    'operator' => '=',
                                    'value'    => 'bars',
                                ],
                                [
                                    'name'     => 'navigation',
                                    'operator' => '=',
                                    'value'    => 'arrows',
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->add_control('center',
            [
                'label'              => esc_html__('Center', 'westio'),
                'type'               => Controls_Manager::SWITCHER,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'enable_scrollbar',
            [
                'label'              => esc_html__( 'Scrollbar', 'westio' ),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => 'no',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'allowTouchMove',
            [
                'label'              => esc_html__( 'Allow Touch Move', 'westio' ),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => 'yes',
                'frontend_available' => true,
            ]
        );


        $this->add_responsive_control(
            'with_scrollbar',
            [
                'label'              => esc_html__( 'With Scrollbar', 'westio' ),
                'type'               => Controls_Manager::SLIDER,
                'size_units'         => [ '%', 'custom' ],
                'range'              => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'            => [
                    'size' => 100
                ],
                'condition'          => [
                    'enable_scrollbar' => 'yes',
                ],
                'frontend_available' => true,
                'selectors'          => [
                    '{{WRAPPER}} .swiper-scrollbar' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'spacing_scrollbar',
            [
                'label'      => esc_html__( 'Spacing scrollbar', 'westio' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [
                        'min'  => - 1000,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => - 100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => '',
                ],

                'condition'          => [
                    'enable_scrollbar' => 'yes',
                ],
                'frontend_available' => true,
                'selectors'          => [
                    '{{WRAPPER}} .swiper-scrollbar' => 'bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_additional_options',
            [
                'label'        => esc_html__( 'Additional Options', 'westio' ),
                $condition_key => $condition_value
            ]
        );

        $this->add_control(
            'lazyload',
            [
                'label'              => esc_html__( 'Lazyload', 'westio' ),
                'type'               => Controls_Manager::SWITCHER,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'mousewheel',
            [
                'label'              => esc_html__( 'Mousewheel control', 'westio' ),
                'type'               => Controls_Manager::SWITCHER,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoheight',
            [
                'label'              => esc_html__( 'Auto Height', 'westio' ),
                'type'               => Controls_Manager::SWITCHER,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'              => esc_html__( 'Autoplay', 'westio' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'yes',
                'options'            => [
                    'yes' => esc_html__( 'Yes', 'westio' ),
                    'no'  => esc_html__( 'No', 'westio' ),
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'              => esc_html__( 'Pause on Hover', 'westio' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'yes',
                'options'            => [
                    'yes' => esc_html__( 'Yes', 'westio' ),
                    'no'  => esc_html__( 'No', 'westio' ),
                ],
                'condition'          => [
                    'autoplay' => 'yes',
                ],
                'render_type'        => 'none',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'pause_on_interaction',
            [
                'label'              => esc_html__( 'Pause on Interaction', 'westio' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'yes',
                'options'            => [
                    'yes' => esc_html__( 'Yes', 'westio' ),
                    'no'  => esc_html__( 'No', 'westio' ),
                ],
                'condition'          => [
                    'autoplay' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'              => esc_html__( 'Autoplay Speed', 'westio' ),
                'type'               => Controls_Manager::NUMBER,
                'default'            => 5000,
                'condition'          => [
                    'autoplay' => 'yes',
                ],
                'render_type'        => 'none',
                'frontend_available' => true,
            ]
        );

        // Loop requires a re-render so no 'render_type = none'
        $this->add_control(
            'infinite',
            [
                'label'              => esc_html__( 'Infinite Loop', 'westio' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'yes',
                'options'            => [
                    'yes' => esc_html__( 'Yes', 'westio' ),
                    'no'  => esc_html__( 'No', 'westio' ),
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'effect',
            [
                'label'              => esc_html__( 'Effect', 'westio' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'slide',
                'options'            => [
                    'slide' => esc_html__( 'Slide', 'westio' ),
                    'fade'  => esc_html__( 'Fade', 'westio' ),
                ],
                'condition'          => [
                    'slides_to_show' => '1',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'speed',
            [
                'label'              => esc_html__( 'Animation Speed', 'westio' ),
                'type'               => Controls_Manager::NUMBER,
                'default'            => 1000,
                'render_type'        => 'none',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'direction',
            [
                'label'              => esc_html__( 'Direction', 'westio' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => '',
                'frontend_available' => true,
                'options'            => [
                    ''         => esc_html__( 'Horizontal', 'westio' ),
                    'vertical' => esc_html__( 'Vertical', 'westio' ),
                ],
            ]
        );

        $this->add_control(
            'rtl',
            [
                'label'     => esc_html__( 'Direction Right/Left', 'westio' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'ltr',
                'condition' => [
                    'direction' => ''
                ],
                'options'   => [
                    'ltr' => esc_html__( 'Left', 'westio' ),
                    'rtl' => esc_html__( 'Right', 'westio' ),
                ],
            ]
        );

        $this->end_controls_section();

        $this->register_controls_navigation();
        $this->register_controls_dots();
    }

    protected function register_controls_dots() {
        $this->start_controls_section(
            'carousel_dots',
            [
                'label'      => esc_html__( 'Carousel Dots', 'westio' ),
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'enable_carousel',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'none',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'arrows',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'dots_position',
            [
                'label'        => esc_html__( 'Position', 'westio' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'outside',
                'options'      => [
                    'outside' => esc_html__( 'Outside', 'westio' ),
                    'inside'  => esc_html__( 'Inside', 'westio' ),
                ],
                'prefix_class' => 'elementor-pagination-position-',
                'condition'    => [
                    'navigation' => [ 'dots', 'both' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_alignment',
            [
                'label'     => esc_html__( 'Alignment', 'westio' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'westio' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'westio' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'westio' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'text-align: {{VALUE}};'
                ],
                'condition' => [
                    'direction' => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_padding',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_radius',
            [
                'label'      => esc_html__('Border Radius', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_size',
            [
                'label'     => esc_html__( 'Size', 'westio' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 5,
                        'max' => 40,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullets'  => '--swiper-pagination-bullet-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-pagination-fraction' => '--swiper-pagination-bullet-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_gap',
            [
                'label'     => esc_html__( 'Gap', 'westio' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 5,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullets' => '--swiper-pagination-bullet-horizontal-gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                    'style_dot'  => [ 'bullets' ],
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_carousel_dots_style' );

        $this->start_controls_tab(
            'tab_carousel_dots_normal',
            [
                'label' => esc_html__( 'Normal', 'westio' ),
            ]
        );

        $this->add_control(
            'carousel_dots_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'westio' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-wrapper'   => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dots_color',
            [
                'label'     => esc_html__( 'Color', 'westio' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet'   => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination-fraction' => '--swiper-pagination-bullet-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dots_opacity',
            [
                'label'     => esc_html__( 'Opacity', 'westio' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'opacity: {{SIZE}};',
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                    'style_dot'  => [ 'bullets' ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_carousel_dots_hover',
            [
                'label' => esc_html__( 'Hover', 'westio' ),
            ]
        );

        $this->add_control(
            'carousel_dots_color_hover',
            [
                'label'     => esc_html__( 'Color Hover', 'westio' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination-bullet:focus' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                    'style_dot'  => [ 'bullets' ],
                ],
            ]
        );

        $this->add_control(
            'carousel_dots_opacity_hover',
            [
                'label'     => esc_html__( 'Opacity', 'westio' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet:hover' => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .swiper-pagination-bullet:focus' => 'opacity: {{SIZE}};',
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                    'style_dot'  => [ 'bullets' ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_carousel_dots_activate',
            [
                'label' => esc_html__( 'Activate', 'westio' ),
            ]
        );

        $this->add_control(
            'carousel_dots_color_activate',
            [
                'label'     => esc_html__( 'Color', 'westio' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                    'style_dot'  => [ 'bullets' ],
                ],
            ]
        );

        $this->add_control(
            'carousel_dots_opacity_activate',
            [
                'label'     => esc_html__( 'Opacity', 'westio' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'opacity: {{SIZE}};',
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                    'style_dot'  => [ 'bullets' ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'dots_vertical_value',
            [
                'label'      => esc_html__( 'Spacing vertical', 'westio' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [
                        'min'  => - 1000,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => - 100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => '',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .swiper-pagination'                                      => 'bottom: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .swiper~.swiper-pagination.swiper-pagination-horizontal' => 'bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_horizontal_value',
            [
                'label'      => esc_html__( 'Spacing horizontal', 'westio' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [
                        'min'  => - 1000,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => - 100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => '',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .swiper-pagination-vertical'   => 'right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-pagination-horizontal' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function register_controls_navigation() {
        $this->start_controls_section(
            'section_style_navigation',
            [
                'label'      => esc_html__( 'Carousel Navigation', 'westio' ),
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'enable_carousel',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'none',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'dots',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'heading_style_arrows',
            [
                'label'     => esc_html__( 'Arrows', 'westio' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_size',
            [
                'label'     => esc_html__( 'Size', 'westio' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button i,
                    {{WRAPPER}} .elementor-swiper-button svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_width',
            [
                'label'      => esc_html__( 'Width', 'westio' ),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'unit' => 'px',
                ],
                'size_units' => [ '%', 'px', 'vw' ],
                'range'      => [
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_height',
            [
                'label'      => esc_html__( 'Height', 'westio' ),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'unit' => 'px',
                ],
                'size_units' => [ '%', 'px', 'vw' ],
                'range'      => [
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(

            Group_Control_Border::get_type(),
            [
                'name'      => 'arrows_border',
                'selector'  => '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'arrows_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'westio' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'arrows_tabs' );

        $this->start_controls_tab( 'arrows_normal',
            [
                'label' => esc_html__( 'Normal', 'westio' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'arrows_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next',
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label'     => esc_html__( 'Color', 'westio' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next'         => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev svg, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );

        $this->add_control(
            'arrows_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'westio' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'arrows_hover',
            [
                'label' => esc_html__( 'Hover', 'westio' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'arrows_box_shadow_hover',
                'selector' => '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev:hover, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next:hover',
            ]
        );

        $this->add_control(
            'arrows_color_hover',
            [
                'label'     => esc_html__( 'Color', 'westio' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev:hover, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next:hover'         => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev:hover svg, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next:hover svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );

        $this->add_control(
            'arrows_background_color_hover',
            [
                'label'     => esc_html__( 'Background Color', 'westio' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev:hover, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );

        $this->add_control(
            'arrows_border_color_hover',
            [
                'label'     => esc_html__( 'Border Color', 'westio' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev:hover, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'arrows_next_heading',
            [
                'label'     => esc_html__( 'Next button', 'westio' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );

        $this->add_control(
            'arrows_next_vertical',
            [
                'label'        => esc_html__( 'Next Vertical', 'westio' ),
                'type'         => Controls_Manager::CHOOSE,
                'label_block'  => false,
                'options'      => [
                    'top'    => [
                        'title' => esc_html__( 'Top', 'westio' ),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'bottom' => [
                        'title' => esc_html__( 'Bottom', 'westio' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'prefix_class' => 'elementor-swiper-button-next-vertical-',
                'condition'    => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_next_vertical_value',
            [
                'type'       => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [
                        'min'  => - 1000,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => - 100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'top: unset; bottom: unset; {{arrows_next_vertical.value}}: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'navigation'           => [ 'arrows', 'both' ],
                    'arrows_next_vertical' => [ 'top', 'bottom' ],
                ],
            ]
        );

        $this->add_control(
            'arrows_next_horizontal',
            [
                'label'        => esc_html__( 'Next Horizontal', 'westio' ),
                'type'         => Controls_Manager::CHOOSE,
                'label_block'  => false,
                'options'      => [
                    'left'  => [
                        'title' => esc_html__( 'Left', 'westio' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'westio' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'elementor-swiper-button-next-horizontal-',
                'condition'    => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );
        $this->add_responsive_control(
            'next_horizontal_value',
            [
                'type'       => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => [ 'px', 'em', '%' ],
                'range'      => [
                    'px' => [
                        'min'  => - 1000,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => - 100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => - 45,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'left: unset; right: unset;{{arrows_next_horizontal.value}}: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'navigation'             => [ 'arrows', 'both' ],
                    'arrows_next_horizontal' => [ 'left', 'right' ],
                ],

            ]
        );

        $this->add_control(
            'arrows_prev_heading',
            [
                'label'     => esc_html__( 'Prev button', 'westio' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );

        $this->add_control(
            'arrows_prev_vertical',
            [
                'label'        => esc_html__( 'Prev Vertical', 'westio' ),
                'type'         => Controls_Manager::CHOOSE,
                'label_block'  => false,
                'render_type'  => 'ui',
                'options'      => [
                    'top'    => [
                        'title' => esc_html__( 'Top', 'westio' ),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'bottom' => [
                        'title' => esc_html__( 'Bottom', 'westio' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'prefix_class' => 'elementor-swiper-button-prev-vertical-',
                'condition'    => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_prev_vertical_value',
            [
                'type'       => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [
                        'min'  => - 1000,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => - 100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev' => 'top: unset; bottom: unset; {{arrows_prev_vertical.value}}: {{SIZE}}{{UNIT}};',
                ],

                'condition' => [
                    'navigation'           => [ 'arrows', 'both' ],
                    'arrows_prev_vertical' => [ 'top', 'bottom' ],
                ],
            ]
        );

        $this->add_control(
            'arrows_prev_horizontal',
            [
                'label'        => esc_html__( 'Prev Horizontal', 'westio' ),
                'type'         => Controls_Manager::CHOOSE,
                'label_block'  => false,
                'options'      => [
                    'left'  => [
                        'title' => esc_html__( 'Left', 'westio' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'westio' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'elementor-swiper-button-prev-horizontal-',
                'condition'    => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );
        $this->add_responsive_control(
            'arrows_prev_horizontal_value',
            [
                'type'       => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => [ 'px', 'em', '%' ],
                'range'      => [
                    'px' => [
                        'min'  => - 1000,
                        'max'  => 1000,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => - 100,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev' => 'left: unset; right: unset; {{arrows_prev_horizontal.value}}: {{SIZE}}{{UNIT}};',
                ],

                'condition' => [
                    'navigation'             => [ 'arrows', 'both' ],
                    'arrows_prev_horizontal' => [ 'left', 'right' ],
                ],
            ]
        );

        $this->end_controls_section();
    }


    public function render_swiper_pagination_navigation() {
        $settings = $this->get_settings_for_display();
        if ( $settings['enable_carousel'] != 'yes' ) {
            return;
        }
        $show_dots   = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
        $show_arrows = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );
        if ( $settings['enable_scrollbar'] === 'yes' ) {
            ?>
            <div class="swiper-scrollbar swiper-scrollbar-<?php echo esc_attr( $this->get_id() ) ?>"></div>
            <?php
        }
        if ( $show_dots ) : ?>
            <div class="swiper-pagination swiper-pagination-<?php echo esc_attr( $this->get_id() ) ?>"></div>
        <?php endif; ?>
        <?php if ( $show_arrows && $settings['custom_navigation'] != 'yes' ) : ?>
            <div class="elementor-swiper-button elementor-swiper-button-prev elementor-swiper-button-prev-<?php echo esc_attr( $this->get_id() ) ?>" role="button" tabindex="0">
                <?php $this->render_swiper_button( 'previous' ); ?>
                <span class="elementor-screen-only"><?php echo esc_html__( 'Previous', 'westio' ); ?></span>
            </div>
            <div class="elementor-swiper-button elementor-swiper-button-next elementor-swiper-button-next-<?php echo esc_attr( $this->get_id() ) ?>" role="button" tabindex="0">
                <?php $this->render_swiper_button( 'next' ); ?>
                <span class="elementor-screen-only"><?php echo esc_html__( 'Next', 'westio' ); ?></span>
            </div>
        <?php endif;
    }

    protected function render_swiper_button( $type, $html = false ) {
        $direction     = 'next' === $type ? 'right' : 'left';
        $icon_settings = $this->get_settings_for_display( 'navigation_' . $type . '_icon' );

        if ( empty( $icon_settings['value'] ) ) {
            $icon_settings = [
                'library' => 'eicons',
                'value'   => 'eicon-angle-' . $direction,
            ];
        }

        if ( $html === true ) {
            return Icons_Manager::try_get_icon_html( $icon_settings, [ 'aria-hidden' => 'true' ] );
        }
        Icons_Manager::render_icon( $icon_settings, [ 'aria-hidden' => 'true' ] );
    }

    protected function get_data_elementor_carousel() {
        $settings             = $this->get_settings_for_display();
        $enable_carousel      = $settings['enable_carousel'] === 'yes';
        $has_autoplay_enabled = 'yes' === $this->get_settings_for_display( 'autoplay' );
        $class                = $settings['slides_to_show'] == 'auto' ? 'swiper-autowidth' : '';
        if ( $enable_carousel ) {
            $this->add_render_attribute( [
                'container' => [
                    'class' => 'westio-swiper swiper ' . $class,
                    'dir'   => $settings['rtl'] ?: 'ltr',
                ],
                'inner'     => [
                    'class'     => 'swiper-wrapper',
                    'aria-live' => $has_autoplay_enabled ? 'off' : 'polite',
                ],
                'item'      => [
                    'class' => 'swiper-slide',
                ],
            ] );
            $this->remove_render_attribute( 'inner', 'class', 'elementor-grid' );
        }
    }

    protected function get_data_elementor_carousel_product() {
        $settings             = $this->get_settings_for_display();
        $enable_carousel      = $settings['enable_carousel'] === 'yes';
        $has_autoplay_enabled = 'yes' === $this->get_settings_for_display( 'autoplay' );
        $class                = $settings['slides_to_show'] == 'auto' ? 'swiper-autowidth' : '';
        if ( $enable_carousel ) {
            $this->add_render_attribute( [
                'container' => [
                    'class' => 'westio-swiper swiper ' . $class,
                    'dir'   => $settings['rtl'] ?: 'ltr',
                ],
                'inner'     => [
                    'class'     => 'swiper-wrapper',
                    'aria-live' => $has_autoplay_enabled ? 'off' : 'polite',
                ],
                'item'      => [
                    'class' => 'swiper-slide',
                ],
            ] );
            $this->remove_render_attribute( 'inner', 'class', 'elementor-grid' );
        }
    }
}
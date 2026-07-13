<?php

namespace Westio\Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

abstract class Westio_Base_Widgets extends Widget_Base {
    /**
     * Register column widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function get_controls_column( $condition = array() ) {
        $column = range( 1, 10 );
        $column = array_combine( $column, $column );
        $this->start_controls_section(
            'section_column_options',
            [
                'label'     => esc_html__( 'Column Options', 'westio' ),
                'condition' => $condition,
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'              => esc_html__( 'Columns', 'westio' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 4,
                'options'            => [
                                            '' => esc_html__( 'Default', 'westio' ),
                                        ] + $column,
                'frontend_available' => true,
                'render_type'        => 'template',
                'prefix_class'       => 'elementor-grid%s-',
                'selectors'          => [
                    '{{WRAPPER}}' => '--e-global-column-to-show: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'column_spacing',
            [
                'label'              => esc_html__( 'Column Spacing', 'westio' ),
                'type'               => Controls_Manager::SLIDER,
                'range'              => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default'            => [
                    'size' => 30,
                ],
                'frontend_available' => true,
                'selectors'          => [
                    '{{WRAPPER}}' => '--grid-column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'row_spacing',
            [
                'label'              => esc_html__( 'Row Spacing', 'westio' ),
                'type'               => Controls_Manager::SLIDER,
                'range'              => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default'            => [
                    'size' => 30,
                ],
                'frontend_available' => true,
                'selectors'          => [
                    '{{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register style column widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function get_control_style_column( $atts = array() ) {
        $selectors = isset( $atts['selectors'] ) ? $atts['selectors'] : '.item-inner';
        $prefix    = isset( $atts['name'] ) ? $atts['name'] : 'item';
        $this->start_controls_section(
            'section_' . $prefix . '_style',
            [
                'label' => ucfirst( $prefix ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            $prefix . '_padding',
            [
                'label'      => esc_html__( 'Padding', 'westio' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selectors => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            $prefix . '_margin',
            [
                'label'      => esc_html__( 'Margin', 'westio' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selectors => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => $prefix . '_background',
                'selector' => '{{WRAPPER}} ' . $selectors,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => $prefix . '_border',
                'selector'  => '{{WRAPPER}} ' . $selectors,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            $prefix . '_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'westio' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selectors => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => $prefix . '_box_shadow',
                'selector' => '{{WRAPPER}} ' . $selectors,
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register Carousel widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function get_control_carousel( $condition = array() ) {

        $this->get_control_carousel_options( $condition );
        $this->get_control_carousel_additional( $condition );
        $this->get_control_carousel_style_navigation( $condition );
    }

    /**
     * Register Control Carousel options.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function get_control_carousel_options( $condition ) {
        $this->start_controls_section(
            'section_swiperjs_options',
            [
                'label'     => esc_html__( 'Caroseul Options', 'westio' ),
                'condition' => $condition,
            ]
        );
        $this->add_control(
            'enable_carousel',
            [
                'label' => esc_html__( 'Enable Carousel', 'westio' ),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control( 'center',
            [
                'label'              => esc_html__( 'Center', 'westio' ),
                'type'               => Controls_Manager::SWITCHER,
                'frontend_available' => true,
                'condition'          => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'swiper_overflow',
            [
                'label'              => esc_html__( 'Overflow', 'westio' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'none',
                'options'            => [
                    'none'    => esc_html__( 'None', 'westio' ),
                    'visible' => esc_html__( 'Visible', 'westio' ),
                    'left'    => esc_html__( 'Overflow to the left', 'westio' ),
                    'right'   => esc_html__( 'Overflow to the right', 'westio' ),
                ],
                'frontend_available' => true,
                'prefix_class'       => 'overflow-to-',
                'condition'          => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label'              => esc_html__( 'Navigation', 'westio' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'none',
                'options'            => [
                    'both'         => esc_html__( 'Arrows and Dots', 'westio' ),
                    'bars'         => esc_html__( 'Arrows and Progressbars', 'westio' ),
                    'arrows'       => esc_html__( 'Arrows', 'westio' ),
                    'dots'         => esc_html__( 'Dots', 'westio' ),
                    'progressbars' => esc_html__( 'Progressbars', 'westio' ),
                    'none'         => esc_html__( 'None', 'westio' ),
                ],
                'frontend_available' => true,
                'condition'          => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'style_dot',
            [
                'label'        => esc_html__( 'Style Dot', 'westio' ),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'style-1' => esc_html__( 'Style 1', 'westio' ),
                    'style-2' => esc_html__( 'Style 2', 'westio' ),
                ],
                'default'      => 'style-1',
                'prefix_class' => 'elementor-pagination-',
                'condition'    => [
                    'enable_carousel' => 'yes',
                    'navigation'      => [ 'dots', 'both' ],
                ],
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
            'custom_navigation_previous',
            [
                'label'              => esc_html__( 'Class Navigation Previous', 'westio' ),
                'type'               => Controls_Manager::TEXT,
                'frontend_available' => true,
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
        $this->end_controls_section();
    }

    /**
     * Register Control Carousel Additional.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function get_control_carousel_additional( $condition ) {


        $this->start_controls_section(
            'section_additional_options',
            [
                'label'     => esc_html__( 'Additional Options', 'westio' ),
                'condition' => [
                                   'enable_carousel' => 'yes'
                               ] + $condition,
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
                'default'            => 'horizontal',
                'frontend_available' => true,
                'options'            => [
                    'horizontal' => esc_html__( 'Horizontal', 'westio' ),
                    'vertical'   => esc_html__( 'Vertical', 'westio' ),
                ],
            ]
        );
        $this->add_control(
            'rtl',
            [
                'label'   => esc_html__( 'Direction Right/Left', 'westio' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'ltr',
                'options' => [
                    'ltr' => esc_html__( 'Left', 'westio' ),
                    'rtl' => esc_html__( 'Right', 'westio' ),
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register Control Carousel Style Navigation.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */

    protected function get_control_carousel_style_navigation( $condition ) {
        $this->start_controls_section(
            'section_style_navigation',
            [
                'label'     => esc_html__( 'Navigation', 'westio' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                                   'enable_carousel' => 'yes',
                                   'navigation'      => [ 'arrows', 'both', 'bars', 'dots', 'progressbars' ],
                               ] + $condition,
            ]
        );

        $this->add_control(
            'heading_style_arrows',
            [
                'label'     => esc_html__( 'Arrows', 'westio' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
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
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev i, 
                    {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
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
                'condition'  => [
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
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
                'condition'  => [
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
                ],
            ]
        );

        $this->add_group_control(

            Group_Control_Border::get_type(),
            [
                'name'      => 'arrows_border',
                'selector'  => '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next',
                'separator' => 'before',
                'condition' => [
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
                ],
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
                'condition'  => [
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'arrows_box_shadow',
                'condition' => [
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
                ],
                'selector'  => '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next',
            ]
        );

        $this->start_controls_tabs( 'arrows_tabs' );

        $this->start_controls_tab( 'arrows_normal',
            [
                'label'     => esc_html__( 'Normal', 'westio' ),
                'condition' => [
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
                ],
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
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
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
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'arrows_hover',
            [
                'label'     => esc_html__( 'Hover', 'westio' ),
                'condition' => [
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
                ],
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
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
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
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
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
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
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
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
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
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
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
                    'navigation'           => [ 'arrows', 'both', 'bars' ],
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
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
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
                    'navigation'             => [ 'arrows', 'both', 'bars' ],
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
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
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
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
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
                    'navigation'           => [ 'arrows', 'both', 'bars' ],
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
                    'navigation!' => [ 'dots', 'progressbars', 'none' ],
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
                    'navigation'             => [ 'arrows', 'both', 'bars' ],
                    'arrows_prev_horizontal' => [ 'left', 'right' ],
                ],
            ]
        );

        $this->add_control(
            'heading_style_dots',
            [
                'label'     => esc_html__( 'Pagination', 'westio' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'navigation' => [ 'dots', 'both', 'bars', 'progressbars' ],
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
                    'navigation' => [ 'dots', 'both', 'bars', 'progressbars' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_vertical_value',
            [
                'label'      => esc_html__( 'Spacing', 'westio' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => '',
                ],
                'selectors'  => [
                    '{{WRAPPER}}.elementor-pagination-position-inside .swiper-pagination'                                                          => 'bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-pagination-position-inside .swiper-pagination-progressbar'                                              => 'bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-pagination-position-outside .swiper, .elementor-lightbox.elementor-pagination-position-outside .swiper' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'navigation' => [ 'dots', 'both', 'bars', 'progressbars' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'Alignment_text',
            [
                'label'     => esc_html__( 'Alignment text', 'westio' ),
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
                    '{{WRAPPER}} .swiper-pagination' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => [ 'both', 'dots' ],
                    'style_dot'  => [ 'style-1', 'style-2' ]
                ],
            ]
        );

        $this->add_control(
            'dots_size',
            [
                'label'     => esc_html__( 'Size', 'westio' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 10,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => '--size-pagination-bullet: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                ],
            ]
        );

        $this->add_control(
            'dots_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'westio' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'navigation' => [ 'dots', 'both' ],
                ],
            ]
        );

        $this->add_responsive_control(
            'progressbar_height',
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
                    '{{WRAPPER}} .swiper-pagination-progressbar.swiper-pagination-horizontal' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'navigation!' => [ 'both', 'arrows', 'dots', 'none' ],
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_carousel_dots_style' );

        $this->start_controls_tab(
            'tab_carousel_dots_normal',
            [
                'label'     => esc_html__( 'Normal', 'westio' ),
                'condition' => [
                    'navigation!' => [ 'arrows', 'none' ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'carousel_dots_color',
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .swiper-pagination-bullet, {{WRAPPER}} .swiper-pagination-progressbar',
                'condition' => [
                    'navigation!' => [ 'arrows', 'none' ],
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
                    '{{WRAPPER}} .swiper-pagination-bullet'      => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .swiper-pagination-progressbar' => 'opacity: {{SIZE}};',
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both', 'bars', 'progressbars' ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_carousel_dots_hover',
            [
                'label'     => esc_html__( 'Hover', 'westio' ),
                'condition' => [
                    'navigation' => [ 'dots', 'both', 'bars', 'progressbars' ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'carousel_dots_color_hover',
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .swiper-pagination-bullet:hover, {{WRAPPER}} .swiper-pagination-bullet:focus, {{WRAPPER}} .swiper-pagination-progressbar:hover, {{WRAPPER}} .swiper-pagination-progressbar:focus',
            ]
        );

        $this->add_control(
            'carousel_dots_opacity_hover',
            [
                'label'     => esc_html__( 'Opacity Hover', 'westio' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet:hover'      => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .swiper-pagination-bullet:focus'      => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .swiper-pagination-progressbar:hover' => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .swiper-pagination-progressbar:focus' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_carousel_dots_activate',
            [
                'label'     => esc_html__( 'Activate', 'westio' ),
                'condition' => [
                    'navigation' => [ 'dots', 'both', 'bars', 'progressbars' ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'carousel_dots_color_activate',
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .swiper-pagination-bullet-active, {{WRAPPER}} .swiper-pagination-progressbar-fill',
            ]
        );

        $this->add_control(
            'carousel_dots_opacity_activate',
            [
                'label'     => esc_html__( 'Opacity Active', 'westio' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet'      => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .swiper-pagination-progressbar' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function get_swiper_navigation( $slides_count = 0 ) {
        $settings = $this->get_settings_for_display();
        if ( $settings['enable_carousel'] != 'yes' ) {
            return;
        }
        $show_dots         = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
        $show_arrows       = ( in_array( $settings['navigation'], [ 'arrows', 'both', 'bars' ] ) );
        $show_progressbars = ( in_array( $settings['navigation'], [ 'progressbars', 'bars' ] ) );
        ?>
        <?php if ( isset( $slides_count ) && $slides_count > 1 ) : ?>
            <?php if ( $show_dots ) : ?>
                <div class="swiper-pagination swiper-pagination-<?php echo esc_attr( $this->get_id() ) ?>"></div>
            <?php endif; ?>

            <?php if ( $show_progressbars ) : ?>
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
            <?php endif; ?>
        <?php endif; ?>
        <?php
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

    protected function get_swiper_navigation_for_product() {
        $settings = $this->get_settings_for_display();
        if ( $settings['enable_carousel'] != 'yes' ) {
            return;
        }
        $settings_navigation = '';
        $show_dots           = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
        $show_arrows         = ( in_array( $settings['navigation'], [ 'arrows', 'both', 'bars' ] ) );
        $show_progressbars   = ( in_array( $settings['navigation'], [ 'progressbars', 'bars' ] ) );


        if ( $show_dots ) {
            $settings_navigation .= '<div class="swiper-pagination swiper-pagination-' . $this->get_id() . '"></div>';
        }
        if ( $show_progressbars ) {
            $settings_navigation .= '<div class="swiper-pagination swiper-pagination-' . $this->get_id() . '"></div>';
        }
        if ( $show_arrows && $settings['custom_navigation'] != 'yes' ) {
            $settings_navigation .= '<div class="elementor-swiper-button elementor-swiper-button-prev elementor-swiper-button-prev-' . $this->get_id() . '" role="button" tabindex="0">';
            $settings_navigation .= $this->render_swiper_button( 'previous', true );
            $settings_navigation .= '<span class="elementor-screen-only">' . esc_html__( 'Previous', 'westio' ) . '</span>';
            $settings_navigation .= '</div>';
            $settings_navigation .= '<div class="elementor-swiper-button elementor-swiper-button-next elementor-swiper-button-next-' . $this->get_id() . '" role="button" tabindex="0">';
            $settings_navigation .= $this->render_swiper_button( 'next', true );
            $settings_navigation .= '<span class="elementor-screen-only">' . esc_html__( 'Next', 'westio' ) . '</span>';
            $settings_navigation .= '</div>';
        }

        return $settings_navigation;
    }

    /**
     * Get data elementor columns
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function get_data_elementor_columns() {

        $settings = $this->get_settings_for_display();
        //wrapper
        $this->add_render_attribute(
            [
                'wrapper'   => [
                    'class' => 'westio-wrapper'
                ],
                'container' => [
                    'class' => 'westio-con'
                ],
                'inner'     => [
                    'class' => [ 'westio-con-inner', 'elementor-grid' ]
                ]
            ]
        );
    }


    protected function get_control_pagination( $condition = array() ) {
        $this->start_controls_section(
            'section_pagination',
            [
                'label'     => esc_html__( 'Pagination', 'westio' ),
                'condition' => $condition,
            ]
        );

        $this->add_control(
            'pagination_type',
            [
                'label'   => esc_html__( 'Pagination', 'westio' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''                      => esc_html__( 'None', 'westio' ),
                    'numbers'               => esc_html__( 'Numbers', 'westio' ),
                    'prev_next'             => esc_html__( 'Previous/Next', 'westio' ),
                    'numbers_and_prev_next' => esc_html__( 'Numbers', 'westio' ) . ' + ' . esc_html__( 'Previous/Next', 'westio' ),
                ],
            ]
        );

        $this->add_control(
            'pagination_page_limit',
            [
                'label'     => esc_html__( 'Page Limit', 'westio' ),
                'default'   => '5',
                'condition' => [
                    'pagination_type!' => '',
                ],
            ]
        );

        $this->add_control(
            'pagination_numbers_shorten',
            [
                'label'     => esc_html__( 'Shorten', 'westio' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => '',
                'condition' => [
                    'pagination_type' => [
                        'numbers',
                        'numbers_and_prev_next',
                    ],
                ],
            ]
        );

        $this->add_control(
            'pagination_prev_label',
            [
                'label'     => esc_html__( 'Previous Label', 'westio' ),
                'type'      => \Elementor\Controls_Manager::TEXTAREA,
                'default'   => '<i class="westio-icon-angle-left"></i>',
                'condition' => [
                    'pagination_type' => [
                        'prev_next',
                        'numbers_and_prev_next',
                    ],
                ],
            ]
        );

        $this->add_control(
            'pagination_next_label',
            [
                'label'     => esc_html__( 'Next Label', 'westio' ),
                'type'      => \Elementor\Controls_Manager::TEXTAREA,
                'default'   => '<i class="westio-icon-angle-right"></i>',
                'condition' => [
                    'pagination_type' => [
                        'prev_next',
                        'numbers_and_prev_next',
                    ],
                ],
            ]
        );

        $this->add_control(
            'pagination_align',
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
                    '{{WRAPPER}} .elementor-pagination' => 'text-align: {{VALUE}}; justify-content: {{VALUE}}',
                ],
                'condition' => [
                    'pagination_type!' => '',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render_loop_footer() {
        $settings = $this->get_settings_for_display();
        if ( ! $settings['pagination_type'] || empty( $settings['pagination_type'] ) ) {
            return;
        }
        $parent_settings = $this->get_settings();
        if ( '' === $parent_settings['pagination_type'] ) {
            return;
        }

        $page_limit = $this->query_posts()->max_num_pages;
        if ( '' !== $parent_settings['pagination_page_limit'] ) {
            $page_limit = min( $parent_settings['pagination_page_limit'], $page_limit );
        }

        if ( 2 > $page_limit ) {
            return;
        }

        $this->add_render_attribute( 'pagination', 'class', 'elementor-pagination' );

        $has_numbers   = in_array( $parent_settings['pagination_type'], [ 'numbers', 'numbers_and_prev_next' ] );
        $has_prev_next = in_array( $parent_settings['pagination_type'], [ 'prev_next', 'numbers_and_prev_next' ] );

        $links = [];

        if ( $has_numbers ) {
            $links = paginate_links( [
                'type'               => 'array',
                'current'            => $this->get_current_page(),
                'total'              => $page_limit,
                'prev_next'          => false,
                'show_all'           => 'yes' !== $parent_settings['pagination_numbers_shorten'],
                'before_page_number' => '<span class="elementor-screen-only">' . esc_html__( 'Page', 'westio' ) . '</span>',
            ] );
        }

        if ( $has_prev_next ) {
            $prev_next = $this->get_posts_nav_link( $page_limit );
            array_unshift( $links, $prev_next['prev'] );
            $links[] = $prev_next['next'];
        }

        ?>
        <div class="pagination">
            <nav class="elementor-pagination" aria-label="<?php esc_attr_e( 'Pagination', 'westio' ); ?>">
                <?php echo implode( PHP_EOL, $links ); ?>
            </nav>
        </div>
        <?php
    }

    public function get_current_page() {
        if ( '' === $this->get_settings( 'pagination_type' ) ) {
            return 1;
        }

        return max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
    }

    public function get_posts_nav_link( $page_limit = null ) {
        if ( ! $page_limit ) {
            $page_limit = $this->query_posts()->max_num_pages;
        }

        $return = [];

        $paged = $this->get_current_page();

        $link_template     = '<a class="page-pagination-nav page-numbers %s" href="%s">%s</a>';
        $disabled_template = '<span class="page-pagination-nav page-numbers %s">%s</span>';

        if ( $paged > 1 ) {
            $next_page = intval( $paged ) - 1;
            if ( $next_page < 1 ) {
                $next_page = 1;
            }

            $return['prev'] = sprintf( $link_template, 'prev', get_pagenum_link( $next_page ), $this->get_settings( 'pagination_prev_label' ) );
        } else {
            $return['prev'] = sprintf( $disabled_template, 'prev', $this->get_settings( 'pagination_prev_label' ) );
        }

        $next_page = intval( $paged ) + 1;

        if ( $next_page <= $page_limit ) {
            $return['next'] = sprintf( $link_template, 'next', get_pagenum_link( $next_page ), $this->get_settings( 'pagination_next_label' ) );
        } else {
            $return['next'] = sprintf( $disabled_template, 'next', $this->get_settings( 'pagination_next_label' ) );
        }

        return $return;
    }
}
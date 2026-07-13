<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Westio\Elementor\Westio_Base_Widgets;
use Elementor\Group_Control_Border;


/**
 * Elementor icon box widget.
 *
 * Elementor widget that displays an icon, a headline and a text.
 *
 * @since 1.0.0
 */
class Westio_Widget_Icon_Box extends Westio_Base_Widgets
{

    /**
     * Get widget name.
     *
     * Retrieve icon box widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'westio-icon-box';
    }

    /**
     * Get widget title.
     *
     * Retrieve icon box widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return __('Westio Icon Box', 'westio');
    }

    /**
     * Get widget icon.
     *
     * Retrieve icon box widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-icon-box';
    }

    public function get_categories()
    {
        return array('westio-addons');
    }

    public function get_style_depends(): array
    {
        return ['widget-icon-box'];
    }

    public function has_widget_inner_wrapper(): bool {
        return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
    }

    /**
     * Register icon box widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_icon',
            [
                'label' => __('Icon Box', 'westio'),
            ]
        );

        $this->add_control(
            'selected_icon',
            [
                'label' => esc_html__('Icon', 'westio'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__('View', 'westio'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => esc_html__('Default', 'westio'),
                    'stacked' => esc_html__('Stacked', 'westio'),
                    'framed' => esc_html__('Framed', 'westio'),
                ],
                'default' => 'default',
                'prefix_class' => 'elementor-view-',
                'condition' => [
                    'selected_icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'shape',
            [
                'label' => esc_html__('Shape', 'westio'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'circle' => esc_html__('Circle', 'westio'),
                    'square' => esc_html__('Square', 'westio'),
                ],
                'default' => 'circle',
                'condition' => [
                    'view!' => 'default',
                    'selected_icon[value]!' => '',
                ],
                'prefix_class' => 'elementor-shape-',
            ]
        );

        $this->add_control(
            'effect',
            [
                'label' => esc_html__('Effect', 'westio'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'selected_icon[value]!' => '',
                    'shape!' => 'square',
                ],
                'prefix_class' => 'elementor-effect-',
            ]
        );
        $this->add_control(
            'title_text',
            [
                'label' => esc_html__('Title', 'westio'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__('This is the heading', 'westio'),
                'placeholder' => esc_html__('Enter your title', 'westio'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description_text',
            [
                'label' => esc_html__('Description Top', 'westio'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'westio'),
                'placeholder' => esc_html__('Enter your description', 'westio'),
                'rows' => 3,
            ]
        );

        $this->add_control(
            'description_text_2',
            [
                'label' => esc_html__('Description Bottom', 'westio'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('Enter your description', 'westio'),
                'rows' => 3,
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'westio'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_size',
            [
                'label' => esc_html__('Title HTML Tag', 'westio'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h4',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_box',
            [
                'label' => esc_html__('Box', 'westio'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'icon_box_background_color',
            [
                'label' => __('Background Color', 'westio'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_box_background_color_hover',
            [
                'label' => __('Background Color Hover', 'westio'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'position',
            [
                'label' => esc_html__('Icon Position', 'westio'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'top',
                'mobile_default' => 'top',
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'westio'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'top' => [
                        'title' => esc_html__('Top', 'westio'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'westio'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'elementor%s-position-',
                'condition' => [
                    'selected_icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'content_justify_content',
            [
                'label' => esc_html__('Justify Content', 'westio'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'westio'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'westio'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'westio'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'westio'),
                        'icon' => 'eicon-h-align-stretch',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-wrapper' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'position!' => 'top',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_vertical_alignment',
            [
                'label' => esc_html__('Vertical Alignment', 'westio'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'westio'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => esc_html__('Middle', 'westio'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'westio'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'top',
                'toggle' => false,
                'prefix_class' => 'elementor%s-vertical-align-',
                'condition' => [
                    'position!' => 'top',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label' => esc_html__('Alignment', 'westio'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'westio'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'westio'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'westio'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justified', 'westio'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'condition' => [
                    'position' => 'top',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'box_padding',
            [
                'label' => esc_html__('Padding', 'westio'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}}',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'box_border_radius_icon_box',
            [
                'label' => esc_html__('Border Radius', 'westio'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon-box-box-shadow',
                'selector' => '{{WRAPPER}}',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'westio'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'selected_icon[value]!' => '',
                ],
            ]
        );

        $this->start_controls_tabs('icon_colors');

        $this->start_controls_tab(
            'icon_colors_normal',
            [
                'label' => esc_html__('Normal', 'westio'),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_color',
                'types' => ['gradient'],
                'fields_options' => [
                    'background' => [
                        'frontend_available' => true,
                    ],
                ],
                'selector' => '{{WRAPPER}}.elementor-view-stacked .elementor-icon',
                'condition' => [
                    'view' => 'stacked',
                ],
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => esc_html__('Primary Color', 'westio'),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon' => 'fill: {{VALUE}}; color: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'secondary_color',
            [
                'label' => esc_html__('Secondary Color', 'westio'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'view!' => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-effect-yes .elementor-icon-box-icon .elementor-icon:before' => 'border-top-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'effect_color',
            [
                'label' => esc_html__('Background Effect Color', 'westio'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'effect' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-westio-icon-box.elementor-effect-yes .elementor-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_colors_hover',
            [
                'label' => esc_html__('Hover', 'westio'),
            ]
        );

        $this->add_control(
            'hover_primary_color',
            [
                'label' => esc_html__('Primary Color', 'westio'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon:hover' => 'fill: {{VALUE}}; color: {{VALUE}}; border-color: {{VALUE}};',
                    '{{WRAPPER}}:hover .elementor-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_secondary_color',
            [
                'label' => esc_html__('Secondary Color', 'westio'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'view!' => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'hover_effect_color',
            [
                'label' => esc_html__('Background Effect Color', 'westio'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'effect' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-westio-icon-box:hover.elementor-effect-yes .elementor-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'westio'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_space',
            [
                'label' => esc_html__('Spacing Icon', 'westio'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--icon-box-icon-margin: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'westio'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ic_width_svg',
            [
                'label' => esc_html__('Width SVG', 'westio'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-icon .elementor-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ic_height_svg',
            [
                'label' => esc_html__('Height SVG', 'westio'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-icon .elementor-icon svg' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'align_icon',
            [
                'label' => esc_html__('Alignment Info ', 'westio'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'westio'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'westio'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'westio'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-icon' => 'justify-content: {{VALUE}}',
                    '{{WRAPPER}} .elementor-icon-box-icon .elementor-icon' => 'justify-content: {{VALUE}}',
                ],
                'condition' => [
                    'position' => 'top',
                ],
            ]
        );
        $this->add_responsive_control(
            'padding_icon_box',
            [
                'label' => esc_html__('Padding', 'westio'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-icon .elementor-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_box_margin',
            [
                'label' => esc_html__('Margin', 'westio'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-icon .elementor-icon i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-icon-box-icon .elementor-icon svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

//        $this->add_responsive_control(
//            'border_width',
//            [
//                'label' => esc_html__('Border Width', 'westio'),
//                'type' => Controls_Manager::DIMENSIONS,
//                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
//                'selectors' => [
//                    '{{WRAPPER}} .elementor-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
//                ],
//                'condition' => [
//                    'view' => 'framed',
//                ],
//            ]
//        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-icon-box-icon .elementor-icon',
                'separator' => 'before',
                'condition' => [
                    'view' => 'framed',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'westio'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'view!' => 'default',
                ],
            ]
        );
//        $this->add_control(
//            'icon_border_color',
//            [
//                'label' => esc_html__('Border Color', 'westio'),
//                'type' => Controls_Manager::COLOR,
//                'default' => '',
//                'selectors' => [
//                    '{{WRAPPER}} .elementor-icon-box-icon .elementor-icon' => 'border-color: {{VALUE}} !important',
//                ],
//            ]
//        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content', 'westio'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_box_content_padding',
            [
                'label' => esc_html__('Content Padding', 'westio'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_box_content_margin',
            [
                'label' => esc_html__('Content Margin', 'westio'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-icon-box-content',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'westio'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'title_text!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_box_title_margin',
            [
                'label' => esc_html__('Title Margin', 'westio'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'westio'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-icon-box-title a' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
            ]
        );
        $this->add_control(
            'icon_box_title_hover',
            [
                'label' => esc_html__('Color Title Hover', 'westio'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-icon-box-content .elementor-icon-box-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}}:hover .elementor-icon-box-content .elementor-icon-box-title a' => 'color: {{VALUE}};',

                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-icon-box-title, {{WRAPPER}} .elementor-icon-box-title a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_desc_1',
            [
                'label' => esc_html__('Description Top', 'westio'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'description_text!' => '',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'westio'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-description' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
            ]
        );
        $this->add_control(
            'icon_box_description_hover',
            [
                'label' => esc_html__('Color Description Hover', 'westio'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-icon-box-content .elementor-icon-box-description' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .elementor-icon-box-description',
            ]
        );

        $this->add_responsive_control(
            'icon_box_description_padding',
            [
                'label' => esc_html__('Description Top Padding', 'westio'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_desc_2',
            [
                'label' => esc_html__('Description Bottom', 'westio'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'description_text_2!' => '',
                ],
            ]
        );

        $this->add_control(
            'description_color_2',
            [
                'label' => esc_html__('Color', 'westio'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-description-2' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography_2',
                'selector' => '{{WRAPPER}} .elementor-icon-box-description-2',
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'icon', 'class', [ 'elementor-icon', 'elementor-animation-' . $settings['hover_animation'] ] );
        $has_link = ! empty( $settings['link']['url'] );
        $icon_tag = $has_link ? 'a' : 'span';
        $button_tag = 'span';

        if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
            // add old default
            $settings['icon'] = 'fa fa-star';
        }

        $has_icon = ! empty( $settings['icon'] );

        if ( ! empty( $settings['link']['url'] ) ) {
            $button_tag = 'a';
            $this->add_link_attributes( 'link', $settings['link'] );
        }

        if ( $has_icon ) {
            $this->add_render_attribute( 'i', 'class', $settings['icon'] );
            $this->add_render_attribute( 'i', 'aria-hidden', 'true' );
        }

        $this->add_render_attribute( 'description_text', 'class', 'elementor-icon-box-description' );
        $this->add_render_attribute( 'description_text_2', 'class', 'elementor-icon-box-description-2' );

        $this->add_inline_editing_attributes( 'title_text', 'none' );
        $this->add_inline_editing_attributes( 'description_text' );
        $this->add_inline_editing_attributes( 'description_text_2' );
        if ( ! $has_icon && ! empty( $settings['selected_icon']['value'] ) ) {
            $has_icon = true;
        }
        $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
        $is_new = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

        ?>
        <div class="elementor-icon-box-wrapper">
        <?php if ( $has_icon ) : ?>
            <div class="elementor-icon-box-icon">
            <<?php Utils::print_validated_html_tag( $icon_tag ); ?> <?php $this->print_render_attribute_string( 'icon' ); ?> <?php $this->print_render_attribute_string( 'link' ); ?>>
            <?php
            if ( $is_new || $migrated ) {
                Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
            } elseif ( ! empty( $settings['icon'] ) ) {
                ?><i <?php $this->print_render_attribute_string( 'i' ); ?>></i><?php
            }
            ?>
            </<?php Utils::print_validated_html_tag( $icon_tag ); ?>>
            </div>
        <?php endif; ?>
        <div class="elementor-icon-box-content">
        <div class="title-content">
        <?php if (!Utils::is_empty($settings['title_text'])) : ?>
            <<?php Utils::print_validated_html_tag( $settings['title_size'] ); ?> class="elementor-icon-box-title">
            <<?php Utils::print_validated_html_tag( $icon_tag ); ?>  <?php $this->print_render_attribute_string( 'title_text' ); ?> <?php $this->print_render_attribute_string( 'link' ); ?>>
            <?php $this->print_unescaped_setting( 'title_text' ); ?>
            </<?php Utils::print_validated_html_tag( $icon_tag ); ?>>
            </<?php Utils::print_validated_html_tag( $settings['title_size'] ); ?>>
        <?php endif; ?>
        <?php if ( ! Utils::is_empty( $settings['description_text'] ) ) : ?>
            <p <?php $this->print_render_attribute_string( 'description_text' ); ?>>
                <?php $this->print_unescaped_setting( 'description_text' ); ?>
            </p>
        <?php endif; ?>

        <?php if ( ! Utils::is_empty( $settings['description_text_2'] ) ) : ?>
            <p <?php $this->print_render_attribute_string( 'description_text_2' ); ?>>
                <?php $this->print_unescaped_setting( 'description_text_2' ); ?>
            </p>
        <?php endif; ?>
        </div>
        </div>
        </div>
        <?php
    }
}

$widgets_manager->register(new Westio_Widget_Icon_Box());
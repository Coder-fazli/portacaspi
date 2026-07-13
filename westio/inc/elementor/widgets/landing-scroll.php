<?php

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Westio\Elementor\Westio_Base_Widgets;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Westio_Elementor_Landing_Scroll extends Westio_Base_Widgets {

    public function get_name() {
        return 'westio-landing-scroll';
    }

    public function get_title() {
        return esc_html__('Westio Landing Scroll', 'westio');
    }

    public function get_icon() {
        return 'eicon-navigation-horizontal';
    }

    public function get_keywords() {
        return ['Scroll', 'Landing'];
    }

    public function get_categories() {
        return array('westio-addons');
    }

    public function get_script_depends() {
        return ['westio-elementor-landing-scroll'];
    }

    public function has_widget_inner_wrapper(): bool {
        return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_setting',
            [
                'label' => esc_html__('Setting', 'westio'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'nav_title',
            [
                'label' => esc_html__('Title', 'westio'),
                'type'  => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Section 1', 'westio'),
            ]
        );

        $repeater->add_control(
            'section_id',
            [
                'label' => esc_html__('Section ID', 'westio'),
                'type'  => Controls_Manager::TEXT,
                'description' => esc_html__('Enter the ID of the section to scroll to (e.g. about, services...)', 'westio'),
            ]
        );

        $this->add_control(
            'nav_items',
            [
                'label'       => esc_html__('Navigation Items', 'westio'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default' => [
                    ['nav_title' => 'Section 1', 'section_id' => 'section-1'],
                    ['nav_title' => 'Section 2', 'section_id' => 'section-2'],
                ],
                'title_field' => '{{{ nav_title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_wrapper',
            [
                'label' => esc_html__('Wrapper', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'wrapper_spacing',
            [
                'label'      => esc_html__('Spacing', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .landing-scroll-nav .landing-scroll-nav__list' => 'gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .landing-scroll-nav .landing-scroll-nav__list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .landing-scroll-nav .landing-scroll-nav__list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_radius',
            [
                'label'      => esc_html__('Border radius', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .landing-scroll-nav .landing-scroll-nav__list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_color',
            [
                'label'      => esc_html__('Background Color', 'westio'),
                'type'       => Controls_Manager::COLOR,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .landing-scroll-nav .landing-scroll-nav__list' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'wrapper-border',
                'selector'  => '{{WRAPPER}} .landing-scroll-nav .landing-scroll-nav__list',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Item', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .landing-scroll-nav .landing-scroll-nav__list .landing-scroll-nav__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .landing-scroll-nav .landing-scroll-nav__list .landing-scroll-nav__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_typography',
                'selector' => '{{WRAPPER}} .landing-scroll-nav .landing-scroll-nav__list .landing-scroll-nav__item',
            ]
        );

        $this->start_controls_tabs( 'item_tabs' );

        $this->start_controls_tab( 'item_normal',
            [
                'label' => esc_html__( 'Normal', 'westio' ),
            ]
        );

        $this->add_control(
            'item_color',
            [
                'label'      => esc_html__('Color', 'westio'),
                'type'       => Controls_Manager::COLOR,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .landing-scroll-nav .landing-scroll-nav__list .landing-scroll-nav__item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'item_hover',
            [
                'label' => esc_html__( 'Hover', 'westio' ),
            ]
        );

        $this->add_control(
            'item_color_hover',
            [
                'label'      => esc_html__('Color', 'westio'),
                'type'       => Controls_Manager::COLOR,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .landing-scroll-nav .landing-scroll-nav__list .landing-scroll-nav__item:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'item_active',
            [
                'label' => esc_html__( 'Active', 'westio' ),
            ]
        );

        $this->add_control(
            'item_color_active',
            [
                'label'      => esc_html__('Color', 'westio'),
                'type'       => Controls_Manager::COLOR,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .landing-scroll-nav .landing-scroll-nav__list .landing-scroll-nav__item.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings['nav_items'] ) ) {
            return;
        }
        ?>
        <nav class="landing-scroll-nav">
            <ul class="landing-scroll-nav__list">
                <?php foreach ( $settings['nav_items'] as $index => $item ) : ?>
                    <li class="landing-scroll-nav__item"
                        data-index="<?php echo esc_attr( $index ); ?>"
                        data-target="#<?php echo esc_attr( $item['section_id'] ); ?>">
                        <span class="landing-scroll-nav__text">
                            <?php echo esc_html( $item['nav_title'] ); ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <?php
    }
}

$widgets_manager->register(new Westio_Elementor_Landing_Scroll());

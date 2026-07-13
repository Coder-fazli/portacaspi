<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;

class Westio_Elementor__Menu_Canvas extends Elementor\Widget_Base {

    public function get_name() {
        return 'westio-menu-canvas';
    }

    public function get_title() {
        return esc_html__('Westio Menu Canvas', 'westio');
    }

    public function get_icon() {
        return 'eicon-nav-menu';
    }

    public function get_categories() {
        return ['westio-addons'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'icon-menu_style',
            [
                'label' => esc_html__('Icon', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'color_tabs' );

        $this->start_controls_tab( 'colors_normal',
            [
                'label' => esc_html__( 'Normal', 'westio' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'all_background_button_link',
                'label'          => esc_html__('Background Button Link', 'westio'),
                'types'          => [ 'classic'],
                'selector'       => '{{WRAPPER}} .menu-mobile-nav-button .westio-icon > span',
                'fields_options' => [
                    'color' => [
                        'global' => [
                            'default' => '',
                        ],
                    ],
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'colors_hover',
            [
                'label' => esc_html__( 'Hover', 'westio' ),
            ]
        );


        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'all_background_button_link_hover',
                'label'          => esc_html__('Background Button Link', 'westio'),
                'types'          => [ 'classic'],
                'selector'       => '{{WRAPPER}} .menu-mobile-nav-button:hover .westio-icon > span',
                'fields_options' => [
                    'color' => [
                        'global' => [
                            'default' => '',
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('wrapper', 'class', 'elementor-canvas-menu-wrapper');
        ?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <?php westio_mobile_nav_button(); ?>
        </div>
        <?php
    }

}

$widgets_manager->register(new Westio_Elementor__Menu_Canvas());

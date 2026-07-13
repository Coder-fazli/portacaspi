<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Westio_Map_Location extends Elementor\Widget_Base {

    public function get_name() {
        return 'westio-map-location';
    }

    public function get_title() {
        return esc_html__('Westio Map Location', 'westio');
    }

    public function get_categories() {
        return array('westio-addons');
    }

    public function get_icon() {
        return 'eicon-image-hotspot';
    }

    protected function register_controls() {

        $this->start_controls_section('map_location_image_section',
            [
                'label' => esc_html__('Image', 'westio'),
            ]
        );

        $this->add_control('map_location_image',
            [
                'label'       => esc_html__('Choose Image', 'westio'),
                'type'        => Controls_Manager::MEDIA,
                'default'     => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'label_block' => true
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'background_image', // Actually its `image_size`.
                'default' => 'full'
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section('map_location_icons_settings',
            [
                'label' => esc_html__('Location', 'westio'),
            ]
        );
        $repeater = new Elementor\Repeater();

        $repeater->add_responsive_control('westio_map_location_main_horizontal_position',
            [
                'label'      => esc_html__('Horizontal Position', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'default'    => [
                    'size' => 50,
                    'unit' => '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.westio-map-location-content' => 'left: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $repeater->add_responsive_control('westio_map_location_main_vertical_position',
            [
                'label'      => esc_html__('Vertical Position', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'default'    => [
                    'size' => 50,
                    'unit' => '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.westio-map-location-content' => 'top: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $repeater->add_control('westio_map_location_icon',
            [
                'label'   => esc_html__('Icon', 'westio'),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-circle',
                    'library' => 'fa-solid',
                ],
            ]);

        $repeater->add_responsive_control(
            'icon_size',
            [
                'label'     => esc_html__('Font Size', 'westio'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .westio-map-location-icon .icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_control('westio_map_location_title',
            [
                'label'       => esc_html__('Title', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Title',
                'label_block' => true,
            ]
        );

        $this->add_control('map_location_icons',
            [
                'label'  => esc_html__('Location', 'westio'),
                'type'   => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'border_radius_img_location',
            [
                'label'      => esc_html__('Border Radius img', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-widget-container .westio-addons-map-location' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'color_path',
            [
                'label'     => esc_html__('Color Path', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover.elementor-widget-westio-map-location .elementor-widget-container .westio-map-location-icon:before' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'color_title',
            [
                'label'     => esc_html__('Color Title', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover.elementor-widget-westio-map-location .elementor-widget-container .westio-map-location-icon .title' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_icon_social_style');

        $this->start_controls_tab(
            'tab_icon_social_normal',
            [
                'label' => esc_html__('Normal', 'westio'),
            ]
        );

        $this->add_control(
            'color_icon_social',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .westio-map-location-icon .icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_social_hover',
            [
                'label' => esc_html__('Hover', 'westio'),
            ]
        );

        $this->add_control(
            'color_icon_social_hover',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .westio-map-location-icon:hover .icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    protected function render() {
        $settings       = $this->get_settings_for_display();
        $image_src      = $settings['map_location_image'];
        $image_src_size = Group_Control_Image_Size::get_attachment_image_src($image_src['id'], 'background_image', $settings);
        if (empty($image_src_size)) $image_src_size = $image_src['url'];
        ?>

        <div class="westio-map-location-container">
            <img class="westio-addons-map-location" alt="Background" src="<?php echo esc_url($image_src_size); ?>">
            <?php foreach ($settings['map_location_icons'] as $index => $item) { ?>
                <?php
                $class_item            = 'elementor-repeater-item-' . $item['_id'];
                $tab_title_setting_key = $this->get_repeater_setting_key('tab_title', 'tabs', $index);
                $this->add_render_attribute($tab_title_setting_key, [
                    'class' => ['westio-map-location-content', $class_item],
                ]);
                ?>
                <div <?php echo westio_elementor_get_render_attribute_string($tab_title_setting_key, $this); ?>>
                    <div class="westio-map-location-icon">
                        <span class="title"><?php printf('%s', $item['westio_map_location_title']); ?></span>
                        <span class="icon">
                            <?php Icons_Manager::render_icon($item['westio_map_location_icon'], ['aria-hidden' => 'true']); ?>
                            <span class="pulse-icon item1"></span>
                            <span class="pulse-icon item2"></span>
                            <span class="pulse-icon item3"></span>
                            <span class="pulse-icon item4"></span>
                        </span>
                    </div>
                </div>
            <?php } ?>
        </div>

        <?php
    }

}

$widgets_manager->register(new Westio_Map_Location());

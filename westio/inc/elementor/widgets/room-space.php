<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Box_Shadow;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Westio\Elementor\Westio_Base_Widgets;
use Elementor\Utils;
use Elementor\Icons_Manager;

class Westio_Elementor_Room_Space extends Westio_Base_Widgets {

    /**
     * Get widget name.
     *
     * Retrieve testimonial widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'westio-room-space';
    }

    /**
     * Get widget title.
     *
     * Retrieve testimonial widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title() {
        return esc_html__('Westio Room Space', 'westio');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-kit-parts';
    }

    public function get_script_depends() {
        return ['westio-elementor-room-space'];
    }

    public function get_categories() {
        return array('westio-addons');
    }

    public function get_style_depends() {
        return ['elementor-icons-fa-solid', 'elementor-icons-fa-brands', 'elementor-icons-fa-regular'];
    }

    /**
     * Register testimonial widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_room',
            [
                'label' => esc_html__('Room', 'westio'),
            ]
        );

        // Nested Repeater: Content
        $content_repeater = new Repeater();

        $content_repeater->add_control(
            'content_title',
            [
                'label'       => esc_html__('Title', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Custom Cabinetry',
                'label_block' => true,
            ]
        );

        // Room Repeater
        $repeater = new Repeater();

        $repeater->add_control(
            'roomspace_image',
            [
                'label'   => esc_html__('Image', 'westio'),
                'type'    => Controls_Manager::MEDIA,
                'default' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
            ]
        );

        $repeater->add_control(
            'tabs',
            [
                'label'   => esc_html__('Tabs', 'westio'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'living',
            ]
        );

        $repeater->add_control(
            'contents',
            [
                'label'        => esc_html__('Content', 'westio'),
                'type'         => Controls_Manager::REPEATER,
                'fields'       => $content_repeater->get_controls(),
                'title_field'  => '{{{ content_title }}}',
                'max_items'    => 10,
                'item_actions' => [
                    'add' => false,
                ],
                'default'      => [
                    [
                        'content_title' => esc_html__('Custom Cabinetry', 'westio'),
                    ],
                ],
            ]
        );

        $this->add_control(
            'roomspace',
            [
                'label'         => esc_html__('Room Space', 'westio'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'title_field'   => '{{{ tabs }}}',
                'prevent_empty' => false
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'roomspace_image',
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->end_controls_section();

        // Wrapper.
        $this->start_controls_section(
            'section_style_room_wrapper',
            [
                'label' => esc_html__('Items', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'roomspace_align_items',
            [
                'label'     => esc_html__('Vertical Align', 'westio'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'default'   => 'flex-end',
                'options'   => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'westio'),
                        'icon'  => 'eicon-align-start-v',
                    ],
                    'center'     => [
                        'title' => esc_html__('Center', 'westio'),
                        'icon'  => 'eicon-align-center-v',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__('Bottom', 'westio'),
                        'icon'  => 'eicon-align-end-v',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .roomspace-wrapper' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'roomspace_gap',
            [
                'label'      => esc_html__('Gap', 'westio'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 200],
                ],
                'default'    => [
                    'size' => 110,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .roomspace-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding_inner',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .roomspace-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .roomspace-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        // Image.
        $this->start_controls_section(
            'section_style_room_image',
            [
                'label' => esc_html__('Image', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'roomspace_image_height',
            [
                'label'      => esc_html__('Height', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .roomspace-right' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .roomspace-right img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Content
        $this->start_controls_section(
            'section_style_room_main',
            [
                'label' => esc_html__('Content', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'roomspace_content_width',
            [
                'label'      => esc_html__('Width', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 900,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .roomspace-wrapper .roomspace-left' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'roomspace_content_gap',
            [
                'label'      => esc_html__('Gap', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .roomspace-wrapper .roomspace-left' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Tabs.
        $this->start_controls_section(
            'section_style_room_tabs',
            [
                'label' => esc_html__('Tabs', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tabs_text_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .roomspace-tab' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tabs_text_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .roomspace-tab:hover'  => 'color: {{VALUE}};',
                    '{{WRAPPER}} .roomspace-tab.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tabs_typography',
                'selector' => '{{WRAPPER}} .roomspace-tabs',
            ]
        );

        $this->add_responsive_control(
            'roomspace_tabs_gap',
            [
                'label'      => esc_html__('Gap', 'westio'),
                'type'       => Controls_Manager::GAPS,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'row'    => 10,
                    'column' => 40,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .roomspace-wrapper .roomspace-tabs' => 'row-gap: {{ROW}}{{UNIT}}; column-gap: {{COLUMN}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Text

        $this->start_controls_section(
            'section_style_text',
            [
                'label' => esc_html__('Text', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'roomspace_text_height',
            [
                'label'      => esc_html__('Min Height', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 900,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .roomspace-wrapper .roomspace-contents' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding_text',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .roomspace-wrapper .roomspace-content li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'text_typography',
                'selector' => '{{WRAPPER}} .roomspace-wrapper .roomspace-content li',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .roomspace-wrapper .roomspace-content li' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_text_color',
            [
                'label'     => esc_html__('Border Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .roomspace-wrapper .roomspace-content li' => 'border-top-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render testimonial widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['roomspace']) || !is_array($settings['roomspace'])) {
            return;
        }

        ?>
        <div class="roomspace-wrapper">
            <div class="roomspace-left">
                <div class="roomspace-tabs">
                    <?php
                    $first = true;
                    foreach ($settings['roomspace'] as $index => $roomspace):
                        $active_class = $first ? ' active' : '';
                        ?>
                        <span class="roomspace-tab<?php echo esc_attr($active_class); ?>" data-room-index="<?php echo esc_attr($index); ?>">
                        <?php echo esc_html($roomspace['tabs']); ?>
                    </span>
                        <?php
                        $first = false;
                    endforeach;
                    ?>
                </div>

                <div class="roomspace-contents">
                    <?php
                    $first = true;
                    foreach ($settings['roomspace'] as $index => $roomspace):
                        $active_class = $first ? ' active' : '';
                        ?>
                        <div class="roomspace-content<?php echo esc_attr($active_class); ?>" data-room-index="<?php echo esc_attr($index); ?>">
                            <?php if (!empty($roomspace['contents']) && is_array($roomspace['contents'])): ?>
                                <ul>
                                    <?php foreach ($roomspace['contents'] as $content): ?>
                                        <li><?php echo esc_html($content['content_title']); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <?php
                        $first = false;
                    endforeach;
                    ?>
                </div>
            </div>

            <div class="roomspace-right">
                <?php
                $first = true;
                foreach ($settings['roomspace'] as $index => $roomspace):
                    $active_class = $first ? ' active' : '';
                    ?>
                    <div class="roomspace-image<?php echo esc_attr($active_class); ?>" data-room-index="<?php echo esc_attr($index); ?>">
                        <?php
                        if (!empty($roomspace['roomspace_image']['url'])) {
                            echo '<img src="' . esc_url($roomspace['roomspace_image']['url']) . '" alt="' . esc_attr($roomspace['tabs']) . '">';
                        }
                        ?>
                    </div>
                    <?php
                    $first = false;
                endforeach;
                ?>
            </div>
        </div>
        <?php
    }
}

$widgets_manager->register(new Westio_Elementor_Room_Space());

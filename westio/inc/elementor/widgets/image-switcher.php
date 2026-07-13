<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Box_Shadow;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Westio\Elementor\Westio_Base_Widgets;
use Elementor\Utils;
use Elementor\Icons_Manager;

class Westio_Elementor_Image_Switcher extends Westio_Base_Widgets {
    use Westio_Carousel_Trait;

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
        return 'westio-image-switcher';
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
        return esc_html__('Westio Image Switcher', 'westio');
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
        return 'eicon-image-rollover';
    }

    public function get_script_depends() {
        return ['westio-elementor-image-switcher', 'westio-elementor-swiper'];
    }

    public function get_categories() {
        return array('westio-addons');
    }

    public function get_style_depends() {
        return ['e-swiper'];
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
            'section_image_switcher',
            [
                'label' => esc_html__('Item', 'westio'),
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control(
            'image_switcher_image',
            [
                'label'      => esc_html__('Choose Image', 'westio'),
                'default'    => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,
            ]
        );
        $repeater->add_control(
            'image_switcher_title',
            [
                'label'   => esc_html__('Title', 'westio'),
                'default' => 'Provide the details',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'       => esc_html__('Link to', 'westio'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('https://your-link.com', 'westio'),
            ]
        );
        $this->add_control(
            'image_switcher_item',
            [
                'label'       => esc_html__('Items', 'westio'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ image_switcher_title }}}',
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image_switcher_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `testimonial_image_size` and `testimonial_image_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );
        $this->add_control('enable_carousel', [
            'label'   => esc_html__('Enable Carousel', 'westio'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'no',

        ]);
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image_switcher_image',
            [
                'label' => esc_html__('Image', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'testimonial_height_img',
            [
                'label'      => esc_html__('Height', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'vh', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .westio-con-inner' => 'padding-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'border_radius_wrapper_box',
            [
                'label'      => esc_html__('Border Radius', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .image-switcher-image-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image_switcher_content',
            [
                'label' => esc_html__('Content', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'image_switcher_content_padding',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-image-switcher-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_banner_sv_title',
            [
                'label'     => esc_html__('Title', 'westio'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'height_banner_sv_title',
            [
                'label'      => esc_html__('Height', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'vh', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-image-switcher-item' => 'min-height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-image-switcher-item .image-switcher-caption' => 'min-height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'banner_sv_title_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-switcher-item .image-switcher-caption .image-switcher-title'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-image-switcher-item .image-switcher-caption .image-switcher-title a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'banner_sv_title_color_hover',
            [
                'label'     => esc_html__('Color Title Hover', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-switcher-item .image-switcher-caption:hover .image-switcher-title'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-image-switcher-item .image-switcher-caption.active .image-switcher-title'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-image-switcher-item .image-switcher-caption:hover .image-switcher-title a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-image-switcher-item .image-switcher-caption.active .image-switcher-title a' => 'color: {{VALUE}};',

                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'banner_sv_title_typography',
                'selector' => '{{WRAPPER}} .elementor-image-switcher-item .image-switcher-caption .image-switcher-title',
            ]
        );
        $this->add_responsive_control(
            'banner_sv_title_padding',
            [
                'label'      => esc_html__('Title Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-image-switcher-item .image-switcher-caption .number-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );
        $this->end_controls_section();

        $this->get_controls_column([
            'enable_carousel!' => 'yes',
        ]);

        $this->add_control_carousel([
            'enable_carousel' => 'yes',
        ]);
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (!empty($settings['image_switcher_item']) && is_array($settings['image_switcher_item'])) {
            $this->add_render_attribute('wrapper', 'class', 'elementor-image-switcher-wrapper');
            $this->add_render_attribute('container', 'class', 'elementor-image-switcher-container');
            $this->add_render_attribute('inner', 'class', 'elementor-image-switcher-inner');
            $this->add_render_attribute('item', 'class', 'elementor-image-switcher-item');

            $image_output = '';
            $this->get_data_elementor_columns();
            $this->get_data_elementor_carousel();
            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                <div <?php $this->print_render_attribute_string('container'); ?>>
                    <div <?php $this->print_render_attribute_string('inner'); ?>>
                        <?php foreach ($settings['image_switcher_item'] as $index => $item):
                            $image_item_key = 'image-repeater-item' . $index;
                            $this->add_render_attribute($image_item_key, 'class', 'image-switcher-img');
                            $this->add_render_attribute($image_item_key, 'class', 'image-item-' . esc_attr($item['_id']));

                            if ($index == 0) {
                                $this->add_render_attribute($image_item_key, 'class', 'show');
                            } else {
                                $this->add_render_attribute($image_item_key, 'style', 'display: none;');
                            }

                            ob_start();
                            ?>
                            <div <?php $this->print_render_attribute_string($image_item_key); ?>>
                                <?php $this->render_image($settings, $item); ?>
                            </div>
                            <?php
                            $image_output .= ob_get_clean();
                            ?>

                            <div <?php $this->print_render_attribute_string('item'); ?>>
                                <div class="image-switcher-caption">
                                    <span class="image-switcher-title">
                                            <?php
                                            $image_switcher_title_html = esc_html($item['image_switcher_title']);
                                            if (!empty($item['link']['url'])) :
                                                $image_switcher_title_html = '<a href="' . esc_url($item['link']['url']) . '">' . esc_html($image_switcher_title_html) . '</a>';
                                            endif;
                                            echo wp_kses_post($image_switcher_title_html);
                                            ?>
                                        </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="image-switcher-image-list">
                        <?php
                        printf('%s', $image_output);
                        ?>
                    </div>
                    <?php $this->get_swiper_navigation(count($settings['image_switcher_item'])); ?>
                </div>
            </div>

            <?php
        }
    }

    private function render_image($settings, $item) {
        if (!empty($item['image_switcher_image']['url'])) :
            ?>
            <div class="process-image">
                <?php
                $item['image_switcher_image_size']             = $settings['image_switcher_image_size'];
                $item['image_switcher_image_custom_dimension'] = $settings['image_switcher_image_custom_dimension'];
                echo Group_Control_Image_Size::get_attachment_image_html($item, 'image_switcher_image');
                ?>
            </div>
        <?php
        endif;
    }
}

$widgets_manager->register(new Westio_Elementor_Image_Switcher());

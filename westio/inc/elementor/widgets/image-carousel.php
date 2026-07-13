<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Westio\Elementor\Westio_Base_Widgets;

class Westio_Elementor_Image_Carousel extends Westio_Base_Widgets {
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
        return 'westio-image-carousel';
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
        return esc_html__('Westio Image Carousel', 'westio');
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
        return 'eicon-gallery-grid';
    }

    public function get_script_depends() {
        return ['westio-elementor-image-carousel' , 'westio-elementor-swiper'];
    }

    public function get_categories() {
        return array('westio-addons');
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
            'section_image_carousel',
            [
                'label' => esc_html__('Image', 'westio'),
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Item Title', 'westio'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Image Item', 'westio'),
            ]
        );

        $repeater->add_control(
            'image_subtitle',
            [
                'label' => esc_html__('Item SubTitle', 'westio'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Image Item', 'westio'),
            ]
        );

        $repeater->add_control(
            'image_link_source',
            [
                'label'      => esc_html__('Choose Image', 'westio'),
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'image_link',
            [
                'label'       => esc_html__('Link to', 'westio'),
                'placeholder' => esc_html__('https://your-link.com', 'westio'),
                'type'        => Controls_Manager::URL,
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'image-carousel',
            [
                'label'       => esc_html__('Items', 'westio'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `brand_image_size` and `brand_image_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'view',
            [
                'label'   => esc_html__('View', 'westio'),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );
        $this->add_control('enable_carousel', [
            'label'   => esc_html__('Enable Carousel', 'westio'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'no',

        ]);
        $this->end_controls_section();

        $this->start_controls_section(
            'image_style',
            [
                'label' => esc_html__('Style', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'border_radius_img',
            [
                'label'      => esc_html__('Border Radius', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-item a img ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_image_content',
            [
                'label' => esc_html__('Content', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,

            ]
        );

        $this->add_responsive_control(
            'image_content_padding',
            [
                'label'      => esc_html__('Content Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-item .image-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'heading_image_title',
            [
                'label'     => esc_html__('Title', 'westio'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-item .image-content .image-title'   => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'image_title_typography',
                'selector' => '{{WRAPPER}} .elementor-item .image-content .image-title',
            ]
        );

        $this->add_control(
            'heading_image_subtitle',
            [
                'label'     => esc_html__('SubTitle', 'westio'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'subtitle_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-item .image-content .image-subtitle'   => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->add_responsive_control(
            'image_subtitle_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-item .image-content .image-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'image_subtitle_typography',
                'selector' => '{{WRAPPER}} .elementor-item .image-content .image-subtitle',
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
        if (!empty($settings['image-carousel']) && is_array($settings['image-carousel'])) {
            $this->add_render_attribute('wrapper', 'class', 'elementor-image-carousel-item-wrapper');
            $this->add_render_attribute(['container' => ['data-center' => $settings['center'] ?? false,],]);
            $this->add_render_attribute('item', 'class', 'elementor-grid-item elementor-item');
            $this->get_data_elementor_columns();
            $this->get_data_elementor_carousel();
            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                <div <?php $this->print_render_attribute_string('container'); ?>>
                    <div <?php $this->print_render_attribute_string('inner'); ?>>
                        <?php foreach ($settings['image-carousel'] as $index => $item):
                            $repeater_image_link_key = $this->get_repeater_setting_key('image_link', 'image-carousel', $index);
                            $this->add_render_attribute($repeater_image_link_key, 'href', $item['image_link']['url']);
                            ?>
                            <div <?php $this->print_render_attribute_string('item'); ?>>
                                <a <?php $this->print_render_attribute_string($repeater_image_link_key); ?>>
                                    <?php
                                    $image_url = Group_Control_Image_Size::get_attachment_image_src($item['image_link_source']['id'], 'image', $settings);
                                    if (!$image_url && isset($attachment['url'])) {
                                        $image_url = $item['url'];
                                    } ?>
                                    <img class="image" src="<?php echo esc_url($image_url); ?>" alt="image">
                                </a>
                                <div class="image-content">
                                    <?php if (!empty($item['title'])) : ?>
                                        <div class="image-title">
                                            <?php echo esc_html($item['title']); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($item['image_subtitle'])) : ?>
                                        <div class="image-subtitle">
                                            <?php echo esc_html($item['image_subtitle']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php $this->render_swiper_pagination_navigation(); ?>
                </div>
            </div>
            <?php
        }
    }

}

$widgets_manager->register(new Westio_Elementor_Image_Carousel());


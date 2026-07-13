<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Repeater;
use Elementor\Utils;
use Westio\Elementor\Westio_Base_Widgets;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;

/**
 * Class Westio_Elementor_Neighborhood
 */
class Westio_Elementor_Neighborhood extends Westio_Base_Widgets {
    use Westio_Carousel_Trait;

    public function get_name() {
        return 'westio-neighborhood';
    }

    public function get_title() {
        return esc_html__('Westio Neighborhood', 'westio');
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
        return 'eicon-archive';
    }

    public function get_categories() {
        return array('westio-addons');
    }

    public function get_script_depends() {
        return ['westio-elementor-neighborhood', 'westio-elementor-swiper',];
    }

    public function get_style_depends() {
        return ['e-swiper'];
    }

    protected function register_controls() {
        // Query

        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__('Query', 'westio'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'neighborhood-style',
            [
                'label'   => esc_html__('Style', 'westio'),
                'type'    => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    1 => esc_html__('Style 1', 'westio'),
                    2 => esc_html__('Style 2', 'westio'),
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'neighborhood_title',
            [
                'label'       => esc_html__('Title', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Title', 'westio'),
            ]
        );

        $repeater->add_control(
            'neighborhood_desc',
            [
                'label'       => esc_html__('Description', 'westio'),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 3,
                'label_block' => true,
                'placeholder' => esc_html__('Description', 'westio'),
            ]
        );

        $repeater->add_control(
            'neighborhood_link',
            [
                'label'       => esc_html__('Link', 'westio'),
                'type'        => \Elementor\Controls_Manager::URL,
                'options'     => ['url', 'is_external', 'nofollow'],
                'default'     => [
                    'url'         => '',
                    'is_external' => true,
                    'nofollow'    => true,
                    // 'custom_attributes' => '',
                ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'neighborhood_image',
            [
                'label'       => esc_html__('Image', 'westio'),
                'type'        => Controls_Manager::MEDIA,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'neighborhood',
            [
                'label'       => '',
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'value_field' => '{{{ value }}}',
                'separator'   => 'before'
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'neighborhood_image',
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->end_controls_section();

        // Image
        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Image', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .neighborhood-image'              => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .neighborhood-image .entry-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .neighborhood-image-mobile'       => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .neighborhood-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'neighborhood-style' => '1',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'      => esc_html__('Height', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'custom'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .neighborhood-image .entry-image' => 'padding-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .neighborhood-image-mobile img'   => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'neighborhood-style' => '1',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label'      => esc_html__('Width', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'custom'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .neighborhood-image' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .neighborhood-image' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_gap',
            [
                'label'      => esc_html__('Gap', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'custom'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .neighborhood-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'neighborhood-style' => '1',
                ],
            ]
        );

        $this->end_controls_section();

        // Title.
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Text', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .entry-title a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .entry-title'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_text_color_hover',
            [
                'label'     => esc_html__('Hover Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .entry-title a:hover'   => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .entry-title:hover'     => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .active .entry-title'   => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .active .entry-title a' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .entry-title',
            ]
        );

        $this->add_responsive_control(
            'title_space',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .entry-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'desc',
            [
                'label'     => esc_html__('Desc', 'westio'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .neighborhood-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'desc_color_hover',
            [
                'label'     => esc_html__('Hover Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .active .neighborhood-desc'                            => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .elementor-neighborhood-item:hover .neighborhood-desc' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'desc_typography',
                'selector' => '{{WRAPPER}} .neighborhood-desc',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $style    = $settings['neighborhood-style'];

        if (empty($settings['neighborhood'])) {
            return;
        }

        $items = [];

        foreach ($settings['neighborhood'] as $item) {
            $image_url = Group_Control_Image_Size::get_attachment_image_src(
                $item['neighborhood_image']['id'] ?? '',
                'neighborhood_image',
                $settings
            );

            $link_data   = $item['neighborhood_link'] ?? [];
            $link_url    = $link_data['url'] ?? '';
            $is_external = !empty($link_data['is_external']);
            $nofollow    = !empty($link_data['nofollow']);

            $items[] = [
                'image'       => $image_url ?: Utils::get_placeholder_image_src(),
                'title'       => $item['neighborhood_title'] ?? '',
                'desc'        => $item['neighborhood_desc'] ?? '',
                'link'        => $link_url,
                'is_external' => $is_external,
                'nofollow'    => $nofollow,
            ];
        }

        if ($style === '1') { ?>
            <div class="neighborhood-wrapper neighborhood-style-1">
                <div class="neighborhood-content" data-element_type="widget">
                    <div class="title-list">
                        <?php foreach ($items as $desc => $item) :
                            $target = ! empty($item['is_external']) ? '_blank' : '';
                            $rel    = ! empty($item['nofollow']) ? 'nofollow' : '';
                            ?>
                            <div class="neighborhood elementor-neighborhood-item"
                                 data-image="<?php echo esc_url($item['image']); ?>"
                                 data-link="<?php echo esc_url($item['link']); ?>">
                                <h4 class="entry-title">
                                    <?php if (!empty($item['link'])) : ?>
                                        <a href="<?php echo esc_url($item['link']); ?>"
                                            <?php if ($target) : ?> target="<?php echo esc_attr($target); ?>"<?php endif; ?>
                                            <?php if ($rel) : ?> rel="<?php echo esc_attr($rel); ?>"<?php endif; ?>
                                        >
                                            <?php echo esc_html($item['title']); ?>
                                        </a>
                                    <?php else : ?>
                                        <span><?php echo esc_html($item['title']); ?></span>
                                    <?php endif; ?>
                                </h4>

                                <?php if (!empty($item['desc'])) : ?>
                                    <div class="neighborhood-desc">
                                        <?php echo esc_html($item['desc']); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="neighborhood-image-mobile">
                                    <div class="entry-image">
                                        <img
                                                src="<?php echo esc_url($item['image']); ?>"
                                                alt="<?php echo esc_attr($item['title']); ?>"
                                                loading="lazy"
                                                data-desc="<?php echo esc_attr($desc); ?>"
                                        >
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="neighborhood-image">
                    <div class="entry-image">
                        <?php foreach ($items as $desc => $item) : ?>
                            <img
                                    class="neighborhood-main-img <?php echo esc_attr($desc === 0 ? 'active' : ''); ?>"
                                    src="<?php echo esc_url($item['image']); ?>"
                                    alt="<?php echo esc_attr($item['title']); ?>"
                                    loading="lazy"
                                    data-desc="<?php echo esc_attr($desc); ?>"
                            >
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php return;
        }

        if ($style === '2') { ?>
            <div class="neighborhood-wrapper neighborhood-style-2">
                <div class="neighborhood-content" data-element_type="widget">
                    <div class="title-list">
                        <?php foreach ($items as $desc => $item) :
                            $target = ! empty($item['is_external']) ? '_blank' : '';
                            $rel    = ! empty($item['nofollow']) ? 'nofollow' : '';
                            ?>
                            <div class="neighborhood elementor-neighborhood-item"
                                 data-image="<?php echo esc_url($item['image']); ?>"
                                 data-link="<?php echo esc_url($item['link']); ?>">
                                <h4 class="entry-title">
                                    <?php if (!empty($item['link'])) : ?>
                                        <a href="<?php echo esc_url($item['link']); ?>"
                                            <?php if ($target) : ?> target="<?php echo esc_attr($target); ?>"<?php endif; ?>
                                            <?php if ($rel) : ?> rel="<?php echo esc_attr($rel); ?>"<?php endif; ?>
                                        >
                                            <?php echo esc_html($item['title']); ?>
                                        </a>
                                    <?php else : ?>
                                        <span><?php echo esc_html($item['title']); ?></span>
                                    <?php endif; ?>
                                </h4>

                                <?php if (!empty($item['desc'])) : ?>
                                    <div class="neighborhood-desc">
                                        <?php echo esc_html($item['desc']); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="neighborhood-image">
                                    <img
                                            src="<?php echo esc_url($item['image']); ?>"
                                            alt="<?php echo esc_attr($item['title']); ?>"
                                            loading="lazy"
                                            data-desc="<?php echo esc_attr($desc); ?>"
                                    >
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php return;
        }
    }

}

$widgets_manager->register(new Westio_Elementor_Neighborhood());
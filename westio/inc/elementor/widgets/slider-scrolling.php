<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Westio\Elementor\Westio_Base_Widgets;
use Elementor\Group_Control_Background;


class Westio_Elementor_Slider_Scrolling extends Westio_Base_Widgets {

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
        return 'westio-slider-scrolling';
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
        return esc_html__('Westio Slider Scrolling', 'westio');
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
        return 'eicon-image';
    }

    public function get_script_depends() {
        return ['westio-elementor-slider-scrolling'];
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
            'section_slider_scrolling',
            [
                'label' => esc_html__('Slider Scrolling', 'westio'),
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control(
            'selected_icon',
            [
                'label'            => esc_html__('Icon', 'westio'),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
            ]
        );
        $repeater->add_control(
            'scrolling_title',
            [
                'label'   => esc_html__('Title 1', 'westio'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Scrolling title',
            ]
        );
        $repeater->add_control(
            'scrolling_title_link',
            [
                'label'       => esc_html__('Link to', 'westio'),
                'placeholder' => esc_html__('https://your-link.com', 'westio'),
                'type'        => Controls_Manager::URL,
            ]
        );
        $this->add_control(
            'slider_scrolling',
            [
                'label'       => esc_html__('Items', 'westio'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ scrolling_title }}}',
            ]
        );

        $this->add_control(
            'effects_scrolling',
            [
                'label'        => esc_html__('Effects Scrolling', 'westio'),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'scrolling-effects-',

            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_slider_scrolling_wrapper',
            [
                'label' => esc_html__('Wrapper', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'slider_scrolling_padding',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-slider-scrolling-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_scrolling_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-slider-scrolling-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'           => 'overlay_color',
                'types'          => ['classic', 'gradient'],
                'fields_options' => [
                    'background' => [
                        'frontend_available' => true,
                    ],
                ],
                'selector'       => '{{WRAPPER}} .elementor-slider-scrolling-item-wrapper',

            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_slider_scrolling_title',
            [
                'label' => esc_html__('Title', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'slider_scrollingtitle_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-slider-scrolling-inner .elementor-slider-scrolling-item .elementor-scrolling-item-inner .scrolling-title .title-scrolling a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-slider-scrolling-inner .elementor-slider-scrolling-item .elementor-scrolling-item-inner .scrolling-title .title-scrolling'   => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-slider-scrolling-inner .elementor-slider-scrolling-item .elementor-scrolling-item-inner .scrolling-title .title-scrolling',
            ]
        );

        $this->add_responsive_control(
            'slider_scrolling_title_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-slider-scrolling-inner .elementor-slider-scrolling-item .elementor-scrolling-item-inner .scrolling-title ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],
            ]
        );
        $this->add_responsive_control(
            'slider_scrolling_time',
            [
                'label'      => esc_html__('Time scroll', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'unit' => 's',
                ],
                'range'      => [
                    's' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['s', 'ms'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-slider-scrolling-item-wrapper .elementor-slider-scrolling-inner' => 'animation-duration: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'slider_scrolling_direct',
            [
                'label'        => __('Direct', 'westio'),
                'type'         => Controls_Manager::SELECT2,
                'default'      => 'rtl',
                'options'      => [
                    'rtl' => __('RTL', 'westio'),
                    'ltr' => __('LTR', 'westio'),
                ],
                'multiple'     => false,
                'prefix_class' => 'slider-'
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

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-slider-scrolling-inner .elementor-slider-scrolling-item .elementor-scrolling-item-inner .elementor-scrolling-icon'     => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .elementor-slider-scrolling-inner .elementor-slider-scrolling-item .elementor-scrolling-item-inner .elementor-scrolling-icon svg' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_font_size',
            [
                'label'      => esc_html__('Font Size', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .elementor-slider-scrolling-inner .elementor-slider-scrolling-item .elementor-scrolling-item-inner .elementor-scrolling-icon' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'width_svg_scroll',
            [
                'label'          => esc_html__('Width', 'westio'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'size_units'     => ['%', 'px', 'vw'],
                'range'          => [
                    '%'  => [
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
                'selectors'      => [
                    '{{WRAPPER}} .elementor-slider-scrolling-inner .elementor-slider-scrolling-item .elementor-scrolling-item-inner .elementor-scrolling-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'height_svg_scroll',
            [
                'label'          => esc_html__('Height', 'westio'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'size_units'     => ['%', 'px', 'vw'],
                'range'          => [
                    '%'  => [
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
                'selectors'      => [
                    '{{WRAPPER}} .elementor-slider-scrolling-inner .elementor-slider-scrolling-item .elementor-scrolling-item-inner .elementor-scrolling-icon svg' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['slider_scrolling']) && is_array($settings['slider_scrolling'])) {
            $this->add_render_attribute('wrapper', 'class', 'elementor-slider-scrolling-item-wrapper');
            $this->add_render_attribute('inner', 'class', 'elementor-slider-scrolling-inner');
            $this->add_render_attribute('item', 'class', 'elementor-slider-scrolling-item');
            $migration_allowed = Icons_Manager::is_migration_allowed();

            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                <div class="wrapper-item">
                    <?php for ($i = 0; $i <= 3; $i++) : ?>
                        <div <?php $this->print_render_attribute_string('inner'); ?>>
                            <?php foreach ($settings['slider_scrolling'] as $item) :
                                if (!isset($item['icon']) && !$migration_allowed) {
                                    $item['icon'] = isset($fallback_defaults[$item]) ? $fallback_defaults[$index] : 'fa fa-check';
                                }
                                $migrated = isset($service['__fa4_migrated']['selected_icon']);
                                $is_new   = !isset($service['icon']) && $migration_allowed;
                                ?>
                                <div <?php $this->print_render_attribute_string('item'); ?>>
                                    <div class="elementor-scrolling-item-inner">
                                        <div class="scrolling-title">
                                            <?php
                                            $scrolling_title_html = $item['scrolling_title'];
                                            if (!empty($item['scrolling_title_link']['url'])) {
                                                $scrolling_title_html = '<a href="' . esc_url($item['scrolling_title_link']['url']) . '">' . esc_html($scrolling_title_html) . '</a>';
                                            }
                                            printf('<span class="title-scrolling">%s</span>', $scrolling_title_html);
                                            ?>
                                        </div>
                                        <?php
                                        if (!empty($item['icon']) || (!empty($item['selected_icon']['value']) && $is_new)) :
                                            ?>
                                            <span class="elementor-scrolling-icon" <?php $this->print_render_attribute_string('color'); ?>>
                                            <?php
                                            if ($is_new || $migrated) {
                                                Icons_Manager::render_icon($item['selected_icon'], ['aria-hidden' => 'true']);
                                            } else { ?>
                                                <i class="<?php echo esc_attr($service['icon']); ?>" aria-hidden="true"></i>
                                            <?php } ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            <?php
        }
    }

}

$widgets_manager->register(new Westio_Elementor_Slider_Scrolling());
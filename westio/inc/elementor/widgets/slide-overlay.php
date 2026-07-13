<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Core\Schemes;
use Elementor\Utils;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Westio_Elementor_Slide_Overlay extends Widget_Base
{

    public function get_categories()
    {
        return array('westio-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'westio-slide-overlay';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return esc_html__('Westio Slide Overlay', 'westio');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-tabs';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     * @since 2.1.0
     * @access public
     *
     */
    public function get_keywords()
    {
        return ['tabs', 'accordion', 'toggle', 'link', 'showcase'];
    }

    public function get_script_depends()
    {
        return ['westio-elementor-slide-overlay'];
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_items',
            [
                'label' => esc_html__('Items', 'westio'),
            ]
        );

        $this->add_responsive_control(
            'duration',
            [
                'label' => esc_html__('Scrolling duration', 'westio'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'selectors' => [
                    '{{WRAPPER}} .slide-overlay-title-inner' => 'animation-duration: {{VALUE}}s',
                ],
            ]
        );


        $repeater = new Repeater();
        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'westio'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Title', 'westio'),
                'placeholder' => esc_html__('Title', 'westio'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'selected_icon',
            [
                'label'            => esc_html__('Icon', 'westio'),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
            ]
        );
        $repeater->add_control(
            'link_image',
            [
                'label' => esc_html__('Choose Image', 'westio'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Items', 'westio'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('Title #1', 'westio'),
                    ],
                    [
                        'title' => esc_html__('Title #2', 'westio'),
                    ],
                    [
                        'title' => esc_html__('Title #3', 'westio'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'link_image',
                'default' => 'full',
                'separator' => 'none',
            ]
        );


        $this->add_responsive_control(
            'item_spacing',
            [
                'label' => esc_html__('Spacing', 'westio'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'size' => 50
                ],
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-overlay-title' => 'margin-left: calc({{SIZE}}{{UNIT}}/2); margin-right: calc({{SIZE}}{{UNIT}}/2);',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title', 'westio'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'westio'),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-overlay-title' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Text Hover Color', 'westio'),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-overlay-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color_active',
            [
                'label' => esc_html__('Text Active Color', 'westio'),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-overlay-title.elementor-active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
                'selector' => '{{WRAPPER}} .elementor-slide-overlay-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'text_stroke',
                'selector' => '{{WRAPPER}} .elementor-slide-overlay-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .elementor-slide-overlay-title',
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label' => esc_html__('Padding', 'westio'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .slide-overlay-title-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
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
                    '{{WRAPPER}} .slide-overlay-title-inner .elementor-scrolling-icon i' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .slide-overlay-title-inner .elementor-scrolling-icon svg' => 'color: {{VALUE}} !important;',
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
                    '{{WRAPPER}}  .slide-overlay-title-inner .elementor-scrolling-icon i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
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
                    '{{WRAPPER}} .slide-overlay-title-inner .elementor-scrolling-icon svg' => 'width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .slide-overlay-title-inner .elementor-scrolling-icon svg' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $title_html = '';
        $image_html = '';
        if (!empty($settings['items']) && is_array($settings['items'])) {
            $items = $settings['items'];
            // Row
            $this->add_render_attribute('wrapper', 'class', 'elementor-slide-overlay-wrapper');
            $this->add_render_attribute('row', 'class', 'elementor-slide-overlay-inner');
            $this->add_render_attribute('row', 'role', 'tablist');
            ?>

            <?php foreach ($items as $index => $item) :
                $item_title_setting_key = $this->get_repeater_setting_key('item_title', 'items', $index);
                $this->add_render_attribute($item_title_setting_key, [
                    'class' => [
                        'elementor-slide-overlay-title',
                        ($index == 0) ? 'elementor-active' : ''
                    ],
                    'data-trigger' => $index
                ]);

                ob_start();
                ?>
                <div <?php $this->print_render_attribute_string($item_title_setting_key); ?>>
                    <span><?php echo esc_html($item['title']); ?></span>
                </div>
                <?php
                $migrated = isset($item['__fa4_migrated']['selected_icon']);
                $is_new   = empty($item['icon']) && Icons_Manager::is_migration_allowed();

                if ( ! empty($item['icon']) || ( ! empty($item['selected_icon']['value']) && $is_new ) ) : ?>
                    <span class="elementor-scrolling-icon">
                            <?php
                            if ($is_new || $migrated) {
                                Icons_Manager::render_icon($item['selected_icon'], ['aria-hidden' => 'true']);
                            } else { ?>
                                <i class="<?php echo esc_attr($item['icon']); ?>" aria-hidden="true"></i>
                            <?php } ?>
                        </span>
                <?php endif; ?>
                <?php
                $title_html .= ob_get_clean();
                ob_start();
                $item_content_setting_key = $this->get_repeater_setting_key('item_content', 'items', $index);
                $this->add_render_attribute($item_content_setting_key, [
                    'class' => [
                        'elementor-slide-overlay-content',
                        ($index == 0) ? 'elementor-active' : '',
                    ],
                    'data-target' => $index
                ]);
                ?>
                <div <?php $this->print_render_attribute_string($item_content_setting_key); ?>>
                    <?php $this->render_image($settings, $item); ?>
                </div>
                <?php
                $image_html .= ob_get_clean();
            endforeach; ?>
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                <div <?php $this->print_render_attribute_string('row'); ?>>
                    <div class="slide-overlay-title-wrapper">
                        <div class="slide-overlay-title-inner">
                            <?php printf('%s', $title_html); ?>
                        </div>
                        <div class="slide-overlay-title-inner">
                            <?php printf('%s', $title_html); ?>
                        </div>
                        <div class="slide-overlay-title-inner">
                            <?php printf('%s', $title_html); ?>
                        </div>
                    </div>
                    <div class="slide-overlay-content-wrapper">
                        <div class="slide-overlay-content-inner">
                            <?php printf('%s', $image_html); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    private function render_image($settings, $item)
    {
        if (!empty($item['link_image']['url'])) :
            ?>
            <?php
            $item['link_image_size'] = $settings['link_image_size'];
            $item['link_image_custom_dimension'] = $settings['link_image_custom_dimension'];
            echo Group_Control_Image_Size::get_attachment_image_html($item, 'link_image');
            ?>
        <?php
        endif;
    }
}

$widgets_manager->register(new Westio_Elementor_Slide_Overlay());

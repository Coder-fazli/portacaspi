<?php

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Westio\Elementor\Westio_Base_Widgets;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Westio_Elementor_Connect_Box extends Westio_Base_Widgets {

    public function get_name() {
        return 'westio-connect_box';
    }

    public function get_title() {
        return esc_html__('Westio Connect Box', 'westio');
    }

    public function get_icon() {
        return 'eicon-editor-link';
    }

    public function get_keywords() {
        return ['Info', 'Minimalist'];
    }

    public function get_categories() {
        return array('westio-addons');
    }

    public function get_style_depends() {
        return ['elementor-icons-fa-solid', 'elementor-icons-fa-brands', 'elementor-icons-fa-regular'];
    }

    public function has_widget_inner_wrapper(): bool {
        return !Plugin::$instance->experiments->is_feature_active('e_optimized_markup');
    }

    protected function register_controls() {
        $column = range(1, 5);
        $column = array_combine($column, $column);

        $this->start_controls_section(
            'section_contact_info',
            [
                'label' => esc_html__('Contact Info', 'westio'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Nested Repeater: Social Icons
        $social_repeater = new Repeater();

        $social_repeater->add_control(
            'social_title',
            [
                'label'   => esc_html__('Title', 'westio'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Facebook',
            ]
        );

        $social_repeater->add_control(
            'social_icon',
            [
                'label'            => esc_html__('Icon', 'westio'),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'          => [
                    'value'   => 'fab fa-facebook-f',
                    'library' => 'fa-brands',
                ],
            ]
        );

        $social_repeater->add_control(
            'social_link',
            [
                'label'       => esc_html__('Link', 'westio'),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-social.com', 'westio'),
            ]
        );

        // Item repeater
        $repeater = new Repeater();

        $repeater->add_control(
            'option',
            [
                'label'   => esc_html__('Option', 'westio'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'text'   => esc_html__('Text', 'westio'),
                    'social' => esc_html__('Social', 'westio'),
                ],
                'default' => 'text'
            ]
        );

        $repeater->add_control(
            'heading',
            [
                'label'       => esc_html__('Title', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Phone', 'westio'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'information',
            [
                'label'       => esc_html__('Information', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__(' Your Information', 'westio'),
                'label_block' => true,
                'condition'   => [
                    'option' => 'text',
                ],
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label'       => esc_html__('Icon', 'westio'),
                'type'        => Controls_Manager::ICONS,
                'label_block' => false,
                'skin'        => 'inline',
                'default'     => [
                    'value'   => 'fas fa-phone',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'socials',
            [
                'label'        => esc_html__('Social Links', 'westio'),
                'type'         => Controls_Manager::REPEATER,
                'fields'       => $social_repeater->get_controls(),
                'title_field'  => '{{{ social_title }}}',
                'max_items'    => 5,
                'condition'    => [
                    'option' => 'social',
                ],
                'item_actions' => [
                    'add' => false,
                ],
                'default'      => [
                    [
                        'social_title' => esc_html__('Facebook', 'westio'),
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'         => esc_html__('Link', 'westio'),
                'type'          => Controls_Manager::URL,
                'placeholder'   => esc_html__('https://your-link.com', 'westio'),
                'show_external' => true,
                'condition'     => [
                    'option' => 'text',
                ],
                'default'       => [
                    'url'         => '',
                    'is_external' => false,
                    'nofollow'    => false,
                ],
            ]
        );

        $this->add_control(
            'contact_items',
            [
                'label'       => esc_html__('Contact Items', 'westio'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'heading' => esc_html__('Phone', 'westio'),
                        'icon'    => ['value' => 'fas fa-phone', 'library' => 'fa-solid'],
                    ],
                    [
                        'heading' => esc_html__('Email', 'westio'),
                        'icon'    => ['value' => 'fas fa-envelope', 'library' => 'fa-solid'],
                    ],
                ],
                'title_field' => '{{{ heading }}}',
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'              => esc_html__('Columns', 'westio'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 2,
                'options'            => $column,
                'frontend_available' => true,
                'separator'          => 'before',
                'render_type'        => 'template',
                'selectors'          => [
                    '{{WRAPPER}} .contact-info-box' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_responsive_control(
            'gaps',
            [
                'label'      => esc_html__('Gaps', 'westio'),
                'type'       => Controls_Manager::GAPS,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'default'    => [
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .contact-info-box' => 'gap: {{ROW}}{{UNIT}} {{COLUMN}}{{UNIT}};',
                ],
                'responsive' => true,
                'validators' => [
                    'Number' => [
                        'min' => 0,
                    ],
                ],
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
            'style_wrapper_padding',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .contact-info-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'style_wrapper_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .contact-info-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
            'style_item_padding',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'style_item_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'style-item-border',
                'selector'  => '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-link',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'style_content_heading',
            [
                'label'     => esc_html__('Content', 'westio'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'style_content_typography',
                'selector' => '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-link',
            ]
        );

        $this->start_controls_tabs('style_content_tabs');

        $this->start_controls_tab('style_content_tabs_normal',
            [
                'label' => esc_html__('Normal', 'westio'),
            ]
        );

        $this->add_control(
            'style_content_color',
            [
                'label'      => esc_html__('Color', 'westio'),
                'type'       => Controls_Manager::COLOR,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('style_content_tabs_hover',
            [
                'label' => esc_html__('Hover', 'westio'),
            ]
        );

        $this->add_control(
            'style_content_color_hover',
            [
                'label'      => esc_html__('Color', 'westio'),
                'type'       => Controls_Manager::COLOR,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-link:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'style_icon_heading',
            [
                'label'     => esc_html__('Icon', 'westio'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'style_icon_size',
            [
                'label'     => esc_html__('Size', 'westio'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-link .contact-info-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-link .contact-info-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->start_controls_tabs('style_icon_tabs');

        $this->start_controls_tab('style_icon_tabs_normal',
            [
                'label' => esc_html__('Normal', 'westio'),
            ]
        );

        $this->add_control(
            'style_icon_color',
            [
                'label'      => esc_html__('Color', 'westio'),
                'type'       => Controls_Manager::COLOR,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-link .contact-info-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('style_icon_tabs_hover',
            [
                'label' => esc_html__('Hover', 'westio'),
            ]
        );

        $this->add_control(
            'style_icon_color_hover',
            [
                'label'      => esc_html__('Color', 'westio'),
                'type'       => Controls_Manager::COLOR,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-link:hover .contact-info-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_social',
            [
                'label' => esc_html__('Social', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'style_social_spacing',
            [
                'label'     => esc_html__('Spacing', 'westio'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-text-wrapper .contact-info-socials-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'style_social_size',
            [
                'label'     => esc_html__('Size', 'westio'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-text-wrapper .contact-info-socials-wrapper .social'     => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-text-wrapper .contact-info-socials-wrapper .social svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->start_controls_tabs('style_social_tabs');

        $this->start_controls_tab('style_social_tabs_normal',
            [
                'label' => esc_html__('Normal', 'westio'),
            ]
        );

        $this->add_control(
            'style_social_color',
            [
                'label'      => esc_html__('Color', 'westio'),
                'type'       => Controls_Manager::COLOR,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-text-wrapper .contact-info-socials-wrapper .social a' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('style_social_tabs_hover',
            [
                'label' => esc_html__('Hover', 'westio'),
            ]
        );

        $this->add_control(
            'style_social_color_hover',
            [
                'label'      => esc_html__('Color', 'westio'),
                'type'       => Controls_Manager::COLOR,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .contact-info-box .contact-info-item .contact-info-text-wrapper .contact-info-socials-wrapper .social a:hover' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['contact_items'])) {
            return;
        }
        ?>

        <div class="contact-info-box">
            <?php foreach ($settings['contact_items'] as $index => $item) :
                $link_key = 'link_' . $index;

                $is_text_mode = $item['option'] === 'text';

                if ($is_text_mode && !empty($item['link'])) {
                    $this->add_link_attributes($link_key, $item['link']);
                }
                ?>

                <div class="contact-info-item">
                    <?php if ($is_text_mode && !empty($item['link']['url'])) : ?>
                        <a <?php $this->print_render_attribute_string($link_key); ?> class="contact-info-link">
                    <?php else : ?>
                        <div class="contact-info-link">
                        <?php endif; ?>

                            <?php if (!empty($item['heading'])) : ?>
                                <div class="contact-info-text-wrapper">
                                    <span class="contact-info-label"><?php echo esc_html($item['heading']); ?></span>

                                    <div class="contact-info-text">
                                        <?php
                                        if ($is_text_mode) {
                                            echo esc_html(isset($item['information']) ? $item['information'] : '');
                                        } else {
                                            if (!empty($item['socials'])) { ?>
                                                <div class="contact-info-socials-wrapper">
                                                    <?php foreach ($item['socials'] as $social) :
                                                        $social_url = isset($social['social_link']['url']) ? $social['social_link']['url'] : '';
                                                        $social_title = isset($social['social_title']) ? $social['social_title'] : '';
                                                        $is_external = !empty($social['social_link']['is_external']);
                                                        ?>
                                                        <span class="social">
                                                            <a href="<?php echo esc_url($social_url); ?>"
                                                               title="<?php echo esc_attr($social_title); ?>"
                                                               target="<?php echo esc_attr($is_external ? '_blank' : '_self'); ?>">
                                                                <?php Icons_Manager::render_icon($social['social_icon'], ['aria-hidden' => 'true']); ?>
                                                            </a>
                                                        </span>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($item['icon']['value'])) : ?>
                                <span class="contact-info-icon">
                                    <?php Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']); ?>
                                </span>
                            <?php endif; ?>

                    <?php if ($is_text_mode && !empty($item['link']['url'])) : ?>
                        </a>
                    <?php else : ?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endforeach; ?>

        </div>

        <?php
    }
}

$widgets_manager->register(new Westio_Elementor_Connect_Box());

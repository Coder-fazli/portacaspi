<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Westio\Elementor\Westio_Base_Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

/**
 * Elementor Archive Post widget.
 *
 *
 * @since 1.0.0
 */
class Westio_Elementor_Archive_post extends Westio_Base_Widgets {

    public function get_categories() {
        return array('westio-addons');
    }

    public function get_name() {
        return 'westio-archive-post';
    }

    public function get_title() {
        return esc_html__('Westio Archive Post', 'westio');
    }

    public function get_icon() {
        return 'eicon-archive';
    }

    public function has_widget_inner_wrapper(): bool {
        return !\Elementor\Plugin::$instance->experiments->is_feature_active('e_optimized_markup');
    }

    protected function register_controls() {
        $column = range(1, 10);
        $column = array_combine($column, $column);
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Settings', 'westio'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'style',
            [
                'label'   => esc_html__('Style', 'westio'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'grid' => esc_html__('Grid', 'westio'),
                    'list' => esc_html__('List', 'westio'),
                ],
                'default' => 'grid'
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'              => esc_html__('Columns', 'westio'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 4,
                'options'            => [
                                            '' => esc_html__('Default', 'westio'),
                                        ] + $column,
                'frontend_available' => true,
                'render_type'        => 'template',
                'prefix_class'       => 'elementor-grid%s-',
                'selectors'          => [
                    '{{WRAPPER}}' => '--e-global-column-to-show: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'column_spacing',
            [
                'label'              => esc_html__('Column Spacing', 'westio'),
                'type'               => Controls_Manager::SLIDER,
                'range'              => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default'            => [
                    'size' => 30,
                ],
                'frontend_available' => true,
                'selectors'          => [
                    '{{WRAPPER}}' => '--grid-column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'row_spacing',
            [
                'label'              => esc_html__('Row Spacing', 'westio'),
                'type'               => Controls_Manager::SLIDER,
                'range'              => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default'            => [
                    'size' => 30,
                ],
                'frontend_available' => true,
                'selectors'          => [
                    '{{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_wrapper_style',
            [
                'label' => esc_html__('Wrapper', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} article.post-style-list'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} article.post-style-special' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} article.post-style-grid'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} article.post-style-list'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} article.post-style-special' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} article.post-style-grid'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'wrapper_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} article.post-style-list, {{WRAPPER}} article.post-style-grid, {{WRAPPER}} article.post-style-special',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'border-radius',
            [
                'label'      => esc_html__('Border Radius', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} article' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_img_style',
            [
                'label' => esc_html__('Image', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .post-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .post-inner'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'width_img',
            [
                'label'      => esc_html__('Width', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    '%'  => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'condition'  => [
                    'post_style' => 'list',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .post-inner .post-image' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__('Content', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_background',
            [
                'label'     => esc_html__('Background Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} article .post-content' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_width',
            [
                'label'      => esc_html__('Width Content', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    '%'  => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'condition'  => [
                    'post_style' => 'post-special',
                ],
                'selectors'  => [
                    '{{WRAPPER}} article.post-style-special .post-content'      => 'max-width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} article.post-style-special .post-inner:before' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'content_alignment',
            [
                'label'        => esc_html__('Alignment', 'westio'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'top'     => [
                        'title' => esc_html__('Top', 'westio'),
                        'icon'  => 'eicon-flex eicon-align-start-v',
                    ],
                    'middle'  => [
                        'title' => esc_html__('Middle', 'westio'),
                        'icon'  => 'eicon-flex eicon-align-center-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__('Stretch', 'westio'),
                        'icon'  => 'eicon-flex eicon-align-stretch-v',
                    ],
                    'bottom'  => [
                        'title' => esc_html__('Bottom', 'westio'),
                        'icon'  => 'eicon-flex eicon-align-end-v',
                    ],
                ],
                'default'      => 'middle',
                'toggle'       => false,
                'prefix_class' => 'elementor-align-',
                'condition'    => [
                    'post_style' => 'list',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin_content',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} article .post-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding_content',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} article .post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_heading',
            [
                'label' => esc_html__('Title', 'westio'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} article .post-content .entry-title',
            ]
        );

        $this->add_responsive_control(
            'margin_title',
            [
                'label'      => esc_html__('Margin Title', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} article .entry-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} article .post-content .entry-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} article .post-content .entry-title a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'desc_heading',
            [
                'label'     => esc_html__('Description', 'westio'),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'post_style' => 'list',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'desc_typography',
                'selector'  => '{{WRAPPER}} .post-content .excerpt-content',
                'condition' => [
                    'post_style' => 'list',
                ],
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-content .excerpt-content' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'post_style' => 'list',
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_controls_settings();

        $allowed_styles = [ 'grid', 'list'];
        $style = $settings['style'] ?? 'grid';
        $style = in_array( $style, $allowed_styles, true ) ? $style : 'grid';

        $this->add_render_attribute([
            'wrapper' => [
                'class' => [
                    'archive-wrapper',
                    'blog-style-' . $style,
                ]
            ],
            'inner'   => [
                'class' => 'elementor-grid'
            ],
            'item'    => [
                'class' => 'elementor-posts-item'
            ]
        ]);

        ?>
        <div <?php $this->print_render_attribute_string('wrapper') ?> >
            <div <?php $this->print_render_attribute_string('inner') ?> >
                <?php

                if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
                    $params = array(
                        'posts_per_page' => -1,
                        'post_type'      => 'post',
                    );

                    $query = new WP_Query($params);

                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            ?>
                            <div <?php $this->print_render_attribute_string('item'); ?>>
                                <?php get_template_part('template-parts/posts-grid/item-post-' . $style); ?>
                            </div>
                            <?php

                        }
                    }

                    wp_reset_postdata();

                } else {
                    if (have_posts()) {
                        global $wp_query;
                        while (have_posts()) {
                            the_post();
                            ?>
                            <div <?php $this->print_render_attribute_string('item'); ?>>
                                <?php get_template_part('template-parts/posts-grid/item-post-' . $style); ?>
                            </div>
                            <?php

                        }
                    } else {
                        echo '<p>' . esc_html__('There are no posts', 'westio') . '</p>';
                    }
                }
                ?>
            </div>
        </div>

        <?php
        /**
         * Functions hooked in to westio_loop_after action
         *
         * @see westio_paging_nav - 10
         */
        do_action('westio_loop_after');
    }
}

$widgets_manager->register(new Westio_Elementor_Archive_post());

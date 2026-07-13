<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Westio\Elementor\Westio_Base_Widgets;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Westio\elementor\Controls\Westio_Group_Control_Query;
use Westio\Elementor\Westio_Posttype_Query;
use Elementor\Skin_Base;

/**
 * Class Westio_Elementor_Blog
 */
class Westio_Elementor_Post_Grid extends Westio_Base_Widgets {
    use Westio_Carousel_Trait;

    public function get_name() {
        return 'westio-post-grid';
    }

    public function get_title() {
        return esc_html__('Posts Grid', 'westio');
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
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return array('westio-addons');
    }

    public function get_script_depends() {
        return ['westio-elementor-posts-grid', 'westio-elementor-swiper'];
    }

    public function get_style_depends() {
        return ['e-swiper'];
    }

    public function get_name_query() {
        return 'post';
    }

    public function has_widget_inner_wrapper(): bool {
        return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
    }

    protected function register_controls() {
        $column = range(1, 10);
        $column = array_combine($column, $column);
        $this->start_controls_section(
            'section_column_options',
            [
                'label' => esc_html__('Layout', 'westio')
            ]
        );

        $this->add_control(
            'post_style',
            [
                'label'   => esc_html__('Style', 'westio'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'post-grid'    => esc_html__('Style 1', 'westio'),
                    'post-list'    => esc_html__('Style 2', 'westio'),
                    'post-special'    => esc_html__('Style 3', 'westio'),
                ],
                'default' => 'post-grid'
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
                    '{{WRAPPER}}'                               => '--e-global-column-to-show: {{VALUE}}',
                    //                    '(widescreen){{WRAPPER}} .grid__item'     => 'width: calc((100% - {{column_spacing_widescreen.SIZE}}{{column_spacing_widescreen.UNIT}}*({{column_widescreen.VALUE}} - 1)) / {{column_widescreen.VALUE}})',
                    '{{WRAPPER}} .elementor-item'               => 'width: calc((100% - {{column_spacing.SIZE}}{{column_spacing.UNIT}}*({{column.VALUE}} - 1)) / {{column.VALUE}});',
                    '(laptop){{WRAPPER}} .elementor-item'       => 'width: calc((100% - {{column_spacing.SIZE}}{{column_spacing.UNIT}}*({{column_laptop.VALUE}} - 1)) / {{column_laptop.VALUE}});',
                    '(tablet_extra){{WRAPPER}} .elementor-item' => 'width: calc((100% - {{column_spacing.SIZE}}{{column_spacing.UNIT}}*({{column_tablet_extra.VALUE}} - 1)) / {{column_tablet_extra.VALUE}});',
                    '(tablet){{WRAPPER}} .elementor-item'       => 'width: calc((100% - {{column_spacing.SIZE}}{{column_spacing.UNIT}}*({{column_tablet.VALUE}} - 1)) / {{column_tablet.VALUE}});',
                    '(mobile_extra){{WRAPPER}} .elementor-item' => 'width: calc((100% - {{column_spacing.SIZE}}{{column_spacing.UNIT}}*({{column_mobile_extra.VALUE}} - 1)) / {{column_mobile_extra.VALUE}});',
                    '(mobile){{WRAPPER}} .elementor-item'       => 'width: calc((100% - {{column_spacing.SIZE}}{{column_spacing.UNIT}}*({{column_mobile.VALUE}} - 1)) / {{column_mobile.VALUE}});',
                ],
                'condition'          => [
                    'enable_carousel!' => 'yes'
                ],
            ]
        );

        $this->add_control('enable_carousel', [
            'label'   => esc_html__('Enable Carousel', 'westio'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'no',
        ]);

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'post_image',
                'default'   => 'full',
                'separator' => 'none',
                'condition' => [
                    'post_style!' => 'post-special',
                ]
            ]
        );

        $this->add_responsive_control(
            'item_ratio',
            [
                'label'          => esc_html__('Image Ratio', 'westio'),
                'type'           => Controls_Manager::SLIDER,
                'selectors'      => [
                    '{{WRAPPER}} .post-thumbnail' => 'padding-top: calc( {{SIZE}} * 100% );',
                ],
                'condition' => [
                    'post_style!' => 'post-special',
                ]
            ]
        );

        $this->add_control(
            'hidden_content',
            [
                'label'     => esc_html__('Hidden Content', 'westio'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'post_style' => 'post-list',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__( 'Query', 'westio' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_group_control(
            Westio_Group_Control_Query::get_type(),
            [
                'name'     => $this -> get_name_query(),
                'presets'  => [ 'full' ],
                'post_type' => 'post',
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
                'condition'          => [
                    'enable_carousel!' => 'yes'
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
                'condition'          => [
                    'enable_carousel!' => 'yes'
                ],
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
                'condition' => [
                    'post_style!' => 'post-special',
                ]
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
                    'post_style' => 'post-list',
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
                    'post_style' => 'post-list',
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

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'content_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} article.post-style-list .post-content, {{WRAPPER}} article.post-style-grid .post-content, {{WRAPPER}} article.post-style-special .post-content',
                'separator'   => 'before',
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
                    'post_style' => 'post-list',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'desc_typography',
                'selector'  => '{{WRAPPER}} .post-content .excerpt-content',
                'condition' => [
                    'post_style' => 'post-list',
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
                    'post_style' => 'post-list',
                ],
            ]
        );


        $this->end_controls_section();

        $this->get_control_pagination(['enable_carousel!' => 'yes']);
        $this->add_control_carousel(['enable_carousel' => 'yes']);
    }

    public function get_query( $widget, $name, $query_args = []) {
        $prefix = $name . '_';
        $post_type = $widget->get_settings( $prefix . 'post_type' );
        $elementor_query = new Westio_Posttype_Query( $widget, $name, $query_args );

        return $elementor_query->get_query();
    }

    public function query_posts() {
        return $this->get_query($this, $this -> get_name_query());
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        set_query_var('settings', $settings);

        $allowed_styles = [ 'post-grid', 'post-list', 'post-special' ];
        $style = $settings['post_style'] ?? 'post-grid';
        $style = in_array( $style, $allowed_styles, true ) ? $style : 'post-grid';

        $query = $this->query_posts();

        if (!$query->found_posts) {
            return;
        }
        $this->add_render_attribute(
            [
                'wrapper'   => [
                    'class' => ['elementor-post-wrapper', 'layout-' . $settings['post_style']]
                ],
                'container' => [
                    'data-count' => $query->post_count,
                    'data-center' => $settings['center'] ?? false,
                ],
                'item'      => [
                    'class' => 'elementor-posts-item',
                ]
            ]
        );
        $this->get_data_elementor_columns();
        $this->get_data_elementor_carousel();

        ?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <div <?php $this->print_render_attribute_string('container'); ?>>
                <div <?php $this->print_render_attribute_string('inner'); ?>>
                    <?php

                    while ($query->have_posts()) {
                        $query->the_post();
                        ?>
                        <div <?php $this->print_render_attribute_string('item'); ?>>
                            <?php get_template_part('template-parts/posts-grid/item-' . $style); ?>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                    ?>
                </div>
                <?php $this->render_swiper_pagination_navigation(); ?>
            </div>
            <?php $this->render_loop_footer(); ?>
        </div>
        <?php
    }
}

$widgets_manager->register(new Westio_Elementor_Post_Grid());
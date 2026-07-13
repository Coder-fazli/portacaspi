<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Westio\Elementor\Westio_Base_Widgets;


class Westio_Elementor_Testimonials extends Westio_Base_Widgets {
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
        return 'westio-testimonials';
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
        return esc_html__('Westio Testimonials', 'westio');
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
        return 'eicon-testimonial';
    }

    public function get_script_depends() {
        return ['westio-elementor-testimonial', 'westio-elementor-swiper'];
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
            'section_testimonial',
            [
                'label' => esc_html__('Testimonials', 'westio'),
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'testimonial_icon',
            [
                'label' => esc_html__('Icon', 'westio'),
                'type'  => Controls_Manager::ICONS,
            ]
        );
        $repeater->add_control(
            'testimonial_rating',
            [
                'label' => esc_html__('Rating', 'westio'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 5,
                'step' => 0.1,
                'default' => 5,
            ]
        );

        $repeater->add_control(
            'testimonial_content',
            [
                'label'       => esc_html__('Content', 'westio'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                'label_block' => true,
                'rows'        => '6',
            ]
        );

        $repeater->add_control(
            'testimonial_name',
            [
                'label'   => esc_html__('Name', 'westio'),
                'default' => 'John Doe',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'testimonial_job',
            [
                'label'   => esc_html__('Job', 'westio'),
                'default' => 'Design',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'testimonial_link',
            [
                'label'       => esc_html__('Link to', 'westio'),
                'placeholder' => esc_html__('https://your-link.com', 'westio'),
                'type'        => Controls_Manager::URL,
            ]
        );

        $repeater->add_control(
            'testimonial_image',
            [
                'label'      => esc_html__('Choose Image', 'westio'),
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label'       => esc_html__('Items', 'westio'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ testimonial_name }}}',
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'testimonial_image',
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'testimonial_layout',
            [
                'label'   => esc_html__('Layout', 'westio'),
                'type'    => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => 'Style 1',
                    '2' => 'Style 2',
                    '3' => 'Style 3',
                ],
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

        // WRAPPER STYLE
        $this->start_controls_section(
            'section_style_testimonial',
            [
                'label' => esc_html__('Wrapper', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'padding_testimonial',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'testimonial_layout!' => ['1', '2'],
                ],
            ]
        );
        $this->add_responsive_control(
            'padding_testimonial_caption',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-item-wrapper .layout-1 .testimonial-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-testimonial-item-wrapper .layout-2 .testimonial-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'testimonial_layout' => ['1', '2'],
                ],

            ]
        );

        $this->add_responsive_control(
            'margin_testimonial',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'color_testimonial_background',
            [
                'label'     => esc_html__('Background Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .inner' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'testimonial_box-shadow',
                'selector' => '{{WRAPPER}} .inner',
            ]
        );


        $this->add_responsive_control(
            'testimonial_alignment',
            [
                'label'       => esc_html__('Alignment Content', 'westio'),
                'type'        => Controls_Manager::CHOOSE,
                'options'     => [
                    'left'   => [
                        'title' => esc_html__('Left', 'westio'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'westio'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'westio'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'label_block' => false,
                'selectors'   => [
                    '{{WRAPPER}} .elementor-testimonial-item-wrapper .inner'                                  => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .elementor-testimonial-item-wrapper .content'                                => 'text-align: {{VALUE}};',
                ],

            ]
        );
        $this->add_responsive_control(
            'align_caption',
            [
                'label'     => esc_html__('Alignment Info ', 'westio'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'westio'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'     => [
                        'title' => esc_html__('Center', 'westio'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__('Right', 'westio'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'   => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-item-wrapper .testimonial-caption'              => 'justify-content: {{VALUE}}',
                    '{{WRAPPER}} .elementor-testimonial-item-wrapper .elementor-testimonial-rating'     => 'justify-content: {{VALUE}}',
                    '{{WRAPPER}} .elementor-testimonial-item-wrapper .name '                             => 'justify-content: {{VALUE}}',
                    '{{WRAPPER}} .elementor-testimonial-item-wrapper .job '                             => 'justify-content: {{VALUE}}',
                    '{{WRAPPER}} .elementor-testimonial-item-wrapper .testimonial-caption .caption-top' => 'justify-content: {{VALUE}}',
                    '{{WRAPPER}} .elementor-testimonial-item-wrapper .layout-2 .icon'                   => 'justify-content: {{VALUE}}'
                ],

            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'wrapper_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .inner',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'border_radius_box',
            [
                'label'      => esc_html__('Border Radius', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_testimonial_img',
            [
                'label' => esc_html__('Image', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'testimonial_width_img',
            [
                'label'      => esc_html__('Width', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%', 'vw'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-image img'           => 'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .layout-2 .elementor-testimonial-image img' => 'min-width: {{SIZE}}{{UNIT}}',
                ],
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
                    '{{WRAPPER}} .elementor-testimonial-image img' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'testimonial_radius_img',
            [
                'label'      => esc_html__('Border Radius', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding_testimonial_img',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-testimonial-item-wrapper .layout-1 .caption-top' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin_testimonial_img',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Content style
        $this->start_controls_section(
            'section_style_testimonial_style',
            [
                'label' => esc_html__('Content', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'testimonial_height_content',
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
                    '{{WRAPPER}} .testimonial-caption' => 'min-height: {{SIZE}}{{UNIT}}',
                ],
                'condition'    => [
                    'testimonial_layout' => '1',
                ],
            ]
        );

        $this->add_control(
            'content_content_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_content_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .inner:hover .content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .content',
            ]
        );

        $this->add_responsive_control(
            'content_spacing',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-testimonial-item-wrapper.layout-wrapper-3 .layout-3 .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();


        // Name.
        $this->start_controls_section(
            'section_style_testimonial_name',
            [
                'label' => esc_html__('Name', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_text_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .name, {{WRAPPER}} .name a'                                 => 'color: {{VALUE}};',
                    '{{WRAPPER}} .caption-bottom .name, {{WRAPPER}} .caption-bottom .name a' => 'color: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'name_text_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .inner .name:hover, {{WRAPPER}} .inner .name a:hover'                   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .caption-bottom .name:hover, {{WRAPPER}} .caption-bottom .name a:hover' => 'color: {{VALUE}};',

                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'selector' => '{{WRAPPER}} .name',
            ]
        );

        $this->add_responsive_control(
            'name_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],
            ]
        );

        $this->end_controls_section();

        // Job.
        $this->start_controls_section(
            'section_style_testimonial_job',
            [
                'label' => esc_html__('Job', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'job_text_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .job'                 => 'color: {{VALUE}};',
                    '{{WRAPPER}} .caption-bottom .job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'job_text_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .inner:hover .job' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'job_typography',
                'selector' => '{{WRAPPER}} .job',
            ]
        );

        $this->end_controls_section();

        // rating
        $this->start_controls_section(
            'section_style_testimonial_rating',
            [
                'label' => esc_html__('Rating', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'rating_title',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__('Title', 'westio'),
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'rating_title_color',
            [
                'label'     => esc_html__('Title Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-caption .rating-icon .elementor-testimonial-rating-wrap .testimonial-rating-title ' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-testimonial-rating-wrap .testimonial-rating-title ' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'rating_title_typography',
                'selector' => '{{WRAPPER}} .testimonial-caption .rating-icon .elementor-testimonial-rating-wrap .testimonial-rating-title, {{WRAPPER}} .elementor-testimonial-rating-wrap .testimonial-rating-title',
            ]
        );
        $this->add_responsive_control(
            'title_rating_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .testimonial-caption .rating-icon .elementor-testimonial-rating-wrap .testimonial-rating-title ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-testimonial-rating-wrap .testimonial-rating-title ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],
            ]
        );
        $this->add_control(
            'rating_value',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__('Rating Value', 'westio'),
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'rating_value_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-caption .rating-icon .elementor-testimonial-rating-wrap .elementor-testimonial-rating-number .rating-value ' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-testimonial-rating-wrap .elementor-testimonial-rating-number .rating-value ' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'rating_value_typography',
                'selector' => '{{WRAPPER}} .testimonial-caption .rating-icon .elementor-testimonial-rating-wrap .elementor-testimonial-rating-number .rating-value, {{WRAPPER}} .elementor-testimonial-rating-wrap .elementor-testimonial-rating-number .rating-value ',
            ]
        );
        $this->add_control(
            'rating_total',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__('Rating Total', 'westio'),
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'rating_total_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-caption .rating-icon .elementor-testimonial-rating-wrap .elementor-testimonial-rating-number .rating-total ' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-testimonial-rating-wrap .elementor-testimonial-rating-number .rating-total ' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'rating_total_typography',
                'selector' => '{{WRAPPER}} .testimonial-caption .rating-icon .elementor-testimonial-rating-wrap .elementor-testimonial-rating-number .rating-total, {{WRAPPER}} .elementor-testimonial-rating-wrap .elementor-testimonial-rating-number .rating-total ',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_testimonial_icon',
            [
                'label' => esc_html__('Icon', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__('Icon Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .icon i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'     => esc_html__('Icon Size', 'westio'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        if (!empty($settings['testimonials']) && is_array($settings['testimonials'])) {
            $this->add_render_attribute('wrapper', 'class', 'layout-wrapper-'. esc_attr($settings['testimonial_layout']) . ' elementor-testimonial-item-wrapper');
            $this->add_render_attribute('inner', 'class', 'layout-' . esc_attr($settings['testimonial_layout']));
            // Container
            $this->add_render_attribute(['container' => ['data-center' => $settings['center'] ?? false,],]);
            $this->add_render_attribute('container', 'class', ' elementor-testimonials-swiper' );

            $this->add_render_attribute('container', 'data-count', count($settings['testimonials']));
            // Item
            $this->add_render_attribute('item', 'class', 'elementor-grid-item elementor-testimonial-item');
            $this->add_render_attribute('details', 'class', 'details');
            $this->get_data_elementor_columns();
            $this->get_data_elementor_carousel();
            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                <div <?php $this->print_render_attribute_string('container'); ?>>
                    <div <?php $this->print_render_attribute_string('inner'); ?>>
                        <?php foreach ($settings['testimonials'] as $testimonial): ?>
                            <div <?php $this->print_render_attribute_string('item'); ?>>
                                <?php if ($settings['testimonial_layout'] == '1'): ?>
                                    <div class="item-inner inner">
                                        <div class="testimonial-caption">
                                            <?php if (!empty($testimonial['testimonial_content'])) : ?>
                                                <div class="content"><?php echo sprintf('%s', $testimonial['testimonial_content']); ?></div>
                                            <?php endif; ?>
                                            <div class="rating-icon">
                                                <?php $this->render_rating($testimonial); ?>
                                                <div class="icon">
                                                    <?php \Elementor\Icons_Manager::render_icon($testimonial['testimonial_icon'], ['aria-hidden' => 'true']); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="caption-top">
                                            <?php $this->render_image($settings, $testimonial); ?>
                                            <div <?php $this->print_render_attribute_string('details'); ?>>
                                                <?php
                                                $testimonial_name_html = $testimonial['testimonial_name'];
                                                if (!empty($testimonial['testimonial_link']['url'])) :
                                                    $testimonial_name_html = '<a href="' . esc_url($testimonial['testimonial_link']['url']) . '">' . esc_html($testimonial_name_html) . '</a>';
                                                endif;
                                                printf('<span class="name">%s</span>', $testimonial_name_html);
                                                ?>
                                                <?php if ($testimonial['testimonial_job']): ?>
                                                    <span class="job"><?php echo esc_html($testimonial['testimonial_job']); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($settings['testimonial_layout'] == '2'): ?>
                                    <div class="item-inner inner">
                                        <div class="testimonial-caption">
                                            <?php $this->render_rating($testimonial); ?>
                                            <?php if (!empty($testimonial['testimonial_content'])) : ?>
                                                <div class="content"><?php echo sprintf('%s', $testimonial['testimonial_content']); ?></div>
                                            <?php endif; ?>
                                            <div class="caption-top">
                                                <div <?php $this->print_render_attribute_string('details'); ?>>
                                                    <?php
                                                    $testimonial_name_html = $testimonial['testimonial_name'];
                                                    if (!empty($testimonial['testimonial_link']['url'])) :
                                                        $testimonial_name_html = '<a href="' . esc_url($testimonial['testimonial_link']['url']) . '">' . esc_html($testimonial_name_html) . '</a>';
                                                    endif;
                                                    printf('<span class="name">%s</span>', $testimonial_name_html);
                                                    ?>
                                                    <?php if ($testimonial['testimonial_job']): ?>
                                                        <span class="job"><?php echo esc_html($testimonial['testimonial_job']); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="icon">
                                                    <?php \Elementor\Icons_Manager::render_icon($testimonial['testimonial_icon'], ['aria-hidden' => 'true']); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $this->render_image($settings, $testimonial); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($settings['testimonial_layout'] == '3'): ?>
                                    <div class="item-inner inner">
                                        <div class="testimonial-caption">
                                            <div class="caption-top">
                                                <?php $this->render_image($settings, $testimonial); ?>
                                                <div <?php $this->print_render_attribute_string('details'); ?>>
                                                    <?php
                                                    $testimonial_name_html = $testimonial['testimonial_name'];
                                                    if (!empty($testimonial['testimonial_link']['url'])) :
                                                        $testimonial_name_html = '<a href="' . esc_url($testimonial['testimonial_link']['url']) . '">' . esc_html($testimonial_name_html) . '</a>';
                                                    endif;
                                                    printf('<span class="name">%s</span>', $testimonial_name_html);
                                                    ?>
                                                    <?php if ($testimonial['testimonial_job']): ?>
                                                        <span class="job"><?php echo esc_html($testimonial['testimonial_job']); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $this->render_rating($testimonial); ?>
                                        <?php if (!empty($testimonial['testimonial_content'])) : ?>
                                            <div class="content"><?php echo sprintf('%s', $testimonial['testimonial_content']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php $this->render_swiper_pagination_navigation(); ?>
                </div>
            </div>
            <?php
        }
    }

    private function render_image($settings, $testimonial) {
        if (!empty($testimonial['testimonial_image']['url'])) :
            ?>
            <div class="elementor-testimonial-image">
                <?php
                $testimonial['testimonial_image_size']             = $settings['testimonial_image_size'];
                $testimonial['testimonial_image_custom_dimension'] = $settings['testimonial_image_custom_dimension'];
                echo Group_Control_Image_Size::get_attachment_image_html($testimonial, 'testimonial_image');
                ?>
            </div>
        <?php
        endif;
    }

    private function render_rating($testimonial) {
        if (!empty($testimonial['testimonial_rating']) && $testimonial['testimonial_rating'] > 0) {
            $rating = (float)$testimonial['testimonial_rating'];

            if ($rating < 1) {
                $label = '';
            } elseif ($rating < 2) {
                $label = 'POOR';
            } elseif ($rating < 3) {
                $label = 'AVERAGE';
            } elseif ($rating < 4.5) {
                $label = 'GREAT';
            } elseif ($rating <= 4.8) {
                $label = 'WONDERFUL!';
            } elseif ($rating <= 4.9) {
                $label = 'EXCELLENT';
            } else {
                $label = 'amazing!';
            }

            echo '<div class="elementor-testimonial-rating-wrap">';
            if ($label) {
                echo '<div class="testimonial-rating-title">' . esc_html($label) . '</div>';
            }
            echo '<div class="elementor-testimonial-rating-number">';
            echo '<span class="rating-value" data-rating="' . esc_attr($rating) . '">0.0</span>';
            echo '<span class="rating-total">/5</span>';
            echo '</div>';
            echo '</div>';
        }
    }




}

$widgets_manager->register(new Westio_Elementor_Testimonials());

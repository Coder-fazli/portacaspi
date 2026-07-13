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
use Elementor\Group_Control_Background;
use Westio\Elementor\Westio_Base_Widgets;
use Elementor\Utils;
use Elementor\Icons_Manager;

class Westio_Elementor_Team_Box extends Westio_Base_Widgets {
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
        return 'westio-team-box';
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
        return esc_html__('Westio Team Box', 'westio');
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
        return 'eicon-person';
    }

    public function get_script_depends() {
        return ['westio-elementor-team-box', 'westio-elementor-swiper'];
    }

    public function get_categories() {
        return array('westio-addons');
    }

    public function get_style_depends() {
        return ['e-swiper', 'elementor-icons-fa-solid', 'elementor-icons-fa-brands', 'elementor-icons-fa-regular'];
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
        $column = range(1, 10);
        $column = array_combine($column, $column);

        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__('Query', 'westio'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control('enable_carousel', [
            'label'   => esc_html__('Enable Carousel', 'westio'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'no',
        ]);

        $this->add_responsive_control(
            'column',
            [
                'label'              => esc_html__('Columns', 'westio'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 3,
                'options'            => [
                                            '' => esc_html__('Default', 'westio'),
                                        ] + $column,
                'frontend_available' => true,
                'render_type'        => 'template',
                'prefix_class'       => 'elementor-grid%s-',
                'selectors'          => [
                    '{{WRAPPER}}'                               => '--e-global-column-to-show: {{VALUE}}',
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

        $this->end_controls_section();

        $this->start_controls_section(
            'section_team',
            [
                'label' => esc_html__('Team', 'westio'),
            ]
        );

        // Team Repeater
        $repeater = new Repeater();

        $repeater->add_control(
            'teambox_image',
            [
                'label'   => esc_html__('Image', 'westio'),
                'type'    => Controls_Manager::MEDIA,
                'default' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label'   => esc_html__('Name', 'westio'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Morgan Maxwell',
            ]
        );

        $repeater->add_control(
            'job',
            [
                'label'   => esc_html__('Job', 'westio'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'CEO & Founder',
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'       => esc_html__('Link to', 'westio'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => ['active' => true],
                'placeholder' => esc_html__('https://your-link.com', 'westio'),
            ]
        );

        $this->add_control(
            'teambox',
            [
                'label'         => esc_html__('Team Members', 'westio'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'title_field'   => '{{{ name }}}',
                'prevent_empty' => false
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'teambox_image',
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->end_controls_section();

        // Wrapper.
        $this->start_controls_section(
            'section_style_team_wrapper',
            [
                'label' => esc_html__('Items', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'team_text_align',
            [
                'label' => esc_html__( 'Alignment', 'westio' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'westio' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'westio' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'westio' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .team_info' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'teambox_height',
            [
                'label'      => esc_html__('Height', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 900,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-teambox-item .team_wrapper .team_image' => 'padding-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'team_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-teambox-item' => '--team-item-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-teambox-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-teambox-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Name.
        $this->start_controls_section(
            'section_style_team_name',
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
                    '{{WRAPPER}} .elementor-teambox-item .team_name' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-teambox-item .team_name:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'selector' => '{{WRAPPER}} .elementor-teambox-item .team_name',
            ]
        );

        $this->add_responsive_control(
            'name_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-teambox-item .team_name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Job.
        $this->start_controls_section(
            'section_style_team_job',
            [
                'label' => esc_html__('Job', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'job_text_color',
            [
                'label'     => esc_html__('Text Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-teambox-item .team_job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'job_typography',
                'selector' => '{{WRAPPER}} .elementor-teambox-item .team_job',
            ]
        );

        $this->add_responsive_control(
            'job_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-teambox-item .team_job' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->add_control_carousel(['enable_carousel' => 'yes']);
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
        set_query_var('settings', $settings);

        if (!empty($settings['teambox']) && is_array($settings['teambox'])) {
            $this->get_data_elementor_columns();
            $this->add_render_attribute('wrapper', 'class', 'elementor-teambox-item-wrapper');
            $this->add_render_attribute('container', 'data-count', count($settings['teambox']));
            // Item
            $this->add_render_attribute('item', 'class', 'elementor-teambox-item');
            $this->add_render_attribute('details', 'class', 'details');

            $this->get_data_elementor_columns();
            $this->get_data_elementor_carousel();
            ?>

            <div <?php $this->print_render_attribute_string('wrapper'); // WPCS: XSS ok. ?>>
                <div <?php $this->print_render_attribute_string('container'); ?>>
                    <div <?php $this->print_render_attribute_string('inner'); // WPCS: XSS ok. ?>>
                        <?php foreach ($settings['teambox'] as $teambox): ?>
                            <div <?php $this->print_render_attribute_string('item'); // WPCS: XSS ok. ?>>
                                <div class="team_wrapper">
                                    <div class="team_media">
                                        <div class="team_image">
                                            <?php $this->render_image($settings, $teambox); ?>
                                        </div>

                                        <div class="team-socials-wrapper">
                                            <?php if (!empty($teambox['socials']) && is_array($teambox['socials'])) : ?>
                                                <?php foreach ($teambox['socials'] as $social) : ?>
                                                    <span class="social">
                                                            <a href="<?php echo esc_url($social['social_link']['url']); ?>"
                                                               title="<?php echo esc_html($social['social_title']); ?>"
                                                               target="<?php echo esc_attr($social['social_link']['is_external'] ? '_blank' : '_self'); ?>">
                                                                <?php Icons_Manager::render_icon($social['social_icon'], ['aria-hidden' => 'true']); ?>
                                                            </a>
                                                        </span>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if (!empty($teambox['job']) || !empty($teambox['name'])) { ?>
                                        <div class="team_info">
                                            <?php if (!empty($teambox['name'])) { ?>
                                                <div class="team_name">
                                                    <?php
                                                    $teambox_name_html = $teambox['name'];
                                                    if (!empty($teambox['link']['url'])) :
                                                        $teambox_name_html = '<a href="' . esc_url($teambox['link']['url']) . '">' . esc_html($teambox_name_html) . '</a>';
                                                    endif;
                                                    printf($teambox_name_html);
                                                    ?>
                                                </div>
                                            <?php } ?>

                                            <?php if (!empty($teambox['job'])) { ?>
                                                <div class="team_job"><?php echo esc_html($teambox['job']); ?></div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                    <?php $this->render_swiper_pagination_navigation(); ?>
                </div>
            </div>

            <?php
        }

    }

    private function render_image($settings, $teambox) {
        if (!empty($teambox['teambox_image']['url'])) :
            $teambox['teambox_image_size']             = $settings['teambox_image_size'];
            $teambox['teambox_image_custom_dimension'] = $settings['teambox_image_custom_dimension'];
            echo Group_Control_Image_Size::get_attachment_image_html($teambox, 'teambox_image');
        endif;
    }
}

$widgets_manager->register(new Westio_Elementor_Team_Box());

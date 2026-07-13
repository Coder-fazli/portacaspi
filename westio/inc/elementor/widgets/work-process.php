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
use Westio\Elementor\Westio_Base_Widgets;
use Elementor\Utils;

class Westio_Elementor_Work_Process extends Westio_Base_Widgets {

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
        return 'westio-work-process';
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
        return esc_html__('Westio Work Process', 'westio');
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
        return ['westio-elementor-work-process'];
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
            'section_work_process',
            [
                'label' => esc_html__('Work Process', 'westio'),
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control(
            'process_image',
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
            'process_subtitle',
            [
                'label'       => esc_html__('SubTitle', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Process subtitle',
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'process_title',
            [
                'label'       => esc_html__('Title', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Process title',
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'process_content',
            [
                'label'       => esc_html__('Content', 'westio'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                'label_block' => true,
                'rows'        => '6',
            ]
        );
        $repeater->add_control(
            'button_text',
            [
                'label'   => esc_html__('Button Text', 'westio'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Click Here', 'westio'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $repeater->add_control(
            'process_link',
            [
                'label'       => esc_html__('Link to', 'westio'),
                'placeholder' => esc_html__('https://your-link.com', 'westio'),
                'type'        => Controls_Manager::URL,
            ]
        );
        $this->add_control(
            'process',
            [
                'label'       => esc_html__('Items', 'westio'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ process_title }}}',
            ]
        );
        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'process_image',
                'default'   => 'full',
                'separator' => 'none',
            ]
        );
        $this->add_control(
            'process_layout',
            [
                'label'        => esc_html__('Layout', 'westio'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'default',
                'options'      => [
                    'default' => esc_html__('Default', 'westio'),
                    '1'       => esc_html__('Layout 1', 'westio'),
                    '2'       => esc_html__('Layout 2', 'westio'),
                ],
                'prefix_class' => 'process-layout-style-',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_process_wrapper',
            [
                'label' => esc_html__('Wrapper', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'process_wrapper_padding_inner',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-process-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'process_wrapper_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-process-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'process_height_wrapper',
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
                    '{{WRAPPER}} .elementor-process-item ' => 'height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .process-post-thumbnail img  ' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_process_content',
            [
                'label' => esc_html__('Content', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'padding_content_inner',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .process-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'process_number',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__('Number', 'westio'),
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'process_number_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .entry-number .number' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'process_number_typography',
                'selector' => '{{WRAPPER}} .entry-number .number',
            ]
        );
        $this->add_responsive_control(
            'process_number_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .entry-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'process_title',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__('Title', 'westio'),
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'process_title_width',
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
                    '{{WRAPPER}}.process-layout-style-default .process-content .process-title'           => 'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}}.process-layout-style-1 .elementor-process-item .process-content .process-title'           => 'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}}.process-layout-style-2 .process-content .process-title'           => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'process_title_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .process-content .process-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .process-content .process-title a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'process_title_typography',
                'selector' => '{{WRAPPER}} .process-content .process-title',
            ]
        );
        $this->add_responsive_control(
            'process_title_padding',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .process-content .process-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'process_des',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => esc_html__('Description', 'westio'),
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'process_des_width',
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
                    '{{WRAPPER}} .elementor-process-item .process-content .process-description .description'           => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'process_des_color',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .process-content .process-description .description' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'process_des_typography',
                'selector' => '{{WRAPPER}} .process-content .process-description .description',
            ]
        );
        $this->end_controls_section();

    }
    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['process']) && is_array($settings['process'])) {
            $this->add_render_attribute('wrapper', 'class', 'elementor-process-wrapper');
            $this->add_render_attribute('container', 'class', 'westio-con');
            $this->add_render_attribute('inner', 'class', 'westio-con-inner');

            // Item
            $this->add_render_attribute('item', 'class', 'elementor-process-item');
            $number            = 0;
            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); // WPCS: XSS ok. ?>>
                <div <?php $this->print_render_attribute_string('container'); // WPCS: XSS ok. ?>>
                    <div <?php $this->print_render_attribute_string('inner'); // WPCS: XSS ok. ?>>
                        <?php foreach ($settings['process'] as $item):
                            $number++;
                            ?>
                            <div <?php $this->print_render_attribute_string('item'); // WPCS: XSS ok. ?>>
                                <div class="process-inner">
                                    <?php if ( isset( $settings['process_layout'] ) && $settings['process_layout'] == 'default' ) : ?>
                                        <div class="entry-number">
                                            <span class="number"><?php echo sprintf("[%02d]", $number); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="process-post-thumbnail">
                                        <?php $this->render_image($settings, $item); ?>
                                    </div>
                                    <div class="process-content">
                                        <div class="process-caption">
                                            <?php if ($item['process_subtitle']): ?>
                                                <span class="process-subtitle"><?php echo esc_html($item['process_subtitle']); ?></span>
                                            <?php endif; ?>
                                            <?php
                                            $process_title_html = $item['process_title'];
                                            if (!empty($item['process_link']['url'])) :
                                                $process_title_html = '<a href="' . esc_url($item['process_link']['url']) . '">' . esc_html($process_title_html) . '</a>';
                                            endif;
                                            printf('<span class="process-title">%s</span>', $process_title_html);
                                            ?>
                                        </div>
                                        <?php if ($item['process_content']): ?>
                                        <div class="process-description">
                                             <span class="description">
                                                <?php echo wp_kses_post($item['process_content']); ?>
                                            </span>
                                        </div>
                                        <?php endif; ?>
                                        <?php if (!empty($item['button_text'])) : ?>
                                            <div class="process-button elementor-widget-button">
                                                <a class="elementor-button elementor-button-link elementor-size-sm"
                                                    <?php if (!empty($item['process_link']['url'])) : ?>
                                                        href="<?php echo esc_url($item['process_link']['url']); ?>"
                                                        <?php if (!empty($item['process_link']['is_external'])) : ?>
                                                        <?php endif; ?>
                                                        <?php
                                                        $rels = [];
                                                        if (!empty($item['process_link']['nofollow'])) {
                                                            $rels[] = 'nofollow';
                                                        }
                                                        if (!empty($item['process_link']['is_external'])) {
                                                            $rels[] = 'noopener';
                                                            $rels[] = 'noreferrer';
                                                        }
                                                        if (!empty($rels)) :
                                                            ?>
                                                            rel="<?php echo implode(' ', $rels); ?>"
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                >
                                                    <span class="elementor-button-content-wrapper">
                                                        <span class="elementor-button-text">
                                                            <?php echo esc_html($item['button_text']); ?>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php
        }

    }
    private function render_image($settings, $item) {
        if (!empty($item['process_image']['url'])) :
            ?>
            <?php
            $item['process_image_size']             = $settings['process_image_size'];
            $item['process_image_custom_dimension'] = $settings['process_image_custom_dimension'];
            echo Group_Control_Image_Size::get_attachment_image_html($item, 'process_image');
            ?>
        <?php
        endif;
    }
}
$widgets_manager->register(new Westio_Elementor_Work_Process());

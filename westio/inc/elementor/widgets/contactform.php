<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!westio_is_contactform_activated()) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;


class Westio_Elementor_ContactForm extends Elementor\Widget_Base {

    public function get_name() {
        return 'westio-contactform';
    }

    public function get_title() {
        return esc_html__('Westio Contact Form', 'westio');
    }

    public function get_categories() {
        return array('westio-addons');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    protected function register_controls() {
        $this->start_controls_section(
            'contactform7',
            [
                'label' => esc_html__('General', 'westio'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $cf7               = get_posts('post_type="wpcf7_contact_form"&numberposts=-1');
        $contact_forms[''] = esc_html__('Please select form', 'westio');
        if ($cf7) {
            foreach ($cf7 as $cform) {
                $contact_forms[$cform->ID] = $cform->post_title;
            }
        } else {
            $contact_forms[0] = esc_html__('No contact forms found', 'westio');
        }

        $this->add_control(
            'cf_id',
            [
                'label'   => esc_html__('Select contact form', 'westio'),
                'type'    => Controls_Manager::SELECT,
                'options' => $contact_forms,
                'default' => ''
            ]
        );

        $this->add_control(
            'form_name',
            [
                'label'   => esc_html__('Form name', 'westio'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Contact form', 'westio'),
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_contact',
            [
                'label' => esc_html__('Wrapper', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'padding_input',
            [
                'label'      => esc_html__('Padding Input', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=text], 
                    .wpcf7-form .wpcf7-form-control-wrap input[type=number], 
                    .wpcf7-form .wpcf7-form-control-wrap input[type=email], 
                    .wpcf7-form .wpcf7-form-control-wrap input[type=tel], 
                    .wpcf7-form .wpcf7-form-control-wrap input[type=url], 
                    .wpcf7-form .wpcf7-form-control-wrap input[type=password], 
                    .wpcf7-form .wpcf7-form-control-wrap input[type=search], 
                    .wpcf7-form .wpcf7-form-control-wrap input[type=date], 
                    .wpcf7-form .wpcf7-form-control-wrap .input-text, 
                    .wpcf7-form .wpcf7-form-control-wrap textarea, 
                    .wpcf7-form .wpcf7-form-control-wrap select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'padding_input_column',
            [
                'label'      => esc_html__('Padding Column', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7-form .contact-form [class*=column-]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'color_contact_background',
            [
                'label'     => esc_html__('Background Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=text]'     => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=email]'    => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=tel]'      => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=url]'      => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=password]' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=search]'   => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=date]'     => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea'             => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap select'               => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'color_contact',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=text]'                   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=email]'                  => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=tel]'                    => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=url]'                    => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=password]'               => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=search]'                 => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=date]'                   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea'                           => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap select:not([size]):not([multiple])' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap:has(> [type="date"])'               => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap:has(> select)'                      => 'color: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'color_placeholder_contact',
            [
                'label'     => esc_html__('Color Placeholder', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=text]::placeholder'                   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=email]::placeholder'                  => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .wpcf7-form .contact-special .wpcf7-form-control-wrap input[type=email]::placeholder' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=tel]::placeholder'                    => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=url]::placeholder'                    => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=password]::placeholder'               => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=search]::placeholder'                 => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=date]'                                => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea::placeholder'                           => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap select:not([size]):not([multiple])'              => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wpcf7-form [class*=" column-"] p i'                                                  => 'color: {{VALUE}};',
                    '{{WRAPPER}} input[type=date]:after'                                                               => 'color: {{VALUE}};',

                ],
            ]
        );

        $this->add_responsive_control(
            'aligrment',
            [
                'label'       => esc_html__('Button Alignment', 'westio'),
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
                    '{{WRAPPER}} .button-wrapper' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'step_wrapper_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector' => '
                    {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=text],
                    {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=number],
                    {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=email],
                    {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=tel],
                    {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=url],
                    {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=password],
                    {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=search],
                    {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type=date],
                    {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .input-text,
                    {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea,
                    {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap select
                ',
                'separator'   => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button_contact',
            [
                'label' => esc_html__('Button', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => esc_html__('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .button-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} button',
            ]
        );

        $this->add_control(
            'size_icon_button',
            [
                'label'     => esc_html__('Size Icon', 'westio'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} button i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} button svg' => 'width: {{SIZE}}px; height: {{SIZE}}px',
                ],
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab('button_normal',
            [
                'label' => esc_html__('Normal', 'westio'),
            ]
        );

        $this->add_control(
            'background_color_button',
            [
                'label'     => esc_html__('Background Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'color_button',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'color_icon_button',
            [
                'label'     => esc_html__('Color Icon', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button i'   => 'color: {{VALUE}}',
                    '{{WRAPPER}} button svg' => 'color: {{VALUE}}; fill: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('button_hover',
            [
                'label' => esc_html__('Hover', 'westio'),
            ]
        );

        $this->add_control(
            'background_color_button_hover',
            [
                'label'     => esc_html__('Background Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'color_button_hover',
            [
                'label'     => esc_html__('Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'color_icon_button_hover',
            [
                'label'     => esc_html__('Color Icon', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button:hover i'   => 'color: {{VALUE}}',
                    '{{WRAPPER}} button:hover svg' => 'color: {{VALUE}}; fill: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!$settings['cf_id']) {
            return;
        }
        $args['id']    = $settings['cf_id'];
        $args['title'] = $settings['form_name'];

        echo westio_do_shortcode('contact-form-7', $args);
    }
}

$widgets_manager->register(new Westio_Elementor_ContactForm());

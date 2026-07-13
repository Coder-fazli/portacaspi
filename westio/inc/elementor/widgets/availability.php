<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Westio\Elementor\Westio_Base_Widgets;

/**
 * Elementor property variation widget.
 *
 * Elementor widget that displays property variation.
 *
 * @since 1.0.0
 */
class Westio_Widget_Availability extends Westio_Base_Widgets {

    public function get_name() {
        return 'westio-availability';
    }

    public function get_title() {
        return esc_html__('Westio Availability', 'westio');
    }

    public function get_categories() {
        return array('westio-addons');
    }

    public function get_script_depends() {
        return ['westio-elementor-availability', 'magnific-popup'];
    }

    public function get_style_depends() {
        return ['magnific-popup'];
    }

    /**
     * Register property variation widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_availability',
            [
                'label' => esc_html__('Availability', 'westio'),
            ]
        );

        $this->add_control(
            'title_1',
            [
                'label'   => esc_html__('Heading 1', 'westio'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'RESIDENCE'
            ]
        );

        $this->add_control(
            'title_2',
            [
                'label'   => esc_html__('Heading 2', 'westio'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'BED/BATH'
            ]
        );

        $this->add_control(
            'title_3',
            [
                'label'   => esc_html__('Heading 3', 'westio'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'SQ. FT.'
            ]
        );

        $this->add_control(
            'title_4',
            [
                'label'   => esc_html__('Heading 4', 'westio'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'SALE PRICE'
            ]
        );

        $this->add_control(
            'title_5',
            [
                'label'   => esc_html__('Heading 5', 'westio'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'RENT PRICE'
            ]
        );

        $this->add_control(
            'title_6',
            [
                'label'   => esc_html__('Heading 6', 'westio'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'FLOOR PLAN'
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'value_1',
            [
                'label'       => esc_html__('Value 1', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Value 1', 'westio'),
            ]
        );

        $repeater->add_control(
            'value_2',
            [
                'label'       => esc_html__('Value 2', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Value 2', 'westio'),
            ]
        );

        $repeater->add_control(
            'value_3',
            [
                'label'       => esc_html__('Value 3', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Value 3', 'westio'),
            ]
        );

        $repeater->add_control(
            'value_4',
            [
                'label'       => esc_html__('Value 4', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Value 4', 'westio'),
            ]
        );

        $repeater->add_control(
            'value_5',
            [
                'label'       => esc_html__('Value 5', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Value 5', 'westio'),
            ]
        );

        $repeater->add_control(
            'value_6',
            [
                'label'       => esc_html__('Value 6', 'westio'),
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
            'availability',
            [
                'label'       => '',
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'value_1' => '320F',
                        'value_2' => '-',
                        'value_3' => '-',
                        'value_4' => '-',
                        'value_5' => '-',
                        'value_6' => '-',
                    ],
                ],
                'value_field' => '{{{ value }}}',
                'separator'   => 'before'
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render icon list widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Wrapper
        $this->add_render_attribute('availability', 'class', 'westio-availability');

        // Table row
        $this->add_render_attribute('availability_item', 'class', 'availability-item');

        // Button
        $this->add_render_attribute('button', 'class', 'availability_button');
        $this->add_render_attribute('button', 'role', 'button');
        ?>
        <div <?php $this->print_render_attribute_string('availability'); ?>>
            <table>
                <thead>
                <tr>
                    <th><?php echo esc_html($settings['title_1']); ?></th>
                    <th><?php echo esc_html($settings['title_2']); ?></th>
                    <th><?php echo esc_html($settings['title_3']); ?></th>
                    <th><?php echo esc_html($settings['title_4']); ?></th>
                    <th><?php echo esc_html($settings['title_5']); ?></th>
                    <th><?php echo esc_html($settings['title_6']); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($settings['availability'] as $index => $item) : ?>
                    <tr <?php $this->print_render_attribute_string('availability_item'); ?>>
                        <td data-label="<?php echo esc_attr($settings['title_1']); ?>">
                            <span><?php if (!empty($item['value_1'])) echo esc_html($item['value_1']); ?></span>
                        </td>
                        <td data-label="<?php echo esc_attr($settings['title_2']); ?>">
                            <?php if (!empty($item['value_2'])) echo esc_html($item['value_2']); ?>
                        </td>
                        <td data-label="<?php echo esc_attr($settings['title_3']); ?>">
                            <?php if (!empty($item['value_3'])) echo esc_html($item['value_3']); ?>
                        </td>
                        <td data-label="<?php echo esc_attr($settings['title_4']); ?>">
                            <?php if (!empty($item['value_4'])) echo esc_html($item['value_4']); ?>
                        </td>
                        <td data-label="<?php echo esc_attr($settings['title_5']); ?>">
                            <?php if (!empty($item['value_5'])) echo esc_html($item['value_5']); ?>
                        </td>
                        <td data-label="<?php echo esc_attr($settings['title_6']); ?>" class="availability-action">
                            <a data-elementor-open-lightbox="no"
                               href="<?php echo esc_attr($item['value_6']['url']); ?>"
                                <?php $this->print_render_attribute_string('button'); ?>>
                                <?php esc_html_e('View Now', 'westio') ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

}

$widgets_manager->register(new Westio_Widget_Availability());
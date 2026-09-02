<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Westio_Child_Success_Message extends Widget_Base {

    public function get_name() {
        return 'westio-child-success-message';
    }

    public function get_title() {
        return esc_html__('Success Message', 'westio-child');
    }

    public function get_icon() {
        return 'eicon-check-circle-o';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_style_depends() {
        return ['westio-child-success-message'];
    }

    protected function register_controls() {
        $this->start_controls_section('section_content', [
            'label' => esc_html__('Content', 'westio-child'),
        ]);
        $this->add_control('heading', [
            'label'   => esc_html__('Heading', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__('Təşəkkür edirik!', 'westio-child'),
        ]);
        $this->add_control('message', [
            'label'   => esc_html__('Message', 'westio-child'),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => esc_html__('Müraciətiniz bizə uğurla çatdı. Ən qısa zamanda sizinlə əlaqə saxlayacağıq.', 'westio-child'),
        ]);
        $this->add_control('button_text', [
            'label'   => esc_html__('Button Text', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__('Ana səhifəyə qayıt', 'westio-child'),
        ]);
        $this->add_control('button_link', [
            'label'     => esc_html__('Button Link', 'westio-child'),
            'type'      => Controls_Manager::URL,
            'default'   => ['url' => home_url('/')],
            'condition' => ['button_text!' => ''],
        ]);
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="sm-wrap">
            <div class="sm-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M8 12.5l2.5 2.5L16 9.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>

            <?php if (!empty($settings['heading'])) : ?>
                <h1 class="sm-heading"><?php echo esc_html($settings['heading']); ?></h1>
            <?php endif; ?>

            <?php if (!empty($settings['message'])) : ?>
                <p class="sm-message"><?php echo esc_html($settings['message']); ?></p>
            <?php endif; ?>

            <?php if (!empty($settings['button_text'])) :
                $link = $settings['button_link'];
                if (!empty($link['url'])) {
                    $this->add_link_attributes('button', $link);
                    $this->add_render_attribute('button', 'class', 'sm-button');
                    echo '<a ' . $this->get_render_attribute_string('button') . '>' . esc_html($settings['button_text']) . '</a>';
                } else {
                    echo '<span class="sm-button">' . esc_html($settings['button_text']) . '</span>';
                }
            endif; ?>
        </div>
        <?php
    }
}

$widgets_manager->register(new Westio_Child_Success_Message());

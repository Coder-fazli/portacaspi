<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Typography;

class Westio_Child_Neighborhood_Map extends Widget_Base {

    public function get_name() {
        return 'westio-child-neighborhood-map';
    }

    public function get_title() {
        return esc_html__('Neighborhood Map', 'westio-child');
    }

    public function get_icon() {
        return 'eicon-map-pin';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_style_depends() {
        return ['westio-child-neighborhood-map'];
    }

    protected function register_controls() {
        $this->start_controls_section('section_image', [
            'label' => esc_html__('Background', 'westio-child'),
        ]);
        $this->add_control('bg_image', [
            'label'   => esc_html__('Image (Desktop)', 'westio-child'),
            'type'    => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
        ]);
        $this->add_control('bg_image_mobile', [
            'label'       => esc_html__('Image (Mobile)', 'westio-child'),
            'type'        => Controls_Manager::MEDIA,
            'default'     => [],
            'description' => esc_html__('Optional — a tighter crop tends to read better on phones than a wide aerial shot. Falls back to the desktop image if left empty.', 'westio-child'),
        ]);
        $this->end_controls_section();

        $this->start_controls_section('section_header', [
            'label' => esc_html__('Header', 'westio-child'),
        ]);
        $this->add_control('eyebrow', [
            'label'   => esc_html__('Eyebrow', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__('Ətraf mühit', 'westio-child'),
        ]);
        $this->add_control('heading', [
            'label'   => esc_html__('Heading', 'westio-child'),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => esc_html__('Əlverişli məkanda yaşayış', 'westio-child'),
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'heading_typography',
            'label'    => esc_html__('Heading Typography', 'westio-child'),
            'selector' => '{{WRAPPER}} .nm-heading',
            'fields_options' => [
                'font_size' => ['default' => ['unit' => 'px', 'size' => 52]],
                'font_weight' => ['default' => '700'],
            ],
        ]);
        $this->add_control('header_position', [
            'label'       => esc_html__('Header Block Position (from top, %)', 'westio-child'),
            'type'        => Controls_Manager::SLIDER,
            'range'       => ['%' => ['min' => 0, 'max' => 50]],
            'default'     => ['unit' => '%', 'size' => 8],
            'description' => esc_html__('Moves the eyebrow + heading block as one unit — use this if it overlaps a pin below it.', 'westio-child'),
            'selectors'   => [
                '{{WRAPPER}} .nm-header' => '--nm-header-top: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('section_pins', [
            'label' => esc_html__('Pins', 'westio-child'),
        ]);

        $repeater = new Repeater();
        $repeater->add_control('label', [
            'label'   => esc_html__('Label', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__('Location', 'westio-child'),
        ]);
        $repeater->add_control('pos_x', [
            'label'   => esc_html__('Position X (%)', 'westio-child'),
            'type'    => Controls_Manager::SLIDER,
            'range'   => ['px' => ['min' => 0, 'max' => 100]],
            'default' => ['size' => 50],
        ]);
        $repeater->add_control('pos_y', [
            'label'   => esc_html__('Position Y (%)', 'westio-child'),
            'type'    => Controls_Manager::SLIDER,
            'range'   => ['px' => ['min' => 0, 'max' => 100]],
            'default' => ['size' => 50],
        ]);
        $repeater->add_control('label_pos', [
            'label'   => esc_html__('Label Side', 'westio-child'),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'bottom' => esc_html__('Bottom', 'westio-child'),
                'top'    => esc_html__('Top', 'westio-child'),
                'left'   => esc_html__('Left', 'westio-child'),
                'right'  => esc_html__('Right', 'westio-child'),
            ],
            'default' => 'bottom',
        ]);
        $repeater->add_control('highlight', [
            'label'        => esc_html__('Highlight (center marker)', 'westio-child'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'westio-child'),
            'label_off'    => esc_html__('No', 'westio-child'),
            'default'      => '',
            'description'  => esc_html__('Use once for the project\'s own marker (e.g. "Porta Caspia") to style it differently from surrounding points of interest.', 'westio-child'),
        ]);

        $this->add_control('pins', [
            'label'       => esc_html__('Pins', 'westio-child'),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ label }}}',
            'default'     => [
                ['label' => 'Casino', 'pos_x' => ['size' => 18], 'pos_y' => ['size' => 45], 'label_pos' => 'top'],
                ['label' => 'Marina', 'pos_x' => ['size' => 55], 'pos_y' => ['size' => 62], 'label_pos' => 'bottom'],
                ['label' => 'Porta Caspia', 'pos_x' => ['size' => 47], 'pos_y' => ['size' => 78], 'label_pos' => 'bottom', 'highlight' => 'yes'],
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('section_fade', [
            'label' => esc_html__('Fade', 'westio-child'),
        ]);
        $this->add_control('fade_color', [
            'label'       => esc_html__('Fade Color', 'westio-child'),
            'type'        => Controls_Manager::COLOR,
            'default'     => '#f5f1e8',
            'description' => esc_html__('Match this to the background color of the sections above and below, so the photo dissolves into the page instead of cutting off.', 'westio-child'),
        ]);
        $this->add_control('fade_top', [
            'label'        => esc_html__('Top Fade', 'westio-child'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'westio-child'),
            'label_off'    => esc_html__('No', 'westio-child'),
            'default'      => 'yes',
        ]);
        $this->add_control('fade_top_height', [
            'label'     => esc_html__('Top Fade Height (px)', 'westio-child'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 40, 'max' => 400]],
            'default'   => ['size' => 160],
            'condition' => ['fade_top' => 'yes'],
            'selectors' => [
                '{{WRAPPER}} .nm-fade-top' => 'height: {{SIZE}}px;',
            ],
        ]);
        $this->add_control('fade_bottom', [
            'label'        => esc_html__('Bottom Fade', 'westio-child'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'westio-child'),
            'label_off'    => esc_html__('No', 'westio-child'),
            'default'      => 'yes',
        ]);
        $this->add_control('fade_height', [
            'label'     => esc_html__('Bottom Fade Height (px)', 'westio-child'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 60, 'max' => 500]],
            'default'   => ['size' => 280],
            'condition' => ['fade_bottom' => 'yes'],
            'selectors' => [
                '{{WRAPPER}} .nm-fade' => 'height: {{SIZE}}px;',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('section_mobile', [
            'label' => esc_html__('Mobile', 'westio-child'),
        ]);
        $this->add_control('mobile_height', [
            'label'     => esc_html__('Height on Mobile (vh)', 'westio-child'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 40, 'max' => 100]],
            'default'   => ['size' => 90],
            'selectors' => [
                '{{WRAPPER}} .nm-map' => '--nm-mobile-h: {{SIZE}}vh;',
            ],
        ]);
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $pins     = !empty($settings['pins']) && is_array($settings['pins']) ? $settings['pins'] : [];

        $bg_url = !empty($settings['bg_image']['url']) ? $settings['bg_image']['url'] : Utils::get_placeholder_image_src();

        $ratio = '1714 / 900';
        if (!empty($settings['bg_image']['id'])) {
            $src = wp_get_attachment_image_src($settings['bg_image']['id'], 'full');
            if ($src && !empty($src[1]) && !empty($src[2])) {
                $ratio = $src[1] . ' / ' . $src[2];
            }
        }

        $fade_color  = !empty($settings['fade_color']) ? $settings['fade_color'] : '#f5f1e8';
        $mobile_url  = !empty($settings['bg_image_mobile']['url']) ? $settings['bg_image_mobile']['url'] : '';
        $show_top    = $settings['fade_top'] === 'yes';
        $show_bottom = $settings['fade_bottom'] === 'yes';
        ?>
        <div class="nm-map" style="--nm-ar: <?php echo esc_attr($ratio); ?>; --nm-fade-color: <?php echo esc_attr($fade_color); ?>;">
            <picture>
                <?php if ($mobile_url) : ?>
                    <source media="(max-width: 767px)" srcset="<?php echo esc_url($mobile_url); ?>">
                <?php endif; ?>
                <img class="nm-bg" src="<?php echo esc_url($bg_url); ?>" alt="">
            </picture>

            <?php if ($show_top) : ?>
                <div class="nm-fade-top" aria-hidden="true"></div>
            <?php endif; ?>

            <?php if (!empty($settings['eyebrow']) || !empty($settings['heading'])) : ?>
                <div class="nm-header">
                    <?php if (!empty($settings['eyebrow'])) : ?>
                        <div class="nm-eyebrow">
                            <?php echo esc_html($settings['eyebrow']); ?>
                            <svg class="nm-eyebrow-mark" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 2l1.8 6.6L20 6l-4.6 4.8L22 12l-6.6 1.2L18 20l-6-3.6L9 22l-1.2-6.6L2 18l3.6-6L2 10l6.6-1.2L6 3l6 3.6L12 2z" />
                            </svg>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($settings['heading'])) : ?>
                        <h2 class="nm-heading"><?php echo esc_html($settings['heading']); ?></h2>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php foreach ($pins as $pin) :
                $x = isset($pin['pos_x']['size']) ? $pin['pos_x']['size'] : 50;
                $y = isset($pin['pos_y']['size']) ? $pin['pos_y']['size'] : 50;
                $label_pos = !empty($pin['label_pos']) ? $pin['label_pos'] : 'bottom';
                $is_highlight = !empty($pin['highlight']);
                ?>
                <div class="nm-pin nm-label-<?php echo esc_attr($label_pos); ?><?php echo $is_highlight ? ' nm-pin-highlight' : ''; ?>" style="left:<?php echo esc_attr($x); ?>%;top:<?php echo esc_attr($y); ?>%;">
                    <span class="nm-pin-dot" aria-hidden="true"></span>
                    <span class="nm-pin-line" aria-hidden="true"></span>
                    <?php if (!empty($pin['label'])) : ?>
                        <span class="nm-pin-label"><?php echo esc_html($pin['label']); ?></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <?php if ($show_bottom) : ?>
                <div class="nm-fade" aria-hidden="true"></div>
            <?php endif; ?>
        </div>
        <?php
    }
}

$widgets_manager->register(new Westio_Child_Neighborhood_Map());

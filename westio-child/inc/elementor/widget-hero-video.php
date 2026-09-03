<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Westio_Child_Hero_Video extends Widget_Base {

    public function get_name() {
        return 'westio-child-hero-video';
    }

    public function get_title() {
        return esc_html__('Hero Video', 'westio-child');
    }

    public function get_icon() {
        return 'eicon-play-o';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_script_depends() {
        return ['westio-child-hero-video'];
    }

    public function get_style_depends() {
        return ['westio-child-hero-video'];
    }

    protected function register_controls() {
        $this->start_controls_section('section_video', [
            'label' => esc_html__('Video', 'westio-child'),
        ]);
        $this->add_control('video', [
            'label'      => esc_html__('Video File (Desktop)', 'westio-child'),
            'type'       => Controls_Manager::MEDIA,
            'media_type' => 'video',
            'default'    => [
                'url' => get_stylesheet_directory_uri() . '/assets/videos/hero-intro.mp4',
            ],
        ]);
        $this->add_control('video_mobile', [
            'label'       => esc_html__('Video File (Mobile)', 'westio-child'),
            'type'        => Controls_Manager::MEDIA,
            'media_type'  => 'video',
            'default'     => [],
            'description' => esc_html__('Optional — a shorter/lower-bitrate export loads much faster on cellular. Falls back to the desktop video if left empty.', 'westio-child'),
        ]);
        $this->add_control('poster', [
            'label'       => esc_html__('Poster Image (Desktop)', 'westio-child'),
            'type'        => Controls_Manager::MEDIA,
            'description' => esc_html__('Shown instantly while the video loads, and instead of the video on mobile if disabled below. Keep this small (under ~150kb) — it is what visitors see first.', 'westio-child'),
            'default'     => [
                'url' => get_stylesheet_directory_uri() . '/assets/images/hero-intro-poster.jpg',
            ],
        ]);
        $this->add_control('poster_mobile', [
            'label'       => esc_html__('Poster Image (Mobile)', 'westio-child'),
            'type'        => Controls_Manager::MEDIA,
            'default'     => [],
            'description' => esc_html__('Optional — a tighter portrait crop reads better on phones than a wide landscape frame. Falls back to the desktop poster if left empty.', 'westio-child'),
        ]);
        $this->end_controls_section();

        $this->start_controls_section('section_watermark', [
            'label' => esc_html__('Logo Watermark', 'westio-child'),
        ]);
        $this->add_control('watermark', [
            'label'       => esc_html__('Watermark Logo', 'westio-child'),
            'type'        => Controls_Manager::MEDIA,
            'default'     => [
                'url' => get_stylesheet_directory_uri() . '/assets/images/logo-watermark.png',
            ],
            'description' => esc_html__('A large, faint logo overlaid across the whole video — not a small corner badge. Use a transparent PNG. Leave empty to turn it off.', 'westio-child'),
        ]);
        $this->add_control('watermark_style', [
            'label'       => esc_html__('Style', 'westio-child'),
            'type'        => Controls_Manager::SELECT,
            'options'     => [
                'cutout' => esc_html__('Cutout — spotlight through a dark overlay', 'westio-child'),
                'simple' => esc_html__('Simple — flat low-opacity logo', 'westio-child'),
            ],
            'default'     => 'cutout',
            'description' => esc_html__('Cutout dims the whole video except the logo shape, so it reads as glowing in the video\'s own colors — no flat sticker look.', 'westio-child'),
        ]);
        $this->add_control('watermark_opacity', [
            'label'     => esc_html__('Opacity (%)', 'westio-child'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['%' => ['min' => 2, 'max' => 60]],
            'default'   => ['unit' => '%', 'size' => 12],
            'condition' => ['watermark_style' => 'simple'],
            'selectors' => [
                '{{WRAPPER}} .hv-watermark' => '--hv-watermark-opacity: {{SIZE}}%;',
            ],
        ]);
        $this->add_control('watermark_dim', [
            'label'     => esc_html__('Dim Amount (%)', 'westio-child'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['%' => ['min' => 10, 'max' => 90]],
            'default'   => ['unit' => '%', 'size' => 60],
            'condition' => ['watermark_style' => 'cutout'],
            'description' => esc_html__('How much the video darkens outside the logo shape.', 'westio-child'),
            'selectors' => [
                '{{WRAPPER}} .hv-watermark-cutout' => '--hv-watermark-dim: {{SIZE}}%;',
            ],
        ]);
        $this->add_control('watermark_width', [
            'label'   => esc_html__('Width (% of hero)', 'westio-child'),
            'type'    => Controls_Manager::SLIDER,
            'range'   => ['%' => ['min' => 15, 'max' => 100]],
            'default' => ['unit' => '%', 'size' => 55],
            'selectors' => [
                '{{WRAPPER}} .hv-watermark' => 'width: {{SIZE}}%;',
                '{{WRAPPER}} .hv-watermark-cutout' => '--hv-watermark-width: {{SIZE}}%;',
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('section_content', [
            'label' => esc_html__('Content', 'westio-child'),
        ]);
        $this->add_control('heading', [
            'label'   => esc_html__('Heading', 'westio-child'),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => esc_html__('Xəzər sahilində premium yaşayış layihəsi', 'westio-child'),
        ]);
        $this->add_control('heading_tag', [
            'label'   => esc_html__('Heading Tag', 'westio-child'),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
            ],
            'default' => 'h1',
        ]);
        $this->add_control('subheading', [
            'label'   => esc_html__('Subheading', 'westio-child'),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => '',
        ]);
        $this->add_control('button_text', [
            'label'   => esc_html__('Button Text', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => '',
        ]);
        $this->add_control('button_link', [
            'label'       => esc_html__('Button Link', 'westio-child'),
            'type'        => Controls_Manager::URL,
            'default'     => ['url' => ''],
            'condition'   => ['button_text!' => ''],
        ]);
        $this->add_control('content_align', [
            'label'   => esc_html__('Text Align', 'westio-child'),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'left'   => esc_html__('Left', 'westio-child'),
                'center' => esc_html__('Center', 'westio-child'),
                'right'  => esc_html__('Right', 'westio-child'),
            ],
            'default' => 'left',
        ]);
        $this->add_control('content_vertical', [
            'label'   => esc_html__('Vertical Position', 'westio-child'),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'flex-start' => esc_html__('Top', 'westio-child'),
                'center'     => esc_html__('Center', 'westio-child'),
                'flex-end'   => esc_html__('Bottom', 'westio-child'),
            ],
            'default' => 'flex-end',
        ]);
        $this->end_controls_section();

        $this->start_controls_section('section_mobile', [
            'label' => esc_html__('Mobile', 'westio-child'),
        ]);
        $this->add_control('play_on_mobile', [
            'label'        => esc_html__('Play Video on Mobile', 'westio-child'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'westio-child'),
            'label_off'    => esc_html__('No', 'westio-child'),
            'default'      => 'yes',
            'description'  => esc_html__('Turn off to save mobile data — phones will show the poster image only instead of downloading the video.', 'westio-child'),
        ]);
        $this->add_control('mobile_height', [
            'label'       => esc_html__('Max Height on Mobile (vh)', 'westio-child'),
            'description' => esc_html__('Caps how tall the 9:16 video box can get on phones, so it doesn\'t fill the entire screen.', 'westio-child'),
            'type'        => Controls_Manager::SLIDER,
            'range'       => ['px' => ['min' => 40, 'max' => 100]],
            'default'     => ['size' => 85],
            'selectors'   => [
                '{{WRAPPER}} .hv-hero' => '--hv-mobile-h: {{SIZE}}vh;',
            ],
        ]);
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Elementor's control 'default' already supplies the bundled sample
        // video/poster the first time this widget is dropped on a page — do
        // NOT re-substitute it here too. Doing so made it impossible to tell
        // "never configured" apart from "admin explicitly cleared this
        // field", so clearing either field appeared to do nothing.
        $video_url  = !empty($settings['video']['url']) ? $settings['video']['url'] : '';
        $video_mobile_url = !empty($settings['video_mobile']['url']) ? $settings['video_mobile']['url'] : '';
        $poster_url = !empty($settings['poster']['url']) ? $settings['poster']['url'] : '';
        $poster_mobile_url = !empty($settings['poster_mobile']['url']) ? $settings['poster_mobile']['url'] : '';
        $watermark_url = !empty($settings['watermark']['url']) ? $settings['watermark']['url'] : '';
        $watermark_style = $settings['watermark_style'] === 'simple' ? 'simple' : 'cutout';
        $play_on_mobile = $settings['play_on_mobile'] === 'yes';

        // Desktop box follows the poster's real aspect ratio (defaults to the
        // bundled 16:9 frame) so the video is never stretched or cropped on
        // the sides — mobile overrides this to a fixed 9:16 box in CSS.
        $ratio = '16 / 9';
        if (!empty($settings['poster']['id'])) {
            $src = wp_get_attachment_image_src($settings['poster']['id'], 'full');
            if ($src && !empty($src[1]) && !empty($src[2])) {
                $ratio = $src[1] . ' / ' . $src[2];
            }
        }

        $this->add_render_attribute('wrapper', 'class', 'hv-hero');
        $this->add_render_attribute('wrapper', 'data-play-mobile', $play_on_mobile ? '1' : '0');
        if ($video_url) {
            $this->add_render_attribute('wrapper', 'data-video', esc_url($video_url));
        }
        if ($video_mobile_url) {
            $this->add_render_attribute('wrapper', 'data-video-mobile', esc_url($video_mobile_url));
        }
        $this->add_render_attribute('wrapper', 'style', '--hv-ar: ' . esc_attr($ratio) . ';');
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <?php if ($poster_url) : ?>
                <picture>
                    <?php if ($poster_mobile_url) : ?>
                        <source media="(max-width: 767px)" srcset="<?php echo esc_url($poster_mobile_url); ?>">
                    <?php endif; ?>
                    <img class="hv-poster" src="<?php echo esc_url($poster_url); ?>" alt="" fetchpriority="high">
                </picture>
            <?php endif; ?>
            <?php if ($video_url) : ?>
                <video class="hv-video" muted loop playsinline preload="none" poster="<?php echo esc_url($poster_url); ?>"></video>
            <?php endif; ?>
            <?php if ($watermark_url && $watermark_style === 'cutout') : ?>
                <div class="hv-watermark-cutout" style="--hv-watermark-mask: url('<?php echo esc_url($watermark_url); ?>');" aria-hidden="true"></div>
            <?php elseif ($watermark_url) : ?>
                <img class="hv-watermark" src="<?php echo esc_url($watermark_url); ?>" alt="" aria-hidden="true" fetchpriority="low" loading="lazy">
            <?php endif; ?>
            <div class="hv-shade" aria-hidden="true"></div>

            <?php if (!empty($settings['heading']) || !empty($settings['subheading']) || !empty($settings['button_text'])) : ?>
                <div class="hv-content hv-align-<?php echo esc_attr($settings['content_align']); ?>" style="justify-content: <?php echo esc_attr($settings['content_vertical']); ?>;">
                    <?php if (!empty($settings['heading'])) :
                        $tag = Utils::validate_html_tag($settings['heading_tag']);
                        printf('<%1$s class="hv-heading">%2$s</%1$s>', tag_escape($tag), esc_html($settings['heading']));
                    endif; ?>

                    <?php if (!empty($settings['subheading'])) : ?>
                        <p class="hv-subheading"><?php echo esc_html($settings['subheading']); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($settings['button_text'])) :
                        $link = $settings['button_link'];
                        if (!empty($link['url'])) {
                            $this->add_link_attributes('button', $link);
                            $this->add_render_attribute('button', 'class', 'hv-button');
                            echo '<a ' . $this->get_render_attribute_string('button') . '>' . esc_html($settings['button_text']) . '</a>';
                        } else {
                            echo '<span class="hv-button">' . esc_html($settings['button_text']) . '</span>';
                        }
                    endif; ?>
                </div>
            <?php endif; ?>

            <button type="button" class="hv-scroll-cue" aria-label="<?php esc_attr_e('Scroll down', 'westio-child'); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path d="M5 9l7 7 7-7" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
        <?php
    }
}

$widgets_manager->register(new Westio_Child_Hero_Video());

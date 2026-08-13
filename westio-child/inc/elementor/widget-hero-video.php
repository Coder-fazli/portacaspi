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
            'label'      => esc_html__('Video File', 'westio-child'),
            'type'       => Controls_Manager::MEDIA,
            'media_type' => 'video',
            'default'    => [
                'url' => get_stylesheet_directory_uri() . '/assets/videos/hero-intro.mp4',
            ],
        ]);
        $this->add_control('poster', [
            'label'       => esc_html__('Poster Image', 'westio-child'),
            'type'        => Controls_Manager::MEDIA,
            'description' => esc_html__('Shown instantly while the video loads, and instead of the video on mobile if disabled below. Keep this small (under ~150kb) — it is what visitors see first.', 'westio-child'),
            'default'     => [
                'url' => get_stylesheet_directory_uri() . '/assets/images/hero-intro-poster.jpg',
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
            'label'     => esc_html__('Height on Mobile (vh)', 'westio-child'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => ['px' => ['min' => 40, 'max' => 100]],
            'default'   => ['size' => 100],
            'selectors' => [
                '{{WRAPPER}} .hv-hero' => '--hv-mobile-h: {{SIZE}}vh;',
            ],
        ]);
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $video_url  = !empty($settings['video']['url']) ? $settings['video']['url'] : get_stylesheet_directory_uri() . '/assets/videos/hero-intro.mp4';
        $poster_url = !empty($settings['poster']['url']) ? $settings['poster']['url'] : get_stylesheet_directory_uri() . '/assets/images/hero-intro-poster.jpg';
        $play_on_mobile = $settings['play_on_mobile'] === 'yes';

        $this->add_render_attribute('wrapper', 'class', 'hv-hero');
        $this->add_render_attribute('wrapper', 'data-play-mobile', $play_on_mobile ? '1' : '0');
        $this->add_render_attribute('wrapper', 'data-video', esc_url($video_url));
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <img class="hv-poster" src="<?php echo esc_url($poster_url); ?>" alt="" fetchpriority="high">
            <video class="hv-video" muted loop playsinline preload="none" poster="<?php echo esc_url($poster_url); ?>"></video>
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
        </div>
        <?php
    }
}

$widgets_manager->register(new Westio_Child_Hero_Video());

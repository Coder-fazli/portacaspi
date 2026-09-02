<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Westio_Child_Gallery_Masonry extends Widget_Base {

    public function get_name() {
        return 'westio-child-gallery-masonry';
    }

    public function get_title() {
        return esc_html__('Gallery Masonry', 'westio-child');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_script_depends() {
        return ['westio-child-gallery-masonry'];
    }

    public function get_style_depends() {
        return ['westio-child-gallery-masonry'];
    }

    protected function register_controls() {
        $this->start_controls_section('section_header', [
            'label' => esc_html__('Header', 'westio-child'),
        ]);
        $this->add_control('title', [
            'label'   => esc_html__('Title', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__('Qalereya', 'westio-child'),
        ]);
        $this->add_control('description', [
            'label'   => esc_html__('Description', 'westio-child'),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => esc_html__('Sürükləyərək kəşf edin, klikləyərək böyüdün.', 'westio-child'),
        ]);
        $this->end_controls_section();

        $this->start_controls_section('section_items', [
            'label' => esc_html__('Images', 'westio-child'),
        ]);
        $this->add_control('images', [
            'label'       => esc_html__('Images', 'westio-child'),
            'type'        => Controls_Manager::GALLERY,
            'default'     => [],
            'description' => esc_html__('Select as many as you like at once from the media library. Hover captions are pulled automatically from each image\'s Title and Caption fields (set those in the media library if you want them shown) — no need to type them here.', 'westio-child'),
        ]);
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $images   = !empty($settings['images']) ? $settings['images'] : [];
        ?>
        <div class="gm-wrap">
            <?php if (!empty($settings['title']) || !empty($settings['description'])) : ?>
                <div class="gm-header">
                    <?php if (!empty($settings['title'])) : ?>
                        <h2 class="gm-title"><?php echo esc_html($settings['title']); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($settings['description'])) : ?>
                        <p class="gm-description"><?php echo esc_html($settings['description']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="gm-track-wrap">
            <div class="gm-track">
                <div class="gm-grid">
                    <?php if (!empty($images)) :
                        foreach ($images as $image) :
                            $id = !empty($image['id']) ? $image['id'] : 0;
                            $full  = $id ? wp_get_attachment_image_url($id, 'full') : ($image['url'] ?? '');
                            $thumb = $id ? wp_get_attachment_image_url($id, 'large') : $full;
                            if (!$thumb) {
                                continue;
                            }
                            // Title used only for the img's alt text (accessibility) —
                            // no longer shown visually, on hover or in the lightbox.
                            $title = $id ? get_the_title($id) : '';
                            ?>
                            <button type="button" class="gm-item" data-full="<?php echo esc_url($full); ?>">
                                <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" draggable="false">
                            </button>
                        <?php endforeach;
                    else :
                        for ($i = 0; $i < 8; $i++) :
                            $tone = ($i % 4) + 1;
                            ?>
                            <div class="gm-item gm-placeholder gm-t-<?php echo esc_attr($tone); ?>">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true">
                                    <rect x="3" y="5" width="18" height="14" rx="1" />
                                    <circle cx="9" cy="10" r="1.6" />
                                    <path d="M21 16l-5.5-5.5a2 2 0 0 0-2.8 0L3 19" />
                                </svg>
                            </div>
                        <?php endfor;
                    endif; ?>
                </div>
            </div>

            <?php if (!empty($images)) : ?>
                <button type="button" class="gm-nav gm-nav-prev" aria-label="<?php esc_attr_e('Scroll left', 'westio-child'); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M15 5l-7 7 7 7" stroke-linecap="round" stroke-linejoin="round" /></svg>
                </button>
                <button type="button" class="gm-nav gm-nav-next" aria-label="<?php esc_attr_e('Scroll right', 'westio-child'); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" /></svg>
                </button>
            <?php endif; ?>
            </div>
        </div>

        <div class="gm-lightbox">
            <button type="button" class="gm-lightbox-close" aria-label="<?php esc_attr_e('Close', 'westio-child'); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18" stroke-linecap="round" /></svg>
            </button>
            <figure class="gm-lightbox-figure">
                <img class="gm-lightbox-img" src="" alt="">
            </figure>
        </div>
        <?php
    }
}

$widgets_manager->register(new Westio_Child_Gallery_Masonry());

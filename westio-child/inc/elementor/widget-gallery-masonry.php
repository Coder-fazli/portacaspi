<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

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

        $repeater = new Repeater();
        $repeater->add_control('image', [
            'label'   => esc_html__('Image', 'westio-child'),
            'type'    => Controls_Manager::MEDIA,
            'default' => ['url' => Utils::get_placeholder_image_src()],
        ]);
        $repeater->add_control('title', [
            'label'   => esc_html__('Title', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => '',
        ]);
        $repeater->add_control('desc', [
            'label'   => esc_html__('Short description', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => '',
        ]);

        $this->add_control('items', [
            'label'       => esc_html__('Images', 'westio-child'),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ title }}}',
            'default'     => [],
        ]);
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items    = !empty($settings['items']) ? $settings['items'] : [];
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

            <div class="gm-track">
                <div class="gm-grid">
                    <?php if (!empty($items)) :
                        foreach ($items as $item) :
                            $id = !empty($item['image']['id']) ? $item['image']['id'] : 0;
                            $full  = $id ? wp_get_attachment_image_url($id, 'full') : ($item['image']['url'] ?? '');
                            $thumb = $id ? wp_get_attachment_image_url($id, 'large') : $full;
                            if (!$thumb) {
                                continue;
                            }
                            ?>
                            <button type="button" class="gm-item"
                                data-full="<?php echo esc_url($full); ?>"
                                data-title="<?php echo esc_attr($item['title']); ?>"
                                data-desc="<?php echo esc_attr($item['desc']); ?>">
                                <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy" draggable="false">
                                <?php if (!empty($item['title']) || !empty($item['desc'])) : ?>
                                    <span class="gm-item-overlay">
                                        <?php if (!empty($item['title'])) : ?>
                                            <span class="gm-item-title"><?php echo esc_html($item['title']); ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($item['desc'])) : ?>
                                            <span class="gm-item-desc"><?php echo esc_html($item['desc']); ?></span>
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
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
        </div>

        <div class="gm-lightbox">
            <button type="button" class="gm-lightbox-close" aria-label="<?php esc_attr_e('Close', 'westio-child'); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18" stroke-linecap="round" /></svg>
            </button>
            <figure class="gm-lightbox-figure">
                <img class="gm-lightbox-img" src="" alt="">
                <figcaption class="gm-lightbox-caption">
                    <span class="gm-lightbox-title"></span>
                    <span class="gm-lightbox-desc"></span>
                </figcaption>
            </figure>
        </div>
        <?php
    }
}

$widgets_manager->register(new Westio_Child_Gallery_Masonry());

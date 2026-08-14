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
        $this->start_controls_section('section_images', [
            'label' => esc_html__('Images', 'westio-child'),
        ]);
        $this->add_control('images', [
            'label'   => esc_html__('Images', 'westio-child'),
            'type'    => Controls_Manager::GALLERY,
            'default' => [],
        ]);
        $this->add_control('items_per_load', [
            'label'   => esc_html__('Images Per Load', 'westio-child'),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 4,
            'max'     => 48,
            'default' => 12,
        ]);
        $this->add_control('load_more_text', [
            'label'   => esc_html__('Load More Button Text', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__('Daha çox göstər', 'westio-child'),
        ]);
        $this->add_control('load_more_done_text', [
            'label'   => esc_html__('All Loaded Text', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__('Bütün şəkillər yükləndi', 'westio-child'),
        ]);
        $this->end_controls_section();

        $this->start_controls_section('section_layout', [
            'label' => esc_html__('Layout', 'westio-child'),
        ]);
        $this->add_control('columns_desktop', [
            'label'   => esc_html__('Desktop Columns', 'westio-child'),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                '3' => '3',
                '4' => '4',
                '5' => '5',
            ],
            'default' => '4',
        ]);
        $this->add_control('columns_note', [
            'type' => Controls_Manager::RAW_HTML,
            'raw'  => esc_html__('Tablet is fixed at 3 columns and mobile at 2 — matches the rest of the site rather than being configurable per-page.', 'westio-child'),
            'content_classes' => 'elementor-descriptor',
        ]);
        $this->end_controls_section();
    }

    private function render_placeholder_tile($index) {
        $tone = ($index % 4) + 1;
        $heights = ['gm-h-a', 'gm-h-b', 'gm-h-c', 'gm-h-d', 'gm-h-e'];
        $height = $heights[$index % count($heights)];
        ?>
        <div class="gm-placeholder gm-t-<?php echo esc_attr($tone); ?> <?php echo esc_attr($height); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true">
                <rect x="3" y="5" width="18" height="14" rx="1" />
                <circle cx="9" cy="10" r="1.6" />
                <path d="M21 16l-5.5-5.5a2 2 0 0 0-2.8 0L3 19" />
            </svg>
            <span class="gm-placeholder-label"><?php echo esc_html(str_pad($index + 1, 2, '0', STR_PAD_LEFT)); ?></span>
        </div>
        <?php
    }

    protected function render() {
        $settings   = $this->get_settings_for_display();
        $images     = !empty($settings['images']) ? $settings['images'] : [];
        $per_load   = !empty($settings['items_per_load']) ? intval($settings['items_per_load']) : 12;
        $load_more  = !empty($settings['load_more_text']) ? $settings['load_more_text'] : esc_html__('Daha çox göstər', 'westio-child');
        $all_loaded = !empty($settings['load_more_done_text']) ? $settings['load_more_done_text'] : esc_html__('Bütün şəkillər yükləndi', 'westio-child');
        $columns    = !empty($settings['columns_desktop']) ? $settings['columns_desktop'] : '4';

        $slideshow_id = 'gm-' . $this->get_id();
        ?>
        <div class="gm-gallery-wrap" style="--gm-cols: <?php echo esc_attr($columns); ?>;">
            <div class="gm-gallery" data-per-load="<?php echo esc_attr($per_load); ?>">
                <?php if (!empty($images)) :
                    foreach ($images as $i => $image) :
                        $id = !empty($image['id']) ? $image['id'] : 0;
                        $full_url = $id ? wp_get_attachment_image_url($id, 'full') : ($image['url'] ?? '');
                        ?>
                        <div class="gm-item">
                            <a href="<?php echo esc_url($full_url); ?>" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="<?php echo esc_attr($slideshow_id); ?>">
                                <?php if ($id) :
                                    echo wp_get_attachment_image($id, 'large', false, ['loading' => 'lazy']);
                                else : ?>
                                    <img src="<?php echo esc_url($full_url); ?>" alt="" loading="lazy">
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endforeach;
                else :
                    // No images added yet — placeholder grid so the widget never
                    // looks broken in the editor before real photos go in.
                    for ($i = 0; $i < 12; $i++) : ?>
                        <div class="gm-item">
                            <?php $this->render_placeholder_tile($i); ?>
                        </div>
                    <?php endfor;
                endif; ?>
            </div>

            <div class="gm-load-more-wrap">
                <button type="button" class="gm-load-more-btn"><?php echo esc_html($load_more); ?></button>
                <div class="gm-load-more-done" hidden><?php echo esc_html($all_loaded); ?></div>
            </div>
        </div>
        <?php
    }
}

$widgets_manager->register(new Westio_Child_Gallery_Masonry());

<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Westio_Child_Building_Selector extends Widget_Base {

    public function get_name() {
        return 'westio-child-building-selector';
    }

    public function get_title() {
        return esc_html__('Building Selector', 'westio-child');
    }

    public function get_icon() {
        return 'eicon-map-pin';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_script_depends() {
        return ['westio-child-building-selector'];
    }

    public function get_style_depends() {
        return ['westio-child-building-selector'];
    }

    protected function register_controls() {
        $this->start_controls_section('section_image', [
            'label' => esc_html__('Background', 'westio-child'),
        ]);
        $this->add_control('bg_image', [
            'label'   => esc_html__('Image', 'westio-child'),
            'type'    => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section('section_buildings', [
            'label' => esc_html__('Buildings', 'westio-child'),
        ]);

        $repeater = new Repeater();
        $repeater->add_control('number', [
            'label'   => esc_html__('Number', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => '1',
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
        $repeater->add_control('apartments', [
            'label'   => esc_html__('Apartments Count', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => '39',
        ]);
        $repeater->add_control('price_from', [
            'label'   => esc_html__('Price From', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => '27 497 820 РУБ',
        ]);
        $repeater->add_control('size_range', [
            'label'   => esc_html__('Size Range', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => '28 - 140 М²',
        ]);
        $repeater->add_control('delivery', [
            'label'   => esc_html__('Delivery Date', 'westio-child'),
            'type'    => Controls_Manager::TEXT,
            'default' => '2026Г',
        ]);
        $repeater->add_control('link', [
            'label' => esc_html__('Link', 'westio-child'),
            'type'  => Controls_Manager::URL,
        ]);

        $this->add_control('buildings', [
            'label'       => esc_html__('Buildings', 'westio-child'),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ number }}}',
            'default'     => [
                ['number' => '1', 'pos_x' => ['size' => 42], 'pos_y' => ['size' => 55], 'apartments' => '39', 'price_from' => '27 497 820 РУБ', 'size_range' => '28 - 140 М²', 'delivery' => '2026Г'],
                ['number' => '2', 'pos_x' => ['size' => 52], 'pos_y' => ['size' => 45], 'apartments' => '54', 'price_from' => '19 200 000 РУБ', 'size_range' => '24 - 110 М²', 'delivery' => '2027Г'],
                ['number' => '3', 'pos_x' => ['size' => 62], 'pos_y' => ['size' => 42], 'apartments' => '61', 'price_from' => '21 500 000 РУБ', 'size_range' => '30 - 120 М²', 'delivery' => '2027Г'],
                ['number' => '4', 'pos_x' => ['size' => 59], 'pos_y' => ['size' => 38], 'apartments' => '47', 'price_from' => '25 000 000 РУБ', 'size_range' => '32 - 130 М²', 'delivery' => '2028Г'],
                ['number' => '5', 'pos_x' => ['size' => 47], 'pos_y' => ['size' => 27], 'apartments' => '79', 'price_from' => '23 385 960 РУБ', 'size_range' => '26 - 152 М²', 'delivery' => '2029Г'],
                ['number' => '6', 'pos_x' => ['size' => 36], 'pos_y' => ['size' => 40], 'apartments' => '33', 'price_from' => '18 900 000 РУБ', 'size_range' => '22 - 100 М²', 'delivery' => '2026Г'],
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings  = $this->get_settings_for_display();
        $buildings = $settings['buildings'];

        if (empty($buildings) || !is_array($buildings)) {
            return;
        }

        $bg_url = !empty($settings['bg_image']['url']) ? $settings['bg_image']['url'] : Utils::get_placeholder_image_src();
        ?>
        <div class="wb-selector">
            <img class="wb-bg" src="<?php echo esc_url($bg_url); ?>" alt="">

            <?php foreach ($buildings as $i => $b) :
                $x = isset($b['pos_x']['size']) ? $b['pos_x']['size'] : 50;
                $y = isset($b['pos_y']['size']) ? $b['pos_y']['size'] : 50;
                ?>
                <button type="button" class="wb-pin" data-i="<?php echo esc_attr($i); ?>" style="left:<?php echo esc_attr($x); ?>%;top:<?php echo esc_attr($y); ?>%;">
                    <span class="wb-pin-number"><?php echo esc_html($b['number']); ?></span>
                </button>
            <?php endforeach; ?>

            <?php foreach ($buildings as $i => $b) :
                $x = isset($b['pos_x']['size']) ? $b['pos_x']['size'] : 50;
                $y = isset($b['pos_y']['size']) ? $b['pos_y']['size'] : 50;
                ?>
                <div class="wb-card" data-i="<?php echo esc_attr($i); ?>" style="left:<?php echo esc_attr($x); ?>%;top:<?php echo esc_attr($y); ?>%;">
                    <div class="wb-card-top">
                        <div class="wb-card-number"><?php echo esc_html($b['apartments']); ?></div>
                        <div class="wb-card-label"><?php esc_html_e('КВАРТИР', 'westio-child'); ?></div>
                    </div>
                    <div class="wb-card-price"><?php echo esc_html__('ОТ ', 'westio-child') . esc_html($b['price_from']); ?></div>
                    <div class="wb-card-size"><?php echo esc_html($b['size_range']); ?></div>
                    <hr>
                    <div class="wb-card-delivery-label"><?php esc_html_e('СРОК СДАЧИ', 'westio-child'); ?></div>
                    <div class="wb-card-delivery-value"><?php echo esc_html($b['delivery']); ?></div>
                    <?php if (!empty($b['link']['url'])) : ?>
                        <a class="wb-card-link" href="<?php echo esc_url($b['link']['url']); ?>"><?php esc_html_e('Подробнее', 'westio-child'); ?></a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}

$widgets_manager->register(new Westio_Child_Building_Selector());

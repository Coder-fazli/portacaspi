<?php

use Elementor\Controls_Manager;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;
use Elementor\Modules\NestedElements\Controls\Control_Nested_Repeater;
use Elementor\Plugin;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Westio_Nested_Slide extends Widget_Nested_Base {
    use Westio_Carousel_Trait;

    public function get_name() {
        return 'westio-nested-slide';
    }

    public function get_title() {
        return esc_html__( 'Westio Slides', 'westio' );
    }

    public function get_icon() {
        return 'eicon-slides';
    }

    public function get_keywords() {
        return [ 'Carousel', 'Slides', 'Nested', 'Media', 'Gallery', 'Image' ];
    }

    public function get_script_depends() {
        return [ 'westio-elementor-nested-slides', 'westio-elementor-swiper' ];
    }

    public function has_widget_inner_wrapper(): bool {
        // TODO: remove after Optmized Markup experiment is merged to the core
        return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
    }

    protected function get_default_repeater_title_setting_key() {
        return 'slide_title';
    }

    protected function get_default_children_title() {
        return esc_html__( 'Slide #%d', 'westio' );
    }

    protected function get_initial_config(): array {

        return array_merge( parent::get_initial_config(), [
            'support_improved_repeaters' => true,
            'node'                       => 'button',
        ] );

        return parent::get_initial_config();
    }

    protected function get_default_children_placeholder_selector() {
        return '.swiper-wrapper';
    }

    protected function get_default_children_elements() {
        return [
            [
                'elType'   => 'container',
                'settings' => [
                    '_title' => __( 'Slide #1', 'westio' ),
                ],
            ],
            [
                'elType'   => 'container',
                'settings' => [
                    '_title' => __( 'Slide #2', 'westio' ),
                ],
            ],
            [
                'elType'   => 'container',
                'settings' => [
                    '_title' => __( 'Slide #3', 'westio' ),
                ],
            ],
        ];
    }

    public function print_template() {
        parent::print_template();
        if ( $this->get_initial_config()['support_improved_repeaters'] ?? false ) {
            ?>
            <script type="text/html" id="tmpl-elementor-<?php echo esc_attr( $this->get_name() ); ?>-content">
                <?php $this->content_template_single_repeater_item(); ?>
            </script>
            <?php
        }
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_slides',
            [
                'label' => esc_html__( 'Slides', 'westio' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'slide_title',
            [
                'label'       => esc_html__( 'Title', 'westio' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Slide Title', 'westio' ),
                'placeholder' => esc_html__( 'Slide Title', 'westio' ),
                'dynamic'     => [
                    'active' => true,
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'carousel_items',
            [
                'label'              => esc_html__( 'Slides Items', 'westio' ),
                'type'               => Control_Nested_Repeater::CONTROL_TYPE,
                'fields'             => $repeater->get_controls(),
                'default'            => [
                    [
                        'slide_title' => esc_html__( 'Slide #1', 'westio' ),
                    ],
                    [
                        'slide_title' => esc_html__( 'Slide #2', 'westio' ),
                    ],
                    [
                        'slide_title' => esc_html__( 'Slide #3', 'westio' ),
                    ],
                ],
                'frontend_available' => true,
                'title_field'        => '{{{ slide_title }}}',
            ]
        );
        $this->add_control( 'enable_carousel', [
            'label'   => esc_html__( 'Enable Carousel', 'westio' ),
            'type'    => Controls_Manager::HIDDEN,
            'default' => 'yes',
        ] );

        $this->end_controls_section();

        $this->add_control_carousel( [ 'enable_carousel' => 'yes' ] );

        $this->update_control(
            'slides_to_show',
            [
                'default' => "1",
                'type'    => Controls_Manager::HIDDEN,
            ]
        );
        $this->update_control(
            'dots_position',
            [
                'default' => "inside",
                'type'    => Controls_Manager::HIDDEN,
            ]
        );
        $this->update_control(
            'slides_to_scroll',
            [
                'default' => "1",
                'type'    => Controls_Manager::HIDDEN,
            ]
        );

        $this->remove_control( 'spaceBetween' );
        $this->remove_control( 'swiper_overflow' );
        $this->update_control(
            'effect',
            [
                'label'              => esc_html__( 'Effect', 'westio' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'slide',
                'options'            => [
                    'slide'     => esc_html__( 'Slide', 'westio' ),
                    'fade'      => esc_html__( 'Fade', 'westio' ),
                    'coverflow' => esc_html__( 'Coverflow', 'westio' ),
                    'cards'     => esc_html__( 'Cards', 'westio' ),
                    'marquee'   => esc_html__( 'Marquee', 'westio' ),
                    'flip'      => esc_html__( 'Flip', 'westio' ),
                    'cube'      => esc_html__( 'Cube', 'westio' ),
                    'creative'  => esc_html__( 'Creative', 'westio' ),
                ],
                'condition'          => [
                    'slides_to_show' => '1',
                ],
                'frontend_available' => true,
            ]
        );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $settings['enable_carousel'] == 'yes';
        $slides = $settings['carousel_items'];
        $this->get_data_elementor_carousel();

        ?>
        <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
            <div <?php $this->print_render_attribute_string( 'container' ); ?>>
                <div <?php $this->print_render_attribute_string( 'inner' ); ?>>
                    <?php
                    foreach ( $slides as $index => $slide ) {
                        $slide_count       = $index + 1;
                        $slide_setting_key = $this->get_repeater_setting_key( 'slide_wrapper', 'slide', $index );
                        $this->add_render_attribute( $slide_setting_key, [
                            'class'                => 'swiper-slide',
                            'data-slide'           => $slide_count,
                            'role'                 => 'group',
                            'aria-roledescription' => 'slide',
                            'aria-label'           => sprintf(
                                esc_attr__( '%1$s of %2$s', 'westio' ),
                                $slide_count,
                                count( $slides )
                            ),
                        ] );
                        ?>
                        <div <?php $this->print_render_attribute_string( $slide_setting_key ); ?>>
                            <?php $this->print_child( $index ); ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php $this->render_swiper_pagination_navigation(); ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {

        if ( Plugin::$instance->experiments->is_feature_active( 'nested-elements' ) == false ) {
            return;
        }

        ?>
        <#
        var showDots = settings.navigation.includes('dots') || settings.navigation.includes('both'),
        showArrows = settings.navigation.includes('arrows') || settings.navigation.includes('both');
        previous_icon = elementor.helpers.renderIcon( view, settings.navigation_previous_icon, { 'aria-hidden': true }, 'i' , 'object' ),
        migrated_prev = elementor.helpers.isIconMigrated( settings, 'navigation_previous_icon' ),

        next_icon = elementor.helpers.renderIcon( view, settings.navigation_next_icon, { 'aria-hidden': true }, 'i' , 'object' ),
        migrated_next = elementor.helpers.isIconMigrated( settings, 'navigation_next_icon' )
        #>
        <div class="westio-swiper {{ elementorFrontend.config.swiperClass }}">
            <div class='swiper-wrapper'></div>
            <# if(settings.enable_scrollbar == 'yes'){ #>
            <div class="swiper-scrollbar"></div>
            <# } #>
            <# if ( showDots) { #>
            <div class="swiper-pagination"></div>
            <# } #>
            <# if ( showArrows) { #>
            <div class="elementor-swiper-button elementor-swiper-button-prev">
                <# if ( previous_icon && previous_icon.rendered && ( ! settings.icon || migrated_prev ) ) { #>
                {{{ previous_icon.value }}}
                <# } else { #>
                <i class="eicon-angle-left" aria-hidden="true"></i>
                <# } #>
            </div>
            <div class="elementor-swiper-button elementor-swiper-button-next">
                <# if ( next_icon && next_icon.rendered && ( ! settings.icon || migrated_next ) ) { #>
                {{{ next_icon.value }}}
                <# } else { #>
                <i class="eicon-angle-right" aria-hidden="true"></i>
                <# } #>
            </div>
            <# } #>
        </div>
        <?php
    }
}

$widgets_manager->register( new Westio_Nested_Slide() );
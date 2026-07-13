<?php
/**
 * Elementor Classes.
 *
 * @package westio
 */

//namespace HFE\WidgetsManager\Widgets;

use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Plugin;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit;   // Exit if accessed directly.
}

/**
 * HFE Site Logo widget
 *
 * HFE widget for Site Logo.
 *
 * @since 1.3.0
 */
class Westio_Site_Logo extends Widget_Base {

    /**
     * Retrieve the widget name.
     *
     * @return string Widget name.
     * @since 1.3.0
     *
     * @access public
     *
     */
    public function get_name() {
        return 'westio-site-logo';
    }

    /**
     * Retrieve the widget title.
     *
     * @return string Widget title.
     * @since 1.3.0
     *
     * @access public
     *
     */
    public function get_title() {
        return __('Site Logo', 'westio');
    }

    /**
     * Retrieve the widget icon.
     *
     * @return string Widget icon.
     * @since 1.3.0
     *
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-logo';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @return array Widget categories.
     * @since 1.3.0
     *
     * @access public
     *
     */
    public function get_categories() {
        return ['westio-widgets'];
    }

    /**
     * Register Site Logo controls.
     *
     * @since 1.5.7
     * @access protected
     */
    protected function register_controls() {
        $this->register_content_site_logo_controls();
        $this->register_site_logo_styling_controls();
        $this->register_site_logo_caption_styling_controls();
    }

    /**
     * Register Site Logo General Controls.
     *
     * @since 1.3.0
     * @access protected
     */
    protected function register_content_site_logo_controls() {
        $this->start_controls_section(
            'section_site_image',
            [
                'label' => __('Site Logo', 'westio'),
            ]
        );

        $this->add_control(
            'site_logo_fallback',
            [
                'label'       => __('Custom Image', 'westio'),
                'type'        => Controls_Manager::SWITCHER,
                'yes'         => __('Yes', 'westio'),
                'no'          => __('No', 'westio'),
                'default'     => 'no',
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'custom_image',
            [
                'label'     => __('Add Image', 'westio'),
                'type'      => Controls_Manager::MEDIA,
                'dynamic'   => [
                    'active' => true,
                ],
                'default'   => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'site_logo_fallback' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'site_logo_size',
                'label'   => __('Image Size', 'westio'),
                'default' => 'medium',
            ]
        );
        $this->add_responsive_control(
            'align',
            [
                'label'     => __('Alignment', 'westio'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'westio'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'westio'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'westio'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .westio-site-logo-container, {{WRAPPER}} .westio-caption-width figcaption' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'caption_source',
            [
                'label'   => __('Caption', 'westio'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'no'  => __('No', 'westio'),
                    'yes' => __('Yes', 'westio'),
                ],
                'default' => 'no',
            ]
        );

        $this->add_control(
            'caption',
            [
                'label'       => __('Custom Caption', 'westio'),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'placeholder' => __('Enter caption', 'westio'),
                'condition'   => [
                    'caption_source' => 'yes',
                ],
                'dynamic'     => [
                    'active' => true,
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'link_to',
            [
                'label'   => __('Link', 'westio'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __('Default', 'westio'),
                    'none'    => __('None', 'westio'),
                    'file'    => __('Media File', 'westio'),
                    'custom'  => __('Custom URL', 'westio'),
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label'       => __('Link', 'westio'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => __('https://your-link.com', 'westio'),
                'condition'   => [
                    'link_to' => 'custom',
                ],
                'show_label'  => false,
            ]
        );

        $this->add_control(
            'open_lightbox',
            [
                'label'     => __('Lightbox', 'westio'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'default',
                'options'   => [
                    'default' => __('Default', 'westio'),
                    'yes'     => __('Yes', 'westio'),
                    'no'      => __('No', 'westio'),
                ],
                'condition' => [
                    'link_to' => 'file',
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label'   => __('View', 'westio'),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Register Site Image Style Controls.
     *
     * @since 1.3.0
     * @access protected
     */
    protected function register_site_logo_styling_controls() {
        $this->start_controls_section(
            'section_style_site_logo_image',
            [
                'label' => __('Site logo', 'westio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label'          => __('Width', 'westio'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units'     => ['%', 'px', 'vw'],
                'range'          => [
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .westio-site-logo .westio-site-logo-container img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'space',
            [
                'label'          => __('Max Width', 'westio') . ' (%)',
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units'     => ['%'],
                'range'          => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .westio-site-logo img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'separator_panel_style',
            [
                'type'  => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_control(
            'site_logo_background_color',
            [
                'label'     => __('Background Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .westio-site-logo-set .westio-site-logo-container' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'site_logo_image_border',
            [
                'label'       => __('Border Style', 'westio'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'none',
                'label_block' => false,
                'options'     => [
                    'none'   => __('None', 'westio'),
                    'solid'  => __('Solid', 'westio'),
                    'double' => __('Double', 'westio'),
                    'dotted' => __('Dotted', 'westio'),
                    'dashed' => __('Dashed', 'westio'),
                ],
                'selectors'   => [
                    '{{WRAPPER}} .westio-site-logo-container .westio-site-logo-img' => 'border-style: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'site_logo_image_border_size',
            [
                'label'      => __('Border Width', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'    => '1',
                    'bottom' => '1',
                    'left'   => '1',
                    'right'  => '1',
                    'unit'   => 'px',
                ],
                'condition'  => [
                    'site_logo_image_border!' => 'none',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .westio-site-logo-container .westio-site-logo-img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'site_logo_image_border_color',
            [
                'label'     => __('Border Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'condition' => [
                    'site_logo_image_border!' => 'none',
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .westio-site-logo-container .westio-site-logo-img' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => __('Border Radius', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .westio-site-logo img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'image_box_shadow',
                'exclude'  => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .westio-site-logo img',
            ]
        );

        $this->start_controls_tabs('image_effects');

        $this->start_controls_tab(
            'normal',
            [
                'label' => __('Normal', 'westio'),
            ]
        );

        $this->add_control(
            'opacity',
            [
                'label'     => __('Opacity', 'westio'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .westio-site-logo img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'css_filters',
                'selector' => '{{WRAPPER}} .westio-site-logo img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'hover',
            [
                'label' => __('Hover', 'westio'),
            ]
        );
        $this->add_control(
            'opacity_hover',
            [
                'label'     => __('Opacity', 'westio'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .westio-site-logo:hover img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'background_hover_transition',
            [
                'label'     => __('Transition Duration', 'westio'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .westio-site-logo img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .westio-site-logo:hover img',
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __('Hover Animation', 'westio'),
                'type'  => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Register Site Logo style Controls.
     *
     * @since 1.3.0
     * @access protected
     */
    protected function register_site_logo_caption_styling_controls() {
        $this->start_controls_section(
            'section_style_caption',
            [
                'label'     => __('Caption', 'westio'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'caption_source!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => __('Text Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .widget-image-caption' => 'color: {{VALUE}};',
                ],
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
            ]
        );

        $this->add_control(
            'caption_background_color',
            [
                'label'     => __('Background Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widget-image-caption' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'caption_typography',
                'selector' => '{{WRAPPER}} .widget-image-caption',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'caption_text_shadow',
                'selector' => '{{WRAPPER}} .widget-image-caption',
            ]
        );

        $this->add_responsive_control(
            'caption_padding',
            [
                'label'      => __('Padding', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .widget-image-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'caption_space',
            [
                'label'     => __('Spacing', 'westio'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'   => [
                    'size' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .widget-image-caption' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: 0px;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Check if the current widget has caption
     *
     * @access private
     * @param array $settings returns settings.
     *
     * @return boolean
     * @since 1.3.0
     *
     */
    private function has_caption($settings) {
        return (!empty($settings['caption_source']) && 'no' !== $settings['caption_source']);
    }

    /**
     * Get the caption for current widget.
     *
     * @access private
     * @param array $settings returns the caption.
     *
     * @return string
     * @since 1.3.0
     */
    private function get_caption($settings) {
        $caption = '';
        if ('yes' === $settings['caption_source']) {
            $caption = !empty($settings['caption']) ? $settings['caption'] : '';
        }
        return $caption;
    }

    /**
     * Render Site Image output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @param array $size returns the size of an image.
     * @access public
     * @since 1.3.0
     */
    public function site_image_url($size) {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['custom_image']['url'])) {
            $logo = wp_get_attachment_image_src($settings['custom_image']['id'], $size, true);
        } else {
            $logo = wp_get_attachment_image_src(get_theme_mod('custom_logo'), $size, true);
        }
        return $logo[0];
    }

    /**
     * Render Site Image output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.3.0
     * @access protected
     */
    protected function render() {
        $link     = '';
        $settings = $this->get_settings_for_display();

        $has_caption = $this->has_caption($settings);

        $this->add_render_attribute('wrapper', 'class', 'westio-site-logo');

        $size = $settings['site_logo_size_size'];

        $site_image = $this->site_image_url($size);

        if (site_url() . '/wp-includes/images/media/default.png' === $site_image) {
            $site_image = site_url() . '/wp-content/plugins/elementor/assets/images/placeholder.png';
        } else {
            $site_image = $site_image;
        }

        if ('file' === $settings['link_to']) {
            $link = $site_image;
            $this->add_render_attribute('link', 'href', $link);
        } elseif ('default' === $settings['link_to']) {
            $link = site_url();
            $this->add_render_attribute('link', 'href', $link);
        } else {
            $link = $this->get_link_url($settings);

            if ($link) {
                $this->add_link_attributes('link', $link);
            }
        }
        $class = '';
        if (Plugin::$instance->editor->is_edit_mode()) {
            $class = 'elementor-non-clickable';
        } else {
            $class = 'elementor-clickable';
        }
        ?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <?php if ($has_caption) : ?>
            <figure class="wp-caption">
                <?php endif; ?>
                <?php if ($link) : ?>
            <?php
            if ('no' === $settings['open_lightbox']) {
                $class = 'elementor-non-clickable';
            }
            ?>
                <a data-elementor-open-lightbox="<?php echo esc_attr($settings['open_lightbox']); ?>" class='<?php echo esc_attr($class); ?>' <?php $this->print_render_attribute_string('link'); ?>>
                    <?php endif; ?>
                    <?php
                    if (empty($site_image)) {
                        return;
                    }
                    $img_animation = '';

                    if ('custom' !== $size) {
                        $image_size = $size;
                    } else {
                        require_once ELEMENTOR_PATH . 'includes/libraries/bfi-thumb/bfi-thumb.php';

                        $image_dimension = $settings['site_logo_size_custom_dimension'];

                        $image_size = [
                            // Defaults sizes.
                            0 => null, // Width.
                            1 => null, // Height.

                            'bfi_thumb' => true,
                            'crop'      => true,
                        ];

                        $has_custom_size = false;
                        if (!empty($image_dimension['width'])) {
                            $has_custom_size = true;
                            $image_size[0]   = $image_dimension['width'];
                        }

                        if (!empty($image_dimension['height'])) {
                            $has_custom_size = true;
                            $image_size[1]   = $image_dimension['height'];
                        }

                        if (!$has_custom_size) {
                            $image_size = 'full';
                        }
                    }

                    $image_url = $site_image;

                    if (!empty($settings['custom_image']['url'])) {
                        $image_data = wp_get_attachment_image_src($settings['custom_image']['id'], $image_size, true);
                    } else {
                        $image_data = wp_get_attachment_image_src(get_theme_mod('custom_logo'), $image_size, true);
                    }

                    $site_image_class = 'elementor-animation-';

                    if (!empty($settings['hover_animation'])) {
                        $img_animation = $settings['hover_animation'];
                    }
                    if (!empty($image_data)) {
                        $image_url = $image_data[0];
                    }

                    if (site_url() . '/wp-includes/images/media/default.png' === $image_url) {
                        $image_url = site_url() . '/wp-content/plugins/elementor/assets/images/placeholder.png';
                    } else {
                        $image_url = $image_url;
                    }

                    $class_animation = $site_image_class . $img_animation;

                    $image_unset = site_url() . '/wp-content/plugins/elementor/assets/images/placeholder.png';

                    if ($image_unset !== $image_url) {
                        $image_url = $image_url;
                    }

                    ?>
                    <div class="westio-site-logo-set">
                        <div class="westio-site-logo-container">
                            <img class="westio-site-logo-img <?php echo esc_attr($class_animation); ?>" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(Control_Media::get_image_alt($settings['custom_image'])); ?>"/>
                        </div>
                    </div>
                    <?php if ($link) : ?>
                </a>
            <?php endif; ?>
                <?php
                if ($has_caption) :
                $caption_text = $this->get_caption($settings);
                ?>
                <?php if (!empty($caption_text)) : ?>
                    <div class="westio-caption-width">
                        <figcaption class="widget-image-caption wp-caption-text"><?php echo wp_kses_post($caption_text); ?></figcaption>
                    </div>
                <?php endif; ?>
            </figure>
        <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Retrieve Site Logo widget link URL.
     *
     * @param array $settings returns settings.
     * @return array|string|false An array/string containing the link URL, or false if no link.
     * @since 1.3.0
     * @access private
     *
     */
    private function get_link_url($settings) {
        if ('none' === $settings['link_to']) {
            return false;
        }

        if ('custom' === $settings['link_to']) {
            if (empty($settings['link']['url'])) {
                return false;
            }
            return $settings['link'];
        }

        if ('default' === $settings['link_to']) {
            if (empty($settings['link']['url'])) {
                return false;
            }
            return site_url();
        }
    }
}


$widgets_manager->register(new Westio_Site_Logo());
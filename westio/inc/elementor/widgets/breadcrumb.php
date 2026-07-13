<?php


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Icons_Manager;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Westio_Elementor_Breadcrumb extends Elementor\Widget_Base {

    public function get_name() {
        return 'westio-breadcrumb';
    }

    public function get_title() {
        return esc_html__('Westio Breadcrumbs', 'westio');
    }

    public function get_icon() {
        return 'eicon-product-breadcrumbs';
    }

    public function get_keywords() {
        return ['breadcrumbs'];
    }

    public function get_categories() {
        return array('westio-addons');
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Style Breadcrumbs', 'westio'),
                'tab'   => Controls_Manager::TAB_CONTENT,

            ]
        );

        $this->add_control(
            'display_title',
            [
                'label'   => esc_html__('Display Title', 'westio'),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'display_nav',
            [
                'label'   => esc_html__('Display Nav', 'westio'),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'separator',
            [
                'label'            => __('Separator', 'westio'),
                'type'             => Controls_Manager::ICONS,
                'label_block'      => false,
                'skin'             => 'inline',
                'fa4compatibility' => 'icon',
                'default'          => [
                    'value'   => 'westio-icon-dot-01',
                    'library' => 'westio-icon',
                ],
                'condition'        => [
                    'display_nav' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'home_text',
            [
                'label'     => __('Home Page', 'westio'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Home', 'westio'),
                'condition' => [
                    'display_nav' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'search_text',
            [
                'label'     => __('Search', 'westio'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Search results for:', 'westio'),
                'condition' => [
                    'display_nav' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'error_text',
            [
                'label'     => __('404 Page', 'westio'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('404 Error Page', 'westio'),
                'condition' => [
                    'display_nav' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'tag',
            [
                'label'     => esc_html__('HTML Tag Title', 'westio'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default'   => 'h2',
                'condition' => [
                    'display_title' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'     => esc_html__('Alignment', 'westio'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'westio'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'westio'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'westio'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb'          => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .westio-title'        => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .breadcrumb-listItem' => 'justify-content: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label'     => esc_html__('Style Title', 'westio'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'text_color_title',
            [
                'label'     => esc_html__('Title Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .westio-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .westio-title',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name'     => 'text_stroke',
                'selector' => '{{WRAPPER}} .westio-title',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'title_shadow',
                'selector' => '{{WRAPPER}} .elementor-accordion-title',
            ]
        );

        $this->add_control(
            'title_direction',
            [
                'label'        => esc_html__('Direction', 'westio'),
                'type'         => \Elementor\Controls_Manager::CHOOSE,
                'options'      => [
                    'above' => [
                        'title' => esc_html__('Above', 'westio'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'below' => [
                        'title' => esc_html__('Below', 'westio'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'default'      => 'above',
                'prefix_class' => 'title-direction-',
                'condition'    => [
                    'display_title' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__('Margin', 'westio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .westio-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_item',
            [
                'label'     => esc_html__('Style Breadcrumbs Item', 'westio'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_nav' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__('Text Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label'     => esc_html__('Link Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'link_color_hover',
            [
                'label'     => esc_html__('Link Color Hover', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'text_typography',
                'selector' => '{{WRAPPER}} .breadcrumb',
            ]
        );

        $this->add_responsive_control(
            'size_separator',
            [
                'label'      => esc_html__('Separator Size', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .breadcrumbs-separator i'   => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .breadcrumbs-separator svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                ],
                'condition'  => [
                    'separator[value]!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'size_spacing',
            [
                'label'      => esc_html__('Separator Spacing', 'westio'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .breadcrumbs-separator' => 'margin: 0 {{SIZE}}{{UNIT}}',
                ],
                'condition'  => [
                    'separator[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'separator_color',
            [
                'label'     => esc_html__('Separator Color', 'westio'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'separator[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .breadcrumbs-separator i'   => 'color: {{VALUE}}',
                    '{{WRAPPER}} .breadcrumbs-separator svg' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $title = $this->get_page_title(false);
        $tag   = Utils::validate_html_tag($settings['tag']);

        $this->add_render_attribute('headline', 'class', 'westio-title');
        ?>
        <div class="breadcrumb" typeof="BreadcrumbList" vocab="https://schema.org/">
        <?php if (isset($settings['display_title']) && $settings['display_title'] == 'yes'): ?>
            <<?php Utils::print_validated_html_tag($tag); ?> <?php $this->print_render_attribute_string('headline'); ?>>
            <?php if (is_404()) {
                echo wp_kses_post($settings['error_text']);
            } else {
                echo wp_kses_post($title);
            } ?>
            </<?php Utils::print_validated_html_tag($tag); ?>>
        <?php endif; ?>

        <?php if (isset($settings['display_nav']) && $settings['display_nav'] == 'yes') {
            $this->breadcrumb_item();
        } ?>

        </div>
        <?php
    }

    public static function get_page_title($include_context = true) {
        $title = '';

        if (is_singular()) {
            $title = get_the_title();
            if ($include_context && $obj = get_post_type_object(get_post_type())) {
                $title = sprintf('%s 12: %s', $obj->labels->singular_name, $title);
            }
        } elseif (is_home()) {
            $title = get_the_title(get_option('page_for_posts'));
        } elseif (is_search()) {
            $title = sprintf(__('Search Results for: %s', 'westio'), get_search_query());
            if (get_query_var('paged')) {
                $title .= sprintf(__(' – Page %s', 'westio'), get_query_var('paged'));
            }
        } elseif (is_category() || is_tag() || is_tax()) {
            $term_title = single_term_title('', false);
            if ($include_context) {
                if (is_category()) {
                    $title = sprintf(__('Category: %s', 'westio'), $term_title);
                } elseif (is_tag()) {
                    $title = sprintf(__('Tag: %s', 'westio'), $term_title);
                } elseif ($tax = get_taxonomy(get_queried_object()->taxonomy)) {
                    $title = sprintf(__('%1$s: %2$s', 'westio'), $tax->labels->singular_name, $term_title);
                }
            } else {
                $title = $term_title;
            }
        } elseif (is_author()) {
            $name  = get_the_author();
            $title = $include_context ? sprintf(__('Author: %s', 'westio'), $name) : $name;
        } elseif (is_year()) {
            $date  = get_the_date(_x('Y', 'yearly archives', 'westio'));
            $title = $include_context ? sprintf(__('Year: %s', 'westio'), $date) : $date;
        } elseif (is_month()) {
            $date  = get_the_date(_x('F Y', 'monthly archives', 'westio'));
            $title = $include_context ? sprintf(__('Month: %s', 'westio'), $date) : $date;
        } elseif (is_day()) {
            $date  = get_the_date(_x('F j, Y', 'daily archives', 'westio'));
            $title = $include_context ? sprintf(__('Day: %s', 'westio'), $date) : $date;
        } elseif (is_post_type_archive()) {
            $name  = post_type_archive_title('', false);
            $title = $include_context ? sprintf(__('Archives: %s', 'westio'), $name) : $name;
        } elseif (is_tax('post_format')) {
            $format  = get_query_var('post_format');
            $formats = [
                'post-format-aside'   => __('Asides', 'westio'),
                'post-format-gallery' => __('Galleries', 'westio'),
                'post-format-image'   => __('Images', 'westio'),
                'post-format-video'   => __('Videos', 'westio'),
                'post-format-quote'   => __('Quotes', 'westio'),
                'post-format-link'    => __('Links', 'westio'),
                'post-format-status'  => __('Statuses', 'westio'),
                'post-format-audio'   => __('Audio', 'westio'),
                'post-format-chat'    => __('Chats', 'westio'),
            ];
            $title   = $formats[$format] ?? '';
        } elseif (is_archive()) {
            $title = __('Archives', 'westio');
        } elseif (is_404()) {
            $title = __('Page Not Found', 'westio');
        }

        return apply_filters('westio_get_the_breadcrumbs_title', $title);
    }

    public function breadcrumb_item() {
        $settings    = $this->get_settings_for_display();
        $breadcrumbs = [];
        $delimiter   = '';

        if (isset($settings['separator'])) {
            ob_start();
            Icons_Manager::render_icon($settings['separator'], ['aria-hidden' => 'true']);
            $delimiter = ob_get_clean();
        }

        $defaults = [
            'home'         => isset($settings['home_text']) ? $settings['home_text'] : __('Westio', 'westio'),
            '404_title'    => isset($settings['error_text']) ? $settings['error_text'] : __('Page not found', 'westio'),
            'search_title' => isset($settings['search_text']) ? $settings['search_text'] : __('Search results for: ', 'westio'),
        ];

        $breadcrumbs[] = [
            'title' => $defaults['home'],
            'url'   => esc_url(home_url()),
            'class' => 'hfe-breadcrumbs-first',
        ];

        if (!is_front_page()) {
            if (is_home()) {
                $breadcrumbs[] = [
                    'title' => get_the_title(get_option('page_for_posts')),
                    'url'   => '',
                    'class' => '',
                ];

            } elseif (is_single()) {
                $post_id          = get_queried_object_id();
                $post_type        = get_post_type($post_id);
                $post_type_object = get_post_type_object($post_type);

                if ($post_type_object) {
                    $breadcrumbs[] = [
                        'title' => $post_type_object->labels->name,
                        'url'   => esc_url(get_post_type_archive_link($post_type)),
                        'class' => '',
                    ];
                }

                if ($post_type === 'post') {
                    $categories = get_the_category($post_id);
                } else {
                    $taxonomy   = $post_type . '_cat';
                    $categories = get_the_terms($post_id, $taxonomy);
                }

                if ($categories && !is_wp_error($categories)) {
                    $selected_category = null;

                    foreach ($categories as $category) {
                        if ($category->parent === 0) {
                            $selected_category = $category;
                            break;
                        }
                    }

                    if (!$selected_category) {
                        $selected_category = $categories[0];
                    }

                    if ($selected_category) {
                        $breadcrumbs[] = [
                            'title' => $selected_category->name,
                            'url'   => esc_url(get_term_link($selected_category)),
                            'class' => '',
                        ];
                    }
                }

                $breadcrumbs[] = [
                    'title' => get_the_title($post_id),
                    'url'   => '',
                    'class' => 'hfe-breadcrumbs-last',
                ];
            } elseif (is_page() && !is_front_page()) {
                $parents = get_post_ancestors(get_the_ID());
                foreach (array_reverse($parents) as $parent) {
                    $breadcrumbs[] = [
                        'title' => get_the_title($parent),
                        'url'   => esc_url(get_permalink($parent)),
                        'class' => '',
                    ];
                }
                $breadcrumbs[] = [
                    'title' => get_the_title(),
                    'url'   => '',
                    'class' => 'hfe-breadcrumbs-last',
                ];
            } elseif (is_category() || is_archive()) {
                $post_type        = get_post_type();
                $post_type_object = get_post_type_object($post_type);

                if ($post_type_object) {
                    $archive_link = get_post_type_archive_link($post_type);
                    if ($archive_link) {
                        $breadcrumbs[] = [
                            'title' => $post_type_object->labels->name,
                            'url'   => esc_url($archive_link),
                            'class' => '',
                        ];
                    }
                }

                $current_category = single_cat_title('', false);
                if ($current_category) {
                    $breadcrumbs[] = [
                        'title' => esc_html($current_category),
                        'url'   => '',
                        'class' => 'hfe-breadcrumbs-last',
                    ];
                }
            } elseif (is_tag()) {
                $breadcrumbs[] = [
                    'title' => single_tag_title('', false),
                    'url'   => '',
                    'class' => 'hfe-breadcrumbs-last',
                ];
            } elseif (is_author()) {
                $breadcrumbs[] = [
                    'title' => get_the_author(),
                    'url'   => '',
                    'class' => 'hfe-breadcrumbs-last',
                ];
            } elseif (is_search()) {
                $breadcrumbs[] = [
                    'title' => $defaults['search_title'] . get_search_query(),
                    'url'   => '',
                    'class' => 'hfe-breadcrumbs-last',
                ];
            } elseif (is_404()) {
                $breadcrumbs[] = [
                    'title' => $defaults['404_title'],
                    'url'   => '',
                    'class' => 'hfe-breadcrumbs-last',
                ];
            }
        }

        $output = '<div class="breadcrumb-listItem">';

        foreach ($breadcrumbs as $index => $breadcrumb) {
            $output .= '<span class="breadcrumbs-item ' . esc_attr($breadcrumb['class']) . '">';

            if ($breadcrumb['url']) {
                $output .= '<a href="' . esc_url($breadcrumb['url']) . '"><span class="breadcrumbs-text">' . wp_kses_post($breadcrumb['title']) . '</span></a>';
            } else {
                $output .= '<span class="breadcrumbs-text">' . wp_kses_post($breadcrumb['title']) . '</span>';
            }
            $output .= '</span>';

            if ($index < count($breadcrumbs) - 1) {
                $output .= '<span class="breadcrumbs-separator">';
                $output .= $delimiter;
                $output .= '</span>';
            }
        }
        $output .= '</div>';

        echo sprintf('%s', $output);

    }
}

$widgets_manager->register(new Westio_Elementor_Breadcrumb());

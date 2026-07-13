<?php

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

trait Westio_Products_Trait {

    private $product_query_types
        = [
            'cross_sells',
            'related_products',
            'upsells',
        ];

    private $product_query_controls_to_hide
        = [
            'avoid_duplicates',
            'date_after',
            'date_before',
            'exclude',
            'exclude_authors',
            'exclude_ids',
            'exclude_term_ids',
            'include',
            'include_authors',
            'include_term_ids',
            'offset',
            'query_exclude',
            'query_include',
            'select_date',
        ];

    private $product_query_group_control_name;

    private $product_query_control_args;

    private $product_query_post_type_control_id;

    /**
     * Get Product Query Fields Options
     *
     * Returns an array of options for controls in the Query group control specific for products-related queries.
     *
     * @return array
     * @since 3.8.0
     *
     */
    private function get_query_fields_options() {
        return [
            'post_type' => [
                'default' => 'product',
                'options' => [
                    'current_query'    => esc_html__( 'Current Query', 'westio' ),
                    'product'          => esc_html__( 'Latest Products', 'westio' ),
                    'sale'             => esc_html__( 'Sale', 'westio' ),
                    'featured'         => esc_html__( 'Featured', 'westio' ),
                    'by_id'            => _x( 'Manual Selection', 'Posts Query Control', 'westio' ),
                    'related_products' => esc_html__( 'Related Products', 'westio' ),
                    'upsells'          => esc_html__( 'Upsells', 'westio' ),
                    'cross_sells'      => esc_html__( 'Cross-Sells', 'westio' ),
                ],
            ],
            'posts_ids' => [
                'autocomplete' => [
                    'object' => 'post',
                    'query'  => [
                        'post_type' => 'product'
                    ],
                ],
            ],
            'orderby'   => [
                'default' => 'date',
                'options' => [
                    'date'       => esc_html__( 'Date', 'westio' ),
                    'title'      => esc_html__( 'Title', 'westio' ),
                    'price'      => esc_html__( 'Price', 'westio' ),
                    'popularity' => esc_html__( 'Popularity', 'westio' ),
                    'rating'     => esc_html__( 'Rating', 'westio' ),
                    'rand'       => esc_html__( 'Random', 'westio' ),
                    'menu_order' => esc_html__( 'Menu Order', 'westio' ),
                ],
            ],
            'exclude'   => [
                'options' => [
                    'current_post'     => esc_html__( 'Current Post', 'westio' ),
                    'manual_selection' => esc_html__( 'Manual Selection', 'westio' ),
                    'terms'            => esc_html__( 'Term', 'westio' ),
                ],
            ],
            'include'   => [
                'options' => [
                    'terms' => esc_html__( 'Term', 'westio' ),
                ],
            ],
        ];
    }

    private function init_query_settings( $name ) {
        $this->product_query_group_control_name   = $name;
        $this->product_query_control_args         = $this->get_query_control_args();
        $this->product_query_post_type_control_id = $this->get_query_post_type_control_id();
    }

    /**
     * @return array
     */
    private function get_query_control_args() {
        $args = [
            'name'           => $this->product_query_group_control_name,
            'post_type'      => 'product',
            'presets'        => [ 'include', 'exclude', 'order' ],
            'fields_options' => $this->get_query_fields_options(),
            'exclude'        => [
                'posts_per_page',
                'exclude_authors',
                'authors',
                'offset',
                'related_fallback',
                'related_ids',
                'query_id',
                'avoid_duplicates',
                'ignore_sticky_posts',
            ],
        ];

        $args['fields_options'] = array_merge( $args['fields_options'], $this->get_query_exclude_conditions() );

        return $args;
    }

    private function get_query_exclude_conditions() {
        $fields = [];
        foreach ( $this->product_query_controls_to_hide as $control_name ) {
            $fields = $this->add_query_not_supported_types( $control_name, $fields );
        }

        return $fields;
    }

    private function add_query_not_supported_types( $control_name, $fields ) {
        foreach ( $this->product_query_types as $query_type ) {
            $fields[ $control_name ]['condition']['post_type!'][] = $query_type;
        }

        return $fields;
    }

    /**
     * @return string
     */
    private function get_query_post_type_control_id() {
        $control_id = $this->product_query_control_args['name'] . '_post_type';

        // Check if the trait is currently being used by a widget or skin. Group controls add
        // the post_type as a prefix when added by a skin.
        if ( method_exists( $this, 'get_control_id' ) ) {
            $control_id = $this->product_query_control_args['post_type'] . '_' . $control_id;
        }

        return $control_id;
    }

    protected function add_query_controls( $name ) {
        $this->init_query_settings( $name );
        $this->add_group_control(
            'query-group',
            $this->product_query_control_args
        );

        $this->add_control(
            'related_products_note',
            [
                'type'       => Controls_Manager::ALERT,
                'alert_type' => 'info',
                'content'    => esc_html__( 'Note: The Related Products Query is available when creating a Single Product template', 'westio' ),
                'condition'  => [
                    $this->product_query_post_type_control_id => 'related_products',
                ],
            ]
        );

        $this->add_control(
            'upsells_products_note',
            [
                'type'       => Controls_Manager::ALERT,
                'alert_type' => 'info',
                'content'    => esc_html__( 'Note: The Upsells Query is available when creating a Single Product template', 'westio' ),
                'condition'  => [
                    $this->product_query_post_type_control_id => 'upsells',
                ],
            ]
        );

        $this->add_control(
            'cross_sells_products_note',
            [
                'type'       => Controls_Manager::ALERT,
                'alert_type' => 'info',
                'content'    => esc_html__( 'Note: The Cross-Sells Query is available when creating a Cart page', 'westio' ),
                'condition'  => [
                    $this->product_query_post_type_control_id => 'cross_sells',
                ],
            ]
        );
    }
}

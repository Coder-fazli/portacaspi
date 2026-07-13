<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Core\Common\Modules\Ajax\Module as Ajax;

//use ElementorPro\Core\Security\Access_Control;
//use ElementorPro\Plugin;
use Elementor\Plugin;
use Elementor\TemplateLibrary\Source_Local;
use Westio\Core\Security\Access_Control;
use Westio\elementor\Controls\Westio_Group_Control_Query;
use Elementor\Controls_Manager;

if ( ! class_exists( 'Westio_Query_Controls' ) ) :

    /**
     * The Westio Elementor Integration class
     */
    class Westio_Query_Controls {

        const QUERY_CONTROL_ID        = 'query';
        const AUTOCOMPLETE_ERROR_CODE = 'QueryControlAutocomplete';
        const GET_TITLES_ERROR_CODE   = 'QueryControlGetTitles';

        // Supported objects for query:
        const QUERY_OBJECT_POST             = 'post';
        const QUERY_OBJECT_TAX              = 'tax';
        const QUERY_OBJECT_AUTHOR           = 'author';
        const QUERY_OBJECT_USER             = 'user';
        const QUERY_OBJECT_LIBRARY_TEMPLATE = 'library_template';
        const QUERY_OBJECT_ATTACHMENT       = 'attachment';

        // Objects that are manipulated by js (not sent in AJAX):
        const QUERY_OBJECT_CPT_TAX = 'cpt_tax';
        const QUERY_OBJECT_JS      = 'js';

        public static $displayed_ids = [];

        private static bool $ignore_avoid_list = false;


        private static $supported_objects_for_query
            = [
                self::QUERY_OBJECT_POST,
                self::QUERY_OBJECT_TAX,
                self::QUERY_OBJECT_AUTHOR,
                self::QUERY_OBJECT_USER,
                self::QUERY_OBJECT_LIBRARY_TEMPLATE,
                self::QUERY_OBJECT_ATTACHMENT,
            ];

        public function __construct() {
            $this->includes();
            add_action( 'elementor/controls/register', [ $this, 'register_controls' ] );
            add_action( 'elementor/ajax/register_actions', [ $this, 'register_ajax_actions' ] );
        }

        public function includes() {
            require get_theme_file_path( 'inc/elementor/query-control/controls/query.php' );
            require get_theme_file_path( 'inc/elementor/query-control/controls/class-product-control.php' );
            require get_theme_file_path( 'inc/elementor/query-control/controls/group-control-query.php' );
        }

        public function register_controls( Controls_Manager $controls_manager ) {
            $controls_manager->add_group_control( Westio_Group_Control_Query::get_type(), new Westio_Group_Control_Query() );
            $controls_manager->register( new Westio_Query() );
            $controls_manager->register( new Products_Control() );
        }

        public function register_ajax_actions( $ajax_manager ) {
            $ajax_manager->register_ajax_action( 'westio_query_control_value_titles', [
                $this,
                'ajax_posts_control_value_titles'
            ] );
            $ajax_manager->register_ajax_action( 'westio_panel_posts_control_filter_autocomplete', [
                $this,
                'ajax_posts_filter_autocomplete'
                //                'ajax_posts_control_filter_product'
            ] );
            /**
             * @deprecated 2.6.0 use new `autocomplete` format
             */
//            $ajax_manager->register_ajax_action( 'query_control_value_titles_deprecated', [
//                $this,
//                'ajax_posts_control_value_titles_deprecated'
//            ] );
//            $ajax_manager->register_ajax_action( 'pro_panel_posts_control_filter_autocomplete_deprecated', [
//                $this,
//                'ajax_posts_filter_autocomplete_deprecated'
//            ] );


            //themes
            $ajax_manager->register_ajax_action( 'query_control_value_product', [
                $this,
                'ajax_query_control_value_product'
            ] );

            $ajax_manager->register_ajax_action( 'panel_posts_control_filter_product', [
                $this,
                'ajax_posts_control_filter_product'
            ] );
        }

        public static function add_to_avoid_list( $ids ) {
            if ( ! self::$ignore_avoid_list ) {
                self::$displayed_ids = array_unique( array_merge( self::$displayed_ids, $ids ) );
            }
        }

        public function ajax_posts_control_filter_product( array $data ) {
            if ( empty( $data['q'] ) ) {
                throw new \Exception( 'Bad Request' );
            }

            $results = [];

            $query_params = [
                'post_type'      => 'product',
                's'              => $data['q'],
                'posts_per_page' => - 1,
            ];

            $query = new WP_Query( $query_params );

            foreach ( $query->posts as $post ) {

                $results[] = [
                    'id'   => $post->ID,
                    'text' => esc_html( $post->post_title ),
                ];
            }

            return [
                'results' => $results,
            ];
        }

        public function ajax_query_control_value_product( $request ) {
            $ids = (array) $request['id'];

            $results = [];
            $query   = new \WP_Query(
                [
                    'post_type'      => 'any',
                    'post__in'       => $ids,
                    'posts_per_page' => - 1,
                ]
            );

            foreach ( $query->posts as $post ) {
                $results[ $post->ID ] = esc_html( $post->post_title );
            }

            return $results;
        }

        /**
         * @param array $data
         *
         * @return array
         * @throws \Exception
         */

        public function ajax_posts_filter_autocomplete( array $data ) {
            $this->verify_user_access_for_editing( $data );

            $query_data = $this->autocomplete_query_data( $data );

            if ( is_wp_error( $query_data ) ) {
                /** @var \WP_Error $query_data */
                throw new \Exception( $query_data->get_error_code() . ':' . $query_data->get_error_message() );
            }
            $results                     = [];

            $display                     = $query_data['display'];
            $query_args                  = $query_data['query'];
            $query_args['no_found_rows'] = true;

            switch ( $query_data['object'] ) {
                case self::QUERY_OBJECT_TAX:
                    $by_field = ! empty( $query_data['by_field'] ) ? $query_data['by_field'] : 'term_taxonomy_id';
                    $terms    = get_terms( $query_args );
                    if ( is_wp_error( $terms ) ) {
                        break;
                    }
                    foreach ( $terms as $term ) {
                        if ( apply_filters( "elementor/query/get_autocomplete/tax/{$display}", true, $term, $data ) ) {
                            $results[] = [
                                'id'   => $term->{$by_field},
                                'text' => $this->get_term_name( $term, $display, $data ),
                            ];
                        }
                    }
                    break;
                case self::QUERY_OBJECT_ATTACHMENT:
                case self::QUERY_OBJECT_POST:
                    $query = new \WP_Query( $query_args );

                    foreach ( $query->posts as $post ) {
                        if ( ! Access_Control::user_can_edit( $post->ID ) ) {
                            continue;
                        }

                        if ( apply_filters( "elementor/query/get_autocomplete/custom/{$display}", true, $post, $data ) ) {
                            $text      = $this->format_post_for_display( $post, $display, $data );
                            $results[] = [
                                'id'   => $post->ID,
                                'text' => $text,
                            ];
                        }
                    }
                    break;
                case self::QUERY_OBJECT_LIBRARY_TEMPLATE:
                    $query = new \WP_Query( $query_args );

                    foreach ( $query->posts as $post ) {
                        if ( ! Access_Control::user_can_edit( $post->ID ) ) {
                            continue;
                        }

                        $document = \ElementorPro\Plugin::elementor()->documents->get( $post->ID );
                        if ( $document ) {
                            $text      = esc_html( $post->post_title ) . ' (' . $document->get_post_type_title() . ')';
                            $results[] = [
                                'id'   => $post->ID,
                                'text' => $text,
                            ];
                        }
                    }
                    break;
                case self::QUERY_OBJECT_USER:
                case self::QUERY_OBJECT_AUTHOR:
                    $user_query = new \WP_User_Query( $query_args );

                    foreach ( $user_query->get_results() as $user ) {
                        if ( apply_filters( "elementor/query/get_autocomplete/user/{$display}", true, $user, $data ) ) {
                            $results[] = [
                                'id'   => $user->ID,
                                'text' => $this->format_user_for_display( $user, $display, $data ),
                            ];
                        }
                    }
                    break;
                default:

                    $results = apply_filters( 'elementor/query/get_autocomplete/' . $query_data['filter_type'], $results, $data );
            }

            return [
                'results' => $results,
            ];
        }

        public function ajax_posts_control_value_titles( $request ) {
            $this->verify_user_access_for_editing( $request );

            $query_data = $this->get_titles_query_data( $request );
            if ( is_wp_error( $query_data ) ) {
                return [];
            }
            $display = $query_data['display'];
            $query_args = $query_data['query'];
            $query_args['no_found_rows'] = true;

            $results = [];
            switch ( $query_data['object'] ) {
                case self::QUERY_OBJECT_TAX:
                    $by_field = ! empty( $query_data['by_field'] ) ? $query_data['by_field'] : 'term_taxonomy_id';

                    // The term_id is not working in 2022-01-18, this is a hack to replace the term id with
                    // `include`, the code is a legacy code so the solution is minimal as possible.
                    if ( isset( $query_args['term_id'] ) ) {
                        $query_args['include'] = array_map( 'intval', $query_args['term_id'] );
                    }

                    $terms = get_terms( $query_args );

                    if ( is_wp_error( $terms ) ) {
                        break;
                    }
                    foreach ( $terms as $term ) {
                        if ( apply_filters( "elementor/query/get_value_titles/tax/{$display}", true, $term, $request ) ) {
                            $results[ $term->{$by_field} ] = $this->get_term_name( $term, $display, $request, 'get_value_titles' );
                        }
                    }
                    break;

                case self::QUERY_OBJECT_ATTACHMENT:
                case self::QUERY_OBJECT_POST:
                    $query = new \WP_Query( $query_args );

                    foreach ( $query->posts as $post ) {
                        if ( ! Access_Control::user_can_edit( $post->ID ) ) {
                            continue;
                        }

                        if ( apply_filters( "elementor/query/get_value_titles/custom/{$display}", true, $post, $request ) ) {
                            $results[ $post->ID ] = $this->format_post_for_display( $post, $display, $request, 'get_value_titles' );
                        }
                    }
                    break;
                case self::QUERY_OBJECT_LIBRARY_TEMPLATE:
                    $query = new \WP_Query( $query_args );

                    foreach ( $query->posts as $post ) {
                        if ( ! Access_Control::user_can_edit( $post->ID ) ) {
                            continue;
                        }

                        $document = Plugin::$instance->documents->get($post->ID );
                        if ( $document ) {
                            $results[ $post->ID ] = htmlentities( esc_html( $post->post_title ) ) . ' (' . $document->get_post_type_title() . ')';
                        }
                    }
                    break;
                case self::QUERY_OBJECT_AUTHOR:
                case self::QUERY_OBJECT_USER:
                    $user_query = new \WP_User_Query( $query_args );

                    foreach ( $user_query->get_results() as $user ) {
                        if ( apply_filters( "elementor/query/get_value_titles/user/{$display}", true, $user, $request ) ) {
                            $results[ $user->ID ] = $this->format_user_for_display( $user, $display, $request, 'get_value_titles' );
                        }
                    }
                    break;
                default:
                    $results = apply_filters( "elementor/query/get_value_titles/{$query_data['filter_type']}", $results, $request );
            }

            return $results;
        }

        private function get_titles_query_data( $data ) {

            if ( empty( $data['get_titles'] ) || empty( $data['id'] ) || empty( $data['get_titles']['object'] ) ) {
                return new \WP_Error( self::GET_TITLES_ERROR_CODE, 'Empty or incomplete data' );
            }

            $get_titles = $data['get_titles'];
            if ( empty( $get_titles['query'] ) ) {
                $get_titles['query'] = [];
            }

            if ( in_array( $get_titles['object'], self::$supported_objects_for_query, true ) ) {
                $method_name = 'get_titles_query_for_' . $get_titles['object'];
                $query       = $this->$method_name( $data );
                if ( is_wp_error( $query ) ) {
                    return $query;
                }
                $get_titles['query'] = $query;
            }

            if ( empty( $get_titles['display'] ) ) {
                $get_titles['display'] = 'minimal';
            }

            return $get_titles;
        }

        private function get_titles_query_for_post( $data ) {
            $query = $data['get_titles']['query'];
            if ( empty( $query['post_type'] ) ) {
                $query['post_type'] = 'any';
            }
            $query['posts_per_page'] = -1;
            $query['post__in'] = (array) $data['id'];

            return $query;
        }

        private function get_titles_query_for_attachment( $data ) {
            $query = $this->get_titles_query_for_post( $data );
            $query['post_type'] = 'attachment';
            $query['post_status'] = 'inherit';

            return $query;
        }

        private function get_titles_query_for_tax( $data ) {
            $by_field = empty( $data['get_titles']['by_field'] ) ? 'term_taxonomy_id' : $data['get_titles']['by_field'];
            return [
                $by_field => (array) $data['id'],
                'hide_empty' => false,
            ];
        }


        private function get_titles_query_for_library_template( $data ) {
            $query = $data['get_titles']['query'];

            $query['post_type'] = Source_Local::CPT;
            $query['orderby'] = 'meta_value';
            $query['order'] = 'ASC';

            if ( empty( $query['posts_per_page'] ) ) {
                $query['posts_per_page'] = -1;
            }

            return $query;
        }

        private function get_titles_query_for_author( $data ) {
            $query = $this->get_titles_query_for_user( $data );

            $query['has_published_posts'] = true;

            return $this->add_edit_capability_to_user_query( $query );
        }

        private function get_titles_query_for_user( $data ) {
            $query = $data['get_titles']['query'];
            if ( ! empty( $query ) ) {
                return $query;
            }
            $query = [
                'fields' => [
                    'ID',
                    'display_name',
                ],
                'include' => (array) $data['id'],
            ];
            if ( 'detailed' === $data['get_titles']['display'] && Access_Control::user_can_access_private_posts() ) {
                $query['fields'][] = 'user_email';
            }
            return $query;
        }
        /**
         * @param \WP_Post $post
         * @param string $display
         * @param array $data
         * @param string $filter_name
         *
         * @return mixed|string|void
         */
        private function format_post_for_display( $post, $display, $data, $filter_name = 'get_autocomplete' ) {
            $post_type_obj = get_post_type_object( $post->post_type );
            switch ( $display ) {
                case 'minimal':
                    $text = ( $post_type_obj->hierarchical ) ? $this->get_post_name_with_parents( $post ) : $post->post_title;
                    break;
                case 'detailed':
                    $text = $post_type_obj->labels->name . ': ' . ( $post_type_obj->hierarchical ) ? $this->get_post_name_with_parents( $post ) : $post->post_title;
                    break;
                default:
                    $text = apply_filters( "elementor/query/{$filter_name}/display/{$display}", $post->post_title, $post->ID, $data );
                    break;
            }

            return esc_html( $text );
        }

        /**
         * get post name with parents
         *
         * @param \WP_Post $post
         * @param int $max
         *
         * @return string
         */
        private function get_post_name_with_parents( $post, $max = 3 ) {
            if ( 0 === $post->post_parent ) {
                return $post->post_title;
            }
            $separator = is_rtl() ? ' < ' : ' > ';
            $test_post = $post;
            $names     = [];
            while ( $test_post->post_parent > 0 ) {
                $test_post = get_post( $test_post->post_parent );
                if ( ! $test_post ) {
                    break;
                }
                $names[] = $test_post->post_title;
            }

            $names = array_reverse( $names );
            if ( count( $names ) < ( $max ) ) {
                return implode( $separator, $names ) . $separator . $post->post_title;
            }

            $name_string = '';
            for ( $i = 0; $i < ( $max - 1 ); $i ++ ) {
                $name_string .= $names[ $i ] . $separator;
            }

            return $name_string . '...' . $separator . $post->post_title;
        }

        /**
         * @param \WP_User $user
         * @param string $display
         * @param array $data
         * @param string $filter_name
         *
         * @return string
         */
        private function format_user_for_display( $user, $display, $data, $filter_name = 'get_autocomplete' ) {
            switch ( $display ) {
                case 'minimal':
                    $text = $user->display_name;
                    break;
                case 'detailed':
                    if ( Access_Control::user_can_access_private_posts() ) {
                        $text = sprintf( '%s (%s)', $user->display_name, $user->user_email );
                    } else {
                        $text = $user->display_name;
                    }
                    break;
                default:
                    $text = apply_filters( "elementor/query/{$filter_name}/display/{$display}", $user, $data );
                    break;
            }

            return $text;
        }

        private function get_term_name( $term, $display, $request, $filter_name = 'get_autocomplete' ) {
            global $wp_taxonomies;
            $term_name = $this->get_term_name_with_parents( $term );
            switch ( $display ) {
                case 'detailed':
                    $text = $wp_taxonomies[ $term->taxonomy ]->labels->name . ': ' . $term_name;
                    break;
                case 'minimal':
                    $text = $term_name;
                    break;
                default:
                    $text = apply_filters( "elementor/query/{$filter_name}/display/{$display}", $term_name, $request );
                    break;
            }

            return $text;
        }

        /**
         * get_term_name_with_parents
         *
         * @param \WP_Term $term
         * @param int $max
         *
         * @return string
         */
        private function get_term_name_with_parents( \WP_Term $term, $max = 3 ) {
            if ( 0 === $term->parent ) {
                return $term->name;
            }
            $separator = is_rtl() ? ' < ' : ' > ';
            $test_term = $term;
            $names     = [];
            while ( $test_term->parent > 0 ) {
                $test_term = get_term( $test_term->parent );
                if ( ! $test_term ) {
                    break;
                }
                $names[] = $test_term->name;
            }

            $names = array_reverse( $names );
            if ( count( $names ) < ( $max ) ) {
                return implode( $separator, $names ) . $separator . $term->name;
            }

            $name_string = '';
            for ( $i = 0; $i < ( $max - 1 ); $i ++ ) {
                $name_string .= $names[ $i ] . $separator;
            }

            return $name_string . '...' . $separator . $term->name;
        }

        /**
         * 'autocomplete' => [
         *    'object' => 'post|tax|user|library_template|attachment|js', // required
         *    'display' => 'minimal(default)|detailed|custom_filter_name',
         *    'by_field' => 'term_taxonomy_id(default)|term_id', // relevant only if `object` is tax|cpt_tax
         *    'query' => [
         *        'post_type' => 'any|post|page|custom-post-type', // can be an array for multiple post types.
         *                                                         // 'any' should not be used if 'object' is 'tax' or 'cpt_tax'.
         *         ...
         *    ],
         * ],
         *
         * 'object' (required):    the queried object.
         *      supported values:
         *      'post'              : will use WP_Query(), if query['post_type'] is empty or missing, will default to 'any'.
         *      'tax'               : will use get_terms().
         *                            When 'post_type' is provided, will first use get_object_taxonomies() to build 'taxonomy'
         *                            args then invoke get_terms().
         *                            When both 'taxonomy' and 'post_type' are provided, 'post_type' is ignored.
         *      'cpt_tax'           : Used in frontend only, will be replaced to 'tax' by js.
         *                            Will use get_object_taxonomies() to build 'taxonomy' args then use get_terms().
         *      'user'              : will use WP_User_Query() with the args defined in 'query'.
         *      'author'            : will use WP_User_Query() with pre-defined args.
         *      'library_template'  : will use WP_Query() with post_type = Source_Local::CPT.
         *      'attachment'        : will use WP_Query() with post_type = attachment.
         *      'js'                : Query data is populated by JavaScript.
         *                            By the time the data is sent to the server,
         *                            the 'object' value should be replaced with one of the other valid 'object' values and
         *                            the Query array populated accordingly.
         *      user_defined        : will invoke apply_filters() using the user_defined value as filter name,
         *                            `elementor/query/[get_value_titles|get_autocomplete]/{user_defined}`.
         *
         * 'display':   output format
         *      supported values:
         *      'minimal' (default) : name only
         *      'detailed'          : for Post & Taxonomies -> `[Taxonomy|Post-Type] : [parent] ... [parent] > name`
         *                            for Users & Authors -> `name [email]`
         *      user_defined        : will invoke apply_filters using the user_defined value as filter name,
         *                            `elementor/query/[get_value_titles|get_autocomplete]/display/{user_defined}`
         *
         * `by_field`:  value of 'id' field in taxonomy query. Relevant only if `object` is tax|cpt_tax
         *      supported values:
         *      'term_taxonomy_id'(default)
         *      'term_id'
         *
         * 'query': array of args to be passed "as-is" to the relevant query function (see 'object').
         *
         **
         *
         * @param array $data
         *
         * @return array | \WP_Error
         */
        private function autocomplete_query_data( $data ) {
            if ( empty( $data['autocomplete'] ) || empty( $data['q'] ) || empty( $data['autocomplete']['object'] ) ) {
                return new \WP_Error( self::AUTOCOMPLETE_ERROR_CODE, 'Empty or incomplete data' );
            }

            $autocomplete = $data['autocomplete'];

            if ( in_array( $autocomplete['object'], self::$supported_objects_for_query, true ) ) {
                $method_name = 'autocomplete_query_for_' . $autocomplete['object'];
                if ( empty( $autocomplete['display'] ) ) {
                    $autocomplete['display'] = 'minimal';
                    $data['autocomplete']    = $autocomplete;
                }
                $query = $this->$method_name( $data );
                if ( is_wp_error( $query ) ) {
                    return $query;
                }
                $autocomplete['query'] = $query;
            }

            return $autocomplete;
        }

        private function autocomplete_query_for_post( $data ) {
            if ( ! isset( $data['autocomplete']['query'] ) ) {
                return new \WP_Error( self::AUTOCOMPLETE_ERROR_CODE, 'Missing autocomplete[`query`] data' );
            }
            $query = $data['autocomplete']['query'];
            if ( empty( $query['post_type'] ) ) {
                $query['post_type'] = 'any';
            }
            $query['posts_per_page'] = - 1;
            $query['s']              = $data['q'];

            return $query;
        }

        private function autocomplete_query_for_library_template( $data ) {
            $query = $data['autocomplete']['query'];

            $query['post_type'] = Source_Local::CPT;
            $query['orderby']   = 'meta_value';
            $query['order']     = 'ASC';

            if ( empty( $query['posts_per_page'] ) ) {
                $query['posts_per_page'] = - 1;
            }
            $query['s'] = $data['q'];

            return $query;
        }

        private function autocomplete_query_for_attachment( $data ) {
            $query = $this->autocomplete_query_for_post( $data );
            if ( is_wp_error( $query ) ) {
                return $query;
            }
            $query['post_type']   = 'attachment';
            $query['post_status'] = 'inherit';

            return $query;
        }

        private function autocomplete_query_for_tax( $data ) {
            $query = $data['autocomplete']['query'];

            if ( empty( $query['taxonomy'] ) && ! empty( $query['post_type'] ) ) {
                $query['taxonomy'] = get_object_taxonomies( $query['post_type'] );
            }
            $query['search']     = $data['q'];
            $query['hide_empty'] = false;

            return $query;
        }

        private function autocomplete_query_for_author( $data ) {
            $query = $this->autocomplete_query_for_user( $data );
            if ( is_wp_error( $query ) ) {
                return $query;
            }

            return $this->add_edit_capability_to_user_query( $query );
        }

        private function autocomplete_query_for_user( $data ) {
            $query = $data['autocomplete']['query'];
            if ( ! empty( $query ) ) {
                return $query;
            }

            $query = [
                'fields'         => [
                    'ID',
                    'display_name',
                ],
                'search'         => '*' . $data['q'] . '*',
                'search_columns' => [
                    'user_login',
                    'user_nicename',
                ],
            ];
            if ( 'detailed' === $data['autocomplete']['display'] && Access_Control::user_can_access_private_posts() ) {
                $query['fields'][] = 'user_email';
            }

            return $query;
        }

        private function add_edit_capability_to_user_query( $query ) {
            // Capability queries were only introduced in WP 5.9.
            if ( version_compare( $GLOBALS['wp_version'], '5.9-alpha', '>=' ) ) {
                $query['capability'] = [ 'edit_posts' ];
            } else {
                $query['who'] = 'authors';
            }

            return $query;
        }

        /**
         * @throws \Exception
         */
        public static function verify_user_access_for_editing( array $data ): void {
            Access_Control::verify_user_editing_capability();

            if ( isset( $data['editor_post_id'] ) ) {
                Access_Control::verify_post_edit_access( (int) $data['editor_post_id'] );
            }
        }
    }

endif;

return new Westio_Query_Controls();

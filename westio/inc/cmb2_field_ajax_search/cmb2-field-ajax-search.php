<?php

/**
 * Class Westio_CMB2_Field_Ajax_Search.
 */

class Westio_CMB2_Field_Ajax_Search {
    /**
     * Initialize the plugin by hooking into CMB2
     */
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'setup_admin_scripts' ) );

        // Render
        add_action( 'cmb2_render_post_ajax_search', array( $this, 'render' ), 10, 5 );
        add_action( 'cmb2_render_user_ajax_search', array( $this, 'render' ), 10, 5 );
        add_action( 'cmb2_render_term_ajax_search', array( $this, 'render' ), 10, 5 );

        // Display
        add_filter( 'cmb2_pre_field_display_post_ajax_search', array( $this, 'display' ), 10, 3 );
        add_filter( 'cmb2_pre_field_display_user_ajax_search', array( $this, 'display' ), 10, 3 );
        add_filter( 'cmb2_pre_field_display_term_ajax_search', array( $this, 'display' ), 10, 3 );

        // Sanitize
        add_action( 'cmb2_sanitize_post_ajax_search', array( $this, 'sanitize' ), 10, 4 );
        add_action( 'cmb2_sanitize_user_ajax_search', array( $this, 'sanitize' ), 10, 4 );
        add_action( 'cmb2_sanitize_term_ajax_search', array( $this, 'sanitize' ), 10, 4 );

        // Ajax request
        add_action( 'wp_ajax_cmb_ajax_search_get_results', array( $this, 'get_results' ) );
    }

    public function convert_as_id_css( $name ) {
        return str_replace( '__', '_', str_replace( '[', '_', str_replace( ']', '_', $name ) ) );
    }

    /**
     * Render field
     */
    public function render( $field, $value, $object_id, $object_type, $field_type ) {
        $field_name = $this->convert_as_id_css($field->_name());
        $default_limit = 1;

        // Current filter is cmb2_render_{$object_to_search}_ajax_search ( post, user or term )
        $object_to_search = str_replace( 'cmb2_render_', '', str_replace( '_ajax_search', '', current_filter() ) );

        if( ! is_array( $value ) && strpos( $value, ', ' ) ) {
            $value = explode(', ', $value);
        }

        if( $field->args( 'multiple-item' ) == true ) {
            $default_limit = -1; // 0 or -1 means unlimited

            ?><ul id="<?php echo esc_attr($field_name); ?>_results" class="cmb-ajax-search-results cmb-<?php echo esc_attr($object_to_search); ?>-ajax-search-results"><?php
            if( isset( $value ) && ! empty( $value ) ){
                if( ! is_array( $value ) ) {
                    $value = array( $value );
                }

                foreach( $value as $val ) :
                    ?>
                    <li>
                        <?php if( $field->args( 'sortable' ) ) : ?><span class="hndl"></span><?php endif; ?>
                        <input type="hidden" name="<?php echo esc_attr($field->_name()); ?>[]" value="<?php echo esc_attr($val); ?>">
                        <a href="<?php echo esc_url($this->object_link( $field->_name(), $val, $object_to_search )); ?>" target="_blank" class="edit-link">
                            <?php printf('%s',$this->object_text( $field->_name(), $val, $object_to_search )); ?>
                        </a>
                        <a class="remover"><span class="dashicons dashicons-no"></span><span class="dashicons dashicons-dismiss"></span></a>
                    </li>
                <?php
                endforeach;
            }

            ?></ul><?php

            $input_value = '';
        } else {
            if( is_array( $value ) ) {
                $value = $value[0];
            }

            printf('%s',$field_type->input( array(
                'type' 	=> 'hidden',
                'name' 	=> $field->_name(),
                'value' => $value,
                'desc'	=> false
            ) ));

            $input_value = ( $value ? $this->object_text( $field_name, $value, $object_to_search ) : '' );
        }

        printf('%s',$field_type->input( array(
            'type' 				=> 'text',
            'name' 				=> '_' . $field->_name(),
            'id'				=> $field_name,
            'class'				=> 'cmb-ajax-search cmb-' . $object_to_search . '-ajax-search',
            'value' 			=> $input_value,
            'desc'				=> false,
            'data-multiple'		=> $field->args( 'multiple-item' ) ? $field->args( 'multiple-item' ) : '0',
            'data-limit'		=> $field->args( 'limit' ) ? $field->args( 'limit' ) : $default_limit,
            'data-sortable'		=> $field->args( 'sortable' ) ? $field->args( 'sortable' ) : '0',
            'data-object-type'	=> $object_to_search,
            'data-query-args'	=> $field->args( 'query_args' ) ? wp_specialchars_decode( json_encode( $field->args( 'query_args' ) ), ENT_QUOTES, 'UTF-8' ) : ''
        ) ));

        echo '<img src="'.admin_url( 'images/spinner.gif' ).'" class="cmb-ajax-search-spinner" />';

        $field_type->_desc( true, true );

    }

    /**
     * Display field
     */
    public function display( $pre_output, $field, $display ) {
        $object_type = str_replace( 'cmb2_pre_field_display_', '', str_replace( '_ajax_search', '', current_filter() ) );

        ob_start();

        $field->peform_param_callback( 'before_display_wrap' );

        printf( "<div class=\"cmb-column %s\" data-fieldtype=\"%s\">\n", $field->row_classes( 'display' ), $field->type() );

        $field->peform_param_callback( 'before_display' );

        if( is_array( $field->value ) ) : ?>
            <?php foreach( $field->value as $value ) : ?>
                <a href="<?php echo esc_url($this->object_link( $field->args['id'], $value, $object_type )); ?>" class="edit-link">
                    <?php printf('%s',$this->object_text( $field->args['id'], $value, $object_type )); ?>
                </a> <br>
            <?php endforeach; ?>
        <?php else : ?>
            <a href="<?php echo esc_url($this->object_link( $field->args['id'], $field->value, $object_type )); ?>" class="edit-link">
                <?php printf('%s',$this->object_text( $field->args['id'], $field->value, $object_type )); ?>
            </a>
        <?php endif;

        $field->peform_param_callback( 'after_display' );

        echo "\n</div>";

        $field->peform_param_callback( 'after_display_wrap' );

        $pre_output = ob_get_clean();

        return $pre_output;
    }

    /**
     * Optionally save the latitude/longitude values into two custom fields
     */
    public function sanitize( $override_value, $value, $object_id, $field_args ) {
        if ( !is_array( $value ) || !( array_key_exists('repeatable', $field_args ) && $field_args['repeatable'] == TRUE ) ) {
            return $override_value;
        }

        $new_values = array();
        foreach ( $value as $key => $val ) {
            $new_values[$key] = array_filter( array_map( 'sanitize_text_field', $val ) );
        }

        return array_filter( array_values( $new_values ) );
    }

    /**
     * Enqueue scripts and styles
     */
    public function setup_admin_scripts() {
        global $westio_version;
        wp_enqueue_script('jquery-autocomplete-ajax-search', get_template_directory_uri() . '/inc/cmb2_field_ajax_search/js/jquery.autocomplete.min.js', array('jquery'), $westio_version);
        wp_enqueue_script('cmb-ajax-search', get_template_directory_uri() . '/inc/cmb2_field_ajax_search/js/ajax-search.js', array( 'jquery', 'jquery-autocomplete-ajax-search', 'jquery-ui-sortable' ), $westio_version);

        wp_localize_script( 'cmb-ajax-search', 'cmb_ajax_search', array(
            'ajaxurl' 	=> admin_url( 'admin-ajax.php' ),
            'nonce'		=> wp_create_nonce( 'cmb_ajax_search_get_results' ),
            'options' 	=> apply_filters( 'cmb_field_ajax_search_autocomplete_options', array() )
        ) );

        wp_enqueue_script( 'cmb-ajax-search' );
        wp_enqueue_style('cmb-ajax-search', get_template_directory_uri() . '/inc/cmb2_field_ajax_search/css/ajax-search.css', array(), $westio_version);

    }

    /**
     * Ajax request : get results
     */
    public function get_results() {
        // Sanitize and verify nonce
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';

        if ( ! wp_verify_nonce( $nonce, 'cmb_ajax_search_get_results' ) ) {
            wp_send_json_error( array(
                'error' => __( 'Error: Unauthorized action', 'westio' )
            ), 403 );
        }

        // Sanitize and validate required fields
        $field_id     = isset($_POST['field_id']) ? sanitize_text_field($_POST['field_id']) : '';
        $object_type  = isset($_POST['object_type']) ? sanitize_text_field($_POST['object_type']) : '';
        $query_string = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';

        if ( empty($field_id) || empty($object_type) ) {
            wp_send_json_error( array(
                'error' => __( 'Error: Wrong request parameters', 'westio' )
            ), 400 );
        }

        // Decode and sanitize query args
        $query_args_raw = isset($_POST['query_args']) ? wp_unslash($_POST['query_args']) : '';
        $query_args_decoded = json_decode( wp_specialchars_decode( $query_args_raw ), true );
        $query_args = is_array($query_args_decoded) ? array_map('sanitize_text_field', $query_args_decoded) : array();

        $data = array();
        $results = array();

        switch ( $object_type ) {
            case 'post':
                $query_args['s'] = $query_string;
                $query = new WP_Query( $query_args );
                $results = $query->posts;
                break;

            case 'user':
                $query_args['search'] = '*' . esc_attr( $query_string ) . '*';
                $query = new WP_User_Query( $query_args );
                $results = $query->results;
                break;

            case 'term':
                $query_args['search'] = esc_attr( $query_string );
                $query = new WP_Term_Query( $query_args );
                $results = $query->terms;
                break;

            default:
                wp_send_json_error( array(
                    'error' => __( 'Error: Unsupported object type', 'westio' )
                ), 400 );
        }

        foreach ( $results as $result ) {
            $result_id = ( $object_type === 'term' ) ? intval( $result->term_id ) : intval( $result->ID );

            $data[] = array(
                'id'    => $result_id,
                'value' => sanitize_text_field( $this->object_text( $field_id, $result_id, $object_type ) ),
                'link'  => esc_url_raw( $this->object_link( $field_id, $result_id, $object_type ) ),
            );
        }

        wp_send_json( $data );
    }


    public function object_text( $field_id, $object_id, $object_type ) {
        $text = '';

        if( $object_type == 'post' ) {
            $text = get_the_title( $object_id );
        } else if( $object_type == 'user' ) {
            $text = get_the_author_meta('display_name', $object_id);
        } else if( $object_type == 'term' ) {
            $term = get_term( $object_id );

            $text = $term->name;
        }

        $text = apply_filters( "cmb_{$field_id}_ajax_search_result_text", $text, $object_id, $object_type );

        return $text;
    }

    public function object_link( $field_id, $object_id, $object_type ) {
        $link = '#';

        if( $object_type == 'post' ) {
            $link = get_edit_post_link( $object_id );
        } else if( $object_type == 'user' ) {
            $link = get_edit_user_link( $object_id );
        } else if( $object_type == 'term' ) {
            $link = get_edit_term_link( $object_id );
        }

        $link = apply_filters( "cmb_{$field_id}_ajax_search_result_link", $link, $object_id, $object_type );

        return $link;
    }

}

$cmb2_field_ajax_search = new Westio_CMB2_Field_Ajax_Search();
<?php


use Elementor\Control_Select2;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Westio_Query extends Control_Select2 {

    public function get_type() {
        return 'query';
    }
    public function enqueue() {
        wp_register_script('elementor-query-control', get_theme_file_uri('/inc/elementor/query-control/assets/custom-query-control.js'), ['jquery', 'elementor-editor', 'elementor-common'], WESTIO_VERSION, true);
        wp_enqueue_script('elementor-query-control');
    }
    /**
     * 'query' can be used for passing query args in the structure and format used by WP_Query.
     * @return array
     */
    protected function get_default_settings() {
        return array_merge(
            parent::get_default_settings(), [
                'query' => '',
            ]
        );
    }

    /**
     * Update control settings using mapping config
     *
     * @param $value
     * @param array $control_args
     * @param array $config
     *
     * @return mixed
     */
    public function on_import_update_settings( $value, array $control_args, array $config ) {
        switch ( $control_args['autocomplete']['object'] ) {
            case 'post':
            case 'library_template':
                return $this->replace_id_from_mapping( $value, $config['post_ids'] );
            case 'tax':
                return $this->replace_id_from_mapping( $value, $config['term_ids'] );
            default:
                return $value;
        }
    }

    /**
     * replace id from config
     *
     * @param mixed $value
     * @param array $mapping
     *
     * @return string
     */
    private function replace_id_from_mapping( $value, array $mapping ): string {
        return $mapping[ $value ] ?? $value;
    }

    /**
     * Render control content in editor (JS handles UI).
     */
    public function content_template() {
        ?>
        <div class="elementor-control-field">
            <label class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <select class="elementor-query-control" multiple></select>
            </div>
        </div>
        <?php
    }

}

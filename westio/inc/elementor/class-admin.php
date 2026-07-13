<?php

namespace Westio;
if (!defined('ABSPATH')) {
    exit;
}

class Westio_Elementor_Admin {
    /**
     * Constructor function to initialize hooks
     *
     * @return void
     * @author PavoThemes <pavothemes@gmail.com>
     * @since 1.0.0
     */
    public function __construct() {
        $this->elementor_style();
    }

    /**
     * Elementor Editor Style, Fonts and Scripts
     *
     * @return void
     * @author PavoThemes <pavothemes@gmail.com>
     * @since 1.0.0
     */
    public function elementor_style() {
        add_action('elementor/editor/before_enqueue_scripts', function () {

            echo '<style id="uicore-csss" >
            .elementor-element .icon .pavo-e-widget:after,
            #elementor-panel-category-westio-addons .icon i:after {
              height: 28px;
              width: 28px;
              margin-right: 10px;
              border-radius: 3px;
              background-color: #532df5;
              background-image: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' viewBox=\'0 0 16 16\' xml:space=\'preserve\'%3E%3Cpath d=\'M1.419 13.737C1.41167 13.5023 1.408 13.264 1.408 13.022C1.408 12.7873 1.408 12.5527 1.408 12.318C1.408 11.24 1.43 10.195 1.474 9.183C1.518 8.16367 1.56933 7.192 1.628 6.268C1.33467 6.34133 1.089 6.411 0.891 6.477L0.462 4.717C0.821333 4.607 1.199 4.51167 1.595 4.431C1.99833 4.343 2.39067 4.27333 2.772 4.222C3.16067 4.16333 3.51633 4.123 3.839 4.101C4.169 4.07167 4.44033 4.057 4.653 4.057C4.88033 4.057 5.159 4.07533 5.489 4.112C5.82633 4.14867 6.171 4.22567 6.523 4.343C6.88233 4.453 7.216 4.62167 7.524 4.849C7.832 5.07633 8.08133 5.38433 8.272 5.773C8.47 6.15433 8.569 6.63467 8.569 7.214C8.569 7.81533 8.437 8.31767 8.173 8.721C7.909 9.117 7.56067 9.436 7.128 9.678C6.69533 9.91267 6.21867 10.0813 5.698 10.184C5.17733 10.2867 4.664 10.338 4.158 10.338C3.83533 10.338 3.52733 10.3233 3.234 10.294C3.22667 10.646 3.223 10.9943 3.223 11.339C3.223 11.8083 3.22667 12.2447 3.234 12.648C3.24133 13.044 3.256 13.3923 3.278 13.693L1.419 13.737ZM4.598 5.861C4.40733 5.861 4.20933 5.86833 4.004 5.883C3.806 5.89767 3.608 5.916 3.41 5.938C3.37333 6.32667 3.344 6.74833 3.322 7.203C3.3 7.65767 3.28167 8.12333 3.267 8.6C3.53833 8.622 3.82067 8.633 4.114 8.633C5.874 8.633 6.754 8.11233 6.754 7.071C6.754 6.66033 6.578 6.356 6.226 6.158C5.874 5.96 5.33133 5.861 4.598 5.861ZM12.8729 13.869C12.4329 13.869 12.0846 13.7737 11.8279 13.583C11.5713 13.3997 11.3843 13.143 11.2669 12.813C11.1496 12.483 11.0726 12.1053 11.0359 11.68C11.0066 11.2547 10.9919 10.8073 10.9919 10.338C10.9919 9.854 11.0103 9.35167 11.0469 8.831C10.5556 8.897 10.0826 8.98133 9.62792 9.084L9.28692 7.357C9.89559 7.19567 10.5446 7.07833 11.2339 7.005C11.2853 6.631 11.3403 6.23867 11.3989 5.828C11.4576 5.41 11.5236 4.97 11.5969 4.508L13.4889 4.673C13.4009 5.05433 13.3239 5.43567 13.2579 5.817C13.1919 6.191 13.1333 6.554 13.0819 6.906C13.4926 6.906 13.8776 6.917 14.2369 6.939C14.6036 6.95367 14.9409 6.983 15.2489 7.027L15.0289 8.754C14.7723 8.72467 14.5046 8.70633 14.2259 8.699C13.9546 8.68433 13.6796 8.677 13.4009 8.677C13.2323 8.677 13.0636 8.68067 12.8949 8.688C12.8509 9.22333 12.8216 9.68167 12.8069 10.063C12.7996 10.4443 12.7959 10.7157 12.7959 10.877C12.7959 11.2803 12.8179 11.57 12.8619 11.746C12.9133 11.922 12.9939 12.01 13.1039 12.01C13.2286 12.01 13.3679 11.9697 13.5219 11.889C13.6759 11.801 13.8263 11.6837 13.9729 11.537C14.1269 11.3903 14.2553 11.2327 14.3579 11.064L15.2049 12.835C14.4789 13.5243 13.7016 13.869 12.8729 13.869Z\' fill=\'%23fff\'/%3E%3C/svg%3E");
              background-size: 16px;
              background-position: center;
              background-repeat: no-repeat;
            }
            .elementor-element .icon .pavo-e-widget:after,
            #elementor-panel-category-westio-addons .icon i:after {
				content: "";
			    position: absolute;
			    right: 5px;
			    top: 5px;
			    margin-right: 0;
			    width: 16px;
			    height: 16px;
			    background-size: 12px;
			    background-color: #656c7196;
				transition: background-color .3s ease-in-out;
            }
            .elementor-element:hover .icon .pavo-e-widget:after
			#elementor-panel-category-westio-addons .elementor-element:hover .icon .i:after {
				background-color: #532df5;
				transition: background-color .3s ease-in-out;
			}
            #elementor-panel-categories{
                display: flex;
                flex-direction: column;
            }
            #elementor-panel-category-basic,
            #elementor-panel-category-layout,
            #elementor-panel-category-favorites,
            #elementor-panel-category-westio-addons{
                order: -1;
            }
            </style>';
        });
    }
}

return new Westio_Elementor_Admin();
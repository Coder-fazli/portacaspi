(function ($) {
    'use strict';

    $(document).ready(function () {

        // Toggle mobile navigation
        $('.menu-mobile-nav-button').on('click', function (e) {
            e.preventDefault();
            $('html').toggleClass('mobile-nav-active');
        });

        // Close mobile navigation
        $('.westio-overlay, .mobile-nav-close').on('click', function (e) {
            e.preventDefault();
            $('html').removeClass('mobile-nav-active');
        });

        // Toggle info canvas
        $('.westio-info-button').on('click', function (e) {
            e.preventDefault();
            $('html').toggleClass('info-canvas-active');
        });

        // Close info canvas
        $('.westio-info-overlay, .westio-canvas-info-close').on('click', function (e) {
            e.preventDefault();
            $('html').removeClass('info-canvas-active');
        });

        // Mobile menu dropdown
        var $menuMobile = $('.handheld-navigation');

        if ($menuMobile.length) {

            $menuMobile.find('.menu-item-has-children').each(function () {

                var $item = $(this);
                var $link = $item.children('a');

                $link.addClass('menu-title');

                if (!$item.children('.dropdown-toggle').length) {
                    $link.after('<button class="dropdown-toggle"></button>');
                }

            });

            $menuMobile.on('click', '.dropdown-toggle', function (e) {

                e.preventDefault();

                var $button = $(this);
                var $submenu = $button.siblings('.sub-menu');

                $button.toggleClass('toggled-on');
                $submenu.stop(true, true).slideToggle(300);

            });

        }

        // Mobile nav tabs
        $('.mobile-nav-tabs li').on('click', function () {

            var $this = $(this);

            if ($this.hasClass('active')) return;

            var menuName = $this.data('menu');

            $this.addClass('active').siblings().removeClass('active');

            $('.mobile-menu-tab').removeClass('active');
            $('.mobile-' + menuName + '-menu').addClass('active');

        });

    });

})(jQuery);
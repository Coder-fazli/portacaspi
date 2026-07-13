(function ($) {
    "use strict";

    $(document).ready(function () {

        // Handle full-width mega menu (stretch across the full body)
        $('.main-navigation .has-mega-menu.has-stretchwidth').each(function () {
            let $body = $('body'),
                itemLeft = $(this).offset().left,
                bodyLeft = $body.offset().left;

            // Stretch mega menu to full body width and align it properly
            $('.mega-stretchwidth', this).css({
                left: -itemLeft + bodyLeft,
                width: $body.width()
            });
        });

        // Handle container-width mega menu (match width with container)
        $('.main-navigation .has-mega-menu.has-containerwidth').each(function () {
            let $container = $(this).closest('.container, .elementor-container, .col-full, .header-container'),
                containerLeft = $container.offset().left + parseInt($container.css('padding-left'), 10),
                itemLeft = $(this).offset().left;

            // Align mega menu with container and set its width
            $('.mega-containerwidth', this).css({
                left: containerLeft - itemLeft,
                width: $container.width()
            });
        });

        // Handle custom width mega menu
        $('.main-navigation .has-mega-menu').has('ul.custom-subwidth').each(function () {
            let paddingLeft = parseFloat($(this).children('a').css('padding-left')),
                itemOffsetLeft = $(this).offset().left + paddingLeft,
                menuWidth = parseInt($(this).children('.custom-subwidth').css('width'), 10),
                bodyWidth = $('body').width();

            let overflow = itemOffsetLeft + menuWidth - bodyWidth;

            // Prevent the mega menu from overflowing to the right
            if (overflow >= 0) {
                $('.mega-menu.custom-subwidth', this).css({
                    left: -overflow + paddingLeft
                });
            } else {
                $('.mega-menu.custom-subwidth', this).css({
                    left: paddingLeft
                });
            }
        });

    });

})(jQuery);

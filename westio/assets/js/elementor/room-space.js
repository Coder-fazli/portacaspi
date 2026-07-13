(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/westio-room-space.default', ($element) => {
            let addHandler = $('.westio-swiper-wrapper', $element);

            $('.roomspace-tab').on('click', function () {
                const index = $(this).data('room-index');

                // Tab active
                $(this).addClass('active').siblings().removeClass('active');

                // Contents active
                $('.roomspace-content').removeClass('active');
                $('.roomspace-content[data-room-index="' + index + '"]').addClass('active');

                // Image active
                $('.roomspace-image').removeClass('active');
                $('.roomspace-image[data-room-index="' + index + '"]').addClass('active');
            });
        });
    });
})(jQuery);
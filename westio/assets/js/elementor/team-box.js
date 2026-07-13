(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/westio-team-box.default', ($element) => {
            let addHandler = $('.swiper', $element);
            if (addHandler.length > 0) {
                elementorFrontend.elementsHandler.addHandler(westioSwiperBase, {
                    $element,
                });
            }
        });
    });
})(jQuery);

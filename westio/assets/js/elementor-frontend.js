'use strict';

(function ($) {

    function addSwiperPaginationWrapper($scope) {
        setTimeout(function () {
            $scope.find('.swiper-pagination').each(function () {
                if (!$(this).children('.swiper-pagination-wrapper').length) {
                    $(this).wrapInner('<div class="swiper-pagination-wrapper"></div>');
                }
            });
        }, 300);
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/global', addSwiperPaginationWrapper);
    });

})(jQuery);
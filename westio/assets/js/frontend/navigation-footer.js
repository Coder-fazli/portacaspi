(function ($) {
    'use strict';
    $(function () {

        const $footerNav = $('#navigation-footer');
        const $footer = $('footer');
        const $slider = $('#slider');
        const $header = $('#header');

        if (!$footerNav.length || !$footer.length) return;

        const toggleFooterNav = function () {
            const scrollPos = $(window).scrollTop();
            const windowHeight = $(window).height();
            const footerTop = $footer.offset().top;

            let shouldHide = true;

            if ($slider.length) {
                const sliderTop = $slider.offset().top;
                const sliderHeight = $slider.outerHeight();
                const sliderBottom = sliderTop + sliderHeight;

                const inMainZone =
                    scrollPos + windowHeight > sliderBottom + 100 &&
                    scrollPos + windowHeight < footerTop + 100;

                shouldHide = !inMainZone;

            } else if ($header.length) {
                const headerHeight = $header.outerHeight();
                const headerBottom = $header.offset().top + headerHeight;
                const isHeaderVisible = scrollPos < headerBottom;

                const inMainZone = scrollPos + windowHeight < footerTop + 100;

                shouldHide = isHeaderVisible || !inMainZone;
            }

            $footerNav.toggleClass('invisible', shouldHide);
        };

        toggleFooterNav();
        $(window).on('scroll resize', toggleFooterNav);

    });
})(jQuery);

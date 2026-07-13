(function ($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction('frontend/element_ready/westio-landing-scroll.default', function ($element) {

            const $nav = $element.find('.landing-scroll-nav');
            const $items = $nav.find('.landing-scroll-nav__item');
            const sections = [];

            $items.each(function () {
                const targetSelector = $(this).data('target');
                const $target = $(targetSelector);
                if ($target.length) {
                    sections.push($target);
                }

                $(this).on('click', function (e) {
                    e.preventDefault();
                    if ($target.length) {
                        const adminBarOffset = $('body').hasClass('admin-bar') ? 32 : 0;
                        const scrollTo = $target.offset().top - adminBarOffset;

                        $('html, body').animate({
                            scrollTop: scrollTo
                        }, 1500);
                    }
                });
            });

            const onScroll = function () {
                let currentId = null;
                const scrollPos = $(window).scrollTop();
                const windowHeight = $(window).height();

                sections.forEach(function ($section) {
                    const sectionTop = $section.offset().top;
                    const sectionBottom = sectionTop + $section.outerHeight();

                    if (scrollPos + windowHeight * 0.9 >= sectionTop && scrollPos < sectionBottom - windowHeight * 0.9) {
                        currentId = $section.attr('id');
                    }
                });

                $items.removeClass('active');
                if (currentId) {
                    $items.each(function () {
                        if ($(this).data('target') === '#' + currentId) {
                            $(this).addClass('active');
                        }
                    });
                }
            };

            onScroll();
            $(window).on('scroll', onScroll);
        });
    });
})(jQuery);

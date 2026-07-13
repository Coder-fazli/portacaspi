(function ($) {
    "use strict";
    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/westio-neighborhood.default", function ($element) {
            const $wrapper = $element.find(".neighborhood-wrapper");
            const $items = $wrapper.find(".elementor-neighborhood-item");
            const isMobile = window.matchMedia("(max-width: 1024px)").matches;

            if (!$items.length) return;

            if ($wrapper.hasClass("neighborhood-style-1")) {
                const $images = $wrapper.find(".neighborhood-main-img");
                if (!$images.length) return;

                $images.removeClass("active").eq(0).addClass("active");
                $items.removeClass("active").eq(0).addClass("active");

                const activateItem = function () {
                    const index = $(this).index();

                    $items.removeClass("active");
                    $(this).addClass("active");

                    $images.removeClass("active");
                    $images.eq(index).addClass("active");
                };

                if (isMobile) {
                    $items.on("click", activateItem);
                } else {
                    $items.on("mouseenter", activateItem);
                }
            }

            if ($wrapper.hasClass("neighborhood-style-2")) {
                $items.removeClass("active").eq(0).addClass("active");

                const activateItem = function () {
                    const index = $(this).index();
                    $items.removeClass("active");
                    $(this).addClass("active");
                };

                if (isMobile) {
                    $items.on("click", activateItem);
                } else {
                    $items.on("mouseenter", activateItem);
                }
            }
        });
    });
})(jQuery);

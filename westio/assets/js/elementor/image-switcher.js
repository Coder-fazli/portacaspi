(function ($) {
    "use strict";

    function initWestioImageSwitcher($element) {
        let addHandler = $(".swiper", $element);
        if (addHandler.length > 0) {
            elementorFrontend.elementsHandler.addHandler(westioSwiperBase, { $element });
        }

        const items = $(".elementor-image-switcher-item", $element);
        const images = $(".image-switcher-image-list .image-switcher-img", $element);
        const imageList = $(".image-switcher-image-list", $element);

        const originalItems = items.filter(function () {
            return !$(this).hasClass("swiper-slide-duplicate") && !$(this).hasClass("cloned");
        });

        originalItems.each(function (i) {
            $(this).attr("data-index", i);
        });

        items.each(function () {
            let originalIndex = $(this).attr("data-index");
            if (originalIndex === undefined) {
                let matchingOriginal = originalItems.eq($(this).index() % originalItems.length);
                originalIndex = matchingOriginal.attr("data-index");
                $(this).attr("data-index", originalIndex);
            }
        });

        items.each(function () {
            const $title = $(this).find(".image-switcher-title");
            const $caption = $(this).find(".image-switcher-caption");
            if ($caption.length && $title.length) {
                const ch = $caption[0].getBoundingClientRect().height;
                const th = $title[0].getBoundingClientRect().height;
                const start = ch - th;
                $title.css({
                    transition: "transform 0.6s ease-in-out",
                    transform: `translateY(${start}px)`
                });
            }
        });

        let firstItem = originalItems.eq(0);
        let firstImg = images.eq(0);
        if (firstItem.length && firstImg.length) {
            firstItem.addClass("active");
            firstImg.addClass("show").show();

            const $firstTitle = firstItem.find(".image-switcher-title");
            if ($firstTitle.length) {
                $firstTitle.css("transform", "translateY(0)");
            }
        }

        items.off("mouseenter").on("mouseenter", function () {
            if (imageList.hasClass("running")) return;

            const $item = $(this);
            const index = parseInt($item.attr("data-index"), 10);
            if (isNaN(index) || index >= images.length || index < 0) return;

            const curImg = images.filter(".show");
            const nextImg = images.eq(index);
            if (nextImg.hasClass("show")) return;

            imageList.addClass("running");

            items.removeClass("active");
            $item.addClass("active");

            items.each(function () {
                const $t = $(this).find(".image-switcher-title");
                const $cap = $(this).find(".image-switcher-caption");
                if ($t.length && $cap.length) {
                    const ch = $cap[0].getBoundingClientRect().height;
                    const th = $t[0].getBoundingClientRect().height;
                    const start = ch - th;

                    if ($(this).is($item)) {
                        $t.css("transform", "translateY(0)");
                    } else {
                        $t.css("transform", `translateY(${start}px)`);
                    }
                }
            });

            const isAfter = index > images.index(curImg);

            if (isAfter) {
                nextImg.addClass("showing");
            } else {
                curImg.addClass("showing");
            }

            nextImg.show();

            curImg.slideUp(500, () => {
                curImg.removeClass("show").hide();
                if (!isAfter) curImg.removeClass("showing");

                nextImg.removeClass("showing").addClass("show");
                imageList.removeClass("running");
            });
        });
    }

    // Khởi tạo
    $(window).on("elementor/frontend/init", () => {
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/westio-image-switcher.default",
            ($element) => initWestioImageSwitcher($element)
        );
    });

    $(document).on("westioCarouselInit", function (e, $element) {
        initWestioImageSwitcher($element);
    });
})(jQuery);

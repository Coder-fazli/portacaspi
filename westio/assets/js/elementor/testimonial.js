(function ($) {
    "use strict";

    $(window).on("elementor/frontend/init", () => {
        elementorFrontend.hooks.addAction("frontend/element_ready/westio-testimonials.default", ($element) => {
            const $swiperEl = $(".swiper", $element);

            if ($swiperEl.length > 0) {
                elementorFrontend.elementsHandler.addHandler(westioSwiperBase, { $element });
            }

            const animateRatings = ($scope) => {
                $scope.find(".rating-value").each(function () {
                    const $this = $(this);
                    const target = parseFloat($this.data("rating"));
                    if (isNaN(target)) return;

                    if ($this.hasClass("rating-animated")) return;

                    $this.addClass("rating-animated").text("0.0");

                    let current = 0;
                    const duration = 1200;
                    const stepTime = 20;
                    const increment = target / (duration / stepTime);

                    const counter = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(counter);
                        }
                        $this.text(current.toFixed(1));
                    }, stepTime);
                });
            };

            const waitForSwiper = setInterval(() => {
                const swiperInstance = $swiperEl[0]?.swiper;
                if (swiperInstance && swiperInstance.slides?.length) {
                    clearInterval(waitForSwiper);

                    animateRatings($swiperEl);

                    swiperInstance.on("slideChangeTransitionEnd", function () {
                        const $activeSlide = $($swiperEl.find(".swiper-slide-active"));
                        animateRatings($activeSlide);
                    });
                }
            }, 100);
        });
    });
})(jQuery);

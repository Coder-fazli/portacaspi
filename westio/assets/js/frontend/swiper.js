(function ($) {
    'use strict';

    function getSwiperSettings(settings) {
        const slidesToShow = +settings.column || 3;
        const isSingleSlide = slidesToShow === 1;
        const breakpoints = settings.breakpoints || {};
        const defaultSlidesToShowMap = {
            mobile: 1,
            tablet: isSingleSlide ? 1 : 2
        };

        const swiperOptions = {
            slidesPerView: slidesToShow,
            loop: settings.infinite === 'yes',
            speed: settings.speed,
            handleElementorBreakpoints: true,
            watchSlidesProgress: true,
            watchSlidesVisibility: true,
        };

        // Responsive breakpoints
        swiperOptions.breakpoints = {};
        let lastSlidesToShow = slidesToShow;
        Object.keys(breakpoints).reverse().forEach(key => {
            const bp = breakpoints[key];
            const slides = +bp.column || defaultSlidesToShowMap[bp.value] || lastSlidesToShow;
            swiperOptions.breakpoints[bp.value] = {
                slidesPerView: slides,
                slidesPerGroup: slides
            };
            lastSlidesToShow = slides;
        });

        // Autoplay
        if (settings.autoplay === 'yes') {
            swiperOptions.autoplay = {
                delay: settings.autoplay_speed,
                disableOnInteraction: settings.pause_on_interaction === 'yes'
            };
        }

        // Slide effect
        if (isSingleSlide && settings.effect) {
            swiperOptions.effect = settings.effect;
            if (settings.effect === 'fade') {
                swiperOptions.fadeEffect = { crossFade: true };
            }
        } else {
            swiperOptions.slidesPerGroup = +settings.slides_to_scroll || 1;
        }

        // Spacing
        if (settings.column_spacing) {
            swiperOptions.spaceBetween = settings.column_spacing;
        }

        // Navigation
        const navType = settings.navigation;
        if (navType === 'arrows' || navType === 'both') {
            swiperOptions.navigation = {
                prevEl: settings.prevEl,
                nextEl: settings.nextEl
            };
        }
        if (navType === 'dots' || navType === 'both') {
            swiperOptions.pagination = {
                el: settings.paginationel,
                type: 'bullets',
                clickable: true
            };
        }

        // Lazy load
        if (settings.lazyload === 'yes') {
            swiperOptions.lazy = {
                loadPrevNext: true,
                loadPrevNextAmount: 1
            };
        }

        return swiperOptions;
    }

    function initSwiper(selector) {
        const $el = $(selector);

        if (!$el.length) return;

        const settings = $el.data('settings');
        if (settings) {
            new Swiper(selector, getSwiperSettings(settings));
        }
    }

    $(function () {
        initSwiper('.upsells .westio-swiper');
        initSwiper('.related .westio-swiper');
        initSwiper('.cross-sells .westio-swiper');
        initSwiper('.post-related-wrapper .westio-swiper');
    });

})(jQuery);

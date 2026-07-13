(function ($) {
    'use strict';

    let lenis = null;
    let rafId = null;

    const startLenis = () => {
        if (lenis) return;
        lenis = new Lenis({
            duration: 1.5,
            easing: t => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            direction: 'vertical',
            gestureDirection: 'vertical',
            smooth: true,
            mouseMultiplier: 1,
            smoothTouch: false,
            touchMultiplier: 2,
            infinite: false,
        });

        const raf = (time) => {
            lenis.raf(time);
            rafId = requestAnimationFrame(raf);
        };
        rafId = requestAnimationFrame(raf);
        $('html').css('scroll-behavior', 'initial');
    };

    const stopLenis = () => {
        if (!lenis) return;
        cancelAnimationFrame(rafId);
        lenis.destroy();
        lenis = null;
        $('html').css('scroll-behavior', 'smooth');
    };

    const updateLenis = () => {
        if ($(window).width() <= 992 ||
            $('html').is('.off-canvas-active, .wihelp-popup-open') ||
            $('body').find('.mfp-ready').length > 0 ||
            ($('body').hasClass('shop_filter_dropdown') && $('.shop_filter_dropdown .active-filter-toggle').length)
        ) {
            stopLenis();
        } else {
            startLenis();
        }
    };

    $(function () {
        updateLenis();

        const observer = new MutationObserver(() => {
            clearTimeout(observer._timeout);
            observer._timeout = setTimeout(updateLenis, 10);
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    });

    $(window).on('resize', updateLenis);

})(jQuery);

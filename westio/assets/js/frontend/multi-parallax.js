(function ($) {
    'use strict';

    // Parallax effect plugin using TweenLite
    $.fn.jsparallax = function (resistance, mouse) {
        const $el = $(this);
        TweenLite.to($el, 0.2, {
            x: -((mouse.clientX - window.innerWidth / 2) / resistance),
            y: -((mouse.clientY - window.innerHeight / 2) / resistance)
        });
    };

    // Reposition parallax layers inside corresponding elements
    $('.parallax-layer').each(function () {
        const $this = $(this);
        const elementId = $this.data('element');
        $('.elementor-repeater-element-' + elementId).prependTo('.elementor-element-' + elementId);
    });

    // Mousemove event to apply parallax on elements with data-parallax="true"
    $('.westio-enable-parallax-yes').on('mousemove', function (e) {
        $(this).find('.parallax-layer[data-parallax="true"]').each(function () {
            const $layer = $(this);
            const rate = $layer.data('rate');
            $layer.jsparallax(rate, e);
        });
    });

})(jQuery);

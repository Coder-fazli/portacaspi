(function () {
    function initGallery(wrap) {
        if (!wrap || wrap.dataset.gmInit) {
            return;
        }
        wrap.dataset.gmInit = '1';

        var gallery = wrap.querySelector('.gm-gallery');
        var items = [].slice.call(gallery.querySelectorAll('.gm-item'));
        var perLoad = parseInt(gallery.getAttribute('data-per-load'), 10) || 12;
        var btn = wrap.querySelector('.gm-load-more-btn');
        var done = wrap.querySelector('.gm-load-more-done');
        var shown = 0;

        function reveal() {
            var next = Math.min(shown + perLoad, items.length);
            for (var i = shown; i < next; i++) {
                items[i].classList.add('gm-visible');
            }
            shown = next;
            if (shown >= items.length) {
                if (btn) {
                    btn.hidden = true;
                }
                if (done) {
                    done.hidden = false;
                }
            }
        }

        reveal();

        if (btn) {
            btn.addEventListener('click', reveal);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.gm-gallery-wrap').forEach(initGallery);
    });

    if (window.elementorFrontend) {
        window.elementorFrontend.hooks.addAction('frontend/element_ready/westio-child-gallery-masonry.default', function ($scope) {
            initGallery($scope[0].querySelector('.gm-gallery-wrap'));
        });
    }
})();

(function () {
    var DRAG_THRESHOLD = 6;

    function initLightbox() {
        var lightbox = document.querySelector('.gm-lightbox');
        if (!lightbox || lightbox.dataset.gmInit) {
            return lightbox;
        }
        lightbox.dataset.gmInit = '1';

        function close() {
            lightbox.classList.remove('is-open');
            document.body.classList.remove('gm-lock-scroll');
        }

        lightbox.querySelector('.gm-lightbox-close').addEventListener('click', close);
        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox) {
                close();
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                close();
            }
        });

        return lightbox;
    }

    function openLightbox(lightbox, item) {
        if (!lightbox) {
            return;
        }
        lightbox.querySelector('.gm-lightbox-img').src = item.getAttribute('data-full') || '';
        lightbox.querySelector('.gm-lightbox-title').textContent = item.getAttribute('data-title') || '';
        lightbox.querySelector('.gm-lightbox-desc').textContent = item.getAttribute('data-desc') || '';
        lightbox.classList.add('is-open');
        document.body.classList.add('gm-lock-scroll');
    }

    function initGallery(wrap, lightbox) {
        if (!wrap || wrap.dataset.gmInit) {
            return;
        }
        wrap.dataset.gmInit = '1';

        var track = wrap.querySelector('.gm-track');
        if (!track) {
            return;
        }

        // Drag-to-scroll for desktop mouse users — touch/trackpad already
        // scroll this natively via the track's own overflow-x.
        var isDown = false;
        var startX = 0;
        var startScroll = 0;
        var moved = 0;

        track.addEventListener('mousedown', function (e) {
            isDown = true;
            moved = 0;
            startX = e.pageX;
            startScroll = track.scrollLeft;
            track.classList.add('gm-dragging');
        });

        window.addEventListener('mousemove', function (e) {
            if (!isDown) {
                return;
            }
            var dx = e.pageX - startX;
            moved = Math.max(moved, Math.abs(dx));
            track.scrollLeft = startScroll - dx;
        });

        function endDrag() {
            isDown = false;
            track.classList.remove('gm-dragging');
        }
        window.addEventListener('mouseup', endDrag);
        window.addEventListener('mouseleave', endDrag);

        wrap.querySelectorAll('.gm-item[data-full]').forEach(function (item) {
            item.addEventListener('click', function () {
                // A real drag shouldn't also trigger the lightbox.
                if (moved > DRAG_THRESHOLD) {
                    return;
                }
                openLightbox(lightbox, item);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        var lightbox = initLightbox();
        document.querySelectorAll('.gm-wrap').forEach(function (wrap) {
            initGallery(wrap, lightbox);
        });
    });

    if (window.elementorFrontend) {
        window.elementorFrontend.hooks.addAction('frontend/element_ready/westio-child-gallery-masonry.default', function ($scope) {
            var lightbox = initLightbox();
            initGallery($scope[0].querySelector('.gm-wrap'), lightbox);
        });
    }
})();

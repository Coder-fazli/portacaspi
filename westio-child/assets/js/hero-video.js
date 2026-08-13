(function () {
    var MOBILE_BREAKPOINT = 767;

    function isMobile() {
        return window.innerWidth <= MOBILE_BREAKPOINT;
    }

    function prefersReducedMotion() {
        return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    function initHero(root) {
        if (!root || root.dataset.hvInit) {
            return;
        }
        root.dataset.hvInit = '1';

        var video = root.querySelector('.hv-video');
        if (!video) {
            return;
        }

        var playOnMobile = root.getAttribute('data-play-mobile') === '1';
        var videoUrl = root.getAttribute('data-video');

        function allowedToPlay() {
            if (prefersReducedMotion()) {
                return false;
            }
            return !isMobile() || playOnMobile;
        }

        function startLoading() {
            if (video.dataset.hvLoaded) {
                return;
            }
            video.dataset.hvLoaded = '1';
            video.src = videoUrl;
            video.load();
        }

        function play() {
            if (!allowedToPlay()) {
                return;
            }
            startLoading();
            var attempt = video.play();
            if (attempt && attempt.catch) {
                attempt.catch(function () {
                    // Autoplay blocked (rare with muted video) — poster stays visible, no error surfaced.
                });
            }
        }

        video.addEventListener('playing', function () {
            root.classList.add('hv-playing');
        });

        // Only fetch/decode video after the page has finished loading everything
        // else, so the hero's video never competes with fonts/CSS/critical JS
        // for bandwidth. Also gated by an IntersectionObserver so a hero
        // further down the page doesn't start downloading until it's in view.
        var observer = ('IntersectionObserver' in window)
            ? new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        video.paused && allowedToPlay() && play();
                    } else if (!video.paused) {
                        video.pause();
                    }
                });
            }, { threshold: 0.1 })
            : null;

        function armWhenReady() {
            if (observer) {
                observer.observe(root);
            } else {
                play();
            }
        }

        if (document.readyState === 'complete') {
            armWhenReady();
        } else {
            window.addEventListener('load', armWhenReady);
        }

        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                video.pause();
            } else if (allowedToPlay() && root.getBoundingClientRect().top < window.innerHeight) {
                play();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.hv-hero').forEach(initHero);
    });

    if (window.elementorFrontend) {
        window.elementorFrontend.hooks.addAction('frontend/element_ready/westio-child-hero-video.default', function ($scope) {
            initHero($scope[0].querySelector('.hv-hero'));
        });
    }
})();

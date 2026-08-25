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

        var scrollCue = root.querySelector('.hv-scroll-cue');
        if (scrollCue) {
            scrollCue.addEventListener('click', function () {
                var y = root.getBoundingClientRect().bottom + window.scrollY;
                window.scrollTo({ top: y, behavior: 'smooth' });
            });
        }

        var video = root.querySelector('.hv-video');
        if (!video) {
            // Poster-only (or fully empty) hero — nothing left to wire up.
            return;
        }

        var playOnMobile = root.getAttribute('data-play-mobile') === '1';
        var mobileVideoUrl = root.getAttribute('data-video-mobile');
        var videoUrl = (isMobile() && mobileVideoUrl) ? mobileVideoUrl : root.getAttribute('data-video');

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

        // Reveal on 'canplay' rather than 'playing': 'playing' fires the
        // instant playback starts, even with almost nothing buffered. On a
        // slow connection that means the video appears and then visibly
        // catches up/stutters as more of the file streams in — waiting for
        // 'canplay' (browser judges it has enough buffered to proceed)
        // gives a clean poster-to-video swap instead.
        video.addEventListener('canplay', function () {
            root.classList.add('hv-playing');
        });

        // Gate loading on an IntersectionObserver rather than a fixed delay:
        // a hero is on screen immediately, so this fires right away instead
        // of waiting on window 'load' (which third-party scripts like GTM or
        // a chat widget can stall for several seconds). A hero further down
        // the page would still defer loading until it's actually scrolled to.
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        video.paused && allowedToPlay() && play();
                    } else if (!video.paused) {
                        video.pause();
                    }
                });
            }, { threshold: 0.1 }).observe(root);
        } else {
            play();
        }

        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                video.pause();
            } else if (allowedToPlay() && root.getBoundingClientRect().top < window.innerHeight) {
                play();
            }
        });
    }

    // Mobile hamburger repositioning lives in header.js now — it runs on
    // every page, not just pages using this widget.

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.hv-hero').forEach(initHero);
    });

    if (window.elementorFrontend && window.elementorFrontend.hooks) {
        window.elementorFrontend.hooks.addAction('frontend/element_ready/westio-child-hero-video.default', function ($scope) {
            initHero($scope[0].querySelector('.hv-hero'));
        });
    }
})();

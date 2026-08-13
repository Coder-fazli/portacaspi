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

        var scrollCue = root.querySelector('.hv-scroll-cue');
        if (scrollCue) {
            scrollCue.addEventListener('click', function () {
                var y = root.getBoundingClientRect().bottom + window.scrollY;
                window.scrollTo({ top: y, behavior: 'smooth' });
            });
        }

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

    // The mobile hamburger button lives in a different header branch
    // (.header-left) than the phone/language icons (.header-right's
    // .wc-header-actions), so plain CSS can't interleave them into one
    // order. Re-parent it into that same flex row instead — moving a node
    // preserves whatever click handlers the theme already attached to it.
    function reorderMobileHeader() {
        if (!isMobile()) {
            return;
        }
        var actions = document.querySelector('.wc-header-actions');
        var hamburger = document.querySelector('.menu-mobile-nav-button');
        if (!actions || !hamburger) {
            return;
        }
        var phone = actions.querySelector('.wc-header-phone');
        var langSwitcher = actions.querySelector('.wc-lang-switcher');
        if (phone) {
            actions.appendChild(phone);
        }
        if (langSwitcher) {
            actions.appendChild(langSwitcher);
        }
        actions.appendChild(hamburger);
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.hv-hero').forEach(initHero);
        reorderMobileHeader();
    });

    if (window.elementorFrontend) {
        window.elementorFrontend.hooks.addAction('frontend/element_ready/westio-child-hero-video.default', function ($scope) {
            initHero($scope[0].querySelector('.hv-hero'));
        });
    }
})();

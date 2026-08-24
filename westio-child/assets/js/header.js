(function () {
    var MOBILE_BREAKPOINT = 767;

    function isMobile() {
        return window.innerWidth <= MOBILE_BREAKPOINT;
    }

    // The mobile hamburger button lives in a different header branch
    // (.header-left) than the phone/language icons (.header-right's
    // .wc-header-actions), so plain CSS can't interleave them into one
    // order. Re-parent it into that same flex row instead — moving a node
    // preserves whatever click handlers the theme already attached to it.
    // Runs on every page (not just hero-video pages), matching the same
    // header layout everywhere regardless of language/template.
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

    document.addEventListener('DOMContentLoaded', reorderMobileHeader);
})();

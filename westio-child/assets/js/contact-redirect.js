(function () {
    // Contact Form 7 fires this standard DOM event (bubbles to document) on
    // every successful submission, on any page, any form — redirecting off
    // it means one script handles all three language forms without needing
    // to know their individual CF7 form IDs.
    var REDIRECTS = {
        az: '/success/',
        ru: '/ru/success-2/',
        en: '/en/success-3/'
    };

    document.addEventListener('wpcf7mailsent', function () {
        var lang = (document.documentElement.lang || 'az').slice(0, 2).toLowerCase();
        window.location.href = REDIRECTS[lang] || REDIRECTS.az;
    });
})();

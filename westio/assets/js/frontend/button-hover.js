(function ($) {
    "use strict";

    function splitButtonText($scope) {
        $('.elementor-button', $scope).each(function () {
            const $btnText = $(this).find('.elementor-button-text').first();

            if ($btnText.length && !$btnText.hasClass('split-done')) {

                // Viết hoa ký tự đầu mỗi từ
                let rawText = $btnText.text().trim();
                if (rawText.length > 0) {
                    let capitalized = rawText.replace(/\b\w/g, char => char.toUpperCase());
                    $btnText.text(capitalized);
                }

                // Tách chữ bằng SplitText
                let splitWords = new SplitText($btnText, {
                    type: "words",
                    wordsClass: "gsap_split_word"
                });

                splitWords.words.forEach(word => {
                    new SplitText(word, {
                        type: "chars",
                        charsClass: "gsap_split_letter"
                    });
                });

                $btnText.addClass('split-done');

                // Lấy toàn bộ ký tự sau khi split
                const allWords = $btnText.find('.gsap_split_word').toArray().map(wordEl => {
                    return $(wordEl).find('.gsap_split_letter').toArray();
                });

                allWords.flat().forEach(char => {
                    gsap.set(char, { y: 0, transform: "translate3d(0,0,0)" });
                });

                // Gắn event hover cho button
                const btnEl = this;
                btnEl.addEventListener("mouseenter", () => {
                    animateWords(allWords, -1.5);
                    animateScale(btnEl, 0.95);
                });
                btnEl.addEventListener("mouseleave", () => {
                    animateWords(allWords, 0);
                    animateScale(btnEl, 1);
                });
            }
        });
    }

    function animateWords(words, targetEm) {
        words.forEach((chars, wordIndex) => {
            let wordDelay = wordIndex * 100;

            chars.forEach((char, charIndex) => {
                let start = null;
                let from = parseFloat(char.dataset.y || "0");
                let to = targetEm;
                let duration = 400;
                let charDelay = charIndex * 20;

                function step(timestamp) {
                    if (!start) start = timestamp;
                    let elapsed = timestamp - start - wordDelay - charDelay;
                    if (elapsed < 0) {
                        requestAnimationFrame(step);
                        return;
                    }

                    let progress = Math.min(elapsed / duration, 1);
                    progress = 1 - Math.pow(1 - progress, 2); // easeOutQuad

                    let current = from + (to - from) * progress;
                    char.style.transform = `translate3d(0, ${current}em, 0)`;
                    char.dataset.y = current;

                    if (progress < 1) {
                        requestAnimationFrame(step);
                    }
                }
                requestAnimationFrame(step);
            });
        });
    }

    function animateScale(el, targetScale) {
        let start = null;
        let from = parseFloat(el.dataset.scale || "1");
        let to = targetScale;
        let duration = 300;

        function step(timestamp) {
            if (!start) start = timestamp;
            let elapsed = timestamp - start;
            let progress = Math.min(elapsed / duration, 1);
            progress = 1 - Math.pow(1 - progress, 2);

            let current = from + (to - from) * progress;
            el.style.transform = `translate3d(0,0,0) scale(${current}, ${current})`;
            el.dataset.scale = current;

            if (progress < 1) {
                requestAnimationFrame(step);
            }
        }
        requestAnimationFrame(step);
    }

    $(document).ready(function () {
        splitButtonText(document);
    });

    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/global", function ($scope) {
            splitButtonText($scope);
        });
    });

})(jQuery);

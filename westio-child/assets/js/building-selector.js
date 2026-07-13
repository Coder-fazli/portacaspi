(function () {
    function initSelector(root) {
        if (!root || root.dataset.wbInit) {
            return;
        }
        root.dataset.wbInit = '1';

        var pins  = root.querySelectorAll('.wb-pin');
        var cards = root.querySelectorAll('.wb-card');

        function closeAll() {
            pins.forEach(function (p) { p.classList.remove('active'); });
            cards.forEach(function (c) { c.classList.remove('active', 'wb-card-flip'); });
        }

        pins.forEach(function (pin) {
            pin.addEventListener('click', function (e) {
                e.stopPropagation();
                var i        = pin.getAttribute('data-i');
                var wasOpen  = pin.classList.contains('active');
                closeAll();

                if (wasOpen) {
                    return;
                }

                pin.classList.add('active');
                var card = root.querySelector('.wb-card[data-i="' + i + '"]');
                if (card) {
                    card.classList.add('active');
                    if (parseFloat(pin.style.left) > 55) {
                        card.classList.add('wb-card-flip');
                    }
                }
            });
        });

        document.addEventListener('click', function (e) {
            if (!root.contains(e.target)) {
                closeAll();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.wb-selector').forEach(initSelector);
    });

    if (window.elementorFrontend) {
        window.elementorFrontend.hooks.addAction('frontend/element_ready/westio-child-building-selector.default', function ($scope) {
            initSelector($scope[0].querySelector('.wb-selector'));
        });
    }
})();

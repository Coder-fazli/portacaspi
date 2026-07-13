(function () {
    function initSelector(root) {
        if (!root || root.dataset.wbInit) {
            return;
        }
        root.dataset.wbInit = '1';

        var pins  = root.querySelectorAll('.wb-pin');
        var cards = root.querySelectorAll('.wb-card');
        var svgShapes = root.querySelectorAll('.plan__svg__hoverable');

        function closeAll() {
            pins.forEach(function (p) { p.classList.remove('active'); });
            cards.forEach(function (c) { c.classList.remove('active', 'wb-card-flip'); });
            svgShapes.forEach(function (s) { s.classList.remove('active'); });
        }

        function activate(number) {
            var wasOpen = root.querySelector('.wb-pin[data-number="' + number + '"].active');
            closeAll();

            if (wasOpen) {
                return;
            }

            var pin  = root.querySelector('.wb-pin[data-number="' + number + '"]');
            var card = root.querySelector('.wb-card[data-number="' + number + '"]');
            var shape = root.querySelector('.plan__svg__hoverable[data-nr="' + number + '"]');

            if (pin) {
                pin.classList.add('active');
                if (card) {
                    card.classList.add('active');
                    if (parseFloat(pin.style.left) > 55) {
                        card.classList.add('wb-card-flip');
                    }
                }
            }
            if (shape) {
                shape.classList.add('active');
            }
        }

        pins.forEach(function (pin) {
            pin.addEventListener('click', function (e) {
                e.stopPropagation();
                activate(pin.getAttribute('data-number'));
            });
        });

        svgShapes.forEach(function (shape) {
            shape.addEventListener('click', function (e) {
                e.stopPropagation();
                activate(shape.getAttribute('data-nr'));
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

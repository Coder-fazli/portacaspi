(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/westio-button-popup.default', ($scope) => {
            var $button = $scope.find('.westio-button-popup a.button-popup');
            if ($('body').hasClass('elementor-editor-active')) {
                return;
            }

            if ($button.length > 0) {
                $button.magnificPopup({
                    type: 'inline',
                    removalDelay: 500,
                    closeBtnInside: true,
                    showCloseBtn: false,
                    mainClass: 'mfp-button-popup',
                    callbacks: {
                        beforeOpen: function () {
                            this.st.mainClass += ' '+ this.st.el.attr('data-effect');
                        },
                        open: function () {
                            $button.addClass('active');
                        },
                        afterClose: function () {
                            $button.removeClass('active');
                        }
                    },
                    midClick: true
                });
            }
        });
    });
})(jQuery);


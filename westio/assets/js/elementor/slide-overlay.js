(function ($) {
    "use strict";

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/westio-slide-overlay.default', ($scope) => {
            let $titles   = $scope.find('.elementor-slide-overlay-title');
            let $contents = $scope.find('.elementor-slide-overlay-content');

            $titles.on("mouseenter", function () {
                let id = $(this).data("trigger");

                $titles.removeClass("elementor-active");
                $contents.removeClass("elementor-active");

                $(this).addClass("elementor-active");
                $scope.find('[data-target="' + id + '"]').addClass("elementor-active");
            });
        });
    });

})(jQuery);``

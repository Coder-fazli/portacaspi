(function ($) {
    "use strict";

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/westio-work-process.default', ($scope) => {
            let $active = $scope.find('.elementor-process-wrapper');
            let $content = $scope.find('.elementor-process-item');
            $active.find('.elementor-process-item').first().addClass('active');
            $content.find('.active').show();
            var windowsize = $(window).width();
            if (windowsize > 567) {
                let firstId = $active.find('.elementor-process-item').first().attr('aria-controls');
                $content.find('#' + firstId).addClass('active');
                $active.find('.elementor-process-item').hover(function (e) {
                    e.preventDefault();
                    let id = $(this).attr('aria-controls');
                    $active.find('.elementor-process-item').removeClass('active');
                    $(this).addClass('active');
                    $content.find('#' + id).addClass('active');
                });
            } else {
                $active.find('.elementor-process-item').on('click', function (e) {
                    e.preventDefault();
                    let id = $(this).attr('aria-controls');
                    $active.find('.elementor-process-item').removeClass('active');
                    $(this).addClass('active');
                    $contents.find('#' + id).addClass('active');
                });
            }
        });
    });

})(jQuery);




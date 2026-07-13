(function ($) {
    "use strict";

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/westio-image-gallery.default', ($scope) => {

            const settings = $scope.data('settings') || {};
            const gutter = settings.column_spacing?.size || 20;
            const $iso = $scope.find('.isotope-grid');

            if (!$iso.length) return;

            const $filters = $scope.find('.elementor-galerry__filters li');
            const $active = $filters.filter('.elementor-active');
            const initialFilter = $active.data('filter') === '.gallery_group_all' ? '*' : ($active.data('filter') || '*');

            $iso.imagesLoaded(function () {

                const isotopeOptions = {
                    itemSelector: '.grid__item',
                    filter: initialFilter,
                    transitionDuration: '0.6s',
                    hiddenStyle: { opacity: 0 },
                    visibleStyle: { opacity: 1 },
                    masonry: {
                        columnWidth: '.grid__item',
                        gutter: gutter,
                    }
                };

                const iso = $iso.isotope(isotopeOptions);

                $iso.imagesLoaded().progress(function () {
                    iso.isotope('layout');
                });

                $filters.on('click', function () {
                    const $this = $(this);
                    $this.addClass('elementor-active').siblings().removeClass('elementor-active');
                    const filter = $this.data('filter') === '.gallery_group_all' ? '*' : $this.data('filter');
                    iso.isotope({ filter });
                });
            });

        });
    });

})(jQuery);

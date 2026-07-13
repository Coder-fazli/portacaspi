(function ($) {
    'use strict';

    $(document).ready(function () {
        const $select = $('select[name="setup-theme"]');
        const $liProfile = $('li.profile');
        const $liCustom = $('li.custom_theme');
        const $liSetup = $('li.setup-theme');

        function toggleThemeOptions(value) {
            if (value === 'profile') {
                $liProfile.show();
                $liCustom.hide();
            } else {
                $liProfile.hide();
                $liCustom.show();
            }
        }

        $liSetup.hide(); // Always hide setup-theme item

        $select.each(function () {
            toggleThemeOptions($(this).val());
        });

        $select.on('change', function () {
            toggleThemeOptions($(this).val());
        });
    });

})(jQuery);

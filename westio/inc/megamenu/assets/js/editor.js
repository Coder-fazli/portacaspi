(function ($) {
    "use strict";

    // Listen for click on the "Back to Admin" button in Elementor panel footer
    $(document).on('click', '#elementor-panel-footer-back-to-admin', function () {
        const parentWindow = window.parent;

        // If modal exists in parent, update model state
        if (parentWindow && parentWindow.westio_menu_modal !== undefined) {
            parentWindow.westio_menu_modal.model.set('edit_submenu', false);
        }
    });

    // Remove the default Elementor panel footer template (if needed for override)
    $('#tmpl-elementor-panel-footer-content').remove();

})(jQuery);

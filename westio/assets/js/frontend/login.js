(function ($) {
    'use strict';

    $('body').on('click', '.westio-login-form-ajax button[type="submit"]', function (event) {
        event.preventDefault(); // Prevent default form submission

        const $button = $(this);
        const $form = $button.closest('form');

        if (!$form.length) return;

        $.ajax({
            type: 'POST',
            url: westioAjax.ajaxurl,
            data: $form.serialize(),
            beforeSend: function () {
                $form.addClass('loading');
                $form.find('input, button').prop('disabled', true);
                $form.find('.result-error').remove(); // Remove previous errors
            },
            success: function (response) {
                if (response.status) {
                    location.reload(); // Reload on success
                } else {
                    const errorMsg = response.msg || 'Login failed. Please try again.';
                    $form.prepend(`<div class="result-error woocommerce-message woocommerce-error">${errorMsg}</div>`);
                }
            },
            error: function () {
                $form.prepend(`<div class="result-error woocommerce-message woocommerce-error">Server connection error. Please try again later.</div>`);
            },
            complete: function () {
                $form.find('input, button').prop('disabled', false);
                $form.removeClass('loading');
            }
        });
    });
})(jQuery);

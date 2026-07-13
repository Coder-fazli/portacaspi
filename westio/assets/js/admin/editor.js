(function ($, api) {
    $(window).on('load', function () {
        $('textarea.wp-editor-area').each(function () {
            const $textarea = $(this);
            const id = $textarea.attr('id');
            const $linkedInput = $('input[data-customize-setting-link="' + id + '"]');
            const editor = tinyMCE.get(id);
            let debounceTimer;
            let content;

            function updateInput(value) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function () {
                    $linkedInput.val(value).trigger('change');
                }, 500);
            }

            if (editor) {
                editor.on('change', function () {
                    editor.save();
                    updateInput(editor.getContent());
                });
            }

            $textarea.css('visibility', 'visible').on('keyup', function () {
                updateInput($textarea.val());
            });
        });
    });
})(jQuery, wp.customize);

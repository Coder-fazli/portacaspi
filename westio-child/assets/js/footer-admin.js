jQuery(function ($) {

    /* ---- Language tabs ---- */
    $('.wcf-tabs').on('click', '.nav-tab', function (e) {
        e.preventDefault();
        var lang = $(this).data('lang');
        $('.wcf-tabs .nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        $('.wcf-lang-panel').hide().filter('[data-lang="' + lang + '"]').show();
    });

    /* ---- Add link item ---- */
    $(document).on('click', '.wcf-add-link', function () {
        var lang = $(this).data('lang');
        var col  = $(this).data('col');
        var i    = Date.now();
        var tpl  = $('#wcf-link-item-tpl').html()
            .replace(/__LANG__/g, lang)
            .replace(/__COL__/g, col)
            .replace(/__I__/g, i);
        $('.wcf-items[data-lang="' + lang + '"][data-col="' + col + '"]').append(tpl);
    });

    /* ---- Add social ---- */
    $(document).on('click', '.wcf-add-social', function () {
        var lang = $(this).data('lang');
        var i    = Date.now();
        var tpl  = $('#wcf-social-item-tpl').html()
            .replace(/__LANG__/g, lang)
            .replace(/__I__/g, i);
        $('.wcf-socials[data-lang="' + lang + '"]').append(tpl);
    });

    /* ---- Remove row ---- */
    $(document).on('click', '.wcf-remove-row', function () {
        $(this).closest('.wcf-item').remove();
    });

    /* ---- Media picker (parallax background) ---- */
    var frame;
    $('.wcf-media-select').on('click', function (e) {
        e.preventDefault();
        var $wrap = $(this).closest('.wcf-media');
        if (frame) {
            frame.off('select');
        }
        frame = wp.media({
            title: 'Select background image',
            button: { text: 'Use this image' },
            multiple: false
        });
        frame.on('select', function () {
            var att = frame.state().get('selection').first().toJSON();
            $wrap.find('.wcf-media-input').val(att.url);
            $wrap.find('.wcf-media-preview').attr('src', att.url).show();
            $wrap.find('.wcf-media-remove').show();
        });
        frame.open();
    });

    $('.wcf-media-remove').on('click', function (e) {
        e.preventDefault();
        var $wrap = $(this).closest('.wcf-media');
        $wrap.find('.wcf-media-input').val('');
        $wrap.find('.wcf-media-preview').hide().attr('src', '');
        $(this).hide();
    });
});

(function ($) {
    'use strict';

    // Handle login dropdown on hover
    function loginDropdown() {
        $('.site-header-account').on('mouseenter', function () {
            // Move .account-wrap inside the .account-dropdown on hover
            $('.account-dropdown', this).append($('.account-wrap'));
        });
    }

    // Check if body has scrollbar and set CSS variable for scrollbar width
    function handleWindow() {
        var body = document.body;
        var scrollbarWidth = window.innerWidth - body.clientWidth;

        if (scrollbarWidth > 5) {
            body.classList.add('has-scrollbar');
            body.style.setProperty('--scroll-bar', scrollbarWidth + 'px');
        } else {
            body.classList.remove('has-scrollbar');
            body.style.removeProperty('--scroll-bar');
        }
    }

    // Set minimum height for content area based on viewport and header/footer heights
    function minHeight() {
        var $body = $('body'),
            bodyHeight = $(window).outerHeight(),
            headerHeight = $('header.header-1').outerHeight() || 0,
            footerHeight = $('footer.site-footer').outerHeight() || 0,
            $adminBar = $('#wpadminbar');

        if ($adminBar.length) {
            headerHeight += $adminBar.outerHeight();
        }

        if ($body.find('header.header-1').length) {
            $('.site-content').css({
                'min-height': bodyHeight - headerHeight - footerHeight - 90
            });
        }
    }

    // Adjust submenu position to avoid overflow off the right side of the screen
    function setPositionLvN($item) {
        var $sub = $item.children('.sub-menu'),
            offset = $item.offset(),
            width = $item.outerWidth(),
            screenWidth = $(window).width(),
            subWidth = $sub.outerWidth(),
            alignDelta = offset.left + width + subWidth - screenWidth;

        if (alignDelta > 0) {
            if ($item.parents('.menu-item-has-children').length) {
                $sub.css({ left: 'auto', right: '100%' });
            } else {
                $sub.css({ left: 'auto', right: '0' });
            }
        } else {
            $sub.css({ left: '', right: '' });
        }
    }

    // Initialize submenu hover to adjust submenu positions on mouse enter
    function initSubmenuHover() {
        $('.site-header .primary-navigation .menu-item-has-children').on('mouseenter', function () {
            setPositionLvN($(this));
        });
    }

    // Initialize sticky sidebar with proper offset for admin bar
    function makeStickyKit() {
        var topSticky = 20,
            $adminBar = $('#wpadminbar'),
            $secondary = $('#secondary');

        if ($adminBar.length) {
            topSticky += $adminBar.outerHeight();
        }

        if ($secondary.length) {
            if (window.innerWidth < 992) {
                $secondary.trigger('sticky_kit:detach');
            } else {
                $secondary.stick_in_parent({
                    offset_top: topSticky
                });
            }
        }
    }

    // Show/hide scroll-up button based on scroll position
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 200) {
            $('.scrollup').fadeIn().addClass('activate');
        } else {
            $('.scrollup').fadeOut().removeClass('activate');
        }
    });

    // Scroll to top when clicking scroll-up button
    $('.scrollup').on('click', function () {
        $('html, body').animate({ scrollTop: 0 }, 600);
        return false;
    });

    // Initialize everything
    $(function () {
        makeStickyKit();
        initSubmenuHover();
        minHeight();
        handleWindow();
        loginDropdown();
    });

    // Update on window resize (optional but recommended)
    $(window).on('resize', function () {
        minHeight();
        handleWindow();
        makeStickyKit();
    });

})(jQuery);

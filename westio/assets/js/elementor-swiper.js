'use strict';

class westioSwiperBase extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
                carousel: `.${elementorFrontend.config.swiperClass}`,
                slideContent: '.swiper-slide',
            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        const elements = {
            $swiperContainer: this.$element.find(selectors.carousel),
        };
        elements.$slides = elements.$swiperContainer.find(selectors.slideContent);
        return elements;
    }

    getSwiperSettings() {
        const elementSettings = this.getElementSettings(),
            slidesToShow = elementSettings.slides_to_show || ('vertical' === elementSettings.direction ? '1' : '3'),
            isSingleSlide = '1' === slidesToShow,
            elementorBreakpoints = elementorFrontend.config.responsive.activeBreakpoints,
            defaultSlidesToShowMap = {
                mobile: 1,
                tablet: isSingleSlide ? 1 : 2,
            };
        const swiperOptions = {
            slidesPerView: slidesToShow,
            loop: 'yes' === elementSettings.infinite,
            speed: elementSettings.speed,
            handleElementorBreakpoints: true,
            watchSlidesProgress: true,
            centeredSlides: this.elements.$swiperContainer.data('center'),
            loopedSlides: this.elements.$swiperContainer.data('count'),
        };

        if ('true' === this.elements.$swiperContainer.data('center')) {
            swiperOptions.centeredSlides = true;

        }

        swiperOptions.breakpoints = {};
        let lastBreakpointSlidesToShowValue = slidesToShow;
        let lastBreakpointSpaceBetweenValue = 30;
        if (elementSettings.spaceBetween) {
            swiperOptions.spaceBetween = elementSettings.spaceBetween.size;
            lastBreakpointSpaceBetweenValue = elementSettings.spaceBetween.size || 30;
        }

        Object.keys(elementorBreakpoints).reverse().forEach((breakpointName) => {
            // Tablet has a specific default `slides_to_show`.
            const defaultSlidesToShow = defaultSlidesToShowMap[breakpointName] ? defaultSlidesToShowMap[breakpointName] : lastBreakpointSlidesToShowValue;
            swiperOptions.breakpoints[elementorBreakpoints[breakpointName].value] = {
                slidesPerView: +elementSettings['slides_to_show_' + breakpointName] || defaultSlidesToShow,
                slidesPerGroup: +elementSettings['slides_to_scroll_' + breakpointName] || 1,
            };
            lastBreakpointSlidesToShowValue = +elementSettings['slides_to_show_' + breakpointName] || defaultSlidesToShow;
            if (typeof elementSettings['spaceBetween_' + breakpointName] !== 'undefined') {
                swiperOptions.breakpoints[elementorBreakpoints[breakpointName].value]['spaceBetween'] = +elementSettings['spaceBetween_' + breakpointName].size || lastBreakpointSpaceBetweenValue;
                lastBreakpointSpaceBetweenValue = +elementSettings['spaceBetween_' + breakpointName].size || 30;
            }
        });

        if ('yes' === elementSettings.autoplay && !(this.hasNesting() && elementorFrontend.isEditMode())) {
            swiperOptions.autoplay = {
                delay: elementSettings.autoplay_speed,
                disableOnInteraction: 'yes' === elementSettings.pause_on_interaction,
            };
        }

        if ('yes' === elementSettings.mousewheel) {
            swiperOptions.mousewheel = true;
        }

        if (undefined === elementSettings.allowTouchMove) {
            swiperOptions.allowTouchMove = false;
        }

        if ('yes' === elementSettings.autoheight) {
            swiperOptions.autoHeight = true;
        } else {
            swiperOptions.autoHeight = false;
        }

        if ('yes' === elementSettings.lazyload) {
            swiperOptions.lazy = true;
        }

        if (isSingleSlide) {
            const animationStyle = elementSettings.effect;
            switch (animationStyle) {
                case 'fade':
                    swiperOptions.effect = 'fade';
                    swiperOptions.fadeEffect = {crossFade: true};
                    break;
                case 'flip':
                    swiperOptions.effect = 'flip';
                    swiperOptions.flipEffect = {slideShadows: false};
                    break;
                case 'cube':
                    swiperOptions.effect = 'cube';
                    swiperOptions.cubeEffect = {slideShadows: false};
                    break;
                case 'creative':
                    swiperOptions.effect = 'creative';
                    swiperOptions.creativeEffect = {
                        prev: {
                            translate: [0, 0, -400],
                        },
                        next: {
                            translate: ['100%', 0, 0],
                        },
                    }
                    break;
                case 'cards':
                    swiperOptions.loop = false;
                    swiperOptions.rewind = elementSettings.infinite === 'yes';
                    swiperOptions.effect = 'cards';
                    swiperOptions.cardsEffect = {slideShadows: false};
                    break;
                case 'coverflow':
                    const slideCount = this.elements.$swiperContainer.find('.swiper-slide').length;
                    const initialSlide = slideCount % 2 === 0 ? (slideCount - 1) / 2 : Math.floor(slideCount / 2);
                    swiperOptions.initialSlide = initialSlide;
                    swiperOptions.effect = 'coverflow';
                    swiperOptions.coverflowEffect = {depth: 500, rotate: 20, slideShadows: true};
                    break;
                case 'marquee':
                    swiperOptions.loop = true;
                    swiperOptions.speed = Math.abs(elementSettings.marquee_speed - 10000) || 5000;
                    swiperOptions.allowTouchMove = false;
                    swiperOptions.direction = elementSettings.direction === 'vertical' ? 'vertical' : 'horizontal';
                    swiperOptions.autoHeight = elementSettings.direction === 'vertical';
                    swiperOptions.autoplay = {
                        delay: 0,
                        disableOnInteraction: false,
                        reverseDirection: Boolean(elementSettings.reverse),
                    };
                    break;
                default:
                    swiperOptions.effect = 'slide';
                    swiperOptions.watchSlidesProgress = true;
                    swiperOptions.speed = Math.abs(elementSettings.speed) || 2000;
                    break;
            }
        } else {
            swiperOptions.slidesPerGroup = +elementSettings.slides_to_scroll || 1;
        }

        const showArrows = 'arrows' === elementSettings.navigation || 'both' === elementSettings.navigation,
            showDots = 'dots' === elementSettings.navigation || 'both' === elementSettings.navigation || 'custom' === elementSettings.navigation;
        if (showArrows) {

            if ('yes' === elementSettings.custom_navigation) {
                swiperOptions.navigation = {
                    prevEl: '.' + elementSettings.custom_navigation_previous.replace(/^\./, ''),
                    nextEl: '.' + elementSettings.custom_navigation_next.replace(/^\./, ''),
                };
            } else {
                swiperOptions.navigation = {
                    prevEl: this.$element.find('.elementor-swiper-button-prev').get(0),
                    nextEl: this.$element.find('.elementor-swiper-button-next').get(0),
                };
            }
        }

        if (showDots) {


            swiperOptions.pagination = {
                el: this.$element.find('.swiper-pagination').get(0),
                type: elementSettings.style_dot,
                clickable: true,
            };
        }

        if (typeof elementSettings.enable_scrollbar !== 'undefined' && elementSettings.enable_scrollbar === 'yes') {
            swiperOptions.scrollbar = {
                el: this.$element.find('.swiper-scrollbar').get(0),
                hide: false,
                draggable: true,
            }
            // swiperOptions.loop = false;
        }

        if (this.hasNesting() && elementorFrontend.isEditMode()) {
            swiperOptions.loop = false;
        }

        if ('vertical' === elementSettings.direction) {
            swiperOptions.direction = 'vertical';
            swiperOptions.slidesPerView = 1;
            swiperOptions.breakpoints = {};
            // swiperOptions.loop = false;
            swiperOptions.fadeEffect = {crossFade: false};
            swiperOptions.on = {
                init: function (swiper) {
                    const currentSlide = swiper.slides[swiper.activeIndex];
                    const currentSlideItem = currentSlide.children[0];
                    jQuery(swiper.$el).css({
                        height: currentSlideItem.clientHeight
                    });
                },
                slideChange: function (swiper) {
                    const currentSlide = swiper.slides[swiper.activeIndex];
                    const currentSlideItem = currentSlide.children[0];
                    jQuery(swiper.$el).css({
                        height: currentSlideItem.clientHeight
                    });
                },
            }
        }

        return swiperOptions;
    }

    updateSwiperOption(propertyName) {
        const elementSettings = this.getElementSettings(),
            newSettingValue = elementSettings[propertyName],
            params = this.swiper.params;
        // Handle special cases where the value to update is not the value that the Swiper library accepts.
        switch (propertyName) {
            case 'image_spacing_custom':
                params.spaceBetween = newSettingValue.size || 0;
                break;
            case 'autoplay_speed':
                params.autoplay.delay = newSettingValue;
                break;
            case 'speed':
                params.speed = newSettingValue;
                break;
        }
        this.swiper.update();
    }

    getChangeableProperties() {
        return {
            pause_on_hover: 'pauseOnHover',
            autoplay_speed: 'delay',
            speed: 'speed',
            image_spacing_custom: 'spaceBetween',
        };
    }

    onElementChange(propertyName) {
        const changeableProperties = this.getChangeableProperties();
        if (changeableProperties[propertyName]) {
            // 'pause_on_hover' is implemented by the handler with event listeners, not the Swiper library.
            if ('pause_on_hover' === propertyName) {
                const newSettingValue = this.getElementSettings('pause_on_hover');
                this.togglePauseOnHover('yes' === newSettingValue);
            } else {
                this.updateSwiperOption(propertyName);
            }
        }
    }

    onEditSettingsChange(propertyName) {
        if ('activeItemIndex' === propertyName) {
            this.swiper.slideToLoop(this.getEditSettings('activeItemIndex') - 1);
        }
    }

    async onInit() {
        super.onInit(...arguments);
        await this.wrapNestedContainers();
        this.elements.$slides = this.elements.$swiperContainer.find(this.getSettings('selectors').slideContent);
        if (!this.elements.$swiperContainer.length || 1 > this.elements.$slides.length) {
            return;
        }

        const Swiper = elementorFrontend.utils.swiper;
        try {
            // Initialize Swiper
            if (!this.swiper) {
                this.swiper = await new Swiper(this.elements.$swiperContainer, this.getSwiperSettings());
                this.elements.$swiperContainer.trigger('swiperInit', [this.swiper]);
                this.elements.$swiperContainer.data('swiper', this.swiper);
            }

            // Handle pause on hover if enabled
            const elementSettings = this.getElementSettings();
            if (elementSettings.pause_on_hover === 'yes') {
                this.togglePauseOnHover(true);
            }

            // Ensure Swiper updates after initialization
            if (this.hasNesting() && elementorFrontend.isEditMode()) {
                this.swiper.update();
            }

            this.triggerElements(this.swiper);

        } catch (error) {
            console.error('Swiper initialization failed:', error);
        }
        // console.log(this.elements.$swiperContainer);
    }

    hasNesting() {
        return ["westio-nested-slide", "westio-nested-carousel"].includes(this.getWidgetType());
    }
    async wrapNestedContainers() {
        if (this.hasNesting() && elementorFrontend.isEditMode()) {
            return new Promise((resolve) => {
                this.elements.$swiperContainer.find('.swiper-wrapper > .e-con').each(function () {
                    const $this = jQuery(this);
                    if (!$this.parent().hasClass('swiper-slide')) {
                        $this.wrap('<div class="swiper-slide"></div>');
                    }
                });
                // DOM updates are synchronous, so resolve immediately
                resolve();
            });
        }
        return Promise.resolve();
    }

    togglePauseOnHover(toggleOn) {
        if (toggleOn) {
            this.elements.$swiperContainer.on({
                mouseenter: () => {
                    this.swiper.autoplay.stop();
                },
                mouseleave: () => {
                    this.swiper.autoplay.start();
                },
            });
        } else {
            this.elements.$swiperContainer.off('mouseenter mouseleave');
        }
    }

    triggerElements(swiper) {
        if (this.hasNesting()) {
            swiper.on("slideChange", () => {
                swiper.slides.forEach((slide) => {
                    jQuery(slide).find(".elementor-element.animated").each(function () {
                        const $el = jQuery(this);
                        const dataSettings = $el.attr("data-settings");
                        let animationClass = null;

                        if (dataSettings) {
                            try {
                                const jsonStr = dataSettings.replace(/(\w+):/g, '"$1":').replace(/'/g, '"');
                                const settings = JSON.parse(jsonStr);
                                animationClass = settings._animation || settings.animation;
                            } catch (e) {
                                console.warn("error parse data-settings:", dataSettings);
                            }
                        }

                        $el.addClass("elementor-invisible").removeClass("animated");
                        if (animationClass) {
                            $el.removeClass(animationClass);
                        }
                    });
                });
                const activeSlide = swiper.slides[swiper.activeIndex];
                jQuery(activeSlide).find(".elementor-element").each(function () {
                    elementorFrontend.elementsHandler.runReadyTrigger(jQuery(this));
                });
            });
        }
    }
}
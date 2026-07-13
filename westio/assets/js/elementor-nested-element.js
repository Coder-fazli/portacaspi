elementorCommon.elements.$window.on("elementor/nested-element-type-loaded", function () {
    class WestioNestedSlide extends elementor.modules.elements.types.NestedElementBase {

        getType() {
            return "westio-nested-slide";
        }
    }

    /**
     * And below you register the element within elementor elements manager
     */
    elementor.elementsManager.registerElementType(new WestioNestedSlide());

    class WestioNestedCarousel extends elementor.modules.elements.types.NestedElementBase {

        getType() {
            return "westio-nested-carousel";
        }
    }

    /**
     * And below you register the element within elementor elements manager
     */
    elementor.elementsManager.registerElementType(new WestioNestedCarousel());
});

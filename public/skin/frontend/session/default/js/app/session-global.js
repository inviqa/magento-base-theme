var Session = Session || {};
//undefined is passed through to make sure undefined is actually undefined as a lot of libraries overwrite this
Session.Global = (function ($, Modernizr, undefined) {
    "use strict";
    var SessionGlobal = {};
    /**
     * if you want a function to be accessible from other files and objects attach it to the object which is
     * returned at the end of the function declaration in this case "SessionGlobal"
     */
    // Slick slider available site wide if activated, carousel specific settings
    // can be added to the HTML
    SessionGlobal.slickSlider = function() {
        $('.js-carousel').slick();
    };

    //responsive video code
    SessionGlobal.responsiveVideo = function ($element) {
        // css tricks - fluid video width
        // http://css-tricks.com/NetMag/FluidWidthVideo/Article-FluidWidthVideo.php
        var $fluidEl,
            $allVideos;

        $fluidEl = ($element) ? $element.find(".fluid-video") : $(".fluid-video");
        $allVideos = $fluidEl.find("iframe, object, embed");

        if ($fluidEl.length > 0) {

            $allVideos.each(function () {
                var $this = $(this),
                    url = $this.attr("src"),
                    char = "?";

                // append wmode=transparent to fix IE issue of ignoiring z-index for iframes and fixed position elements
                if (url.indexOf("?") !== -1) {
                    char = "&";
                }
                // jQuery .data does not work on object/embed elements
                $this.attr("src", url + char + "wmode=transparent");
                $this.attr('data-aspectRatio', this.height / this.width).removeAttr('height').removeAttr('width');

            });

            $(window).resize(function () {
                $allVideos.each(function () {
                    var $el = $(this),
                        newWidth = $el.closest(".fluid-video").width();
                    $el.width(newWidth).height(newWidth * $el.attr('data-aspectRatio'));
                });
            }).resize();
        }
    };

    /**
     * Used in conjunction with the limit-text.scss file to give vertical num lines clipping
     */
    function css3LimitTextFallback() {
        if (typeof window.document.createElement('div').style.webkitLineClamp !== 'undefined') {
            document.querySelector('html').classList.add('webkit-line-clamp');
        }
    }

    /**
     * Global functions available on all pages
     */
    SessionGlobal.init = function () {
        //if you want a function either public or private to initialize on page load add it here
        SessionGlobal.responsiveVideo();
        SessionGlobal.slickSlider();
        css3LimitTextFallback();
    };

    //used to bind a function to an event (cross browser)
    //e.g Session.Global.bindEvent(window, 'resize', equalize);
    SessionGlobal.bindEvent = function(el, eventName, eventHandler) {
        if (el.addEventListener){
            el.addEventListener(eventName, eventHandler, false);
        } else if (el.attachEvent){
            el.attachEvent('on'+eventName, eventHandler);
        }
    };

    return SessionGlobal;
})(window.jQuery, Modernizr);

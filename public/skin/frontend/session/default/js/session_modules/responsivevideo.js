"use strict";

// css tricks - fluid video width
// http://css-tricks.com/NetMag/FluidWidthVideo/Article-FluidWidthVideo.php
module.exports = function ($element) {
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
"use strict";

/**
 * Load theme scripts using CommonJS convention
 * See: http://webpack.github.io/docs/commonjs.html
 */
var responsiveVideo = require('./session_modules/responsivevideo'),
    owlCarousel = require('./session_modules/owlCarousel'),
    css3LimitTextFallback = require('./session_modules/css3limittext'),
    bindEvent = require('./session_modules/bindevent');

/**
 * Initialise global JS dependencies
 */
responsiveVideo();
owlCarousel();
css3LimitTextFallback();

/**
 * Expose functions we'd like to use in inline scripts
 * Usage:
 * Session.Global.[function name]([args]);
 */
if (typeof window.Session == 'undefined') {
    window.Session = {};
}
window.Session.Global = {
    bindEvent: bindEvent
};
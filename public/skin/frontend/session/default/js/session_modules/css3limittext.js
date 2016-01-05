"use strict";

module.exports = function () {
    if (typeof window.document.createElement('div').style.webkitLineClamp !== 'undefined') {
        document.querySelector('html').classList.add('webkit-line-clamp');
    }
};
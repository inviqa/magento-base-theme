"use strict";

//used to bind a function to an event (cross browser)
//e.g Session.Global.bindEvent(window, 'resize', equalize);
module.exports = function (el, eventName, eventHandler) {
    if (el.addEventListener){
        el.addEventListener(eventName, eventHandler, false);
    } else if (el.attachEvent){
        el.attachEvent('on'+eventName, eventHandler);
    }
};
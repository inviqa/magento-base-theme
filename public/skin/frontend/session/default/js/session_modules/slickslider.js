"use strict";

// Slick slider available site wide if activated
module.exports = function () {
    var buttonTextPrevious = 'Previous',
        buttonTextNext = 'Next';

    $('.js-carousel').slick({
        mobileFirst: true,
        prevArrow: '<button type="button" class="[ slick-arrow  slick-prev ]  [ carousel__navigation  carousel__navigation--prev ]">' +
            '<span class="carousel__navigation__text">' +
                ( window.Translator ? Translator.translate(buttonTextPrevious) : buttonTextPrevious ) +
            '</span>' +
            '<span class="carousel__navigation__icon  [ icon  icon-angle-left ]"></span>' +
        '</button>',
        nextArrow: '<button type="button" class="[ slick-arrow  slick-next ]  [ carousel__navigation  carousel__navigation--next ]">' +
            '<span class="carousel__navigation__text">' +
                ( window.Translator ? Translator.translate(buttonTextNext) : buttonTextNext ) +
            '</span>' +
            '<span class="carousel__navigation__icon  [ icon  icon-angle-right ]"></span>' +
        '</button>'
    });
};

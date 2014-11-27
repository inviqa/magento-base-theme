"use strict";

// Add validation hints
Validation.defaultOptions.immediate = true;
Validation.defaultOptions.addClassNameToContainer = true;

var Session = (function ($) {
    "use strict";
    return {

        // HOWTO: define your functions here

        // wrap select form elements for styling
        styledSelects: function () {
            $('select:not(.multiselect)').wrap('<div class="styled-select" />');
        },

        init: function (initModules) {

            // HOWTO: initialise your functions
            this.styledSelects();

            $.each(initModules, function(key, value) {
                if (value === true) {
                    Session[key].init();
                }
            });
        }
    };
})(window.jQuery);

jQuery(function ($) {
    FastClick.attach(document.body);
    //load modules for site separated by function
    var initModules = {};
    Session.init(initModules);
});

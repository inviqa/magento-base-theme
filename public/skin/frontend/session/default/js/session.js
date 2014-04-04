"use strict";

// Add validation hints
Validation.defaultOptions.immediate = true;
Validation.defaultOptions.addClassNameToContainer = true;

var Session = (function ($) {
    "use strict";
    return {
        init: function (initModules) {
            $.each(initModules, function(key, value) {
                if (value === true) {
                    Innov8[key].init();
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
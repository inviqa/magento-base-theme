// Add validation hints
Validation.defaultOptions.immediate = true;
Validation.defaultOptions.addClassNameToContainer = true;

var Session = (function ($, undefined) {
    //always define "use strict" inside the function to prevent it affecting other scripts
    "use strict";
    return {
        //intialize module functions
        init: function (initModules) {
            $.each(initModules, function(key, value) {
                if (value === true) {
                    Session[key].init();
                }
            });
        }
    };
})(window.jQuery);

//initialize app on jQuery Document Ready
jQuery(function ($) {
    "use strict";
    FastClick.attach(document.body);
    //load modules for site separated by function
    var initModules = {
        Global: true
    };
    Session.init(initModules);
});

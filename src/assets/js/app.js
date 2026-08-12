!function () {
    "use strict";
    var e, t;
    [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(function (t) {
        return new bootstrap.Tooltip(t)
    }), [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).map(function (t) {
        return new bootstrap.Popover(t)
    }), Waves.init()
}();

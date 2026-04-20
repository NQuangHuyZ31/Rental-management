$(document).ready(function () {
    if (typeof initProfileHandlers === 'function') {
        initProfileHandlers({ role: 'customer' });
    }
});

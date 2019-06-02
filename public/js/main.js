$( document ).ready(function() {
    window.alert = function (msg, callback) {
        alertify.alert('Atenção!!!', msg, callback);
    };
});
jQuery(document).ready(function( $ ) {

    /* Activate modals function */
    $(window).on("load", function () {
        $("#myModal").modal("show");
    });

    /* Script WOW */
    new WOW().init();
});

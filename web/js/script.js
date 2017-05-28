jQuery(document).ready(function () {
    if ($('.datepicker').length) {
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            language: "fr"
        });
    }
});
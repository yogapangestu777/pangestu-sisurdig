$(document).ready(function () {
    $(".disable-button").click(function () {
        $(this).prop('disabled', true);
        $(this).text('Proses...');
        $(this).closest('form').submit();
        return false;
    });
});

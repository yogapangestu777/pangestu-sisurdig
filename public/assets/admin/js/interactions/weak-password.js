$(document).ready(function () {
    let $myInput = $("#newpass");
    let $retype = $("#retype");
    let $letter = $("#letter");
    let $capital = $("#capital");
    let $number = $("#number");
    let $symbol = $("#symbol");
    let $length = $("#length");
    let $feedback = $("#feedback");

    $myInput.on("focus", function () {
        $("#newpass-message").show();
    });

    $myInput.on("blur", function () {
        $("#newpass-message").hide();
    });

    $myInput.on("keyup", function () {
        let lowerCaseLetters = /[a-z]/g;
        if ($myInput.val().match(lowerCaseLetters)) {
            $letter.removeClass("invalid").addClass("valid");
        } else {
            $letter.removeClass("valid").addClass("invalid");
        }

        let upperCaseLetters = /[A-Z]/g;
        if ($myInput.val().match(upperCaseLetters)) {
            $capital.removeClass("invalid").addClass("valid");
        } else {
            $capital.removeClass("valid").addClass("invalid");
        }

        let numbers = /[0-9]/g;
        if ($myInput.val().match(numbers)) {
            $number.removeClass("invalid").addClass("valid");
        } else {
            $number.removeClass("valid").addClass("invalid");
        }

        if ($myInput.val().length >= 8) {
            $length.removeClass("invalid").addClass("valid");
        } else {
            $length.removeClass("valid").addClass("invalid");
        }

        let symbols = /[!$#%@]/g;
        if ($myInput.val().match(symbols)) {
            $symbol.removeClass("invalid").addClass("valid");
        } else {
            $symbol.removeClass("valid").addClass("invalid");
        }
    });

    $retype.on("focus", function () {
        $feedback.show();
    });

    $retype.on("blur", function () {
        $feedback.hide();
    });

    $retype.on("keyup", function () {
        if ($retype.val().length === 0) {
            $retype.removeClass("is-valid").addClass("is-invalid");
            $feedback.addClass("text-danger");
            $("#retype-message").html("Silakan masukkan ulang <b>Kata sandi baru!</b>");
        } else {
            if ($myInput.val() === $retype.val()) {
                $retype.removeClass("is-invalid").addClass("is-valid");
                $feedback.removeClass("text-danger").addClass("text-success");
                $("#retype-message").html("Kata sandi <b>cocok!</b>");
            } else {
                $retype.removeClass("is-valid").addClass("is-invalid");
                $feedback.removeClass("text-success").addClass("text-danger");
                $("#retype-message").html("Kata sandi <b>tidak cocok!</b>");
            }
        }
    });
});

$(document).ready(function () {
    let $newPassword = $("#new_password");
    let $confirmNewPassword = $("#confirm_new_password");
    let $letter = $("#letter");
    let $capital = $("#capital");
    let $number = $("#number");
    let $symbol = $("#symbol");
    let $length = $("#length");
    let $feedback = $("#feedback");
    let $confirmNewPasswordMessage = $("#confirm_new_password_message");
  
    $newPassword.on("focus", function () {
      $("#new_password_message").show();
    });
  
    $newPassword.on("blur", function () {
      $("#new_password_message").hide();
    });
  
    $newPassword.on("keyup", function () {
      let value = $newPassword.val();
  
      if (/[a-z]/.test(value)) {
        $letter.removeClass("invalid").addClass("valid");
      } else {
        $letter.removeClass("valid").addClass("invalid");
      }
  
      if (/[A-Z]/.test(value)) {
        $capital.removeClass("invalid").addClass("valid");
      } else {
        $capital.removeClass("valid").addClass("invalid");
      }
  
      if (/[0-9]/.test(value)) {
        $number.removeClass("invalid").addClass("valid");
      } else {
        $number.removeClass("valid").addClass("invalid");
      }
  
      if (value.length >= 8) {
        $length.removeClass("invalid").addClass("valid");
      } else {
        $length.removeClass("valid").addClass("invalid");
      }
  
      if (/[!$#%@]/.test(value)) {
        $symbol.removeClass("invalid").addClass("valid");
      } else {
        $symbol.removeClass("valid").addClass("invalid");
      }
    });
    confirm_new_password
    $confirmNewPassword.on("focus", function () {
      $feedback.show();
    });
  
    $confirmNewPassword.on("blur", function () {
      $feedback.hide();
    });
  
    $confirmNewPassword.on("keyup", function () {
      let repeatValue = $confirmNewPassword.val();
      let newValue = $newPassword.val();
  
      if (repeatValue.length === 0) {
        $confirmNewPassword.removeClass("is-valid").addClass("is-invalid");
        $feedback.addClass("text-danger");
        $confirmNewPasswordMessage.html("Silakan masukkan ulang <b>Kata sandi baru!</b>");
      } else if (newValue === repeatValue) {
        $confirmNewPassword.removeClass("is-invalid").addClass("is-valid");
        $feedback.removeClass("text-danger").addClass("text-success");
        $confirmNewPasswordMessage.html("Kata sandi <b>cocok!</b>");
      } else {
        $confirmNewPassword.removeClass("is-valid").addClass("is-invalid");
        $feedback.removeClass("text-success").addClass("text-danger");
        $confirmNewPasswordMessage.html("Kata sandi <b>tidak cocok!</b>");
      }
    });
  });
  
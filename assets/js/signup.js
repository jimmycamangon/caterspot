$(document).ready(function () {
  $("#verificationButton").click(function () {
    var verifyBtn = document.getElementById("verificationButton");

    var username = $("#username").val();
    var email = $("#email_signup").val();
    var password = $("#password_signup").val();
    var confirmpass = $("#confirmpass").val();
    var firstname = $("#firstname").val();
    var lastname = $("#lastname").val();

    if (
      username != "" &&
      email != "" &&
      password != "" &&
      confirmpass != "" &&
      firstname != "" &&
      lastname != ""
    ) {
      // Make sure all fields are filled

      if (password === confirmpass) {
        verifyBtn.disabled = true; // Disable the submit button
        verifyBtn.style.opacity = 0.5; // Change button opacity
        verifyBtn.style.cursor = "wait";
        $.ajax({
          url: "functions/send-code-verification.php",
          method: "POST",
          data: {
            username: username,
            email: email,
            password: password,
            lastname: lastname,
            firstname: firstname,
          }, // Include email in data
          dataType: "json", // Expect JSON response
          success: function (data) {
            if (data.msg) {
              // Display the error message in the #message div
              $("#message").html(
                '<div class="alert alert-danger" role="alert">' +
                  data.msg +
                  "</div>"
              );

              verifyBtn.disabled = false;
              verifyBtn.style.opacity = 1;
              verifyBtn.style.cursor = "pointer";
            } else if (data.success) {
              Toastify({
                text: data.success,
                backgroundColor: "rgba(31, 166, 49, 0.8)",
              }).showToast();

              // Hide the first display and show the second display
              $("#firstDisplay").hide();
              $("#secondDisplay").show();
            }
          },
          error: function (xhr, status, error) {
            // Handle AJAX errors
            console.error(xhr.responseText);

            verifyBtn.disabled = false;
            verifyBtn.style.opacity = 1;
            verifyBtn.style.cursor = "pointer";
          },
        });
      } else {
        // Display a danger alert if new password and confirm password don't match
        $("#message").html(
          '<div class="alert alert-danger" role="alert">New password and Confirm password are not matched</div>'
        );
      }
    } else {
      // Display a danger alert if any field is empty
      $("#message").html(
        '<div class="alert alert-danger" role="alert">All fields are required</div>'
      );
    }
  });
  // Handle the paste event on the verification code inputs
  $(".verification-code").on("paste", function (e) {
    var pasteData = e.originalEvent.clipboardData.getData("text");
    var inputs = $(".verification-code");

    if (pasteData.length === inputs.length) {
      inputs.each(function (index, input) {
        $(input).val(pasteData[index]);
      });
    }

    // Prevent the default paste action
    e.preventDefault();
  });

  $("#signUp").click(function () {
    var signUpBtn = document.getElementById("signUp");

    var username = $("#username").val();
    var email = $("#email_signup").val();
    var password = $("#password_signup").val();
    var firstname = $("#firstname").val();
    var lastname = $("#lastname").val();

    // Retrieve the entered verification code
    var verificationCode = "";
    $(".verification-code").each(function () {
      verificationCode += $(this).val();
    });

    // Ensure the code is 4 digits long
    if (verificationCode.length !== 4) {
      $("#message_verification").html(
        '<div class="alert alert-danger" role="alert">Please enter the 4-digit verification code.</div>'
      );
      return;
    } else {
      signUpBtn.disabled = true; // Disable the submit button
      signUpBtn.style.opacity = 0.5; // Change button opacity
      signUpBtn.style.cursor = "wait";

      $.ajax({
        url: "functions/signup.php",
        method: "POST",
        data: {
          username: username,
          email: email,
          password: password,
          firstname: firstname,
          lastname: lastname,
          verification_code: verificationCode,
        }, // Include the verification code in data
        dataType: "json", // Expect JSON response
        success: function (data) {
          if (data.msg) {
            // Display the error message in the #message div
            $("#message_verification").html(
              '<div class="alert alert-danger" role="alert">' +
                data.msg +
                "</div>"
            );
            signUpBtn.disabled = false; 
            signUpBtn.style.opacity = 1; 
            signUpBtn.style.cursor = "pointer";
          } else if (data.success) {
            Toastify({
              text: data.success,
              backgroundColor: "rgba(31, 166, 49, 0.8)",
            }).showToast();

            setTimeout(function () {
              window.location.href = "index.php";
            }, 2000);
          }
        },
        error: function (xhr, status, error) {
          // Handle AJAX errors
          console.error(xhr.responseText);
          signUpBtn.disabled = false; 
          signUpBtn.style.opacity = 1; 
          signUpBtn.style.cursor = "pointer";
        },
      });
    }
  });
});

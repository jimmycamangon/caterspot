$(document).ready(function () {
  // Save changes button click event
  $("#saveChangesBtn").click(function () {
    var userId = $("#edit_user_id").val();
    var firstName = $("#edit_first_name").val();
    var lastName = $("#edit_last_name").val();
    var username = $("#edit_username").val();
    var email = $("#edit_email").val();
    var contact = $("#edit_contact").val();
    var region = $("#edit_region").val();
    var province = $("#edit_province").val();
    var city = $("#edit_city").val();
    var location = $("#edit_location").val();
    var newpass = $("#newpass").val();
    var confirmpass = $("#confirmpass").val();
    // Add other fields as needed

    if (
      userId !== "" &&
      firstName !== "" &&
      lastName !== "" &&
      email !== "" &&
      contact !== "" &&
      region !== "" &&
      province !== "" &&
      city !== "" &&
      location !== "" &&
      username !== ""
    ) {
      if (newpass === confirmpass) {
        // AJAX call to update user profile
        $.ajax({
          url: "functions/update-profile.php",
          method: "POST",
          data: {
            user_id: userId,
            first_name: firstName,
            last_name: lastName,
            email: email,
            contact: contact,
            region: region,
            province: province,
            city: city,
            location: location,
            username: username,
            newpass: newpass,
            // Add other fields as needed
          },
          dataType: "json",
          success: function (data) {
            // Handle success response
            if (data.success) {
              // Display success message
              Toastify({
                text: data.success,
                backgroundColor: "rgba(31, 166, 49, 0.8)",
              }).showToast();

              setTimeout(function () {
                window.location.href = "profile.php";
              }, 1000);
            } else {
              // Display error message
              $("#message").html(
                '<div class="alert alert-danger" role="alert">' +
                  data.msg +
                  "</div>"
              );
            }
          },
          error: function (xhr, status, error) {
            // Handle AJAX errors
            console.error(xhr.responseText);
          },
        });
      } else {
        // Display a danger alert if new password and confirm password don't match
        $("#message").html(
          '<div class="alert alert-danger" role="alert">New password and Confirm password are not matched</div>'
        );
      }
    } else {

      const locationField = document.getElementById("edit_location");
      locationField.addEventListener("input", function () {
        const edit_location = locationField.value.trim();

        if (edit_location === "") {
          locationField.classList.add("invalid");
        } else {
          locationField.classList.remove("invalid");
        }
      });


      const contactField = document.getElementById("edit_contact");
      contactField.addEventListener("input", function () {
        const edit_contact = contactField.value.trim();

        if (edit_contact === "") {
          contactField.classList.add("invalid");
        } else {
          contactField.classList.remove("invalid");
        }
      });
      contactField.classList.add("invalid");
      locationField.classList.add("invalid");
      // Display a danger alert if any required field is empty
      $("#message").html(
        '<div class="alert alert-danger" role="alert">All fields are required</div>'
      );
    }
  });
});

// PASSWORD INDICATION
document.addEventListener("DOMContentLoaded", function () {
  const addressField = document.getElementById("edit_location");
  const passwordField = document.getElementById("newpass");
  const confirmPasswordField = document.getElementById("confirmpass");
  const passwordLengthMessage = document.getElementById(
    "passwordLengthMessage"
  );
  const passwordUppercaseMessage = document.getElementById(
    "passwordUppercaseMessage"
  );
  const passwordSpecialCharMessage = document.getElementById(
    "passwordSpecialCharMessage"
  );
  const confirmPasswordMessage = document.getElementById(
    "confirmPasswordMessage"
  );
  var submitBtn = document.getElementById("saveChangesBtn");

  // Validate password on input
  passwordField.addEventListener("input", function () {
    const password = passwordField.value;
    let allConditionsMet = true; // Flag to track if all conditions are met

    // Check if password meets length requirement
    const passwords = passwordField.value.trim(); // Trim to remove leading and trailing whitespace


    if (passwords === "") {
      // Password input is empty, hide all messages
      passwordLengthMessage.style.display = "none";
      passwordUppercaseMessage.style.display = "none";
      passwordSpecialCharMessage.style.display = "none";
      passwordField.classList.remove("invalid");
    } else {
      // Password input is not empty, show all messages
      passwordLengthMessage.style.display = "block";
      passwordUppercaseMessage.style.display = "block";
      passwordSpecialCharMessage.style.display = "block";
    }

    if (password.length >= 8) {
      passwordLengthMessage.style.color = "green";
    } else {
      passwordLengthMessage.style.color = "red";
      allConditionsMet = false; // Set flag to false if length condition is not met
    }

    // Check if password contains at least one uppercase letter
    if (/[A-Z]/.test(password)) {
      passwordUppercaseMessage.style.color = "green";
    } else {
      passwordUppercaseMessage.style.color = "red";
      allConditionsMet = false; // Set flag to false if uppercase condition is not met
    }

    // Check if password contains at least one special character
    if (/[!@#$%^&*]/.test(password)) {
      passwordSpecialCharMessage.style.color = "green";
    } else {
      passwordSpecialCharMessage.style.color = "red";
      allConditionsMet = false; // Set flag to false if special character condition is not met
    }

    // Enable or disable the submit button based on all conditions being met
    submitBtn.disabled = !allConditionsMet;
  });

  // Validate confirm password on input
  confirmPasswordField.addEventListener("input", function () {
    const password = passwordField.value;
    const confirmPassword = confirmPasswordField.value;

    if (password !== confirmPassword) {
      confirmPasswordMessage.style.color = "red";
      confirmPasswordMessage.style.display = "block";

      submitBtn.disabled = true; // Disable the submit button if passwords do not match
    } else {
      confirmPasswordMessage.style.color = "green";
      confirmPasswordMessage.style.display = "none";

      submitBtn.disabled = false;
    }
  });
});

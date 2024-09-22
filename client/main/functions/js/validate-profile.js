$(document).ready(function () {
  // Save changes button click event
  $("#saveChangesBtn").click(function () {
    var client_id = $("#edit_client_id").val();
    var username = $("#edit_username").val();
    var email = $("#edit_email").val();
    var contact = $("#contact").val();
    // Add other fields as needed

    if (client_id !== "" && email !== "" && username !== "" && contact !== "") {
        // AJAX call to update user profile
        $.ajax({
          url: "../main/functions/update-profile.php",
          method: "POST",
          data: {
            client_id: client_id,
            email: email,
            username: username,
            contact: contact
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
      // Display a danger alert if any required field is empty
      $("#message").html(
        '<div class="alert alert-danger" role="alert">All fields are required</div>'
      );
    }
  });

  function validateContact() {
    var contactInput = document.getElementById("contact");
    var contactError = document.getElementById("contactError");
    var contactPattern = /^(0936xxxxxx|094-xxx-xxxx)$/;

    if (!contactPattern.test(contactInput.value)) {
      contactError.innerHTML = "Contact number format is not valid.";
      contactInput.setCustomValidity("Invalid contact number format");
    } else if (!/^\d*$/.test(contactInput.value)) {
      contactError.innerHTML = "Contact number should contain only numbers.";
      contactInput.setCustomValidity(
        "Contact number should contain only numbers"
      );
    } else {
      contactError.innerHTML = "";
      contactInput.setCustomValidity(""); // Reset validation
    }
  }
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



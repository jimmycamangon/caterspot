$(document).ready(function () {
    // Save changes button click event
    $("#saveChangesBtnPass").click(function () {
      var client_id = $("#edit_client_id").val();
      var newpass = $("#newpass").val();
      var confirmpass = $("#confirmpass").val();
      // Add other fields as needed
  
      if (client_id !== "") {
        if (newpass === confirmpass) {
          // AJAX call to update user profile
          $.ajax({
            url: "../main/functions/update-pass.php",
            method: "POST",
            data: {
              client_id: client_id,
              newpass: newpass,
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
                  window.location.href = "settings.php";
                }, 1000);
              } else {
                // Display error message
                $("#message_pass").html(
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
          $("#message_pass").html(
            '<div class="alert alert-danger" role="alert">New password and Confirm password are not matched</div>'
          );
        }
      } else {
        // Display a danger alert if any required field is empty
        $("#message_pass").html(
          '<div class="alert alert-danger" role="alert">All fields are required</div>'
        );
      }
    });

  });
  
  
  
  // PASSWORD INDICATION
  document.addEventListener("DOMContentLoaded", function () {
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
    var submitBtn = document.getElementById("saveChangesBtnPass");
  
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
  
      if (password.length >= 13) {
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
  
  
  

  // Check if passwordLogin element exists before accessing it
const passwordSignup = document.getElementById("newpass");
const confirmpass = document.getElementById("confirmpass");
const eyeIconContainerLogin = document.getElementById("eyeIconContainer");
const eyeIconContainerSignup = document.getElementById(
  "eyeIconContainerSignup"
);
const eyeIconContainerSignupConfirm = document.getElementById(
  "eyeIconContainerSignupConfirm"
);




if (passwordSignup) {
  // Add event listener only if passwordSignup exists
  passwordSignup.addEventListener("input", function () {
    const inputValue = this.value.trim();
    if (inputValue.length > 0) {
      eyeIconContainerSignup.classList.remove("d-none");
    } else {
      eyeIconContainerSignup.classList.add("d-none");
    }
  });

  // Check if eyeIconContainerSignup exists before adding event listener
  if (eyeIconContainerSignup) {
    eyeIconContainerSignup.addEventListener("click", function () {
      const type =
        passwordSignup.getAttribute("type") === "password"
          ? "text"
          : "password";
      passwordSignup.setAttribute("type", type);
      // Store a reference to the <i> element separately
      const eyeIcon = eyeIconContainerSignup.querySelector("i");
      // Check if eyeIcon exists before toggling its classList
      if (eyeIcon) {
        eyeIcon.classList.toggle("bx-show");
        eyeIcon.classList.toggle("bx-hide");
      }
    });
  }
}

if (confirmpass) {
  // Add event listener only if confirmpass exists
  confirmpass.addEventListener("input", function () {
    const inputValue = this.value.trim();
    if (inputValue.length > 0) {
      eyeIconContainerSignupConfirm.classList.remove("d-none");
    } else {
      eyeIconContainerSignupConfirm.classList.add("d-none");
    }
  });

  // Check if eyeIconContainerSignupConfirm exists before adding event listener
  if (eyeIconContainerSignupConfirm) {
    eyeIconContainerSignupConfirm.addEventListener("click", function () {
      const type =
        confirmpass.getAttribute("type") === "password" ? "text" : "password";
      confirmpass.setAttribute("type", type);
      // Store a reference to the <i> element separately
      const eyeIcon = eyeIconContainerSignupConfirm.querySelector("i");
      // Check if eyeIcon exists before toggling its classList
      if (eyeIcon) {
        eyeIcon.classList.toggle("bx-show");
        eyeIcon.classList.toggle("bx-hide");
      }
    });
  }
}

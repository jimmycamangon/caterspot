// Check if passwordLogin element exists before accessing it
const passwordSignup = document.getElementById("password");
const confirmpass = document.getElementById("confirm_password");
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



// INDICATION FOR PASSWORD
document.addEventListener("DOMContentLoaded", function () {
  const passwordField = document.getElementById("password");
  const confirmPasswordField = document.getElementById("confirm_password");
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
  var submitBtn = document.getElementById("reset_button");

  // Validate password on input
  passwordField.addEventListener("input", function () {
    const password = passwordField.value;
    let allConditionsMet = true; // Flag to track if all conditions are met


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

    // Check if password meets length requirement
    if (password.length >= 8) {
      passwordLengthMessage.style.color = "green";
      passwordField.classList.remove("invalid");
    } else {
      passwordLengthMessage.style.color = "red";
      passwordField.classList.add("invalid");
      allConditionsMet = false; // Set flag to false if length condition is not met
    }

    // Check if password contains at least one uppercase letter
    if (/[A-Z]/.test(password)) {
      passwordUppercaseMessage.style.color = "green";
      passwordField.classList.remove("invalid");
    } else {
      passwordUppercaseMessage.style.color = "red";
      passwordField.classList.add("invalid");
      allConditionsMet = false; // Set flag to false if uppercase condition is not met
    }

    // Check if password contains at least one special character
    if (/[!@#$%^&*]/.test(password)) {
      passwordSpecialCharMessage.style.color = "green";
      passwordField.classList.remove("invalid");
    } else {
      passwordSpecialCharMessage.style.color = "red";
      passwordField.classList.add("invalid");
      allConditionsMet = false; // Set flag to false if special character condition is not met
    }

    // Enable or disable the submit button based on all conditions being met
    submitBtn.disabled = !allConditionsMet;
  });

  // Validate confirm password on input
  confirmPasswordField.addEventListener("input", function () {
    const password = passwordField.value;
    const confirmPassword = confirmPasswordField.value;

    const confirmPasswords = confirmPasswordField.value.trim();

    if (confirmPasswords === "") {
      confirmPasswordMessage.style.display = "none";
      confirmPasswordField.classList.remove("invalid");
    } else {
      confirmPasswordMessage.style.display = "block";
    }
    if (password !== confirmPassword) {
      confirmPasswordMessage.style.color = "red";
      confirmPasswordMessage.style.display = "block";
      confirmPasswordField.classList.add("invalid");

      submitBtn.disabled = true; // Disable the submit button if passwords do not match
    } else {
      confirmPasswordMessage.style.color = "green";
      confirmPasswordMessage.style.display = "none";
      confirmPasswordField.classList.remove("invalid");
      submitBtn.disabled = false;
    }
  });
});

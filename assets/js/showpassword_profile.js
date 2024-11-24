
const passwordSignup = document.getElementById("newpass");
const confirmpass = document.getElementById("confirmpass");
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


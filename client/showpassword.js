// Check if passwordLogin element exists before accessing it
const passwordInput = document.getElementById('passwordLogin');
const eyeIconContainer = document.getElementById('eyeIconContainer');

if (passwordInput) {
    // Add event listener only if passwordInput exists
    passwordInput.addEventListener('input', function () {
        const inputValue = this.value.trim();
        if (inputValue.length > 0) {
            eyeIconContainer.classList.remove('d-none');
        } else {
            eyeIconContainer.classList.add('d-none');
        }
    });

    // Check if eyeIconContainer exists before adding event listener
    if (eyeIconContainer) {
        eyeIconContainer.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            // Store a reference to the <i> element separately
            const eyeIcon = eyeIconContainer.querySelector('i');
            // Check if eyeIcon exists before toggling its classList
            if (eyeIcon) {
                eyeIcon.classList.toggle('bx-show');
                eyeIcon.classList.toggle('bx-hide');
            }
        });
    }
} else {
    // If passwordLogin does not exist, hide eyeIconContainer
    if (eyeIconContainer) {
        eyeIconContainer.classList.add('d-none');
    }
}



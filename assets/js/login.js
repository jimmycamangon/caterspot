$(document).ready(function () {
    $('#LoginButton').click(function () {
        var email = $('#emailLogin').val(); 
        var password = $('#passwordLogin').val();

        if (email != '' && password != '') { // Make sure all fields are filled
            $.ajax({
                url: "functions/login.php",
                method: "POST",
                data: { email: email, password: password }, // Include email in data
                dataType: "json", // Expect JSON response
                success: function (data) {
                    if (data.msg) {
                        // Display the error message in the #message div
                        $('#messageLogin').html('<div class="alert alert-danger" role="alert">' + data.msg + '</div>');
                    } else if (data.success) {
                        Toastify({
                            text: data.success,
                            backgroundColor: "rgba(31, 166, 49, 0.8)",
                        }).showToast();

                        setTimeout(function () {
                            window.location.href = 'index.php';
                        }, 2000);
                    }
                },
                error: function (xhr, status, error) {
                    // Handle AJAX errors
                    console.error(xhr.responseText);
                }
            });
        } else {
            // Display a danger alert if any field is empty
            $('#messageLogin').html('<div class="alert alert-danger" role="alert">All fields are required</div>');
        }
    });
});


document.addEventListener('keydown', function(event) {
    // Check if the pressed key is Enter (keyCode 13) or Return (keyCode 10)
    if (event.keyCode === 13 || event.keyCode === 10) {
        // Prevent the default action of the Enter key
        event.preventDefault();
        
        // Check if the login form is active
        if (document.getElementById('emailLogin').matches(':focus') || document.getElementById('passwordLogin').matches(':focus')) {
            // Trigger a click event on the login button
            document.getElementById('LoginButton').click();
        }
        // Check if the sign-up form is active
        else if (document.getElementById('email_signup').matches(':focus') || document.getElementById('username').matches(':focus') || document.getElementById('firstname').matches(':focus') || document.getElementById('lastname').matches(':focus') || document.getElementById('password').matches(':focus')) {
            // Trigger a click event on the sign-up button
            document.getElementById('signUp').click();
        }
    }
});

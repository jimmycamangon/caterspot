$(document).ready(function () {
    $('#LoginButton').click(function () {
        var username = $('#username').val(); 
        var password = $('#passwordLogin').val();

        if (username != '' && password != '') { // Make sure all fields are filled
            $.ajax({
                url: "login_process.php",
                method: "POST",
                data: { username: username, password: password }, // Include username in data
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
                            window.location.href = 'main/';
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
        // Trigger a click event on the login button
        document.getElementById('LoginButton').click();
    }
});
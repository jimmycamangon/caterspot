$(document).ready(function() {
    $('button[type="submit"]').click(function(e) {
        e.preventDefault(); // Prevent form submission
        
        // Reset any previous messages
        $('#contact_message').html('<div class="alert alert-info">Sending message...</div>');
        
        // Get form values
        var name = $('#customer_name').val();
        var email = $('#customer_email').val();
        var subject = $('#customer_subject').val();
        var message = $('#customer_message').val();
        var client_email = $('#client_email').val();
        var client_username = $('#client_username').val();
        
        // Check if any field is empty
        if (name == '' || email == '' || subject == '' || message == '') {
            $('#contact_message').html('<div class="alert alert-danger">All fields are required.</div>');
            return;
        }
        
        // If all fields are filled, make AJAX request
        $.ajax({
            url: 'functions/customer-message.php',
            type: 'POST',
            data: {
                customer_name: name,
                customer_email: email,
                customer_subject: subject,
                client_email: client_email,
                client_username: client_username,
                customer_message: message
            },
            success: function(response) {
                // Display success message
                $('#contact_message').html('<div class="alert alert-success">Message sent successfully!</div>');
                // Clear form fields
                $('#customer_name').val('');
                $('#customer_email').val('');
                $('#customer_subject').val('');
                $('#customer_message').val('');
            },
            error: function(xhr, status, error) {
                // Display error message
                $('#contact_message').html('<div class="alert alert-danger">Error: ' + error + '</div>');
            }
        });
    });
});

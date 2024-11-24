$(document).ready(function() {
    var packageId = ''; // Variable to hold the package_id

    // When the "Rate Package" span is clicked
    $('span[data-toggle="modal"][data-target="#ratingModal"]').click(function() {
        // Get the package_id from the clicked span's data attribute
        packageId = $(this).data('package-id');
    });

    var submitBtn = document.getElementById("submitRating");
    $('#submitRating').click(function() {
        // Get selected star rating
        var rating = $('input[name="ratingStars"]:checked').val();
        
        // Validate star rating
        if (!rating) {
            $("#rating-message").html(
                '<div class="alert alert-danger" role="alert">Please ensure a star rating is selected.</div>'
            );
            return;
        }

        // Clear previous message
        $('#rating-message').html('').removeClass('alert-danger');
        
        // Ajax call to submit feedback
        $.ajax({
            type: 'POST',
            url: 'functions/insert-ratings.php',
            data: {
                client_id: clientId,  // Ensure clientId is defined somewhere
                rating: rating,
                package_id: packageId  // Pass the captured package_id here
            },
            success: function(response) {
                // Handle success response
                if (response.trim() === 'Your rating has been successfully submitted!') {
                    submitBtn.disabled = true; // Disable the submit button
                    submitBtn.style.opacity = 0.5; // Change button opacity
                    submitBtn.style.cursor = "not-allowed"; // Change cursor to not allowed
                    $("#rating-message").html(
                        '<div class="alert alert-success" role="alert">' + response + '</div>'
                    );
                    setTimeout(function () {
                        location.reload(); 
                    }, 2000);
                } else {
                    $("#rating-message").html(
                        '<div class="alert alert-danger" role="alert">' + response + '</div>'
                    );
                }
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error('Error submitting feedback: ' + error);
            }
        });
    });
});

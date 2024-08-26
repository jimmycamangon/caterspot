$(document).ready(function() {
    var submitBtn = document.getElementById("submitFeedback");
    $('#submitFeedback').click(function() {
        // Get selected star rating
        var rating = $('input[name="stars"]:checked').val();
        
        // Get comment
        var comment = $('#comments').val();
        
        // Validate star rating
        if (!rating) {
            $("#review-message").html(
                '<div class="alert alert-danger" role="alert">Please ensure a star rating is selected.</div>'
              );
            return;
        }

        // Clear previous message
        $('#review-message').html('').removeClass('alert-danger');
        
        // Ajax call to submit feedback
        $.ajax({
            type: 'POST',
            url: 'functions/insert-feedbacks.php',
            data: {
                client_id: clientId,
                rating: rating,
                comment: comment
            },
            success: function(response) {
                // Handle success response
                if (response.trim() === 'Thank you for your feedback!') {
                    submitBtn.disabled = true; // Disable the submit button
                    submitBtn.style.opacity = 0.5; // Change button opacity
                    submitBtn.style.cursor = "not-allowed"; // Change cursor to not allowed
                    $("#review-message").html(
                        '<div class="alert alert-success" role="alert">' + response + '</div>'
                      );
                      setTimeout(function () {
                        location.reload(); 
                    }, 2000);
                } else {
                    $("#review-message").html(
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

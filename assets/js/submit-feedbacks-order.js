$(document).ready(function () {
  // Ensure the variables are defined globally or within the appropriate scope
  var transacNo = window.transacNo;
  var clientId = window.clientId;

  var submitBtn = document.getElementById("submitFeedback");

  $("#submitFeedback").click(function () {
    // Get selected star rating
    var rating = $('input[name="stars"]:checked').val();

    // Get comment
    var comment = $("#comments").val();

    // Validate star rating
    if (!rating) {
      $("#review-message").html(
        '<div class="alert alert-danger" role="alert">Please ensure a star rating is selected.</div>'
      );
      return;
    }

    // Ajax call to submit feedback
    $.ajax({
      type: "POST",
      url: "functions/insert-feedbacks-order.php",
      data: {
        transacNo: transacNo,
        client_id: clientId,
        rating: rating,
        comment: comment,
      },
      success: function (response) {
        var jsonResponse = JSON.parse(response); // Parse the JSON response
        if (jsonResponse.success === "Feedback submitted successfully!") {
          submitBtn.disabled = true; // Disable the submit button
          submitBtn.style.opacity = 0.5; // Change button opacity
          submitBtn.style.cursor = "not-allowed"; // Change cursor to not allowed
          $("#review-message").html(
            '<div class="alert alert-success" role="alert">Thank you for your feedback!</div>'
          );
          setTimeout(function () {
            // Redirect to my-reservations.php after 2 seconds
            window.location.href = "my-reservations.php";
          }, 2000);
        } else {
          $("#review-message").html(
            '<div class="alert alert-danger" role="alert">' +
              response +
              "</div>"
          );
        }
      },
      error: function (xhr, status, error) {
        // Handle error response
        console.error("Error submitting feedback: " + error);
      },
    });
  });
});

function rejectReservation(transactionNo, remarks) {

    var submitBtn = document.getElementById("deleteRequest");

    submitBtn.disabled = true; // Disable the submit button
    submitBtn.style.opacity = 0.5; // Change button opacity
    submitBtn.style.cursor = "wait"; // Change cursor to not allowed

    $.ajax({
        url: 'functions/update-reject-status.php',
        type: 'POST',
        data: { transactionNo: transactionNo, status: 'Rejected', remarks: remarks },
        success: function(response) {
            // Parse the JSON response
            var data = JSON.parse(response);
            if (data.msg) {
                $("#message").html(
                  '<div class="alert alert-danger" role="alert">' +
                    data.msg +
                    "</div>"
                );
              } else if (data.success) {
                Toastify({
                  text: data.success,
                  backgroundColor: "rgba(31, 166, 49, 0.8)",
                }).showToast();
                // Redirect to the same page after a short delay
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error rejecting request:', error);
        }
    });
}

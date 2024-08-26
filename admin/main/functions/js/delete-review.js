$(document).ready(function () {
  // Delete button click event
  $(".btn-get-del").click(function () {
    var user_id = $(this).data("customer-id");

    // Set the customer id for deletion
    $("#confirmDeleteBtn").data("customer-id", user_id);

    var feed_id = $(this).data("feed-id");

    // Set the customer id for deletion
    $("#confirmDeleteBtn").data("feed-id", feed_id);

    // Show delete confirmation modal
    $("#deleteConfirmationModal").modal("show");
  });

  // Confirm delete button click event
  $("#confirmDeleteBtn").click(function () {
    var user_id = $(this).data("customer-id");
    var feed_id = $(this).data("feed-id");

    // AJAX call to delete customer
    $.ajax({
      url: "functions/delete-review.php",
      method: "POST",
      data: { user_id: user_id, feed_id: feed_id },
      dataType: "json",
      success: function (data) {
        // Handle success response
        if (data.msg) {
          // Display the message in the #message div
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

          setTimeout(function () {
            window.location.href = "index.php";
          }, 1000);
        }
      },
      error: function (xhr, status, error) {
        // Handle AJAX errors
        console.error(xhr.responseText);
      },
    });

    // Hide delete confirmation modal
    $("#deleteConfirmationModal").modal("hide");
  });
});

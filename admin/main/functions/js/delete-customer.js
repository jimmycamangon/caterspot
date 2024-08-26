$(document).ready(function () {
    // Delete button click event
    $(".btn-get-del").click(function () {
      var user_id = $(this).data("user-id");
  
      // Set the user id for deletion
      $("#confirmDeleteBtn").data("user-id", user_id);
  
      // Show delete confirmation modal
      $("#deleteConfirmationModal").modal("show");
    });
  
    // Confirm delete button click event
    $("#confirmDeleteBtn").click(function () {
      var user_id = $(this).data("user-id");
  
      // AJAX call to delete user
      $.ajax({
        url: "functions/delete-customers.php",
        method: "POST",
        data: { user_id: user_id },
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
              window.location.href = "customers.php";
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
  
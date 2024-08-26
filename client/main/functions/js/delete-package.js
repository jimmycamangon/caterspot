$(document).ready(function () {
  // Delete button click event
  $(".btn-get-del").click(function () {
    var packageId = $(this).data("package-id");

    // AJAX call to check if there are existing data associated with the package ID
    $.ajax({
      url: "functions/check-existing-package.php",
      method: "POST",
      data: { package_id: packageId },
      dataType: "json",
      success: function (data) {
        // If there are existing data associated with the package ID
        if (data.exists) {
          $("#messages").html('<div class="alert alert-danger" role="alert">There is an existing item from the menus that is aligned/connected with this package. <a href="menus.php">View Lists</a></div>');
          $("#conformeDel").hide();
          $("#returnDel").show();
        } else {
          // Set the package ID for deletion
          $("#confirmDeleteBtn").data("package-id", packageId);
          $("#returnDel").hide();
          $("#conformeDel").show();
          $("#messages").html('Are you sure you want to delete this package?');
          // $("#conformeDel").html('<button type="button" class="btn-get-main" data-dismiss="modal">Cancel</button>');


        }
      },
      error: function (xhr, status, error) {
        // Handle AJAX errors
        console.error(xhr.responseText);
      },
    });
  });

  // Confirm delete button click event
  $("#confirmDeleteBtn").click(function () {
    var packageId = $(this).data("package-id");

    // AJAX call to delete package
    $.ajax({
      url: "functions/delete-package.php",
      method: "POST",
      data: { package_id: packageId },
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
            window.location.href = "packages.php";
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

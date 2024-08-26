$(document).ready(function () {
    $("#submitButton").click(function (event) {
        event.preventDefault(); // Prevent the default form submission
        var form_data = new FormData();
        var client_id = $("#client_id").val(); // Get client_id from hidden field
        var menu_id = $("#menu_id").val();

        // Read selected files
        var files = $("#files")[0].files; // Get the files from the input
        for (var index = 0; index < files.length; index++) {
            form_data.append("files[]", files[index]);
        }

        if (client_id !== "" && menu_id !== "" && files.length > 0) {
            // Append client_id and menu_id to form_data
            form_data.append("client_id", client_id);
            form_data.append("menu_id", menu_id);

            // AJAX request
            $.ajax({
                url: "functions/upload-more-menu-image.php",
                type: "post",
                data: form_data, // Send form_data directly
                contentType: false,
                processData: false,
                dataType: 'json', // Expect JSON response
                success: function (data) {
                    // Handle success response
                    if (data.success) {
                        // Display success message
                        Toastify({
                            text: data.success,
                            backgroundColor: "rgba(31, 166, 49, 0.8)",
                        }).showToast();

                        setTimeout(function () {
                            window.location.href = "other_menus.php";
                        }, 1000);
                    } else {
                        // Display error message
                        $("#MenuMessage").html(
                            '<div class="alert alert-danger" role="alert">' +
                            data.error +
                            "</div>"
                        );
                    }
                },
                error: function (xhr, status, error) {
                    // Handle AJAX errors
                    console.error(xhr.responseText);
                },
            });
        } else {
            // Display a danger alert if any required field is empty
            $("#MenuMessage").html(
                '<div class="alert alert-danger" role="alert">Please select files and fill in all required fields.</div>'
            );
        }
    });



    // DELETE
      // Delete button click event
      $(".btn-get-del").click(function () {
        var uniq_id = $(this).data("menu-id");
    
        // Set the menu id for deletion
        $("#confirmDeleteBtn").data("menu-id", uniq_id);
    
        // Show delete confirmation modal
        $("#deleteConfirmationModal").modal("show");
      });
    
      // Confirm delete button click event
      $("#confirmDeleteBtn").click(function () {
        var uniq_id = $(this).data("menu-id");
    
        // AJAX call to delete menu
        $.ajax({
            url: "functions/delete-other-menu-image.php",
          method: "POST",
          data: { uniq_id: uniq_id },
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
                window.location.href = "other_menus.php";
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

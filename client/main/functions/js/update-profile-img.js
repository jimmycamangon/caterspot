$(document).ready(function () {
    var client_id; 
  
    // Edit button click event
    $(".edit-profile").click(function () {
      // Retrieve client_id from the edit button's data attribute
      client_id = $(this).data("profile-id");
    });
  
    // Save changes button click event
    $("#saveChangesBtn_profile").click(function () {

      var fileInput = document.getElementById("edit_profile_image");
      var client_image = "";
  
      // Check if a file is selected
      if (fileInput.files.length > 0) {
        // Extract only the filename if a file is selected
        client_image = fileInput.files[0].name;
      }
  
      // AJAX call to update package
      $.ajax({
        url: "functions/update-profile-img.php",
        method: "POST",
        data: {
          client_id: client_id,
          client_image: client_image,
        },
        dataType: "json",
        success: function (data) {
          // Handle success response
          if (data.msg) {
            // Display the error message in the #editMessage div
            $("#editMessage").html(
              '<div class="alert alert-danger" role="alert">' +
                data.msg +
                "</div>"
            );
          } else if (data.success) {
            Toastify({
              text: data.success,
              backgroundColor: "rgba(31, 166, 49, 0.8)",
            }).showToast();
  
            // package update successful, start image upload
            var formData = new FormData();
            formData.append("file", fileInput.files[0]);
            $.ajax({
              url: "functions/upload-profile-img.php",
              type: "POST",
              data: formData,
              contentType: false,
              processData: false,
              success: function (response) {
                  setTimeout(function () {
                    window.location.href = "profile.php";
                  }, 1000);
              },
              error: function (xhr, status, error) {
                console.error(error);
              },
            });
          }
        },
        error: function (xhr, status, error) {
          // Handle AJAX errors
          console.error(xhr.responseText);
        },
      });
    });
  });
  
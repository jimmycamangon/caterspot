$(document).ready(function () {
  // Function to fetch menu details
  function fetchMenuDetails(menuIdToUpdate) {
    // Retrieve menu details via AJAX
    $.ajax({
      url: "functions/get-menu-details.php",
      method: "POST",
      data: { menu_id: menuIdToUpdate },
      dataType: "json",
      success: function (data) {
        // Populate edit modal with menu details
        $("#edit_package_id").val(data.package_id);
        $("#edit_menu_name").val(data.menu_name);
        $("#edit_menu_description").val(data.menu_description);
        $("#edit_menu_price").val(data.menu_price);

        // Determine the main availability value
        var mainAvailability =
          data.availability == "Available" ? "Available" : "Not available";

        // Generate and append option dynamically
        var option =
          '<option value="' +
          data.availability +
          '">' +
          data.availability +
          "</option>";
        if (data.availability == "Available") {
          option += '<option value="Not available">Not available</option>';
        } else if (data.availability == "Not available") {
          option += '<option value="Available">Available</option>';
        }
        $("#edit_availability").html(option).val(mainAvailability);
      },
      error: function (xhr, status, error) {
        // Handle AJAX errors
        console.error(xhr.responseText);
      },
    });
  }

  // Edit button click event
  $(".edit-btn").click(function () {
    // Retrieve menu_id from the edit button's data attribute
    menuIdToUpdate = $(this).data("menu-id");

    fetchMenuDetails(menuIdToUpdate);
  });

  // Save changes button click event
  $("#saveChangesBtn").click(function () {
    var menuId = menuIdToUpdate;
    var packageId = $("#edit_package_id").val();
    var menuName = $("#edit_menu_name").val();
    var menuDescription = $("#edit_menu_description").val();
    var menuPrice = $("#edit_menu_price").val();
    var availability = $("#edit_availability").val();
    var fileInput = document.getElementById("edit_menu_image");
    var menu_image = "";

    // Check if a file is selected
    if (fileInput.files.length > 0) {
      // Extract only the filename if a file is selected
      menu_image = fileInput.files[0].name;
    }

    if (
      packageId != "" &&
      menuName != "" &&
      menuDescription != "" &&
      menuPrice != ""
    ) {
      // AJAX call to update menu
      $.ajax({
        url: "functions/update-menu.php",
        method: "POST",
        data: {
          menu_id: menuId,
          package_id: packageId,
          menu_name: menuName,
          menu_description: menuDescription,
          menu_price: menuPrice,
          availability: availability,
          menu_image: menu_image,
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

            // Menu update successful, start image upload
            var formData = new FormData();
            formData.append("file", fileInput.files[0]);
            $.ajax({
              url: "functions/upload-menu-image.php",
              type: "POST",
              data: formData,
              contentType: false,
              processData: false,
              success: function (response) {
                setTimeout(function () {
                  window.location.href = "menus.php";
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
    } else {
      // Display a danger alert if any field is empty
      $("#editMessage").html(
        '<div class="alert alert-danger" role="alert">All fields are required</div>'
      );
    }
  });
});

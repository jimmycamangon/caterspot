$(document).ready(function () {
  $("#AddMenu").click(function () {
    var package_id = $("#package_id").val();
    var menu_name = $("#menu_name").val();
    var menu_description = $("#menu_description").val();
    var menu_price = $("#menu_price").val();
    var fileInput = document.getElementById("menu_image");
    var menu_image = "";

    // Check if a file is selected
    if (fileInput.files.length > 0) {
      // Extract only the filename if a file is selected
      menu_image = fileInput.files[0].name;
    }

    var client_id = clientId;

    // Check if a package is selected
    if (package_id != null && package_id != "") {
      // Make sure all fields are filled
      if (menu_name != "" && menu_description != "" && menu_price != "") {
        $.ajax({
          url: "functions/add-menus.php",
          method: "POST",
          data: {
            package_id: package_id,
            menu_name: menu_name,
            menu_description: menu_description,
            menu_price: menu_price,
            client_id: client_id,
            menu_image: menu_image,
          },
          dataType: "json",
          success: function (data) {
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

              // Menu addition successful, start image upload
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
            console.error(xhr.responseText);
          },
        });
      } else {
        $("#message").html(
          '<div class="alert alert-danger" role="alert">All fields are required</div>'
        );
      }
    } else {
      $("#message").html(
        '<div class="alert alert-danger" role="alert">Please select a package</div>'
      );
    }
  });
});

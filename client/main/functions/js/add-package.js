$(document).ready(function () {
  $("#AddPackage").click(function () {
    var package_name = $("#package_name").val();
    var package_desc = $("#package_desc").val();
    var fileInput = document.getElementById("package_image");
    var package_image = "";

    // Check if a file is selected
    if (fileInput.files.length > 0) {
      // Extract only the filename if a file is selected
      package_image = fileInput.files[0].name;
    }

    var client_id = clientId;

      // Make sure all fields are filled
      if (package_name != "" && package_desc != "") {
        $.ajax({
          url: "functions/add-packages.php",
          method: "POST",
          data: {
            package_name: package_name,
            package_desc: package_desc,
            client_id: client_id,
            package_image: package_image,
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
                url: "functions/upload-package-image.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                  setTimeout(function () {
                    window.location.href = "packages.php";
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
  });
});

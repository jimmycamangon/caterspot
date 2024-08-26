$(document).ready(function () {
  // Function to fetch package details
  function fetchPackageDetails(packageIdToUpdate) {
    // Retrieve package details via AJAX
    $.ajax({
      url: "functions/get-package-details.php",
      method: "POST",
      data: { package_id: packageIdToUpdate },
      dataType: "json",
      success: function (data) {
        // Populate edit modal with package details
        $("#edit_package_name").val(data.package_name);
        $("#edit_package_desc").val(data.package_desc);
      },
      error: function (xhr, status, error) {
        // Handle AJAX errors
        console.error(xhr.responseText);
      },
    });
  }

  // Edit button click event
  $(".edit-btn").click(function () {
    // Retrieve package_id from the edit button's data attribute
    packageIdToUpdate = $(this).data("package-id");

    fetchPackageDetails(packageIdToUpdate);
  });

  // Save changes button click event
  $("#saveChangesBtn").click(function () {
    var packageId = packageIdToUpdate;
    var packageName = $("#edit_package_name").val();
    var packageDesc = $("#edit_package_desc").val();
    var fileInput = document.getElementById("edit_package_image");
    var package_image = "";

    // Check if a file is selected
    if (fileInput.files.length > 0) {
      // Extract only the filename if a file is selected
      package_image = fileInput.files[0].name;
    }

    if (packageId != "" && packageName != "" && packageDesc != "") {
        // AJAX call to update package
        $.ajax({
            url: "functions/update-package.php",
            method: "POST",
            data: {
                package_id: packageId,
                package_name: packageName,
                package_desc: packageDesc,
                package_image: package_image,
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

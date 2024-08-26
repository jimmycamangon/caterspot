function upload2() {
  var imgcanvas = document.getElementById("editCanv1");
  var fileinput = document.getElementById("edit_profile_image");
  var image = new SimpleImage(fileinput);
  image.drawTo(imgcanvas);
  document.getElementById("editImagePreviewContainer").style.display = "block"; // Display the image preview container
}

$(document).ready(function () {
  // Function to fetch bg image and display it using canvas
  function fetchBGImage(client_id) {
    // AJAX request to fetch menu image
    $.ajax({
      url: "functions/fetch-profile-img.php",
      method: "POST",
      data: { client_id: client_id },
      dataType: "json",
      success: function (data) {
        // Check if image data is available
        if (data.image_data) {
          // Get canvas element
          var imgcanvas = document.getElementById("editCanv1");
          // Create new image object
          var img = new Image();
          // Set image source data by decoding the base64 encoded string
          img.src = "../../assets/img/client-images/" + atob(data.image_data);
          // Draw image to canvas when it's loaded
          img.onload = function () {
            // Clear canvas
            var ctx = imgcanvas.getContext("2d");
            ctx.clearRect(0, 0, imgcanvas.width, imgcanvas.height);
            // Draw image to canvas
            ctx.drawImage(img, 0, 0, imgcanvas.width, imgcanvas.height);
            // Display image preview container
            $("#editImagePreviewContainer").show();
          };
        } else {
          // Hide image preview container if no image data is available
          $("#editImagePreviewContainer").hide();
        }
      },
      error: function (xhr, status, error) {
        console.error(error);
      },
    });
  }

  // Edit button click event
  $(".edit-profile").click(function () {
    // Retrieve client_id from the edit button's data attribute
    var client_id = $(this).data("profile-id");
    // Fetch package image
    fetchBGImage(client_id);

  });

});

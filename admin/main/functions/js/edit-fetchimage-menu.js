function upload2() {
    var imgcanvas = document.getElementById("editCanv1");
    var fileinput = document.getElementById("edit_menu_image");
    var image = new SimpleImage(fileinput);
    image.drawTo(imgcanvas);
    document.getElementById("editImagePreviewContainer").style.display = "block"; // Display the image preview container
  }

  
$(document).ready(function () {
  // Function to fetch menu image and display it using canvas
  function fetchMenuImage(menu_id) {
    // AJAX request to fetch menu image
    $.ajax({
      url: "functions/fetch-menu-image.php",
      method: "POST",
      data: { menu_id: menu_id },
      dataType: "json",
      success: function (data) {
        // Check if image data is available
        if (data.image_data) {
          // Get canvas element
          var imgcanvas = document.getElementById("editCanv1");
          // Create new image object
          var img = new Image();
          // Set image source data by decoding the base64 encoded string
          img.src = "../../assets/img/menu-uploads/" + atob(data.image_data);
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
  $(".edit-btn").click(function () {
    // Retrieve menu_id from the edit button's data attribute
    var menu_id = $(this).data("menu-id");

    // Fetch menu image
    fetchMenuImage(menu_id);
  });


});

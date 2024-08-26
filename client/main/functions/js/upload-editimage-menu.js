function upload2() {
    var imgcanvas = document.getElementById("editCanv1");
    var fileinput = document.getElementById("edit_menu_image");
    var image = new SimpleImage(fileinput);
    image.drawTo(imgcanvas);
    document.getElementById("editImagePreviewContainer").style.display = "block"; // Display the image preview container
  }


  $(document).ready(function () {
    $("#AddMenu").click(function () {
        var fileinput = document.getElementById("editImagePreviewContainer");
        // Get the file data
        var file = fileinput.files[0];
        var formData = new FormData();
        formData.append("file", file);
    
        // Send the file data to the server
        $.ajax({
          url: "functions/upload-menu-image.php",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            // console.log(response);
          },
          error: function (xhr, status, error) {
            console.error(error);
          },
        });
      });
  });
  
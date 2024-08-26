function upload() {
  var imgcanvas = document.getElementById("canv1");
  var fileinput = document.getElementById("menu_image");
  var image = new SimpleImage(fileinput);
  image.drawTo(imgcanvas);
  document.getElementById("imagePreviewContainer").style.display = "block"; // Display the image preview container
}


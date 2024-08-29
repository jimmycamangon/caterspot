$(document).ready(function () {
  $('button[type="submit"]').click(function (e) {
    e.preventDefault(); // Prevent form submission

    // Reset any previous messages
    $("#vendor_message").html(
      '<div class="alert alert-info">Submitting Application...</div>'
    );

    // Create FormData object to hold form data including files
    var formData = new FormData(document.getElementById("vendorForm"));

    // Check if any field is empty
    if (
      $("#business_name").val() === "" ||
      $("#owner").val() === "" ||
      $("#contact_number").val() === "" ||
      $("#gmail").val() === "" ||
      $("#edit_region").val() === "" ||
      $("#edit_province").val() === "" ||
      $("#edit_city").val() === "" ||
      $("#street").val() === "" ||
      $("#permit").val() === "" ||
      $("#menu").val() === "" ||
      $("#business_img").val() === ""
    ) {
      $("#vendor_message").html(
        '<div class="alert alert-danger">All fields are required.</div>'
      );
      return;
    }

    // If all fields are filled, make AJAX request
    $.ajax({
      url: "functions/vendor-message.php",
      type: "POST",
      data: formData,
      processData: false, // Important!
      contentType: false, // Important!
      success: function (response) {
        // Display success message
        $("#vendor_message").html(
          '<div class="alert alert-success">Application Form has been sent successfully!</div>'
        );
        // Clear form fields
        $("#vendorForm").trigger("reset");
      },
      error: function (xhr, status, error) {
        // Display error message
        $("#vendor_message").html(
          '<div class="alert alert-danger">Error: ' + error + "</div>"
        );
      },
    });
  });
});



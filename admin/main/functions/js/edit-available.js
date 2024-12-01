$(document).ready(function () {
    // Function to fetch  status
    function fetchStatus(IdToUpdate) {
        // Retrieve status via AJAX
        $.ajax({
          url: "functions/get-available.php",
          method: "POST",
          data: { client_id: IdToUpdate },
          dataType: "json",
          success: function (data) {
            // Determine the main status value
            var status = data.status === "Available" ? "Unavailable" : "Available"; // Toggle between Paid and Not Paid
      
            // Check for blank or Not Paid status and set it to Paid
            if (data.status === "" || data.status === "Unavailable") {
              status = "Unavailable";
            } else if (data.status === "Available") {
              status = "Available";
            }
      
            // Generate and append option dynamically
            var option =
              '<option value="' + status + '">' + status + "</option>";
            if (status === "Available") {
              option += '<option value="Unavailable">Unavailable</option>';
            } else {
              option += '<option value="Available">Available</option>';
            }
      
            $("#edit_status").html(option).val(status);
          },
          error: function (xhr, status, error) {
            // Handle AJAX errors
            console.error(xhr.responseText);
          },
        });
      }
      
  
    // Edit button click event
    $(".edit-btn").click(function () {
      // Retrieve status_id from the edit button's data attribute
      statusIdToUpdate = $(this).data("status-id");
  
      fetchStatus(statusIdToUpdate);
    });
  
// Save changes button click event
$("#saveChangesBtn").click(function () {
    var statusId = statusIdToUpdate;
    var status = $("#edit_status").val();
  
    if (status != "") {
      // AJAX call to update status
      $.ajax({
        url: "functions/update-available.php",
        method: "POST",
        data: {
         client_id: statusId,
          status: status,
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
  
            // Get the current URL and redirect to it
            var currentUrl = window.location.href;
            setTimeout(function () {
              window.location.href = currentUrl;
            }, 1000);
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
  
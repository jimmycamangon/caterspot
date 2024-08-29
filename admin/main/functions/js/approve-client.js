function approveApplication(client_id) {
    var submitBtn = document.getElementById("confirmApprove");
  
    submitBtn.disabled = true; // Disable the submit button
    submitBtn.style.opacity = 0.5; // Change button opacity
    submitBtn.style.cursor = "wait"; // Change cursor to not allowed
  
    $.ajax({
      url: "functions/approve-client.php",
      type: "POST",
      data: { client_id: client_id, status: "Approved" },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.success) {
          Toastify({
            text: data.success,
            backgroundColor: "rgba(31, 166, 49, 0.8)",
          }).showToast();
  
          setTimeout(function () {
            // Redirect to reservation-details.php upon successful update
            window.location.href =
              "view-applications.php?client_id=" + client_id;
          }, 1000);
        } else {
          console.error("Error updating status:", data.error);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error updating status:", error);
      },
    });
  }
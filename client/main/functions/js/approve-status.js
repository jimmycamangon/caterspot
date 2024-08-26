function approveReservation(transactionNo) {
  var submitBtn = document.getElementById("saveChangesBtn");

  submitBtn.disabled = true; // Disable the submit button
  submitBtn.style.opacity = 0.5; // Change button opacity
  submitBtn.style.cursor = "wait"; // Change cursor to not allowed

  $.ajax({
    url: "functions/update-approve-status.php",
    type: "POST",
    data: { transactionNo: transactionNo, status: "Booked" },
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
            "reservation-details.php?transactionNo=" + transactionNo;
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


function approveCancellation(transactionNo) {
  var approveBtnConf = document.getElementById("approveBtn");

  approveBtnConf.disabled = true; // Disable the submit button
  approveBtnConf.style.opacity = 0.5; // Change button opacity
  approveBtnConf.style.cursor = "wait"; // Change cursor to not allowed
  
  $.ajax({
    url: "functions/update-approve-status.php",
    type: "POST",
    data: { transactionNo: transactionNo, status: "Request cancellation approved." },
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
            "reservation-details.php?transactionNo=" + transactionNo;
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

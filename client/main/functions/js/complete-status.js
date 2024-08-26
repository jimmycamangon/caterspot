function completeReservation(transactionNo, client_id, tax, user_id, total_price) {

    var submitBtn = document.getElementById("completeBtn");

    submitBtn.disabled = true; // Disable the submit button
    submitBtn.style.opacity = 0.5; // Change button opacity
    submitBtn.style.cursor = "wait"; // Change cursor to not allowed


    // Get the balance_paid value from the HTML input, or set it to 0 if it doesn't exist
    var balance_paid_input = document.getElementById('balance_paid');
    var balance_paid = balance_paid_input ? balance_paid_input.value : 0;

    $.ajax({
        url: "functions/update-complete-status.php",
        type: "POST",
        data: {
            transactionNo: transactionNo,
            status: "Completed",
            client_id: client_id,
            tax: tax,
            user_id: user_id,
            total_price: total_price,
            balance_paid: balance_paid
        },
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

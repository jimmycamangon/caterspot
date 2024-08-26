function markAsRead(transactionNo) {
    // Send an AJAX request to update the is_read field
    $.ajax({
        url: 'functions/update-is-read.php',
        type: 'GET',
        data: { transactionNo: transactionNo },
        success: function(response) {
            // Reload the page after the AJAX request completes
            window.location.href = 'reservation-details.php?transactionNo=' + transactionNo;
        },
        error: function(xhr, status, error) {
            console.error('Error updating is_read status:', error);
        }
    });
}
document.addEventListener("DOMContentLoaded", function () {
  // Function to calculate average star rating
  function calculateAverageRating(feedbackData) {
    if (feedbackData.length === 0) {
      return "No"; // Return message indicating no rates available
    }

    let totalRating = 0;
    for (let i = 0; i < feedbackData.length; i++) {
      totalRating += parseInt(feedbackData[i].rate);
    }
    const averageRating = totalRating / feedbackData.length;
    return averageRating.toFixed(1); // Return average rating with one decimal place
  }

  // Fetch feedback data from the server
  fetch("functions/fetch_feedback.php?client_id=" + clientId) // Pass client_id as a query parameter
    .then((response) => response.json())
    .then((data) => {
      // Calculate average rating or display message if no rates available
      const averageRating = calculateAverageRating(data);
      document.getElementById("average-rating").innerHTML =
        '<span id="star" style="color: black;">★</span>' + averageRating + ' Ratings';

      document.getElementById("average-rating-mini").innerHTML = '<span id="star-2">⭐️</span>' +  averageRating + ' Ratings';
    })
    .catch((error) => console.error("Error fetching feedback:", error));
});

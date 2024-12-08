// Function to generate random colors for the chart
function generateRandomColors(count) {
    const colors = [];
    for (let i = 0; i < count; i++) {
        const r = Math.floor(Math.random() * 256);
        const g = Math.floor(Math.random() * 256);
        const b = Math.floor(Math.random() * 256);
        colors.push(`rgba(${r}, ${g}, ${b}, 0.6)`); // Slightly higher transparency
    }
    return colors;
}

// Function to fetch top cater ratings with date filters
function fetchTopCaterRatings() {
    const startDate = encodeURIComponent(document.querySelector('input[name="start_date"]').value);
    const endDate = encodeURIComponent(document.querySelector('input[name="end_date"]').value);
    const url = `functions/chart-functions/fetch-top_ratings.php?start_date=${startDate}&end_date=${endDate}`;
    return fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        });
}

// Function to populate the ratings chart
function populateRatingsChart(data) {
    // Extract data for labels and datasets
    const labels = data.map(entry => entry.username);
    const ratingsData = data.map(entry => parseFloat(entry.average_rating));

    // Generate random colors for the chart
    const backgroundColors = generateRandomColors(data.length);

    // Prepare the data for the chart
    const chartData = {
        labels: labels,
        datasets: [{
            label: 'Average Rating',
            backgroundColor: backgroundColors,
            data: ratingsData,
        }],
    };

    // Populate the chart
    const ctx = document.getElementById('topCaterChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie', // Changed from 'bar' to 'pie'
        data: chartData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    enabled: true,
                },
            },
        },
    });
}

// Function to handle chart updates on filter form submission
function updateRatingsChart() {
    fetchTopCaterRatings()
        .then(data => populateRatingsChart(data))
        .catch(error => console.error('Error fetching top cater ratings:', error));
}

// Add event listener to the filter form
document.querySelector('form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission
    updateRatingsChart(); // Update the chart with the filtered data
});

// Initial load of the chart
updateRatingsChart();

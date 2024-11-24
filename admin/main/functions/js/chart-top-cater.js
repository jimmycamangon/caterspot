// Function to generate random colors for the chart
function generateRandomColors(count) {
    const colors = [];
    for (let i = 0; i < count; i++) {
        const r = Math.floor(Math.random() * 256);
        const g = Math.floor(Math.random() * 256);
        const b = Math.floor(Math.random() * 256);
        colors.push(`rgba(${r}, ${g}, ${b}, 0.2)`); // Background color with transparency
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

    // Calculate the maximum rating value
    const maxRating = Math.max(...ratingsData);

    // Adjust the max value (round up to next whole number for a cleaner scale)
    const adjustedMax = Math.ceil(maxRating);

    // Generate random colors for the chart
    const backgroundColors = generateRandomColors(data.length);
    const borderColors = backgroundColors.map(color => color.replace('0.2', '1')); // Higher opacity for borders

    // Prepare the data for the chart
    const chartData = {
        labels: labels,
        datasets: [{
            label: 'Average Rating',
            backgroundColor: backgroundColors,
            borderColor: borderColors,
            borderWidth: 1,
            data: ratingsData,
        }],
    };

    // Populate the chart
    const ctx = document.getElementById('topCaterChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                },
                tooltip: {
                    enabled: true,
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Caterers',
                    },
                },
                y: {
                    beginAtZero: true,
                    max: adjustedMax,  // Dynamically adjust max value based on the data
                    title: {
                        display: true,
                        text: 'Average Rating',
                    },
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

// Function to fetch data from PHP script
function fetchDataForBarChart() {
    const url = `functions/chart-functions/fetch-revenue-permonth.php?start_date=${encodeURIComponent(document.querySelector('input[name="start_date"]').value)}&end_date=${encodeURIComponent(document.querySelector('input[name="end_date"]').value)}`;
    return fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        });
}

// Function to populate the bar chart
function populateBarChart(data) {
    // Extract data for labels and datasets
    const labels = data.map(entry =>  entry.month);
    const revenueData = data.map(entry => entry.total_revenue);

    // Calculate the max value from the revenueData
    const maxRevenue = Math.max(...revenueData);

    // Determine the adjusted max value (round it up to the next highest value)
    const adjustedMax = Math.ceil(maxRevenue * 1.1);  // Increase by 20% for extra space above the highest value

    // Prepare the data for the bar chart
    const chartData = {
        labels: labels,
        datasets: [{
            label: "Revenue",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: revenueData, // Use fetched revenue data here
        }],
    };

    // Populate the bar chart
    const ctx = document.getElementById('myBarChart').getContext('2d');
    const myBarChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            scales: {
                xAxes: [{
                    time: {
                        unit: 'month'
                    },
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: adjustedMax, // Dynamically adjust max value based on the data
                        maxTicksLimit: 5
                    },
                    gridLines: {
                        display: true
                    }
                }],
            },
            legend: {
                display: false
            }
        }
    });
}

// Fetch data from PHP script and populate the bar chart
fetchDataForBarChart()
    .then(data => populateBarChart(data))
    .catch(error => console.error('Error fetching data for bar chart:', error));

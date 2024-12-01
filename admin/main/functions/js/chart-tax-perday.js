// Function to fetch data from PHP script
function fetchDataFromPHP() {
    const url = `functions/chart-functions/fetch-tax-perday.php?start_date=${encodeURIComponent(document.querySelector('input[name="start_date"]').value)}&end_date=${encodeURIComponent(document.querySelector('input[name="end_date"]').value)}`;
    return fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        });
}

// Function to populate the chart
function populateChart(data) {
    // Extract data for labels and datasets
    const labels = data.map(entry => entry.date_collected); // Use the actual date for labels
    const taxData = data.map(entry => entry.total_tax);

    // Calculate the max value from the taxData
    const maxTax = Math.max(...taxData);

    // Determine the adjusted max value (round it up to the next highest value, e.g., 80000, 2000000, etc.)
    const adjustedMax = Math.ceil(maxTax * 1.1);  // Increase by 10% as an example

    // Prepare the data for the chart
    const chartData = {
        labels: labels,
        datasets: [{
            label: 'Tax collected',
            lineTension: 0.3,
            backgroundColor: 'rgba(2,117,216,0.2)',
            borderColor: 'rgba(2,117,216,1)',
            pointRadius: 5,
            pointBackgroundColor: 'rgba(2,117,216,1)',
            pointBorderColor: 'rgba(255,255,255,0.8)',
            pointHoverRadius: 5,
            pointHoverBackgroundColor: 'rgba(2,117,216,1)',
            pointHitRadius: 50,
            pointBorderWidth: 2,
            data: taxData,
        }],
    };

    // Populate the chart
    const ctx = document.getElementById('myAreaChart').getContext('2d');
    const myLineChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: adjustedMax, // Dynamically adjust max value
                        maxTicksLimit: 5
                    },
                    gridLines: {
                        color: 'rgba(0, 0, 0, .125)',
                    }
                }],
            },
            legend: {
                display: false
            }
        }
    });
}

// Fetch data from PHP script and populate the chart
fetchDataFromPHP()
    .then(data => populateChart(data))
    .catch(error => console.error('Error fetching data:', error));

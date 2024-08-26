

// Function to fetch data from PHP script
function fetchDataFromPHP() {
    const url = `functions/chart-functions/fetch-revenue-perday.php?start_date=${encodeURIComponent(document.querySelector('input[name="start_date"]').value)}&end_date=${encodeURIComponent(document.querySelector('input[name="end_date"]').value)}`;
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
    const labels = data.map(entry => 'Day ' + entry.day);
    const taxData = data.map(entry => entry.total_revenue);
  
    // Prepare the data for the chart
    const chartData = {
        labels: labels,
        datasets: [{
            label: 'Revenue',
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
                        max: 80000,
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
  
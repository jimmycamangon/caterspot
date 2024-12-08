// Function to generate random colors for the chart
function generateRandomColors(count, highlightIndex = null) {
    const colors = [];
    for (let i = 0; i < count; i++) {
        if (i === highlightIndex) {
            colors.push('rgba(255, 99, 132, 0.8)'); // Highlighted color (red)
        } else {
            const r = Math.floor(Math.random() * 256);
            const g = Math.floor(Math.random() * 256);
            const b = Math.floor(Math.random() * 256);
            colors.push(`rgba(${r}, ${g}, ${b}, 0.6)`); // Background color with transparency
        }
    }
    return colors;
}

// Function to fetch top contributors with date filters
function fetchTopContributors() {
    const startDate = encodeURIComponent(document.querySelector('input[name="start_date"]').value || '');
    const endDate = encodeURIComponent(document.querySelector('input[name="end_date"]').value || '');
    const url = `functions/chart-functions/fetch-top-contributors.php?start_date=${startDate}&end_date=${endDate}`;
    return fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        });
}

// Function to populate the contributors chart
function populateContributorsChart(data) {
    if (!data || data.length === 0) {
        console.warn('No data available to populate the chart.');
        return;
    }

    // Extract data for labels and datasets
    const labels = data.map(entry => entry.cater_name || 'Unknown'); // Use cater_name for labels
    const revenueData = data.map(entry => parseFloat(entry.total_revenue));

    // Find the least contributor
    const minIndex = revenueData.indexOf(Math.min(...revenueData));
    const leastContributor = labels[minIndex];
    const leastRevenue = revenueData[minIndex];
    console.log(`Least Contributor: ${leastContributor}, Revenue: ${leastRevenue}`);

    // Generate colors, highlighting the least contributor
    const backgroundColors = generateRandomColors(data.length, minIndex);

    // Prepare the data for the chart
    const chartData = {
        labels: labels,
        datasets: [{
            label: 'Total Revenue',
            data: revenueData,
            backgroundColor: backgroundColors,
        }],
    };

    // Populate the chart
    const ctx = document.getElementById('topContributor').getContext('2d');
    new Chart(ctx, {
        type: 'polarArea',
        data: chartData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        afterBody: (tooltipItems) => {
                            const index = tooltipItems[0].dataIndex;
                            if (index === minIndex) {
                                return 'Least Contributor';
                            }
                            return null;
                        },
                    },
                },
            },
            scales: {
                r: {
                    ticks: {
                        beginAtZero: true,
                    },
                    title: {
                        display: true,
                        text: 'Total Revenue',
                    },
                },
            },
        },
    });

    // Display least contributor in the UI
    const leastContributorEl = document.getElementById('leastContributor');
    if (leastContributorEl) {
        leastContributorEl.textContent = `Least Contributor: ${leastContributor} with revenue ${leastRevenue.toFixed(2)}`;
    }
}

// Function to handle chart updates on filter form submission
function updateContributorsChart() {
    fetchTopContributors()
        .then(data => populateContributorsChart(data))
        .catch(error => console.error('Error fetching top contributors:', error));
}

// Add event listener to the filter form
document.querySelector('form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission
    updateContributorsChart(); // Update the chart with the filtered data
});

// Initial load of the chart
updateContributorsChart();

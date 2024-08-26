// Function to fetch data based on date range
function fetchDataWithDateRange(startDate, endDate) {
    return fetch(`index.php?start_date=${startDate}&end_date=${endDate}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        });
}



// Function to update dashboard elements with new data
function updateDashboard(data) {
    // Update card elements
    document.querySelector('#pendingCount').textContent = data.pending_count;
    document.querySelector('#approvedCount').textContent = data.approved_count;
    document.querySelector('#completedCount').textContent = data.completed_count;
    document.querySelector('#rejectedCount').textContent = data.rejected_count;

    // Update feedbacks table
    const feedbacksTableBody = document.querySelector('#datatablesSimple tbody');
    feedbacksTableBody.innerHTML = '';
    data.feedback.forEach(feedback => {
        const row = `<tr>
                        <td>${feedback.firstname} ${feedback.lastname}</td>
                        <td>${feedback.cater_name}</td>
                        <td>${feedback.comment}</td>
                        <td>${feedback.rate}</td>
                        <td>${feedback.createdAt}</td>
                    </tr>`;
        feedbacksTableBody.innerHTML += row;
    });

    // Update charts if needed
    // Example: populateChart(data.revenue_per_day);
    // Example: populateBarChart(data.revenue_per_month);
}


// Event listener for filter button click
document.getElementById('filterButton').addEventListener('click', function() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    fetchDataWithDateRange(startDate, endDate)
        .then(data => {
            updateDashboard(data);
        })
        .catch(error => console.error('Error fetching data:', error));
});

// Initial fetch of data when page loads (optional)
document.addEventListener('DOMContentLoaded', function() {
    // You can set default date range here if needed
    // const defaultStartDate = '2024-06-01';
    // const defaultEndDate = '2024-06-30';

    // fetchDataWithDateRange(defaultStartDate, defaultEndDate)
    //     .then(data => {
    //         updateDashboard(data);
    //     })
    //     .catch(error => console.error('Error fetching initial data:', error));
});

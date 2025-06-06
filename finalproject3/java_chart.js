fetch('chart_data.php')
    .then(res => res.json())
    .then(response => {
        const ctx = document.getElementById('myChart').getContext('2d');

        const data = {
            labels: response.labels,
            datasets: [{
                label: 'Inventory by Category',
                data: response.data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'pie',
            data: data
        };

        new Chart(ctx, config);
    })
    .catch(err => console.error("Failed to load chart data:", err));

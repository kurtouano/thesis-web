<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RVM Data Chart</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 50px;
    }
    #chart-container {
      width: 1200px;
      height: 800px;
    }
    select {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

  <h2>Recycling Data</h2>
  <!-- Dropdown to choose between daily or monthly -->
  <select id="view-selector">
    <option value="daily">Daily</option>
    <option value="monthly">Monthly</option>
  </select>

  <!-- Canvas element for the chart -->
  <div id="chart-container">
    <canvas id="rvmChart"></canvas>
  </div>

  <script>
    // Get the context of the canvas
    const ctx = document.getElementById('rvmChart').getContext('2d');

    // Datasets for daily and monthly views
    const dailyData = {
      labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],
      datasets: [
        {
          label: 'Plastic Bottles',
          data: [12, 15, 8, 10, 6, 9, 14],
          backgroundColor: 'rgba(54, 162, 235, 0.5)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        },
        {
          label: 'Glass Bottles',
          data: [5, 7, 3, 4, 6, 2, 8],
          backgroundColor: 'rgba(255, 99, 132, 0.5)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1
        },
        {
          label: 'Aluminum Cans',
          data: [9, 10, 12, 5, 8, 11, 7],
          backgroundColor: 'rgba(255, 206, 86, 0.5)',
          borderColor: 'rgba(255, 206, 86, 1)',
          borderWidth: 1
        }
      ]
    };

    const monthlyData = {
      labels: ['January', 'February', 'March', 'April', 'May', 'June'],
      datasets: [
        {
          label: 'Plastic Bottles',
          data: [100, 120, 130, 140, 90, 110],
          backgroundColor: 'rgba(54, 162, 235, 0.5)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        },
        {
          label: 'Glass Bottles',
          data: [60, 80, 70, 90, 50, 65],
          backgroundColor: 'rgba(255, 99, 132, 0.5)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1
        },
        {
          label: 'Aluminum Cans',
          data: [85, 95, 105, 110, 75, 80],
          backgroundColor: 'rgba(255, 206, 86, 0.5)',
          borderColor: 'rgba(255, 206, 86, 1)',
          borderWidth: 1
        }
      ]
    };

    // Initial chart
    let rvmChart = new Chart(ctx, {
      type: 'bar', // Bar chart
      data: dailyData,
      options: {
        scales: {
          y: {
            beginAtZero: true // Start Y-axis at 0
          }
        }
      }
    });

    // Update chart based on selected option
    const viewSelector = document.getElementById('view-selector');
    viewSelector.addEventListener('change', function() {
      const selectedView = this.value;

      // Destroy the old chart instance before creating a new one
      rvmChart.destroy();

      // Create a new chart with the selected data
      rvmChart = new Chart(ctx, {
        type: 'bar',
        data: selectedView === 'daily' ? dailyData : monthlyData,
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    });
  </script>

</body>
</html>

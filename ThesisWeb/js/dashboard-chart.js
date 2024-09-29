var bar_xValues = {
    week: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
    month: ["Week 1", "Week 2", "Week 3", "Week 4"],
    year: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
  };
  
  var bar_values = {
    plastic: {
        week: [10, 12, 8, 14, 16, 9, 13],
        month: [50, 70, 60, 80],
        year: [1200, 1100, 1300, 1400, 1500, 1600, 1700, 1800, 1900, 2000, 2100, 2200]
    },
    glass: {
        week: [5, 6, 5, 10, 7, 5, 6],
        month: [20, 30, 25, 35],
        year: [500, 450, 600, 550, 700, 650, 800, 750, 900, 850, 1000, 950]
    },
    aluminum: {
        week: [7, 8, 5, 9, 10, 6, 7],
        month: [25, 35, 30, 45],
        year: [800, 700, 900, 850, 1000, 950, 1100, 1050, 1200, 1150, 1300, 1250]
    }
  };
  
  var currentPeriod = 'week'; // Default period
  updateBarChart();
  
  function updateBarChart() {
    var selectedPeriod = bar_xValues[currentPeriod];
    var plasticData = bar_values.plastic[currentPeriod];
    var glassData = bar_values.glass[currentPeriod];
    var aluminumData = bar_values.aluminum[currentPeriod];
  
    // Check if myBarChart exists and has a destroy method
    if (window.myBarChart && typeof window.myBarChart.destroy === 'function') {
        window.myBarChart.destroy();
    }
  
    // Create new bar chart
    window.myBarChart = new Chart("myBarChart", {
        type: "bar",
        data: {
            labels: selectedPeriod,
            datasets: [
                {
                    label: "Plastic",
                    backgroundColor: "#1D7031",
                    data: plasticData
                },
                {
                    label: "Glass",
                    backgroundColor: "#3ABF5D",
                    data: glassData
                },
                {
                    label: "Aluminum",
                    backgroundColor: "#93cb8b",
                    data: aluminumData
                }
            ]
        },
        options: {
            title: {
                display: true,
                text: "Total Materials for the " + currentPeriod.charAt(0).toUpperCase() + currentPeriod.slice(1)
            },
            legend: {
              display: true,
              position: 'top' // Move the legend to the top
            },
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
  
    // Update the pie chart
    var totalPlastic = plasticData.reduce((a, b) => a + b, 0);
    var totalGlass = glassData.reduce((a, b) => a + b, 0);
    var totalAluminum = aluminumData.reduce((a, b) => a + b, 0);
  
    var pie_yValues = [totalPlastic, totalGlass, totalAluminum]; // New pie values based on total of the current period
  
    // Check if myPieChart exists and has a destroy method
    if (window.myPieChart && typeof window.myPieChart.destroy === 'function') {
        window.myPieChart.destroy();
    }
  
    // Create new pie chart
    window.myPieChart = new Chart("myPieChart", {
        type: "pie",
        data: {
            labels: ["Plastic", "Glass", "Aluminum"],
            datasets: [{
                backgroundColor: ["#1D7031", "#3ABF5D", "#93cb8b"],
                data: pie_yValues
            }]
        },
        options: {
            title: {
                display: true,
                text: "Total Materials for the " + currentPeriod.charAt(0).toUpperCase() + currentPeriod.slice(1)
            }
        }
    });
  }
  
  // Function to handle dropdown change
  function changePeriod(period) {
    currentPeriod = period;
    updateBarChart();
  }
  
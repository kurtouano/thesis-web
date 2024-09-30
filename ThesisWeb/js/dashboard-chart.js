

        var bar_xValues = {
            week: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            month: ["Week 1", "Week 2", "Week 3", "Week 4"],
            year: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
        };

        var bar_values = {
            plastic: {
                week: [],
                month: [],
                year: []
            },
            glass: {
                week: [],
                month: [],
                year: []
            },
            aluminum: {
                week: [],
                month: [],
                year: []
            }
        };

        var currentPeriod = 'week'; // Default period
        updateBarChart();

        fetch('/ThesisWeb/require/dashboard-chart-render.php')
            .then(response => response.json())
            .then(data => {
                // Fill bar_values with fetched data
                bar_values.plastic.week = data.week['Plastic'] || [];
                bar_values.glass.week = data.week['Glass'] || [];
                bar_values.aluminum.week = data.week['Aluminum'] || [];
                
                bar_values.plastic.month = data.month['Plastic'] || [];
                bar_values.glass.month = data.month['Glass'] || [];
                bar_values.aluminum.month = data.month['Aluminum'] || [];
                
                bar_values.plastic.year = data.year['Plastic'] || [];
                bar_values.glass.year = data.year['Glass'] || [];
                bar_values.aluminum.year = data.year['Aluminum'] || [];

                // Update the chart after fetching data
                updateBarChart();
            })
            .catch(error => console.error('Error fetching data:', error));

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
                }
            });
        }

        // Function to handle dropdown change
        function changePeriod(period) {
            currentPeriod = period;
            updateBarChart();
        }

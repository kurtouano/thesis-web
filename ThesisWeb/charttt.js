var bar_xValues = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
var bar_plasticValues = [10, 12, 8, 14, 16, 9, 13]; // Example data for plastic
var bar_glassValues = [5, 6, 5, 10, 7, 5, 6]; // Example data for glass
var bar_aluminumValues = [7, 8, 5, 9, 10, 6, 7]; // Example data for aluminum

new Chart("myBarChart", {
  type: "bar",
  data: {
    labels: bar_xValues,
    datasets: [
      {
        label: "Plastic",
        backgroundColor: "#1D7031",
        data: bar_plasticValues
      },
      {
        label: "Glass",
        backgroundColor: "#3ABF5D",
        data: bar_glassValues
      },
      {
        label: "Aluminum",
        backgroundColor: "#A8D6A0",
        data: bar_aluminumValues
      }
    ]
  },
  options: {
    title: {
      display: true,
      text: "Total Materials for the Past 7 Days",

    },

    scales: {
      x: {
        stacked: true // Stacks the bars side by side for each day
      },
      y: {
        beginAtZero: true
      }
    }
  }
});

var pie_xValues = ["Plastic", "Glass", "Aluminum"];
var pie_yValues = [55, 49, 44];
var pie_barColors = [
  "#1D7031",
  "#3ABF5D",
  "#A8D6A0",
  "#e8c3b9",
  "#1e7145"
];

new Chart("myPieChart", {
  type: "pie",
  data: {
    labels: pie_xValues,
    datasets: [{
      backgroundColor: pie_barColors,
      data: pie_yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Total Materials for the Month"
    }
  }
});
<?php

require 'dbconf.php';

// Get year parameter from query string, default to current year if not provided
$year = isset($_GET['year']) ? intval($_GET['year']) : date("Y");

// Query for the last 7 days
$weekQuery = "
    SELECT SUM(pet_quantity) AS plastic, SUM(glass_quantity) AS glass, SUM(aluminum_quantity) AS aluminum, DATE(timestamp) AS day
    FROM transaction_records
    WHERE timestamp >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
    GROUP BY day
    ORDER BY day
";

// Query for the selected year's monthly data
$yearQuery = "
    SELECT SUM(pet_quantity) AS plastic, SUM(glass_quantity) AS glass, SUM(aluminum_quantity) AS aluminum, MONTH(timestamp) AS month 
    FROM transaction_records 
    WHERE YEAR(timestamp) = $year 
    GROUP BY month
";

// Execute the queries
$weekResult = $conn->query($weekQuery);
$yearResult = $conn->query($yearQuery);

// Initialize arrays to hold data
$weekData = [
    'PET' => [],
    'Glass' => [],
    'Aluminum' => []
];

$yearData = [
    'PET' => array_fill(0, 12, 0), // Initialize all months to 0
    'Glass' => array_fill(0, 12, 0),
    'Aluminum' => array_fill(0, 12, 0)
];

// Create an array for the last 7 days
$last7Days = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days")); // Get the date for the last 7 days
    $last7Days[$date] = ['PET' => 0, 'Glass' => 0, 'Aluminum' => 0]; // Default to 0
}

// Fetch weekly data and populate the last7Days array
while ($row = $weekResult->fetch_assoc()) {
    $day = $row['day'];
    if (isset($last7Days[$day])) {
        $last7Days[$day] = [
            'PET' => (int)$row['plastic'],
            'Glass' => (int)$row['glass'],
            'Aluminum' => (int)$row['aluminum']
        ];
    }
}

// Extract structured data for the week chart
foreach ($last7Days as $dayData) {
    $weekData['PET'][] = $dayData['PET'];
    $weekData['Glass'][] = $dayData['Glass'];
    $weekData['Aluminum'][] = $dayData['Aluminum'];
}

// Fetch yearly data and place it in the appropriate month index (0-based for Jan to Dec)
while ($row = $yearResult->fetch_assoc()) {
    $monthIndex = (int)$row['month'] - 1; // Convert 1-based month to 0-based index
    $yearData['PET'][$monthIndex] = (int)$row['plastic'];
    $yearData['Glass'][$monthIndex] = (int)$row['glass'];
    $yearData['Aluminum'][$monthIndex] = (int)$row['aluminum'];
}

// Close the database connection
$conn->close();

// Return data as JSON
echo json_encode([
    'week' => $weekData,
    'year' => $yearData
]);
?>

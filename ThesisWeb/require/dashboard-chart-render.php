<?php

require 'dbconf.php';

$weekQuery = "
    SELECT SUM(pet_quantity) AS plastic, SUM(glass_quantity) AS glass, SUM(aluminum_quantity) AS aluminum, WEEK(timestamp) AS week_num 
    FROM transaction_records 
    WHERE YEAR(timestamp) = YEAR(CURRENT_DATE) 
    GROUP BY week_num
";

$monthQuery = "
    SELECT SUM(pet_quantity) AS plastic, SUM(glass_quantity) AS glass, SUM(aluminum_quantity) AS aluminum, MONTH(timestamp) AS month_num 
    FROM transaction_records 
    WHERE YEAR(timestamp) = YEAR(CURRENT_DATE) 
    GROUP BY month_num
";

$yearQuery = "
    SELECT SUM(pet_quantity) AS plastic, SUM(glass_quantity) AS glass, SUM(aluminum_quantity) AS aluminum, YEAR(timestamp) AS year_num 
    FROM transaction_records 
    GROUP BY year_num
";

$weekResult = $conn->query($weekQuery);
$monthResult = $conn->query($monthQuery);
$yearResult = $conn->query($yearQuery);

$weekData = [];
$monthData = [];
$yearData = [];

// Fetch weekly data
while ($row = $weekResult->fetch_assoc()) {
    $weekData['PET'][] = (int)$row['plastic'];
    $weekData['Glass'][] = (int)$row['glass'];
    $weekData['Aluminum'][] = (int)$row['aluminum'];
}

// Fetch monthly data
while ($row = $monthResult->fetch_assoc()) {
    $monthData['PET'][] = (int)$row['plastic'];
    $monthData['Glass'][] = (int)$row['glass'];
    $monthData['Aluminum'][] = (int)$row['aluminum'];
}

// Fetch yearly data
while ($row = $yearResult->fetch_assoc()) {
    $yearData['PET'][] = (int)$row['plastic'];
    $yearData['Glass'][] = (int)$row['glass'];
    $yearData['Aluminum'][] = (int)$row['aluminum'];
}

// Close the database connection
$conn->close();

// Return data as JSON
echo json_encode([
    'week' => $weekData,
    'month' => $monthData,
    'year' => $yearData
]);
?>

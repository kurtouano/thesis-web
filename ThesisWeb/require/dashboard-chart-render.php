<?php

require 'dbconf.php';

$weekQuery = "
    SELECT material_type, SUM(material_quantity) AS total_quantity, WEEK(timestamp) AS week_num 
    FROM transaction_records 
    WHERE YEAR(timestamp) = YEAR(CURRENT_DATE) 
    GROUP BY week_num, material_type
";

$monthQuery = "
    SELECT material_type, SUM(material_quantity) AS total_quantity, MONTH(timestamp) AS month_num 
    FROM transaction_records 
    WHERE YEAR(timestamp) = YEAR(CURRENT_DATE) 
    GROUP BY month_num, material_type
";

$yearQuery = "
    SELECT material_type, SUM(material_quantity) AS total_quantity, YEAR(timestamp) AS year_num 
    FROM transaction_records 
    GROUP BY year_num, material_type
";

$weekResult = $conn->query($weekQuery);
$monthResult = $conn->query($monthQuery);
$yearResult = $conn->query($yearQuery);

$weekData = [];
$monthData = [];
$yearData = [];

// Fetch weekly data
while ($row = $weekResult->fetch_assoc()) {
    $materialType = $row['material_type'];
    $quantity = (int)$row['total_quantity'];
    
    if (!isset($weekData[$materialType])) {
        $weekData[$materialType] = [];
    }
    $weekData[$materialType][] = $quantity;
}

// Fetch monthly data
while ($row = $monthResult->fetch_assoc()) {
    $materialType = $row['material_type'];
    $quantity = (int)$row['total_quantity'];
    
    if (!isset($monthData[$materialType])) {
        $monthData[$materialType] = [];
    }
    $monthData[$materialType][] = $quantity;
}

// Fetch yearly data
while ($row = $yearResult->fetch_assoc()) {
    $materialType = $row['material_type'];
    $quantity = (int)$row['total_quantity'];
    
    if (!isset($yearData[$materialType])) {
        $yearData[$materialType] = [];
    }
    $yearData[$materialType][] = $quantity;
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
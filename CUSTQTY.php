<?php

// Database connection
$conn = mysqli_connect("localhost", "root", "", "u369677608_maverickdb");
// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get JSON input
$json = file_get_contents('php://input');
$filters = json_decode($json, true);

// Check if input is valid
if (!is_array($filters)) {
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Invalid JSON input'
    ]);
    exit;
}

// Initialize query filters
$Query_Filter = [];

// Get filter parameters from JSON input
$appKeyCode = $filters['APP_KEY_CODE'] ?? null;
$firmCode = $filters['Firm_Code'] ?? null;
$custName = $filters['Cust_Name'] ?? null;

// Build the query filter based on the input parameters
if (!empty($appKeyCode)) {
    $Query_Filter[] = "m.APP_KEY_CODE = '" . mysqli_real_escape_string($conn, $appKeyCode) . "'";
}
if (!empty($firmCode)) {
    $Query_Filter[] = "m.Firm_Code = '" . mysqli_real_escape_string($conn, $firmCode) . "'";
}
if (!empty($custName)) {
    $Query_Filter[] = "m.Cust_Name = '" . mysqli_real_escape_string($conn, $custName) . "'";
} else {
    $Query_Filter[] = "m.Cust_Name IS NOT NULL";
}

// SQL query to join s_mtr and s_dtl tables and fetch the required data with aggregation
$query = "SELECT 
            m.Cust_Name,
            SUM(d.Qty) AS Total_Qty,
            SUM(d.Item_Net_Amt) AS Total_Amount
          FROM 
            s_mtr AS m
          INNER JOIN 
            s_dtl AS d ON m.APP_KEY_CODE = d.APP_KEY_CODE";

// Apply the filter if there are any conditions
if (!empty($Query_Filter)) {
    $query .= " WHERE " . implode(" AND ", $Query_Filter);
}

// Group by Cust_Name to calculate total quantity and amount per customer
$query .= " GROUP BY m.Cust_Name ORDER BY m.Cust_Name ASC";

// Execute the query
$result = mysqli_query($conn, $query);

$response = array();

// Check if query execution was successful
if ($result) {
    // Fetch all records from the result
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = array(
            'Cust_Name' => $row['Cust_Name'],
            'Total_Qty' => $row['Total_Qty'],
            'Total_Amount' => $row['Total_Amount']
        );
    }
    
    // Set response header to JSON
    header('Content-Type: application/json');
    // Directly output the fetched data as JSON
    echo json_encode($response);
} else {
    // Error handling
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Database query error: ' . mysqli_error($conn)
    ]);
}

// Close the database connection
mysqli_close($conn);

?>

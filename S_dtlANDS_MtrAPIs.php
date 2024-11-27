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
        'status' => 'error',
        'message' => 'Invalid JSON input'
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

// Handle Cust_Name condition
// Handle Cust_Name condition
if (!empty($custName)) {
    // If Cust_Name is provided, match only the provided name
    $Query_Filter[] = "m.Cust_Name = '" . mysqli_real_escape_string($conn, $custName) . "'";
} else {
    // If Cust_Name is not provided or is NULL, include all records
    $Query_Filter[] = "m.Cust_Name IS NOT NULL";
}

// SQL query to join s_mtr and s_dtl tables and fetch the required data
$query = "SELECT 
            m.Bill_No,
            m.Invoice_Date,
            m.Cust_Name,
            d.Item_Name,
            d.Size1,
            d.Qty,
            d.Selling_Rate,
            d.Tax_Amt,
            d.Item_Net_Amt
          FROM 
            s_mtr AS m
          INNER JOIN 
            s_dtl AS d ON m.APP_KEY_CODE = d.APP_KEY_CODE";

// Apply the filter if there are any conditions
if (!empty($Query_Filter)) {
    $query .= " WHERE " . implode(" AND ", $Query_Filter);
}

// Order by Invoice_Date
$query .= " ORDER BY m.Invoice_Date ASC";

// Execute the query
$result = mysqli_query($conn, $query);

$response = array();

// Check if query execution was successful
if ($result) {
    // Fetch all records from the result
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = array(
            'Bill_No' => $row['Bill_No'],
            'Invoice_Date' => $row['Invoice_Date'],
            'Cust_Name' => $row['Cust_Name'],
            'Item_Name' => $row['Item_Name'],
            'Size1' => $row['Size1'],
            'Qty' => $row['Qty'],
            'Selling_Rate' => $row['Selling_Rate'],
            'Tax_Amt' => $row['Tax_Amt'],
            'Item_Net_Amt' => $row['Item_Net_Amt']
        );
    }
    
    // Set response header to JSON
    header('Content-Type: application/json');
    // Return success response with data
    echo json_encode([
        'status' => 'success',
        'data' => $response
    ]);
} else {
    // Error handling
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Database query error: ' . mysqli_error($conn)
    ]);
}

// Close the database connection
mysqli_close($conn);

?>

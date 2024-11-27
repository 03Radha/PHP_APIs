<?php

// Database connection
$conn = mysqli_connect("localhost","root","","u369677608_maverickdb");
// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get JSON input
$json = file_get_contents('php://input');
$people = json_decode($json, true);

// Check if input is valid
if (!is_array($people)) {
    die("Invalid JSON input");
}

$count = count($people);

// Initialize query filters
$Query_Filter = [];

// Loop through the input JSON
for ($i = 0; $i < $count; $i++) {
    $appKeyCode = $people[$i]['APP_KEY_CODE'] ?? null; // Get APP_KEY_CODE from input
    $Firm_Code = $people[$i]['Firm_Code'] ?? null; // Get Firm_Code from input
    $Cust_Name = $people[$i]['Cust_Name'] ?? null; // Get Cust_Name from input
}

// Build the query filter based on the input parameters
if (!empty($appKeyCode)) {
    $Query_Filter[] = "m.APP_KEY_CODE = '$appKeyCode'";
}
if (!empty($Firm_Code)) {
    $Query_Filter[] = "m.Firm_Code = '$Firm_Code'";
}
if (!empty($Cust_Name)) {
    $Query_Filter[] = "m.Cust_Name = '$Cust_Name'";
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
            s_mtr m
          INNER JOIN 
            s_dtl d ON m.APP_KEY_CODE = d.APP_KEY_CODE";

// Apply the filter if there are any conditions
if (!empty($Query_Filter)) {
    $query .= " WHERE " . implode(" AND ", $Query_Filter);
}

// Order by Invoice_Date
$query .= " ORDER BY m.Invoice_Date ASC";

// Execute the query
$result = mysqli_query($conn, $query);

$response = array();

// Fetch all records from the result
while ($row = mysqli_fetch_array($result)) {
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

// Return the response as JSON
echo json_encode($response);

?>

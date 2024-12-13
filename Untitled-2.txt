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
$Invoice_Date = $filters['Invoice_Date'] ?? null;
//$endDate = $filters['endDate'] ?? null;
$Product_Code = $filters['Product_Code'] ?? null;
$Group_Code = $filters['Group_Code'] ?? null;
$Brand_Code = $filters['Brand_Code'] ?? null;

// Build the query filter based on the input parameters
if (!empty($appKeyCode)) {
    $Query_Filter[] = "s_mtr.APP_KEY_CODE = '" . mysqli_real_escape_string($conn, $appKeyCode) . "'";
}
if (!empty($firmCode)) {
    $Query_Filter[] = "s_mtr.Firm_Code = '" . mysqli_real_escape_string($conn,$firmCode) . "'";
}
if (!empty($custName)) {
    $Query_Filter[] = "s_mtr.Cust_Name = '" . mysqli_real_escape_string($conn,$custName) . "'";
}
if (!empty($InvoiceDate)) {
    $Query_Filter[] = "s_mtr.Invoice_Date = '" . mysqli_real_escape_string($conn,$InvoiceDate) . "'";
}
if (!empty($Product_Code)) {
    $Query_Filter[] = "product.Product_Code = '" . mysqli_real_escape_string($conn, $Product_Code) . "'";
}
if (!empty($Group_Code)) {
    $Query_Filter[] = "product.Group_Code = '" . mysqli_real_escape_string($conn, $Group_Code) . "'";
}
if (!empty($Brand_Code)) {
    $Query_Filter[] = "product.Brand_Code = '" . mysqli_real_escape_string($conn, $Brand_Code) . "'";
}

// Base SQL query
$query = "SELECT 
            s_mtr.Invoice_Date,
            s_mtr.Cust_Name,
            s_dtl.Invoice_No,
            s_dtl.Item_Name,
            s_dtl.Sales_Man_Code,
            s_dtl.SALE_GST_STATUS,
            s_dtl.Item_Code,
            product.Product_Code,
            product.Group_Code,
            product.Brand_Code
          FROM 
            s_mtr
          INNER JOIN 
            s_dtl ON s_mtr.APP_KEY_CODE = s_dtl.APP_KEY_CODE
          INNER JOIN 
            product ON s_dtl.Item_Code = product.Product_Code";
        

// Apply filters if any
if (!empty($Query_Filter)) {
    $query .= " WHERE " . implode(" AND ", $Query_Filter);
}

// Group by all columns to avoid SQL errors
$query .= " GROUP BY 
                s_mtr.Invoice_Date,
                s_mtr.Cust_Name,
                s_dtl.Invoice_No,
                s_dtl.Item_Name,
                s_dtl.Sales_Man_Code,
                s_dtl.SALE_GST_STATUS,
                s_dtl.Item_Code,
                product.Product_Code,
                product.Group_Code,
                product.Brand_Code
            ORDER BY 
                s_mtr.Cust_Name, s_dtl.Item_Name ASC";

// Debug: Uncomment the following line to check the query
// echo $query;

// Execute the query
$result = mysqli_query($conn, $query);

$response = [];

// Check if query execution was successful
if ($result) {
    // Fetch all records from the result
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = [
            'Invoice_Date' => $row['Invoice_Date'],
            'Cust_Name' => $row['Cust_Name'],
            'Invoice_No' => $row['Invoice_No'],
            'Item_Name' => $row['Item_Name'],
            'Sales_Man_Code' => $row['Sales_Man_Code'],
            'SALE_GST_STATUS' => $row['SALE_GST_STATUS'],
            'Item_Code' => $row['Item_Code'],
            'Product_Code' => $row['Product_Code'],
            'Group_Code' => $row['Group_Code'],
            'Brand_Code' => $row['Brand_Code']
        ];
    }
    // Set response header to JSON
    header('Content-Type: application/json');
    // Output the fetched data as JSON
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
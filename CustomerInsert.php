<?php
//Database connection
$conn = mysqli_connect("localhost", "root", "", "maverick");

// Check the connection
if (!$conn) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . mysqli_connect_error()]));
}

// Read JSON input
$json = file_get_contents('php://input');
if (!$json) {
    die(json_encode(["status" => "error", "message" => "No JSON input received."]));
}

// Parse the JSON input (expecting an array)
$dataArray = json_decode($json, true);
if (!is_array($dataArray) || empty($dataArray)) {
    die(json_encode(["status" => "error", "message" => "Invalid or empty JSON array received."]));
}

// Initialize a response array
$response = [
    "status" => "success",
    "message" => "Customers added successfully!",
    "details" => []
];

// Loop through each customer in the array and insert
foreach ($dataArray as $data) {
    $custId = $data['Cust_Id'] ?? null; // Ensure Cust_Id is provided
    $custname = $data['Cust_Name'] ?? null;
    $custmob = $data['Cust_Mobile'] ?? null;
    $GST = $data['GST'] ?? null;
    $CustAddress = $data['Cust_Address'] ?? null;

    // Validate required fields
    if (empty($custId) || empty($custname) || empty($custmob)) {
        $response['status'] = "partial_success";
        $response['details'][] = [
            "Cust_Id" => $custId,
            "Cust_Name" => $custname,
            "message" => "Cust_Id, Cust_Name, and Cust_Mobile are required."
        ];
        continue; // Skip this record
    }

    // Construct the SQL INSERT query
    $query = "INSERT INTO customer (Cust_Id, Cust_Name, Cust_Mobile, GST, Cust_Address) 
              VALUES ($custId, '$custname', '$custmob', '$GST', '$CustAddress')";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        $response['details'][] = [
            "Cust_Id" => $custId,
            "Cust_Name" => $custname,
            "message" => "Customer added successfully."
        ];
    } else {
        $response['status'] = "partial_success";
        $response['details'][] = [
            "Cust_Id" => $custId,
            "Cust_Name" => $custname,
            "message" => "Error adding customer: " . mysqli_error($conn)
        ];
    }
}

// Output the response as JSON
echo json_encode($response);

// Close the database connection
mysqli_close($conn);
?>
<?php

// https://businessguruerp.com/BG_API_NEW/PRODUCT_LIST_TESTING.php

//[{"appKeyCodeKey":"1013","Firm_Code":"3"}]

//include('db_connection.php');
$conn = mysqli_connect("localhost","root","","u369677608_maverickdb");

if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }
  echo "Connected successfully!";
//$appKeyCode=$_POST['appKeyCodeKey'];

// $json = file_get_contents('php://input');
// $people = json_decode($json,true);
// $count= count($people);

$json = file_get_contents('php://input');
if (empty($json)) {
    die("No input received");
}
$people = json_decode($json, true);
if (!is_array($people)) {
    die("Invalid JSON input");
}
$count = count($people);

   
for ($i=0; $i < $count; $i++) 
{ 
//$appKeyCode = "3939";//1
$appKeyCode = $people[$i]['appKeyCodeKey'];//1
$Firm_Code =$people[$i]['Firm_Code'];
//$mem_id="3939";
//$appKeyCode="1011";

//echo "App: $appKeyCode";

$query = "SELECT p.Firm_Code,p.Product_Code,p.Group_Code,p.Picture, p.PRODUCT_ID, p.Product_Name, p.Cost_Price, p.Sale_Price, p.Option1 as HSN_CODE, p.Print_Name, p.Unit, p.Whole_Sale_Price, p.Discount, p.Message, pg.Group_Name, pb.Brand_Name, t.Tax_Name as Tax_Name, t.Tax as Tax_Per FROM PRODUCT p LEFT JOIN PRODUCT_GROUP pg ON p.Group_Code = pg.Group_Code AND p.APP_KEY_CODE = pg.APP_KEY_CODE AND p.Firm_Code=pg.Firm_Code LEFT JOIN PRODUCT_BRAND pb ON p.Brand_Code = pb.Brand_Code AND p.APP_KEY_CODE = pb.APP_KEY_CODE AND p.Firm_Code=pb.Firm_Code INNER JOIN TAX t ON p.Tax_At_Sale = t.Tax_Code AND p.APP_KEY_CODE = t.APP_KEY_CODE AND p.Firm_Code=t.Firm_Code WHERE p.APP_KEY_CODE = '$appKeyCode' AND p.Firm_Code='$Firm_Code' ORDER BY p.Product_Name ASC";  

//$query = "SELECT p.Product_Code, p.Picture, p.PRODUCT_ID, p.Product_Name, p.Cost_Price, p.Sale_Price, p.Option1 as HSN_CODE, p.Print_Name, p.Unit, p.Whole_Sale_Price, p.Discount, p.Message, pg.Group_Name, pb.Brand_Name, t.Tax_Name as Tax_Name, t.Tax as Tax_Per FROM PRODUCT p LEFT JOIN PRODUCT_GROUP pg ON p.Group_Code = pg.Group_Code AND p.APP_KEY_CODE = pg.APP_KEY_CODE LEFT JOIN PRODUCT_BRAND pb ON p.Brand_Code = pb.Brand_Code AND p.APP_KEY_CODE = pb.APP_KEY_CODE INNER JOIN TAX t ON p.Tax_At_Sale = t.Tax_Code AND p.APP_KEY_CODE = t.APP_KEY_CODE WHERE p.APP_KEY_CODE = '$appKeyCode' ORDER BY p.Product_Name ASC";  



$result = mysqli_query($conn,$query); 
 

$response = array();

//$posts = array(); 
      while($row = mysqli_fetch_array($result))  
      {  
          
                     $posts[] = array('Product_Name' => $row["Product_Name"],
                     'Cost_Price' => $row["Cost_Price"],  
                     'Sale_Price' => $row["Sale_Price"],  
                     'HSN_CODE' => $row["HSN_CODE"],  
                     'Print_Name' => $row["Print_Name"],  
                     'Unit' => $row["Unit"], 
                     'Whole_Sale_Price' => $row["Whole_Sale_Price"],  
                     'Discount' => $row["Discount"],  
                     'Message' => $row["Message"],  
                     'Group_Name' => $row["Group_Name"],  
                     'Group_Code' => $row["Group_Code"],  
                     'Firm_Code' => $row["Firm_Code"],  
                     'Brand_Name' => $row["Brand_Name"],  
                     'Tax_Name' => $row["Tax_Name"],  
                     'Tax' => $row["Tax_Per"],
                     'PRODUCT_ID' => $row["PRODUCT_ID"],
                     'Picture' => $row["Picture"],
                     'Product_Code'  =>  $row["Product_Code"]);  
         
      }
      
      
     // $response['posts'] = $posts;
}
      echo json_encode($posts);   
 

		 

?>
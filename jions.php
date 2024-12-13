<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the Invoice_No from the GET request
    $invoiceNo = $_GET['Invoice_No'];

    // SQL to fetch data
    $sql = "SELECT 
                S_MTR.*, 
                S_DTL.S_DTL_ID,
                S_DTL.APP_KEY_CODE,
                S_DTL.Firm_Code,
                S_DTL.Invoice_Type,
                S_DTL.App_Online_Flag,
                S_DTL.S_MTR_ID,
                S_DTL.Sr_No,
                S_DTL.Item_Code,
                S_DTL.Item_Name
            FROM 
                S_MTR
            JOIN 
                S_DTL ON S_MTR.Invoice_No = S_DTL.Invoice_No
            WHERE 
                S_MTR.Invoice_No = :Invoice_No";

    // Prepare and execute query
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':Invoice_No', $invoiceNo, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["message" => "Data fetched successfully.", "data" => $result]);
    } else {
        echo json_encode(["message" => "Failed to fetch data."]);
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle POST request
    $data = json_decode(file_get_contents('php://input'), true);

    // SQL to insert data
    $sql = "INSERT INTO S_MTR 
            (S_MTR_ID, APP_KEY_CODE, Firm_Code, Invoice_Type, App_Online_Flag, Invoice_No, Invoice_Date, Bill_No, Vat_Status, SD_No, SD_Dt, SO_No, Cust_Code, Cust_Name, Bill_Status, Tot_Item, Payment_Type, S_Amt, S_GAmt, Round_Off, Profit, Disc, Disc_Amt, Tax, Tax_Amt, Cess_Tax_Amt, Servies_Tax, Servies_Tax_Amt, ADDL_Tax, ADDL_Tax_Amt, Packing_Chrg, Packing_Chrg_Pre, Dely_Chrg, Dely_Chrg_Pre, Misc_Chrg, Freight_Chrg, Dely_Boy_Code, Sales_Man_Code, Transport, Spng_Name, Spng_Addr1, Spng_Addr2, Spng_Addr3, Spng_Addr4, Spng_State, Spng_Pincode, Spng_Mobile_No, Card_No, Card_Name, Card_Hld_Name, Card_Exp_Date, Card_Ad_No, Card_Slip_No, Cash_Amt, Cheque_Amt, Card_Amt, Credit_Amt, Card_Servies_Tax, Card_Servies_Tax_Amt, Rate_Type, Remark, Vouchar_No, Audit_Row, SO_Dt, Advance_Amount, GST_Type, Consignee_Cust_Code, SalesManCode, Sal_Man_Dis, Sal_Man_Dis_Amt, Ledger_Type, Project_Name, Project_Team, SQ_NO, SI_COLUMN1, SI_COLUMN2, SI_COLUMN3, SI_COLUMN4, Narration_Value, Mobile_No_Quick_Cust, Address_Quick_Cust, Quick_Cust_String, Invoice_No_String, Invoice_Year, Total_Amount_New, Final_Amount_New, Paid_Amount_New, Return_Amount_New, Loyalty_Point, Redeem_Loyalty_Point, Loyalty_Value, User_Id, User_Name, String_Value, SQL_Convert_Final)
            VALUES 
            (:S_MTR_ID, :APP_KEY_CODE, :Firm_Code, :Invoice_Type, :App_Online_Flag, :Invoice_No, :Invoice_Date, :Bill_No, :Vat_Status, :SD_No, :SD_Dt, :SO_No, :Cust_Code, :Cust_Name, :Bill_Status, :Tot_Item, :Payment_Type, :S_Amt, :S_GAmt, :Round_Off, :Profit, :Disc, :Disc_Amt, :Tax, :Tax_Amt, :Cess_Tax_Amt, :Servies_Tax, :Servies_Tax_Amt, :ADDL_Tax, :ADDL_Tax_Amt, :Packing_Chrg, :Packing_Chrg_Pre, :Dely_Chrg, :Dely_Chrg_Pre, :Misc_Chrg, :Freight_Chrg, :Dely_Boy_Code, :Sales_Man_Code, :Transport, :Spng_Name, :Spng_Addr1, :Spng_Addr2, :Spng_Addr3, :Spng_Addr4, :Spng_State, :Spng_Pincode, :Spng_Mobile_No, :Card_No, :Card_Name, :Card_Hld_Name, :Card_Exp_Date, :Card_Ad_No, :Card_Slip_No, :Cash_Amt, :Cheque_Amt, :Card_Amt, :Credit_Amt, :Card_Servies_Tax, :Card_Servies_Tax_Amt, :Rate_Type, :Remark, :Vouchar_No, :Audit_Row, :SO_Dt, :Advance_Amount, :GST_Type, :Consignee_Cust_Code, :SalesManCode, :Sal_Man_Dis, :Sal_Man_Dis_Amt, :Ledger_Type, :Project_Name, :Project_Team, :SQ_NO, :SI_COLUMN1, :SI_COLUMN2, :SI_COLUMN3, :SI_COLUMN4, :Narration_Value, :Mobile_No_Quick_Cust, :Address_Quick_Cust, :Quick_Cust_String, :Invoice_No_String, :Invoice_Year, :Total_Amount_New, :Final_Amount_New, :Paid_Amount_New, :Return_Amount_New, :Loyalty_Point, :Redeem_Loyalty_Point, :Loyalty_Value, :User_Id, :User_Name, :String_Value, :SQL_Convert_Final)";

    // Prepare and execute the INSERT query
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute($data)) {
        echo json_encode(["message" => "Record added successfully."]);
    } else {
        echo json_encode(["message" => "Failed to add record."]);
    }
}
?>

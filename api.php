<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // SQL query to insert data
    $sql = "INSERT INTO S_MTR 
            ( APP_KEY_CODE, Firm_Code, Invoice_Type, App_Online_Flag, Invoice_No, Invoice_Date, Bill_No, Vat_Status, SD_No, SD_Dt, SO_No, Cust_Code, Cust_Name, Bill_Status, Tot_Item, Payment_Type, S_Amt, S_GAmt, Round_Off, Profit, Disc, Disc_Amt, Tax, Tax_Amt, Cess_Tax_Amt, Servies_Tax, Servies_Tax_Amt, ADDL_Tax, ADDL_Tax_Amt, Packing_Chrg, Packing_Chrg_Pre, Dely_Chrg, Dely_Chrg_Pre, Misc_Chrg, Freight_Chrg, Dely_Boy_Code, Sales_Man_Code, Transport, Spng_Name, Spng_Addr1, Spng_Addr2, Spng_Addr3, Spng_Addr4, Spng_State, Spng_Pincode, Spng_Mobile_No, Card_No, Card_Name, Card_Hld_Name, Card_Exp_Date, Card_Ad_No, Card_Slip_No, Cash_Amt, Cheque_Amt, Card_Amt, Credit_Amt, Card_Servies_Tax, Card_Servies_Tax_Amt, Rate_Type, Remark, Vouchar_No, Audit_Row, SO_Dt, Advance_Amount, GST_Type, Consignee_Cust_Code, SalesManCode, Sal_Man_Dis, Sal_Man_Dis_Amt, Ledger_Type, Project_Name, Project_Team, SQ_NO, SI_COLUMN1, SI_COLUMN2, SI_COLUMN3, SI_COLUMN4, Narration_Value, Mobile_No_Quick_Cust, Address_Quick_Cust, Quick_Cust_String, Invoice_No_String, Invoice_Year, Total_Amount_New, Final_Amount_New, Paid_Amount_New, Return_Amount_New, Loyalty_Point, Redeem_Loyalty_Point, Loyalty_Value, User_Id, User_Name, String_Value, SQL_Convert_Final)
            VALUES 
            ( :APP_KEY_CODE, :Firm_Code, :Invoice_Type, :App_Online_Flag, :Invoice_No, :Invoice_Date, :Bill_No, :Vat_Status, :SD_No, :SD_Dt, :SO_No, :Cust_Code, :Cust_Name, :Bill_Status, :Tot_Item, :Payment_Type, :S_Amt, :S_GAmt, :Round_Off, :Profit, :Disc, :Disc_Amt, :Tax, :Tax_Amt, :Cess_Tax_Amt, :Servies_Tax, :Servies_Tax_Amt, :ADDL_Tax, :ADDL_Tax_Amt, :Packing_Chrg, :Packing_Chrg_Pre, :Dely_Chrg, :Dely_Chrg_Pre, :Misc_Chrg, :Freight_Chrg, :Dely_Boy_Code, :Sales_Man_Code, :Transport, :Spng_Name, :Spng_Addr1, :Spng_Addr2, :Spng_Addr3, :Spng_Addr4, :Spng_State, :Spng_Pincode, :Spng_Mobile_No, :Card_No, :Card_Name, :Card_Hld_Name, :Card_Exp_Date, :Card_Ad_No, :Card_Slip_No, :Cash_Amt, :Cheque_Amt, :Card_Amt, :Credit_Amt, :Card_Servies_Tax, :Card_Servies_Tax_Amt, :Rate_Type, :Remark, :Vouchar_No, :Audit_Row, :SO_Dt, :Advance_Amount, :GST_Type, :Consignee_Cust_Code, :SalesManCode, :Sal_Man_Dis, :Sal_Man_Dis_Amt, :Ledger_Type, :Project_Name, :Project_Team, :SQ_NO, :SI_COLUMN1, :SI_COLUMN2, :SI_COLUMN3, :SI_COLUMN4, :Narration_Value, :Mobile_No_Quick_Cust, :Address_Quick_Cust, :Quick_Cust_String, :Invoice_No_String, :Invoice_Year, :Total_Amount_New, :Final_Amount_New, :Paid_Amount_New, :Return_Amount_New, :Loyalty_Point, :Redeem_Loyalty_Point, :Loyalty_Value, :User_Id, :User_Name, :String_Value, :SQL_Convert_Final)";

    $stmt = $pdo->prepare($sql);

    // Execute the statement with provided data
    if ($stmt->execute($data)) {
        // Return inserted data in column format as response
        $response = [
            "message" => "",
            "inserted_data" => $data // This will return the columns with values you inserted
        ];
        echo json_encode($response);
    } else {
        echo json_encode(["message" => "Failed to add record."]);
    }
}
?>

<?php 
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    try {
        // Start transaction
        $pdo->beginTransaction();

        // Get the maximum S_MTR_ID from the s_mtr table
        $max_id_query = "SELECT IFNULL(MAX(S_MTR_ID), 0) + 1 AS new_s_mtr_id FROM s_mtr";
        $max_id_stmt = $pdo->query($max_id_query);
        $new_s_mtr_id = $max_id_stmt->fetchColumn();

        // Insert into S_MTR with the new ID as Invoice_No
        $s_mtr_sql = "INSERT INTO s_mtr (
            S_MTR_ID, APP_KEY_CODE, Firm_Code, Invoice_Type, App_Online_Flag, Invoice_No, Invoice_Date, 
            Bill_No, Vat_Status, SD_No, SD_Dt, SO_No, Cust_Code, Cust_Name, Bill_Status, Tot_Item, Payment_Type, 
            S_Amt, S_GAmt, Round_Off, Profit, Disc, Disc_Amt, Tax, Tax_Amt, Cess_Tax_Amt, Servies_Tax, 
            Servies_Tax_Amt, ADDL_Tax, ADDL_Tax_Amt, Packing_Chrg, Packing_Chrg_Pre, Dely_Chrg, 
            Dely_Chrg_Pre, Misc_Chrg, Freight_Chrg, Dely_Boy_Code, Sales_Man_Code, Transport, Spng_Name, 
            Spng_Addr1, Spng_Addr2, Spng_Addr3, Spng_Addr4, Spng_State, Spng_Pincode, Spng_Mobile_No, 
            Card_No, Card_Name, Card_Hld_Name, Card_Exp_Date, Card_Ad_No, Card_Slip_No, Cash_Amt, Cheque_Amt, 
            Card_Amt, Credit_Amt, Card_Servies_Tax, Card_Servies_Tax_Amt, Rate_Type, Remark, Vouchar_No, 
            Audit_Row, SO_Dt, Advance_Amount, GST_Type, Consignee_Cust_Code, SalesManCode, Sal_Man_Dis, 
            Sal_Man_Dis_Amt, Ledger_Type, Project_Name, Project_Team, SQ_NO, SI_COLUMN1, SI_COLUMN2, SI_COLUMN3, 
            SI_COLUMN4, Narration_Value, Mobile_No_Quick_Cust, Address_Quick_Cust, Quick_Cust_String, 
            Invoice_No_String, Invoice_Year, Total_Amount_New, Final_Amount_New, Paid_Amount_New, 
            Return_Amount_New, Loyalty_Point, Redeem_Loyalty_Point, Loyalty_Value, User_Id, User_Name, 
            String_Value, SQL_Convert_Final
        ) VALUES (
            :S_MTR_ID, :APP_KEY_CODE, :Firm_Code, :Invoice_Type, :App_Online_Flag, :Invoice_No, :Invoice_Date, 
            :Bill_No, :Vat_Status, :SD_No, :SD_Dt, :SO_No, :Cust_Code, :Cust_Name, :Bill_Status, :Tot_Item, :Payment_Type, 
            :S_Amt, :S_GAmt, :Round_Off, :Profit, :Disc, :Disc_Amt, :Tax, :Tax_Amt, :Cess_Tax_Amt, :Servies_Tax, 
            :Servies_Tax_Amt, :ADDL_Tax, :ADDL_Tax_Amt, :Packing_Chrg, :Packing_Chrg_Pre, :Dely_Chrg, 
            :Dely_Chrg_Pre, :Misc_Chrg, :Freight_Chrg, :Dely_Boy_Code, :Sales_Man_Code, :Transport, :Spng_Name, 
            :Spng_Addr1, :Spng_Addr2, :Spng_Addr3, :Spng_Addr4, :Spng_State, :Spng_Pincode, :Spng_Mobile_No, 
            :Card_No, :Card_Name, :Card_Hld_Name, :Card_Exp_Date, :Card_Ad_No, :Card_Slip_No, :Cash_Amt, :Cheque_Amt, 
            :Card_Amt, :Credit_Amt, :Card_Servies_Tax, :Card_Servies_Tax_Amt, :Rate_Type, :Remark, :Vouchar_No, 
            :Audit_Row, :SO_Dt, :Advance_Amount, :GST_Type, :Consignee_Cust_Code, :SalesManCode, :Sal_Man_Dis, 
            :Sal_Man_Dis_Amt, :Ledger_Type, :Project_Name, :Project_Team, :SQ_NO, :SI_COLUMN1, :SI_COLUMN2, :SI_COLUMN3, 
            :SI_COLUMN4, :Narration_Value, :Mobile_No_Quick_Cust, :Address_Quick_Cust, :Quick_Cust_String, 
            :Invoice_No_String, :Invoice_Year, :Total_Amount_New, :Final_Amount_New, :Paid_Amount_New, 
            :Return_Amount_New, :Loyalty_Point, :Redeem_Loyalty_Point, :Loyalty_Value, :User_Id, :User_Name, 
            :String_Value, :SQL_Convert_Final
        )";
        
        $stmt = $pdo->prepare($s_mtr_sql);
        $stmt->execute([
                ':S_MTR_ID' => $new_s_mtr_id,
                ':APP_KEY_CODE' => $data['APP_KEY_CODE'],
                ':Firm_Code' => $data['Firm_Code'],
                ':Invoice_Type' => $data['Invoice_Type'],
                ':App_Online_Flag' => $data['App_Online_Flag'],
                ':Invoice_No' => $new_s_mtr_id, // Using the new S_MTR_ID as Invoice_No
                ':Invoice_Date' => $data['Invoice_Date'],
                ':Bill_No' => $data['Bill_No'],
                ':Vat_Status' => $data['Vat_Status'],
                ':SD_No' => $data['SD_No'],
                ':SD_Dt' => $data['SD_Dt'],
                ':SO_No' => $data['SO_No'],
                ':Cust_Code' => $data['Cust_Code'],
                ':Cust_Name' => $data['Cust_Name'],
                ':Bill_Status' => $data['Bill_Status'],
                ':Tot_Item' => $data['Tot_Item'],
                ':Payment_Type' => $data['Payment_Type'],
                ':S_Amt' => $data['S_Amt'],
                ':S_GAmt' => $data['S_GAmt'],
                ':Round_Off' => $data['Round_Off'],
                ':Profit' => $data['Profit'],
                ':Disc' => $data['Disc'],
                ':Disc_Amt' => $data['Disc_Amt'],
                ':Tax' => $data['Tax'],
                ':Tax_Amt' => $data['Tax_Amt'],
                ':Cess_Tax_Amt' => $data['Cess_Tax_Amt'],
                ':Servies_Tax' => $data['Servies_Tax'],
                ':Servies_Tax_Amt' => $data['Servies_Tax_Amt'],
                ':ADDL_Tax' => $data['ADDL_Tax'],
                ':ADDL_Tax_Amt' => $data['ADDL_Tax_Amt'],
                ':Packing_Chrg' => $data['Packing_Chrg'],
                ':Packing_Chrg_Pre' => $data['Packing_Chrg_Pre'],
                ':Dely_Chrg' => $data['Dely_Chrg'],
                ':Dely_Chrg_Pre' => $data['Dely_Chrg_Pre'],
                ':Misc_Chrg' => $data['Misc_Chrg'],
                ':Freight_Chrg' => $data['Freight_Chrg'],
                ':Dely_Boy_Code' => $data['Dely_Boy_Code'],
                ':Sales_Man_Code' => $data['Sales_Man_Code'],
                ':Transport' => $data['Transport'],
                ':Spng_Name' => $data['Spng_Name'],
                ':Spng_Addr1' => $data['Spng_Addr1'],
                ':Spng_Addr2' => $data['Spng_Addr2'],
                ':Spng_Addr3' => $data['Spng_Addr3'],
                ':Spng_Addr4' => $data['Spng_Addr4'],
                ':Spng_State' => $data['Spng_State'],
                ':Spng_Pincode' => $data['Spng_Pincode'],
                ':Spng_Mobile_No' => $data['Spng_Mobile_No'],
                ':Card_No' => $data['Card_No'],
                ':Card_Name' => $data['Card_Name'],
                ':Card_Hld_Name' => $data['Card_Hld_Name'],
                ':Card_Exp_Date' => $data['Card_Exp_Date'],
                ':Card_Ad_No' => $data['Card_Ad_No'],
                ':Card_Slip_No' => $data['Card_Slip_No'],
                ':Cash_Amt' => $data['Cash_Amt'],
                ':Cheque_Amt' => $data['Cheque_Amt'],
                ':Card_Amt' => $data['Card_Amt'],
                ':Credit_Amt' => $data['Credit_Amt'],
                ':Card_Servies_Tax' => $data['Card_Servies_Tax'],
                ':Card_Servies_Tax_Amt' => $data['Card_Servies_Tax_Amt'],
                ':Rate_Type' => $data['Rate_Type'],
                ':Remark' => $data['Remark'],
                ':Vouchar_No' => $data['Vouchar_No'],
                ':Audit_Row' => $data['Audit_Row'],
                ':SO_Dt' => $data['SO_Dt'],
                ':Advance_Amount' => $data['Advance_Amount'],
                ':GST_Type' => $data['GST_Type'],
                ':Consignee_Cust_Code' => $data['Consignee_Cust_Code'],
                ':SalesManCode' => $data['SalesManCode'],
                ':Sal_Man_Dis' => $data['Sal_Man_Dis'],
                ':Sal_Man_Dis_Amt' => $data['Sal_Man_Dis_Amt'],
                ':Ledger_Type' => $data['Ledger_Type'],
                ':Project_Name' => $data['Project_Name'],
                ':Project_Team' => $data['Project_Team'],
                ':SQ_NO' => $data['SQ_NO'],
                ':SI_COLUMN1' => $data['SI_COLUMN1'],
                ':SI_COLUMN2' => $data['SI_COLUMN2'],
                ':SI_COLUMN3' => $data['SI_COLUMN3'],
                ':SI_COLUMN4' => $data['SI_COLUMN4'],
                ':Narration_Value' => $data['Narration_Value'],
                ':Mobile_No_Quick_Cust' => $data['Mobile_No_Quick_Cust'],
                ':Address_Quick_Cust' => $data['Address_Quick_Cust'],
                ':Quick_Cust_String' => $data['Quick_Cust_String'],
                ':Invoice_No_String' => $data['Invoice_No_String'],
                ':Invoice_Year' => $data['Invoice_Year'],
                ':Total_Amount_New' => $data['Total_Amount_New'],
                ':Final_Amount_New' => $data['Final_Amount_New'],
                ':Paid_Amount_New' => $data['Paid_Amount_New'],
                ':Return_Amount_New' => $data['Return_Amount_New'],
                ':Loyalty_Point' => $data['Loyalty_Point'],
                ':Redeem_Loyalty_Point' => $data['Redeem_Loyalty_Point'],
                ':Loyalty_Value' => $data['Loyalty_Value'],
                ':User_Id' => $data['User_Id'],
                ':User_Name' => $data['User_Name'],
                ':String_Value' => $data['String_Value'],
                ':SQL_Convert_Final' => $data['SQL_Convert_Final']
        ]);
    

        // Insert into S_DTL using the new S_MTR_ID
        $s_dtl_sql = "INSERT INTO s_dtl (
            S_DTL_ID, APP_KEY_CODE, Firm_Code, Invoice_Type, App_Online_Flag, 
            S_MTR_ID, Sr_No, Invoice_No, Item_Code, Item_Name, 
            Batch_No, Exp_Dt, Unit, Size1, Qty, 
            F_Qty, Dist_Code, Pur_Rate, Selling_Rate, MRP, 
            Landing_Cost, Item_Amt, Item_Net_Amt, Round_Off, Profit, 
            Tax, Tax_Amt, Cess_Percetage, Cess_Tax_Amt, Servies_Tax, 
            Servies_Tax_Amt, ADDL_Tax, ADDL_Tax_Amt, Discount, Discount_Amt, 
            Addd_Discount, Addd_Discount_Amt, Type, Rate_Type, Remark, 
            Audit_Row, Pur_Id_Stock_Id, Sales_Man_Code, New_Unit, Height, 
            Width, Val, Tot_Square_Feet, Stock_Id_Godown, Operation1, 
            Operation1_Value, Operation2, Operation2_Value, Operation3, Operation3_Value, 
            New_Batch_No, Milk_Basic_Rate, Milk_Packing_Charges, Milk_Pack_Size, Tax_Mandi, 
            Tax_Amt_Mandi, Expiry_Date_Batch, Manufature_Date_Batch, Alternate_Unit_Stock, SALE_GST_STATUS, 
            User_Id, User_Name
        ) VALUES (
            :S_DTL_ID, :APP_KEY_CODE, :Firm_Code, :Invoice_Type, :App_Online_Flag, 
            :S_MTR_ID, :Sr_No, :Invoice_No, :Item_Code, :Item_Name, 
            :Batch_No, :Exp_Dt, :Unit, :Size1, :Qty, 
            :F_Qty, :Dist_Code, :Pur_Rate, :Selling_Rate, :MRP, 
            :Landing_Cost, :Item_Amt, :Item_Net_Amt, :Round_Off, :Profit, 
            :Tax, :Tax_Amt, :Cess_Percetage, :Cess_Tax_Amt, :Servies_Tax, 
            :Servies_Tax_Amt, :ADDL_Tax, :ADDL_Tax_Amt, :Discount, :Discount_Amt, 
            :Addd_Discount, :Addd_Discount_Amt, :Type, :Rate_Type, :Remark, 
            :Audit_Row, :Pur_Id_Stock_Id, :Sales_Man_Code, :New_Unit, :Height, 
            :Width, :Val, :Tot_Square_Feet, :Stock_Id_Godown, :Operation1, 
            :Operation1_Value, :Operation2, :Operation2_Value, :Operation3, :Operation3_Value, 
            :New_Batch_No, :Milk_Basic_Rate, :Milk_Packing_Charges, :Milk_Pack_Size, :Tax_Mandi, 
            :Tax_Amt_Mandi, :Expiry_Date_Batch, :Manufature_Date_Batch, :Alternate_Unit_Stock, :SALE_GST_STATUS, 
            :User_Id, :User_Name
        )";
        
        $stmt = $pdo->prepare($s_dtl_sql);
        foreach ($data['items'] as $item) {
            $stmt->execute([
                    ':S_DTL_ID' => $data['S_DTL_ID'],
                    ':APP_KEY_CODE' => $data['APP_KEY_CODE'],
                    ':Firm_Code' => $data['Firm_Code'],
                    ':Invoice_Type' => $data['Invoice_Type'],
                    ':App_Online_Flag' => $data['App_Online_Flag'],
                    ':S_MTR_ID' => $new_s_mtr_id,
                    ':Sr_No' => $data['Sr_No'],
                    ':Invoice_No' => $new_s_mtr_id, // Same Invoice_No as S_MTR_ID
                    ':Item_Code' => $item['Item_Code'],
                    ':Item_Name' => $item['Item_Name'],
                    ':Batch_No' => $item['Batch_No'],
                    ':Exp_Dt' => $item['Exp_Dt'],
                    ':Unit' => $item['Unit'],
                    ':Size1' => $item['Size1'],
                    ':Qty' => $item['Qty'],
                    ':F_Qty' => $item['F_Qty'],
                    ':Dist_Code' => $data['Dist_Code'],
                    ':Pur_Rate' => $item['Pur_Rate'],
                    ':Selling_Rate' => $item['Selling_Rate'],
                    ':MRP' => $item['MRP'],
                    ':Landing_Cost' => $item['Landing_Cost'],
                    ':Item_Amt' => $item['Item_Amt'],
                    ':Item_Net_Amt' => $item['Item_Net_Amt'],
                    ':Round_Off' => $data['Round_Off'],
                    ':Profit' => $data['Profit'],
                    ':Tax' => $data['Tax'],
                    ':Tax_Amt' => $item['Tax_Amt'],
                    ':Cess_Percetage' => $data['Cess_Percetage'],
                    ':Cess_Tax_Amt' => $data['Cess_Tax_Amt'],
                    ':Servies_Tax' => $data['Servies_Tax'],
                    ':Servies_Tax_Amt' => $data['Servies_Tax_Amt'],
                    ':ADDL_Tax' => $data['ADDL_Tax'],
                    ':ADDL_Tax_Amt' => $data['ADDL_Tax_Amt'],
                    ':Discount' => $item['Discount'],
                    ':Discount_Amt' => $item['Discount_Amt'],
                    ':Addd_Discount' => $data['Addd_Discount'],
                    ':Addd_Discount_Amt' => $data['Addd_Discount_Amt'],
                    ':Type' => $data['Type'],
                    ':Rate_Type' => $data['Rate_Type'],
                    ':Remark' => $data['Remark'],
                    ':Audit_Row' => $data['Audit_Row'],
                    ':Pur_Id_Stock_Id' => $data['Pur_Id_Stock_Id'],
                    ':Sales_Man_Code' => $data['Sales_Man_Code'],
                    ':New_Unit' => $item['New_Unit'],
                    ':Height' => $item['Height'],
                    ':Width' => $item['Width'],
                    ':Val' => $data['Val'],
                    ':Tot_Square_Feet' => $data['Tot_Square_Feet'],
                    ':Stock_Id_Godown' => $data['Stock_Id_Godown'],
                    ':Operation1' => $data['Operation1'],
                    ':Operation1_Value' => $data['Operation1_Value'],
                    ':Operation2' => $data['Operation2'],
                    ':Operation2_Value' => $data['Operation2_Value'],
                    ':Operation3' => $data['Operation3'],
                    ':Operation3_Value' => $data['Operation3_Value'],
                    ':New_Batch_No' => $item['New_Batch_No'],
                    ':Milk_Basic_Rate' => $data['Milk_Basic_Rate'],
                    ':Milk_Packing_Charges' => $data['Milk_Packing_Charges'],
                    ':Milk_Pack_Size' => $data['Milk_Pack_Size'],
                    ':Tax_Mandi' => $data['Tax_Mandi'],
                    ':Tax_Amt_Mandi' => $data['Tax_Amt_Mandi'],
                    ':Expiry_Date_Batch' => $item['Expiry_Date_Batch'],
                    ':Manufature_Date_Batch' => $item['Manufature_Date_Batch'],
                    ':Alternate_Unit_Stock' => $item['Alternate_Unit_Stock'],
                    ':SALE_GST_STATUS' => $data['SALE_GST_STATUS'],
                    ':User_Id' => $data['User_Id'],
                    ':User_Name' => $data['User_Name']
                
                
            ]);
        }

        // Commit transaction
        $pdo->commit();

        echo json_encode(["message" => "Record added successfully.", "inserted_data" => $data]);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(["message" => "Failed to insert data.", "error" => $e->getMessage()]);
    }
}
?>

<?php
set_time_limit(300);  // Increase script execution time to 5 minutes

require 'db.php';

try {
    $sql = "SELECT 
    m.S_MTR_ID, m.APP_KEY_CODE, m.Firm_Code, m.Invoice_Type, m.App_Online_Flag, 
    m.Invoice_No, m.Invoice_Date, m.Bill_No, m.Vat_Status, m.SD_No, m.SD_Dt, 
    m.SO_No, m.Cust_Code, m.Cust_Name, m.Bill_Status, m.Tot_Item, m.Payment_Type, 
    m.S_Amt, m.S_GAmt, m.Round_Off, m.Profit, m.Disc, m.Disc_Amt, m.Tax, m.Tax_Amt, 
    m.Cess_Tax_Amt, m.Servies_Tax, m.Servies_Tax_Amt, m.ADDL_Tax, m.ADDL_Tax_Amt, 
    m.Packing_Chrg, m.Packing_Chrg_Pre, m.Dely_Chrg, m.Dely_Chrg_Pre, m.Misc_Chrg, 
    m.Freight_Chrg, m.Dely_Boy_Code, m.Sales_Man_Code, m.Transport, m.Spng_Name, 
    m.Spng_Addr1, m.Spng_Addr2, m.Spng_Addr3, m.Spng_Addr4, m.Spng_State, 
    m.Spng_Pincode, m.Spng_Mobile_No, m.Card_No, m.Card_Name, m.Card_Hld_Name, 
    m.Card_Exp_Date, m.Card_Ad_No, m.Card_Slip_No, m.Cash_Amt, m.Cheque_Amt, 
    m.Card_Amt, m.Credit_Amt, m.Card_Servies_Tax, m.Card_Servies_Tax_Amt, 
    m.Rate_Type, m.Remark, m.Vouchar_No, m.Audit_Row, m.SO_Dt, m.Advance_Amount, 
    m.GST_Type, m.Consignee_Cust_Code, m.SalesManCode, m.Sal_Man_Dis, 
    m.Sal_Man_Dis_Amt, m.Ledger_Type, m.Project_Name, m.Project_Team, m.SQ_NO, 
    m.SI_COLUMN1, m.SI_COLUMN2, m.SI_COLUMN3, m.SI_COLUMN4, m.Narration_Value, 
    m.Mobile_No_Quick_Cust, m.Address_Quick_Cust, m.Quick_Cust_String, 
    m.Invoice_No_String, m.Invoice_Year, m.Total_Amount_New, m.Final_Amount_New, 
    m.Paid_Amount_New, m.Return_Amount_New, m.Loyalty_Point, m.Redeem_Loyalty_Point, 
    m.Loyalty_Value, m.User_Id, m.User_Name, m.String_Value, m.SQL_Convert_Final,
    d.S_DTL_ID, d.APP_KEY_CODE, d.Firm_Code, d.Invoice_Type, d.App_Online_Flag, 
    d.Sr_No, d.Item_Code, d.Item_Name, d.Batch_No, d.Exp_Dt, d.Unit, d.Size1, 
    d.Qty, d.F_Qty, d.Dist_Code, d.Pur_Rate, d.Selling_Rate, d.MRP, d.Landing_Cost, 
    d.Item_Amt, d.Item_Net_Amt, d.Round_Off, d.Profit, d.Tax, d.Tax_Amt, 
    d.Cess_Percetage, d.Cess_Tax_Amt, d.Servies_Tax, d.Servies_Tax_Amt, 
    d.ADDL_Tax, d.ADDL_Tax_Amt, d.Discount, d.Discount_Amt, d.Addd_Discount, 
    d.Addd_Discount_Amt, d.Type, d.Rate_Type, d.Remark, d.Audit_Row, 
    d.Pur_Id_Stock_Id, d.Sales_Man_Code, d.New_Unit, d.Height, d.Width, d.Val, 
    d.Tot_Square_Feet, d.Stock_Id_Godown, d.Operation1, d.Operation1_Value, 
    d.Operation2, d.Operation2_Value, d.Operation3, d.Operation3_Value, 
    d.New_Batch_No, d.Milk_Basic_Rate, d.Milk_Packing_Charges, d.Milk_Pack_Size, 
    d.Tax_Mandi, d.Tax_Amt_Mandi, d.Expiry_Date_Batch, d.Manufature_Date_Batch, 
    d.Alternate_Unit_Stock, d.SALE_GST_STATUS, d.User_Id, d.User_Name
            FROM S_MTR m
            LEFT JOIN S_DTL d ON m.S_MTR_ID = d.S_MTR_ID";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch (Exception $e) {
    echo json_encode(["message" => "Failed to fetch data.", "error" => $e->getMessage()]);
}
?>

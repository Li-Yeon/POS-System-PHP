<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';

//Get Transaction ID
if (isset($_GET['print'])){
    $transID = $_GET['print'];   

    //Get Transaction Date
    $getDateQuery = "SELECT Date from transaction WHERE TransID='$transID' LIMIT 1";
    $getDateSqli = mysqli_query($conn, $getDateQuery);
    $getDate = mysqli_fetch_assoc($getDateSqli);
    $getDate = $getDate['Date'];
    $getDate = date("d-m-Y", strtotime($getDate));

    //Get Customer Name
    $getCustQuery = "SELECT IFNULL( (SELECT Cust_Name FROM transaction WHERE TransID = '$transID' LIMIT 1) ,'Null') As 'Cust_Name'";
    $getCustSqli = mysqli_query($conn, $getCustQuery);
    $getCust = mysqli_fetch_assoc($getCustSqli);
    $getCust = $getCust['Cust_Name'];
    if ($getCust == "Null")
    {
        $getCust = "Null";
        $getAddress = "Null";
    }
    else{
        //Get Customer Address
        $custAddressQuery = "SELECT Cust_Address FROM transaction WHERE TransID = '$transID' LIMIT 1";
        $custAddressSqli = mysqli_query($conn, $custAddressQuery);
        $getAddress = mysqli_fetch_assoc($custAddressSqli);
        $getAddress = $getAddress['Cust_Address'];
    }
 
    //Transaction Table
    $transactionQuery = "SELECT * FROM transaction WHERE TransID='$transID'";
    $transactionTable = mysqli_query($conn, $transactionQuery);

    //Transaction Table
    $transactionQuery2 = "SELECT Product_Name, Price, Quantity, Total FROM transaction WHERE TransID='$transID'";
    $transactionTable2 = mysqli_query($conn, $transactionQuery2);

    //Get Grand Total
    $getGrandTotalQuery = "SELECT SUM(Total) As Total from transaction WHERE TransID='$transID'";
    $getGrandTotalSqli = mysqli_query($conn, $getGrandTotalQuery);
    $getGrandTotal = mysqli_fetch_assoc($getGrandTotalSqli);
    $getGrandTotal = $getGrandTotal['Total'];
}  


// (A) LOAD INVOICR
require "invoicr-master/invlib/invoicr.php";

// (B) SET INVOICE DATA
// (B1) COMPANY INFORMATION
$invoicr->set("company", [
	"assets/images/loginlogo.png",
	"assets/images/loginlogo.png", 
	"LiyeonTech", 
	"Kenampang, Kota Kinabunan, Sabah",
	"Phone: 010-2151169",
    "liyeontech@gmail.com",
]); 

// (B2) INVOICE HEADER
$invoicr->set("head", [
	["Invoice #", $transID],
	["Date", $getDate]
]);

// (B3) BILL TO
$invoicr->set("billto", [
	$getCust,
    "",
    "",
    ""
]);

// (B4) SHIP TO
$invoicr->set("shipto", [
    $getAddress,
    "",
    "",
    ""
]);

// (B5) ITEMS - ADD ONE-BY-ONE
$items = [];

//foreach ($items as $i) { $invoicr->add("items", $i); }
  
//(B6) ITEMS - OR SET ALL AT ONCE
$invoicr->set("items", $transID);

// (B7) TOTALS
$invoicr->set("totals", [
	["GRAND TOTAL", "RM".$getGrandTotal]
]);

// (B8) NOTES, IF ANY
$invoicr->set("notes", [

]);

// (C) OUTPUT
// (C1) CHOOSE A TEMPLATE
//$invoicr->template("apple");
 $invoicr->template("simple");
// $invoicr->template("lime");
// $invoicr->template("simple");
// $invoicr->template("strawberry");

$invoicr->outputHTML();

// (C3) OUTPUT IN PDF
// DEFAULT : DISPLAY IN BROWSER 
// 1 : DISPLAY IN BROWSER 
// 2 : FORCE DOWNLOAD 
// 3 : SAVE ON SERVER
// $invoicr->outputPDF();
// $invoicr->outputPDF(1);
// $invoicr->outputPDF(2, "invoice.pdf");
// $invoicr->outputPDF(3, __DIR__ . DIRECTORY_SEPARATOR . "invoice.pdf");
?>
<script>
    window.print();
</script>
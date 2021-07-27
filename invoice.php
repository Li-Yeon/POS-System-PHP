<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';

//Get Company Name
$sql = "SELECT CompanyName FROM companydetails";
$getData = mysqli_query($conn, $sql) or die (mysqli_error($conn));

//Company Name
$companyName = mysqli_fetch_assoc($getData);
$companyName = $companyName['CompanyName'];

//-----------------------------------------------//

//Get Company Address
$sql2 = "SELECT CompanyAddress FROM companydetails";
$getData2 = mysqli_query($conn, $sql2) or die (mysqli_error($conn));

//Company Address
$companyAddress = mysqli_fetch_assoc($getData2);
$companyAddress = nl2br($companyAddress['CompanyAddress']);

//-----------------------------------------------//

//Get Company Tel
$sql3 = "SELECT CompanyTel FROM companydetails";
$getData3 = mysqli_query($conn, $sql3) or die (mysqli_error($conn));

//Company Tel
$companyTel = mysqli_fetch_assoc($getData3);
$companyTel = nl2br($companyTel['CompanyTel']);

//-----------------------------------------------//

//Get Company Email
$sql4 = "SELECT CompanyEmail FROM companydetails";
$getData4 = mysqli_query($conn, $sql4) or die (mysqli_error($conn));

//Company Email
$companyEmail = mysqli_fetch_assoc($getData4);
$companyEmail = nl2br($companyEmail['CompanyEmail']);

//-----------------------------------------------//

//Check for Product Duplication
$companyLogoQuery = "SELECT IFNULL( (SELECT CompanyLogo FROM companydetails WHERE No = 1 LIMIT 1) ,'Null') As 'Image'";
$companyLogoSqli = mysqli_query($conn, $companyLogoQuery);
$companyLogo = mysqli_fetch_assoc($companyLogoSqli);
$companyLogo = $companyLogo['Image'];

if ($companyLogo == "NULL")
{
    $companyLogo = "-";
}
else
{
    $companyLogo = "uploads/CompanyLogo.png";
}

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
	$companyLogo,
	$companyLogo, 
	$companyName, 
	$companyAddress,
	"Phone: $companyTel",
    $companyEmail,
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
$invoicr->template("blueberry");
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
//$invoicr->outputPDF(2, "invoice.pdf");
// $invoicr->outputPDF(3, __DIR__ . DIRECTORY_SEPARATOR . "invoice.pdf");
?>
<script>
    window.print();
</script>
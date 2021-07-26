<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';

$currentUser = $_SESSION['currentUser'];
$getCurrentUserQuery = "SELECT Name from users WHERE Username=" . "'" . $currentUser . "'";
$getCurrentUserSqli = mysqli_query($conn, $getCurrentUserQuery);
$getCurrentUser = mysqli_fetch_assoc($getCurrentUserSqli);
$getCurrentUser = $getCurrentUser['Name'];

//Get Product Information
$productQuery = "SELECT * FROM products ORDER BY No ASC";
$productRes = mysqli_query($conn, $productQuery);

//Get Customer Information
$customerQuery = "SELECT * FROM customers ORDER BY No ASC";
$customerRes = mysqli_query($conn, $customerQuery);

 //Check if transaction are empty
 $checkrowQuery = "SELECT COUNT(1) AS 'Kiyeru' FROM transaction";
 $checkrowSqli = mysqli_query($conn, $checkrowQuery);
 $checkrow = mysqli_fetch_assoc($checkrowSqli);
 $checkrow = $checkrow['Kiyeru'];

 $transDate = date("Ymd");
 if ($checkrow == '0')
 {
     $transNo = "0001";
 }
 else
 {        
     //Get Current TransID
     $getCurrentTransQuery = "SELECT TransID as 'Latest' FROM transaction ORDER BY No DESC LIMIT 1";
     $getCurrentTransSqli = mysqli_query($conn, $getCurrentTransQuery);
     $getCurrentTrans = mysqli_fetch_assoc($getCurrentTransSqli);
     $getCurrentTrans =  $getCurrentTrans['Latest'];
     $latestTrans = substr($getCurrentTrans, 8);
     $latestTrans = (int)$latestTrans;
     $transNo = $latestTrans + 1;
     $transNo = sprintf("%04d", $transNo);       
 }
 $transID = $transDate . $transNo;

 //Add Item
 if(isset($_POST['CheckOutbtn']))
 {
     $date_Entry=$_POST['date_Entry'];
     $product_ID=$_POST['product_ID'];
     $price=$_POST['price'];
     $stock=$_POST['stock'];
     $outgoingstock=$_POST['outgoingstock'];
     $discount=$_POST['discount'];
     $totalstock=$_POST['totalstock'];
     $totalPrice=$_POST['totalPrice'];
     
     //Get Product Name
     $getProductNameQuery = "SELECT Product_Name from products where Product_ID=" . "'" . $product_ID . "'";
     $getProductNameSqli = mysqli_query($conn, $getProductNameQuery) or die (mysqli_error($conn));
     $getProductName = mysqli_fetch_assoc($getProductNameSqli);
     $getProductName = $getProductName['Product_Name'];

     //Get Stock
     $getCurrentStockQuery = "SELECT Stock from products where Product_ID=" . "'" . $product_ID . "'";
     $getCurrentStockSqli = mysqli_query($conn, $getCurrentStockQuery) or die (mysqli_error($conn));
     $getCurrentStock = mysqli_fetch_assoc($getCurrentStockSqli);
     $getCurrentStock = $getCurrentStock['Stock'];

     //Check for Product Duplication
     $checkIDDuplicateCartQuery = "SELECT IFNULL( (SELECT Product_ID FROM checkout WHERE Product_ID = '$product_ID' LIMIT 1) ,'Null') As 'ID'";
     $checkIDDuplicateCartSqli = mysqli_query($conn, $checkIDDuplicateCartQuery);
     $checkIDDuplicateCart = mysqli_fetch_assoc($checkIDDuplicateCartSqli);
     $checkIDDuplicateCart = $checkIDDuplicateCart['ID'];

         if($checkIDDuplicateCart == "Null")
         {
         $insert = "INSERT INTO checkout (TransID, Product_ID, Product_Name, Price, Quantity, Discount, Total, Date, Issued) values ('$transID', '$product_ID', '$getProductName', '$price', '$outgoingstock', '$discount', '$totalPrice', '$date_Entry', '$getCurrentUser')";
         $result = mysqli_query($conn, $insert);
         } 
         else
         {
          $getCartTableStockQuery = "SELECT Quantity from checkout WHERE Product_ID=" . "'" . $product_ID . "'";
          $getCartTableStockSqli = mysqli_query($conn, $getCartTableStockQuery);
          $getCartTableStock = mysqli_fetch_assoc($getCartTableStockSqli);
          $getCartTableStock = $getCartTableStock['Quantity'];
          
          $upatedStock = $getCartTableStock + $outgoingstock;
          $updateCartTableQuery = "UPDATE checkout SET Quantity='$upatedStock' WHERE Product_ID='$product_ID'"; 
          $updateCartTableSqli = mysqli_query($conn, $updateCartTableQuery);
          
          $getCartTableDiscountQuery = "SELECT Discount from checkout WHERE Product_ID=" . "'" . $product_ID . "'";
          $getCartTableDiscountSqli = mysqli_query($conn, $getCartTableDiscountQuery);
          $getCartTableDiscount = mysqli_fetch_assoc($getCartTableDiscountSqli);
          $getCartTableDiscount = $getCartTableDiscount['Discount'];

          $upatedDiscount = $getCartTableDiscount + $discount;
          $updateCartTableDiscountQuery = "UPDATE checkout SET Discount='$upatedDiscount' WHERE Product_ID='$product_ID'"; 
          $updateCartTableDiscountSqli = mysqli_query($conn, $updateCartTableDiscountQuery);

          $getCartTableTotalQuery = "SELECT Total from checkout WHERE Product_ID=" . "'" . $product_ID . "'";
          $getCartTableTotalSqli = mysqli_query($conn, $getCartTableTotalQuery);
          $getCartTableTotal = mysqli_fetch_assoc($getCartTableTotalSqli);
          $getCartTableTotal = $getCartTableTotal['Total'];

          $upatedTotal = $getCartTableTotal + $totalPrice;
          $updateCartTableTotalQuery = "UPDATE checkout SET Total='$upatedTotal' WHERE Product_ID='$product_ID'"; 
          $updateCartTableTotalSqli = mysqli_query($conn, $updateCartTableTotalQuery);
         }           
         $finalStock = $getCurrentStock - $outgoingstock;
         $updateProductQuery = "UPDATE products SET Stock = '$finalStock' WHERE Product_ID ='$product_ID'";
         $updateProductSqli = mysqli_query($conn, $updateProductQuery) or die (mysqli_error($conn));
}


if(isset($_POST['addTransaction']))
    {
        //Check if checkout table empty
        $checkchkQuery = "SELECT COUNT(1) AS 'Empty' FROM checkout";
        $checkchkSqli = mysqli_query($conn, $checkchkQuery);
        $checkchk = mysqli_fetch_assoc($checkchkSqli);
        $checkchk = $checkchk['Empty'];

        if ($checkchk == '0')
        {
            echo '<script>alert("Empty cart! Please add items before proceeding.")</script>';
        }
        else
        {

        }

        $custName = $_POST['cust_Name'];
        
        //Duplicate Data to Transaction
        $copyDataToTransQuery = "INSERT INTO transaction (TransID, Product_ID, Product_Name, Price, Quantity, Discount, Total, Date, Issued)SELECT TransID, Product_ID, Product_Name, Price, Quantity, Discount, Total, Date, Issued FROM checkout";
        $copyDataToTransSqli = mysqli_query($conn, $copyDataToTransQuery);

        if ($custName == "-")
        {
            //Insert Customer Info in Transaction
            $insertCustQuery = "UPDATE transaction SET Cust_Name = '-', Cust_Address = '-' WHERE TransID = '$transID'";
            $insertCustSqli = mysqli_query($conn, $insertCustQuery) or die (mysqli_error($conn));
            echo $transID;
        }
        else
        {
            //Get Cust Info
            $getCustInfoQuery = "SELECT Cust_Address from customers where Cust_Name='$custName'";
            $getCustInfoSqli = mysqli_query($conn, $getCustInfoQuery);
            $getCustInfo = mysqli_fetch_assoc($getCustInfoSqli);
            $getCustInfo = $getCustInfo['Cust_Address'];
            //Insert Customer Info in Transaction
            $insertCustQuery = "UPDATE transaction SET Cust_Name = '$custName', Cust_Address = '$getCustInfo' WHERE TransID = '$transID'";
            $insertCustSqli = mysqli_query($conn, $insertCustQuery) or die (mysqli_error($conn));
            echo  $transID;
        }

        //Truncate Checkout
        $truncateCheckoutTableQuery = "TRUNCATE TABLE checkout";
        $truncateCheckoutTable = mysqli_query($conn, $truncateCheckoutTableQuery);      

        //Fix Auto Increment
        $fixIncrementQuery = "ALTER TABLE transaction DROP No;ALTER TABLE transaction AUTO_INCREMENT = 1;ALTER TABLE transaction ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
        $resetIncrement = mysqli_multi_query($conn, $fixIncrementQuery);
        echo '<script>location.href="./checkout.php"</script>';
}

//Delete Item
if (isset($_GET['delete'])){
        $idP = $_GET['delete'];
    
        //Get Product ID
        $getProductIDDeleteQuery = "SELECT Product_ID from checkout where No='$idP'";
        $getProductIDDeleteSqli = mysqli_query($conn, $getProductIDDeleteQuery);
        $getProductIDDelete = mysqli_fetch_assoc($getProductIDDeleteSqli);
        $getProductIDDelete = $getProductIDDelete['Product_ID'];
    
        $checkoutStockQuery = "SELECT Quantity As 'Qty' from checkout where No=$idP";
        $checkoutStockSqli = mysqli_query($conn, $checkoutStockQuery);
        $checkoutStock = mysqli_fetch_assoc($checkoutStockSqli );
        $checkoutStock = $checkoutStock['Qty'];
    
        //Get Stock
        $getCurrentStockQuery = "SELECT Stock from products where Product_ID=" . "'" . $getProductIDDelete . "'";
        $getCurrentStockSqli = mysqli_query($conn, $getCurrentStockQuery);
        $getCurrentStock = mysqli_fetch_assoc($getCurrentStockSqli);
        $getCurrentStock = $getCurrentStock['Stock'];
    
        $finalStock = $getCurrentStock + $checkoutStock;
        $updateProductQuery = "UPDATE products SET Stock = '$finalStock' WHERE Product_ID ='$getProductIDDelete'";
        $updateProductSqli = mysqli_query($conn, $updateProductQuery) or die (mysqli_error($conn));
        $query = "DELETE FROM checkout WHERE No = '$idP'";
        $reset = "ALTER TABLE checkout DROP No;ALTER TABLE checkout AUTO_INCREMENT = 1;ALTER TABLE checkout ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";   
        $resultDelete = mysqli_query($conn, $query);
        $resetIncrement = mysqli_multi_query($conn, $reset);
        echo '<script>location.href="./checkout.php"</script>';
}  



?>
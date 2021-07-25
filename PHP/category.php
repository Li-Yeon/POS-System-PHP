<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';
$currentUser = $_SESSION['currentUser'];
$getCurrentUserQuery = "SELECT Name from users WHERE Username=" . "'" . $currentUser . "'";
$getCurrentUserSqli = mysqli_query($conn, $getCurrentUserQuery);
$getCurrentUser = mysqli_fetch_assoc($getCurrentUserSqli);
$getCurrentUser = $getCurrentUser['Name'];

//Get Category Info
$sql = "SELECT * FROM category ORDER BY No ASC";
$result = mysqli_query($conn, $sql) or die (mysqli_error($conn));

//Get Category No
$getCatNoQuery = "SELECT IFNULL( (SELECT No FROM Category ORDER BY No DESC LIMIT 1) ,'Null') As 'No'";
$getCatNoSqli = mysqli_query($conn, $getCatNoQuery) or die (mysqli_error($conn));
$getCatNo = mysqli_fetch_assoc($getCatNoSqli);
$getCatNo = $getCatNo['No'];

if ($getCatNo == "Null")
{
    $nextNo = 1;
}
else
{
    $nextNo = $getCatNo + 1;

}

//Add Category
if(isset($_POST['addCategory']))
{

        $category_Name=$_POST['category'];

        $insertCategoryQuery = "INSERT INTO category (Category) values ('$category_Name')";
        $insertCategorySqli = mysqli_query($conn, $insertCategoryQuery) or die (mysqli_error($conn));
        $reset = "ALTER TABLE category DROP No;ALTER TABLE category AUTO_INCREMENT = 1;ALTER TABLE category ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
        $resetIncrement = mysqli_multi_query($conn, $reset);
        $_SESSION['status'] = "Category successfully added!";


}

//Delete Category
if (isset($_GET['delete'])){
    $No = $_GET['delete'];
    $query = "DELETE FROM category WHERE No = '$No'";
    $reset = "ALTER TABLE category DROP No;ALTER TABLE category AUTO_INCREMENT = 1;ALTER TABLE category ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
    $resultDelete = mysqli_query($conn, $query) or die (mysqli_error($conn));
    $resetIncrement = mysqli_multi_query($conn, $reset);
    echo '<script>location.href="./category.php"</script>';
}  

//Get Category Data
if (isset($_GET['edit'])){
    $idP = $_GET['edit'];
    $query = "SELECT * FROM category WHERE No = '$idP'";
    $getData = mysqli_query($conn, $query);
}  

//Update Category Details
if(isset($_POST['editCategory']))
{
    $category_Name=$_POST['category'];

    $update = "UPDATE category SET Category = '$category_Name' WHERE No = '$idP'";
    $result = mysqli_query($conn, $update) or die (mysqli_error($conn));    
    echo '<script>location.href="./category.php"</script>';
}
?>
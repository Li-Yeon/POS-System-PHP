<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/vendor/autoload.php';

$sql = "SELECT * from transaction";
$query = mysqli_query($conn, $sql);

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$Excel_writer = new Xlsx($spreadsheet);

$spreadsheet -> setActiveSheetIndex(0);
$activeSheet = $spreadsheet -> getActiveSheet();


$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);


$activeSheet -> setCellValue('A1', 'Transaction ID');
$activeSheet -> setCellValue('B1', 'Product ID');
$activeSheet -> setCellValue('C1', 'Product Name');
$activeSheet -> setCellValue('D1', 'Price');
$activeSheet -> setCellValue('E1', 'Quantity');
$activeSheet -> setCellValue('F1', 'Discount');
$activeSheet -> setCellValue('G1', 'Total');
$activeSheet -> setCellValue('H1', 'Date');
$activeSheet -> setCellValue('I1', 'Issued By');
$activeSheet -> setCellValue('J1', 'Customer Name');
$activeSheet -> setCellValue('K1', 'Customer Address');


if(mysqli_num_rows($query) > 0)
{
    $no = 2;
    while ($row = mysqli_fetch_assoc($query))
    {
        $activeSheet -> setCellValue('A'.$no, "'".$row['TransID']);
        $activeSheet -> setCellValue('B'.$no, $row['Product_ID']);
        $activeSheet -> setCellValue('C'.$no, $row['Product_Name']);
        $activeSheet -> setCellValue('D'.$no, $row['Price']);
        $activeSheet -> setCellValue('E'.$no, $row['Quantity']);
        $activeSheet -> setCellValue('F'.$no, $row['Discount']);
        $activeSheet -> setCellValue('G'.$no, $row['Total']);
        $activeSheet -> setCellValue('H'.$no, $row['Date']);
        $activeSheet -> setCellValue('I'.$no, $row['Issued']);
        $activeSheet -> setCellValue('J'.$no, $row['Cust_Name']);
        $activeSheet -> setCellValue('K'.$no, $row['Cust_Address']);
        $no++;
    }
}

$filename = 'Transactions.xlsx';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max=age=0');
$Excel_writer -> save('php://output');
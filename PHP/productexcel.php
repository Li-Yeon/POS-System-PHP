<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/vendor/autoload.php';

$sql = "SELECT * from products";
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

$activeSheet -> setCellValue('A1', 'Product ID');
$activeSheet -> setCellValue('B1', 'Product Name');
$activeSheet -> setCellValue('C1', 'Stock');
$activeSheet -> setCellValue('D1', 'Category');
$activeSheet -> setCellValue('E1', 'Price');
$activeSheet -> setCellValue('F1', 'Barcode');
$activeSheet -> setCellValue('G1', 'Image');


if(mysqli_num_rows($query) > 0)
{
    $no = 2;
    while ($row = mysqli_fetch_assoc($query))
    {
        $activeSheet -> setCellValue('A'.$no, $row['Product_ID']);
        $activeSheet -> setCellValue('B'.$no, $row['Product_Name']);
        $activeSheet -> setCellValue('C'.$no, $row['Stock']);
        $activeSheet -> setCellValue('D'.$no, $row['Category']);
        $activeSheet -> setCellValue('E'.$no, $row['Price']);
        $activeSheet -> setCellValue('F'.$no, $row['Barcode']);
        $activeSheet -> setCellValue('G'.$no, $row['Image']);
        $no++;
    }
}

$filename = 'Products.xlsx';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max=age=0');
$Excel_writer -> save('php://output');
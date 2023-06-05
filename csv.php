<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
if($_GET['backlinks']=='backlinks'){
    $sheet->setCellValue('A1', 'backlink_url');
    $sheet->setCellValue('B1', 'username');
    $sheet->setCellValue('C1', 'password');
    $filename = 'backlinks.xlsx';
}

if($_GET['master_backlinks']=='master_backlinks'){
    $sheet->setCellValue('A1', 'backlink');
    $filename = 'master_backlinks.xlsx';

}

if($_GET['cpanels']=='cpanels'){
    $sheet->setCellValue('A1', 'url');
    $sheet->setCellValue('B1', 'login');
    $sheet->setCellValue('C1', 'password');
    $filename = 'master_backlinks.xlsx';
}

if($_GET['cms']=='cms'){
    $sheet->setCellValue('A1', 'url');
    $sheet->setCellValue('B1', 'login');
    $sheet->setCellValue('C1', 'password');
    $filename = 'master_backlinks.xlsx';
}

if($_GET['articlesinfo']=='articlesinfo'){
    $sheet->setCellValue('A1', 'url');
    $filename = 'articlesinfo.xlsx';
}

$writer = new Xlsx($spreadsheet);
$writer->save($filename);

header('Content-Description: File Transfer');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"".basename($filename)."\"");
header("Content-Transfer-Encoding: binary");
header("Expires: 0");
header("Pragma: public");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-Length: ' . filesize($filename)); //Remove

ob_clean();
flush();

readfile($filename);

?>
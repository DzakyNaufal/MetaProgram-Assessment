<?php

require 'vendor/autoload.php';

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('Question MP_Formatted.xlsx');
$worksheet = $spreadsheet->getActiveSheet();
$data = $worksheet->toArray();

echo json_encode($data);

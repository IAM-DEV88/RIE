<?php 
// Load the database configuration file 
include_once 'conn.php'; 
 
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 
// Excel file name for download 
$fileName = "RIE_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('ID', 'TIPO', 'DESCRIPCION', 'REFERIDO', 'FECHA', 'MONTO'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
$query = $pdo->query("SELECT * FROM libro ORDER BY fecha ASC"); 
if($query->fetch() > 0){ 
    // Output each row of the data 
    while($row = $query->fetch()){
        $lineData = array($row['id'], $row['tipo'], $row['descripcion'], $row['referido'], $row['fecha'], $row['monto']); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
}else{ 
    $excelData .= 'Ningun registro encontrado...'. "\n"; 
}
// var_dump($excelData);
 
// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
 
exit;
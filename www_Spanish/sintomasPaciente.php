<?php
include('session_check.php');
include('mysql.php');

$pacienteId = $_GET['pacienteId'];
$queryResult = $mysqlConnection->query("select * from calendario_sintomas where id_usuario = {$pacienteId}");
$jsonOutput = array();
if ($queryResult) {
    $jsonArray = array();
    while ($currentTableRow = $queryResult->fetch_assoc())
        $jsonArray[] = $currentTableRow;
    $jsonOutput["data"] = $jsonArray;
} else {
    $jsonOutput["error"] = true;
    $jsonOutput["message"] = "Select sintomas error";
}
echo json_encode($jsonOutput);
$mysqlConnection->close();

?>
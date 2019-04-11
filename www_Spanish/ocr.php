<?php
include('session_check.php');
include('mysql.php');

$query = "SELECT * FROM palabras_prohibidas";
$queryResult = $mysqlConnection->query($query);
$jsonOutput = array();
if ($queryResult && $queryResult->num_rows > 0) {
    $jsonArray = array();
    while ($currentTableRow = $queryResult->fetch_assoc())
        $jsonArray[] = $currentTableRow;
    $jsonOutput["data"] = $jsonArray;
} else {
    $jsonOutput["error"] = true;
    $jsonOutput["message"] = "Select forbidden words error";
}
echo json_encode($jsonOutput);
$mysqlConnection->close();
?>
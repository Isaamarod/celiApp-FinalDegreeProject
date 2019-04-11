<?php
include('session_check.php');
include('mysql.php');

$idUsuario = $_SESSION['user']['idUsuario'];
$queryResult = $mysqlConnection->query("select * from usuario u, pacientes_medico m where m.medico_id = {$idUsuario} and m.paciente_id = u.idUsuario");
$jsonOutput = array();
if ($queryResult) {
    $jsonArray = array();
    while ($currentTableRow = $queryResult->fetch_assoc())
        $jsonArray[] = $currentTableRow;
    $jsonOutput["data"] = $jsonArray;
} else {
    $jsonOutput["error"] = true;
    $jsonOutput["message"] = "Select pacientes error";
}
echo json_encode($jsonOutput);
$mysqlConnection->close();

?>
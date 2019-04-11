<?php
include('session_check.php');
include('mysql.php');
$start = $_REQUEST['from'] / 1000;
$end = $_REQUEST['to'] / 1000;
$usuario = $_SESSION['user']['idUsuario'];
$queryResult=$mysqlConnection->query("SELECT *, UNIX_TIMESTAMP(fecha) as fecha FROM calendario_sintomas WHERE fecha BETWEEN FROM_UNIXTIME({$start}) and FROM_UNIXTIME({$end}) and id_usuario = {$usuario}");
$jsonOutput = array();
if($queryResult && $queryResult->num_rows > 0){
    $jsonOutput["success"] = 1;
    $jsonArray = array();
    while($currentTableRow = $queryResult->fetch_assoc()) {
        $data = array();
        $data["id"] = $currentTableRow["id"];
        $fecha = $currentTableRow["fecha"];
        $data["title"] = "Sintomas a las ".date('H:i', $fecha + 3600);
        $data["start"] = $fecha * 1000;
        $data["end"] = $fecha * 1000;
        $data["class"] = "event-special";
        $data["event_data"] = $currentTableRow;
        $jsonArray[] = $data;
    }
    $jsonOutput["result"] = $jsonArray;
}else{
    $jsonOutput["success"] = 1;
    $jsonOutput["result"] = array();
}
echo json_encode($jsonOutput);
$mysqlConnection->close();
?>


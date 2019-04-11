<?php
include('session_check.php');
include('mysql.php');

$inputJson = json_decode(file_get_contents('php://input'), true);

$valoracion = $inputJson['valoracion']; // con el unixtime de despues lo convierto a fecha normal para poder almacenarlo
$idProducto= $inputJson['idProducto'];
$idUsuario = $_SESSION['user']['idUsuario'];

$queryResult=$mysqlConnection->query("INSERT INTO valoraciones (valoracion, id_producto, id_usuario) VALUES ({$valoracion}, {$idProducto}, {$idUsuario})");
$jsonOutput = array();
if($queryResult){
    $jsonOutput["success"] = true;
}else{
    $jsonOutput["error"] = true;
    $jsonOutput["query"] = $query;
}
echo json_encode($jsonOutput);
$mysqlConnection->close();
?>


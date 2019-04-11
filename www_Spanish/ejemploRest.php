<?php
$inputJson = json_decode(file_get_contents('php://input'), true);

$recibidoJSON = $inputJson['keyEjemplo'];

$outputJSON = array();
$outputJSON['respuesta'] = array();
$outputJSON['respuesta']['recibido'] = $recibidoJSON;
$outputJSON['respuesta']['enviado'] = 'OK';

echo json_encode($outputJSON);
?>
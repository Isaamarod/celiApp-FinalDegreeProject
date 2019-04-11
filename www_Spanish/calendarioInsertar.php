<?php
include('session_check.php');
include('mysql.php');
$inputJson = json_decode(file_get_contents('php://input'), true);// dECODIFICA LOS DATOS BINARIOS QUE RECBE DLE SERVIDOR
//LOS COJO LOS METO EN UNA VARIABLE


$fecha = $inputJson['fecha']/1000; // con el unixtime de despues lo convierto a fecha normal para poder almacenarlo
$valor_analitica1= $inputJson['valor_analitica1'];
$valor_analitica2= $inputJson['valor_analitica2'];
$valor_analitica3= $inputJson['valor_analitica3'];
$valor_analitica4= $inputJson['valor_analitica4'];
$valor_analitica5= $inputJson['valor_analitica5'];
$valor_analitica6= $inputJson['valor_analitica6'];
$valor_analitica7= $inputJson['valor_analitica7'];
$valor_analitica8= $inputJson['valor_analitica8'];
$valor_analitica9= $inputJson['valor_analitica9'];
$valor_analitica10= $inputJson['valor_analitica10'];
$estado_animico= $inputJson['estado_animico'];
$id_dolores_articulares= $inputJson['id_dolores_articulares'];
$test_fecal= $inputJson['test_fecal'];
$id_sintomas= $inputJson['id_sintomas'];
$apetito= $inputJson['apetito'];
$control_peso= $inputJson['control_peso'];
$datos_menstruales1_fecha_inicio= $inputJson['datos_menstruales1_fecha_inicio'];
$datos_menstruales2_fecha_fin= $inputJson['datos_menstruales2_fecha_fin'];
$datos_menstruales3_dolor= $inputJson['datos_menstruales3_dolor'];
$datos_menstruales4_sangrado= $inputJson['datos_menstruales4_sangrado'];
$datos_menstruales5_anticonceptivo= $inputJson['datos_menstruales5_anticonceptivo'];
$test_orina= $inputJson['test_orina'];

$usuario = $_SESSION['user']['idUsuario']; //todo change to session
$query = "INSERT INTO calendario_sintomas (id_usuario, fecha, valor_analitica1,valor_analitica2,valor_analitica3,valor_analitica4,valor_analitica5, valor_analitica6,valor_analitica7,valor_analitica8,valor_analitica9,valor_analitica10,estado_animico,id_dolores_articulares,test_fecal,id_sintomas, apetito, control_peso,datos_menstruales1_fecha_inicio,datos_menstruales2_fecha_fin, datos_menstruales3_dolor,datos_menstruales4_sangrado, datos_menstruales5_anticonceptivo,test_orina) VALUES ({$usuario}, FROM_UNIXTIME({$fecha}),{$valor_analitica1},{$valor_analitica2}, {$valor_analitica3}, {$valor_analitica4}, {$valor_analitica5}, {$valor_analitica6}, {$valor_analitica7}, {$valor_analitica8}, {$valor_analitica9}, {$valor_analitica10}, {$estado_animico}, {$id_dolores_articulares}, {$test_fecal}, {$id_sintomas}, {$apetito} ,{$control_peso}, {$datos_menstruales1_fecha_inicio}, {$datos_menstruales2_fecha_fin}, {$datos_menstruales3_dolor}, {$datos_menstruales4_sangrado}, {$datos_menstruales5_anticonceptivo},{$test_orina})";

$queryResult=$mysqlConnection->query($query);
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


<?php
$inputJson = json_decode(file_get_contents('php://input'), true);// dECODIFICA LOS DATOS BINARIOS QUE RECBE DLE SERVIDOR
//LOS COJO LOS METO EN UNA VARIABLE


$fecha = $inputJson['fecha']/1000; // con el unixtime de despues lo convierto a fecha normal para poder almacenarlo
$transglutamiasaIgA= $inputJson['transglutamiasaIgA'];
$transglutaminasaIgG= $inputJson['transglutaminasaIgG'];
$antigliadinaIgG= $inputJson['antigliadinaIgG'];
$antiPeptidos_gliadinas_desaminadoIgG= $inputJson['antiPeptidos_gliadinas_desaminadoIgG'];
$antiendomisioIgA= $inputJson['antiendomisioIgA'];
$endomisioIgG= $inputJson['endomisioIgG'];
$vitaminaD= $inputJson['vitaminaD'];
$vitaminaB12= $inputJson['vitaminaB12'];
$folato= $inputJson['folato'];
$proteinas= $inputJson['proteinas'];
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

$usuario = 1; //todo change to session


$mysqlConnection = mysqli_connect('localhost', 'u778517381_cliap', 'CELIAPP2016', 'u778517381_cliap');
if (!$mysqlConnection) {
    die('No pudo conectar: ' . mysqli_error($mysqlConnection));
}

$mysqlConnection->select_db("u778517381_cliap");
$mysqlConnection->query("SET NAMES utf8");
$query = "INSERT INTO calendario_sintomas (id_usuario, fecha,TransglutamiasaIgA,TransglutaminasaIgG,AntigliadinaIgG,AntiPeptidosGliadinasDesaminadoIgG,AntiendomisioIgA,EndomisioIgG,VitaminaD,VitaminaB12,Folato,Proteinas,estado_animico,id_dolores_articulares,test_fecal,id_sintomas, apetito, control_peso,datos_menstruales1_fecha_inicio,datos_menstruales2_fecha_fin, datos_menstruales3_dolor,datos_menstruales4_sangrado, datos_menstruales5_anticonceptivo,test_orina) VALUES ({$usuario}, FROM_UNIXTIME({$fecha}),{$TransglutamiasaIgA},{$TransglutamiasaIgA}, {$AntigliadinaIgG}, {$AntiPeptidosGliadinasDesaminadoIgG}, {$AntiendomisioIgA}, {$EndomisioIgG}, {$VitaminaD}, {$VitaminaB12}, {$Folato}, {$Proteínas}, {$id_dolores_articulares}, {$test_fecal}, {$id_sintomas}, {$apetito} ,{$control_peso}, {$datos_menstruales1_fecha_inicio}, {$datos_menstruales2_fecha_fin}, {$datos_menstruales3_dolor}, {$datos_menstruales4_sangrado}, {$datos_menstruales5_anticonceptivo}, {$test_orina})";

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


<?php
    $inputJson = json_decode(file_get_contents('php://input'), true);// dECODIFICA LOS DATOS BINARIOS QUE RECBE DLE SERVIDOR
//LOS COJO LOS METO EN UNA VARIABLE

    $respuestas= $inputJson['respuestas']; //coger variable json
    $fase= $inputJson['fase'];
    $varIdUsuario = 1;

    $mysqlConnection = mysqli_connect('localhost', 'u778517381_cliap', 'CELIAPP2016', 'u778517381_cliap');
    if (!$mysqlConnection) {
        die('No pudo conectar: ' . mysqli_error($mysqlConnection));
    }
    $insert="INSERT INTO trivial_historico (fase, id_usuario, pregunta, respuesta) VALUES ";


    for($i=0; $i<count($respuestas); $i++) {
        $insert = $insert."({$fase}, {$varIdUsuario}, {$i}, {$respuestas[$i]['respuestaSeleccionada']}),";
    }

    $insert = rtrim($insert,",").'';

    $mysqlConnection->select_db("u778517381_cliap");
    $mysqlConnection->query("SET NAMES utf8");

    $queryResult=$mysqlConnection->query($insert);
    $jsonOutput = array();
    if(!$queryResult){
        $jsonOutput["error"] = true;
        $jsonOutput["message"] = "Select users error";
    }
    echo json_encode($jsonOutput);
    $mysqlConnection->close();
?>
<?php
//1� HIPOTESIS: recibo el jsonada json con la peticion le hago el decode

//2� : NO, no recibo nada simplemente pinto

//hago la consulta a la bd$

$tiendaParam = isset($_GET['tienda'])?$_GET['tienda']:'';

$mysqlConnection = mysqli_connect('localhost', 'u778517381_cliap', 'CELIAPP2016', 'u778517381_cliap');
if (!$mysqlConnection) {
    die('No pudo conectar: ' . mysqli_error($mysqlConnection));
}

$mysqlConnection->select_db("u778517381_cliap");
$mysqlConnection->query("SET NAMES utf8");
$query = "SELECT * FROM producto p";
if(strlen($tiendaParam) > 0){
    $query = $query." inner join tienda_producto t on p.id=t.producto_id
inner join tienda i on t.tienda_id=i.id
where i.nombreTienda='{$tiendaParam}'";
}
$queryResult=$mysqlConnection->query($query);
$jsonOutput = array();
if($queryResult && $queryResult->num_rows > 0){
    $jsonArray = array();
    while($currentTableRow = $queryResult->fetch_assoc())
        $jsonArray[]=$currentTableRow;
    $jsonOutput["data"] = $jsonArray;
}else{
    $jsonOutput["error"] = true;
    $jsonOutput["message"] = "Select users error";
}
echo json_encode($jsonOutput);
$mysqlConnection->close();

//luego por cada consulta buena de la bd envio de vuelta un json para que por cree una fila en la tabla
?>
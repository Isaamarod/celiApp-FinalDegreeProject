<?php
include('session_check.php');
include('mysql.php');

$idUsuario = $_SESSION['user']['idUsuario'];

$query = "SELECT * FROM producto p inner join tienda_producto t on p.id=t.producto_id ";
if(isset($_GET['tienda']) && !empty($_GET['tienda'])){
    $query = $query . "inner join tienda i on t.tienda_id=i.id and i.id = {$_GET['tienda']} ";
}else{
    $query = $query . "inner join tienda i on t.tienda_id=i.id ";
}
$query = $query .
    "inner join marca m on m.nombreMarca=p.marca
inner join categoria c on c.nombreCategoria=p.categoria
inner join tipoproducto tip on tip.nombreTipo=p.tipo
left join valoraciones v on v.id_producto = p.id and v.id_usuario = {$idUsuario}";

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
?>
<?php
include('mysql.php');
//recibimos los datos introducidos por el usuario
$user = $_POST['nombreUsuario'];
$pass = $_POST['password'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$centroMedico = $_POST['centroMedico'];
$sexo = $_POST['sexo'];
$fechaNacimiento = $_POST['fechaNacimiento'];
$tipoPersona = $_POST['tipoPersona'];
$pais = $_POST['pais'];
$ciudad = $_POST['ciudad'];
//lo insertamos en la base de datos
$queryResult=$mysqlConnection->query("INSERT INTO usuario (nombreUsuario, password, nombre, apellidos, centroMedico, sexo, fechaNacimiento, tipoPersona, pais, ciudad) VALUES ('{$user}', '{$pass}', '{$nombre}', '{$apellidos}', '{$centroMedico}', '{$sexo}', STR_TO_DATE('{$fechaNacimiento}', '%Y-%m-%d'), '{$tipoPersona}', '{$pais}', '{$ciudad}')");

//si el usuario no existe con anterioridad la petición será acepada
if($queryResult){
    header('Location: pantallaInicio.php?registro=aceptado');
}else{
    header('Location: pantallaInicio.php?registro=fallido&causa=Usuario%20existente');
}
$mysqlConnection->close();
?>
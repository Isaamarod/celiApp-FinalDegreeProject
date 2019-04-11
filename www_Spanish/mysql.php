<?php
$mysqlConnection = mysqli_connect('mysql.hostinger.es', 'u778517381_cliap', 'CELIAPP2016', 'u778517381_cliap');
if (!$mysqlConnection) {
    die('No pudo conectar: ' . mysqli_error($mysqlConnection));
}
$mysqlConnection->select_db("u778517381_cliap");
$mysqlConnection->query("SET NAMES utf8");
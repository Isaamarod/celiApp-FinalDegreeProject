<?php
    include('mysql.php');
    session_start();
    $user = $_POST['nombreUsuario'];
    $pass = $_POST['password'];

    $queryResult = $mysqlConnection->query("SELECT * FROM usuario where nombreUsuario='{$user}' and password='{$pass}'");
    $jsonOutput = array();
    if ($queryResult && $queryResult->num_rows == 1) {
        $_SESSION['user'] = $queryResult->fetch_assoc();
        if ($_SESSION['user']['tipoPersona'] == 'M') {
            header('Location: pantallaMedico.php');
        } else {
            header('Location: pantallaMenu.php');
        }
    } else {
        header('Location: pantallaInicio.php?login=fallido');
    }
    $mysqlConnection->close();
?>
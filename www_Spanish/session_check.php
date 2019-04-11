<?php
if (!isset($_SESSION)) { session_start(); }
/* Si no hay una sesión creada, redireccionar al index. */
if(empty($_SESSION['user']) || empty($_SESSION['user']['idUsuario'])) { // Recuerda usar corchetes.
    header('Location: pantallaInicio.php');
    die();
}
?>
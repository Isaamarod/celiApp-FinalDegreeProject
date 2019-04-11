<?php
//redirijo a la pantalla inicial de cada tipo de usuario cuando hay sesion
    session_start();
    if(!empty($_SESSION['user']) && !empty($_SESSION['user']['tipoPersona'])){
        if ($_SESSION['user']['tipoPersona'] == 'M') {
            header('Location: pantallaMedico.php');
        } else {
            header('Location: pantallaMenu.php');
        }
        die();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, minimum-scale=1.0, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <title>Celiapp - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet prefetch'
          href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch'
          href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="favicon.png">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/loader.js"></script>
</head>

<body>
<div class="pen-title">
    <h1>Celiapp</h1>
    <img class="logo_footer"  src="img/logo_3.png"/>
</div>

<!--<div align="center"><img src="logo_2.png"></div>-->
<div class="module form-module">
    <div class="toggle"><i class="fa fa-times fa-pencil"></i>
        <div class="tooltip">Registro</div>
    </div>
    <div class="form">
        <h2>Iniciar sesión</h2>
        <form action="login.php" method="post" target="_self">
            <input type="hidden" name="formrequest" value="true"/>
            <input type="text" name="nombreUsuario" placeholder="Usuario"/>
            <input type="password" name="password" placeholder="Contraseña"/>
            <button type="submit">Iniciar sesión</button>
        </form>
    </div>
    <div class="form">
        <h2>Crear cuenta</h2>
        <form action="registro.php" method="post" target="_self">
            <input type="hidden" name="formrequest" value="true"/>
            <input type="text" name="nombreUsuario" placeholder="Usuario"/>
            <input type="password" name="password" placeholder="Contraseña"/>
            <input type="text" name="nombre" placeholder="Nombre"/>
            <input type="text" name="apellidos" placeholder="Apellidos"/>
            <input type="text" name="centroMedico" placeholder="Centro medico"/>
            <select name="sexo">
                <option value="HOMBRE">Hombre</option>
                <option value="MUJER">Mujer</option>
            </select>
            <input type="date" name="fechaNacimiento" placeholder="Fecha de nacimiento"/>
            <select name="tipoPersona">
                <option value="P">Paciente</option>
                <option value="M">Medico</option>
            </select>
            <input type="text" name="pais" placeholder="Pais"/>
            <input type="text" name="ciudad" placeholder="Ciudad"/>
            <button>Registrar</button>
        </form>
    </div>
</div>

<script type="text/javascript">
    window.AppLoad = function () {
        $(document).ready(function () {
            $('form').submit(function(){
               window.AppLoader.show();
            });
            // Toggle Function
            $('.toggle').click(function () {
                // Switches the Icon
                $(this).children('i').toggleClass('fa-pencil');
                // Switches the forms
                $('.form').animate({
                    height: "toggle",
                    'padding-top': 'toggle',
                    'padding-bottom': 'toggle',
                    opacity: "toggle"
                }, "slow");
            });
        });

    };
</script>
<script src="js/cordova/index.js"></script>
</body>
</html>

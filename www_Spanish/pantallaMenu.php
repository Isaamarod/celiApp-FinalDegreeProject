<?php
include('session_check.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, minimum-scale=1.0, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.png">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/main.css" rel="stylesheet">

    <!-- Fonts from Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/loader.js"></script>
</head>

<body class="container">

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><b>Menú Celiapp</b></a>
        <span class="glyphicon glyphicon-off logout" onclick="window.location.href='logout.php';"></span>
    </div>
</div>
<div class="row mt centered">
    <a href="pantallaMenuRecorrido.php" target="_self">
        <div class="col-lg-4">
            <img src="img/recorrido_celiaquia.png" width="125" alt="">
            <h4>Recorrido por la Celiaquía</h4>
            <p>Aprende más sobre la celiaquía ¡Pincha Aquí!</p>
        </div><!--/col-lg-4 -->
    </a>
    <a href="pantallaMenuEscenarios.php" target="_self">
        <div class="col-lg-4">
            <img src="img/informacion.png" width="150" alt="">
            <h4>¿Cómo celebro mi cumpleaños? <br> ¿Qué hago cuando salgo a cenar fuera?<br> ¿Cómo organizo la cocina?</h4>
            <p>Infórmate sobre cómo colocar los utensilios en casa, qué hacer antes de salir a cenar fuera..</p>
        </div><!--/col-lg-4 -->
    </a>
    <a href="pantallaTrivial.php" target="_self">
        <div class="col-lg-4">
            <img src="img/juego.png" width="125" alt="">
            <h4>¡Celiaquía a prueba!</h4>
            <p>Juego en el que podrás poner a prueba tus conocimientos sobre celiaquía</p>
        </div>
    </a>

</div>

<div class="row mt centered">

    <div class="col-lg-4">
        <a href="pantallaCalendario.php" target="_self">
            <img src="img/ImagenCalendario.png" width="130" alt="">
            <h4>Control Periódico de Seguimiento</h4>
            <p>Registra cómo te encuentras, el peso, los test de orina..</p>
        </a>
    </div><!--/col-lg-4 -->

    <div class="col-lg-4" >
        <a href="pantallaBusquedaProductos.php" target="_self">
            <img src="img/localizar2.png" width="190" alt="">
            <h4>Localizador y Valoraciones</h4>
            <p>Encuentra un alimento específico, valorarlo y el lugar en el que lo venden</p>

        </a>
    </div>
    <div class="col-lg-4" id="menu_ocr">
        <a href="pantallaOCR.php" target="_self">
            <img src="img/ocr_imagen.png" width="170" alt="">
            <h4>Comprobación de cartas o etiquetas</h4>
            <p>Coge desde tu móvil o tu ordenador una carta de restaurante o la etiqueta de un producto y comprueba si tiene gluten o no</p>
        </a>
    </div>
</div><!--/col-lg-4 -->

</div>
<script type="text/javascript">
    window.AppLoad = function(){
        $(document).ready(function(){
        });
    };
</script>
<script src="js/cordova/index.js"></script>
</body>
</html>

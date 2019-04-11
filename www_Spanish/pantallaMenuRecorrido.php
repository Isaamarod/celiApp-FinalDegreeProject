<?php
include('session_check.php');
?>
<!DOCTYPE html>
<html lang="en">
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
</head>

<body class="container">

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top">
	<div class="navbar-header">
		<a class="navbar-brand" href="#"><b>Menú Recorrido</b></a>
		<span class="glyphicon glyphicon-off logout" onclick="window.location.href='logout.php';"></span>
	</div>
</div>
<div class="row mt centered">

	<div class="col-lg-4">
		<a href="pantallaQueEsLaCeliaquia.php" target="_self">
			<img src="img/pregunta.png" width="100" alt="">
			<h4>¿Qué es la celiaquía?</h4>
		</a>
	</div><!--/col-lg-4 -->


	<div class="col-lg-4">
		<a href="pantallaImportanciaDejarComerGluten.php" target="_self">
			<img src="img/pregunta.png" width="100" alt="">
			<h4>¿Porqué es importante dejar de comer  gluten?</h4>
        </a>
	</div><!--/col-lg-4 -->
	<div class="col-lg-4">
		<a href="pantallaHayRecuperacion.php" target="_self">
			<img src="img/pregunta.png" width="100" alt="">
			<h4>¿Hay recuperación?</h4>
		</a>
	</div>


</div>

<div class="row mt centered">

	<div class="col-lg-4">
		<a href="pantallaBeneficiosSinGluten.php" target="_self">
			<img src="img/pregunta.png" width="100" alt="">
			<h4>¿Qué beneficios tiene una dieta sin gluten?</h4>
		</a>
	</div>


	<div class="col-lg-4" >
		<a href="pantallaSiNoHagoDietaSinGluten.php" target="_self">
			<img src="img/pregunta.png" width="180" alt="">
			<h4>¿Qué ocurre si no hago una dieta sin gluten?</h4>
		</a>
	</div>
    <div class="col-lg-4">
        <a href="pantallaTodosLosCerealesGluten.php" target="_blank">
            <img src="img/pregunta.png" width="100" alt="">
            <h4>¿Todos los cereales tienen gluten?</h4>
        </a>
    </div>

</div>
<div class="row mt centered">
    <div class="col-lg-4">
        <a href="pantallaAlimentosGluten.php" target="_blank">
            <img src="img/pregunta.png" width="100" alt="">
            <h4>¿Qué alimentos tienen gluten?</h4>
        </a>
    </div><!--/col-lg-4 -->
	<div class="col-lg-4">
		<a href="pantallaContaminacionCruzada.php" target="_blank">
			<img src="img/pregunta.png" width="100" alt="">
			<h4>¿Qué es la contaminación cruzada?</h4>
		</a>
	</div><!--/col-lg-4 -->
	<div class="col-lg-4">
		<a href="pantallaEtiquetado.php" target="_blank">
			<img src="img/pregunta.png" width="100" alt="">
			<h4>¿Qué etiquetas puedo encontrar?</h4>
		</a>
	</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

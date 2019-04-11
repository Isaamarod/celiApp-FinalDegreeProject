<?php
include('session_check.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="favicon.png">

	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="css/main.css" rel="stylesheet">

	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-waitingfor.min.js"></script>

	<!-- Fonts from Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<script type="text/javascript">

		function funcionSalir() {
			window.location.href = "pantallaMenu.php";
		}


	</script>
</head>

<body class="container">

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top">
	<div class="navbar-header">
		<a class="navbar-brand" href="#"><b>Menú Escenarios</b></a>
		<span class="glyphicon glyphicon-off logout" onclick="window.location.href='logout.php';"></span>
	</div>
</div>
<div class="row mt centered">
	<a href="pantallaEscenarioCasa.php" target="_self">
		<div class="col-lg-4">
			<img src="img/iconoCasa.png" width="100" alt="">
			<h4>En casa</h4>
			<p>Si pinchas aquí encontrarás consejos sobre cómo organizarte en casa</p>
		</div><!--/col-lg-4 -->
	</a>
	<a href="pantallaEscenarioFuera.php" target="_self">
	<div class="col-lg-4">
		<img src="img/salirDeCasa.png" width="100" alt="">
		<h4>Fuera de casa</h4>
		<p>Si pinchas aquí encontrarás consejos sobre cómo organizarte cuando sales de casa a comer</p>
	</div><!--/col-lg-4 -->
	</a>
</div>



<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

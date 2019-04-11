<?php
include('session_check.php');
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.png">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this      -->
    <link href="css/main.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <style type="text/css">
        .carousel {
            height: 70%;
        }

        .carousel-inner {
            /* make sure your .items will get correct height */
            height: 100%;
        }

       /* .item {
            background-size: cover;
            background-position: 50% 50%;
            width: 100%;
            height: 100%;
        }*/
		
		.item{
			text-align: center;
		}

        .item img {
            /*visibility: hidden;*/
			
        }
    </style>

 </head>
<body class="container-fluid">
<div class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><b>Recorrido por la Celiaquía</b></a>
        <span class="glyphicon glyphicon-off logout" onclick="window.location.href='logout.php';"></span>
    </div>

</div>


<div class="container jumbotron panel panel-default" style="margin-top: 70px; min-height: 70%; background-color:#F4F6F7">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active" >
                <div class="item">
                    <img src="img/pqimportantedejardecomergluten.PNG" style="height: 100%;"/>
                </div>
                <div class="carousel-caption">
                    <h3>¿Qué es la celiaquía?</h3>
                    <p>La celiaquía se trata de una enfermedad que afecta a ...</p>
                </div>
            </div>
            <div class="item">
                <div class="item">
                    <img src="img/pqimportantedejardecomergluten.PNG" style="height: 100%;"/>
                </div>
                <div class="carousel-caption">
                    <h3>¿Qué es la celiaquía?</h3>
                    <p>La celiaquía se trata de una enfermedad que afecta a ...</p>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

</div>

</body>




</html>
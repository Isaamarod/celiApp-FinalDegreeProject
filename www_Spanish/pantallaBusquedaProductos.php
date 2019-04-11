<?php
include('session_check.php');
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, minimum-scale=1.0, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.png">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this      -->
    <link href="css/main.css" rel="stylesheet">
    <!-- css alert-->

    <link href="css/alerts_trivial/prettify.css" rel="stylesheet">
    <link href="css/alerts_trivial/styles.css" rel="stylesheet">
    <link href="css/localizador_productos/productos.css" rel="stylesheet">
    <link href="css/localizador_productos/slider.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/star-rating.min.css"/>

    <style type="text/css">
        .caption{
            display: none!important;
        }

        .rating-md {
            font-size: 1em;
        }
    </style>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-slider.js"></script>
    <script type="text/javascript" src="js/star-rating.min.js"></script>
    <script src="js/alerts_trivial/jquery.bsAlerts.js"></script>
    <script src="js/loader.js"></script>
    <script type="text/javascript">

        Array.prototype.unique = function() {
            var a = [];
            for (var i=0, l=this.length; i<l; i++)
                if (a.indexOf(this[i]) === -1)
                    a.push(this[i]);
            return a;
        };

        function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        }

        function onValoracion(idProducto){
            var valoracion = $('#rating-valoracion-' + idProducto).val();
            window.AppLoader.show();
            $.ajax('insertarValoracion.php', {
                dataType: 'text',
                method: 'POST',
                data: JSON.stringify({
                    valoracion: valoracion,
                    idProducto: idProducto
                }),
                contentType: 'application/json; charset=UTF-8'
            }).done(function (data) {
                window.AppLoader.hide();
                data = JSON.parse(data);
                if(data.success){
                    var parent = $('#rating-valoracion-'+idProducto).parent();
                    $('#rating-valoracion-'+idProducto).remove();
                    $(parent).text(valoracion);
                }else{
                    $(document).trigger("add-alerts", [
                        {
                            "message": "Error asignando valoracion al producto, intentelo de nuevo",
                            "priority": 'danger',
                            "fade": 2000
                        }
                    ]);
                }
            }).fail(function(){
                window.AppLoader.hide();
                $(document).trigger("add-alerts", [
                    {
                        "message": "Error asignando valoracion al producto, intentelo de nuevo",
                        "priority": 'danger',
                        "fade": 2000
                    }
                ]);
            });
        }

        $(document).ready(function() {

            $("#filtroPrecio").slider();
            $("#filtroPrecio").on("slide", function(slideEvt) {
                $("#sliderValue").text(slideEvt.value);
            });

            $('.slider').on("click", function() {
                var newvalue = $('.tooltip-inner').text();
                $("#sliderValue").text(newvalue);
            });

            function rellenarTabla(datos){
                var contenidoTabla = jQuery(".table > tbody");
                contenidoTabla.children().remove();
                for (var i = 0; i < datos.length; i++) {
                    var objetoBD = datos[i];
                    var valoracion = objetoBD.valoracion && objetoBD.valoracion != null ? objetoBD.valoracion : '<input id="rating-valoracion-' + objetoBD.id + '" name="rating-valoracion-' + objetoBD.id + '" class="rating-loading" onchange="onValoracion(' + objetoBD.id + ');"/>';

                    var html = '<tr><td>' + i + '</td><td>' + objetoBD.nombreProducto + '</td><td>' +  objetoBD.nombreTipo + '</td><td>' + objetoBD.precio + '</td><td>' + objetoBD.nombreCategoria + '</td><td>' + objetoBD.nombreMarca
                            + '</td><td>' + objetoBD.nombreTienda + '</td><td> ' + valoracion + ' </td></tr>';
                    contenidoTabla.append(html);
                }
                $('.rating-loading').rating({
                    clearButton: '',
                    clearElement: "",
                    captionElement: ""
                });
            }





            var urlServidor = 'busquedaProductos.php';
            if(getUrlParameter('tienda'))
                urlServidor += '?tienda=' + getUrlParameter('tienda');

            $.ajax(urlServidor, {
                dataType: 'text',
                method: 'GET'
            }).done(function (data) {
                var Recibidojson = JSON.parse(data);
                rellenarTabla(Recibidojson.data);

                var filtrosTipo = [], filtrosTienda = [], filtrosCategoria = [], filtrosMarca = [];
                for(var i=0; i<Recibidojson.data.length; i++){
                    var dato = Recibidojson.data[i];
                    if(dato.nombreTienda)
                        filtrosTienda.push(dato.nombreTienda);
                    if(dato.nombreCategoria)
                        filtrosCategoria.push(dato.nombreCategoria);
                    if(dato.nombreTipo)
                        filtrosTipo.push(dato.nombreTipo);
                    if(dato.nombreMarca)
                        filtrosMarca.push(dato.nombreMarca);
                }

                filtrosTipo = filtrosTipo.unique();
                filtrosTienda = filtrosTienda.unique();
                filtrosCategoria = filtrosCategoria.unique();
                filtrosMarca = filtrosMarca.unique();

                $(filtrosTipo).each(function(index, value){
                    $('#filtroTipo').append('<option value="' + value + '">' + value + '</option>');
                });

                $(filtrosTienda).each(function(index, value){
                    $('#filtroTienda').append('<option value="' + value + '">' + value + '</option>');
                });

                $(filtrosCategoria).each(function(index, value){
                    $('#filtroCategoria').append('<option value="' + value + '">' + value + '</option>');
                });

                $(filtrosMarca).each(function(index, value){
                    $('#filtroMarca').append('<option value="' + value + '">' + value + '</option>');
                });

                $("#botonFiltrar").click(function () {
                    var filtroTipo = $('#filtroTipo').val();
                    var filtroTienda = $('#filtroTienda').val();
                    var filtroCategoria = $('#filtroCategoria').val();
                    var filtroMarca = $('#filtroMarca').val();
                    var filtroPrecio = $('#filtroPrecio').val();

                   // var filtroValue = $("#filtro").val();
                    var datos = Recibidojson.data;
                    var datosFiltrados = [];
                    var noHayFiltros = !filtroTipo && !filtroTienda && !filtroPrecio && !filtroCategoria && !filtroMarca;
                    if(noHayFiltros){
                        datosFiltrados = datos;
                    }else{
                        for(var i=0; i<datos.length; i++){
                            if((!filtroTipo || (datos[i].tipo && datos[i].tipo.indexOf(filtroTipo) > -1))
                                    && (!filtroTienda || (datos[i].nombreTienda && datos[i].nombreTienda.indexOf(filtroTienda) > -1))
                                    && (filtroPrecio == -1 || (datos[i].precio && datos[i].precio <= filtroPrecio))
                                    && (!filtroCategoria || (datos[i].categoria && datos[i].categoria.indexOf(filtroCategoria) > -1))
                                    && (!filtroMarca || (datos[i].marca && datos[i].marca.indexOf(filtroMarca) > -1))
                            ){
                                datosFiltrados.push(datos[i]);
                            }
                        }
                    }
                    rellenarTabla(datosFiltrados);
                });
            });
        });

    </script>

</head>

<body class="container container-fluid">
<div class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><b>Localización de Productos Celíacos</b></a>
        <span class="glyphicon glyphicon-off logout" onclick="window.location.href='logout.php';"></span>
    </div>
</div>
<div class="row">
        <div class="col-md-4 col-md-offset-8">
            <div class="input-group" id="adv-search" style="width: 100%;" >
                <input type="text" class="form-control" placeholder="Encuentra tu producto" />
                <div class="input-group-btn">
                    <div class="btn-group" role="group">
                        <div class="dropdown dropdown-lg">
                            <button type="button" class="btn btn-default dropdown-toggle" style="height: 42px; margin-bottom:40px" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <form class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <label for="filtroTipo">Filtrar por:</label>
                                        <select class="form-control" id="filtroTipo">
                                            <option value="" selected>Todos los productos</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="filtroTienda">Tiendas</label>
                                        <select class="form-control" id="filtroTienda">
                                            <option value="" selected>Todas las tiendas</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="filtroCategoria">Categorías</label>
                                        <select class="form-control" id="filtroCategoria">
                                            <option value="" selected>Todas las categorias</option>
                                        </select>
                                     </div>
                                    <div class="form-group">
                                        <label for="filtroMarca">Marcas</label>
                                        <select class="form-control" id="filtroMarca">
                                            <option value="" selected>Todas las marcas</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="filtroPrecio">Precio</label> <!-- http://bootsnipp.com/snippets/00WGK-->
                                        <div class="button-slider">
                                        <div class="btn-group">
                                            <!--<div class="btn btn-default">Precio</div>-->
                                            <div class="btn btn-default">
                                                <input id="filtroPrecio" type="text" data-slider-min="-1" data-slider-max="100" data-slider-step="1" data-slider-value="-1"/>
                                                <div class="valueLabel"><span id="sliderValue"></span>€</div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <button id="botonFiltrar" type="button" class="btn btn-primary" style="height: 42px" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="row" >
    <div class="col-xs-6 offset-xs-6"  style=" margin-top: 50px; width: 55%">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Nombre Producto</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Marca</th>
                <th>Tienda</th>
                <th>Tu valoración</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>
</div>
</div>
<div style="position: absolute; right: 20px; top: 20px; left: 20px; width: 100%; height: auto; z-index: 1031;">
    <center><div class="col-xs-10 col-lg-4" data-alerts="alerts"></div></center>
</div>
</body>

</html>
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
    <link href="css/medicos.css" rel="stylesheet">
    <link href="css/localizador_productos/slider.css" rel="stylesheet">


    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
    <script src="js/loader.js"></script>
    <script src="js/bootstrap-slider.js"></script>
    <style>
        canvas{
            display: block;
            width: 75%;
            height: 75%;
        }
        #chartjs-tooltip {
            opacity: 1;
            position: absolute;
            background: rgba(0, 0, 0, .7);
            color: white;
            border-radius: 3px;
            -webkit-transition: all .1s ease;
            transition: all .1s ease;
            pointer-events: none;
            -webkit-transform: translate(-50%, 0);
            transform: translate(-50%, 0);
        }

        .chartjs-tooltip-key {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin-right: 10px;
        }
    </style>
</head>


</head>


<body class="container">
<div class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><b>Localización de Pacientes</b></a>
        <span class="glyphicon glyphicon-off logout" onclick="window.location.href='logout.php';"></span>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="input-group" id="adv-search" style="float: right;">
            <input type="text" class="form-control" placeholder="Encuentra al Paciente" disabled/>
            <div class="input-group-btn">
                <div class="btn-group" role="group">
                    <div class="dropdown dropdown-lg">
                        <button type="button" class="btn btn-default dropdown-toggle"
                                style="height: 42px; margin-bottom:40px" data-toggle="dropdown"
                                aria-expanded="false"><span class="caret"></span></button>
                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                            <form class="form-horizontal" role="form">
                                <div class="form-group">
                                    <label for="filtroPaciente">Seleccionar paciente:</label>
                                    <select class="form-control" id="filtroPaciente">
                                        <option value="" selected>Todos los pacientes</option>
                                    </select>
                                </div>
                                <div class="form-group hidden">
                                    <label for="filtroSintoma">Seleccionar sintoma:</label>
                                    <select class="form-control" id="filtroSintoma">
                                        <option value="control_peso">Peso</option>
                                        <option value="datos_menstruales4_sangrado">Intensidad sangrado menstruacion</option>
                                        <option value="test_fecal">Evolución fecal</option>
                                        <option value="valor_analitica1">Analitica 1</option>
                                        <option value="valor_analitica2">Analitica 2</option>
                                        <option value="valor_analitica3">Analitica 3</option>
                                        <option value="valor_analitica4">Analitica 4</option>
                                        <option value="valor_analitica5">Analitica 5</option>
                                        <option value="valor_analitica6">Analitica 6</option>
                                        <option value="valor_analitica7">Analitica 7</option>
                                        <option value="valor_analitica8">Analitica 8</option>
                                        <option value="valor_analitica9">Analitica 9</option>
                                        <option value="valor_analitica10">Analitica 10</option>
                                    </select>
                                </div>
                                <div class="form-group hidden">
                                    <label for="filtroFechaDesde">Seleccionar fecha desde (opcional):</label>
                                    <select class="form-control" id="filtroFechaDesde">
                                        <option value="" selected>Todas las fechas</option>
                                    </select>
                                </div>
                                <div class="form-group hidden">
                                    <label for="filtroFechaHasta">Seleccionar fecha hasta (opcional):</label>
                                    <select class="form-control" id="filtroFechaHasta">
                                        <option value="" selected>Todas las fechas</option>
                                    </select>
                                </div>
                                <div class="form-group hidden">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true" id="mostrarAnilitica">Mostrar evolución</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="text-align: center; margin: 0 auto;">
    <canvas id="canvas"></canvas>
</div>
</div>


<!--modal para valorar el producto -->

</div>

<script type="text/javascript">
    var MONTHS = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    var config = {
        "type": "line",
        "data": {

        },
        "options": {
            "responsive": true,
            "title": {
                "display": true,
                "text": "Evolución del paciente"
            },
            "tooltips": {
                enabled: false,
                mode: 'index',
                position: 'nearest',
                "custom": function(tooltipModel) {
                    // Tooltip Element
                    var tooltipEl = document.getElementById('chartjs-tooltip');

                    // Create element on first render
                    if (!tooltipEl) {
                        tooltipEl = document.createElement('div');
                        tooltipEl.id = 'chartjs-tooltip';
                        tooltipEl.innerHTML = "<table></table>"
                        document.body.appendChild(tooltipEl);
                    }

                    // Hide if no tooltip
                    if (tooltipModel.opacity === 0) {
                        tooltipEl.style.opacity = 0;
                        return;
                    }

                    // Set caret Position
                    tooltipEl.classList.remove('above', 'below', 'no-transform');
                    if (tooltipModel.yAlign) {
                        tooltipEl.classList.add(tooltipModel.yAlign);
                    } else {
                        tooltipEl.classList.add('no-transform');
                    }

                    var sintoma = window.sintomas.filter(function(sintoma){
                        return sintoma.fecha == tooltipModel.title[0];
                    })[0];

                    var extraData = [];
                    if(sintoma.estado_animico != null) {
                        var label = '';
                        switch(parseInt(sintoma.estado_animico)){
                            case 1:
                                label = 'Sonriente';
                                break;
                            case 2:
                                label = 'Sonrojado';
                                break;
                            case 3:
                                label = 'Trabajador';
                                break;
                            case 4:
                                label = 'Reluciente';
                                break;
                            case 5:
                                label = 'Pensativo';
                                break;
                            case 6:
                                label = 'Incomodo';
                                break;
                            case 7:
                                label = 'Desastroso';
                                break;
                            case 8:
                                label = 'Divertido';
                                break;
                        }
                        extraData.push(['Estado de animo: ' + label]);
                    }
                    if(sintoma.apetito != null) {
                        var label = '';
                        switch(parseInt(sintoma.apetito)){
                            case 1:
                                label = 'Poco';
                                break;
                            case 2:
                                label = 'Algo';
                                break;
                            case 3:
                                label = 'Normal';
                                break;
                            case 4:
                                label = 'Mucho';
                                break;
                        }
                        extraData.push(['Apetito: ' + label]);
                    }
                    if(sintoma.id_dolores_articulares != null){
                        var labels = [];
                        $.each(sintoma.id_dolores_articulares.split(','), function(index, idDolor){
                            switch(parseInt(idDolor)){
                                case 1:
                                    labels.push('Dolores de huesos');
                                    break;
                                case 2:
                                    labels.push('Dolores de articulaciones superiores');
                                    break;
                                case 3:
                                    labels.push('Dolores de articulaciones inferiores');
                                    break;
                                case 4:
                                    labels.push('Dolor abdominal');
                                    break;
                                case 5:
                                    labels.push('Calambres musculares');
                                    break;
                                case 6:
                                    labels.push('Dolores denombre huesos');
                                    break;
                                case 7:
                                    labels.push('Dolores de articulaciones superiores');
                                    break;
                                case 8:
                                    labels.push('Dolores de articulaciones inferiores');
                                    break;
                                case 9:
                                    labels.push('Dolor abdominal');
                                    break;
                                case 10:
                                    labels.push('Calambres musculares');
                                    break;
                                case 11:
                                    labels.push('Dolores denombre huesos');
                                    break;
                                case 12:
                                    labels.push('Dolores de articulaciones superiores');
                                    break;
                                case 13:
                                    labels.push('Dolores de articulaciones inferiores');
                                    break;
                                case 14:
                                    labels.push('Dolor abdominal');
                                    break;
                                case 15:
                                    labels.push('Calambres musculares');
                                    break;
                            }

                        });
                        extraData.push(['Dolores articulares: ' + labels.join(', ')]);
                    }

                    if(sintoma.id_sintomas != null) {
                        var labels = [];
                        $.each(sintoma.id_sintomas.split(','), function(index, idSintoma){
                            switch(parseInt(idSintoma)){
                                case 2:
                                    labels.push('Vómitos');
                                    break;
                                case 3:
                                    labels.push('Uñas frágiles');
                                    break;
                                case 4:
                                    labels.push('Pérdida de cabello');
                                    break;
                                case 5:
                                    labels.push('Ampollas en la piel');
                                    break;
                                case 6:
                                    labels.push('Ronchas en la piel');
                                    break;
                            }

                        });
                        extraData.push(['Sintomas: ' + labels.join(', ')]);
                    }
                    if(sintoma.test_orina != null)
                        extraData.push(['Orina: ' + sintoma.test_orina]);
                    if(sintoma.datos_menstruales1_fecha_inicio != null)
                        extraData.push(['Fecha inicio menstruacion: ' + tooltipModel.title.split(' ')[0]]);
                    if(sintoma.datos_menstruales2_fecha_fin != null)
                        extraData.push(['Fecha fin menstruacion: ' + tooltipModel.title.split(' ')[0]]);
                    if(sintoma.datos_menstruales5_anticonceptivo != null)
                        extraData.push(['Toma anticonceptivo: ' + (sintoma.datos_menstruales5_anticonceptivo == 0 ? 'No':'Si')]);

                    function getBody(bodyItem) {
                        return bodyItem.lines;
                    }

                    // Set Text
                    if (tooltipModel.body) {
                        var titleLines = tooltipModel.title || [];
                        var bodyLines = tooltipModel.body.map(getBody).concat(extraData);

                        var innerHtml = '<thead>';

                        titleLines.forEach(function(title) {
                            innerHtml += '<tr><th style="color: white;">' + title + '</th></tr>';
                        });
                        innerHtml += '</thead><tbody>';

                        bodyLines.forEach(function(body, i) {
                            var colors = tooltipModel.labelColors[i] || {
                                backgroundColor: 'white',
                                borderColor: 'white'
                            };
                            var style = 'background:' + colors.backgroundColor;
                            style += '; border-color:' + colors.borderColor;
                            style += '; border-width: 2px';
                            var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
                            innerHtml += '<tr><td style="color: white;">' + span + body + '</td></tr>';
                        });
                        innerHtml += '</tbody>';

                        var tableRoot = tooltipEl.querySelector('table');
                        tableRoot.innerHTML = innerHtml;
                    }

                    // `this` will be the overall tooltip
                    var position = this._chart.canvas.getBoundingClientRect();

                    // Display, position, and set styles for font
                    tooltipEl.style.opacity = 1;
                    tooltipEl.style.left = position.left + tooltipModel.caretX + 'px';
                    tooltipEl.style.top = position.top + tooltipModel.caretY + 'px';
                    tooltipEl.style.fontSize = tooltipModel.fontSize;
                    tooltipEl.style.color = '#fff!important';
                    tooltipEl.style.fontStyle = tooltipModel._fontStyle;
                    tooltipEl.style.padding = tooltipModel.yPadding + 'px ' + tooltipModel.xPadding + 'px';
                }
            },
            "hover": {
                "mode": "nearest",
                "intersect": true
            },
            "scales": {
                "xAxes": [
                    {
                        "display": true,
                        "scaleLabel": {
                            "display": true,
                            "labelString": "Fecha"
                        }
                    }
                ],
                "yAxes": [
                    {
                        "display": true,
                        "scaleLabel": {
                            "display": true,
                            "labelString": "Valor"
                        }
                    }
                ]
            }
        }
    };
    Array.prototype.unique = function () {
        var a = [];
        for (var i = 0, l = this.length; i < l; i++)
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

    window.AppLoad = function(){
        $(document).ready(function () {
            window.AppLoader.show();
            $.ajax('pacientesMedico.php', {
                dataType: 'text',
                method: 'GET'
            }).done(function (data) {
                window.AppLoader.hide();
                var pacientes = JSON.parse(data).data;

                $(pacientes).each(function (index, paciente) {
                    $('#filtroPaciente').append('<option value="' + paciente.idUsuario + '">' + paciente.nombre + ' ' + paciente.apellidos + '</option>');
                });

                //Aqui relleno filtroPaciente con los datos de cada uno de los pacientes

                $('#filtroPaciente').change(function () {
                    var idPacienteSeleccionado = $(this).val();
                    if (idPacienteSeleccionado) {
                        $.ajax('sintomasPaciente.php?pacienteId=' + idPacienteSeleccionado, {
                            dataType: 'text',
                            method: 'GET'
                        }).done(function (sintomasData) {
                            var sintomas = JSON.parse(sintomasData).data;
                            window.sintomas = sintomas;
                            var fechas = [];
                            $(sintomas).each(function (index, sintoma) {
                                fechas.push(sintoma.fecha.split(' ')[0]);
                            });

                            fechas = fechas.unique();
                            $('#filtroFechaDesde > option').not(':first').remove();
                            $('#filtroFechaHasta > option').not(':first').remove(); // en cada busqueda borro los datos anteriores y refresco el filtro menos la primera pos que es todos los ...
                            $(fechas).each(function (index, fecha) {
                                $('#filtroFechaDesde, #filtroFechaHasta').append('<option value="' + fecha + '">' + fecha + '</option>');
                            });
                            $('.hidden').not('#app-loader').removeClass('hidden');
                            $('#mostrarAnilitica').click(function(){
                                var fechaDesde = $('#filtroFechaDesde').val();
                                var fechaHasta = $('#filtroFechaHasta').val();
                                var claveSintoma = $('#filtroSintoma').val();
                                var labelSintoma = $('#filtroSintoma option:selected').text();
                                var data = [];
                                var fechas = [];
                                $(sintomas).each(function(index, sintoma){
                                    var valid = true;
                                    if(fechaDesde.length > 0 && new Date(fechaDesde).getTime() > new Date(sintoma.fecha).getTime())
                                        valid = false;
                                    if(fechaHasta.length > 0 && new Date(fechaHasta).getTime() < new Date(sintoma.fecha).getTime())
                                        valid = false;
                                    if(!sintoma[claveSintoma] || Number.isNaN(parseInt(sintoma[claveSintoma])))
                                        valid = false;
                                    if(valid) {
                                        data.push(parseInt(sintoma[claveSintoma]));
                                        fechas.push(sintoma.fecha);
                                    }
                                });
                                data = data.sort(function(data1, data2){
                                    return new Date(data2.fecha).getTime() - new Date(data1.fecha).getTime();
                                });
                                fechas = fechas.sort(function(fecha1, fecha2){
                                    return new Date(fecha1).getTime() - new Date(fecha2).getTime();
                                });
                                var ctx = document.getElementById("canvas").getContext("2d");
                                config.data= {
                                    "labels": fechas,
                                    "datasets": [
                                        {
                                            "label": labelSintoma,
                                            "backgroundColor": "rgb(54, 162, 235)",
                                            "borderColor": "rgb(54, 162, 235)",
                                            "data": data,
                                            "fill": false
                                        }
                                    ]
                                };
                                window.myLine = new Chart(ctx, config);
                            });
                        });
                    }
                });
            });
        });
    }
</script>
<script src="js/cordova/index.js"></script>
</body>

</html>
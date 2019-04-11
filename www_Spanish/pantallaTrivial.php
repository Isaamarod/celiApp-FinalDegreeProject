<?php
include('session_check.php');
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
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

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/loader.js"></script>
    <script src="js/bootstrap-waitingfor.min.js"></script>
    <!--alerts-->
    <script src="js/alerts_trivial/jquery.bsAlerts.js"></script>


    <script type="text/javascript">
        //array con fases [] y dentro del array preguntas y respuestas de cada fase {}
        window.preguntas = [
            [
                {
                    pregunta: '¿Es necesario disponer de recipientes separados para alimentos como mantequilla, mayonesa o mermeladas?',
                    respuestas: [
                        "No, porque no existe riesgo de contaminación.",
                        "Si, para evitar contaminaciones que pueden producirse al untar el pan con alguno de estos alimentos."
                    ],
                    respuestaSeleccionada: 0,
                    respuestaCorrecta: 1
                },
                {
                    pregunta: 'Los productos exclusivos para los celíacos se almacenarán…',
                    respuestas: [
                        "En la parte inferior de la despensa",
                        "Siempre que sea posible en un armario o un almacén exclusivo"
                    ],
                    respuestaSeleccionada: 0,
                    respuestaCorrecta: 1
                },
            ],
            [
                {
                    pregunta: '¿Cómo se deben almacenar los alimentos que no están envasados?',
                    respuestas: [
                        "Cubriéndolos con film plástico o papel de aluminio.",
                        "Metidos en bolsas"
                    ],
                    respuestaSeleccionada: 0,
                    respuestaCorrecta: 1
                },
                {
                    pregunta: '¿Dónde se almacenarán las harinas o productos en polvo?',
                    respuestas: [
                        "Siempre en lugares distintos y separados.",
                        "Junto a las bebidas."
                    ],
                    respuestaSeleccionada: 0,
                    respuestaCorrecta: 0
                },
            ]
        ];
        window.preguntasFaseActual = 0; //pregunta por la que voy
        window.faseActual = 0;
        window.faseActualCorrecta = true;
        window.puntuacion = 0;

        function rellenaPregunta() {
            $('#respuestas').children().remove();
            var datosPregunta = window.preguntas[window.faseActual][window.preguntasFaseActual];
            jQuery("#preguntas").text(datosPregunta.pregunta);
            for(var index in datosPregunta.respuestas){
                var divRespuesta = '<div class="col-xs-12"><label class="btn btn-default" style="width: 100%;"><input type="radio" name="options" id="' + index + '" autocomplete="off" checked> ' + datosPregunta.respuestas[index] + '</label></div>';
                jQuery('#respuestas').append(divRespuesta);
            }
        }


        function enviarPreguntasServidor(callback){
            waitingDialog.show('Guardando datos de la fase, espere...',{
                dialogSize: 'sm',
                progressType: 'info'
            });
            var jsonAEnviar = {respuestas:window.preguntas[window.faseActual], fase: window.faseActual}; //losque mete el usuario
            $.ajax('trivial.php', {
                dataType: 'text',
                method: 'POST',
                data: JSON.stringify(jsonAEnviar),
               contentType: 'application/json; charset=UTF-8' //Tipo de contenido que se envia al servidor para que sepa qué le estoy enviando.
            }).done(function(){
                setTimeout(function(){
                    waitingDialog.hide();
                    callback();
                }, 2000);

            }).fail(function(){
                setTimeout(function(){
                    waitingDialog.hide();
                    callback();
                }, 2000);
            });

        }

         /** Aqui relleno las preguntas de cada fase y  a la siguiente pregunta **/
        $(document).ready(function() {
            $('#contestar').click(function(){
                var pregunta = window.preguntas[window.faseActual][window.preguntasFaseActual];
                pregunta.respuestaSeleccionada = $('#respuestas input[type="radio"]:checked').attr('id');
                //comprobar que es la ultima pregunta. si es la ultima pregunta ver el numero de aciertos y si se aumenta de fase
                //por cada pregunta de cada fase si se ha llegado al final de la fase entonces:
                window.puntuacion++;

                jQuery('.badge').text( window.puntuacion);
                if (pregunta.respuestaSeleccionada != pregunta.respuestaCorrecta)
                    window.faseActualCorrecta = false;

                if (window.preguntasFaseActual < (window.preguntas[window.faseActual].length - 1)) {
                    window.preguntasFaseActual++;
                    rellenaPregunta();
                } else {
                    enviarPreguntasServidor(function(){
                        if(window.faseActualCorrecta){
                            if(window.faseActual <  window.preguntas.length - 1) {
                                window.faseActual++;
                                window.preguntasFaseActual = 0;
                                rellenaPregunta();
                                //Paso a la siguiente fase
                                $(document).trigger("add-alerts", [
                                    {
                                        "message": "Fase " + window.faseActual  + " finalizada correctamente, a por la siguiente!",
                                        "priority": 'info',
                                        "fade": 2000
                                    }
                                ]);
                            }else{
                                //Informo de que ha llegado al final!
                                $(document).trigger("add-alerts", [
                                    {
                                        "message": "Has finalizado correctamente el trivial!",
                                        "priority": 'success',
                                        "fade": 2000
                                    }
                                ]);
                            }

                        }else{
                            //Informo de que ha fallado al menos una pregunta y debe contestar la fase de nuevo
                            $(document).trigger("add-alerts", [
                                {
                                    "message": "Has fallado alguna pregunta de la fase. Intentalo de nuevo!",
                                    "priority": 'danger',
                                    "fade": 2000
                                }
                            ]);
                            window.preguntasFaseActual = 0;
                            window.puntuacion -= window.preguntas[window.faseActual].length;
                            jQuery('.badge').text( window.puntuacion);
                            rellenaPregunta();
                        }
                    });
                }
            });
            rellenaPregunta();
        });

        function funcionSalir() {
            window.location.href = "pantallaMenu.php";
        }


    </script>

    <style type="text/css">
        label{
            word-wrap: break-word;
            white-space: initial!important;
        }

        body{
            overflow-x: hidden;
        }
    </style>
</head>
<body class="container-fluid">
<div class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><b>Celiaquía  a Prueba</b></a>
        <span class="glyphicon glyphicon-off logout" onclick="window.location.href='logout.php';"></span>
    </div>
    <div class="row mt centered" style="position: absolute; top: 8px; width: 100%;">
        <button type="button" class="btn btn-info">Puntuaci&oacute;n Obtenida
            <span class="badge">0</span></button> <!-- Pendiente de ir sumando aciertos -->
    </div>
</div>


<div class="jumbotron panel panel-default" style="margin-top: 170px; background-color:#F4F6F7">
    <div class="panel-body" id="preguntas">
    </div>
    <div class="row btn-group" data-toggle="buttons" style="margin: 20px; width: 100%;">
        <div id="respuestas">

        </div>
        <div class="col-xs-12">
            <div class="centered" style="margin-top: 50px">
                <button type="button"  class="btn btn-info" id="contestar"> Contestar </button>
            </div>

                    </div>
    </div>

</div>
<div data-alerts="alerts" style="position: absolute; right: 20px; top: 20px; width: 25%; height: auto; z-index: 1031;"></div>

</body>
</html>
<?php
include('session_check.php');
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, minimum-scale=1.0, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Pantalla Calendario</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://underscorejs.org/underscore-min.js"></script>
    <script type="text/javascript" src="js/calendar.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="js/es-ES.js"></script>
    <script type="text/javascript" src="js/star-rating.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css"  />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/calendar.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/star-rating.min.css"/>
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">

    <link rel="stylesheet" href="css/main.css">
    <script src="js/bootstrap-waitingfor.min.js"></script>
    <!--alerts-->
    <script src="js/alerts_trivial/jquery.bsAlerts.js"></script>


    <style>
        .em{
            height: 2.5em!important;
            width: 2.5em!important;
        }

        .caption{
            display: none!important;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function() {
            window.calendar = $("#calendar").calendar({
                events_source: 'calendario.php', /** json **/
                view: 'month',
                tmpl_path: 'tmpls/',
                tmpl_cache: false,
                day: 'now',
                modal: "#events-modal",
                modal_type: 'template',
                first_day: 1,
                onAfterEventsLoad: function(events) {
                    if(!events) {
                        return;
                    }
                    var list = $('#eventlist');
                    list.html('');

                    $.each(events, function(key, val) {
                        $(document.createElement('li'))
                            .html('<a href="' + val.url + '">' + val.title + '</a>')
                            .appendTo(list);
                    });
                },
                onAfterViewLoad: function(view) {
                    $('.page-header h3').text(this.getTitle());
                    $('.btn-group button').removeClass('active');
                    $('button[data-calendar-view="' + view + '"]').addClass('active');

                    if(this.options && this.options.day && this.options.day.length > 3) {
                        window.currentDate = new Date(this.options.day);
                        window.currentDate.setHours(0);
                    }

                    if($('#cal-day-box').length > 0){
                        $('#cal-day-box .botonNewSintoma').click(function(){
                            $.get('tmpls/modal_dia.html?t='+new Date().getTime()).done(function(html){
                                html = html.replace('%FECHACOMIENZO%', $('.page-header h3').text()).replace('%FECHAFIN%', $('.page-header h3').text());
                                $('#events-modal .modal-body').html(html);
                                $('.rating-loading').rating({clearButton: '',
                                    clearElement: "",
                                    captionElement: ""});
                                $('#altura,#peso').change(function(){

                                    var imc = IMC(parseInt($('#peso').val()), parseFloat(parseInt($('#altura').val()) / 100));
                                    var imcRango='';

                                    if(imc < 18.5){
                                        imcRango='Bajo Peso';
                                    }else if(imc >= 18.5 && imc<= 24.99){
                                        imcRango='Normal';
                                    } else if(imc >= 25 && imc <30){
                                        imcRango='Sobrepeso';
                                    }else if(imc >= 30  && imc <40){
                                        imcRango='Obesidad';
                                    }else if(imc >=40){
                                        imcRango='Obesidad mórbida';
                                    }

                                    $('#imc').val(parseFloat(imc).toFixed(2)); /** 2 decimales **/
                                    $('#imcRango').val(imcRango);
                                });
                                $('#home').children('i').click(function(){
                                    var valorEstadoAnimico = 0;
                                    if($(this).hasClass('em-anguished')){
                                        valorEstadoAnimico = 1;
                                    }else if($(this).hasClass('em-astonished')){
                                        valorEstadoAnimico = 2;
                                    }else if($(this).hasClass('em em-blush')){
                                        valorEstadoAnimico = 3;
                                    }else{
                                        valorEstadoAnimico = 4;
                                    }
                                    //todo: actualizar objeto
                                });
                            });
                        });
                        $('#volver').click(function(){
                            $('button[data-calendar-view="month"]').click();
                        });
                    }

                    $('.cal-month-day').click(function(){
                        var fechaNuevoSintoma = $(this).children('span').attr('data-cal-date');
                        setTimeout(function(){
                            $('.botonNewSintoma').not($('#cal-day-box .botonNewSintoma')).click(function(){  /** por hacer**/
                            alert('POR HACER: CREAR NUEVO SINTOMA!');
                            });
                        }, 200);
                    });
                },
                classes: {
                    months: {
                        general: 'label'
                    }
                }
            });

            $('.btn-group button[data-calendar-nav]').each(function() {
                var $this = $(this);
                $this.click(function() {
                    calendar.navigate($this.data('calendar-nav'));
                });
            });

            $('.btn-group button[data-calendar-view]').each(function() {
                var $this = $(this);
                $this.click(function() {
                    calendar.view($this.data('calendar-view'));
                });
            });

            $('#modalGuardar').click(function(ev) {
                var analiticaDato1=$('#Dato1').val();
                var analiticaDato2=$('#Dato2').val();
                var analiticaDato3=$('#Dato3').val();
                var analiticaDato4=$('#Dato4').val();
                var analiticaDato5=$('#Dato5').val();
                var analiticaDato6=$('#Dato6').val();
                var analiticaDato7=$('#Dato7').val();
                var analiticaDato8=$('#Dato8').val();
                var analiticaDato9=$('#Dato9').val();
                var analiticaDato10=$('#Dato10').val();
                var peso=$('#peso').val();
                var altura=$('#altura').val();
                var imc=$('#imc').val();
                var ratingSangrado=$('#rating-sangrado').val();
                var tipoMenstruacion = $('input[type="radio"][name="tipomenstruacion"]:checked').val();
                var estadoAnimico = $('input[type="radio"][name="estados"]:checked').val();
                var orina = $('input[type="radio"][name="orina"]:checked').val();
                var bristol = $('input[type="radio"][name="bristol"]:checked').val();
                var fecha = window.currentDate ? window.currentDate.getTime() : Date.now();
                var anticonceptivo = $('#anticonceptivoRadio').is('checked') ? 0 : 1;

                var fechaInicioMenstruacion = tipoMenstruacion && tipoMenstruacion == 'inicio' ? fecha : 'null';
                var fechaFinMenstruacion = tipoMenstruacion && tipoMenstruacion == 'fin' ? fecha : 'null';
                <!--coge los values de los checks los mete en un array y los separa por comas para almacenarlos en la db, he puesto los -->
                <!--value de los checks igual que los ids de la bd para despues operar mejor-->
                var id_sintomas= $.map($('#sintomascheck:checked,#sintomascheck2:checked,#sintomascheck3:checked,#sintomascheck4:checked, #sintomascheck5:checked'), function(elem){return $(elem).val()}).join(',');
                var id_dolores_articulares= $.map($('#Artcheck1:checked,#Artcheck2:checked,#Artcheck3:checked,#Artcheck4:checked, #Artcheck5:checked'), function(elem){return $(elem).val()}).join(',');
                var apetito= $('input[type="radio"][name="apetito"]:checked').val();


                var datos = {
                    fecha: fecha,
                    valor_analitica1: parseInt(analiticaDato1) || 'null',
                    valor_analitica2: parseInt(analiticaDato2) || 'null',
                    valor_analitica3: parseInt(analiticaDato3) || 'null',
                    valor_analitica4: parseInt(analiticaDato4) || 'null',
                    valor_analitica5: parseInt(analiticaDato5) || 'null',
                    valor_analitica6: parseInt(analiticaDato6) || 'null',
                    valor_analitica7: parseInt(analiticaDato7) || 'null',
                    valor_analitica8: parseInt(analiticaDato8) || 'null',
                    valor_analitica9: parseInt(analiticaDato9) || 'null',
                    valor_analitica10: parseInt(analiticaDato10) || 'null',
                    estado_animico: parseInt(estadoAnimico) || 'null',
                    id_dolores_articulares: id_dolores_articulares ? ("'" + id_dolores_articulares + "'") : 'null',
                    test_fecal: parseInt(bristol) || 'null',
                    id_sintomas: id_sintomas ? ("'" + id_sintomas + "'") : 'null',
                    apetito: apetito ? parseInt(apetito) : 'null',
                    control_peso: parseInt(peso) || 'null',
                    datos_menstruales1_fecha_inicio: fechaInicioMenstruacion,
                    datos_menstruales2_fecha_fin: fechaFinMenstruacion,
                    datos_menstruales3_dolor: 'null',
                    datos_menstruales4_sangrado: ratingSangrado ? parseFloat(ratingSangrado) : 'null',
                    datos_menstruales5_anticonceptivo: anticonceptivo,
                    test_orina: orina && orina.trim().length > 0 ? ("'" + orina + "'") : 'null'
                };
                waitingDialog.show('Guardando datos del sintoma, espere...',{
                    dialogSize: 'sm',
                    progressType: 'info'
                });
                $.ajax('calendarioInsertar.php', {
                    dataType: 'text',
                    method: 'POST',
                    data: JSON.stringify(datos),
                    contentType: 'application/json; charset=UTF-8' //Tipo de contenido que se envia al servidor para que sepa qué le estoy enviando.
                }).done(function(){
                    setTimeout(function(){
                        waitingDialog.hide();
                        $('button[data-calendar-view="month"]').click();
                    }, 2000);

                }).fail(function(){
                    setTimeout(function(){
                        waitingDialog.hide();
                    }, 2000);
                });
            });
        });

        function IMC(peso, alturaMetros){
            return peso/Math.pow(alturaMetros, 2);
        }


    </script>
</head>
<body>
<div class="container">
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="navbar-header">
            <a class="navbar-brand" href="#"><b>Control seguimiento</b></a>
            <span class="glyphicon glyphicon-off logout" onclick="window.location.href='logout.php';"></span>
        </div>
    </div>
    <div class="page-header ">
        <div class="pull-right form-inline">
            <div class="btn-group">
                <button class="btn btn-primary" data-calendar-nav="prev"><< Anterior</button>
                <button class="btn" data-calendar-nav="today">Hoy</button>
                <button class="btn btn-primary" data-calendar-nav="next">Siguiente >></button>
            </div>
            <div class="btn-group">
                <button class="btn btn-warning" data-calendar-view="year">Año</button>
                <button class="btn btn-warning active" data-calendar-view="month">Mes</button>
                <button class="btn btn-warning" data-calendar-view="week">Semana</button>
                <button class="btn btn-warning" data-calendar-view="day">Día</button>
            </div>
        </div>
        <h3></h3>
    </div>

    <div id="calendar"></div>
    <div class="modal fade" id="events-modal">
        <div class="modal-dialog" style="width: 70%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3>Evento</h3>
                </div>
                <div class="modal-body" style="height: 400px;">
                </div>
                <div class="modal-footer">
                    <a href="#" data-dismiss="modal" class="btn">Cerrar</a>
                    <a href="#" data-dismiss="modal" class="btn" id="modalGuardar">Guardar</a> <!-- mas adelante jscript que lo guarde en la bd -->
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
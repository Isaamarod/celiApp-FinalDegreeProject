<?php

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
    <link href="css/alerts_trivial/prettify.css" rel="stylesheet">
    <link href="css/alerts_trivial/styles.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/main.css" rel="stylesheet">
    <!-- Fonts from Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!--alerts-->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/alerts_trivial/jquery.bsAlerts.js"></script>
    <script src="js/loader.js"></script>
</head>
<body class="container">

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><b>Lector OCR</b></a>
        <span class="glyphicon glyphicon-off logout" onclick="window.location.href='logout.php';"></span>
    </div>
</div>


<div class="row mt centered">
    <div class="col-xs-12 hidden" id="web_ocr">
        <button type="file" class="btn btn-primary" id="web_image_btn">Subir imagen de la carta de alimentos</button>
        <input type="file" class="hidden" id="web_image_file"/>
    </div>
    <div class="col-xs-12 hidden" id="mobile_ocr">
        <button type="button" class="btn btn-primary" id="mobile_image">Tomar imagen de la carta de alimentos</button>
    </div>
    <br/>
    <br/>
    <div class="row">
        <div class="col-xs-12">
            <button type="button" class="btn btn-primary disabled" id="ocr">Comprobar imagen</button>
        </div>
        <br/>
        <br/>
        <div class="col-xs-12">
            Palabras prohibidas detectadas
            <textarea id="results" style="width: 90%; height: 100%;" readonly></textarea>
        </div>
    </div>
</div>
<script type="text/javascript">
    function requestOcr(file, base64){
        $(document).trigger("clear-alerts");
        window.AppLoader.show();
        $('#results').val('');
        //Prepare form data
        var formData = new FormData();
        if(file){
            formData.append("file", file);
        }else{
            formData.append("base64Image", 'data:image/jpeg;base64,'+base64);
        }

        formData.append("language", "spa");
        formData.append("apikey", "b27c89480688957");
        formData.append("isOverlayRequired", true);
        //Send OCR Parsing request asynchronously
        jQuery.ajax({
            url: 'https://api.ocr.space/parse/image',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (ocrParsedResult) {
                try {
                    //Get the parsed results, exit code and error message and details
                    var parsedResults = ocrParsedResult["ParsedResults"];
                    var ocrExitCode = ocrParsedResult["OCRExitCode"];
                    var isErroredOnProcessing = ocrParsedResult["IsErroredOnProcessing"];
                    var errorMessage = ocrParsedResult["ErrorMessage"];
                    var errorDetails = ocrParsedResult["ErrorDetails"];
                    var processingTimeInMilliseconds = ocrParsedResult["ProcessingTimeInMilliseconds"];
                    //If we have got parsed results, then loop over the results to do something
                    if (parsedResults != null) {
                        //Loop through the parsed results
                        $.each(parsedResults, function (index, value) {
                            var exitCode = value["FileParseExitCode"];
                            var parsedText = value["ParsedText"];
                            var errorMessage = value["ParsedTextFileName"];
                            var errorDetails = value["ErrorDetails"];

                            var textOverlay = value["TextOverlay"];
                            var pageText = '';
                            switch (+exitCode) {
                                case 1:
                                    pageText = parsedText;
                                    break;
                                case 0:
                                case -10:
                                case -20:
                                case -30:
                                case -99:
                                default:
                                    pageText += "Error: " + errorMessage;
                                    break;
                            }

                            if (parsedText && window.forbiddenWords) {
                                parsedText = parsedText.toLowerCase();
                                var results = '',
                                    totalResults = 0;
                                $.each(window.forbiddenWords, function (index, forbiddenWord) { // recorremos el indice de cada palabra
                                    if (parsedText.indexOf(forbiddenWord.palabra.toLowerCase()) > -1) { // todo a minusculas y comparamos
                                        results += forbiddenWord.palabra + ', '; //acumulamos en variable separandolas por comas
                                        totalResults++;
                                    }
                                });
                                if(totalResults> 0) {
                                    $('#results').val(results.substring(0, results.length - 2));
                                    $(document).trigger("add-alerts", [
                                        {
                                            "message": "Peligro!! Se han encontrado " + totalResults + " alimentos no aptos!!",
                                            "priority": 'danger'
                                        }
                                    ]);
                                }else{
                                    $(document).trigger("add-alerts", [
                                        {
                                            "message": "Enhorabuena! No se han encontrado alimentos peligros. Disfruta de tu comida",
                                            "priority": 'success'
                                        }
                                    ]);
                                }
                                setTimeout(function(){
                                    $(document).trigger("clear-alerts");
                                }, 5000)
                            }
                        });
                    }
                }catch(e){}
                window.AppLoader.hide();
            },
            error: function(){
                window.AppLoader.hide();
            }
        });
    }
</script>
<script type="text/javascript">

    function onImageSelected(file, base64){
        $('#ocr').removeClass('disabled');
        $('#ocr').click(function(){
            requestOcr(file, base64);
        });
    }

    function takePicture(fileCallback){
        var options = {
            // Some common settings are 20, 50, and 100
            quality: 50,
            destinationType: Camera.DestinationType.DATA_URL, //base 64
            // In this app, dynamically set the picture source, Camera or photo gallery
            sourceType: Camera.PictureSourceType.CAMERA,
            encodingType: Camera.EncodingType.JPEG,
            mediaType: Camera.MediaType.PICTURE,
            allowEdit: false,
            correctOrientation: false  //Corrects Android orientation quirks
        };

        navigator.camera.getPicture(function cameraSuccess(data) {
            fileCallback(null, data)
        }, function cameraError(error) {
            fileCallback(error ? e : 'Error loading camera image');
            console.debug("Unable to obtain picture: " + error, "app");
        }, options);
    }

    window.AppLoad = function(){
        $(document).ready(function(){
            window.AppLoader.show();
            if(!window.cordova){ // si no se trata de un dispositivo movil
                $('#web_ocr').removeClass('hidden');
                $('#web_image_btn').click(function(){ //activamos el boton para adjuntar la imagen
                    $('#web_image_file').click();
                });
                $('#web_image_file').change(function(){
                    onImageSelected($('#web_image_file')[0].files[0])
                });
            }else{ // en el caso de ser un dispositivo móvil
                $('#mobile_ocr').removeClass('hidden'); // mostramos el botón para tomar la foto
                $('#mobile_image').click(function(){
                    window.AppLoader.show();
                    takePicture(function(err, imgDataB64){
                        window.AppLoader.hide();
                        if(err && err != null) {
                            $(document).trigger("add-alerts", [
                                {
                                    "message": err,
                                    "priority": 'danger',
                                    fade: 2000
                                }
                            ]);
                            setTimeout(function(){
                                $(document).trigger("clear-alerts");
                            }, 2000)
                            return;
                        }
                        onImageSelected(null, imgDataB64);
                    });
                });
            }

            $.ajax('ocr.php', { //nos comunicamos
                dataType: 'text',
                method: 'GET'
            }).done(function (data) {
                data = JSON.parse(data);
                if(data.data) {
                    window.forbiddenWords = data.data;
                    window.AppLoader.hide();
                }else{
                    $(document).trigger("add-alerts", [
                        {
                            "message": "Error leyendo palabras prohibidas",
                            "priority": 'danger',
                            "fade": 2000
                        }
                    ]);
                }
            }).fail(function(){
                $(document).trigger("add-alerts", [
                    {
                        "message": "Error leyendo palabras prohibidas",
                        "priority": 'danger',
                        "fade": 2000
                    }
                ]);
            });
        });
    };
</script>
<script src="js/cordova/index.js"></script>
<div style="position: absolute; right: 20px; top: 20px; left: 20px; width: 100%; height: auto; z-index: 1031;">
    <center><div class="col-xs-10 col-lg-4" data-alerts="alerts"></div></center>
</div>
</body>
</html>

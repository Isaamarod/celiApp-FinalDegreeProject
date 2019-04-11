if(navigator.userAgent.match(new RegExp(/CordovaWebview$/))){ //detecta si estoy en movil
	document.addEventListener('deviceready', function () { //ha cargado la pagina, se puede usar js
		window.AppLoad();
	}.bind(this), false);
	var script = document.createElement('script');
	script.onload = function () {
		if(!window.cordova)
			window.AppLoad();
	};
	script.src = 'js/cordova/cordova.js';
	document.head.appendChild(script);
}else
	window.AppLoad(); // si no estoy en movil directamente no tengo que cargar nada y me carga la app

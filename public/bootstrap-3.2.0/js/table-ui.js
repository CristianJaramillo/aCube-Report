(function($){

	var defaults = {
		"contentType": "application/x-www-form-urlencoded;charset=UTF-8",
		"data": [],
		"method": "POST",
		"url": "/",
	};

	$.fn.tableUI = function(options){

		// El objeto no esta definido.
		if (this.length==0) {alert("Error");return this;};

		// Referencia al objeto contenedor.
		var el = this;

		// Canfiguraciones del usuario.
		var settings = undefined;

		// Queue and Member JSON
		var queuMembers = undefined;

		/**
		 * Añade funciones a cada objeto.
		 */
		var addFunctions = function() {
			// Control para cambiar de tabla actual.
			if (el.selectQueue!=undefined) {	
				el.selectQueue.on('change', setMember);
			}
		};

		/**
		 *
		 */
		var beforeQueue = function() {
			console.log('before queue');
		};

		/**
		 *
		 */
		var errorQueue = function() {
			console.log('error queue');
		};

		/**
		 * Inicia el plugin.
		 */
		var init = function() {
			// Mescla las configuraciones usuario.
			settings = $.extend({}, defaults, options);
			// Creamos una estructura de nodos para facil acceso.
			nodeStruct();
			// Agregamos los eventos a los controles
			addFunctions();
			// Obtenenos las queueMembers
			loadData(beforeQueue, errorQueue, successQueue);
		};
		/**
		 * Obtenemos los resultados de una consulta en formato JSON
		 */
		var loadData = function(beforef, errorf, successf) {
			$.ajax({
				async: true,
				beforeSend: beforef,
				contentType: settings.contentType,
				data: settings.data,
				dataType: "json",
				error: errorf,
				success: successf,
				timeout: 10000,	
				type: settings.method,
				url: settings.url
			});
		};

		/**
		 * Estructura de nodos.
		 */
		var nodeStruct = function() {
			/**
			 * Controles principales de la aplicación.
			 */
			if (el.find("#queue").length!=0) {
				el.selectQueue = el.find("#queue");
			}

			if (el.find("#queue_member").length!=0) {
				el.selectQueueMember = el.find("#queue_member");
			}

			if (el.find("#date_from").length!=0) {
				el.dateFrom = el.find("#date_from");
			}

			if (el.find("#date_to").length!=0) {
				el.dateTo = el.find("#date_to");
			}

			if (el.find("#btn").length!=0) {
				el.submit = el.find("#btn");
			}
		};

		/**
		 * Establece los usuarios de la cola seleccionadad.
		 */
		var setMember = function() {

			var queue = this.value;

			el.selectQueueMember.empty();
			el.selectQueueMember.append('<option value="all">-- All Queue Memebers --</option>');

			if (queue != 'all') {
				$.each(queuMembers, function(a, b){
					if (a == queue) {
						$.each(b, function(c, d){
							el.selectQueueMember.append('<option value="' + d + '">' + d + '</option>');
						});
					};
				});
			}
		};

		/**
		 * Agrega las colas al campo select
		 */
		var successQueue = function(json) {
			
			$.each(json, function(a, b){
				el.selectQueue.append('<option value="' + a + '">' + a + '</option>');
			});
			
			queuMembers = json;
		};

		init();

	};

})(jQuery);
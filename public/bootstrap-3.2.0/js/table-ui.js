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
			
			$(el).submit(submitForm);

		};

		/**
		 *
		 */
		var beforeQueue = function() {
			console.log('beforeQueue');
		};

		/**
		 *
		 */
		var beforeReport = function() {
			var tbody = $("#table-report tbody").empty();
			console.log('beforeReport');
		};

		/**
		 *
		 */
		var errorQueue = function() {
			console.log('error queue');
		};

		/**
		 *
		 */
		var errorReport = function() {
			console.log('errorReport');
		}

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
		 *
		 */
		var showErrors = function (erros) {
			console.log(erros);
		};

		/**
		 *
		 */
		var showReport = function (report) {
			
			var tbody = $("#table-report tbody");

			$.each(report, function(index, row) {
				
				if (!index) {
					setTHead(row);	
				};

				var tr = $("<tr/>");

				$.each(row, function(a, b){
					tr.append("<td>" + b + "</td>");
				});

				tbody.append(tr);

			});
		};

		var setTHead = function (row) {
				
			var thead = $("#table-report thead tr:first");

			thead.empty();

			$.each(row, function(a, b){
				thead.append("<th>" + a + "</th>");
			});
		}

		/**
		 *
		 */
		var submitForm = function(event) {
			
			event.preventDefault();

			settings.data = $(this).serialize();

			settings.url = settings.url_responce;

			loadData(beforeReport, errorReport, successReport);

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

		/**
		 *
		 */
		var successReport = function(json) {
			
			$.each(json, function(event, obj) {
				if (typeof obj == "object") {
					if (obj.length) {
						if (event == 'error') {
							showErrors(obj);
						} else if (event == 'success') {
							showReport(obj);
						};
					};
				}
			});
			
		};

		init();

	};

})(jQuery);
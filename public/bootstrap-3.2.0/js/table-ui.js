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
			el.msg.alert.empty();
			el.msg.alert.hide();
			el.table.tbody.empty();
			el.table.tbody.append("<tr><td colspan=\"7\"><center>No se ha encontrado ningun registro!</center></td></tr>");
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
		 *
		 */
		var time = function(t) {
			var expTime    = new Date(0, 0, 0, 0, 0, parseInt(t), 0);
			var h          = expTime.getHours()
			var i          = expTime.getMinutes()
			var s          = expTime.getSeconds()

			h = h < 10 ? '0' + h : h; 
			i = i < 10 ? '0' + i : i;
			s = s < 10 ? '0' + s : s;
			
			return h +":"+ i +":"+ s 
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
			if (el.find("#queue").length) {
				el.selectQueue = el.find("#queue");
			}

			if (el.find("#queue_member").length) {
				el.selectQueueMember = el.find("#queue_member");
			}

			if (el.find("#date_from").length) {
				el.dateFrom = el.find("#date_from");
			}

			if (el.find("#date_to").length) {
				el.dateTo = el.find("#date_to");
			}

			if (el.find("#btn").length) {
				el.submit = el.find("#btn");
			}

			if ($("#table-report").length) {

				el.table = $("#table-report");

				if (el.table.find("thead").length) {
					el.table.thead = el.table.find("thead");
					if (el.table.thead.find("tr:last-child").length) {
						el.table.thead.tr = el.table.thead.find("tr:last-child");
					};
				}

				if (el.table.find("tbody").length) {
					el.table.tbody = el.table.find("tbody");
				}

			};

			if ($("#message-error").length) {
				el.msg = $("#message-error");
				if (el.msg.find('.alert').length) {
					el.msg.alert = el.msg.find('.alert');
					el.msg.alert.empty();
					el.msg.alert.hide();
				};
			};

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
		var showErrors = function (errors) {

			var i = 0;

			$.each(errors, function(index, msg){
				el.msg.alert.append("<p>"+msg+"</p>");
				i++;
			});

			if (i>=1) {
				el.msg.alert.show();
			};

		};

		/**
		 *
		 */
		var showReport = function (report) {

			// Nueva fila de la tabla
			var tr = undefined;
			// Contador
			var i = 0;

			var list = new Array(0, 0, 0, 0, 0, 0);
			var prom = new Array(0, 0, 0);


			el.table.tbody.empty();

			$.each(report, function(index, row) {
				
				tr = $("<tr/>");

				var aux = new Array();

				$.each(row, function (key, values) {
					
					switch(key){
						case "ENTERQUEUE":
							list[0]++;
							aux[0] = values.time;
							aux[1] = values.queue;
							aux[3] = values.phone;
						break;
							
						case 'CONNECT':
							list[1]++;
							aux[2] = values.agent;
							prom[0] += aux[4] = parseInt(values.waiting);
						break;

						case 'TRANSFER':
							list[5]++;
							prom[1] += aux[5] = parseInt(values.duration);
							aux[6] = key;
						break;
							
						case 'COMPLETECALLER':
							list[4]++;
							prom[1] += aux[5] = parseInt(values.duration);
							aux[6] = key;
						break;

						case 'COMPLETEAGENT':
							list[3]++;
							prom[1] += aux[5] = parseInt(values.duration);
							aux[6] = key;
						break;

						case 'ABANDON':
							list[2]++;
							aux[2] = 'NONE';
							prom[2] += aux[4] = parseInt(values.waiting);
							prom[1] += aux[5] = parseInt(values.duration);
							aux[6] = key;
						break;
					};

				});

				for (i = 0; i < 7; i++) {
					
					if (i == 4 || i == 5) {
						aux[i] = time(aux[i]);
					}

					if (i == 6) {
						switch(aux[i]) {
							case 'TRANSFER':
							case 'COMPLETECALLER':
							case 'COMPLETEAGENT':
								aux[i] = '<center><button class="btn btn-success">'+aux[i]+'</button></center>';
							break;
							case 'ABANDON':
								aux[i] = '<center><button class="btn btn-danger">'+aux[i]+'</button></center>';
							break;
						}
					};

					tr.append("<td>"+aux[i]+"</td>");
				};


				el.table.tbody.append(tr);

			});

			$("#a").text(list[0]); // total de llamadas
			$("#b").text(list[1]); // total de llamadas contestadas
			$("#c").text(list[2]); // total de llamadas abandonadas
			$("#d").text(list[3]); // tatal de llamadas finalizadas por el agente
			$("#e").text(list[4]); // tatal de llamadas finalizadas por el cliente
			$("#f").text(list[5]); // tatal de llamadas trasferidas

			// Promedio de atencion
			if (prom[0]>0 && list[1]>0) {
				prom[0] = time(prom[0] / list[1]);
			} else {
				prom[0] = "00:00:00";
			};

			if (prom[1]>0 && (list[3] + list[4] + list[5])>0) {
				prom[1] = time(prom[1] / (list[3] + list[4] + list[5]));
			} else {
				prom[1] = "00:00:00";
			};

			if (prom[2]>0 && list[2]>0) {
				prom[2] = time(prom[2] / list[2]);
			} else {
				prom[2] = "00:00:00";
			};

			$("#tClient").text(prom[0]);
			$("#tCall").text(prom[1]);
			$("#tAbandon").text(prom[2]);

		};

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
				if (event == 'error') {
					showErrors(obj);
				} else if (event == 'success' && obj != 0) {
					showReport(obj);
				};
			});
		};

		init();

	};

})(jQuery);
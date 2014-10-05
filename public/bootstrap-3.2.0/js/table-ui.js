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

		// logQueu JSON
		var logQueu = undefined;

		// Llamadas recibidas.
		var enterqueue = 0;
		
		// Llamadas atendidas.
		var connect = 0;
		
		// Llamadas abandonadas.
		var abandon = 0;
		
		// Llamadas trasferidas.
		var transfer = 0;
		
		// Llamadas terminadas por el cliente.
		var completecaller = 0;

		// Llamadas terminadas por el agente.
		var completeagent = 0;

		// Llamadas que exedieron el tiempo en cola.
		var exitwithtimeout = 0;

		// Llamadas sin agente disponible.
		var exitempty = 0;


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
				$.each(logQueu, function(a, b){
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

		var loadRows = function (index, row) {
			// Nueva fila	
			var tr = $("<tr/>", {"call":index});
			
			// Resumen de llamada.
			var call = new Array(); 

			$.each(row, function (key, value) {

				switch (key) {
					case "ENTERQUEUE":
						call[0] = value.time;        // Fecha
						call[1] = value.queue;       // Cola
						call[3] = value.phone;       // Origen
					break;
					case "CONNECT":
						call[2] = value.agent;       // Agente
						if (call[4] == undefined) {
							call[4] = value.waiting; // Espera
						};
					break;
					case "TRANSFER":
						if (call[4] == undefined) {
							call[4] = value.waiting; // Espera
						};
						call[5] = value.duration;    // Duración
					break;
					case "COMPLETECALLER":
						call[4] = value.waiting;     // Espera
						call[5] = value.duration;    // Duración
					break;
					case "COMPLETEAGENT":
						call[4] = value.waiting;     // Espera
						call[5] = value.duration;    // Duración
					break;
					case "EXITWITHTIMEOUT":
						if (call[4] == undefined) {
							call[4] = value.waiting;  // Espera
						};
					break;
					case "EXITEMPTY":
						if (call[4] == undefined) {
							call[4] = value.waiting;  // Espera
						};
					break;
					case "ABANDON":
						call[4] = value.waiting;      // Espera
					break;
				};

				if (call[6] == undefined) {
					call[6] = key;
				};

			});

			if (call[2] == undefined) {
				call[2] = "NONE";         // Agente
			};
			if (call[4] == undefined) {
				call[4] = 0;              // Espera
			};
			if (call[5] == undefined) {
				call[5] = 0;              // Espera
			};

			call[4] = time(parseInt(call[4]));
			call[5] = time(parseInt(call[5]));
			call[6] = status(call[6]);

			for (var i = 0; i <= 6; i++) {
				tr.append("<td>"+call[i]+"</td>");
			};

			// Agregamos la nueva fila
			el.table.tbody.append(tr);
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

			console.log(report);

			$.each(report, loadRows);

			/*
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
			*/

		};

		/**
		 *
		 */
		var status = function (status) {
			
			var style = "btn btn-";
			
			switch (status) {
				case "ENTERQUEUE":
					style += 'acube';
				break;
				case "CONNECT":
					style += 'info';
				break;
				case "TRANSFER":
				case "COMPLETECALLER":
				case "COMPLETEAGENT":
					style += 'success';
				break;
				case "EXITWITHTIMEOUT":
				case "EXITEMPTY":
					style += 'warning';
				break;
				case "ABANDON":
					style += 'danger';
				break;
				default:
					style += 'default';
				break;	
			};

			return "<button class=\""+style+"\">"+status+"</button>";			
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
			
			logQueu = json;
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
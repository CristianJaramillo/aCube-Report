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

		// logQueu JSON respaldo de colas y agentes.
		var logQueu = undefined;

		// Respaldo de reporte actual.
		var logReport = undefined;

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

		// Espera promedio del cliente.
		var waitingconnect = 0;

		// Duración promedio de llamada.
		var duration = 0;

		// Espera promedio de abandono.
		var waitingabandon = 0;

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
			enterqueue     = 0;
			connect        = 0;
			abandon        = 0;
			completecaller = 0;
			completeagent  = 0;
			transfer       = 0;
			duration       = 0;
			waitingabandon = 0;
			waitingconnect = 0;
			el.msg.alert.empty();
			el.msg.alert.hide();
			el.table.tbody.empty();
			el.table.tbody.append("<tr><td colspan=\"7\"><center>No se ha encontrado ningun registro!</center></td></tr>");
			setDataDashboard();
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
		 *
		 */
		var setDataDashboard = function() {
			$("#a").text(enterqueue);     // total de llamadas
			$("#b").text(connect);        // total de llamadas contestadas
			$("#c").text(abandon);        // total de llamadas abandonadas
			$("#d").text(completecaller); // total de llamadas finalizadas por el agente
			$("#e").text(completeagent);  // total de llamadas finalizadas por el cliente
			$("#f").text(transfer);       // total de llamadas trasferidas

			var t1 = time(waitingconnect/(connect ? connect : 1));

			var t2 = time(duration/((enterqueue-abandon) > 0 ? (enterqueue-abandon) : 1));

			var t3 = time(waitingabandon/(abandon ? abandon : 1));

			$("#tClient").text(t1);
			$("#tCall").text(t2);
			$("#tAbandon").text(t3);

			$("#table-description tbody").empty();
			$("#table-description tbody").append("<tr><td colspan=\"3\" style=\"text-align:center;\">Tabla sin contenido</td></tr>");
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

		/**
		 * @param callid
		 * @param row
		 * return void
		 */
		var loadRows = function (callid, row) {
			// Nueva fila	
			var tr = $("<tr/>", {"callid":callid});
			
			// Resumen de llamada.
			var callSumary = new Array(); 

			// Eventos presentes
			var size = row.length;
			
			// Agregamos la llamada a contador
			enterqueue++;

			// Ultimo estado de llamada.
			callSumary[6] = row[--size].event;

			// Obtención de resumen de llamada.
			$.each(row, function (index, call) {
				switch (call.event) {
					case "ENTERQUEUE":
						if (callSumary[0] == undefined) {
							callSumary[0] = call.time;    // Fecha
						};
						if (callSumary[1] == undefined) {
							callSumary[1] = call.queue;    // Fecha
						};
						if (callSumary[3] == undefined) {
							callSumary[3] = call.phone;    // Fecha
						};
					break;
					case "CONNECT":
						connect++;
						if (callSumary[2] == undefined) {
							callSumary[2] = call.agent;   // Agente
						};
						if (callSumary[4] == undefined) {
							callSumary[4] = call.waiting; // Espera
						};
					break;
					case "TRANSFER":
						transfer++;
						if (callSumary[2] == undefined) {
							callSumary[2] = call.agent;   // Agente
						};
						if (callSumary[4] == undefined) {
							callSumary[4] = call.waiting; // Espera
						};
						if (callSumary[5] == undefined) {
							callSumary[5] = call.duration;// Duración
						};
					break;
					case "COMPLETECALLER":
						completecaller++;
						if (callSumary[2] == undefined) {
							callSumary[2] = call.agent;   // Agente
						};
						callSumary[4] = call.waiting;     // Espera
						callSumary[5] = call.duration;    // Duración
					break;
					case "COMPLETEAGENT":
						completeagent++;
						if (callSumary[2] == undefined) {
							callSumary[2] = call.agent;   // Agente
						};
						callSumary[4] = call.waiting;     // Espera
						callSumary[5] = call.duration;    // Duración
					break;
					case "EXITWITHTIMEOUT":
						exitwithtimeout++;
						if (callSumary[4] == undefined) {
							callSumary[4] = call.waiting;  // Espera
						};
					break;
					case "EXITEMPTY":
						exitempty++;
						if (callSumary[4] == undefined) {
							callSumary[4] = call.waiting;  // Espera
						};
					break;
					case "ABANDON":
						console.log('ABANDON');
						abandon++;
						callSumary[4] = call.waiting;      // Espera
					break;
				};
			});

			if (callSumary[2] == undefined) {
				callSumary[2] = "NONE";         // Agente
			};
			
			if (callSumary[4] == undefined) {
				callSumary[4] = 0;              // Espera
			};
			
			if (callSumary[5] == undefined) {
				callSumary[5] = 0;              // Duración
			};

			if (callSumary[6] == "ABANDON") {
				waitingabandon += parseInt(callSumary[4]);
			} else {
				waitingconnect += parseInt(callSumary[4]);
			}

			duration += parseInt(callSumary[5]);


			// Parseo de datos.
			callSumary[4] = time(parseInt(callSumary[4]));
			callSumary[5] = time(parseInt(callSumary[5]));
			callSumary[6] = status(callSumary[6]);

			// Agregamos las nuevas columnas
			for (var i in callSumary) {
				tr.append("<td>"+callSumary[i]+"</td>");
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
			// Vaciamos la tabla.
			el.table.tbody.empty();
			// cargamos los registros a la tabla.
			$.each(report, loadRows);

			setDataDashboard();

			if (el.table.tbody.find('button.btn').length) {
				el.table.tbody.find('button.btn').on('click', function(){

					var callid = $(this).parent('td').parent('tr').attr('callid');


					// .replace('e', 'E')
					var style = $(this).attr('class').replace('btn btn-', '');

					// if (style=='acube') {style='info';};

					el.table.tbody.find('tr').removeAttr('class');
					$(this).parent('td').parent('tr').addClass(style);

					var tbody = $("#table-description tbody");

					tbody.empty();

					$.each(logReport, function (id, logCall) {
						if (id == callid) {
							$.each(logCall, function (index, obj) {
							
								var tr = $("<tr/>");

								var row = new Array(); 

								switch (obj.event) {
									case "ENTERQUEUE":
										row[0] = "Fecha: " +
												 obj.time +
												 "<br/>Origen: "+
												 obj.phone +
												 "<br/>Cola de destino: " +
												 obj.queue;
									break;
									case "CONNECT":
										row[0] = "Atendido por el agente: " +
												 obj.agent;
										row[1] = obj.waiting;
									break;
									case "TRANSFER":
										row[0] = "El agente: " + obj.agent + "<br/>Transfirio a " + obj.transfer;
										row[1] = obj.waiting;
										row[2] = obj.duration;
									break;
									case "COMPLETECALLER":
										row[0] = "Finalizo llamada con el agente: " + obj.agent;
										row[1] = obj.waiting;
										row[2] = obj.duration;
									break;
									case "COMPLETEAGENT":
										row[0] = "Finalizo llamada con el agente: " + obj.agent;
										row[1] = obj.waiting;
										row[2] = obj.duration;
									break;
									case "EXITWITHTIMEOUT":
										row[0] = "Salio de cola, tiempo maximo de espera!";
										row[1] = obj.waiting;
									break;
									case "EXITEMPTY":
										row[0] = "Salio de cola, no hay agentes!";
										row[1] = obj.waiting;
									break;
									case "ABANDON":
										row[0] = "Abandono la llamada";
										row[1] = obj.waiting;
									break;	
								};

								if (row[1]==undefined) {
									row[1] = 0;
								};

								if (row[2]==undefined) {
									row[2] = 0;
								};

								row[1] = time(parseInt(row[1]));
								row[2] = time(parseInt(row[2]));

								for (var i in row) {
									tr.append("<td>"+row[i]+"</td>");
								};

								tbody.append(tr);

							});
						};
					});

				});
			};

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
					style += 'primary';
				break;
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
					logReport = obj;
				};
			});
		};

		init();

	};

})(jQuery);
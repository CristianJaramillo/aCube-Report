(function($){

	/**
	 * Variables por defecto.
	 */
	var defaults = {
		"modal" : true,
		"effect": "rotate"
	};

	/*
	 * Inicializa la estructura de la aplicación y maneja los menus
	 * del documento.
	 */
	$.fn.startUX = function(options){

		if (this.length==0) {return 0;};

		// Referencia al contenedor.
		var el = this;
		// Configuraciones del plugin.
		var settings = undefined;
		// Structura por defecto de la ventana modal.
		var modal = {
			"class": "modalmask",
			"childrens": {
				"0":{
					"class": "modalbox"
				}
			},
			"id": "modal"
		};

		/**
		 * Añade elementos a un objeto mediante
		 * una structura modal dada.
		 */
		var addElement = function(obj, json){
			$.each(json, function(a, b){
				var childrens = undefined;
				var tag       = "div";
				if (b.class!=undefined) {if (b.class=="modalbox") {b.class += " " + settings.effect;};};
                if (b.childrens!=undefined) {childrens=b.childrens;delete b.childrens;}
				if (b.tag!=undefined) {tag = b.tag; delete b.tag;}
				var x = $("<"+tag+"/>", b).appendTo(obj);
				if (childrens!=undefined) {addElement(x, childrens);};
			});
		};

		/*
		 * Agrega plugins de terceros.
		 */
		var addPlugins = function (){
			if (settings.modal) {
				var childrens = undefined;
				var tag       = "div";
				if (modal.childrens!=undefined) {childrens=modal.childrens;delete modal.childrens;};
				if (modal.tag!=undefined) {tag = modal.tag; delete modal.tag;}
				var x = $("<"+tag+"/>", modal).appendTo(el);
				if (childrens!=undefined) {addElement(x, childrens);};
				// Agregamos a la estructura de nodos
				el.modal = el.find("#modal");
				// Agregamos a la estructura de nodos
				el.modal.box = el.modal.find("div.modalbox");
			};
		};

		/**
		 * Inicia la palicación.
		 */
		var init = function(){
			// Obtine las configuraciones basicas del usuario.
			settings = $.extend({}, defaults, options);
			// Agregamos plugins.
			addPlugins();
			// Establecemos las dimenciones iniciales de la aplicación.
			setHeight();
			// Agregamos sus funciones a los elementos.
			setFunctions();
		};

		/**
		 * Acciones al detectar un evento ajax.
		 */
		var setFunctions = function(){

			$(document).ajaxStart(function(){
				// Mostramos la ventana modal.
				$(location).attr("href", "#modal");
			});

			$(document).ajaxStop(function(){
				// Cerramos la ventana modal.
				$(location).attr("href", "#close");
			});

		};

		/**
		 * Define las dimenciones de la ventana modal.
		 */
		var setHeight = function(){
			
			// Obtenemos el alto reale de la app
			var h = $(window).outerHeight();
			
			// Dimenciones de la ventana modal.
			if (el.modal!=undefined){
				if (el.modal.box!=undefined) {
					el.modal.box.css({
						"margin-top": (h/2.0) + "px"
					});
				};
			};

		};

		init();

	};

})(jQuery);
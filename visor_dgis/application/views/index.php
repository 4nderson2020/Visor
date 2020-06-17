<div class="container-fluid">

    <div class="row" id = "visor">

        <div class="col-md-12" id="espacio">
        
        <div id="btnpanel">
            <a href="#" id="muestra" class="btn btn-circle btn-success"><span class="fa fa-list"></span></a>
        </div>  

        <div class="info-flotante" >                            
            <div class="col-xs-63 col-md-pull-9 p-r-0 scrollbar" id="panel">
                <div class="card card-outline-info p-b-1" id="contenedor">
                    <!-- <div class="borde box-search"> -->
                    <div class="card-header" id="tituloFiltros">
                        <div class="sidebar-toggle-box">                   
                            <div class="field" style="padding-top: 2px;">
                            <span class="text-white"style="font-weight: 600;font-size: 13px;">VISOR DE MAPAS :</span>
                            <!-- <input type="text" name="txturl" id="txturl" class="input-fil" style="width: 60%" autocomplete="off">

                            <button id="btnbuscar" class="btn btn-primary btn-xs" data-toggle="modal" title="Buscar"><img src="assets/images/icono-buscar.png" width="20"/></button> -->

                            <button id="btnlimpiar" class="btn btn-primary btn-xs" data-toggle="modal" title="Limpiar"><img src="assets/images/icono-limpiar4.png" width="20"/></button>

                            <!-- <button id="btnmodalvideo" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalVideo" 
                             title="Video Tutoriales"><img src="assets/images/Youtuben.png" width="20"/></button> -->

                            <!-- <button id="btnmodalvideo" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open</button>         -->

                            <button id="ocultar" class="btn btn-primary btn-xs" data-toggle="modal" title="Ocultar"><img src="assets/images/icono-ocultar3.png" width="20"/></button>
                            </div> 
                        </div>                      
                    </div>

                    <div class="card-body p-1">
                        <h4 class="toast-header">Capas de Información: </h4>                     
                        
                        <div class="form-group row">
                            <div class="form-check col-md-12" style="padding-left:10px;">
                                <h4 class="toast-header" style="font-weight:500;">Límites Políticos</h4>
                              <input class="form-check-input" type="checkbox" id="ckbDepartamento" style="margin-left:0px;" checked>
                              <label class="form-check-label linkPopOver" for="ckbDepartamento" data-container="body" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" data-content="<span style='font-size:10px;'><img width='30px' src='assets/images/dpto.png'></span>">Departamentos</label>
                            </div>
                            <div class="form-check col-md-6" style="padding-left:10px;">
                              <input class="form-check-input" type="checkbox" id="ckbProvincia" style="margin-left:0px;">
                              <label class="form-check-label linkPopOver" for="ckbProvincia" data-container="body" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" data-content="<span style='font-size:10px;'><img width='30px' src='assets/images/prov.png'></span>">Provincias</label>
                            </div>
                            <div class="form-check col-md-6" style="padding-left:10px;">
                              <input class="form-check-input" type="checkbox" id="ckbDistrito" style="margin-left:0px;">
                              <label class="form-check-label linkPopOver" for="ckbDistrito" data-container="body" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" data-content="<span style='font-size:10px;'><img width='30px' src='assets/images/dist.png'></span>">Distritos</label>
                            </div>
                            <div class="form-check col-md-12" style="padding-left:10px;">
                                <h4 class="toast-header" style="font-weight:500;">Comisarías Básicas</h4>
                              <input class="form-check-input" type="checkbox" id="ckbComisaria" style="margin-left:0px;">
                              <label class="form-check-label linkPopOver" for="ckbComisaria" data-container="body" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" data-content="<p style='font-size:14px;'><img width='30px' src='assets/images/ico-comisaria.png'></p>">Comisarías</label>
                            </div>
                            <div class="form-check col-md-6" style="padding-left:10px;">
                              <input class="form-check-input" type="checkbox" id="ckbJurisdiccionCom" style="margin-left:0px;">
                              <label class="form-check-label linkPopOver" for="ckbJurisdiccionCom" data-container="body" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" data-content="<p style='font-size:14px;'><img width='30px' src='assets/images/jurisdiccion.png'></p>">Jurisdicción Comisaría</label>
                            </div>
                            <div class="form-check col-md-6" style="padding-left:10px;">
                              <input class="form-check-input" type="checkbox" id="ckbJurisdiccionDiv" style="margin-left:0px;">
                              <label class="form-check-label linkPopOver" for="ckbJurisdiccionDiv" data-container="body" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" data-content="<p style='font-size:14px;'><img width='30px' src='assets/images/divpol.png'></p>">Jurisdicción Divpol</label>
                            </div>
                            <div class="form-check col-md-6" style="padding-left:10px;">
                              <input class="form-check-input" type="checkbox" id="ckbSector" style="margin-left:0px;">
                              <label class="form-check-label linkPopOver" for="ckbSector" data-container="body" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" data-content="<p style='font-size:14px;'><img width='30px' src='assets/images/sector.png'></p>">Sectores</label>
                            </div>
                            <div class="form-check col-md-12" style="padding-left:10px;">
                                <h4 class="toast-header" style="font-weight:500;">Barrios Urbanos</h4>
                              <input class="form-check-input" type="checkbox" id="ckbBarrio" style="margin-left:0px;">
                              <label class="form-check-label linkPopOver" for="ckbBarrio" data-container="body" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" data-content="<p style='font-size:14px;'><img width='30px' src='assets/images/barrio.png'></p>">Barrio Seguro</label>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-1">
                        <div class="card">
                            <div class="card-body p-1">
                                <div class="row">
                                    <div class="col-md-12 themed-grid-col">
                                        <h4 class="toast-header">Fuente de información :</h4>
                                        <select class="selectpicker" data-style="data-selected-text-format" id="cbxBD">
                                            <option class="selectpicker" value="0">-- Seleccione Fuente de Información --</option>
                                            <?php 
                                            foreach ($db as $u_db) { ?>
                                            <option value="<?php echo $u_db['id_fuente']; ?>"><?php echo $u_db['descrip_bd']; ?></option>
                                            <?php } ?>       
                                        </select> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body p-1" id="divIndicador">
                                <div class="row">
                                    <div class="col-md-12 themed-grid-col">
                                        <h4 class="toast-header">Variable :</h4>
                                        <select class="selectpicker" data-style="data-selected-text-format" id="cbxIndicador">
                                            <option class="selectpicker" value="0">-- Seleccione Variable --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body p-1" id="divNivel">
                                <div class="row">
                                    <div class="col-md-12 themed-grid-col">
                                        <h4 class="toast-header">Nivel de Representación  :</h4>
                                        <select class="selectpicker" data-style="data-selected-text-format" id="cbxNivel">
                                            <option class="selectpicker" value="0">-- Seleccione Nivel de Representación --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>                   
                        <div class="card">
                            <div class="card-body p-1" id="divObjeto">
                                <div class="row">
                                    <div class="col-md-12 themed-grid-col">
                                        <input type="checkbox" name="" checked="true">
                                        <h4 class="toast-header">Objeto:</h4>
                                        <select class="selectpicker" data-actions-box="true" data-style="data-selected-text-format" title="-- Seleccione Objeto --" multiple data-live-search="true" data-size="6" data-selected-text-format="count > 3" id="cbxObjeto">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-9 card-body" id="divFiltrar">
                                <center class="p-2"><button class="btn btn-success" id="btnFiltrar"><b>FILTRAR</b></button></center>
                            </div>
                            <div class="col-md-3 card-body" id="divDescargar">
                                <center class="p-2"><button class="btn btn-success" id="btnDescargar"><li class="fa fa-download"></li></button></center>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body p-1" id="divOpcional">
                                <div class="row">
                                    <div class="col-md-12 themed-grid-col">
                                        <input type="checkbox" id="md_checkbox_21" class="filled-in chk-col-light"><label class for="md_checkbox_21">Periodo Móvil :</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body p-1" id="divFrecuencia">
                                <div class="row">
                                    <div class="col-md-12 themed-grid-col">
                                        <h4 class="toast-header">Frecuencia :</h4>
                                        <select class="selectpicker" data-style="data-selected-text-format" id="cbxFrecuencia">
                                            <option class="selectpicker" value="0">-- Seleccione Frecuencia --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body p-1" id="divPeriodo">
                                <div class="row">
                                    <div class="col-md-12 themed-grid-col">
                                        <h4 class="toast-header">Rango de Tiempo :</h4>
                                        <select class="selectpicker" data-style="data-selected-text-format" id="cbxPeriodo">
                                            <option class="selectpicker" value="0">-- Seleccione Periodo Movil --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body p-1" id="divMostrar">
                                <center class="p-2"><button class="btn btn-success" id="btnFiltrar2"><b>FILTRAR</b></button></center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        

        <div id="mapa">
            <div id="descripcion" class="col-md-4">
                <div class="card card-outline-success">
                    <div class="borde box-resume">
                        <div class="card-header" id="mtituloDesc">
                            <h5><strong><span id="tituloDesc"></span></strong></h5>
                        </div>
                        <div class="card-body" id="mfuenteDesc">
                          <h5><strong><span id="fuenteDesc"></span></strong></h5>
                        </div>
                        <div class="card-body" id="mimagenDesc">
                          <!-- <img src="assets/images/fuente1.png" id="imgFuente"> -->
                        </div>
                        <div class="card-body" id="mdetalleDesc">
                          <h5><span id="detalleDesc"></span></h5>
                        </div>
                    </div>
                </div>
            </div>

            <div id="resumen" class="col-md-4">
                <div class="card card-outline-success">
                    <div class="borde box-resume">
                        <div class="card-header">
                            <span class="m-b-0 text-white">RESUMEN DE SELECCIÓN : </span>
                            <div id="cerrar" style="z-index: 999" type="button" onclick="window.close();"><a href="#"><span class="btn-close">Cerrar X</span></a>
                            </div>
                            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                        </div>
                        <div class="card-body" id="resumenSeleccion">
                            <div class="table-responsive" style="max-height:240px;">
                                <table id="dataResumen" class="table table-sm table-hover" cellspacing="0" width="100%"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="detalle" class="col-md-4" >
                <div class="card card-outline-success">
                    <div class="borde box-resume">
                        <div class="card-header">
                        <span class="m-b-0 text-white">RESUMEN GENERAL DEL TEMA :</span>
                        </div>
                        <div class="card-body" id="enunciado">
                            <h5>
                                <strong><span id="nombre"></span></strong> concentra
                                <strong><span id="cantidad"></span></strong>
                                <strong><span id="unidad"></span></strong> del total de 
                                <strong><span style="text-transform: lowercase;" id="variable"></span></strong> denunciados para el año
                                <strong><span id="anio20"></span></strong>.
                            </h5>
                        </div>
                    </div>
                </div>
            </div>    

            <div id="leyenda" class="card card-outline-success">
                <div class="card-header" id="tituloLeyenda">
                    <h5><strong><span id="encabezado"></span></strong></h5>
                </div>
                <div class="card-body  p-1" style="z-index: 9999; background-color: white">
                    <div class="card" id="print">
                        <div class="contLeyenda">
                            <div class="leyenda_1"></div> De <span id="leyenda_1_min">0</span> a <span id="leyenda_1_max">0</span> <span id="unidadMedida1"></span>
                        </div>
                        <div class="contLeyenda">
                            <div class="leyenda_2"></div> De <span id="leyenda_2_min">0</span> a <span id="leyenda_2_max">0</span> <span id="unidadMedida2"></span>
                        </div>
                        <div class="contLeyenda">
                            <div class="leyenda_3"></div> De <span id="leyenda_3_min">0</span> a <span id="leyenda_3_max">0</span> <span id="unidadMedida3"></span>
                        </div>
                        <div class="contLeyenda">
                            <div class="leyenda_4"></div> De <span id="leyenda_4_min">0</span> a <span id="leyenda_4_max">0</span> <span id="unidadMedida4"></span>
                        </div>
                        <div class="contLeyenda">
                            <div class="leyenda_5"></div> De <span id="leyenda_5_min">0</span> a <span id="leyenda_5_max">0</span> <span id="unidadMedida5"></span>
                        </div>                     
                    </div>
                    <div class="card"><span id="piepag"></span></div>   
                </div>
            </div>

            <div id="leyenda_bar" class="card card-outline-success">
                <div class="card-header" id="tituloLeyenda_bar">
                    <h5><strong><span id="encabezado_bar"></span></strong></h5>
                </div>
                <div class="card-body  p-1" style="z-index: 9999; background-color: white">
                    <div class="card" id="print_bar">
                        <div class="contLeyenda">
                            <div class="leyenda_pnp"></div> Policia Nacional
                        </div>
                        <div class="contLeyenda">
                            <div class="leyenda_se"></div> Serenazgo
                        </div>
                        <div class="contLeyenda">
                            <div class="leyenda_pi"></div> Patrullaje Integrado
                        </div>                   
                    </div>
                    <div class="card"><span id="piepag_bar"></span></div>   
                </div>
            </div>

            <div id="leyenda_pie" class="card card-outline-success">
                <div class="card-header" id="tituloLeyenda_pie">
                    <h5><strong><span id="encabezado_pie"></span></strong></h5>
                </div>
                <div class="card-body  p-1" style="z-index: 9999; background-color: white">
                    <div class="card" id="print_pie">
                        <div class="contLeyenda">
                            <div class="leyenda_ns"></div> Nada Satifecho
                        </div>
                        <div class="contLeyenda">
                            <div class="leyenda_pc"></div> Poco Satisfecho
                        </div>
                        <div class="contLeyenda">
                            <div class="leyenda_ne"></div> Neutral
                        </div>
                        <div class="contLeyenda">
                            <div class="leyenda_ms"></div> Muy Satisfecho
                        </div>
                        <div class="contLeyenda">
                            <div class="leyenda_ts"></div> Totalmente Satisfecho
                        </div>                     
                    </div>
                    <div class="card"><span id="piepag_pie"></span></div>   
                </div>
            </div>
        
            <div class="card" id="controlAnios">
            <div id="controlDespl"></div>
            </div>  

            <!-- cierra mapa -->
            </div> 
        </div> 

    </div>

</div>

<script src="assets/js/leaflet.js"></script>
<script src="assets/js/bundle.js"></script>
<script src="assets/js/mijs/map_api.js"></script>
<script src="assets/js/Leaflet.draw.js"></script>
<script src="assets/plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {
    $('#panel').show();  
	$('#muestra').hide();

	$('#muestra').on('click', function(event) {
        $('#panel').toggle('show');
    });

  $('#ocultar').on('click', function(event) {
        $('#panel').toggle('hide');
		$('#muestra').show();
    });

  $('#cerrar').on('click', function(event) {
    $('#resumen').hide();
    $('#detalle').hide();
    localStorage.setItem('arrayPuntos','');
    map_api.puntos = [];
    });
});

	preCarga = function() {

		function initProject() {
		map_api.init();
		//
		localStorage.removeItem('arrayAnios');
		localStorage.removeItem('arrayPuntos');
        localStorage.removeItem('arrayGraficos');
            $('#leyenda').hide();
            $('#leyenda_bar').hide();
            $('#leyenda_pie').hide();
			$('#divIndicador').hide();
			$('#divNivel').hide();
			$('#divFiltrar').hide();
            $('#divDescargar').hide();
			$('#divObjeto').hide();
            $('#divOpcional').hide();
			$('#divFrecuencia').hide();
			$('#divPeriodo').hide();
            $('#divMostrar').hide();
			$('#descripcion').hide();
			$('#resumen').hide();
			$('#detalle').hide();
            $('#controlAnios').hide();
			$('#controlDespl').hide();
		}

		initProject();

		$(window).resize(function() {
			$('#mapa').css('width', '100%');
			$('#mapa').height($(window).height() - 30);
		});

		$(window).resize();

        // $(window).resize(function(){
        //   var ancho = $(window).width();
        //   if(ancho < 560){
        //     $("#btnmodalvideo").html('<img src="assets/images/Youtuben.png">');

        //   }else{
        //     $("#btnmodalvideo").html('<img src="assets/images/Youtuben.png">Video Tutoriales');
        // }
        //   });

    //CHECKBOX Y FILTROS

    $('#ckbDepartamento').change(function() {
      if (!$(this).prop('checked')) {
        map_api.mapaDepartamento.remove();
        map_api.clearEtiquetasDepartamento();
      } else {
        map_api.get_departamento();          
      }       
    });

    $('#ckbProvincia').change(function() {
      if (!$(this).prop('checked')) {
        map_api.mapaProvincia.remove();
        map_api.clearEtiquetasProvincia();
      } else {
        map_api.get_provincia();          
      }       
    });

    $('#ckbDistrito').change(function() {
      if (!$(this).prop('checked')) {
        map_api.mapaDistrito.remove();
        map_api.clearEtiquetasDistrito();
      } else {
        map_api.get_distrito();          
      }       
    });

    $('#ckbComisaria').change(function() {
      if (!$(this).prop('checked')) {
        map_api.clearLayerComisarias();
      } else {
        map_api.get_comisarias();          
      }       
    });

    $('#ckbJurisdiccionCom').change(function() {
      if (!$(this).prop('checked')) {
        map_api.jurisdicciones_comisarias.remove();
      } else {
        map_api.get_jurisdicciones_comisarias();          
      }       
    });    

    $('#ckbJurisdiccionDiv').change(function() {
      if (!$(this).prop('checked')) {
        map_api.jurisdicciones_divpol.remove();
      } else {
        map_api.get_jurisdicciones_divpol();          
      }       
    });

    $('#ckbSector').change(function() {
      if (!$(this).prop('checked')) {
        map_api.clearLayerEtiquetas();
        map_api.sectores.remove();
      } else {
        map_api.get_sectores();          
      }       
    });

    $('#ckbBarrio').change(function() {
      if (!$(this).prop('checked')) {
        map_api.barrios.remove();
      } else {
        map_api.get_barrios();          
      }       
    });

    //BOTONES

    // $("#btnmodalvideo").click( function(){
    //     $('#modalVideo').modal('show');
    // });

    $("#btnlimpiar").click( function(){
      map_api.limpiarCapas();
    });
    
    $("#btnFiltrar").click( function(){
      map_api.filtrar();
      $('#divObjeto').show();
      $("#md_checkbox_21:checkbox").attr('checked',false);
    });

    $("#btnDescargar").click( function(){
      map_api.exportarReporte();
    });

    $("#btnFiltrar2").click( function(){
        map_api.filtrar2();
    });


	$("#controlDespl").on("slidestop", function(event, ui) {
		var anioseleccionado = ui.value;
		map_api.anio = anioseleccionado;
		//
		var arrayAniosActual = localStorage.getItem('arrayAnios');
        var arrayAnios = JSON.parse(arrayAniosActual);
		//
		var arrayAnios_seleccionado = arrayAnios.filter(function (el) {
			return (parseInt(el.anios) == parseInt(anioseleccionado));
		});
		//
		map_api.anio_id = arrayAnios_seleccionado[0].anios_id;
		//
		map_api.filtrar();
	});

	var screen = L.control.fullscreen({
		position: 'topleft', 
		title: {
		    'false': 'Ver Pantalla Completa',
		    'true': 'Salir de Pantalla Completa'
	    },
		content: null, 
		forceSeparateButton: true, 
		forcePseudoFullscreen: true, 
		fullscreenElement: false 
		}).addTo(map_api.map);

	var printer = L.easyPrint({
        position: 'topleft',
		title:'Descargar Mapa',
		tileLayer: null,
		sizeModes: ['A4Landscape', 'A4Portrait'],
		// sizeModes: ['Current', 'A4Landscape', 'A4Portrait'],
		defaultSizeTitles: {A4Landscape:'A4 Horizontal',A4Portrait:'A4 Vertical'},
		filename: 'Mapa',
		exportOnly: true,
		hideControlContainer: true
		}).addTo(map_api.map);

	var printer2 = L.easyPrint({
        position: 'topleft',
		title:'Imprimir Mapa',
		tileLayer: null,
		sizeModes: ['A4Landscape', 'A4Portrait'],
		defaultSizeTitles: {A4Landscape:'A4 Horizontal',A4Portrait:'A4 Vertical'},
		filename: 'Mapa',
		exportOnly: false,
		hideControlContainer: true
		}).addTo(map_api.map);

    var centrar = L.easyButton('<img src="assets/images/centrar.png">', function(btn, map){
    // var centrar = L.easyButton('<i class="fa fa-crosshairs">', function(btn, map){
        var centro = [-10,-74];
        map.setView(centro,5);
		}).addTo(map_api.map);

	// map_api.map.addControl(L.control.search());

    var drawnItems = new L.FeatureGroup();
    map_api.map.addLayer(drawnItems);

    var customMarker= L.Icon.extend({
        options: {
            shadowUrl: null,
            iconAnchor: new L.Point(12, 12),
            iconSize: new L.Point(24, 35),
            iconUrl: 'assets/images/marker-icon-2x.png'
        }
    });

    var drawControl = new L.Control.Draw({
        edit: {
            featureGroup: drawnItems,
            poly:{
                allowIntersection: false
            }
        },
        draw: {
            polygon:false,
            polyline:false,        
            marker: {
              icon: new customMarker() 
            }
        }
    });
    map_api.map.addControl(drawControl);

    map_api.map.on('draw:created', function(e) {
      var type = e.layerType,
        layer = e.layer;
      drawnItems.addLayer(layer);
    });

    // map_api.map.on('draw:stop', function (e) {
    //      var layers = e.layers;
    //      layers.eachLayer(function (layer) {
    //          //do whatever you want; most likely save back to db
    //      });
    //  });

    // map_api.map.on('draw:editstart', function() {
    //   console.log('edit start');
    // });

    // map_api.map.on('draw:editstop', function() {
    //   console.log('edit stop');
    // });



	    $('#cbxBD').change(function() {
			limpiarForm();
			map_api.mostrarDescripcion($(this).val());
			map_api.get_indicadores($(this).val());
			//map_api.get_anio($(this).val());
			//
			var id = parseInt($(this).val());
			// 
			$("#tituloDesc").html('');
            //
            if(id == 1){
				$('#divNivel, #divObjeto, #divOpcional, #divFrecuencia, #divPeriodo').hide();
				$('#divIndicador, #descripcion').show();
			}else if(id == 2){
				$('#divNivel, #divObjeto, #divOpcional, #divFrecuencia, #divPeriodo').hide();
				$('#divIndicador, #descripcion').show();
			}else if(id == 3){
				$('#divNivel, #divObjeto, #divOpcional, #divFrecuencia, #divPeriodo').hide();
				$('#divIndicador, #descripcion').show();
			}else if(id == 4){
				$('#divNivel, #divObjeto, #divOpcional, #divFrecuencia, #divPeriodo').hide();
				$('#divIndicador, #descripcion').show();
			}else if(id == 5){
				$('#divNivel, #divObjeto, #divOpcional, #divFrecuencia, #divPeriodo').hide();
				$('#divIndicador, #descripcion').show();
			}else if(id == 6){
				$('#divNivel, #divObjeto, #divOpcional, #divFrecuencia, #divPeriodo').hide();
				$('#divIndicador, #descripcion').show();
			}else if(id == 7){
				$('#divNivel, #divObjeto, #divOpcional, #divFrecuencia, #divPeriodo').hide();
				$('#divIndicador, #descripcion').show();
			}else if(id == 8){
				$('#divNivel, #divObjeto, #divOpcional, #divFrecuencia, #divPeriodo').hide();
				$('#divIndicador, #descripcion').show();
			}else if(id == 0){
				//Limpiamos los resultados del subtema				
				$('#divIndicador').hide();
				$('#divNivel').hide();
                $('#divOpcional').hide();
				$('#divFrecuencia').hide();
                $('#divPeriodo').hide();
                $('#divObjeto').hide();
				$("#cbxIndicador").html('<option value="0">-- Seleccione Variable --</option>');
				$("#cbxNivel").html('<option value="0">-- Seleccione Nivel de Representación --</option>');
				$("#cbxFrecuencia").html('<option value="0">-- Seleccione Frecuencia --</option>');
                $("#cbxPeriodo").html('<option value="0">-- Seleccione Periodo Movil --</option>');
				$("#cbxObjeto").html('');
				$(".selectpicker").selectpicker('refresh');
                $('#descripcion').hide();
				$('#resumen').hide();
				$('#detalle').hide();
			}
			//
            $('#divFiltrar').hide();
            $('#divDescargar').hide();
            $('#divOpcional').hide();
			$('#divFrecuencia').hide()
			$("#cbxIndicador").html('<option value="0">-- Seleccione Variable --</option>');
			$("#cbxNivel").html('<option value="0">-- Seleccione Nivel de Representación --</option>');
			$("#cbxFrecuencia").html('<option value="0">-- Seleccione Frecuencia --</option>');
            $("#cbxPeriodo").html('<option value="0">-- Seleccione Periodo Movil --</option>');
			$("#cbxObjeto").html('');
			$(".selectpicker").selectpicker('refresh');
			$('#resumen').hide();
			$('#detalle').hide();
		});

	    $('#cbxIndicador').change(function() {
			$iddb = $("#cbxBD").val();
			$idindicador = $("#cbxIndicador").val();
			//
			if($idindicador > 0){
				map_api.get_nivel($iddb, $idindicador);
				$('#divNivel').show();
			}else{
                $('#divNivel').hide();
                $('#divOpcional').hide();
				$('#divFrecuencia').hide();
                $('#divObjeto').hide();
                $('#divPeriodo').hide();
				$("#cbxObjeto").html('');
				$("#cbxNivel").html('<option value="0">-- Seleccione Nivel de Representación --</option>');
				$("#cbxFrecuencia").html('<option value="0">-- Seleccione Frecuencia --</option>');
                $("#cbxPeriodo").html('<option value="0">-- Seleccione Periodo Movil --</option>');
				$('#descripcion').hide();
			}
            $('#divFiltrar').hide();
            $('#divDescargar').hide();
            $('#divOpcional').hide();
			$('#divFrecuencia').hide();
            $('#divPeriodo').hide();
            $('#divObjeto').hide();
			$('#descripcion').hide();
			$('#resumen').hide();
			$('#detalle').hide();
			//
			$("#cbxObjeto").html('');
			//
			$(".selectpicker").selectpicker('refresh');
		});   

		$('#cbxNivel').change(function() {
			$iddb = $("#cbxBD").val();
			$idindicador = $("#cbxIndicador").val(); 
			$idnivel = $("#cbxNivel").val(); 
			//
			if($idnivel > 0){
				map_api.get_frecuencia($iddb, $idindicador,$idnivel);
                map_api.get_anio($iddb, $idindicador,$idnivel, function(){
                  map_api.filtrar();
                  $('#divObjeto').show();
                  $("#md_checkbox_21:checkbox").attr('checked',false);
                  $('#divFiltrar').show();
                  $('#divDescargar').show();
                });
                // $('#divFiltrar').show();                
			}
			 else{                                
                $('#divFiltrar').hide();
                $('#divDescargar').hide();
                $('#divOpcional').hide();
			 	$("#cbxFrecuencia").html('<option value="0">-- Seleccione Frecuencia --</option>');
			 	$('#divFrecuencia').hide();	
			 	$("#cbxPeriodo").html('<option value="0">-- Seleccione Periodo Movil --</option>');		 	
			 	$('#divPeriodo').hide();
				$("#cbxObjeto").html('');
				$('#detalle').hide();
			}
            $('#divOpcional').hide();
            $('#divFrecuencia').hide();
            $('#divPeriodo').hide();
            $('#divMostrar').hide();
			$('#detalle').hide();
			$('#resumen').hide();
			$('#detalle').hide();
			//
			$('#divObjeto').hide();
			//
			$("#cbxObjeto").html('');
			//
			$(".selectpicker").selectpicker('refresh');
			//
            if($iddb ==6){
                $('#controlAnios').hide();
                $('#controlDespl').hide();
            }else{
                $('#controlAnios').show(); 
                $('#controlDespl').show();
            }
			
		}); 

		$('#cbxFrecuencia').change(function(){

			// var id = parseInt($(this).val());
			$iddb = $("#cbxBD").val();
			$idindicador = $("#cbxIndicador").val(); 
			$idnivel = $("#cbxNivel").val(); 
			$frecuencia_periodo = $('#cbxFrecuencia').val();
			//
			if($frecuencia_periodo > 0){
				map_api.get_periodo($iddb,$idindicador,$idnivel,$frecuencia_periodo);
				$('#divPeriodo').show();
			}
			 else{
                $('#divMostrar').hide();
				$("#cbxObjeto").html('');
                $('#divPeriodo').hide();
				$("#cbxPeriodo").html('<option value="0">-- Seleccione --</option>');
				$('#detalle').hide();
			}
			//
            $('#divMostrar').hide();
			$('#detalle').hide();
			$('#resumen').hide();
			$('#detalle').hide();
			//
			// $("#cbxObjeto").html('');
			//
			$(".selectpicker").selectpicker('refresh'); 
		});


		$('#cbxPeriodo').change(function(){
			$iddb = $("#cbxBD").val();
			$idindicador = $("#cbxIndicador").val(); 
			$idnivel = $("#cbxNivel").val(); 
			$frecuencia_periodo = $("#cbxFrecuencia").val(); 
			//
            if($frecuencia_periodo > 0){
                // map_api.get_valores_periodo($iddb,$idindicador,$idnivel,$frecuencia_periodo);
                $('#divMostrar').show();
            }else{
                $('#divMostrar').hide();                
            }
            //
			$('#detalle').hide();
			$('#resumen').hide();
			$('#detalle').hide();
			//
			// $("#cbxObjeto").html('');
			//
			$(".selectpicker").selectpicker('refresh'); 
		});

        $("#md_checkbox_21").on( 'change', function() {

            if(!$(this).is(':checked') ) {

                $('#divFiltrar').show();
                $('#divDescargar').show();
                map_api.limpiar2();

            }else if( $(this).is(':checked') ) {

                $iddb = $("#cbxBD").val();
                $idindicador = $("#cbxIndicador").val(); 
                $idnivel = $("#cbxNivel").val(); 
                map_api.get_frecuencia($iddb, $idindicador,$idnivel);

                $('#divFiltrar').hide();
                $('#divDescargar').hide();
                $('#divFrecuencia').show();
            } 

        });

        $('body').off('click', '#btnGenerarReporte').on('click','#btnGenerarReporte',function(event){
                event.preventDefault();
                var valorSeleccionado = $('#cbxNivel').val();
                if(valorSeleccionado!=''){
                    map_api.exportarReporte();
                } else {
                    VisorJS.msj.error('Mensaje','Debe seleccionar un Nivel para descargar el reporte');
                }
            });


		function limpiarForm(){
      $('#leyenda').hide();
      $('#leyenda_bar').hide();
      $('#leyenda_pie').hide();
			$('#cbxIndicador').val('0');
			$('#cbxNivel').val('0');
			$('#cbxObjeto').val('');
			$('#cbxFrecuencia').val('0');
			$('#cbxPeriodo').val('0');
			$(".selectpicker").selectpicker('refresh');
		}



}
</script>
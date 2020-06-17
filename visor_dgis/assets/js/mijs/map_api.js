'use strict'

var map_api = {

    map: null,
    iniLatitud: -10.0,
    iniLongitud: -74.0,
    iniZoom: 5,
    markers: [],
    imarkers: [],
    arreglo: [],
    layer_ubigeo : null,
    layerGroup : null,
    mapa_peru: null,
    mapa_comisarias: null,
    mapMarkers: [],
    mapEtiquetas: [],
    mapEtiquetasPeru: [],
    mapEtiquetasDepartamento: [],
    mapEtiquetasProvincia: [],
    mapEtiquetasDistrito: [],


    init: function () {

        // this.map = L.map('mapa').setView([map_api.iniLatitud, map_api.iniLongitud], map_api.iniZoom);
        this.map = L.map('mapa',{
            center: [-10, -74],
            // zoomDelta: 0.25,
            // zoomSnap:0.5,
            zoom: 5,
            minZoom: 5,
            maxZoom: 18 
        });

        map_api.get_departamento();

        var osmLayer = L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        zIndex:1
        }).addTo(this.map);
        this.map.createPane('panelOsm');
        this.map.getPane('panelOsm').style.zIndex = 650;
        this.map.getPane('panelOsm').style.pointerEvents = 'none';

        var mGray = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png', {
        zIndex:2
        }).addTo(this.map);
        this.map.createPane('panelGray');
        this.map.getPane('panelGray').style.zIndex = 650;
        this.map.getPane('panelGray').style.pointerEvents = 'none';

        var mCartoon = L.tileLayer('https://a.tiles.mapbox.com/v4/mapbox.light/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NDg1bDA1cjYzM280NHJ5NzlvNDMifQ.d6e-nNyBDtmQCVwVNivz7A', {
        zIndex:3
        }).addTo(this.map);
        this.map.createPane('panelCartoon');
        this.map.getPane('panelCartoon').style.zIndex = 650;
        this.map.getPane('panelCartoon').style.pointerEvents = 'none';

        var mSatelite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        zIndex:4
        }).addTo(this.map);
        this.map.createPane('panelSatelite');
        this.map.getPane('panelSatelite').style.zIndex = 650;
        this.map.getPane('panelSatelite').style.pointerEvents = 'none';

        var baseMaps = {
            "OSM": osmLayer,
            "Gray": mGray,
            "Cartoon": mCartoon,
            "Satelite": mSatelite
        };

        map_api.map.addControl(L.control.layers(baseMaps));

        this.map.on('zoomend', function () {
            map_api.map.invalidateSize();
        });

        this.map.on('dragend', function (e) {
            map_api.map.invalidateSize();
        });
    },

    limpiarCapas: function (layer) {
    // map_api.get_peru();
    map_api.get_departamento();
    // 
    if( map_api.layer_ubigeo != null){
        map_api.layer_ubigeo.remove();
        map_api.clearLayerEtiquetasPeru();
    }

    if(map_api.mapaDepartamento != null){
        map_api.mapaDepartamento.remove();
        map_api.clearEtiquetasDepartamento();
    }

    if(map_api.mapaProvincia != null){
        map_api.mapaProvincia.remove();
        map_api.clearEtiquetasProvincia();
    }

    if(map_api.mapaDistrito != null){
        map_api.mapaDistrito.remove();
        map_api.clearEtiquetasDistrito();
    }
    map_api.delete();

    if(map_api.limites != null){
        map_api.limites.remove();
    }

    if(map_api.mapMarkers.length != null){
       map_api.clearLayerComisarias(); 
    }

    if(map_api.jurisdicciones_comisarias != null){
        map_api.jurisdicciones_comisarias.remove();
    }

    if(map_api.jurisdicciones_divpol != null){
        map_api.jurisdicciones_divpol.remove();
    }

    if(map_api.sectores != null){
        map_api.sectores.remove();
        map_api.clearLayerEtiquetas();
    }

    if(map_api.barrios != null){
        map_api.barrios.remove();
    }
    
    localStorage.removeItem('arrayAnios');
    localStorage.removeItem('arrayPuntos');
    localStorage.removeItem('arrayGraficos');
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
    $('#leyenda').hide();
    $('#leyenda_bar').hide();
    $('#leyenda_pie').hide();
    $("#ckbDepartamento").prop('checked',true);
    $('#ckbProvincia').prop("checked", false);
    $('#ckbDistrito').prop("checked", false);
    $('#ckbComisaria').prop("checked", false);
    $('#ckbJurisdiccionCom').prop("checked", false);
    $('#ckbJurisdiccionDiv').prop("checked", false);
    $('#ckbJurisdiccionDiv').prop("checked", false);
    $('#ckbSector').prop("checked", false);
    $('#ckbBarrio').prop("checked", false);
    $('#cbxBD').val('0');
    $(".selectpicker").selectpicker('refresh');
    },

    get_peru: function(){

        $.getJSON('main/json_peru', function(data) {

            if(data){
                if(data.peru){ var objPeru = JSON.parse(data.peru);}
                if(objPeru.totalFeatures > 0){
                    map_api.mapa_peru = L.geoJson(objPeru,{

                        style: function(feature){
                            return{
                              color: '#e3c012',
                              weight: '1',
                              fillOpacity: '0'
                            }
                        }
                    }).addTo(map_api.map);
                    map_api.mapa_peru.bringToBack();
                }
            }
        });
    },

    get_limites:function(){
        map_api.map.on('zoomend',function(){
            if(map_api.map.getZoom()<8){
                map_api.get_departamento();
                map_api.mapaProvincia.removeLayer();
                map_api.clearEtiquetasProvincia();
                map_api.mapaDistrito.removeLayer();
                map_api.clearEtiquetasDistrito();            
            }else if(map_api.map.getZoom()>=8 && map_api.map.getZoom()<=10){
                map_api.get_provincia();
                map_api.mapaDepartamento.removeLayer();
                map_api.clearEtiquetasDepartamento();
                map_api.mapaDistrito.removeLayer();
                map_api.clearEtiquetasDistrito();
            }else{
                map_api.get_distrito();
                map_api.mapaDepartamento.removeLayer();
                map_api.clearEtiquetasDepartamento();
                map_api.mapaProvincia.removeLayer();
                map_api.clearEtiquetasProvincia();
            }
        });
    },

    get_departamento: function(){

        $.getJSON('main/json_departamentos', function(data) {

            if(data){
                if(data.departamentos){ var objDepartamento = JSON.parse(data.departamentos);}
                if(objDepartamento.totalFeatures > 0){
                    map_api.mapaDepartamento = L.geoJson(objDepartamento,{

                        style: function(feature){
                            return{
                              color: '#990000',
                              weight: '3',
                              fillOpacity: '0'
                            }
                        },
                        onEachFeature: function(feature, layer) {
                            var labelDepartamentos = "<center><b>" + feature.properties.nombdep + "</b></center>";
                            
                            var etiquetasDepartamentos = L.marker(layer.getBounds().getCenter(), {
                            icon: L.divIcon({
                                className: 'etiquetasDepartamentos',
                                html: labelDepartamentos,
                                iconSize: [100, 30],
                                // iconAnchor: [50,20]
                                })
                            });
                                etiquetasDepartamentos.addTo(map_api.map);
                                map_api.mapEtiquetasDepartamento.push(etiquetasDepartamentos);
                        }
                    }).addTo(map_api.map);
                    map_api.mapaDepartamento.bringToFront();
                }
            }
        });
    },

    clearEtiquetasDepartamento: function(){
        for(var i = 0; i < map_api.mapEtiquetasDepartamento.length; i++){
        map_api.map.removeLayer(map_api.mapEtiquetasDepartamento[i]);
        }
    },

    get_provincia: function(){

        $.getJSON('main/json_provincias', function(data) {

            if(data){
                if(data.provincias){ var objProvincia = JSON.parse(data.provincias);}
                if(objProvincia.totalFeatures > 0){
                    map_api.mapaProvincia = L.geoJson(objProvincia,{

                        style: function(feature){
                            return{
                              color: '#663300',
                              weight: '2',
                              fillOpacity: '0'
                            }
                        },
                        onEachFeature: function(feature, layer) {
                            var labelProvincias = "<center><b>" + feature.properties.nombprov + "</b></center>";
                            
                            layer.bindTooltip(labelProvincias, {
                                offset: L.point(0, -20)
                            });
                        } 
                    }).addTo(map_api.map);
                    map_api.mapaProvincia.bringToFront();
                }
            }
        });
    },

    clearEtiquetasProvincia: function(){
        for(var i = 0; i < map_api.mapEtiquetasProvincia.length; i++){
        map_api.map.removeLayer(map_api.mapEtiquetasProvincia[i]);
        }
    },

    get_distrito: function(){

        $.getJSON('main/json_distritos', function(data) {

            if(data){
                if(data.distritos){ var objDistrito = JSON.parse(data.distritos);}
                if(objDistrito.totalFeatures > 0){
                    map_api.mapaDistrito = L.geoJson(objDistrito,{

                        style: function(feature){
                            return{
                              color: '#CC9900',
                              weight: '1',
                              fillOpacity: '0'
                            }
                        },
                        onEachFeature: function(feature, layer) {
                            var labelDistritos = "<center><b>" + feature.properties.nombdist + "</b></center>";
                            
                            layer.bindTooltip(labelDistritos, {
                                offset: L.point(0, -20)
                            });
                            } 
                    }).addTo(map_api.map);
                    map_api.mapaDistrito.bringToFront();
                }
            }
        });
    },

    clearEtiquetasDistrito: function(){
        for(var i = 0; i < map_api.mapEtiquetasDistrito.length; i++){
        map_api.map.removeLayer(map_api.mapEtiquetasDistrito[i]);
        }
    },

    mapLimites: [],
    get_limites_: function(){

        var limites = L.esri.dynamicMapLayer({
        // url: "http://192.168.50.165/geoservicios/rest/services/Demarcacion_Territorial/MapServer/",
        url: "https://www.idep.gob.pe/geoportal/rest/services/DATOS_GEOESPACIALES/LsÍMITES/MapServer/",
        // url: "https://www.idep.gob.pe/geoportal/rest/services/DATOS_GEOESPACIALES/LÍMITES/MapServer/dynamicLayer",
        style: function () {
          return { color: "#e3c012", weight: 1 };
        }
      }).addTo(map_api.map);
        map_api.mapLimites.push(limites);
    },

    get_limites_1: function(){

        var url="http://geoservicios_des.mininter.gob.pe:8080/geoserver/BDIDEMI/wms"

        var limites =  L.tileLayer.wms(url,{
            service:'WMS',
            request:'GetMap',
            layers:'BDIDEMI:dgis_limites_administrativos',
            version:'1.1.0',
            styles:'',
            transparent: true,
            srs:'EPSG:4326',
            format:'image/png',
            zIndex: 5,
            // serverType: 'geoserver',
            // crossOrigin: 'anonymous'
        }).addTo(map_api.map);
        map_api.map.createPane('panelLimites');
        map_api.map.getPane('panelLimites').style.zIndex = 650;
        map_api.map.getPane('panelLimites').style.pointerEvents = 'none';
        map_api.mapLimites.push(limites);
    },

    get_limites_2: function(){
        $.get('main/geo_limites',function($ruta){

            var url = $ruta;
            console.log(url);

            // var limites = L.TileLayer.WMS({
            // getTileUrl: function(coords) {            
            // var i = Math.ceil( Math.random() * 4 );
            // return url + i;
            // }
            // }).addTo(map_api.map);

            var limites =  L.tileLayer.wms(url,{
            service:'WMS',
            request:'GetMap',
            layers:'BDIDEMI:dgis_limites_administrativos',
            version:'1.1.0',
            styles:'',
            transparent: true,
            srs:'EPSG:4326',
            format:'image/png',
            zIndex: 5,
            // serverType: 'geoserver',
            // crossOrigin: 'anonymous'
        }).addTo(map_api.map);
        });
    },

    clearLimites: function(){
        for(var i = 0; i < map_api.mapLimites.length; i++){
        map_api.map.removeLayer(map_api.mapLimites[i]);
        }
    },

    clearDepartamentos: function(){
        for(var i = 0; i < map_api.mapaDepartamento.length; i++){
        map_api.map.removeLayer(map_api.mapaDepartamento[i]);
        }
    },

    clearProvincias: function(){
        for(var i = 0; i < map_api.mapaProvincia.length; i++){
        map_api.map.removeLayer(map_api.mapaProvincia[i]);
        }
    },

    clearDistritos: function(){
        for(var i = 0; i < map_api.mapaDistrito.length; i++){
        map_api.map.removeLayer(map_api.mapaDistrito[i]);
        }
    },

    clearLayerLimites: function(){
        for(var i = 0; i < map_api.mapLimites.length; i++){
        map_api.map.removeLayer(map_api.mapLimites[i]);
        }
    },

    get_comisarias: function(){
        $.getJSON('main/json_comisarias', function(data) {

            if(data){
                console.log(data.comisarias);
                if(data.comisarias){ 
                    var objComisarias = JSON.parse(data.comisarias);

                    var mcg = L.markerClusterGroup({
                      chunkedLoading: true,
                      singleMarkerMode: false,
                      spiderfyOnMaxZoom: false,
                      //Ver los limites de los iconos
                      showCoverageOnHover:false,
                      //Radio max de agupamiento
                      maxClusterRadius: 20, 
                      // A partir del nivel 10 de zoom se deshabilita el agrupamiento
                      disableClusteringAtZoom: 10,
                    });                
            
                $.each(objComisarias.features, function(idx,obj){

                    var tooltipText = "<center><b>" + obj.properties.comisaria + "</b></center>" +
                            "<b>Tipo de comisaría :</b> " + obj.properties.tipo;
                    
                    //construccion de tooltip
                    var popupText = "<center><b> " + obj.properties.comisaria + "</b></center>" +                                
                        "<b><b>Departamento:</b> "  + obj.properties.nombredd +                         
                        "<br><b>Provincia:</b> " + obj.properties.nombrepp +
                        "<br><b>Distrito:</b> " + obj.properties.nombredi +
                        "<br><b>Dirección:</b> " + obj.properties.tipovia + " " + obj.properties.nombrevia + " " + obj.properties.numpuerta +
                        "<hr><b>Macroregión Policial:</b> " + obj.properties.macregpol_ +
                        "<br><b>Región Policial:</b> " + obj.properties.regpol +
                        "<br><b>División Policial:</b> " + obj.properties.divpol_div;

                    var marker = L.marker(new L.LatLng(obj.geometry.coordinates[1], obj.geometry.coordinates[0]), { title: obj.properties.comisaria });
                    
                    marker.bindTooltip(tooltipText);

                    marker.bindPopup(popupText, {
                        closeButton: true,
                        offset: L.point(0, -20)
                    });

                    marker.on('mouseover', function (e) {
                        this.bindTooltip();
                    });

                    marker.on('mouseout', function (e) {
                        this.bindTooltip();
                    });
                    // marker.bindPopup(obj.properties.comisaria);
                    mcg.addLayer(marker);  
                });
                    map_api.map.addLayer(mcg);
                    map_api.mapMarkers.push(mcg);
                }
            }
        });
    },

    clearLayerComisarias: function(){
        for(var i = 0; i < map_api.mapMarkers.length; i++){
        map_api.map.removeLayer(map_api.mapMarkers[i]);
        }
    },

    get_jurisdicciones_comisarias: function(){

        $.getJSON('main/json_jurisdicciones_comisarias', function(data) {

            if(data){
                if(data.jcomisaria){ var objJComisarias = JSON.parse(data.jcomisaria);}
                // console.log(jcomisarias);
                if(objJComisarias.totalFeatures > 0){
                    map_api.jurisdicciones_comisarias = L.geoJson(objJComisarias,{

                        style: function(feature){
                            return{
                              color: '#6811ce',
                              weight: '3',
                              fillOpacity: '0'
                            }
                        },
                        onEachFeature: function(feature, layer) {
                            var tooltipText = "<center><b>Jurisdicción : " + feature.properties.comisaria + "</b></center>"+
                            "<center><b>DIVPOL : " + feature.properties.divter + "</b></center>";

                            layer.bindTooltip(tooltipText, {
                                offset: L.point(0, -20)
                            });
                        }
                    }).addTo(map_api.map);
                    map_api.jurisdicciones_comisarias.bringToFront();
                }
            }
        });
    },

    get_jurisdicciones_divpol: function(){

        $.getJSON('main/json_jurisdicciones_divpol', function(data) {

            if(data){
                if(data.jdivpol){ var objJDivpol = JSON.parse(data.jdivpol);}
                if(objJDivpol.totalFeatures > 0){
                    map_api.jurisdicciones_divpol = L.geoJson(objJDivpol,{

                        style: function(feature){
                            return{
                              color: '#11B261',
                              weight: '4',
                              fillOpacity: '0'
                            }
                        },
                        onEachFeature: function(feature, layer) {
                            var tooltipText = "<center><b>DIVPOL : " + feature.properties.divter + "</b></center>";

                            layer.bindTooltip(tooltipText, {
                                offset: L.point(0, -20)
                            });
                        }
                    }).addTo(map_api.map);
                    map_api.jurisdicciones_divpol.bringToFront();
                }
            }
        });
    },

    get_sectores: function(){

        $.getJSON('main/json_sectores', function(data) {

            if(data){
                if(data.sectores){ var objSectores = JSON.parse(data.sectores);}
                if(objSectores.totalFeatures > 0){
                    map_api.sectores = L.geoJson(objSectores,{

                        style: function(feature){
                            return{
                              color: '#EAE30D',
                              weight: '2',
                              fillOpacity: '0'
                            }
                        },

                        onEachFeature: function(feature, layer) {
                            var tooltipText = "<center><b>Sector : " + feature.properties.sector + "</b></center>"+
                            "<center><b>" + feature.properties.comisaria + "</b></center>";

                            layer.bindTooltip(tooltipText, {
                                offset: L.point(0, -20)
                            });

                            var etiquetaSector = L.marker(layer.getBounds().getCenter(), {
                            icon: L.divIcon({
                                className: 'etiquetaSector',
                                html: feature.properties.sector,
                                iconSize: [0, 0]
                                })
                            });
                            etiquetaSector.addTo(map_api.map);
                            map_api.mapEtiquetas.push(etiquetaSector);
                        },
                    }).addTo(map_api.map);
                    map_api.sectores.bringToFront();
                }
            }
        });
    },

    clearLayerEtiquetas: function(){
        for(var i = 0; i < map_api.mapEtiquetas.length; i++){
        map_api.map.removeLayer(map_api.mapEtiquetas[i]);
        }
    },

    get_barrios: function(){

        $.getJSON('main/json_barrioSeguro', function(data) {
            if(data){
                if(data.barrio){ var objBarrios = JSON.parse(data.barrio);}
                if(objBarrios.totalFeatures > 0){
                    map_api.barrios = L.geoJson(objBarrios,{

                        style: function(feature){
                            return{
                              color: '#33B5FF',
                              weight: '3',
                              fillOpacity: '0'
                            }
                        },
                        onEachFeature: function(feature, layer) {
                            var tooltipText = "<center><b>" + feature.properties.bs_nombre + "</b></center>";

                            layer.bindTooltip(tooltipText, {
                                offset: L.point(0, -20)
                            });
                        }
                    }).addTo(map_api.map);
                    map_api.barrios.bringToFront();
                }
            }
        });
    },

    get_tema: function (iddb) {
        //Recibo el valor de la base de datos "iddb"  
        var seleccion = {};
        seleccion.id = iddb;

        if (iddb > 0) {
            $.post('main/get_tema', seleccion, function (data) {
                $("#cbxBD").html('<option value="0"></option>');
                $("#cbxIndicador").html('<option value="0">-- Seleccione Variable --</option>');
                $("#cbxNivel").html('<option value="0">-- Seleccione Nivel de Representación --</option>');
                $("#cbxFrecuencia").html('<option value="0">-- Seleccione Frecuencia --</option>');
                $("#cbxPeriodo").html('<option value="0">-- Seleccione Periodo Movil --</option>');
                $.each(data.tema, function (index, obj) {
                    $("#cbxBD").append('<option value="' + obj.id_fuente + '">' + obj.descrip_bd + '</option>');
                });
				//
		        $(".selectpicker").selectpicker('refresh');
            });
        } else {
            $("#cbxBD").html('<option value="0"></option>');
            $("#cbxIndicador").html('<option value="0">-- Seleccione Variable --</option>');
            $("#cbxNivel").html('<option value="0">-- Seleccione Nivel de Representación --</option>');
            $("#cbxFrecuencia").html('<option value="0">-- Seleccione Frecuencia --</option>');
            $("#cbxPeriodo").html('<option value="0">-- Seleccione Periodo Movil --</option>');

        }
    },

    get_indicadores: function (iddb) {
        //Recibo el valor de la base de datos  "iddb"  
        var variable = {};
        variable.id = iddb;

        if (iddb > 0) {
            $.post('main/get_indicadores', variable, function (data) {
                $("#cbxIndicador").html('<option value="0">-- Seleccione Variable --</option>');
                $("#cbxNivel").html('<option value="0">-- Seleccione Nivel de Representación --</option>');
                $("#cbxFrecuencia").html('<option value="0">-- Seleccione Frecuencia --</option>');
                $("#cbxPeriodo").html('<option value="0">-- Seleccione Periodo Movil --</option>');
                $.each(data.indicadores, function (index, obj) {
                    $("#cbxIndicador").append('<option value="' + obj.id_variable + '">' + obj.nomb_variable + '</option>');
                });
				//
		        $(".selectpicker").selectpicker('refresh');
            });
        } else {
                $("#cbxIndicador").html('<option value="0">-- Seleccione Variable --</option>');
                $("#cbxNivel").html('<option value="0">-- Seleccione Nivel de Representación --</option>');
                $("#cbxFrecuencia").html('<option value="0">-- Seleccione Frecuencia --</option>');
                $("#cbxPeriodo").html('<option value="0">-- Seleccione Periodo Movil --</option>');
        }
    },

    get_nivel: function (iddb,idsubtema) {
        //Recibo los valores de la base de datos "iddb y idsubtema"  
        var filtro = {};
        filtro.id = iddb;
        filtro.id_ind = idsubtema;

        if (iddb > 0) {
            $.post('main/get_nivel', filtro, function (data) {
                $("#cbxNivel").html('<option value="0">-- Seleccione Nivel de Representación --</option>');
                $("#cbxFrecuencia").html('<option value="0">-- Seleccione Frecuencia --</option>');
                $("#cbxPeriodo").html('<option value="0">-- Seleccione Periodo Movil --</option>');
                $.each(data.nivel, function (index, obj) {
                    $("#cbxNivel").append('<option value="' + obj.id_nivel + '">' + obj.nomb_nivel + '</option>');
                });
				//
		        $(".selectpicker").selectpicker('refresh');
            });
        } else {
            $("#cbxNivel").html('<option value="0">-- Seleccione Nivel de Representación --</option>');
            $("#cbxFrecuencia").html('<option value="0">-- Seleccione Frecuencia --</option>');
            $("#cbxPeriodo").html('<option value="0">-- Seleccione Periodo Movil --</option>');
        }
    },

    anios: [],
    anios_id: [],
    anio : '',
    anio_id: '',

    get_anio: function (iddb, idsubtema,idnivel, callback) { 
        var filtro = {};
        filtro.id = iddb;
        filtro.id_ind = idsubtema;
        filtro.id_nivel = idnivel;

        if (iddb > 0) {
            $.post('main/get_anio', filtro, function (data) {
                $("#cbxAnio").html('<option value="0">-- Seleccione --</option>');
                map_api.anios = [];
                var arrayAnios = new Array();
                $.each(data.anio, function (index, obj) {
                    $("#cbxAnio").append('<option value="' + obj.id_anio + '">' + obj.anio + '</option>');
                    map_api.anios.push(parseInt(obj.anio));
                    map_api.anios_id.push(parseInt(obj.id_anio));
                    var objAnios = {'anios':parseInt(obj.anio),'anios_id':parseInt(obj.id_anio)};
                    arrayAnios.push(objAnios);
                });
                localStorage.setItem('arrayAnios', JSON.stringify(arrayAnios));
                // $("#controlDespl").slider("destroy");
                map_api.set_slider(map_api.anios[0], map_api.anios[map_api.anios.length - 1]);
                //map_api.anio = map_api.anios[0];
                map_api.anio = map_api.anios[map_api.anios.length - 1];
                map_api.anio_id = map_api.anios_id[map_api.anios_id.length - 1];
                //
                $(".selectpicker").selectpicker('refresh');
                //
                map_api.get_objeto(iddb, idsubtema, idnivel, map_api.anio_id);
                map_api.get_periodo(iddb, idsubtema, idnivel, map_api.anio_id);

                 if(callback){
                    callback();
                }
            });
        } else {
            $("#cbxAnio").html('<option value="0">-- Seleccione --</option>');
        }
    },

    get_frecuencia: function (iddb,idsubtema,idnivel) {
        //Recibo el valor de la base de datos  "iddb, idsubtema, idnivel"  
        var frecuencia = {};
        frecuencia.id = iddb;
        frecuencia.id_ind = idsubtema;
        frecuencia.id_nivel = idnivel;

        if (iddb > 0) {
            $.post('main/get_frecuencia', frecuencia, function (data) {
                $("#cbxFrecuencia").html('<option value="0">-- Seleccione Frecuencia --</option>');
                $("#cbxPeriodo").html('<option value="0">-- Seleccione Periodo Movil --</option>');
                $.each(data.frecuencia, function (index, obj) {
                    
                    $("#cbxFrecuencia").append('<option value="' + obj.frecuencia_periodo + '">' + obj.nomb_frecuencia + '</option>');
                });
				//
		        $(".selectpicker").selectpicker('refresh');
            });
        } else {
            $("#cbxFrecuencia").html('<option value="0">-- Seleccione Frecuencia --</option>');
            $("#cbxPeriodo").html('<option value="0">-- Seleccione Periodo Movil --</option>');
        }
    },

    get_periodo: function(iddb,idsubtema,idnivel,frecuencia_periodo,idanio){
    	var periodo = {};
    	periodo.id = iddb;
    	periodo.id_ind = idsubtema;
    	periodo.id_nivel = idnivel;
    	periodo.frec_pe  = frecuencia_periodo;
        periodo.id_anio = map_api.anio_id;

    	if(iddb > 0){
    		$.post('main/get_periodo',periodo,function(data){

    			$("#cbxPeriodo").html('<option value = "0">-- Seleccione Periodo Movil --</option>');
    			$.each(data.periodo,function(index,obj){
    				$("#cbxPeriodo").append('<option value="' + obj.id_periodo + '">' + obj.nomb_periodo + '</option>');
    			});
    			$(".selectpicker").selectpicker('refresh');
    		});
    	} else {
    		$("#cbxPeriodo").html('<option value="0">-- Seleccione Periodo Movil --</option>');
    	}
    },

    get_objeto: function (iddb,idsubtema,idnivel,idanio) { 
        var filtro = {};
        filtro.id = iddb;
        filtro.id_ind = idsubtema;
        filtro.id_niv = idnivel;
        filtro.id_anio = idanio;

        if (iddb > 0) {
            $.post('main/get_objeto', filtro, function (data) {
                $("#cbxObjeto").html('');
                $.each(data.objeto, function (index, obj) {
                    $("#cbxObjeto").append('<option value="' + obj.id_ubigeo + '">' + obj.nombre + '</option>');
                });
				//
		        $(".selectpicker").selectpicker('refresh');
            });
        } else {
            $("#cbxObjeto").html('');
        }
    },

    get_valores_escala: function (ubigeo, callback) { 
       
        var bd = $("#cbxBD").val();
        var ind = $("#cbxIndicador").val();
        var nvl = $("#cbxNivel").val();
        var anio = map_api.anio_id;

        var escala = {};
        escala.id = bd;
        escala.idsubtema = ind;
        escala.idnivel = nvl;
        escala.idanio = anio;
        escala.idubigeo = ubigeo;

        if (bd > 0) {
            $.post('main/get_valores_escala', escala, function (data) {
                                
                var datos = new Array();
                $.each(data.escala, function (index, obj) {
                    datos.push({'nivel_escala':(obj.nivel_escala),'valor':(obj.valor)});
                });

                var length = (map_api.puntos.length - 1);
                
                map_api.puntos[length].datos = datos;


                if(callback){
                        callback();
                } 
            });
        }    
    },

    slide: null,

    set_slider: function (min, max) {

        // Control deslizante
        if (map_api.slide == null) {
            
        map_api.slide = $("#controlDespl").slider({
                value: max,
                min: min,
                max: max,
                step: 1,
                animate: true
            })
            .each(function() {
                // Obtenemos las opciones para el control deslizante
                // Agregar etiquetas al control deslizante cuyos valores se especifican por min, max
                var opt = $(this).data().uiSlider.options;
                // Obtenemos el número de valores posibles
                var vals = opt.max - opt.min;
                // Colocamos las etiquetas
                for (var i = 0; i <= vals; i++) {
                    // Creamos un nuevo elemento y colócalo con porcentajes
                    var el = $('<label><br>' + (i + opt.min) + '</label>').css('left', (i / vals * 100) + '%');
                    // Agregamos el elemento dentro de #slider
                    $("#controlDespl").append(el);
                }
            })
            .slider('pips',{
                first: 'label',
                last: 'label',
                rest: 'label',
                labels : [],  
                prefix :  "" ,  
                suffix : ""
            })
            .slider('float',{
                handle:true,
                pips:true,
                labels : [],  
                prefix :  "" ,  
                suffix : "" 
            });
        } else {
            $("#controlDespl").slider("destroy");
            $("#controlDespl").html('');
            map_api.slide = $("#controlDespl").slider({
                    value: max,
                    min: min,
                    max: max,
                    step: 1,
                    animate: true
                })
                .each(function () {
                    var opt = $(this).data().uiSlider.options;
                    var vals = opt.max - opt.min;

                    for (var i = 0; i <= vals; i++) {
                        var el = $('<label><br>' + (i + opt.min) + '</label>').css('left', (i / vals * 100) + '%');
                        $("#controlDespl").append(el);
                    }
            })
            .slider('pips',{
                first: 'label',
                last: 'label',
                rest: 'label',
                labels : [],  
                prefix :  "" ,  
                suffix : ""
            })
            .slider('float',{
                handle:true,
                pips:true,
                labels : [],  
                prefix :  "" ,  
                suffix : "" 
            });
        }
    },

    puntos:[],
    enviarObjeto: function(bd,ind,nvl,listaObjeto){
        // var bd = $("#cbxBD").val();
        // var ind = $("#cbxIndicador").val();
        // var nvl = $("#cbxNivel").val();
        var anio = map_api.anio_id;
        // var listaObjeto = $("#cbxObjeto").val();
        // 
        if(listaObjeto.length>0){
            var valorObjeto = '';
            for (var i = 0; i<listaObjeto.length; i++){
                valorObjeto=valorObjeto+listaObjeto[i]+'-';
            }
            valorObjeto = valorObjeto.substring(0,valorObjeto.length-1);
        }
		
		var filtro = {};
		filtro.id = bd;
		filtro.idsubtema = ind;
		filtro.idnivel = nvl;
		filtro.idanio = anio;
		filtro.idubigeo = valorObjeto;
        // 
		$.LoadingOverlay("show"); 
		$.post('main/json_poligonos_visor', filtro, function (data) {
		    if(data){
				if(data.poligonos) { var objPoligonos = JSON.parse(data.poligonos); }
				if(data.leyenda) { var objLeyenda = data.leyenda; }
                // if(data.poblacion) { var objPoblacion = data.poblacion;}
				// var Poligonos = Object.assign(objPoligonos,objPoblacion);
				if(objLeyenda.length > 0){
                    
					var tieneLeyenda = '1';
					var unidadMedida;
                    var encabezado;
					var pie_pagina;
                    var idvariable=filtro.idsubtema;
					//
					var leyenda_1 = objLeyenda.filter(function (el) {
						return (el.particion == '1');
					});

                    if(idvariable == 1){

                    var leyenda_1_min = leyenda_1[0].minimo;
                    var leyenda_1_max = leyenda_1[0].maximo;
                    //
                    var leyenda_2 = objLeyenda.filter(function (el) {
                        return (el.particion == '2');
                    });
                    var leyenda_2_min = leyenda_2[0].minimo;
                    var leyenda_2_max = leyenda_2[0].maximo;
                    //
                    var leyenda_3 = objLeyenda.filter(function (el) {
                        return (el.particion == '3');
                    });
                    var leyenda_3_min = leyenda_3[0].minimo;
                    var leyenda_3_max = leyenda_3[0].maximo;
                    //
                    var leyenda_4 = objLeyenda.filter(function (el) {
                        return (el.particion == '4');
                    });
                    var leyenda_4_min = leyenda_4[0].minimo;
                    var leyenda_4_max = leyenda_4[0].maximo;
                    //
                    var leyenda_5 = objLeyenda.filter(function (el) {
                        return (el.particion == '5');
                    });
                    var leyenda_5_min = leyenda_5[0].minimo;
                    var leyenda_5_max = leyenda_5[0].maximo;

                    }else{
                    // (Math.round(num * 100) / 100).toFixed(2);
					var leyenda_1_min = (Math.round(leyenda_1[0].minimo * 100) / 100).toFixed(1);
					var leyenda_1_max = (Math.round(leyenda_1[0].maximo * 100) / 100).toFixed(1);
					//
					var leyenda_2 = objLeyenda.filter(function (el) {
						return (el.particion == '2');
					});
					var leyenda_2_min = (Math.round(leyenda_2[0].minimo * 100) / 100).toFixed(1);
					var leyenda_2_max = (Math.round(leyenda_2[0].maximo * 100) / 100).toFixed(1);
					//
					var leyenda_3 = objLeyenda.filter(function (el) {
						return (el.particion == '3');
					});
					var leyenda_3_min = (Math.round(leyenda_3[0].minimo * 100) / 100).toFixed(1);
					var leyenda_3_max = (Math.round(leyenda_3[0].maximo * 100) / 100).toFixed(1);
					//
					var leyenda_4 = objLeyenda.filter(function (el) {
						return (el.particion == '4');
					});
					var leyenda_4_min = (Math.round(leyenda_4[0].minimo * 100) / 100).toFixed(1);
					var leyenda_4_max = (Math.round(leyenda_4[0].maximo * 100) / 100).toFixed(1);
					//
					var leyenda_5 = objLeyenda.filter(function (el) {
						return (el.particion == '5');
					});
					var leyenda_5_min = (Math.round(leyenda_5[0].minimo * 100) / 100).toFixed(1);
					var leyenda_5_max = (Math.round(leyenda_5[0].maximo * 100) / 100).toFixed(1);
                    }
                    //
				} else {
					var tieneLeyenda = '0';                    
				}            
				//
				if(objPoligonos.totalFeatures > 0) {
					map_api.layer_ubigeo = L.geoJson(objPoligonos ,{
							
						style: function(feature) {
							var valor_medido = feature.properties.valor_medido;
							//
							if(tieneLeyenda=='1'){
								if (valor_medido < leyenda_1_min) {
									return {
									  color: '#455a64',
									  weight: '1',
									  fillColor: '#FFF5F0',
									  fillOpacity: '3.0'
									}; 
								} else if ((valor_medido >= leyenda_1_min)&&(valor_medido <= leyenda_1_max)) {
									return {
									  color: '#455a64',
									  weight: '1',
									  fillColor: '#FFF5F0',
									  fillOpacity: '3.0'
									}; 
								} else if ((valor_medido > leyenda_2_min)&&(valor_medido <= leyenda_2_max)) {
									return {
									  color: '#455a64',
									  weight: '1',
									  fillColor: '#FDBEA5',
									  fillOpacity: '3.0'
									};
								} else if ((valor_medido > leyenda_3_min)&&(valor_medido <= leyenda_3_max)) {
									return {
									  color: '#455a64',
									  weight: '1',
									  fillColor: '#FC7050',
									  fillOpacity: '3.0'
									}
								} else if ((valor_medido > leyenda_4_min)&&(valor_medido <= leyenda_4_max)) {
									return {
									  color: '#455a64',
									  weight: '1',
									  fillColor: '#D42020',
									  fillOpacity: '3.0'
									}
								} else if ((valor_medido > leyenda_5_min)&&(valor_medido <= leyenda_5_max)) {
									return {
									  color: '#455a64',
									  weight: '1',
									  fillColor: '#67000D',
									  fillOpacity: '3.0'
									}
								} else if (valor_medido > leyenda_5_max) {
									return {
									  color: '#455a64',
									  weight: '1',
									  fillColor: '#67000D',
									  fillOpacity: '3.0'
									}
								}
							} else {
								return {
								  color: '#455a64',
								  weight: '1',
								  fillColor: '#ffffff',
								  fillOpacity: '3.0'
								}
							}
						},
						
						onEachFeature: function(feature, layer) {

							encabezado = "<center>" + feature.properties.medida + ' de ' + feature.properties.variable + ' por ' + 
										feature.properties.nivel + ' - ' + feature.properties.anio + "</center>";

							pie_pagina = "<center>Fuente: " + feature.properties.institucion + ' - ' + feature.properties.fuente + 
										', ' +	feature.properties.anio + "</center>";

                            unidadMedida = feature.properties.unidad;

							var valores = "<center><b>" + feature.properties.descripcion + "</b></center>" +
                                "<center><b> " + (Math.round(feature.properties.valor_medido * 100) / 100).toFixed(1)+ " " + feature.properties.unidad + "</b></center>";

                            var nivel = feature.properties.id_nivel

                            if(nivel==4 || nivel == 3){
                            // var tooltipText = "<center><b>" + feature.properties.descripcion + "</b></center>" +
                            //     "<b>Ranking:</b> " + feature.properties.orden_rank + " de " + feature.properties.total_rank;
                            layer.bindTooltip(valores, {
                                offset: L.point(0, -20)
                            });

                            }else{

                            var etiquetasPeru = L.marker(layer.getBounds().getCenter(), {
                            icon: L.divIcon({
                                className: 'etiquetasPeru',
                                html: valores,
                                iconSize: [100, 30],
                                // iconAnchor: [50,20]
                                })
                            });
                            etiquetasPeru.addTo(map_api.map);
                            map_api.mapEtiquetasPeru.push(etiquetasPeru);
                            }
							//construccion de popup
                            if((feature.properties.codigo=='990001')||(feature.properties.codigo=='990002')||(feature.properties.codigo=='070000')){
                                var popupText = "<center><b> " + feature.properties.variable + "</b></center>" +                                
                                "<b>"  + feature.properties.descripcion +                         
                                "<br><b>Año:</b> " + feature.properties.anio +
                                "<br><b>Valor:</b> " + feature.properties.valor_medido + " " + feature.properties.unidad +
                                "<br><b>Población:</b> " + feature.properties.nro_hab + " hab."
                                "<br><b>Ranking:</b> " + feature.properties.orden_rank + " de " + feature.properties.total_rank;
                            }else{
                                var popupText = "<center><b> " + feature.properties.variable + "</b></center>" +                                
                                "<b>"  + feature.properties.nivel + ":</b> " + feature.properties.descripcion +                         
                                "<br><b>Año:</b> " + feature.properties.anio +
                                "<br><b>Valor:</b> " + feature.properties.valor_medido + " " + feature.properties.unidad +
                                "<br><b>Población:</b> " + feature.properties.nro_hab + " hab."
                                "<br><b>Ranking:</b> " + feature.properties.orden_rank + " de " + feature.properties.total_rank;
                            }
							//
							layer.bindPopup(popupText, {
								closeButton: true,
								offset: L.point(0, -20)
							});
							//
							layer.on('mouseover', function() {
								layer.openTooltip();
							});
							//
							layer.on('mouseout', function() {
								layer.closeTooltip();
							});
							//
							layer.on('click', function() {

								var punto;
								var arrayPuntosActual = localStorage.getItem('arrayPuntos');
                                // console.log(arrayPuntosActual);
								if(arrayPuntosActual){
									var arrayPuntos = JSON.parse(arrayPuntosActual);
									var arrayPuntos_existe = arrayPuntos.filter(function (el) {
										return (el.codigo == feature.properties.codigo);
									});
									//
									punto = feature.properties;
									if(arrayPuntos_existe.length <= 0){
										arrayPuntos.push(punto);
										localStorage.setItem('arrayPuntos', JSON.stringify(arrayPuntos));
                                        map_api.puntos.push(punto);  
									}
								} else {
									var arrayPuntos = new Array();
									punto = feature.properties;
									arrayPuntos.push(punto);
									localStorage.setItem('arrayPuntos', JSON.stringify(arrayPuntos));
                                    map_api.puntos.push(punto);  
								}		
                                // 
                                map_api.mostrarResumen();
                                map_api.mostrarDetalle(punto);
                                layer.openPopup();
                                //map_api.map.fitBounds(layer.getBounds());                                
							});
						}						
					}).addTo(map_api.map);
					//
					map_api.map.fitBounds(map_api.layer_ubigeo.getBounds());
                    map_api.layer_ubigeo.bringToBack();
				} else {
					$.notify({
						title: "ALERTA: ",
						message: "NO HAY INFORMACIÓN DISPONIBLE CON LOS DATOS CONSULTADOS",
						icon: 'fa fa-exclamation-triangle' 
					},{
						type: "warning",
						z_index: 10310
					});
				}
				//
				if(tieneLeyenda=='1'){ 
					$('#encabezado').html(encabezado);
					$('#leyenda_1_min').html(leyenda_1_min);
					$('#leyenda_1_max').html(leyenda_1_max);
					$('#leyenda_2_min').html(leyenda_2_min);
					$('#leyenda_2_max').html(leyenda_2_max);
					$('#leyenda_3_min').html(leyenda_3_min);
					$('#leyenda_3_max').html(leyenda_3_max);
					$('#leyenda_4_min').html(leyenda_4_min);
					$('#leyenda_4_max').html(leyenda_4_max);
					$('#leyenda_5_min').html(leyenda_5_min);
					$('#leyenda_5_max').html(leyenda_5_max);
                    // $('#unidadMedida1').html(unidadMedida);
                    // $('#unidadMedida2').html(unidadMedida);
                    // $('#unidadMedida3').html(unidadMedida);
                    // $('#unidadMedida4').html(unidadMedida);
                    // $('#unidadMedida5').html(unidadMedida);
					$('#piepag').html(pie_pagina);
					$('#leyenda').show(); 
				}
				//
				$.LoadingOverlay("hide");
			} else {
				$.notify({
					title: "ALERTA: ",
					message: "NO HAY INFORMACIÓN DISPONIBLE CON LOS DATOS CONSULTADOS",
					icon: 'fa fa-exclamation-triangle' 
				},{
					type: "warning",
					z_index: 10310
				});
				//
			    $.LoadingOverlay("hide");
			}
		}).fail(function(xhr, status, error) {
			// error handling
			console.log(xhr);
			console.log(status);
			console.log(error);
			//
			$.notify({
				title: "ALERTA: ",
				message: "ERROR - NO SE PUDO CONSULTAR LA INFORMACIÓN",
				icon: 'fa fa-exclamation-triangle' 
			},{
				type: "danger",
				z_index: 10310
			});
			//
			$.LoadingOverlay("hide");
		});
    },

    clearLayerEtiquetasPeru: function(){
        for(var i = 0; i < map_api.mapEtiquetasPeru.length; i++){
        map_api.map.removeLayer(map_api.mapEtiquetasPeru[i]);
        }
    },

    enviarValoresEscala: function(bd,ind,nvl,listaObjeto){

        var anio = map_api.anio_id;
        // 
        if(listaObjeto.length>0){
            var valorObjeto = '';
            for (var i = 0; i<listaObjeto.length; i++){
                valorObjeto=valorObjeto+listaObjeto[i]+'-';
            }
            valorObjeto = valorObjeto.substring(0,valorObjeto.length-1);
        }
        
        var filtro = {};
        filtro.id = bd;
        filtro.idsubtema = ind;
        filtro.idnivel = nvl;
        filtro.idanio = anio;
        filtro.idubigeo = valorObjeto;
        // 

        $.LoadingOverlay("show"); 
        $.post('main/json_valores_escala_visor', filtro, function (data) {
            
            if(data){
                if(data.poligonos) { var objPoligonos = JSON.parse(data.poligonos); }
                    var encabezado;
                    var pie_pagina;

                if(objPoligonos.totalFeatures > 0) {
                    map_api.layer_ubigeo = L.geoJson(objPoligonos ,{
                            
                        style: function(feature) {
                                return {
                                  color: '#e3c012',
                                  weight: '1',
                                  fillOpacity: '0'
                            }
                        },
                        
                        onEachFeature: function(feature, layer) {

                            encabezado = "<center>" + feature.properties.variable + ' por ' + 
                                        feature.properties.nivel + ' - ' + feature.properties.anio + "</center>";

                            pie_pagina = "<center>Fuente: " + feature.properties.institucion + ' - ' + feature.properties.fuente + 
                                        ', ' +  feature.properties.anio + "</center>";

                            var tooltipText = "<center><b>" + feature.properties.descripcion + "</b></center>" +
                            "<b>Población:</b> " + feature.properties.nro_hab + " hab."+
                            "<br><b>Año:</b> " + feature.properties.anio;                            
                            //
                            layer.bindTooltip(tooltipText, {
                                offset: L.point(0, -20)
                            });
                            //
                            layer.on('mouseover', function() {
                                layer.openTooltip();
                            });
                            //
                            layer.on('mouseout', function() {
                                layer.closeTooltip();
                            });
                            //
                            layer.on('click', function() {

                                var punto;
                                var arrayPuntosActual = localStorage.getItem('arrayPuntos');
                                if(arrayPuntosActual){
                                    var arrayPuntos = JSON.parse(arrayPuntosActual);
                                    var arrayPuntos_existe = arrayPuntos.filter(function (el) {
                                        return (el.codigo == feature.properties.codigo);
                                    });
                                    //
                                    punto = feature.properties;
                                    if(arrayPuntos_existe.length <= 0){
                                        arrayPuntos.push(punto);
                                        localStorage.setItem('arrayPuntos', JSON.stringify(arrayPuntos));
                                        map_api.puntos.push(punto);  
                                    }
                                } else {
                                    var arrayPuntos = new Array();
                                    punto = feature.properties;
                                    arrayPuntos.push(punto);
                                    localStorage.setItem('arrayPuntos', JSON.stringify(arrayPuntos));
                                    map_api.puntos.push(punto);  
                                }
                                //
                                map_api.get_valores_escala(feature.properties.codigo, function(){
                                map_api.mostrarValoresEscala(map_api.puntos);
                                }); 
                                // setTimeout(function(){ map_api.mostrarResumen(); }, 5000);
                                // map_api.mostrarResumen();
                                // map_api.mostrarDetalle(punto);
                                // layer.openPopup();
                                //map_api.map.fitBounds(layer.getBounds());
                            });
                        }                        
                    }).addTo(map_api.map);
                    //
                    map_api.map.fitBounds(map_api.layer_ubigeo.getBounds());
                    map_api.layer_ubigeo.bringToBack();
                } else {
                    $.notify({
                        title: "ALERTA: ",
                        message: "NO HAY INFORMACIÓN DISPONIBLE CON LOS DATOS CONSULTADOS",
                        icon: 'fa fa-exclamation-triangle' 
                    },{
                        type: "warning",
                        z_index: 10310
                    });
                }
                //
                    $('#encabezado_pie').html(encabezado); 
                    $('#piepag_pie').html(pie_pagina);
                    $('#encabezado_bar').html(encabezado);
                    $('#piepag_bar').html(pie_pagina);
                //
                $.LoadingOverlay("hide");
            } else {
                $.notify({
                    title: "ALERTA: ",
                    message: "NO HAY INFORMACIÓN DISPONIBLE CON LOS DATOS CONSULTADOS",
                    icon: 'fa fa-exclamation-triangle' 
                },{
                    type: "warning",
                    z_index: 10310
                });
                //
                $.LoadingOverlay("hide");
            }
        }).fail(function(xhr, status, error) {
            // error handling
            console.log(xhr);
            console.log(status);
            console.log(error);
            //
            $.notify({
                title: "ALERTA: ",
                message: "ERROR - NO SE PUDO CONSULTAR LA INFORMACIÓN",
                icon: 'fa fa-exclamation-triangle' 
            },{
                type: "danger",
                z_index: 10310
            });
            //
            $.LoadingOverlay("hide");
        });
    },

    enviarPeriodoMovil: function(bd,ind,nvl,listaObjeto,frec,rango){
        var anio = map_api.anio_id;
        // 
        if(listaObjeto.length>0){
            var valorObjeto = '';
            for (var i = 0; i<listaObjeto.length; i++){
                valorObjeto=valorObjeto+listaObjeto[i]+'-';
            }
            valorObjeto = valorObjeto.substring(0,valorObjeto.length-1);
        }
        
        var filtro = {};
        filtro.id = bd;
        filtro.idsubtema = ind;
        filtro.idnivel = nvl;
        filtro.idanio = anio;
        filtro.idubigeo = valorObjeto;
        filtro.idfrecuencia = frec;
        filtro.idrango = rango;
        // 
        // console.log(bd,ind,nvl,anio,valorObjeto,frec,rango);
        // 
        $.LoadingOverlay("show"); 
        $.post('main/json_periodo_movil_visor', filtro, function (data) {

            if(data){
                if(data.poligonos) { var objPoligonos = JSON.parse(data.poligonos); }
                if(data.leyendaperiodo) { var objLeyenda = data.leyendaperiodo; }
                if(objLeyenda.length > 0){
                    
                    var tieneLeyenda = '1';
                    var encabezado;
                    var encabezado2;
                    var pie_pagina;
                    //
                    var leyenda_1 = objLeyenda.filter(function (el) {
                        return (el.particion == '1');
                    });
                    var leyenda_1_min = leyenda_1[0].minimo;
                    var leyenda_1_max = leyenda_1[0].maximo;
                    //
                    var leyenda_2 = objLeyenda.filter(function (el) {
                        return (el.particion == '2');
                    });
                    var leyenda_2_min = leyenda_2[0].minimo;
                    var leyenda_2_max = leyenda_2[0].maximo;
                    //
                    var leyenda_3 = objLeyenda.filter(function (el) {
                        return (el.particion == '3');
                    });
                    var leyenda_3_min = leyenda_3[0].minimo;
                    var leyenda_3_max = leyenda_3[0].maximo;
                    //
                    var leyenda_4 = objLeyenda.filter(function (el) {
                        return (el.particion == '4');
                    });
                    var leyenda_4_min = leyenda_4[0].minimo;
                    var leyenda_4_max = leyenda_4[0].maximo;
                    //
                    var leyenda_5 = objLeyenda.filter(function (el) {
                        return (el.particion == '5');
                    });
                    var leyenda_5_min = leyenda_5[0].minimo;
                    var leyenda_5_max = leyenda_5[0].maximo;
                    //
                } else {
                    var tieneLeyenda = '0';                    
                }            
                //
                if(objPoligonos.totalFeatures > 0) {
                    map_api.layer_ubigeo = L.geoJson(objPoligonos ,{
                            
                        style: function(feature) {
                            var valor_medido = feature.properties.valor_medido_periodo;
                            //
                            if(tieneLeyenda=='1'){
                                if (valor_medido < leyenda_1_min) {
                                    return {
                                      color: '#455a64',
                                      weight: '1',
                                      fillColor: '#FFF5F0',
                                      fillOpacity: '3.0'
                                    }; 
                                } else if ((valor_medido >= leyenda_1_min)&&(valor_medido <= leyenda_1_max)) {
                                    return {
                                      color: '#455a64',
                                      weight: '1',
                                      fillColor: '#FFF5F0',
                                      fillOpacity: '3.0'
                                    }; 
                                } else if ((valor_medido > leyenda_2_min)&&(valor_medido <= leyenda_2_max)) {
                                    return {
                                      color: '#455a64',
                                      weight: '1',
                                      fillColor: '#FDBEA5',
                                      fillOpacity: '3.0'
                                    };
                                } else if ((valor_medido > leyenda_3_min)&&(valor_medido <= leyenda_3_max)) {
                                    return {
                                      color: '#455a64',
                                      weight: '1',
                                      fillColor: '#FC7050',
                                      fillOpacity: '3.0'
                                    }
                                } else if ((valor_medido > leyenda_4_min)&&(valor_medido <= leyenda_4_max)) {
                                    return {
                                      color: '#455a64',
                                      weight: '1',
                                      fillColor: '#D42020',
                                      fillOpacity: '3.0'
                                    }
                                } else if ((valor_medido > leyenda_5_min)&&(valor_medido <= leyenda_5_max)) {
                                    return {
                                      color: '#455a64',
                                      weight: '1',
                                      fillColor: '#67000D',
                                      fillOpacity: '3.0'
                                    }
                                } else if (valor_medido > leyenda_5_max) {
                                    return {
                                      color: '#455a64',
                                      weight: '1',
                                      fillColor: '#67000D',
                                      fillOpacity: '3.0'
                                    }
                                }
                            } else {
                                return {
                                  color: '#455a64',
                                  weight: '1',
                                  fillColor: '#ffffff',
                                  fillOpacity: '3.0'
                                }
                            }
                        },
                        
                        onEachFeature: function(feature, layer) {

                            encabezado = "<center>" + feature.properties.medida + ' de ' + feature.properties.variable + ' por ' + 
                                        feature.properties.nivel + ' - ' + feature.properties.anio + "</center>";

                            pie_pagina = "<center>Fuente: " + feature.properties.institucion + ' - ' + feature.properties.fuente + 
                                        ', ' +  feature.properties.anio + "</center>";

                            var tooltipText = "<center><b>" + feature.properties.descripcion + "</b></center>";
                            
                            var nivel = feature.properties.id_nivel

                            if(nivel==4 || nivel == 3){
                            layer.bindTooltip(tooltipText, {
                                offset: L.point(0, -20)
                            });

                            }else{

                            var etiquetasPeru = L.marker(layer.getBounds().getCenter(), {
                            icon: L.divIcon({
                                className: 'etiquetasPeru',
                                html: tooltipText,
                                iconSize: [100, 30],
                                iconAnchor: [50,20]
                                })
                            });
                            etiquetasPeru.addTo(map_api.map);
                            map_api.mapEtiquetasPeru.push(etiquetasPeru);
                            }
                            //construccion de popup
                            if((feature.properties.codigo=='990001')||(feature.properties.codigo=='990002')||(feature.properties.codigo=='070000')){
                                var popupText = "<center><b> " + feature.properties.variable + "</b></center>" +                                
                                "<b>"  + feature.properties.descripcion +                         
                                "<br><b>Año:</b> " + feature.properties.anio +
                                "<br><b>Valor:</b> " + feature.properties.valor_medido + " " + feature.properties.unidad +
                                "<br><b>Población:</b> " + feature.properties.nro_hab + " hab."
                                "<br><b>Ranking:</b> " + feature.properties.orden_rank + " de " + feature.properties.total_rank;
                            }else{
                                var popupText = "<center><b> " + feature.properties.variable + "</b></center>" +                                
                                "<b>"  + feature.properties.nivel + ":</b> " + feature.properties.descripcion +                         
                                "<br><b>Año:</b> " + feature.properties.anio +
                                "<br><b>Valor:</b> " + feature.properties.valor_medido + " " + feature.properties.unidad +
                                "<br><b>Población:</b> " + feature.properties.nro_hab + " hab."
                                "<br><b>Ranking:</b> " + feature.properties.orden_rank + " de " + feature.properties.total_rank;
                            }
                            //
                            layer.bindPopup(popupText, {
                                closeButton: true,
                                offset: L.point(0, -20)
                            });
                            //
                            layer.on('mouseover', function() {
                                layer.openTooltip();
                            });
                            //
                            layer.on('mouseout', function() {
                                layer.closeTooltip();
                            });
                            //
                            layer.on('click', function() {

                                var punto;
                                var arrayPuntosActual = localStorage.getItem('arrayPuntos');
                                if(arrayPuntosActual){
                                    var arrayPuntos = JSON.parse(arrayPuntosActual);
                                    var arrayPuntos_existe = arrayPuntos.filter(function (el) {
                                        return (el.codigo == feature.properties.codigo);
                                    });
                                    //
                                    punto = feature.properties;
                                    if(arrayPuntos_existe.length <= 0){
                                        arrayPuntos.push(punto);
                                        localStorage.setItem('arrayPuntos', JSON.stringify(arrayPuntos));
                                    }
                                } else {
                                    var arrayPuntos = new Array();
                                    punto = feature.properties;
                                    arrayPuntos.push(punto);
                                    localStorage.setItem('arrayPuntos', JSON.stringify(arrayPuntos));
                                }
                                //
                                map_api.mostrarResumen();
                                map_api.mostrarDetalle(punto);
                                layer.openPopup();
                                //map_api.map.fitBounds(layer.getBounds());
                            });
                        }
                        
                    }).addTo(map_api.map);
                    //
                    map_api.map.fitBounds(map_api.layer_ubigeo.getBounds());
                    map_api.layer_ubigeo.bringToBack();
                } else {
                    $.notify({
                        title: "ALERTA: ",
                        message: "NO HAY INFORMACIÓN DISPONIBLE CON LOS DATOS CONSULTADOS",
                        icon: 'fa fa-exclamation-triangle' 
                    },{
                        type: "warning",
                        z_index: 10310
                    });
                }
                //
                if(tieneLeyenda=='1'){ 
                    $('#encabezado').html(encabezado);
                    $('#leyenda_1_min').html(leyenda_1_min);
                    $('#leyenda_1_max').html(leyenda_1_max);
                    $('#leyenda_2_min').html(leyenda_2_min);
                    $('#leyenda_2_max').html(leyenda_2_max);
                    $('#leyenda_3_min').html(leyenda_3_min);
                    $('#leyenda_3_max').html(leyenda_3_max);
                    $('#leyenda_4_min').html(leyenda_4_min);
                    $('#leyenda_4_max').html(leyenda_4_max);
                    $('#leyenda_5_min').html(leyenda_5_min);
                    $('#leyenda_5_max').html(leyenda_5_max);
                    $('#piepag').html(pie_pagina);
                    $('#leyenda').show(); 
                }
                //
                $.LoadingOverlay("hide");
            } else {
                $.notify({
                    title: "ALERTA: ",
                    message: "NO HAY INFORMACIÓN DISPONIBLE CON LOS DATOS CONSULTADOS",
                    icon: 'fa fa-exclamation-triangle' 
                },{
                    type: "warning",
                    z_index: 10310
                });
                //
                $.LoadingOverlay("hide");
            }
        }).fail(function(xhr, status, error) {
            // error handling
            console.log(xhr);
            console.log(status);
            console.log(error);
            //
            $.notify({
                title: "ALERTA: ",
                message: "ERROR - NO SE PUDO CONSULTAR LA INFORMACIÓN",
                icon: 'fa fa-exclamation-triangle' 
            },{
                type: "danger",
                z_index: 10310
            });
            //
            $.LoadingOverlay("hide");
        });
    },

    mostrarBarChart: function() {

        var bd = $("#cbxBD").val();
        var ind = $("#cbxIndicador").val();
        var nvl = $("#cbxNivel").val();
        var anio = map_api.anio_id;
        var listaObjeto = $("#cbxObjeto").val();

        if (listaObjeto.length > 0) {
            var valorObjeto = '';
            for (var i = 0; i < listaObjeto.length; i++) {
                valorObjeto = valorObjeto + listaObjeto[i] + '-';
            }
            valorObjeto = valorObjeto.substring(0, valorObjeto.length - 1);
        }

        var filtro = {};
        filtro.id = bd;
        filtro.idsubtema =ind;
        filtro.idnivel = nvl;
        filtro.idanio =anio;
        filtro.idubigeo = valorObjeto;

        $.LoadingOverlay("show");

        map_api.arreglo = [];

        $.get('main/barChart', filtro, function(data) {
            
            if(data){
            if(data.bar) { var objGrafico = JSON.parse(data.bar); }

            $.each( objGrafico.features, function( idx, grafico ) {

                var options = {
                    data: {
                        'Patrullaje PNP': grafico.properties.data1,
                        'Patrullaje Serenazgo': grafico.properties.data2,
                        'Patrullaje Integrado': grafico.properties.data3
                    },
                    ubigeo:  grafico.properties.ubigeo,
                    chartOptions : {
                        'Patrullaje PNP': {
                            fillColor: '#088A29',
                            minValue: 0,
                            maxValue: 20,
                            maxHeight: 20,
                            displayText: function (value) {
                                return value+' %';
                            }
                        },
                        'Patrullaje Serenazgo': {
                            fillColor: '#00BFFF',
                            minValue: 0,
                            maxValue: 20,
                            maxHeight: 20,
                            displayText: function (value) {
                                return value+' %';
                            }
                        },
                        'Patrullaje Integrado': {
                            fillColor: '#045FB4',
                            minValue: 0,
                            maxValue: 20,
                            maxHeight: 20,
                            displayText: function (value) {
                                return value+' %';
                            }
                        }
                    },
                    weight: 0,
                    color: '#000000',
                    iconSize: new L.Point(53, 53)
                };
                var barChartMarker = new L.BarChartMarker(new L.LatLng(grafico.geometry.coordinates[1], grafico.geometry.coordinates[0]), options);
                map_api.map.addLayer(barChartMarker);
                map_api.arreglo.push(barChartMarker);
                });
            }       
        });
        $.LoadingOverlay("hide");
    },

	mostrarPieChart: function(bd,ind,nvl,listaObjeto) {

	    // var bd = $("#cbxBD").val();
	    // var ind = $("#cbxIndicador").val();
	    // var nvl = $("#cbxNivel").val();
	    var anio = map_api.anio_id;
	    // var listaObjeto = $("#cbxObjeto").val();

	    if (listaObjeto.length > 0) {
	        var valorObjeto = '';
	        for (var i = 0; i < listaObjeto.length; i++) {
	            valorObjeto = valorObjeto + listaObjeto[i] + '-';
	        }
	        valorObjeto = valorObjeto.substring(0, valorObjeto.length - 1);
	    }

	    var filtro = {};
	    filtro.id = bd;
	    filtro.idsubtema =ind;
	    filtro.idnivel = nvl;
	    filtro.idanio =anio;
	    filtro.idubigeo = valorObjeto;

	    $.LoadingOverlay("show");

        map_api.arreglo =[];
	    $.get('main/pieChart', filtro, function(data) {
	        //
            if(data){
            if(data.pie) { var objGrafico = JSON.parse(data.pie); }
            // var objGrafico = JSON.parse(data);

            $.each( objGrafico.features, function( idx, grafico ) {
                var colorValue = Math.random() * 360;
                var options = {
                    data: {
                        'Nada Satisfecho': grafico.properties.data1,
                        'Poco Satisfecho': grafico.properties.data2,
                        'Neutral': grafico.properties.data3,
                        'Muy Satisfecho': grafico.properties.data4,
                        'Totalmente Satisfecho': grafico.properties.data5
                    },
                    ubigeo:  grafico.properties.ubigeo,
                    chartOptions: {
                        'Nada Satisfecho': {
                            fillColor: '#FF0000',
                            minValue: 0,
                            maxValue: 20,
                            maxHeight: 20,
                            displayText: function (value) {
                                return value+' %';
                            }
                        },
                        'Poco Satisfecho': {
                            fillColor: '#FE9A2E',
                            minValue: 0,
                            maxValue: 20,
                            maxHeight: 20,
                            displayText: function (value) {
                                return value+' %';
                            }
                        },
                        'Neutral': {
                            fillColor: '#FACC2E',
                            minValue: 0,
                            maxValue: 20,
                            maxHeight: 20,
                            displayText: function (value) {
                                return value+' %';
                            }
                        },
                        'Muy Satisfecho': {
                            fillColor: '#FFFF00',
                            minValue: 0,
                            maxValue: 20,
                            maxHeight: 20,
                            displayText: function (value) {
                                return value+' %';
                            }
                        },
                        'Totalmente Satisfecho': {
                            fillColor: '#70C620',
                            minValue: 0,
                            maxValue: 20,
                            maxHeight: 20,
                            displayText: function (value) {
                                return value+' %';
                            }
                        }
                    },
                    radius: 30,
                    weight: 0.5,
                    color: '#000000',                    
                    fillColor: 'hsl(' + colorValue + ',100%,50%)',
                    fillOpacity: 1,
                    iconSize: new L.Point(53, 53)
                };
                var pieChartMarker = new L.PieChartMarker(new L.LatLng(grafico.geometry.coordinates[1], grafico.geometry.coordinates[0]), options);
                map_api.map.addLayer(pieChartMarker);
                map_api.arreglo.push(pieChartMarker);
            });
            }         
	    });
	    $.LoadingOverlay("hide");
	},

    delete: function(){
        for (let index = 0; index < map_api.arreglo.length; index++) {   
            map_api.map.removeLayer(map_api.arreglo[index])       
        }
    },

    mostrarSeleccion: function(lat,lng){
        var latlng = new L.LatLng(lat,lng);
        map_api.map.setView(latlng, 8, { animation: true });      
    },

    ocultarTr: function() {
    $("tr").hide();
    },

    mostrarResumen: function (){

        $('#descripcion').hide();
        
        var arrayPuntosActual = localStorage.getItem('arrayPuntos');
        var arrayPuntos = JSON.parse(arrayPuntosActual);
        
        var tableHtml = '';
        tableHtml += '<tbody>'; 

        var arr = [];
        arr = arrayPuntos.reverse();
        // 
        $.each(arr, function(idx, obj) {
        // console.log(obj);
        // 
        var codigo = obj.codigo+"";

            tableHtml += '<tr>';
                // tableHtml += '<td>';
                tableHtml += "<td onclick='map_api.mostrarSeleccion("+obj.centro.coordinates[1]+","+obj.centro.coordinates[0]+");'>";
                if((obj.id_nivel=='3')||(obj.id_nivel=='4')||(obj.id_nivel=='5')||(obj.id_nivel=='7')) { tableHtml += '<b>Departamento de ' + obj.departamento + '</b>'; }
                if((obj.id_nivel=='4')||(obj.id_nivel=='5')||(obj.id_nivel=='7')) { tableHtml += '<br><b>Provincia de ' + obj.provincia + '</b>'; }
                if((obj.id_nivel=='3')||(obj.id_nivel=='4')||(obj.id_nivel=='5')||(obj.id_nivel=='7')) { tableHtml += '<br>'; }
                if(obj.id_nivel=='7'){obj.nivel='Distrito';}
                if(obj.id_nivel=='5'){obj.nivel='Ciudad';}
                if((obj.codigo=='990001')||(obj.codigo=='990002')||(obj.codigo=='070000')){tableHtml += '<b>' + obj.descripcion + '</b>';}
                else{tableHtml += '<b>' + obj.nivel + ' de ' + obj.descripcion + '</b>';}  
                tableHtml += '<br><b>' + obj.variable + ':</b> ' + obj.valor_medido + ' ' + obj.unidad;
                tableHtml += '<br><b>Población:</b> ' + obj.nro_hab + ' habitantes.' ;
                tableHtml += '<br><b>Ranking:</b> ' + obj.orden_rank + ' de ' + obj.total_rank;
                tableHtml += '</td>';
                // tableHtml += "<td><button type='button' onclick='map_api.ocultarTr();' aria-label='Cerrar' class='close'><span aria-hidden='true'>×</span></button></td>';"
                // tableHtml += "<td><button type='button' onclick='$(tbody tr).hide();' aria-label='Cerrar' class='close'><span aria-hidden='true'>×</span></button></td>';"
                // tableHtml += '<button id="cerrar" style="z-index: 999" type="button" onclick="window.close();"><a href="#"><span class="btn-close">X</span></a></button>';
            tableHtml += '</tr>';
        });

        tableHtml += '</tbody>';

        $('#dataResumen').html(tableHtml);
        $('#resumen').show();
    },

	mostrarValoresEscala: function (puntos){

        $('#descripcion').hide();

        var arr;
        arr = puntos;
        var tableHtml = '';
        tableHtml += '<tbody>';         

        $.each(arr.reverse(), function(idx, obj) {

            var codigo = obj.codigo+"";

            tableHtml += '<tr>';
            tableHtml += "<td onclick='map_api.mostrarSeleccion("+obj.centro.coordinates[1]+","+obj.centro.coordinates[0]+");'>";
            if((obj.id_nivel=='3')||(obj.id_nivel=='4')||(obj.id_nivel=='5')||(obj.id_nivel=='7')) { tableHtml += '<b>Departamento de ' + obj.departamento + '</b>'; }
            if((obj.id_nivel=='4')||(obj.id_nivel=='5')||(obj.id_nivel=='7')) { tableHtml += '<br><b>Provincia de ' + obj.provincia + '</b>'; }
            if((obj.id_nivel=='3')||(obj.id_nivel=='4')||(obj.id_nivel=='5')||(obj.id_nivel=='7')) { tableHtml += '<br>'; }
            if(obj.id_nivel=='7'){obj.nivel='Distrito';}
            if(obj.id_nivel=='5'){obj.nivel='Ciudad';}
            if((obj.codigo=='990001')||(obj.codigo=='990002')){tableHtml += '<b>' + obj.descripcion + '</b>';}
            else{tableHtml += '<b>' + obj.nivel + ' de ' + obj.descripcion + '</b>';}            
            tableHtml += '<br><b>Población:</b> ' + obj.nro_hab + ' ';         

            $.each(obj.datos , function(idx, obj) {
                tableHtml += '<br> - '+obj.nivel_escala+': ' + obj.valor + '%' ; 
            });  

            tableHtml += '</td>';
            tableHtml += '</tr>';
        });       

        tableHtml += '</tbody>';

        $('#dataResumen').html(tableHtml);
        $('#resumen').show();
	},

	mostrarDetalle: function (punto){
		
		var enunciado = punto;

		$('#nombre').text(enunciado.descripcion);
		$('#cantidad').text(enunciado.valor_medido);
		$('#unidad').text(enunciado.unidad);
		$('#variable').text(enunciado.variable);
		$('#anio20').text(enunciado.anio);
		$('#detalle').show();		
	},

    mostrarDescripcion: function (iddb) {
        var descripcion = {};
        descripcion.id = iddb;

        if (iddb > 0) {
            $.post('main/get_descripcion', descripcion, function (data) {
                var t_desc ='';
                var d_desc ='';
                var f_desc ='';
                var imgHtml = '';
                // 
                $.each(data.descripcion, function (index, obj) {
                    
                    t_desc = '<center>' + obj.descrip_bd + '</center>';
                    d_desc = '<justify>' + obj.detalle_bd + '</justify>';
                    f_desc = '<center>' + obj.fuente_bd + ' ' + obj.min + ' - ' + obj.max + '</center>';
                    imgHtml += '<img src="assets/images/fuente'+obj.id_fuente+'.png" id="imgFuente">'
                });
                $("#tituloDesc").html(t_desc);
                $("#fuenteDesc").html(f_desc);
                $('#mimagenDesc').html(imgHtml);
                $("#detalleDesc").html(d_desc);                
                //
            });
        } 
    },

    filtrar: function (){
        localStorage.removeItem('arrayPuntos');
        map_api.puntos = [];
        // map_api.clearLayerComisarias();
        var tableHtml = '';
		$('#resumen').hide();
		$('#detalle').hide();
		$('#leyenda').hide();
        $('#leyenda_bar').hide();
        $('#leyenda_pie').hide();
        $('#ckbDepartamento').prop("checked", false);
        $('#ckbProvincia').prop("checked", false);
        $('#ckbDistrito').prop("checked", false);
        //
        if (map_api.arreglo.length > 0){
            map_api.delete();
        }
        //
        if( map_api.mapa_peru != null){
            map_api.mapa_peru.remove();
        }
		//
		if( map_api.layer_ubigeo != null){
            map_api.layer_ubigeo.remove();
            map_api.clearLayerEtiquetasPeru(); 
        }
        //
        if( map_api.mapaDepartamento != null){
            map_api.mapaDepartamento.remove();
            map_api.clearEtiquetasDepartamento(); 
        }
        //
        if( map_api.mapaProvincia != null){
            map_api.mapaProvincia.remove();
            map_api.clearEtiquetasProvincia(); 
        }
        //
        if( map_api.mapaDistrito != null){
            map_api.mapaDistrito.remove();
            map_api.clearEtiquetasDistrito(); 
        }
        //
		var bd = $("#cbxBD").val();
        var ind = $("#cbxIndicador").val();
        var nvl = $("#cbxNivel").val();
        var anio = map_api.anio_id;
        var listaObjeto = $("#cbxObjeto").val();
        // console.log(bd,ind,nvl,anio,listaObjeto);
		//
		if((bd!='0')&&(ind!='0')&&(nvl!='0')){
            
            if(bd=='1'){
                if(ind=='3'){
                    map_api.enviarValoresEscala(bd,ind,nvl,anio,listaObjeto);
                    map_api.mostrarBarChart(bd,ind,nvl,listaObjeto);
                    $('#leyenda_bar').show(); 
                }else if(ind=='5'||ind=='27'||ind=='28'){
                    map_api.enviarObjeto(bd,ind,nvl,listaObjeto);
                    $('#divOpcional').show();
                }else{
                    map_api.enviarObjeto(bd,ind,nvl,listaObjeto);
                }
            }else if(bd=='2'){
                map_api.enviarValoresEscala(bd,ind,nvl,anio,listaObjeto);
                map_api.mostrarPieChart(bd,ind,nvl,listaObjeto); 
                $('#leyenda_pie').show();            
            }else{
                map_api.enviarObjeto(bd,ind,nvl,listaObjeto);
            }

		} else {
		    $.notify({
				title: "ALERTA: ",
				message: "DEBE SELECCIONAR UN TEMA, SUB TEMA Y NIVEL PARA PODER CONSULTAR",
				icon: 'fa fa-exclamation-triangle' 
			},{
				type: "warning",
				z_index: 10310
			});
		}
    },

    filtrar2: function (){
        localStorage.removeItem('arrayPuntos');
        
        $('#resumen').hide();
        $('#detalle').hide();
        $('#leyenda').hide();
        $('#leyenda_bar').hide();
        $('#leyenda_pie').hide();
        //
        if( map_api.mapa_peru != null){
            map_api.mapa_peru.remove();
        }
        //
        if( map_api.layer_ubigeo != null){
            map_api.layer_ubigeo.remove();
        }
        //
        if( map_api.layer_ubigeo != null){
            map_api.layer_ubigeo.remove();
            map_api.clearLayerEtiquetasPeru(); 
        }
        // 
        var bd = $("#cbxBD").val();
        var ind = $("#cbxIndicador").val();
        var nvl = $("#cbxNivel").val();
        var anio = map_api.anio_id;
        var listaObjeto = $("#cbxObjeto").val();
        var frec = $("#cbxFrecuencia").val();
        var rango = $("#cbxPeriodo").val();

        // console.log(bd,ind,nvl,anio,listaObjeto,frec,rango);
        //
        if((bd!='0')&&(ind!='0')&&(nvl!='0')&&(frec!='0')&&(rango!='0')){
            map_api.enviarPeriodoMovil(bd,ind,nvl,listaObjeto,frec,rango);
            
        } else {
            $.notify({
                title: "ALERTA: ",
                message: "DEBE SELECCIONAR UN TEMA, SUB TEMA, NIVEL, FRECUENCIA Y RANGO DE TIEMPO PARA PODER CONSULTAR",
                icon: 'fa fa-exclamation-triangle' 
            },{
                type: "warning",
                z_index: 10310
            });
        }
    },

    limpiar2: function(){
        map_api.layer_ubigeo.remove();
        map_api.clearLayerEtiquetasPeru();
        $("#cbxPeriodo").html('');
        $('#divPeriodo').hide();
        $("#cbxFrecuencia").html('');
        $('#divFrecuencia').hide();
        $('#divMostrar').hide();
    },

    exportarReporte: function(){
    // Show loading
        $.LoadingOverlay("Show");
        // Filtros Reporte
        var bd = $("#cbxBD").val();
        var ind = $("#cbxIndicador").val();
        var nvl = $("#cbxNivel").val();
        var anio = map_api.anio_id;
        var listaObjeto = $("#cbxObjeto").val();
        // 
        if(listaObjeto.length>0){
            var valorObjeto = '';
            for (var i = 0; i<listaObjeto.length; i++){
                valorObjeto=valorObjeto+listaObjeto[i]+'-';
            }
            valorObjeto = valorObjeto.substring(0,valorObjeto.length-1);
        }
        // Data Reporte
        var filtro = {};
        filtro.id = bd;
        filtro.idsubtema = ind;
        filtro.idnivel = nvl;
        filtro.idanio = anio;
        filtro.idubigeo = valorObjeto; 

        $.post('main/validar_data_reporte', filtro, function (data) {
            if(data.resultado == 'true'){
                map_api.autoPostBlank('main/reporte_xls', filtro);                
                $.LoadingOverlay("hide");
            } else {
                $.LoadingOverlay("hide");
                msj.error('Mensaje','No hay información disponible');
            }
            
        });
    },

    autoPostBlank: function(url, param){
        var form = $('<form>');
        form.attr('target', '_blank');
        form.attr('enctype','multipart/form-data');
        form.attr('method', 'post');
        form.attr('action', url);
        $('body').append(form);
        param[this.tk_k] = this.tk_v;
        for(var key in param) {
            var val = param[key];
            if(typeof val != 'undefined'){
              var txtArea = document.createElement('textarea');
              $(txtArea).prop('name', key);
              txtArea.textContent = val;
              form.append($(txtArea));
            }
        }
        form.submit();
        form.remove();
    },

    cerrarModal: function(){
        $("#modalVideo").modal('hide');
    },
};
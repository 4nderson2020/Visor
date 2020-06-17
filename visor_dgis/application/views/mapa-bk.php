<div class="container-fluid p-2">

    <div class="row">
    <!-- ---------------------------------------------------------------------------------------------------------------------- -->
       
edavilas
<!-- ---------------------------------------------------------------------------------------------------------------------- -->
       sssssssssssss <div class="col-md-12 col-md-push-3 p-l-1" id="espacio">
            <div id="mapa"></div>
			
			<div style="z-index: 9999999;" id="controlDespl"></div>
			
			<div id="leyenda" class="card card-outline-success">
				<div class="card-header"  style="z-index: 999999">
					<h5 class="m-b-0 text-white"><b>LEYENDA:</b></h5>
				</div>
				<div class="card-body  p-1" style="z-index: 999999; background-color: white">
					<div class="card" style="z-index: 999999" id="print">
						<div class="contLeyenda"><div class="leyenda_1"></div> De <span id="leyenda_1_min">0</span> a <span id="leyenda_1_max">0</span></div>
						<div class="contLeyenda"><div class="leyenda_2"></div> De <span id="leyenda_2_min">0</span> a <span id="leyenda_2_max">0</span></div>
						<div class="contLeyenda"><div class="leyenda_3"></div> De <span id="leyenda_3_min">0</span> a <span id="leyenda_3_max">0</span></div>
						<div class="contLeyenda"><div class="leyenda_4"></div> De <span id="leyenda_4_min">0</span> a <span id="leyenda_4_max">0</span></div>
						<div class="contLeyenda"><div class="leyenda_5"></div> De <span id="leyenda_5_min">0</span> a <span id="leyenda_5_max">0</span></div>
					</div>
				</div>
			</div>  
        </div>

    </div>
</div>

<script src="assets/js/leaflet.js"></script>
<script src="assets/js/L.TileLayer.BetterWMS.js"></script>
<script src="assets/js/bundle.js"></script>
<script src="assets/js/mijs/map_api.js"></script>
<script src="assets/js/Leaflet.draw.js"></script> 

<script type="text/javascript">
	preCarga = function() {

		function initProject() {
			map_api.init();
			//
			localStorage.removeItem('arrayAnios');
			localStorage.removeItem('arrayPuntos');
			$('#divObjeto').hide();
			$('#divFrecuencia').hide();
			$('#divSemestre').hide();
			$('#resumen').hide();
			$('#detalle').hide();
			$('#controlDespl').hide();
			$('#leyenda').hide();
		}

		initProject();

		$(window).resize(function() {
			$('#mapa').css('width', '100%');
			$('#mapa').height($(window).height() - 30);
		});

		$(window).resize();

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

		$("#btnFiltrar").click( function(){
			map_api.filtrar();
		});

		var printer = L.easyPrint({
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
			title:'Imprimir Mapa',
			tileLayer: null,
			sizeModes: ['A4Landscape', 'A4Portrait'],
			defaultSizeTitles: {A4Landscape:'A4 Horizontal',A4Portrait:'A4 Vertical'},
			filename: 'Mapa',
			exportOnly: false,
			hideControlContainer: true
			}).addTo(map_api.map);


	   $('#cbxBD').change(function() {
			limpiarForm();
			map_api.get_indicadores($(this).val());
			//map_api.get_anio($(this).val());
			//
			var id = parseInt($(this).val());
            //
			if(id == 1){
				$('#divObjeto, #divFrecuencia, #divSemestre').hide();
			}else if(id == 2){
				$('#divObjeto, #divFrecuencia, #divSemestre').hide();
			}else if(id == 3){
				$('#divObjeto, #divFrecuencia, #divSemestre').hide();
			}else if(id == 4){
				$('#divObjeto, #divFrecuencia, #divSemestre').hide();
			}else if(id == 5){
				$('#divObjeto, #divFrecuencia, #divSemestre').hide();
			}else if(id == 6){
				$('#divObjeto, #divFrecuencia, #divSemestre').hide();
			}else if(id == 7){
				$('#divObjeto, #divFrecuencia, #divSemestre').hide();
			}else if(id == 8){
				$('#divObjeto, #divFrecuencia, #divSemestre').hide();
			}else if(id == 0){
				//Limpiamos los resultados del subtema
				$("#cbxIndicador").html('<option value="0">-- Seleccione --</option>');
				$("#cbxNivel").html('<option value="0">-- Seleccione --</option>');
				$("#cbxFrecuencia").html('<option value="0">-- Seleccione --</option>');
                $("#cbxSemestre").html('<option value="0">-- Seleccione --</option>');
				$("#cbxObjeto").html('');
				$(".selectpicker").selectpicker('refresh');
				$('#resumen').hide();
				$('#detalle').hide();
			}
			//
			$("#cbxIndicador").html('<option value="0">-- Seleccione --</option>');
			$("#cbxNivel").html('<option value="0">-- Seleccione --</option>');
			$("#cbxFrecuencia").html('<option value="0">-- Seleccione --</option>');
            $("#cbxSemestre").html('<option value="0">-- Seleccione --</option>');
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
			}else{
				$("#cbxObjeto").html('');
				$("#cbxNivel").html('<option value="0">-- Seleccione --</option>');
			}
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
				map_api.get_anio($iddb, $idindicador,$idnivel);
			}
			 else{
				$("#cbxObjeto").html('');
				$("#cbxFrecuencia").html('<option value="0">-- Seleccione --</option>');
			}
			$('#resumen').hide();
			$('#detalle').hide();
			//
            $('#divObjeto').show();
			//
			$("#cbxObjeto").html('');
			//
			$(".selectpicker").selectpicker('refresh');
			//
			$('#controlDespl').show();
		}); 

		$('#cbxFrecuencia').change(function(){
			var id = parseInt($(this).val());
			//
			if(id == 0 ){
				$('#divSemestre').hide();
			}else if(id == 1){
				$('#divSemestre').hide();
			}else if(id == 2){
				$('#divSemestre').show();
			}
			$('#resumen').hide();
			$('#detalle').hide();
			//
			$("#cbxObjeto").html('');
			//
			//
			$(".selectpicker").selectpicker('refresh'); 
		});

		function limpiarForm(){
			$('#cbxIndicador').val('0');
			$('#cbxNivel').val('0');
			$('#cbxObjeto').val('');
			$('#cbxFrecuencia').val('0');
			$('#cbxSemestre').val('0');
			$(".selectpicker").selectpicker('refresh');
		}
}
</script>
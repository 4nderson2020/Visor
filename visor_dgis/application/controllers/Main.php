<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('display_errors', 1);
ini_set('memory_limit', '-1');
set_time_limit(0);


class Main extends Sys_Controller {

	public $rgeo = 'http://admin:$4dm1n$@geoservicios_des.mininter.gob.pe:8080';

    function __construct()
    {   
        parent::__construct(); // Ejecuta Constructor del Padre(Clase CI_Controller - Framework)
        $this->load->model('Based_model','m_db');
        $this->load->model('Indicador_model','m_indicador');
        $this->load->model('Nivel_model','m_nivel');
        $this->load->model('Anio_model','m_anio');
        $this->load->model('Frecuencia_model','m_frecuencia');
        $this->load->model('Periodo_model', 'm_periodo');       
        $this->load->model('Objeto_model','m_ubigeo');
		$this->load->model('Leyenda_model','m_leyenda');
        $this->load->model('LeyendaPeriodo_model','m_leyendaperiodo');
        $this->load->model('Descripcion_model','m_descripcion');
        $this->load->model('Poblacion_model','m_poblacion');
        $this->load->model('Escala_model','m_escala');
        $this->load->model('Reporte_model','m_reporte');
    }

	public function index()	{  
        $data = array();
        //LLAMADA AL MODELO  m_db - Based_model
        $data['db'] = $this->m_db->get_base_datos();
        $this->sys_render('index',$data); //Ejecutamos index.php
	}

	public function geoserver_api(){
    	
    	$ruta= $this->rgeo.'/geoserver/BDIDEMI/wms?SERVICE='.$_GET['SERVICE'].
    	'&VERSION='.@$_GET['VERSION'].
    	'&REQUEST='.@$_GET['REQUEST'].
    	'&FORMAT='.@$_GET['FORMAT'].
    	((@$_GET['STYLES']!='')?('&STYLES='.@$_GET['STYLES']):'').
    	'&TRANSPARENT='.@$_GET['TRANSPARENT'].
    	//((@$_GET['CQL_FILTER']!='')?('&CQL_FILTER='.@$_GET['CQL_FILTER']):'').
    	((@$_GET['VIEWPARAMS']!='')?('&VIEWPARAMS='.@$_GET['VIEWPARAMS']):'').
    	'&LAYERS='.@$_GET['LAYERS'].
    	'&SRS='.@$_GET['SRS'].
    	'&WIDTH='.@$_GET['WIDTH'].
    	'&HEIGHT='.@$_GET['HEIGHT'].
    	'&MAXFEATURES='.@$_GET['MAXFEATURES'].
    	'&BBOX='.@$_GET['BBOX'];

    	echo file_get_contents($ruta);
        echo "$ruta";
    }

    public function json_peru(){

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/wms?service=WFS&version=1.0.0&request=GetFeature&typeName=BDIDEMI:vi_peru&outputFormat=application%2Fjson';

        $data = array();
        $data['peru'] = file_get_contents($ruta);
        
        $this->json_output($data);
    }

    public function json_departamentos(){

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=BDIDEMI:dgis_departamento&outputFormat=application%2Fjson';

        $data = array();
        $data['departamentos'] = file_get_contents($ruta);
        
        $this->json_output($data);
    }

    public function json_provincias(){

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=BDIDEMI:dgis_provincia&outputFormat=application%2Fjson';

        $data = array();
        $data['provincias'] = file_get_contents($ruta);
        
        $this->json_output($data);
    }

    public function json_distritos(){

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=BDIDEMI:dgis_distrito&outputFormat=application%2Fjson';

        $data = array();
        $data['distritos'] = file_get_contents($ruta);
        
        $this->json_output($data);
    }

    public function geo_limites(){

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/wms?service=WMS&version=1.1.0&request=GetMap&layers=BDIDEMI:dgis_limites_administrativos&styles=&bbox=-81.32823049,-18.350927736226,-68.6522791026984,-0.038605967999949&width=531&height=768&srs=EPSG:4326&format=image/png'; 

        echo file_get_contents($ruta);
        echo "$ruta";
    }

    public function json_comisarias(){

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/wms?service=WFS&version=1.0.0&request=GetFeature&typeName=BDIDEMI:vi_comisarias_peru&outputFormat=application%2Fjson';

        $data = array();
        $data['comisarias'] = file_get_contents($ruta);
        
        $this->json_output($data);
    }

    public function json_jurisdicciones_comisarias(){

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/wms?service=WFS&version=1.0.0&request=GetFeature&typeName=BDIDEMI:dgis_jurisdicciones&outputFormat=application%2Fjson';

        $data = array();
        $data['jcomisaria'] = file_get_contents($ruta);
        
        $this->json_output($data);
    }

    public function json_jurisdicciones_divpol(){

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/wms?service=WFS&version=1.0.0&request=GetFeature&typeName=BDIDEMI:dgis_jurisdicciones_total&outputFormat=application%2Fjson';

        $data = array();
        $data['jdivpol'] = file_get_contents($ruta);
        
        $this->json_output($data);
    }

    public function json_sectores(){

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/wms?service=WFS&version=1.0.0&request=GetFeature&typeName=BDIDEMI:dgis_sectores&outputFormat=application%2Fjson';

        $data = array();
        $data['sectores'] = file_get_contents($ruta);
        
        $this->json_output($data);
    }

    public function json_barrioSeguro(){

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/wms?service=WFS&version=1.0.0&request=GetFeature&typeName=BDIDEMI:dgis_barrio_seguro&outputFormat=application%2Fjson';

        $data = array();
        $data['barrio'] = file_get_contents($ruta);
        
        $this->json_output($data);
    }
	
	public function json_poligonos_visor(){
        $id = @$_POST['id'];
		$idsubtema = @$_POST['idsubtema'];
		$idnivel = @$_POST['idnivel'];
		$idanio = @$_POST['idanio'];
		$idubigeo = @$_POST['idubigeo'];

        $vparam = '';
        $url = '';

        if( !empty($id) ) {
            $vparam .= ($vparam!=''?';':'').'id:'.$id;
        }
		
		if( !empty($idsubtema) ) {
            $vparam .= ($vparam!=''?';':'').'idsubtema:'.$idsubtema;
        }
		
		if( !empty($idnivel) ) {
            $vparam .= ($vparam!=''?';':'').'idnivel:'.$idnivel;
        }
		
		if( !empty($idanio) ) {
            $vparam .= ($vparam!=''?';':'').'idanio:'.$idanio;
        }
		
		if( !empty($idubigeo) ) {
            $vparam .= ($vparam!=''?';':'').'idubigeo:'.$idubigeo;
        }

        if($vparam != ''){
            $url .= "&VIEWPARAMS=".$vparam;
        }

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=BDIDEMI:vi_poligono_visor&outputFormat=application%2Fjson'.$url;

        $data = array();
		$data['poligonos'] = file_get_contents($ruta);
		$data['leyenda'] = $this->m_leyenda->obtenerLeyenda($id,$idsubtema,$idnivel,$idanio)->result();
        
		$this->json_output($data);
    }

    public function json_valores_escala_visor(){
        $id = @$_POST['id'];
        $idsubtema = @$_POST['idsubtema'];
        $idnivel = @$_POST['idnivel'];
        $idanio = @$_POST['idanio'];
        $idubigeo = @$_POST['idubigeo'];

        $vparam = '';
        $url = '';

        if( !empty($id) ) {
            $vparam .= ($vparam!=''?';':'').'id:'.$id;
        }
        
        if( !empty($idsubtema) ) {
            $vparam .= ($vparam!=''?';':'').'idsubtema:'.$idsubtema;
        }
        
        if( !empty($idnivel) ) {
            $vparam .= ($vparam!=''?';':'').'idnivel:'.$idnivel;
        }
        
        if( !empty($idanio) ) {
            $vparam .= ($vparam!=''?';':'').'idanio:'.$idanio;
        }
        
        if( !empty($idubigeo) ) {
            $vparam .= ($vparam!=''?';':'').'idubigeo:'.$idubigeo;
        }

        if($vparam != ''){
            $url .= "&VIEWPARAMS=".$vparam;
        }

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=BDIDEMI:vi_valores_escala_visor&outputFormat=application%2Fjson'.$url;

        $data = array();
        $data['poligonos'] = file_get_contents($ruta);
        // $data['leyenda'] = $this->m_leyenda->obtenerLeyenda($id,$idsubtema,$idnivel,$idanio)->result();

        $this->json_output($data);
    }

    public function json_periodo_movil_visor(){
        $id = @$_POST['id'];
        $idsubtema = @$_POST['idsubtema'];
        $idnivel = @$_POST['idnivel'];
        $idanio = @$_POST['idanio'];
        $idubigeo = @$_POST['idubigeo'];
        $idfrecuencia = @$_POST['idfrecuencia'];
        $idrango = @$_POST['idrango'];

        $vparam = '';
        $url = '';

        if( !empty($id) ) {
            $vparam .= ($vparam!=''?';':'').'id:'.$id;
        }
        
        if( !empty($idsubtema) ) {
            $vparam .= ($vparam!=''?';':'').'idsubtema:'.$idsubtema;
        }
        
        if( !empty($idnivel) ) {
            $vparam .= ($vparam!=''?';':'').'idnivel:'.$idnivel;
        }
        
        if( !empty($idanio) ) {
            $vparam .= ($vparam!=''?';':'').'idanio:'.$idanio;
        }
        
        if( !empty($idubigeo) ) {
            $vparam .= ($vparam!=''?';':'').'idubigeo:'.$idubigeo;
        }

        if( !empty($idfrecuencia) ) {
            $vparam .= ($vparam!=''?';':'').'idfrecuencia:'.$idfrecuencia;
        }

        if( !empty($idrango) ) {
            $vparam .= ($vparam!=''?';':'').'idrango:'.$idrango;
        }

        if($vparam != ''){
            $url .= "&VIEWPARAMS=".$vparam;
        }

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=BDIDEMI:vi_periodo_movil_visor&outputFormat=application%2Fjson'.$url;

        $data = array();
        $data['poligonos'] = file_get_contents($ruta);
        $data['leyendaperiodo'] = $this->m_leyendaperiodo->obtenerLeyendaPeriodo($id,$idsubtema,$idnivel,$idanio,$idfrecuencia,$idrango)->result();

        $this->json_output($data);
    }

    public function get_indicadores(){
        $id_ind = $_POST['id'];

        $data = array();
        $data['indicadores'] = $this->m_indicador->get_indicadores($id_ind);

        $this->json_output($data);
    }

    public function get_nivel(){
        $id = $_POST['id'];
        $id_ind = $_POST['id_ind'];

        $data = array();
        $data['nivel'] = $this->m_nivel->get_nivel($id,$id_ind);

        $this->json_output($data);
    }

    public function get_anio(){
        $id = $_POST['id'];
        $id_ind = $_POST['id_ind'];
        $id_nivel = $_POST['id_nivel'];

        $data = array();
        $data['anio'] = $this->m_anio->get_anio($id,$id_ind,$id_nivel);

        $this->json_output($data);
    }

    public function get_frecuencia(){
        $id = $_POST['id'];
        $id_ind = $_POST['id_ind'];
        $id_nivel = $_POST['id_nivel'];

        $data = array();
        $data['frecuencia'] = $this->m_frecuencia->get_frecuencia($id,$id_ind,$id_nivel);

        $this->json_output($data);
    }

    public function get_periodo(){
        $id = $_POST['id'];
        $id_ind = $_POST['id_ind'];
        $id_nivel = $_POST['id_nivel'];
        $frecuencia_periodo = $_POST['frec_pe'];
        $id_anio = $_POST['id_anio'];

        $data = array();
        $data['periodo'] = $this->m_periodo->get_periodo($id,$id_ind,$id_nivel,$frecuencia_periodo,$id_anio);

        $this->json_output($data);
    }

    public function get_objeto(){
        $id = $_POST['id'];
        $idsubtema = $_POST['id_ind'];
        $idnivel = $_POST['id_niv'];
        $idanio = $_POST['id_anio'];

        $data = array();
        $data['objeto'] = $this->m_ubigeo->get_objeto($id,$idsubtema,$idnivel,$idanio);

        $this->json_output($data);
    }

    public function get_valores_escala(){

        $id = @$_POST['id'];
        $idsubtema = @$_POST['idsubtema'];
        $idnivel = @$_POST['idnivel'];
        $idanio = @$_POST['idanio'];
        $idubigeo = @$_POST['idubigeo'];

        $data = array();
        $data['escala'] = $this->m_escala->get_valores_escala($id,$idsubtema,$idnivel,$idanio,$idubigeo);

        $this->json_output($data);
    }

    public function get_descripcion(){
        $idfuente = $_POST['id'];

        $data = array();
        $data['descripcion'] = $this->m_descripcion->get_descripcion($idfuente);

        $this->json_output($data);
    }

    public function barChart(){
        $id = @$_GET['id'];
        $idsubtema = @$_GET['idsubtema'];
        $idnivel = @$_GET['idnivel'];
        $idanio = @$_GET['idanio'];
        $idubigeo = @$_GET['idubigeo'];

        $vparam = '';
        $url = '';

        if( !empty($id) ) {
            $vparam .= ($vparam!=''?';':'').'id:'.$id;
        }
        
        if( !empty($idsubtema) ) {
            $vparam .= ($vparam!=''?';':'').'idsubtema:'.$idsubtema;
        }
        
        if( !empty($idnivel) ) {
            $vparam .= ($vparam!=''?';':'').'idnivel:'.$idnivel;
        }
        
        if( !empty($idanio) ) {
            $vparam .= ($vparam!=''?';':'').'idanio:'.$idanio;
        }
        
        if( !empty($idubigeo) ) {
            $vparam .= ($vparam!=''?';':'').'idubigeo:'.$idubigeo;
        }

        if($vparam != ''){
            $url .= "&VIEWPARAMS=".$vparam;
        }

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=BDIDEMI:vi_barchart_visor&outputFormat=application%2Fjson'.$url;

        $data = array(); 
        $data['bar'] = file_get_contents($ruta);
        //
        $this->json_output($data);
    }

    public function pieChart(){
        $id = @$_GET['id'];
        $idsubtema = @$_GET['idsubtema'];
        $idnivel = @$_GET['idnivel'];
        $idanio = @$_GET['idanio'];
        $idubigeo = @$_GET['idubigeo'];

        $vparam = '';
        $url = '';

        if( !empty($id) ) {
            $vparam .= ($vparam!=''?';':'').'id:'.$id;
        }
        
        if( !empty($idsubtema) ) {
            $vparam .= ($vparam!=''?';':'').'idsubtema:'.$idsubtema;
        }
        
        if( !empty($idnivel) ) {
            $vparam .= ($vparam!=''?';':'').'idnivel:'.$idnivel;
        }
        
        if( !empty($idanio) ) {
            $vparam .= ($vparam!=''?';':'').'idanio:'.$idanio;
        }
        
        if( !empty($idubigeo) ) {
            $vparam .= ($vparam!=''?';':'').'idubigeo:'.$idubigeo;
        }

        if($vparam != ''){
            $url .= "&VIEWPARAMS=".$vparam;
        }

        $ruta = $this->rgeo.'/geoserver/BDIDEMI/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=BDIDEMI:vi_piechart_visor&outputFormat=application%2Fjson'.$url;

        // if (isset($_POST['ubigeo']) && !empty($_POST['ubigeo'])) {
        //     $ruta .= '&viewparams=ubigeo:'.$_POST['ubigeo'].'';
        // }
        $data = array(); 
        $data['pie'] = file_get_contents($ruta);
        //
        $this->json_output($data);
    }

    public function validar_data_reporte(){
        $id = @$_POST['id'];
        $idsubtema = @$_POST['idsubtema'];
        $idnivel = @$_POST['idnivel'];
        $idanio = @$_POST['idanio'];
        $idubigeo = @$_POST['idubigeo'];
        //
        // $arrayFiltros = array(
        //     'idfuente'=>$id,
        //     'idvariable'=>$idsubtema,
        //     'idnivel'=>$idnivel,
        //     'idanio'=>$idanio,
        //     'idubigeo'=>$idubigeo
        // );
        //
        // $dataReporte = $this->m_reporte->obtenerDataReporte($arrayFiltros)->result();
        //
        $dataReporte = array();

        if(($id!='0')&&($idsubtema!='0')&&($idnivel!='0')){
            if($id=='1'){
                if($idsubtema=='3'){
                    $dataReporte['reporte'] = $this->m_reporte->obtenerDataEscalar($id,$idsubtema,$idnivel,$idanio,$idubigeo)->result();

                }else{
                    $dataReporte['reporte'] = $this->m_reporte->obtenerDataReporte($id,$idsubtema,$idnivel,$idanio,$idubigeo)->result();
                }
            }else if($id=='2'){
                $dataReporte['reporte'] = $this->m_reporte->obtenerDataEscalar($id,$idsubtema,$idnivel,$idanio,$idubigeo)->result();       
            }else{
                $dataReporte['reporte'] = $this->m_reporte->obtenerDataReporte($id,$idsubtema,$idnivel,$idanio,$idubigeo)->result();
            }
        }

        if (count($dataReporte)> 0) {
            $data['resultado']="true";
            $data['registros']=count($dataReporte);
        } else {
            $data['resultado']="false";
            $data['registros']=count($dataReporte);
        }
        $this->json_output($data);
    }

    public function reporte_xls(){

        ini_set('memory_limit','2048M');
        set_time_limit(0);

        $id = @$_POST['id'];
        $idsubtema = @$_POST['idsubtema'];
        $idnivel = @$_POST['idnivel'];
        $idanio = @$_POST['idanio'];
        $idubigeo = @$_POST['idubigeo'];
        //
        // $arrayFiltros = array(
        //     'idfuente'=>$id,
        //     'idvariable'=>$idsubtema,
        //     'idnivel'=>$idnivel,
        //     'idanio'=>$idanio,
        //     'idubigeo'=>$idubigeo
        // );
        //
        if(($id!='0')&&($idsubtema!='0')&&($idnivel!='0')){
            
            if($id=='1'){
                if($idsubtema=='3'){
                    $dataReporte = $this->m_reporte->obtenerDataEscalar($id,$idsubtema,$idnivel,$idanio,$idubigeo)->result();
                }else{
                    $dataReporte = $this->m_reporte->obtenerDataReporte($id,$idsubtema,$idnivel,$idanio,$idubigeo)->result();
                }
            }else if($id=='2'){
                $dataReporte = $this->m_reporte->obtenerDataEscalar($id,$idsubtema,$idnivel,$idanio,$idubigeo)->result();       
            }else{
                $dataReporte = $this->m_reporte->obtenerDataReporte($id,$idsubtema,$idnivel,$idanio,$idubigeo)->result();
            }
        }
           // $dataReporte = $this->m_reporte->obtenerDataEscalar($id,$idsubtema,$idnivel,$idanio,$idubigeo)->result();
           $nombreReporte = 'Reporte Observatorio de Seguridad Ciudadana';
           $nombreHoja = 'Visor de Mapas';
           $nombreArchivo = 'consulta';
           $letraFinal = 'N';

        $this->load->library('PHPExcel/PHPExcel.php');
        $this->phpexcel->getProperties()->setCreator('Ministerio del Interior')->setLastModifiedBy('Ministerio del Interior')->setTitle($nombreReporte)->setCategory("DGIS");

        $styleLogo = new PHPExcel_Style();
        $styleLogo->applyFromArray(
        array('fill' =>
            array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '2f2f2f'),
            )
        ));
        
        $styleTitulo = new PHPExcel_Style();
        $styleTitulo->applyFromArray(
        array('fill' =>
            array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '2f2f2f'),
            ),
            'alignment' => array(
              'wrap' => false,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
            ),
            'font' => array(
              'bold' => true,
              'color' => array('rgb' => 'FFFFFF'),
              'size' => 20
            )
        ));
        
        $styleTablaGeneral = new PHPExcel_Style();
        $styleTablaGeneral->applyFromArray(
        array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        $styleTablaCabecera = new PHPExcel_Style();
        $styleTablaCabecera->applyFromArray(
        array('fill' =>
            array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '1FB5AD'),
            ),
            'alignment' =>
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font'  => 
            array(
                'bold'  => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size'  => 12,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        $styleResultado = new PHPExcel_Style();
        $styleResultado->applyFromArray(
        array('fill' =>
            array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => 'c7c7c7'),
            ),
            'font' => array(
              'bold' => true,
              'color' => array('rgb' => '000000')
            )
        ));
        
        $myWorkSheet = new PHPExcel_Worksheet($this->phpexcel, $nombreHoja);
        $this->phpexcel->addSheet($myWorkSheet, 1);
        $this->phpexcel->getSheet(1);
        $this->phpexcel->getActiveSheet(1);
        $this->phpexcel->setActiveSheetIndex(1);
        
        $this->phpexcel->getActiveSheet(1)->mergeCells("A1:".$letraFinal."1");
        $this->phpexcel->getActiveSheet(1)->setSharedStyle($styleLogo, "A1:".$letraFinal."1");
        $this->phpexcel->getActiveSheet(1)->getRowDimension('1')->setRowHeight(60);
        
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setPath('assets/images/logo-observatorio.png');
        $objDrawing->setHeight(70);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($this->phpexcel->getActiveSheet(1));
        
        $this->phpexcel->getActiveSheet(1)->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 3);
        $this->phpexcel->getActiveSheet(1)->SetCellValue("A2", $nombreHoja);
        $this->phpexcel->getActiveSheet(1)->mergeCells("A2:".$letraFinal."2");
        $this->phpexcel->getActiveSheet(1)->setSharedStyle($styleTitulo, "A2:".$letraFinal."2");
        
        $this->phpexcel->getActiveSheet(1)->mergeCells("A3:".$letraFinal."3");
        
        $fila='4';    

        if($id=='1'){
            if($idsubtema=='3'){
                $this->phpexcel->setActiveSheetIndex(1)->setCellValue("A".$fila, "N");
                $this->phpexcel->setActiveSheetIndex(1)->setCellValue("B".$fila, "CÓDIGO");
                $this->phpexcel->setActiveSheetIndex(1)->setCellValue("C".$fila, "DESCRIPCION");
                $this->phpexcel->setActiveSheetIndex(1)->setCellValue("D".$fila, "DEPARTAMENTO");
                $this->phpexcel->setActiveSheetIndex(1)->setCellValue("E".$fila, "PROVINCIA");
                $this->phpexcel->setActiveSheetIndex(1)->setCellValue("F".$fila, "DISTRITO");
                $this->phpexcel->setActiveSheetIndex(1)->setCellValue("G".$fila, "FUENTE");
                $this->phpexcel->setActiveSheetIndex(1)->setCellValue("H".$fila, "VARIABLE");
                $this->phpexcel->setActiveSheetIndex(1)->setCellValue("I".$fila, "NIVEL");
                $this->phpexcel->setActiveSheetIndex(1)->setCellValue("J".$fila, "AÑO");
                $this->phpexcel->setActiveSheetIndex(1)->setCellValue("K".$fila, "POBLACION");
                $this->phpexcel->setActiveSheetIndex(1)->setCellValue("L".$fila, "TIPO PATRULLAJE");
                $this->phpexcel->setActiveSheetIndex(1)->setCellValue("M".$fila, "VALOR");
                $this->phpexcel->setActiveSheetIndex(1)->setCellValue("N".$fila, "UNIDAD");        
        
                $this->phpexcel->getActiveSheet(1)->getRowDimension($fila)->setRowHeight(40);

            $i='0';
            foreach($dataReporte as $datos) { $fila ++; $i ++;
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("A".$fila, $i);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("B".$fila, $datos->codigo);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("C".$fila, $datos->descripcion);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("D".$fila, $datos->departamento);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("E".$fila, $datos->provincia);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("F".$fila, $datos->distrito);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("G".$fila, $datos->fuente);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("H".$fila, $datos->variable);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("I".$fila, $datos->nivel);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("J".$fila, $datos->anio);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("K".$fila, $datos->nro_hab);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("L".$fila, $datos->tipo);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("M".$fila, $datos->valor_medido);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("N".$fila, $datos->unidad);
            }
        }else{
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("A".$fila, "N");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("B".$fila, "CÓDIGO");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("C".$fila, "DESCRIPCION");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("D".$fila, "DEPARTAMENTO");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("E".$fila, "PROVINCIA");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("F".$fila, "DISTRITO");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("G".$fila, "FUENTE");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("H".$fila, "VARIABLE");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("I".$fila, "NIVEL");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("J".$fila, "AÑO");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("K".$fila, "POBLACION");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("L".$fila, "VALOR");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("M".$fila, "UNIDAD");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("N".$fila, "RANKING");
            
            $this->phpexcel->getActiveSheet(1)->getRowDimension($fila)->setRowHeight(40);

            $i='0';
            foreach($dataReporte as $datos) { $fila ++; $i ++;
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("A".$fila, $i);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("B".$fila, $datos->codigo);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("C".$fila, $datos->descripcion);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("D".$fila, $datos->departamento);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("E".$fila, $datos->provincia);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("F".$fila, $datos->distrito);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("G".$fila, $datos->fuente);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("H".$fila, $datos->variable);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("I".$fila, $datos->nivel);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("J".$fila, $datos->anio);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("K".$fila, $datos->nro_hab);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("L".$fila, $datos->valor_medido);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("M".$fila, $datos->unidad);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("N".$fila, $datos->orden_rank);
                }
            }
        }else if($id=='2'){
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("A".$fila, "N");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("B".$fila, "CÓDIGO");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("C".$fila, "DESCRIPCION");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("D".$fila, "DEPARTAMENTO");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("E".$fila, "PROVINCIA");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("F".$fila, "DISTRITO");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("G".$fila, "FUENTE");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("H".$fila, "VARIABLE");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("I".$fila, "NIVEL");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("J".$fila, "AÑO");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("K".$fila, "POBLACION");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("L".$fila, "NIVEL CONFIANZA");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("M".$fila, "VALOR");
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("N".$fila, "UNIDAD");        
            
            $this->phpexcel->getActiveSheet(1)->getRowDimension($fila)->setRowHeight(40);

            $i='0';
            foreach($dataReporte as $datos) { $fila ++; $i ++;
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("A".$fila, $i);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("B".$fila, $datos->codigo);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("C".$fila, $datos->descripcion);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("D".$fila, $datos->departamento);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("E".$fila, $datos->provincia);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("F".$fila, $datos->distrito);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("G".$fila, $datos->fuente);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("H".$fila, $datos->variable);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("I".$fila, $datos->nivel);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("J".$fila, $datos->anio);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("K".$fila, $datos->nro_hab);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("L".$fila, $datos->tipo);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("M".$fila, $datos->valor_medido);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("N".$fila, $datos->unidad);
            }       
        }else{
                   $this->phpexcel->setActiveSheetIndex(1)->setCellValue("A".$fila, "N");
        $this->phpexcel->setActiveSheetIndex(1)->setCellValue("B".$fila, "CÓDIGO");
        $this->phpexcel->setActiveSheetIndex(1)->setCellValue("C".$fila, "DESCRIPCION");
        $this->phpexcel->setActiveSheetIndex(1)->setCellValue("D".$fila, "DEPARTAMENTO");
        $this->phpexcel->setActiveSheetIndex(1)->setCellValue("E".$fila, "PROVINCIA");
        $this->phpexcel->setActiveSheetIndex(1)->setCellValue("F".$fila, "DISTRITO");
        $this->phpexcel->setActiveSheetIndex(1)->setCellValue("G".$fila, "FUENTE");
        $this->phpexcel->setActiveSheetIndex(1)->setCellValue("H".$fila, "VARIABLE");
        $this->phpexcel->setActiveSheetIndex(1)->setCellValue("I".$fila, "NIVEL");
        $this->phpexcel->setActiveSheetIndex(1)->setCellValue("J".$fila, "AÑO");
        $this->phpexcel->setActiveSheetIndex(1)->setCellValue("K".$fila, "POBLACION");
        $this->phpexcel->setActiveSheetIndex(1)->setCellValue("L".$fila, "VALOR");
        $this->phpexcel->setActiveSheetIndex(1)->setCellValue("M".$fila, "UNIDAD");
        $this->phpexcel->setActiveSheetIndex(1)->setCellValue("N".$fila, "RANKING");
        
        $this->phpexcel->getActiveSheet(1)->getRowDimension($fila)->setRowHeight(40);

        $i='0';
        foreach($dataReporte as $datos) { $fila ++; $i ++;
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("A".$fila, $i);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("B".$fila, $datos->codigo);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("C".$fila, $datos->descripcion);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("D".$fila, $datos->departamento);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("E".$fila, $datos->provincia);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("F".$fila, $datos->distrito);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("G".$fila, $datos->fuente);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("H".$fila, $datos->variable);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("I".$fila, $datos->nivel);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("J".$fila, $datos->anio);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("K".$fila, $datos->nro_hab);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("L".$fila, $datos->valor_medido);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("M".$fila, $datos->unidad);
            $this->phpexcel->setActiveSheetIndex(1)->setCellValue("N".$fila, $datos->orden_rank);
            }
        }    
        
        $column = 'A';
        for ($i=0; $i<12; $i++) {
            $this->phpexcel->getActiveSheet(1)->getColumnDimension($column)->setAutoSize(true);
            $column++;
        }        
        
        $limitPestaña='A4:'.$letraFinal.$fila;
        $this->phpexcel->getActiveSheet(1)->setSharedStyle($styleTablaGeneral, $limitPestaña);
        $this->phpexcel->getActiveSheet(1)->setSharedStyle($styleTablaCabecera, "A4:".$letraFinal."4");
        
        $sheetIndex = $this->phpexcel->getIndex($this->phpexcel->getSheetByName('Worksheet'));
        $this->phpexcel->removeSheetByIndex($sheetIndex);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="rpt_'.$nombreArchivo.'_'.@date('YmdHis').'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}
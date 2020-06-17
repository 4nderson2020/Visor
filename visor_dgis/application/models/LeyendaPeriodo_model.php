<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LeyendaPeriodo_model extends CI_Model{

    public function __construct(){
		parent::__construct();
    }
	
	public function obtenerLeyendaPeriodo($id_fuente,$id_variable,$id_nivel,$id_anio,$id_frecuencia,$id_periodo) {
		$sql = 'SELECT particion, minimo, maximo,tipo FROM sisvisordgismi.tm_leyenda
				WHERE id_fuente='.$id_fuente.' and id_variable='.$id_variable.' and id_nivel='.$id_nivel.' and id_anio='.$id_anio.' and frecuencia_periodo='.$id_frecuencia.' and id_periodo='.$id_periodo.' ';
        return $this->db->query($sql);
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poblacion_model extends CI_Model{

    public function __construct(){
		parent::__construct();
    }
	
	public function obtenerPoblacion($idfuente,$idvariable,$idnivel,$idanio) {
		$sql = 'SELECT * FROM sisvisordgismi.ufn_get_poblacion_visor('.$idfuente.','.$idvariable.','.$idnivel.','.$idanio.')';
        return $this->db->query($sql);
    }
}
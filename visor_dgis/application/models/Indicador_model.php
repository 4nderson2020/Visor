<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once 'Base_model.php';

class Indicador_model extends Base_model {
	
	function __construct() {
        parent::__construct('sisvisordgismi.tm_variable','id_variable');       
	}

    public function get_indicadores($id=''){

        $this->db->select('distinct(v.id_variable),v.nomb_variable,fv.orden_presentacion');
        $this->db->from('sisvisordgismi.tm_variable v');
        $this->db->join('sisvisordgismi.tt_valores_med u ', 'u.id_variable= v.id_variable ');
        $this->db->join('sisvisordgismi.tm_fuente f ', 'f.id_fuente= u.id_fuente ');
        $this->db->join('sisvisordgismi.tm_fuente_variable fv','fv.id_fuente=f.id_fuente and fv.id_variable=v.id_variable');
        $this->db->where('f.id_fuente = '.$id.'');
        $this->db->order_by('fv.orden_presentacion','asc');

        $query = $this->db->get();

        if($query){
            return $query->result_array();
        }else{
            return array();
        }
    }
}
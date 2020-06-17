<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once 'Base_model.php';

class Descripcion_model extends Base_model {
	
	function __construct() {
        parent::__construct('sisvisordgismi.tm_fuente','id_fuente'); 
	}

    public function get_descripcion($idfuente=''){

        $this->db->select('f.id_fuente, f.nomb_bd,f.descrip_bd,f.institucion_bd,f.alias_bd,f.fuente_bd,f.detalle_bd,min(an.anio),max(an.anio)');
        $this->db->from('sisvisordgismi.tm_fuente f');
        $this->db->join('sisvisordgismi.tt_valores_med vm ', 'vm.id_fuente=f.id_fuente');
        $this->db->join('sisvisordgismi.tm_anios an', 'an.id_anio=vm.id_anio');
        $this->db->where('f.id_fuente = '.$idfuente.'');
        $this->db->group_by('f.id_fuente, f.nomb_bd,f.descrip_bd,f.institucion_bd,f.alias_bd,f.fuente_bd,f.detalle_bd');

        $query = $this->db->get();

        // print_r($this->db->last_query());
        
        if($query){
            return $query->result_array();
        }else{
            return array();
        }
    }
}
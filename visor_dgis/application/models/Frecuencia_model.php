<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once 'Base_model.php';

class Frecuencia_model extends Base_model {
	
	function __construct() {
        parent::__construct('sisvisordgismi.tm_frecuencia','id_frecuencia');       
	}

    public function get_frecuencia($id='',$id_ind='',$id_nivel=''){

        $this->db->select('distinct(vmp.frecuencia_periodo),fr.nomb_frecuencia');
        $this->db->from('sisvisordgismi.tt_valores_med vm');
        $this->db->join('sisvisordgismi.tm_fuente f ', 'f.id_fuente= vm.id_fuente');
        $this->db->join('sisvisordgismi.tm_variable v ', 'v.id_variable= vm.id_variable');
        $this->db->join('sisvisordgismi.tm_nivel n ', 'n.id_nivel= vm.id_nivel');
        $this->db->join('sisvisordgismi.tt_valores_med_periodo vmp ', 'vmp.id_fuente=f.id_fuente and vmp.id_variable=v.id_variable and vmp.id_nivel=n.id_nivel');
        $this->db->join('sisvisordgismi.tm_frecuencia fr', 'fr.id_frecuencia=vmp.frecuencia_periodo');
        $this->db->where('f.id_fuente='.$id.' and v.id_variable='.$id_ind.' and n.id_nivel='.$id_nivel.'');

        $query = $this->db->get();

        if($query){
            return $query->result_array();
        }else{
            return array();
        }
    }
}
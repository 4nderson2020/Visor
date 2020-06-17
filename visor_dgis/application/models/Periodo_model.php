<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once 'Base_model.php';

class Periodo_model extends Base_model {
	
	function __construct() {
        parent::__construct('sisvisordgismi.tm_periodo','id_periodo');       
	}

    public function get_periodo($id='',$id_ind='',$id_nivel='',$frecuencia_periodo='',$id_anio=''){

        $this->db->select('distinct(pe.id_periodo),pe.nomb_periodo');
        $this->db->from('sisvisordgismi.tm_fuente f ');
        $this->db->join('sisvisordgismi.tt_valores_med vm ', 'f.id_fuente= vm.id_fuente');
        $this->db->join('sisvisordgismi.tm_variable v ', 'v.id_variable= vm.id_variable');
        $this->db->join('sisvisordgismi.tm_nivel n ', 'n.id_nivel= vm.id_nivel');
        $this->db->join('sisvisordgismi.tt_valores_med_periodo vmp ', 'vmp.id_fuente = vm.id_fuente and vmp.id_variable= vm.id_variable and vmp.id_nivel=vm.id_nivel and vmp.id_anio=vm.id_anio and vmp.id_frecuencia=vm.id_frecuencia and vmp.id_nute=vm.id_nute');
        $this->db->join('sisvisordgismi.tm_periodo pe ', 'pe.id_periodo=vmp.id_periodo');
        $this->db->join('sisvisordgismi.tm_frecuencia fr ', 'fr.id_frecuencia = vmp.frecuencia_periodo');
        $this->db->where('f.id_fuente='.$id.' and v.id_variable='.$id_ind.' and n.id_nivel='.$id_nivel.' and 
        vmp.frecuencia_periodo='.$frecuencia_periodo.' and pe.id_anio_ini='.$id_anio.'');
        $this->db->order_by('pe.id_periodo');

        $query = $this->db->get();

        if($query){
            return $query->result_array();
        }else{
            return array();
        }
    }
}
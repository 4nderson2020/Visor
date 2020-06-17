<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once 'Base_model.php';

class Escala_model extends Base_model {
	
	function __construct() {
        parent::__construct('sisvisordgismi.tm_escala_medida','id_escala_medida'); 
	}

    public function get_valores_escala($id='',$id_ind='',$id_nivel='',$id_anio='',$id_ubigeo=''){

        $this->db->select('e.nivel_escala,sum(a.valor_medido_escala) as valor');
        $this->db->from('sisvisordgismi.tt_valores_med_escala a');
        $this->db->join('sisvisordgismi.tm_escala_medida e','a.id_escala_medida=e.id_escala_medida'); 
        $ubigeo = "'".$id_ubigeo."'"; 
        $this->db->where('a.id_fuente= '.$id.' and a.id_variable = '.$id_ind.' and a.id_nivel = '.$id_nivel.' and a.id_anio= '.$id_anio.' and a.id_ubigeo='.$ubigeo.'');
        $this->db->group_by('a.id_ubigeo, a.id_escala_medida,e.nivel_escala, a.id_fuente, a.id_variable, a.id_nivel, a.id_anio');

        $query = $this->db->get();

        // print_r($this->db->last_query());
        
        if($query){
            return $query->result_array();
        }else{
            return array();
        }
    }
}
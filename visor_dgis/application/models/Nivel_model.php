<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once 'Base_model.php';

class Nivel_model extends Base_model {
	
	function __construct() {
        parent::__construct('sisvisordgismi.tm_nivel','id_nivel');    
	}

    public function get_nivel($id='',$id_ind=''){

        $this->db->select('distinct(n.id_nivel),n.orden_nivel,n.nomb_nivel');
        $this->db->from('sisvisordgismi.tm_nivel n');
        $this->db->join('sisvisordgismi.tt_valores_med u', 'u.id_nivel= n.id_nivel ');
        $this->db->join('sisvisordgismi.tm_fuente f ', 'f.id_fuente= u.id_fuente ');
        $this->db->join('sisvisordgismi.tm_variable v ', 'v.id_variable= u.id_variable'); 
        $estado = "estado_nivel=true";       
        $this->db->where('f.id_fuente = '.$id.' and v.id_variable='.$id_ind.' and '.$estado.'');
        $this->db->order_by('n.orden_nivel','asc');

        $query = $this->db->get();

        if($query){
            return $query->result_array();
        }else{
            return array();
        }
    }
}
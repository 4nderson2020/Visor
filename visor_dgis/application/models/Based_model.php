<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once 'Base_model.php';

class Based_model extends Base_model {
	
	function __construct() {
        parent::__construct('sisvisordgismi.tm_fuente','id_fuente'); 
	}

    public function get_base_datos(){

        $this->db->select('id_fuente, descrip_bd');
        $this->db->from($this->model_name); 
        $estado = "estadoimp_bd='avance'";
        $this->db->where($estado);
        $this->db->order_by('orden_bd', 'asc');

        $query = $this->db->get();

        // print_r($this->db->last_query());
        
        if($query){
            return $query->result_array();
        }else{
            return array();
        }
    }
}
<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once 'Base_model.php';

class Anio_model extends Base_model {
	
	function __construct() {
        parent::__construct('sisvisordgismi.tm_anios','id_anio'); 
        
	}

    public function get_anio($id='',$id_ind='',$id_nivel){
    
    $this->db->select('distinct(an.id_anio),an.anio');
    $this->db->from('sisvisordgismi.tm_anios an');
    $this->db->join('sisvisordgismi.tt_valores_med u', 'u.id_anio= an.id_anio');
    $this->db->join('sisvisordgismi.tm_fuente f ', 'f.id_fuente= u.id_fuente ');
	$this->db->where('f.id_fuente = '.$id.' AND u.id_variable='.$id_ind.' AND u.id_nivel='.$id_nivel.'');
    $this->db->order_by('an.id_anio','asc');

    $query = $this->db->get();

    if($query){
        return $query->result_array();
    }else{
        return array();
    }

    }
}
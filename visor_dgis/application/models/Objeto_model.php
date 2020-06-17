<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'Base_model.php';

class Objeto_model extends Base_model {
    
    function __construct() {
        parent::__construct('sisvisordgismi.tt_valores_med','id_ubigeo');   
    }

    public function get_objeto($iddb='',$idsubtema='',$idnivel='',$idanio=''){

        if( $idnivel == 2 || $idnivel == 6  ) //DPTO o REGN
        {
            $this->db->select('id_ubigeo,nomb_dpto as nombre,valor_medido');

        }else if ($idnivel == 3) //PROV
        {
            $this->db->select('id_ubigeo,nomb_prov as nombre,valor_medido');

        }else if ($idnivel == 4 || $idnivel == 7) //DIST
        {
            $this->db->select('id_ubigeo,nomb_dist as nombre,valor_medido');

        }else if ($idnivel == 5) //CDAD
        {
            $this->db->select('id_ubigeo,nomb_cdad as nombre,valor_medido');
        }

        $this->db->from('sisvisordgismi.tt_valores_med u');
        $this->db->join('sisvisordgismi.tm_ubigeo_inei ub', 'ub.id_ubigeo_dist=u.id_ubigeo');
        $this->db->where('id_fuente ='.$iddb.' and id_variable ='.$idsubtema.' and id_nivel ='.$idnivel.' and id_anio='.$idanio.' and ub.fnivel_pa <> 1');

        if ($idnivel == 5){
            $this->db->order_by('nomb_cdad','asc');
        }else{
            $this->db->order_by('id_ubigeo','asc');
        }        

        $query = $this->db->get();

        //print_r($this->db->last_query()); //Imprimir query para consultar en la bd

        if($query){
            return $query->result_array();
        }else{
            return array();
        }
    }   
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
 * @class Base_model
 * @param $model_name String , Almacena el nombre del modelo o entidad
 * @param $mode_id String , Almacena el nombre del campo identificador sin el prefijo "id_"
 * @param $columns , Almacena el nombre de las columnas a obtener
 * @param $order_by , almacena el campo o campos por el cual se ordenara el resultado
 * @param $order_asc , Almacena el orden de los resultados "asc" => ascendente o "desc" => descendente
 */
class Base_model extends CI_Model { 

    protected $model_name   = '';
    protected $model_id     = '';
    protected $columns      = '';
    protected $order_by     = '';
    protected $order_asc    = 'asc';

    /**
     * Function __construct , Constructor de clase
     * @param string $table_name , Nombre de la tabla
     * @param string $table_id , Identificador de la tabla sin el prefijo "id_"
     */
    function __construct($table, $id = null)
    {
        // Crea referencia a la clase de modelo padre base de Code Igniter
        parent::__construct();

        // Set values
        $this->model_name   = $table;
        $this->model_id     = $table . '.' . ( $id ? $id : $table );
        $this->columns      = $this->model_id;
        $this->order_by     = $this->model_id;
    }

    /**
     * Function setDefault , Modifica los valores por defecto de los valores de busqueda 
     * @param $default_params , valores de busqueda a modificar
     */
    protected function setDefault($default_params) 
    {
        // Obtenemos y generamos las variables para su facil uso
        extract($default_params);

        // Setea los nuevos valores
        $this->columns      = ($columns ? $columns: $this->columns);
        $this->order_by     = ($order_by ? $order_by: $this->order_by);
        $this->order_asc    = ($order_asc ? $order_asc: $this->order_asc); 
    }

    /**
     * Function _all , Obtiene todos los registros de la tabla o entidad
     * @param $columns , Columnas a obtener
     * @param $order_by , Campo o campos a ordenar
     * @param $order_asc , Forma de ordenamiento
     */
    function _all($columns = null, $order_by = null, $order_asc = null, $pag_ini = null, $pag_end = null)
    {
        // Setea los nuevos valores enviados
        $this->setDefault(compact('columns', 'order_by', 'order_asc'));

        // Genera la consulta
        $this->db->select($this->columns);
        $this->db->order_by($this->order_by, $this->order_asc);

        // Obtiene los resultados
        $result = $this->db->get($this->model_name, $pag_ini, $pag_end)->result_array();
        
        return $result;
        // $variab = $this->db->get($this->model_name, $pag_ini, $pag_end)->result_array();

        // print_r($this->db->last_query());
        // return $variab;
    }

    /**
     * Function _all , Obtiene todos los registros de la tabla o entidad
     * @param $columns , Columnas a obtener
     * @param $order_by , Campo o campos a ordenar
     * @param $order_asc , Forma de ordenamiento
     */
    function _all_by_id($id_row, $columns = null, $order_by = null, $order_asc = null, $pag_ini = null, $pag_end = null)
    {
        // Setea los nuevos valores enviados
        $this->setDefault(compact('columns', 'order_by', 'order_asc'));

        // Genera la consulta
        $this->db->select($this->columns);
        $this->db->where($this->model_id, $id_row);
        $this->db->order_by($this->order_by, $this->order_asc);

        $result = $this->db->get($this->model_name, $pag_ini, $pag_end)->result_array();
        
        return $result;

    }

    /**
     * Function _get , Obtiene un registro de la tabla o entidad
     * @param $id_row , CĆ³digo identificador del registro
     * @param $columns , Columnas a obtener
     * @param $order_by , Campo o campos a ordenar
     * @param $order_asc , Forma de ordenamiento
     */
    function _get($id_row, $columns = null, $order_by = null, $order_asc = null) {

        $this->setDefault(compact('columns', 'order_by', 'order_asc'));
        if ($this->db->conn_id === FALSE)
        {
            sleep(1);
            $this->db->reconnect();
        }

        $this->db->select($this->columns);
        $this->db->where($this->model_id, $id_row);   
        $result = $this->db->get($this->model_name);            
        return $result->row_array();    
    }

    /**
     * Function _getSimple , Obtiene un registro de la tabla o entidad
     * @param $columns , Columnas a obtener
     * @param $order_by , Campo o campos a ordenar
     * @param $order_asc , Forma de ordenamiento
     */
    function _getSimple($columns = null, $order_by = null, $order_asc = null) {

        $this->setDefault(compact('columns', 'order_by', 'order_asc'));

        $this->db->select($this->columns);    
  
        $result = $this->db->get($this->model_name)->row_array(); 
        
        return $result;
    }

    /**
     * Function _add , Ingresa un registro a la tabla o entidad
     * @param $data , Registros a ingresar basado en las columnas de la tabla o entidad
     * @param $hide , Columnas a no ser consideradas
     * @param $time_stamp , Indica si la tabla tiene columnas de fechas de ingreso y modificacion
     */
    function _add($data = array(), $hide = array(), $time_stamp = true) 
    {
        if ($this->db->conn_id === FALSE)
        {
            sleep(1);
            $this->db->reconnect();
        }

        // Almacena los valores reales a ingresar
        $data_insert = array();

        // Verifica se han enviado datos para ingresar
        if (count($data)) 
        {
            // Recorre los datos enviados
            foreach ($data as $dataKey => $dataValue) 
            {
                // Verifica que la columna no este dentro de las columnas a no ser consideradas
                if (!in_array($dataKey, $hide)) 
                {
                    $data_insert[$dataKey] = trim($dataValue);
                }
            }
        }  

        // Verifica si hay datos a enviar
        if ( count($data_insert) ) 
        {
            // Verifica si se ha indicado el ingreso de columnas de fechas de ingreso y modificacion
            if ( $time_stamp )
            {
                $data_insert['fechareg'] = date('Y-m-d H:i:s');
                $data_insert['fechamod'] = date('Y-m-d H:i:s');    
            }

            // Ingresa el registro a la base de datos
            $this->db->insert($this->model_name, $data_insert);    
        }

        // Obtiene las filas afectadas por efecto de la consulta
        $afected = $this->db->affected_rows();

        // Obtiene el resultado de la consulta
        return ($afected > 0 ? $afected : false);
    }

    /**
     * Function _update , Actualiza un registro a la tabla o entidad
     * @param $id_row , CĆ³digo identificador del registro
     * @param $data , Registros a ingresar basado en las columnas de la tabla o entidad
     * @param $hide , Columnas a no ser consideradas
     * @param $time_stamp , Indica si la tabla tiene columnas de fechas de ingreso y modificacion
     */
    function _update($id_row, $data = array(), $hide = array(), $time_stamp = true) 
    {
        if ($this->db->conn_id === FALSE)
        {
            sleep(1);
            $this->db->reconnect();
        }

        // Almacena los valores reales a ingresar
        $data_update = array();

        // Verifica se han enviado datos para ingresar
        if (count($data)) 
        {
            // Recorre los datos enviados
            foreach ($data as $dataKey => $dataValue) 
            {
                // Verifica que la columna no este dentro de las columnas a no ser consideradas
                if (!in_array($dataKey, $hide)) 
                {
                    $data_update[$dataKey] = trim($dataValue);
                }
            }
        }

        // Verifica si hay datos a enviar
        if (count($data_update)) 
        {   
            // Verifica si se ha indicado el ingreso de columnas de fechas de ingreso y modificacion
            if ( $time_stamp )
            {
                $data_update['fechamod'] = date('Y-m-d H:i:s');  
            }

            // Ingresa el registro a la base de datos
            $this->db->where($this->model_id, $id_row);
            $this->db->update($this->model_name, $data_update); 
        }

        // Obtiene las filas afectadas por efecto de la consulta
        $afected = $this->db->affected_rows();

        // Obtiene el resultado de la consulta
        return ($afected > 0 ? $id_row: false);
    }

    /**
     * Function _delete , Elimina un registro a la tabla o entidad
     * @param $id_row , CĆ³digo identificador del registro
     */
    function _delete($id_row) 
    {
        if ($this->db->conn_id === FALSE)
        {
            sleep(1);
            $this->db->reconnect();
        }
        
        // Elimina el registro a la base de datos
        $data_update = array();
        $data_update['fechaeli'] = date('Y-m-d H:i:s'); 
        $this->db->where($this->model_id, $id_row);   
        $this->db->update($this->model_name, $data_update);    
        
        // Obtiene las filas afectadas por efecto de la consulta
        $afected = $this->db->affected_rows();

        // Obtiene el resultado de la consulta
        return ($afected > 0 ? true: false);
    }

    protected function _tbl_ruta($fecha = ''){
        $tbl = '';
        if($fecha == @date('d/m/Y')){
            $tbl = 'th_ruta_sync';
        }else{
            $tbl = 'th_ruta_sync_his';
        }
        return $tbl;
    }

    protected function _fn_exec($db_object, $binds){      
        $data = FALSE;  
        if ($this->db->conn_id) {
            $this->db->trans_start();
            try{
                $this->db->query("BEGIN;");
                $num_params = count($binds);
                $list_params = '';

                for($i=1;$i<=$num_params;$i++){
                    $list_params.=($list_params!=''?',':'').'?::text';
                }

                $query = 'SELECT '.$db_object.'('.$list_params.') as scur;';
                $tr=$this->db->query($query,$binds);
                $r=$tr->row_array();            
                $name=$r['scur'];
                $rs=$this->db->query("FETCH ALL IN \"" . $name . "\";");
                
                if($rs){
                    $data = $rs->result_array();
                }
                $rs=$this->db->query("CLOSE \"" . $name . "\";");
                $this->db->query("END;");
            }catch(Exception $ex){}
            $this->db->trans_complete();
        }
        return $data;
    }
}
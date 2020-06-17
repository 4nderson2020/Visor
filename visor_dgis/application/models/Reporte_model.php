<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_model extends Base_model{

    public function __construct(){
		parent::__construct('sisvisordgismi.tm_fuente');
    }

    // public function obtenerDataReporte($id='',$id_ind='',$id_nivel='',$id_anio='',$id_ubigeo='') {

      // if($id_ubigeo == null ){

      // $sql = 'SELECT * FROM sisvisordgismi.ufn_reporte_visor(\''.$id.'\',\''.$id_ind.'\',\''.$id_nivel.'\',\''.$id_anio.'\',null)';
      // echo $sql;
      // }else{
      // $sql = 'SELECT * FROM sisvisordgismi.ufn_reporte_visor(\''.$id.'\',\''.$id_ind.'\',\''.$id_nivel.'\',\''.$id_anio.'\',\''.$id_ubigeo.'\')';
      // echo $sql;
      // } 
      // $data = $this->db->query($sql); 
      // return $data; 

      //   $variables = array();
      //   $variables[0] = $id;
      //   $variables[1] = $id_ind;
      //   $variables[2] = $id_nivel;
      //   $variables[3] = $id_anio;
      //   $variables[4] = $id_ubigeo;

      // $data = $this->_fn_exec("sisvisordgismi.ufn_reporte_visor",$variables);
      
      // // print_r($data);
      //   if(@$data){
      //       return $data;
      //   }else{
      //       return array();
      //   }

//     public function obtenerDataReporte($id,$id_ind,$id_nivel,$id_anio,$id_ubigeo) {

//     $sql = 'SELECT DISTINCT poligonos.codigo, poligonos.descripcion,
//             poligonos.departamento, poligonos.provincia, poligonos.distrito,
//             poligonos.id_fuente, poligonos.fuente,
//             poligonos.id_variable, poligonos.variable,
//             poligonos.id_unidad_medida, poligonos.medida, poligonos.unidad,
//             poligonos.id_nivel, poligonos.nivel,
//             poligonos.id_anio, poligonos.anio,
//             poligonos.valor_medido, poligonos.poblacion,
//             rank.orden_rank::integer, rank.total_rank::integer
//             FROM
//             (SELECT DISTINCT
//             ub.id_ubigeo_dist::text AS codigo,
//             CASE 
//             WHEN v.id_nivel=2 THEN ub.nomb_dpto::text
//             WHEN v.id_nivel=3 THEN ub.nomb_prov::text
//             WHEN v.id_nivel=4 THEN ub.nomb_dist::text
//             WHEN v.id_nivel=5 THEN ub.nomb_cdad::text
//             WHEN v.id_nivel=6 THEN ub.nomb_dpto::text
//             WHEN v.id_nivel=7 THEN ub.nomb_dist::text
//             END AS descripcion,
//             ub.nomb_dpto::text AS departamento,
//             ub.nomb_prov::text AS provincia,
//             ub.nomb_dist::text AS distrito,
//             v.id_fuente::integer,
//             fu.descrip_bd::text AS fuente,
//             v.id_variable::integer,
//             va.nomb_variable::text AS variable,
//             un.id_unidad_medida::integer,
//             un.nomb_unidad_medida::text AS medida,
//             un.etq_unidad_medida::text AS unidad,
//             v.id_nivel::integer,
//             ni.nomb_nivel::text AS nivel,
//             v.id_anio::integer,
//             an.anio::text AS anio,
//             v.valor_medido::numeric,
//             case when po.poblacion is not null then po.poblacion::integer else 0 end AS poblacion
//             FROM sisvisordgismi.tt_valores_med v
//             JOIN sisvisordgismi.tm_ubigeo_inei ub on v.id_ubigeo = ub.id_ubigeo_dist
//             JOIN sisvisordgismi.tm_fuente fu on v.id_fuente = fu.id_fuente
//             JOIN sisvisordgismi.tm_variable va on v.id_variable = va.id_variable
//             JOIN sisvisordgismi.tm_unidad_medida un on un.id_unidad_medida = va.id_unidad_medida
//             JOIN sisvisordgismi.tm_nivel ni on v.id_nivel = ni.id_nivel
//             JOIN sisvisordgismi.tm_anios an on v.id_anio = an.id_anio
//             LEFT JOIN sisvisordgismi.tm_poblacion po on v.id_ubigeo = po.id_ubigeo and v.id_anio = po.id_anio
//             JOIN sisvisordgismi.tg_n2pe00 g on g.id_n2pe00 = ub.ubigeo_inei_dpto
//             WHERE 1=1 and v.id_fuente = \''.$id.'\' and v.id_variable =\''.$id_ind.'\' and v.id_nivel =\''.$id_nivel.'\' and v.id_anio =\''.$id_anio.'\'';
// // isset($variable);
//             if($id_ubigeo <> null ){
//               $sql .= ' and v.id_ubigeo in (select regexp_split_to_table(\''.$id_ubigeo.'\',\''-'\'))';
//             }
             
//             $sql .= ')poligonos JOIN (SELECT DISTINCT id_fuente, id_variable, id_nivel, id_anio, id_ubigeo::text, valor_medido,
//             ROW_NUMBER() OVER(PARTITION BY id_fuente, id_variable, id_nivel, id_anio ORDER BY valor_medido DESC) as orden_rank,
//             COUNT(*) OVER(PARTITION BY id_fuente, id_variable, id_nivel, id_anio) as total_rank
//             FROM sisvisordgismi.tt_valores_med
//             WHERE id_fuente=\''.$id.'\' and id_variable=\''.$id_ind.'\' and id_nivel=\''.$id_nivel.'\' and id_anio=\''.$id_anio.'\') rank 
//             on poligonos.id_fuente=rank.id_fuente and poligonos.id_variable=rank.id_variable 
//             and poligonos.id_nivel=rank.id_nivel and poligonos.id_anio=rank.id_anio
//             and poligonos.codigo=rank.id_ubigeo';
//             // 
//             // echo $sql;
//         return $this->db->query($sql);
//     }

    public function obtenerDataReporte($id='',$id_ind='',$id_nivel='',$id_anio='',$id_ubigeo='') {

    $sql = 'SELECT DISTINCT poligonos.codigo, poligonos.descripcion,
            poligonos.departamento, poligonos.provincia, poligonos.distrito,
            poligonos.id_fuente, poligonos.fuente, poligonos.institucion,
            poligonos.id_variable, poligonos.variable,
            poligonos.id_unidad_medida, poligonos.medida, poligonos.unidad,
            poligonos.id_nivel, poligonos.nivel,
            poligonos.id_anio, poligonos.anio,
            poligonos.valor_medido, to_char(poligonos.poblacion,\'999G999G999\') as nro_hab,
            rank.orden_rank::integer, rank.total_rank::integer
            FROM
            (SELECT DISTINCT
            ub.id_ubigeo_dist::text AS codigo,
            CASE 
            WHEN v.id_nivel=2 THEN ub.nomb_dpto::text
            WHEN v.id_nivel=3 THEN ub.nomb_prov::text
            WHEN v.id_nivel=4 THEN ub.nomb_dist::text
            WHEN v.id_nivel=5 THEN ub.nomb_cdad::text
            WHEN v.id_nivel=6 THEN ub.nomb_dpto::text
            WHEN v.id_nivel=7 THEN ub.nomb_dist::text
            END AS descripcion,
            ub.nomb_dpto::text AS departamento,
            ub.nomb_prov::text AS provincia,
            ub.nomb_dist::text AS distrito,
            v.id_fuente::integer,
            fu.descrip_bd::text AS fuente,
            fu.institucion_bd:: text AS institucion,
            v.id_variable::integer,
            va.nomb_variable::text AS variable,
            un.id_unidad_medida::integer,
            un.nomb_unidad_medida::text AS medida,
            un.etq_unidad_medida::text AS unidad,
            v.id_nivel::integer,
            ni.nomb_nivel::text AS nivel,
            v.id_anio::integer,
            an.anio::text AS anio,
            v.valor_medido::numeric,
            CASE 
            WHEN v.id_nivel=2 THEN po.poblacion_dpto::integer
            WHEN v.id_nivel=3 THEN po.poblacion_prov::integer
            WHEN v.id_nivel=4 THEN po.poblacion_dist::integer
            WHEN v.id_nivel=5 THEN po.poblacion_dist::integer
            WHEN v.id_nivel=6 AND ub.id_ubigeo_dist =\'990001\' THEN po.poblacion_dist::integer
            WHEN v.id_nivel=6 AND ub.id_ubigeo_dist =\'990002\' THEN po.poblacion_dist::integer
            WHEN v.id_nivel=6 AND ub.id_ubigeo_dist <>\'99%\' THEN po.poblacion_dpto::integer
            WHEN v.id_nivel=7 THEN po.poblacion_dist::integer
            END AS poblacion
            FROM sisvisordgismi.tt_valores_med v
            JOIN sisvisordgismi.tm_ubigeo_inei ub on v.id_ubigeo = ub.id_ubigeo_dist
            JOIN sisvisordgismi.tm_fuente fu on v.id_fuente = fu.id_fuente
            JOIN sisvisordgismi.tm_variable va on v.id_variable = va.id_variable
            JOIN sisvisordgismi.tm_unidad_medida un on un.id_unidad_medida = va.id_unidad_medida
            JOIN sisvisordgismi.tm_nivel ni on v.id_nivel = ni.id_nivel
            JOIN sisvisordgismi.tm_anios an on v.id_anio = an.id_anio
            LEFT JOIN sisvisordgismi.uvw_total_poblacion po on 
            CASE 
            WHEN v.id_nivel=2 THEN po.ubigeo_inei_dpto::text
            WHEN v.id_nivel=3 THEN po.ubigeo_inei_prov::text
            WHEN v.id_nivel=4 THEN po.id_ubigeo_dist::text
            WHEN v.id_nivel=5 THEN po.id_ubigeo_dist::text
            WHEN v.id_nivel=6 AND ub.id_ubigeo_dist =\'990001\' THEN po.id_ubigeo_dist::text
            WHEN v.id_nivel=6 AND ub.id_ubigeo_dist =\'990002\' THEN po.id_ubigeo_dist::text
            WHEN v.id_nivel=6 AND ub.id_ubigeo_dist<>\'99%\' THEN po.ubigeo_inei_dpto::text
            WHEN v.id_nivel=7 THEN po.id_ubigeo_dist::text
            END =v.id_ubigeo 
            and v.id_anio = po.id_anio';

            if( $id_nivel==2){
            $sql .= ' JOIN sisvisordgismi.tg_n2pe00 g on g.id_n2pe00 = ub.ubigeo_inei_dpto';
            }
            else if( $id_nivel==3){
            $sql .= ' JOIN sisvisordgismi.tg_n3pe02 g on g.id_n3pe02 = ub.ubigeo_inei_prov';
            }
            else if( $id_nivel==4){
            $sql .= ' JOIN sisvisordgismi.tg_n4pe08 g on g.id_n4pe08 = ub.id_ubigeo_dist';
            }
            else if( $id_nivel==5){
            $sql .= ' JOIN sisvisordgismi.tg_n4pe08_cdad28_pl g on g.id_n4pe08_cdad_pl = ub.id_ubigeo_dist';
            }
            else if( $id_nivel==6){
            $sql .= ' JOIN sisvisordgismi.tg_n2pe00_lpd g on rpad(g.id_geo::text, 6, \'0000\'::text) = ub.id_ubigeo_dist::text';
            }
            else if( $id_nivel==7){
            $sql .= ' JOIN sisvisordgismi.uvw_g_enevic_totvar_dist_lyc g on g.id_ubigeo_dist = ub.id_ubigeo_dist::text';
            }

            $sql .= ' WHERE 1=1 and v.id_fuente = '.$id.' and v.id_variable ='.$id_ind.' and v.id_nivel ='.$id_nivel.' and v.id_anio ='.$id_anio.'';

            if($id_ubigeo <> null ){
              $sql .= ' and v.id_ubigeo in (select regexp_split_to_table(\''.$id_ubigeo.'\',\'-\'))';
            }
             
            $sql .= ' GROUP BY ub.id_ubigeo_dist,v.id_nivel,v.id_fuente,fu.descrip_bd,fu.institucion_bd,v.id_variable,
            va.nomb_variable,un.id_unidad_medida,un.nomb_unidad_medida,un.etq_unidad_medida,ni.nomb_nivel,v.id_anio,an.anio,
            v.valor_medido,po.poblacion_dpto,po.poblacion_prov,po.poblacion_dist)poligonos JOIN (SELECT DISTINCT id_fuente, id_variable, id_nivel, id_anio, id_ubigeo::text, valor_medido,
            ROW_NUMBER() OVER(PARTITION BY id_fuente, id_variable, id_nivel, id_anio ORDER BY valor_medido DESC) as orden_rank,
            COUNT(*) OVER(PARTITION BY id_fuente, id_variable, id_nivel, id_anio) as total_rank
            FROM sisvisordgismi.tt_valores_med
            WHERE id_fuente=\''.$id.'\' and id_variable=\''.$id_ind.'\' and id_nivel=\''.$id_nivel.'\' and id_anio=\''.$id_anio.'\') rank 
            on poligonos.id_fuente=rank.id_fuente and poligonos.id_variable=rank.id_variable 
            and poligonos.id_nivel=rank.id_nivel and poligonos.id_anio=rank.id_anio
            and poligonos.codigo=rank.id_ubigeo';
            // 
            // echo $sql;
        return $this->db->query($sql);
    }

    public function obtenerDataEscalar($id='',$id_ind='',$id_nivel='',$id_anio='',$id_ubigeo='') {

    $sql = 'SELECT DISTINCT poligonos.codigo, poligonos.descripcion,
    poligonos.departamento, poligonos.provincia, poligonos.distrito,
    poligonos.id_fuente, poligonos.fuente, poligonos.institucion,
    poligonos.id_variable, poligonos.variable,
    poligonos.id_unidad_medida, poligonos.medida, poligonos.unidad,
    poligonos.id_nivel, poligonos.nivel,
    poligonos.id_anio, poligonos.anio,
    poligonos.tipo, poligonos.valor_medido,
    to_char(poligonos.poblacion,\'999G999G999\') as nro_hab
    FROM
    (SELECT DISTINCT
    ub.id_ubigeo_dist::text AS codigo,
    CASE 
    WHEN v.id_nivel=2 THEN ub.nomb_dpto::text
    WHEN v.id_nivel=3 THEN ub.nomb_prov::text
    WHEN v.id_nivel=4 THEN ub.nomb_dist::text
    WHEN v.id_nivel=5 THEN ub.nomb_cdad::text
    WHEN v.id_nivel=6 THEN ub.nomb_dpto::text
    WHEN v.id_nivel=7 THEN ub.nomb_dist::text
    END AS descripcion,
    ub.nomb_dpto::text AS departamento,
    ub.nomb_prov::text AS provincia,
    ub.nomb_dist::text AS distrito,
    v.id_fuente::integer,
    fu.descrip_bd::text AS fuente,
    fu.institucion_bd:: text AS institucion,
    v.id_variable::integer,
    va.nomb_variable::text AS variable,
    un.id_unidad_medida::integer,
    un.nomb_unidad_medida::text AS medida,
    un.etq_unidad_medida::text AS unidad,
    v.id_nivel::integer,
    ni.nomb_nivel::text AS nivel,
    v.id_anio::integer,
    an.anio::text AS anio,
    esc.nivel_escala::text AS tipo,
    v.valor_medido_escala::numeric AS valor_medido,
    CASE 
    WHEN v.id_nivel=2 THEN po.poblacion_dpto::integer
    WHEN v.id_nivel=3 THEN po.poblacion_prov::integer
    WHEN v.id_nivel=4 THEN po.poblacion_dist::integer
    WHEN v.id_nivel=5 THEN po.poblacion_dist::integer
    WHEN v.id_nivel=6 AND ub.id_ubigeo_dist =\'990001\' THEN po.poblacion_dist::integer
    WHEN v.id_nivel=6 AND ub.id_ubigeo_dist =\'990002\' THEN po.poblacion_dist::integer
    WHEN v.id_nivel=6 AND ub.id_ubigeo_dist <>\'99%\' THEN po.poblacion_dpto::integer
    WHEN v.id_nivel=7 THEN po.poblacion_dist::integer
    END AS poblacion
    FROM sisvisordgismi.tt_valores_med_escala v
    JOIN sisvisordgismi.tm_ubigeo_inei ub on v.id_ubigeo = ub.id_ubigeo_dist
    JOIN sisvisordgismi.tm_fuente fu on v.id_fuente = fu.id_fuente
    JOIN sisvisordgismi.tm_variable va on v.id_variable = va.id_variable
    JOIN sisvisordgismi.tm_unidad_medida un on un.id_unidad_medida = va.id_unidad_medida
    JOIN sisvisordgismi.tm_nivel ni on v.id_nivel = ni.id_nivel
    JOIN sisvisordgismi.tm_anios an on v.id_anio = an.id_anio
    JOIN sisvisordgismi.tm_escala_medida esc on esc.id_escala_medida=v.id_escala_medida
    LEFT JOIN sisvisordgismi.uvw_total_poblacion po on 
    CASE 
    WHEN v.id_nivel=2 THEN po.ubigeo_inei_dpto::text
    WHEN v.id_nivel=3 THEN po.ubigeo_inei_prov::text
    WHEN v.id_nivel=4 THEN po.id_ubigeo_dist::text
    WHEN v.id_nivel=5 THEN po.id_ubigeo_dist::text
    WHEN v.id_nivel=6 AND ub.id_ubigeo_dist =\'990001\' THEN po.id_ubigeo_dist::text
    WHEN v.id_nivel=6 AND ub.id_ubigeo_dist =\'990002\' THEN po.id_ubigeo_dist::text
    WHEN v.id_nivel=6 AND ub.id_ubigeo_dist<>\'99%\' THEN po.ubigeo_inei_dpto::text
    WHEN v.id_nivel=7 THEN po.id_ubigeo_dist::text
    END =v.id_ubigeo 
    and v.id_anio = po.id_anio ';

    if( $id_nivel==2){
    $sql .= ' JOIN sisvisordgismi.tg_n2pe00 g on g.id_n2pe00 = ub.ubigeo_inei_dpto';
    }
    else if( $id_nivel==3){
    $sql .= ' JOIN sisvisordgismi.tg_n3pe02 g on g.id_n3pe02 = ub.ubigeo_inei_prov';
    }
    else if( $id_nivel==4){
    $sql .= ' JOIN sisvisordgismi.tg_n4pe08 g on g.id_n4pe08 = ub.id_ubigeo_dist';
    }
    else if( $id_nivel==5){
    $sql .= ' JOIN sisvisordgismi.tg_n4pe08_cdad28_pl g on g.id_n4pe08_cdad_pl = ub.id_ubigeo_dist';
    }
    else if( $id_nivel==6){
    $sql .= ' JOIN sisvisordgismi.tg_n2pe00_lpd g on rpad(g.id_geo::text, 6, \'0000\'::text) = ub.id_ubigeo_dist::text';
    }
    else if( $id_nivel==7){
    $sql .= ' JOIN sisvisordgismi.uvw_g_enevic_totvar_dist_lyc g on g.id_ubigeo_dist = ub.id_ubigeo_dist::text';
    }

    $sql .= ' WHERE 1=1  and v.id_fuente ='.$id.' and v.id_variable=\''.$id_ind.'\' and v.id_nivel=\''.$id_nivel.'\' and v.id_anio=\''.$id_anio.'\'';

    if($id_ubigeo <> null ){
      $sql .= ' and v.id_ubigeo in (select regexp_split_to_table(\''.$id_ubigeo.'\',\'-\'))';
    }

    $sql .= 'GROUP BY ub.id_ubigeo_dist,v.id_nivel,v.id_fuente,fu.descrip_bd,fu.institucion_bd,v.id_variable,
    va.nomb_variable,un.id_unidad_medida,un.nomb_unidad_medida,un.etq_unidad_medida,ni.nomb_nivel,v.id_anio,an.anio,
    esc.nivel_escala,v.valor_medido_escala,po.poblacion_dpto,po.poblacion_prov,po.poblacion_dist)poligonos ';  
            // echo $sql;
        return $this->db->query($sql);
    }
}
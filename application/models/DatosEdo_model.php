<?php
ini_set('max_execution_time', 0);
ini_set("memory_limit", "-1");
class DatosEdo_model extends CI_Model
{
  function __construct() {
    parent::__construct();
    $this->load->database();
  }


    function get_reporte_apa($idnivel,$periodo,$ciclo){
      $periodo_planea="2019";
      if($idnivel==2){
        $periodo_planea="2018";
      }
      $q = "SELECT GROUP_CONCAT(c.idreporteapa) AS idreporteapa
            ,c.encabezado_n_nivel
            ,c.`encabezado_n_periodo`
            ,c.asi_est_ciclo1
            ,SUM(c.asi_est_al_t) AS asi_est_al_t
            ,SUM(c.asi_est_al_1) AS asi_est_al_1
            ,SUM(c.asi_est_al_2) AS asi_est_al_2
            ,SUM(c.asi_est_al_3) AS asi_est_al_3
            ,SUM(c.asi_est_al_4) AS asi_est_al_4
            ,SUM(c.asi_est_al_5) AS asi_est_al_5
            ,SUM(c.asi_est_al_6) AS asi_est_al_6
            ,SUM(c.asi_est_gr_t) AS asi_est_gr_t
            ,SUM(c.asi_est_gr_1) AS asi_est_gr_1
            ,SUM(c.asi_est_gr_2) AS asi_est_gr_2
            ,SUM(c.asi_est_gr_3) AS asi_est_gr_3
            ,SUM(c.asi_est_gr_4) AS asi_est_gr_4
            ,SUM(c.asi_est_gr_5) AS asi_est_gr_5
            ,SUM(c.asi_est_gr_6) AS asi_est_gr_6
            ,SUM(c.asi_est_do_t) AS asi_est_do_t
            ,c.asi_est_ac_ciclo
            ,c.asi_est_h1_ciclo
            ,SUM(c.asi_est_h1_al_1) AS asi_est_h1_al_1
            ,SUM(c.asi_est_h1_al_2) AS asi_est_h1_al_2
            ,SUM(c.asi_est_h1_al_3) AS asi_est_h1_al_3
            ,SUM(c.asi_est_h1_al_4) AS asi_est_h1_al_4
            ,SUM(c.asi_est_h1_al_5) AS asi_est_h1_al_5
            ,SUM(c.asi_est_h1_al_6) AS asi_est_h1_al_6
            ,SUM(c.asi_est_h1_gr_t) AS asi_est_h1_gr_t
            ,c.asi_est_h2_ciclo
            ,SUM(c.asi_est_h2_al_1) AS asi_est_h2_al_1
            ,SUM(c.asi_est_h2_al_2) AS asi_est_h2_al_2
            ,SUM(c.asi_est_h2_al_3) AS asi_est_h2_al_3
            ,SUM(c.asi_est_h2_al_4) AS asi_est_h2_al_4
            ,SUM(c.asi_est_h2_al_5) AS asi_est_h2_al_5
            ,SUM(c.asi_est_h2_al_6) AS asi_est_h2_al_6
            ,SUM(c.asi_est_h2_gr_t) AS asi_est_h2_gr_t
            ,SUM(c.asi_est_gruposmulti) AS asi_est_gruposmulti
            ,c.asi_anio_inegi
            ,c.asi_rez_gedad_noasiste
            ,c.asi_rez_pob_t
            ,c.asi_rez_pob_m
            ,c.asi_rez_pob_h
            ,c.asi_rez_noasiste_t
            ,c.asi_rez_noasiste_m
            ,c.asi_rez_noasiste_h
            ,c.asi_analfabeta_t
            ,c.asi_analfabeta_m
            ,c.asi_analfabeta_h
            ,c.asi_lenguas_nativas
            ,SUM(c.per_riesgo_al_t) AS per_riesgo_al_t
            ,SUM(c.per_riesgo_al_muy_alto) AS per_riesgo_al_muy_alto
            ,SUM(c.per_riesgo_al_alto) AS per_riesgo_al_alto
            ,SUM(c.per_riesgo_al_medio) AS per_riesgo_al_medio
            ,SUM(c.per_riesgo_al_bajo) AS per_riesgo_al_bajo
            ,SUM(c.per_riesgo_al_muy_alto_1) AS per_riesgo_al_muy_alto_1
            ,SUM(c.per_riesgo_al_muy_alto_2) AS per_riesgo_al_muy_alto_2
            ,SUM(c.per_riesgo_al_muy_alto_3) AS per_riesgo_al_muy_alto_3
            ,SUM(c.per_riesgo_al_muy_alto_4) AS per_riesgo_al_muy_alto_4
            ,SUM(c.per_riesgo_al_muy_alto_5) AS per_riesgo_al_muy_alto_5
            ,SUM(c.per_riesgo_al_muy_alto_6) AS per_riesgo_al_muy_alto_6
            ,SUM(c.per_riesgo_al_alto_1) AS per_riesgo_al_alto_1
            ,SUM(c.per_riesgo_al_alto_2) AS per_riesgo_al_alto_2
            ,SUM(c.per_riesgo_al_alto_3) AS per_riesgo_al_alto_3
            ,SUM(c.per_riesgo_al_alto_4) AS per_riesgo_al_alto_4
            ,SUM(c.per_riesgo_al_alto_5) AS per_riesgo_al_alto_5
            ,SUM(c.per_riesgo_al_alto_6) AS per_riesgo_al_alto_6
            , ' ' AS per_ind_ciclo
            , ' ' AS per_ind_retencion
            , ' ' AS per_ind_aprobacion
            , ' ' AS per_ind_et
            ,c.per_bit_datos_subestimados_inasistencia
             ,' ' AS apr_ete_ciclo_et
            ,' ' AS apr_ete_periodo_planea
            ,' ' AS apr_ete
            ,c.apr_planea_nlogro_estado_periodo
            ,c.apr_planea_nlogro_estado_lyc_i
            ,p.`nii_lyc` AS apr_planea_nlogro_estado_lyc_ii
            ,p.`niii_lyc` AS apr_planea_nlogro_estado_lyc_iii
            ,p.`niv_lyc` AS apr_planea_nlogro_estado_lyc_iv
            ,c.`apr_planea_nlogro_estado_lyc_ii-iii-iv`
            ,c.apr_planea_nlogro_estado_mat_i
            ,p.`nii_mat` AS apr_planea_nlogro_estado_mat_ii
            ,p.`niii_mat` AS apr_planea_nlogro_estado_mat_iii
            ,p.`niv_mat` AS apr_planea_nlogro_estado_mat_iv
            ,c.`apr_planea_nlogro_estado_mat_ii-iii-iv`
            ,c.apr_planea_nlogro_pais_periodo
            ,c.apr_planea_nlogro_pais_lyc_i
            ,c.`apr_planea_nlogro_pais_lyc_ii-iii-iv`
            ,c.apr_planea_nlogro_pais_mat_i
            ,c.`apr_planea_nlogro_pais_mat_ii-iii-iv`
            ,((SUM(c.apr_prom_al_esc_esp_5))/COUNT(c.apr_prom_al_esc_esp_5)) AS apr_prom_al_esc_esp_5
            ,((SUM(c.`apr_prom_al_esc_esp_6-7`))/COUNT(c.`apr_prom_al_esc_esp_6-7`)) AS `apr_prom_al_esc_esp_6-7`
            ,((SUM(c.`apr_prom_al_esc_esp_8-9`))/count(c.`apr_prom_al_esc_esp_8-9`)) AS `apr_prom_al_esc_esp_8-9`
            ,((SUM(c.apr_prom_al_esc_esp_10))/COUNT(c.apr_prom_al_esc_esp_10)) AS  apr_prom_al_esc_esp_10
            ,((SUM(c.apr_prom_al_esc_mat_5))/COUNT(c.apr_prom_al_esc_mat_5)) AS apr_prom_al_esc_mat_5
            ,((SUM(c.`apr_prom_al_esc_mat_6-7`))/count(c.`apr_prom_al_esc_mat_6-7`)) as `apr_prom_al_esc_mat_6-7`
            ,((SUM(c.`apr_prom_al_esc_mat_8-9`))/count(c.`apr_prom_al_esc_mat_8-9`)) as `apr_prom_al_esc_mat_8-9`
            ,((SUM(c.apr_prom_al_esc_mat_10))/count(c.apr_prom_al_esc_mat_10)) as apr_prom_al_esc_mat_10
            ,c1.porcentaje  AS apr_planea1_ct_lyc_1por
            ,c1.contenido  AS apr_planea1_ct_lyc_1txt
            ,c2.porcentaje  AS apr_planea1_ct_lyc_2por
            ,c2.contenido  AS apr_planea1_ct_lyc_2txt
            ,c3.porcentaje  AS apr_planea1_ct_lyc_3por
            ,c3.contenido  AS apr_planea1_ct_lyc_3txt
            ,c4.porcentaje  AS apr_planea1_ct_lyc_4por
            ,c4.contenido  AS apr_planea1_ct_lyc_4txt
            ,c5.porcentaje  AS apr_planea1_ct_lyc_5por
            ,c5.contenido  AS apr_planea1_ct_lyc_5txt
            ,c6.porcentaje  AS apr_planea1_ct_mat_1por
            ,c6.contenido  AS apr_planea1_ct_mat_1txt
            ,c7.porcentaje  AS apr_planea1_ct_mat_2por
            ,c7.contenido  AS apr_planea1_ct_mat_2txt
            ,c8.porcentaje  AS apr_planea1_ct_mat_3por
            ,c8.contenido  AS apr_planea1_ct_mat_3txt
            ,c9.porcentaje  AS apr_planea1_ct_mat_4por
            ,c9.contenido  AS apr_planea1_ct_mat_4txt
            ,c10.porcentaje AS apr_planea1_ct_mat_5por
            ,c10.contenido  AS apr_planea1_ct_mat_5txt
            FROM complemento_apa c
            INNER JOIN centrocfg cfg ON cfg.idcentrocfg=c.idcentrocfg
            INNER JOIN `planea_nlogro_x_entidad` p ON p.`idnivel`=c.`idnivel` 
            INNER JOIN (
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idnivel 
                  FROM planea_contenidos_xedo_xnivel
                  WHERE  idnivel={$idnivel} 
                  AND idcampodisciplinario=1
                  ORDER BY porcentaje ASC LIMIT 1 ) AS c1 ON c1.idnivel=cfg.nivel
            INNER JOIN(
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idnivel 
                  FROM planea_contenidos_xedo_xnivel
                  WHERE  idnivel={$idnivel} 
                  AND idcampodisciplinario=1
                  ORDER BY porcentaje ASC LIMIT 1,1 ) AS c2 ON c2.idnivel=cfg.nivel
            INNER JOIN(
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idnivel 
                  FROM planea_contenidos_xedo_xnivel
                  WHERE  idnivel={$idnivel}  
                  AND idcampodisciplinario=1
                  ORDER BY porcentaje ASC LIMIT 2,1 ) AS c3 ON c3.idnivel=cfg.nivel
            INNER JOIN(
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idnivel 
                  FROM planea_contenidos_xedo_xnivel
                  WHERE  idnivel={$idnivel} 
                  AND idcampodisciplinario=1
                  ORDER BY porcentaje ASC LIMIT 3,1 ) AS c4 ON c4.idnivel=cfg.nivel
            INNER JOIN (
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idnivel 
                  FROM planea_contenidos_xedo_xnivel
                  WHERE  idnivel={$idnivel} 
                  AND idcampodisciplinario=1
                  ORDER BY porcentaje ASC LIMIT 4,1
            ) AS c5 on c5.idnivel=cfg.nivel
            INNER JOIN (
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idnivel 
                  FROM planea_contenidos_xedo_xnivel
                  WHERE  idnivel={$idnivel} 
                  AND idcampodisciplinario=2
                  ORDER BY porcentaje ASC LIMIT 1 ) AS c6 ON c6.idnivel=cfg.nivel
            INNER JOIN(
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idnivel 
                  FROM planea_contenidos_xedo_xnivel
                  WHERE  idnivel={$idnivel} 
                  AND idcampodisciplinario=2
                  ORDER BY porcentaje ASC LIMIT 1,1 ) AS c7 ON c7.idnivel=cfg.nivel
            INNER JOIN(
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idnivel 
                  FROM planea_contenidos_xedo_xnivel
                  WHERE  idnivel={$idnivel}  
                  AND idcampodisciplinario=2
                  ORDER BY porcentaje ASC LIMIT 2,1 ) AS c8 ON c8.idnivel=cfg.nivel
            INNER JOIN(
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idnivel 
                  FROM planea_contenidos_xedo_xnivel
                  WHERE  idnivel={$idnivel} 
                  AND idcampodisciplinario=2
                  ORDER BY porcentaje ASC LIMIT 3,1 ) AS c9 ON c9.idnivel=cfg.nivel
            INNER JOIN (
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idnivel 
                  FROM planea_contenidos_xedo_xnivel
                  WHERE  idnivel={$idnivel} 
                  AND idcampodisciplinario=2
                  ORDER BY porcentaje ASC LIMIT 4,1
            ) AS c10 ON c10.idnivel=cfg.nivel

            WHERE  cfg.nivel= ? AND c.periodo= ? AND c.ciclo= ? 
            AND p.periodo_planea= ?
            ";
            // echo $q;die();
      return $this->db->query($q, array($idnivel,$periodo,$ciclo,$periodo_planea))->row_array();
      // return $this->db->query($q)->result_array();
    }

    function get_alumnos_baja($idreporte){
      $q = "SELECT
            b.*,c.cct,c.encabezado_n_turno,c.encabezado_n_escuela,c.encabezado_muni_escuela,c.idcentrocfg,c.encabezado_n_direc_resp
            FROM bajas_apa as b
            INNER JOIN complemento_apa c on c.idreporteapa=b.idreporteapa
            WHERE b.idreporteapa IN({$idreporte}) order by c.idcentrocfg,b.grado, b.grupo, b.nombre_alu";
      return $this->db->query($q)->result_array();
    }

    function get_alumnos_mar($idreporte){
      $q = "SELECT
            m.*,c.cct,c.encabezado_n_turno,c.encabezado_n_escuela,c.encabezado_muni_escuela,c.idcentrocfg,c.encabezado_n_direc_resp
            FROM muy_alto_riesgo as m
            INNER JOIN complemento_apa c ON c.idreporteapa=m.idreporteapa
            WHERE m.idreporteapa IN({$idreporte}) order by c.idcentrocfg,m.muyalto_alto desc, m.grado asc, m.grupo, m.nombre_alu";
      // $q = "SELECT
      //       *
      //       FROM muy_alto_riesgo as m
      //       WHERE idreporteapa IN({$idreporte}) order by muyalto_alto desc,grado asc, grupo, nombre_alu";
            // echo $q;die();
      return $this->db->query($q)->result_array();
    }

}

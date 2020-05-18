<?php
ini_set('max_execution_time', 0);
ini_set("memory_limit", "-1");
class DatosMunicipal_model extends CI_Model
{
  function __construct() {
    parent::__construct();
    $this->load->database();
  }


    function get_reporte_apa($idmunicipio,$idnivel,$periodo,$ciclo){
      $periodo_planea="2019";
      if($idnivel==2){
        $periodo_planea="2018";
      }
      // print_r($periodo_planea_mun_max); die();
      $q = "SELECT GROUP_CONCAT(c.idreporteapa) AS idreporteapa
            ,c.encabezado_n_nivel
            ,c.`encabezado_n_periodo`
            ,c.`encabezado_muni_escuela`
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
            INNER JOIN cct ct ON ct.idct=cfg.idct
            INNER JOIN (
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idmunicipio 
                  FROM `planea_contenidosxmunixnivel`
                  WHERE idmunicipio={$idmunicipio} AND idnivel={$idnivel} 
                  AND idcampodisciplinario=1
                  ORDER BY porcentaje ASC LIMIT 1 ) AS c1 ON c1.idmunicipio=ct.idmunicipio
            INNER JOIN(
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idmunicipio 
                  FROM `planea_contenidosxmunixnivel`
                  WHERE idmunicipio={$idmunicipio} AND idnivel={$idnivel} 
                  AND idcampodisciplinario=1
                  ORDER BY porcentaje ASC LIMIT 1,1 ) AS c2 ON c2.idmunicipio=ct.idmunicipio
            INNER JOIN(
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idmunicipio 
                  FROM `planea_contenidosxmunixnivel`
                  WHERE idmunicipio={$idmunicipio} AND idnivel={$idnivel}  
                  AND idcampodisciplinario=1
                  ORDER BY porcentaje ASC LIMIT 2,1 ) AS c3 ON c3.idmunicipio=ct.idmunicipio
            INNER JOIN(
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idmunicipio 
                  FROM `planea_contenidosxmunixnivel`
                  WHERE idmunicipio={$idmunicipio} AND idnivel={$idnivel} 
                  AND idcampodisciplinario=1
                  ORDER BY porcentaje ASC LIMIT 3,1 ) AS c4 ON c4.idmunicipio=ct.idmunicipio
            INNER JOIN (
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idmunicipio 
                  FROM `planea_contenidosxmunixnivel`
                  WHERE idmunicipio={$idmunicipio} AND idnivel={$idnivel} 
                  AND idcampodisciplinario=1
                  ORDER BY porcentaje ASC LIMIT 4,1
            ) AS c5 on c5.idmunicipio=ct.idmunicipio
            INNER JOIN (
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idmunicipio 
                  FROM `planea_contenidosxmunixnivel`
                  WHERE idmunicipio={$idmunicipio} AND idnivel={$idnivel} 
                  AND idcampodisciplinario=2
                  ORDER BY porcentaje ASC LIMIT 1 ) AS c6 ON c6.idmunicipio=ct.idmunicipio
            INNER JOIN(
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idmunicipio 
                  FROM `planea_contenidosxmunixnivel`
                  WHERE idmunicipio={$idmunicipio} AND idnivel={$idnivel} 
                  AND idcampodisciplinario=2
                  ORDER BY porcentaje ASC LIMIT 1,1 ) AS c7 ON c7.idmunicipio=ct.idmunicipio
            INNER JOIN(
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idmunicipio 
                  FROM `planea_contenidosxmunixnivel`
                  WHERE idmunicipio={$idmunicipio} AND idnivel={$idnivel}  
                  AND idcampodisciplinario=2
                  ORDER BY porcentaje ASC LIMIT 2,1 ) AS c8 ON c8.idmunicipio=ct.idmunicipio
            INNER JOIN(
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idmunicipio 
                  FROM `planea_contenidosxmunixnivel`
                  WHERE idmunicipio={$idmunicipio} AND idnivel={$idnivel} 
                  AND idcampodisciplinario=2
                  ORDER BY porcentaje ASC LIMIT 3,1 ) AS c9 ON c9.idmunicipio=ct.idmunicipio
            INNER JOIN (
                  SELECT contenido,ROUND(porcentaje,1) AS porcentaje,idmunicipio 
                  FROM `planea_contenidosxmunixnivel`
                  WHERE idmunicipio={$idmunicipio} AND idnivel={$idnivel} 
                  AND idcampodisciplinario=2
                  ORDER BY porcentaje ASC LIMIT 4,1
            ) AS c10 ON c10.idmunicipio=ct.idmunicipio

            WHERE ct.`idmunicipio`= ?  AND cfg.nivel= ? AND c.periodo= ? AND c.ciclo= ? 
            AND p.periodo_planea= ?
            ";
            // echo $q;die();
      
       // if($this->db->query($this->db->query($q, array($idmunicipio,$idnivel,$periodo,$ciclo,$periodo_planea))){
        return $this->db->query($q, array($idmunicipio,$idnivel,$periodo,$ciclo,$periodo_planea))->row_array();
      // }else{
      //   $error =$this->db->error();
      //   return $error;
      // }
      // return $this->db->query($q)->result_array();
    }
    function get_planea_max_periodo_municipal($idnivel,$idmunicipio){
      $q="SELECT MAX(periodo_planea) AS periodo_planea,
                idnivel
                FROM planea_nlogro_x_municipio WHERE idnivel= ?";
      return $this->db->query($q, array($idnivel))->row_array();
    }

    function get_planea_min_periodo_municipal($idnivel,$idmunicipio){
      $q="SELECT MIN(periodo_planea) periodo_planea,
                  idnivel
                FROM planea_nlogro_x_municipio WHERE idnivel= ?";
      return $this->db->query($q, array($idnivel))->row_array();
    }
    
    function get_planea_nl_max_municipal($idnivel,$idmunicipio,$periodo_planea){
      $q="SELECT MAX(periodo_planea) AS periodo_planea,
                ni_lyc AS ni_lyc_mun_max,
                nii_lyc AS nii_lyc_mun_max,
                niii_lyc AS niii_lyc_mun_max,
                niv_lyc AS niv_lyc_mun_max,
                (nii_lyc+niii_lyc+niv_lyc) planea_ii_iii_iv_lyc_mun_max,
                ni_mat AS ni_mat_mun_max,
                nii_mat as nii_mat_mun_max,
                niii_mat as niii_mat_mun_max,
                niv_mat as niv_mat_mun_mun,
                (nii_mat+niii_mat+niv_mat) planea_ii_iii_iv_mat_mun_max,
                idmunicipio,idnivel
                FROM planea_nlogro_x_municipio WHERE idnivel= ? AND idmunicipio= ? AND periodo_planea= ?";
      return $this->db->query($q, array($idnivel,$idmunicipio,$periodo_planea))->row_array();
    }

    function get_planea_nl_min_municipal($idnivel,$idmunicipio,$periodo_planea){
      $q="SELECT MIN(periodo_planea) periodo_planea,
                  ni_lyc as ni_lyc_mun_min ,
                  (nii_lyc+niii_lyc+niv_lyc) planea_ii_iii_iv_lyc_mun_min,
                  ni_mat as ni_mat_mun_min,
                  (nii_mat+niii_mat+niv_mat) planea_ii_iii_iv_mat_mun_min,
                  idmunicipio,
                  idnivel
                FROM planea_nlogro_x_municipio WHERE idnivel= ? AND idmunicipio= ? AND periodo_planea= ?";
      return $this->db->query($q, array($idnivel,$idmunicipio,$periodo_planea))->row_array();
    }

    function get_alumnos_baja($idreporte){
      // $q = "SELECT
      //       *
      //       FROM bajas_apa
      //       WHERE idreporteapa IN({$idreporte}) order by grado, grupo, nombre_alu";
      // return $this->db->query($q)->result_array();
      $q = "SELECT
            b.*,c.cct,c.encabezado_n_turno,c.encabezado_n_escuela,c.encabezado_muni_escuela,c.idcentrocfg,c.encabezado_n_direc_resp
            FROM bajas_apa as b
            INNER JOIN complemento_apa c on c.idreporteapa=b.idreporteapa
            WHERE b.idreporteapa IN({$idreporte}) order by c.idcentrocfg,b.grado, b.grupo, b.nombre_alu";
      return $this->db->query($q)->result_array();
    }

    function get_alumnos_mar($idreporte){
       $q = " SELECT d.idcentrocfg,
                    d.total_muy_alto,
                    d.total_alto,
                    d.cct,
                    d.turno,
                    d.nombre_escuela,
                    d.encabezado_muni_escuela,
                    d.total_alumnos,
                    d.encabezado_n_nivel,
                    d.encabezado_n_periodo,
                    d.localidad,
                    (d.total_alto+d.total_muy_alto) as total_alto_riesgo,
                    ROUND((((d.total_alto+d.total_muy_alto)*100)/d.total_alumnos),2) AS porcentaje 

                    FROM (
                      SELECT 
                      c.idcentrocfg
                      ,SUM(c.per_riesgo_al_muy_alto) AS total_muy_alto
                      ,SUM(c.per_riesgo_al_alto) AS total_alto
                      ,c.cct
                      ,c.turno
                      ,c.encabezado_n_escuela AS nombre_escuela
                      ,c.encabezado_muni_escuela
                      ,c.per_riesgo_al_t AS total_alumnos
                      ,c.encabezado_n_nivel
                      ,c.encabezado_n_periodo
                      ,ct.localidad
                      FROM complemento_apa c
                      INNER JOIN centrocfg cfg ON cfg.idcentrocfg=c.idcentrocfg
                      INNER JOIN cct ct ON ct.idct=cfg.idct
                      WHERE c.idreporteapa IN({$idreporte})

                      AND  c.per_riesgo_al_t IS NOT NULL 
                      GROUP BY c.`idcentrocfg` ) AS d 
                      -- WHERE d.total_muy_alto!=0 OR d.total_alto!=0
                  ORDER BY d.total_muy_alto DESC";
            // echo $q;die();
      return $this->db->query($q)->result_array();
    }


      function insertacontenidos_xcentrocfgall(){
            $q = "SELECT
                  idcentrocfg
                  FROM centrocfg
                  ";
                  // echo $q;die();
            $resultado=$this->db->query($q)->result_array();
            // echo "<pre>";
            // print_r($resultado); die();
            //inserto los datos para nivel primaria y campodisciplinario 1
            if(count($resultado)>0){
                  for ($i=0; $i <count($resultado) ; $i++) { 
                        $query="INSERT INTO temporal_contenidosxcfgall (
                                idcentrocfg,
                                `idnivel`,
                                `idcampodisciplinario`,
                                `periodo`,
                                `id_contenido`,
                                `contenido`,
                                `porcentaje`
                              )
                              SELECT b.idcentrocfg,'2' AS idnivel,
                              '1' campodisciplinario,
                               '2018' AS periodo,b.id_contenido,b.contenidos,b.porcentaje
                               FROM (
                                    SELECT t1.`idcentrocfg`,t4.id_periodo,`t3`.`id_contenido`, `t3`.`contenido` AS `contenidos`,
                                         
                                              ((((SUM(t1.n_aciertos))*100)/((COUNT(t3.id_contenido))*t1.n_almn_eval)))AS porcentaje
                                              FROM `planeaxidcentrocfg_reactivo` `t1`
                                              INNER JOIN centrocfg cfg ON cfg.idcentrocfg=t1.idcentrocfg
                                              INNER JOIN `planea_reactivo` `t2` ON `t1`.`id_reactivo`=`t2`.`id_reactivo`
                                              INNER JOIN `planea_contenido` `t3` ON `t2`.`id_contenido`= `t3`.`id_contenido`
                                              INNER JOIN `planea_unidad_analisis` `t4` ON `t3`.`id_unidad_analisis`=`t4`.`id_unidad_analisis`
                                              INNER JOIN `planea_camposdisciplinares` `t5` ON `t4`.`id_campodisiplinario`=`t5`.`id_campodisiplinario`
                                              WHERE cfg.`idcentrocfg`= {$resultado[$i]['idcentrocfg']}  AND cfg.nivel= 2 
                                              AND  t5.id_campodisiplinario=1 
                                              GROUP BY `t3`.`id_contenido`
                              ) AS b ORDER BY b.porcentaje ASC 
                        ";
                        $this->db->query($query);
                  }
            }

            //inserto los datos para nivel primaria y campodisciplinario 2
            if(count($resultado)>0){
                  for ($i=0; $i <count($resultado) ; $i++) { 
                        $query="INSERT INTO temporal_contenidosxcfgall (
                                `idcentrocfg`,
                                `idnivel`,
                                `idcampodisciplinario`,
                                `periodo`,
                                `id_contenido`,
                                `contenido`,
                                `porcentaje`
                              )
                              SELECT b.idcentrocfg,'2' AS idnivel,
                              '2' campodisciplinario,
                               '2018' AS periodo,b.id_contenido,b.contenidos,b.porcentaje
                               FROM (
                                    SELECT t1.`idcentrocfg`,t4.id_periodo,`t3`.`id_contenido`, `t3`.`contenido` AS `contenidos`,
                                         
                                              ((((SUM(t1.n_aciertos))*100)/((COUNT(t3.id_contenido))*t1.n_almn_eval)))AS porcentaje
                                              FROM `planeaxidcentrocfg_reactivo` `t1`
                                              INNER JOIN centrocfg cfg ON cfg.idcentrocfg=t1.idcentrocfg
                                              INNER JOIN `planea_reactivo` `t2` ON `t1`.`id_reactivo`=`t2`.`id_reactivo`
                                              INNER JOIN `planea_contenido` `t3` ON `t2`.`id_contenido`= `t3`.`id_contenido`
                                              INNER JOIN `planea_unidad_analisis` `t4` ON `t3`.`id_unidad_analisis`=`t4`.`id_unidad_analisis`
                                              INNER JOIN `planea_camposdisciplinares` `t5` ON `t4`.`id_campodisiplinario`=`t5`.`id_campodisiplinario`
                                              WHERE cfg.idcentrocfg= {$resultado[$i]['idcentrocfg']}  AND cfg.nivel= 2 
                                              AND  t5.id_campodisiplinario=2 
                                              GROUP BY `t3`.`id_contenido`
                              ) AS b ORDER BY b.porcentaje ASC 
                        ";
                        $this->db->query($query);
                  }
            

            //inserto los datos para el nivel secundaria y campodisciplinario 1
        
                  for ($i=0; $i <count($resultado) ; $i++) { 
                        $query="INSERT INTO temporal_contenidosxcfgall (
                                `idcentrocfg`,
                                `idnivel`,
                                `idcampodisciplinario`,
                                `periodo`,
                                `id_contenido`,
                                `contenido`,
                                `porcentaje`
                              )
                              SELECT b.idcentrocfg,'3' AS idnivel,
                              '1' campodisciplinario,
                               '2019' AS periodo,b.id_contenido,b.contenidos,b.porcentaje
                               FROM (
                                    SELECT t1.`idcentrocfg`,t4.id_periodo,`t3`.`id_contenido`, `t3`.`contenido` AS `contenidos`,
                                         
                                              ((((SUM(t1.n_aciertos))*100)/((COUNT(t3.id_contenido))*t1.n_almn_eval)))AS porcentaje
                                              FROM `planeaxidcentrocfg_reactivo` `t1`
                                              INNER JOIN centrocfg cfg ON cfg.idcentrocfg=t1.idcentrocfg
                                              INNER JOIN `planea_reactivo` `t2` ON `t1`.`id_reactivo`=`t2`.`id_reactivo`
                                              INNER JOIN `planea_contenido` `t3` ON `t2`.`id_contenido`= `t3`.`id_contenido`
                                              INNER JOIN `planea_unidad_analisis` `t4` ON `t3`.`id_unidad_analisis`=`t4`.`id_unidad_analisis`
                                              INNER JOIN `planea_camposdisciplinares` `t5` ON `t4`.`id_campodisiplinario`=`t5`.`id_campodisiplinario`
                                              WHERE cfg.idcentrocfg= {$resultado[$i]['idcentrocfg']}  AND cfg.nivel= 3 
                                              AND  t5.id_campodisiplinario=1 
                                              GROUP BY `t3`.`id_contenido`
                              ) AS b ORDER BY b.porcentaje ASC 
                        ";
                        $this->db->query($query);
                  }

            

            //inserto los datos para nivel secundaria y campodisciplinario 2
                  for ($i=0; $i <count($resultado) ; $i++) { 
                        $query="INSERT INTO temporal_contenidosxcfgall (
                                `idcentrocfg`,
                                `idnivel`,
                                `idcampodisciplinario`,
                                `periodo`,
                                `id_contenido`,
                                `contenido`,
                                `porcentaje`
                              )
                              SELECT  b.idcentrocfg,'3' AS idnivel,
                              '2' campodisciplinario,
                               '2019' AS periodo,b.id_contenido,b.contenidos,b.porcentaje
                               FROM (
                                    SELECT t1.`idcentrocfg`,t4.id_periodo,`t3`.`id_contenido`, `t3`.`contenido` AS `contenidos`,
                                         
                                              ((((SUM(t1.n_aciertos))*100)/((COUNT(t3.id_contenido))*t1.n_almn_eval)))AS porcentaje
                                              FROM `planeaxidcentrocfg_reactivo` `t1`
                                              INNER JOIN centrocfg cfg ON cfg.idcentrocfg=t1.idcentrocfg
                                              INNER JOIN cct ct ON ct.idct=cfg.idct
                                              INNER JOIN `planea_reactivo` `t2` ON `t1`.`id_reactivo`=`t2`.`id_reactivo`
                                              INNER JOIN `planea_contenido` `t3` ON `t2`.`id_contenido`= `t3`.`id_contenido`
                                              INNER JOIN `planea_unidad_analisis` `t4` ON `t3`.`id_unidad_analisis`=`t4`.`id_unidad_analisis`
                                              INNER JOIN `planea_camposdisciplinares` `t5` ON `t4`.`id_campodisiplinario`=`t5`.`id_campodisiplinario`
                                              WHERE cfg.`idcentrocfg`= {$resultado[$i]['idcentrocfg']}  AND cfg.nivel= 3 
                                              AND  t5.id_campodisiplinario=2 
                                              GROUP BY `t3`.`id_contenido`
                              ) AS b ORDER BY b.porcentaje ASC 
                        ";
                        $this->db->query($query);
                  }
            }
      }

      function insertacontenidos_xmunxnivel(){
            $query="SELECT idmunicipio FROM municipio";
            $resultado=$this->db->query($query)->result_array();

            //inserto los datos para nivel primaria y campodisciplinario 1
            if(count($resultado)>0){
                  for ($i=0; $i <count($resultado) ; $i++) { 
                        $query="INSERT INTO planea_contenidosxmunixnivel (
                                `idmunicipio`,
                                `idnivel`,
                                `idcampodisciplinario`,
                                `periodo`,
                                `id_contenido`,
                                `contenido`,
                                `porcentaje`
                              )
                              SELECT * FROM (
                                    SELECT '{$resultado[$i]['idmunicipio']}' AS idmunicipio,t.`idnivel`,t.`idcampodisciplinario`,
                                         t.periodo,t.`id_contenido`,t.`contenido`,((SUM(t.`porcentaje`))/COUNT(t.`idcentrocfg`)) AS porcentaje
                                    FROM `temporal_contenidosxcfgall` t
                                    INNER JOIN centrocfg cfg ON cfg.`idcentrocfg`=t.`idcentrocfg`
                                    INNER JOIN cct c ON c.`idct`=cfg.`idct`
                                    WHERE c.`idmunicipio`= {$resultado[$i]['idmunicipio']}  AND t.`idcampodisciplinario`=1 AND cfg.nivel=2
                                    GROUP BY t.`id_contenido`
                                    ) AS b ORDER BY b.porcentaje ASC LIMIT 5";
                        $this->db->query($query);

                  }

                  for ($i=0; $i <count($resultado) ; $i++) { 
                        $query="INSERT INTO planea_contenidosxmunixnivel (
                                `idmunicipio`,
                                `idnivel`,
                                `idcampodisciplinario`,
                                `periodo`,
                                `id_contenido`,
                                `contenido`,
                                `porcentaje`
                              )
                              SELECT * FROM (
                                    SELECT '{$resultado[$i]['idmunicipio']}' AS idmunicipio,t.`idnivel`,t.`idcampodisciplinario`,
                                         t.periodo,t.`id_contenido`,t.`contenido`,((SUM(t.`porcentaje`))/COUNT(t.`idcentrocfg`)) AS porcentaje
                                    FROM `temporal_contenidosxcfgall` t
                                    INNER JOIN centrocfg cfg ON cfg.`idcentrocfg`=t.`idcentrocfg`
                                    INNER JOIN cct c ON c.`idct`=cfg.`idct`
                                    WHERE c.`idmunicipio`= {$resultado[$i]['idmunicipio']}  AND t.`idcampodisciplinario`=2 AND cfg.nivel=2
                                    GROUP BY t.`id_contenido`
                                    ) AS b ORDER BY b.porcentaje ASC LIMIT 5";
                        $this->db->query($query);

                  }

                  for ($i=0; $i <count($resultado) ; $i++) { 
                        $query="INSERT INTO planea_contenidosxmunixnivel (
                                `idmunicipio`,
                                `idnivel`,
                                `idcampodisciplinario`,
                                `periodo`,
                                `id_contenido`,
                                `contenido`,
                                `porcentaje`
                              )
                              SELECT * FROM (
                                    SELECT '{$resultado[$i]['idmunicipio']}' AS idmunicipio,t.`idnivel`,t.`idcampodisciplinario`,
                                         t.periodo,t.`id_contenido`,t.`contenido`,((SUM(t.`porcentaje`))/COUNT(t.`idcentrocfg`)) AS porcentaje
                                    FROM `temporal_contenidosxcfgall` t
                                    INNER JOIN centrocfg cfg ON cfg.`idcentrocfg`=t.`idcentrocfg`
                                    INNER JOIN cct c ON c.`idct`=cfg.`idct`
                                    WHERE c.`idmunicipio`= {$resultado[$i]['idmunicipio']}  AND t.`idcampodisciplinario`=1 AND cfg.nivel=3
                                    GROUP BY t.`id_contenido`
                                    ) AS b ORDER BY b.porcentaje ASC LIMIT 5";
                        $this->db->query($query);

                  }

                  for ($i=0; $i <count($resultado) ; $i++) { 
                        $query="INSERT INTO planea_contenidosxmunixnivel (
                                `idmunicipio`,
                                `idnivel`,
                                `idcampodisciplinario`,
                                `periodo`,
                                `id_contenido`,
                                `contenido`,
                                `porcentaje`
                              )
                              SELECT * FROM (
                                    SELECT '{$resultado[$i]['idmunicipio']}' AS idmunicipio,t.`idnivel`,t.`idcampodisciplinario`,
                                         t.periodo,t.`id_contenido`,t.`contenido`,((SUM(t.`porcentaje`))/COUNT(t.`idcentrocfg`)) AS porcentaje
                                    FROM `temporal_contenidosxcfgall` t
                                    INNER JOIN centrocfg cfg ON cfg.`idcentrocfg`=t.`idcentrocfg`
                                    INNER JOIN cct c ON c.`idct`=cfg.`idct`
                                    WHERE c.`idmunicipio`= {$resultado[$i]['idmunicipio']}  AND t.`idcampodisciplinario`=2 AND cfg.nivel=3
                                    GROUP BY t.`id_contenido`
                                    ) AS b ORDER BY b.porcentaje ASC LIMIT 5";
                        $this->db->query($query);

                  }
            }

      }

}

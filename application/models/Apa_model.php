<?php
ini_set('max_execution_time', 0);
ini_set("memory_limit", "1024M");
class Apa_model extends CI_Model
{
  function __construct() {
    parent::__construct();
    $this->load->database();
  }

    function get_riesgo_abandono()
    {
      $riesgo=array(29,14,30,322);
      return $riesgo;
    }

    function get_historico_mat()
    {
      $historico=array(array(47,80,40,116,10,20),array(61,30,82,105,10,20),array(115,50,70,93,10,20));
      return $historico;
    }

    function get_distribucionxgrado()
    {
      $distribucion=array(array(1,2,4,6,10,2),array(6,3,8,5,7,8));
      return $distribucion;
    }

    function get_planea_aprov()
    {
      $distribucion=array(array(1,2,4,6),array(6,3,8,5));
      return $distribucion;
    }

    function get_datos_escuela()
    {
      $array = array(
      "nombre" => "LICENCIADO BENITO JUAREZ",
      "cct" => "25DPR2893V",
      "director" => "ALEYDA HERNANDEZ MONTES",
      "turno" => "MATUTINO",
      "municipio" => "CULIACAN",
      "modalidad" => "GENERAL"
      );
      return $array;
    }

    function get_reporte_apa($cct,$turno,$periodo,$ciclo){
      $q = "SELECT
            *
            FROM complemento_apa
            WHERE cct = ?
            AND turno = ?
            AND periodo = ?
            AND ciclo = ?";
            // echo $q;die();
      return $this->db->query($q, array($cct,$turno,$periodo,$ciclo))->row_array();
      // return $this->db->query($q)->result_array();
    }

    function get_alumnos_baja($idreporte){
      $q = "SELECT
            *
            FROM bajas_apa
            WHERE idreporteapa = ? order by grado, grupo, nombre_alu";
            // echo $q;die();
      return $this->db->query($q, array($idreporte))->result_array();
    }

    function get_alumnos_mar($idreporte){
      $q = "SELECT
            *
            FROM muy_alto_riesgo
            WHERE idreporteapa = ? order by muyalto_alto desc, grado asc, grupo, nombre_alu";
            // echo $q;die();
      return $this->db->query($q, array($idreporte))->result_array();
    }

    function llenar_planeaxreactivoxcentrocfg(){
      //para secundaria,español
      // $x=0;
      for ($i=1; $i<52; $i++) {
        //para español omitir reactivos 24,28,35,42,43
        if($i!=24 && $i!=28 && $i!=35 && $i!=42 && $i!=43){

        $query=" INSERT INTO `apa_ok`.`planeaxidcentrocfg_reactivo` (
                  `idcentrocfg`,
                  `id_reactivo`,
                  `n_almn_eval`,
                  `n_aciertos`,
                  `id_periodo`
                )
                SELECT cfg.idcentrocfg, aux.id_reactivo AS id_reactivo,l.n_alum_eval,
                  l.r{$i}_lyc,p.id_periodo
                 FROM `temporal_planea3` l
                 INNER JOIN cct ct ON ct.cct=l.cct
                 INNER JOIN centrocfg cfg ON cfg.idct=ct.idct AND l.turno=(IF(cfg.turno='M',100,(IF(cfg.turno='V',200,IF(cfg.turno='N',300,400)))))
                 INNER JOIN periodoplanea p ON p.periodo=l.periodo_planea
                 INNER JOIN (
                   SELECT
                    r.*
                    FROM planea_camposdisciplinares cd
                    INNER JOIN planea_unidad_analisis ud ON cd.id_campodisiplinario = ud.id_campodisiplinario AND ud.id_nivel=3
                    INNER JOIN planea_contenido c ON ud.id_unidad_analisis = c.id_unidad_analisis
                    INNER JOIN planea_reactivo r ON c.id_contenido = r.id_contenido

                    WHERE cd.id_campodisiplinario=1

                    ORDER BY r.n_reactivo
                 ) aux on aux.n_reactivo = $i
                 WHERE cfg.nivel=3
              ";
          // echo $query; die();
        $this->db->query($query);
        }
      }



      //para matematicas,secundaria
      // $x=0;
      for ($i=1; $i<51 ; $i++) {

        // $x=$x+1;
        //   if($x==6 || $x==22 || $x==26 || $x==28){
        //     $x=$x+1;
        //   }
          if($i!=6 && $i!=22 && $i!=26 && $i!=28){

        // $query=" INSERT INTO `apa_ok`.`planeaxidcentrocfg_reactivo` (
        //           `idcentrocfg`,
        //           `id_reactivo`,
        //           `n_almn_eval`,
        //           `n_aciertos`,
        //           `id_periodo`
        //         )
        //         SELECT cfg.idcentrocfg,'{$i}' AS id_reactivo,l.n_alum_eval,
        //           l.r{$x}_lyc,p.id_periodo
        //          FROM `temporal_planea3` l
        //          INNER JOIN cct ct ON ct.cct=l.cct AND ct.turno=l.turno
        //          INNER JOIN centrocfg cfg ON cfg.idct=ct.idct AND l.turno=(IF(cfg.turno='M',100,(IF(cfg.turno='V',200,IF(cfg.turno='N',300,400)))))
        //          INNER JOIN periodoplanea p ON p.periodo=l.periodo_planea
        //          WHERE cfg.nivel=3
        //       ";
        //    $this->db->query($query);

           $query=" INSERT INTO `apa_ok`.`planeaxidcentrocfg_reactivo` (
                     `idcentrocfg`,
                     `id_reactivo`,
                     `n_almn_eval`,
                     `n_aciertos`,
                     `id_periodo`
                   )
                   SELECT cfg.idcentrocfg, aux.id_reactivo AS id_reactivo,l.n_alum_eval,
                     l.r{$i}_mat,p.id_periodo
                    FROM `temporal_planea3` l
                    INNER JOIN cct ct ON ct.cct=l.cct
                    INNER JOIN centrocfg cfg ON cfg.idct=ct.idct AND l.turno=(IF(cfg.turno='M',100,(IF(cfg.turno='V',200,IF(cfg.turno='N',300,400)))))
                    INNER JOIN periodoplanea p ON p.periodo=l.periodo_planea
                    INNER JOIN (
                      SELECT
                       r.*
                       FROM planea_camposdisciplinares cd
                       INNER JOIN planea_unidad_analisis ud ON cd.id_campodisiplinario = ud.id_campodisiplinario AND ud.id_nivel=3
                       INNER JOIN planea_contenido c ON ud.id_unidad_analisis = c.id_unidad_analisis
                       INNER JOIN planea_reactivo r ON c.id_contenido = r.id_contenido

                       WHERE cd.id_campodisiplinario=2

                       ORDER BY r.n_reactivo
                    ) aux on aux.n_reactivo = $i
                    WHERE cfg.nivel=3
                 ";
             // echo $query; die();
           $this->db->query($query);
      }
    }
//primaria español
    for ($i=1; $i<51; $i++) {
       //para español omitir reactivos 24,28,35,42,43
       if($i!=2 && $i!=21 && $i!=30 && $i!=32 && $i!=48){

       $query=" INSERT INTO `apa_ok`.`planeaxidcentrocfg_reactivo` (
                 `idcentrocfg`,
                 `id_reactivo`,
                 `n_almn_eval`,
                 `n_aciertos`,
                 `id_periodo`
               )
               SELECT cfg.idcentrocfg, aux.id_reactivo AS id_reactivo,l.n_alum_eval,
                 l.r{$i}_lyc,p.id_periodo
                FROM `temporal_planea2` l
                INNER JOIN cct ct ON ct.cct=l.cct AND ct.turno=l.turno
                INNER JOIN centrocfg cfg ON cfg.idct=ct.idct AND l.turno=(IF(cfg.turno='M',100,(IF(cfg.turno='V',200,IF(cfg.turno='N',300,400)))))
                INNER JOIN periodoplanea p ON p.periodo=l.periodo_planea
                INNER JOIN (
                  SELECT
                   r.*
                   FROM planea_camposdisciplinares cd
                   INNER JOIN planea_unidad_analisis ud ON cd.id_campodisiplinario = ud.id_campodisiplinario AND ud.id_nivel=2
                   INNER JOIN planea_contenido c ON ud.id_unidad_analisis = c.id_unidad_analisis
                   INNER JOIN planea_reactivo r ON c.id_contenido = r.id_contenido

                   WHERE cd.id_campodisiplinario=1

                   ORDER BY r.n_reactivo
                ) aux on aux.n_reactivo = $i
                WHERE cfg.nivel=2
             ";
         // echo $query; die();
         $this->db->query($query);
       }
     }

      //para primaria matemáticas mh
      for ($i=1; $i<51; $i++) {
        //para español omitir reactivos 24,28,35,42,43
        if($i!=2 && $i!=26){

        $query=" INSERT INTO `apa_ok`.`planeaxidcentrocfg_reactivo` (
                  `idcentrocfg`,
                  `id_reactivo`,
                  `n_almn_eval`,
                  `n_aciertos`,
                  `id_periodo`
                )
                SELECT cfg.idcentrocfg, aux.id_reactivo AS id_reactivo,l.n_alum_eval,
                  l.r{$i}_mat,p.id_periodo
                 FROM `temporal_planea2` l
                 INNER JOIN cct ct ON ct.cct=l.cct AND ct.turno=l.turno
                 INNER JOIN centrocfg cfg ON cfg.idct=ct.idct AND l.turno=(IF(cfg.turno='M',100,(IF(cfg.turno='V',200,IF(cfg.turno='N',300,400)))))
                 INNER JOIN periodoplanea p ON p.periodo=l.periodo_planea
                 INNER JOIN (

                    SELECT
                     r.*
                     FROM planea_camposdisciplinares cd
                     INNER JOIN planea_unidad_analisis ud ON cd.id_campodisiplinario = ud.id_campodisiplinario AND ud.id_nivel=2
                     INNER JOIN planea_contenido c ON ud.id_unidad_analisis = c.id_unidad_analisis
                     INNER JOIN planea_reactivo r ON c.id_contenido = r.id_contenido
                     WHERE cd.id_campodisiplinario=2
                     ORDER BY r.n_reactivo
                 ) aux on aux.n_reactivo = $i
                 WHERE cfg.nivel=2
              ";
          // echo $query; die();
        $this->db->query($query);
        }
      }



    }

    function llenarcontenidos(){
      $query="SELECT idcentrocfg FROM centrocfg";
      $datos=$this->db->query($query)->result_array();
      // echo "<pre>";
      // print_r($datos); die();
      for($i=0; $i<count($datos); $i++){
        $query2="INSERT INTO `apa_ok`.`temporal_contenidosxcfg` (
                `idcentrocfg`,
                `periodo`,
                `id_contenido`,
                `contenido`,
                `porcentaje`
              )
              SELECT a.idcentrocfg,a.id_periodo,a.id_contenido,a.contenidos AS contenidolyc,a.porcen_alum_respok AS porcentaje_lyc
                FROM planeaxidcentrocfg_reactivo p
                INNER JOIN   planea_reactivo r ON r.`id_reactivo`=p.`id_reactivo`
                INNER JOIN  planea_contenido pc ON pc.`id_contenido`=r.`id_contenido`
                INNER   JOIN (
                  SELECT b.* FROM (
                    SELECT t1.`idcentrocfg`,t4.`id_periodo`,`t3`.`id_contenido`, `t3`.`contenido` AS `contenidos`,
                    GROUP_CONCAT(t2.n_reactivo) AS reactivos, COUNT(t3.id_contenido) AS total_reac_xua,
                    SUM(t1.n_aciertos) AS total, `t1`.`n_almn_eval` AS `alumnos_evaluados`,
                    ROUND((((SUM(t1.n_aciertos))*100)/((COUNT(t3.id_contenido))*t1.n_almn_eval)), 1)AS porcen_alum_respok
                    FROM `planeaxidcentrocfg_reactivo` `t1`
                    INNER JOIN `planea_reactivo` `t2` ON `t1`.`id_reactivo`=`t2`.`id_reactivo`
                    INNER JOIN `planea_contenido` `t3` ON `t2`.`id_contenido`= `t3`.`id_contenido`
                    INNER JOIN `planea_unidad_analisis` `t4` ON `t3`.`id_unidad_analisis`=`t4`.`id_unidad_analisis`
                    INNER JOIN `planea_camposdisciplinares` `t5` ON `t4`.`id_campodisiplinario`=`t5`.`id_campodisiplinario`
                    WHERE  t5.id_campodisiplinario=1 AND t1.`idcentrocfg`={$datos[$i]['idcentrocfg']}
                    GROUP BY `t3`.`id_contenido`
                    ) AS b ORDER BY b.porcen_alum_respok ASC LIMIT 5
                        ) AS a ON p.`idcentrocfg`=a.idcentrocfg  AND a.id_contenido=pc.`id_contenido`
                    WHERE p.`idcentrocfg`={$datos[$i]['idcentrocfg']}
                    GROUP BY r.`id_contenido` ORDER BY a.porcen_alum_respok ";
                    $this->db->query($query2);
      }

      for($i=0; $i<count($datos); $i++){
        $query2="INSERT INTO `apa_ok`.`temporal_contenidosxcfg` (
                `idcentrocfg`,
                `periodo`,
                `id_contenido`,
                `contenido`,
                `porcentaje`
              )
              SELECT b.idcentrocfg,b.id_periodo,b.id_contenido,b.contenidos AS contenidomat,b.porcen_alum_respok AS porcentaje_mat
                  FROM planeaxidcentrocfg_reactivo p
                  INNER JOIN   planea_reactivo r ON r.`id_reactivo`=p.`id_reactivo`
                  INNER JOIN  planea_contenido pc ON pc.`id_contenido`=r.`id_contenido`
                  INNER JOIN (
                      SELECT b.* FROM (
                      SELECT t1.`idcentrocfg`,t4.id_periodo,`t3`.`id_contenido`, `t3`.`contenido` AS `contenidos`,
                      GROUP_CONCAT(t2.n_reactivo) AS reactivos, COUNT(t3.id_contenido) AS total_reac_xua,
                      SUM(t1.n_aciertos) AS total, `t1`.`n_almn_eval` AS `alumnos_evaluados`,
                      ROUND((((SUM(t1.n_aciertos))*100)/((COUNT(t3.id_contenido))*t1.n_almn_eval)), 1)AS porcen_alum_respok
                      FROM `planeaxidcentrocfg_reactivo` `t1`
                      INNER JOIN `planea_reactivo` `t2` ON `t1`.`id_reactivo`=`t2`.`id_reactivo`
                      INNER JOIN `planea_contenido` `t3` ON `t2`.`id_contenido`= `t3`.`id_contenido`
                      INNER JOIN `planea_unidad_analisis` `t4` ON `t3`.`id_unidad_analisis`=`t4`.`id_unidad_analisis`
                      INNER JOIN `planea_camposdisciplinares` `t5` ON `t4`.`id_campodisiplinario`=`t5`.`id_campodisiplinario`
                      WHERE  t5.id_campodisiplinario=2 AND t1.`idcentrocfg`={$datos[$i]['idcentrocfg']}
                      GROUP BY `t3`.`id_contenido`
                      ) AS b ORDER BY b.porcen_alum_respok  ASC LIMIT 5
                      ) AS b ON b.idcentrocfg=p.`idcentrocfg`   AND b.id_contenido=pc.`id_contenido`
                      WHERE p.`idcentrocfg`={$datos[$i]['idcentrocfg']}
                      GROUP BY r.`id_contenido` ORDER BY b.porcen_alum_respok ";
                      $this->db->query($query2);
      }

    }

    function llena_contenidosxidcentrocfg(){
      $query="SELECT idcentrocfg FROM centrocfg";
      $datos=$this->db->query($query)->result_array();
      for($i=0; $i<count($datos); $i++){
        $query2="INSERT INTO planea_ctematicos_x_idcentrocfg (
           `idcentrocfg`,
            `periodo_planea`,
            `mct_lyc_p1`,
            `mct_lyc1`,
            `mct_lyc_p2`,
            `mct_lyc2`,
            `mct_lyc_p3`,
            `mct_lyc3`,
            `mct_lyc_p4`,
            `mct_lyc4`,
            `mct_lyc_p5`,
            `mct_lyc5`,
            `mct_mat_p1`,
            `mct_mat1`,
            `mct_mat_p2`,
            `mct_mat2`,
            `mct_mat_p3`,
            `mct_mat3`,
            `mct_mat_p4`,
            `mct_mat4`,
            `mct_mat_p5`,
            `mct_mat5`
          )
          SELECT c.idcentrocfg,
            t1.periodo,
            t1.porcentaje AS p1,
            t1.contenido AS c1,
            t2.porcentaje AS p2,
            t2.contenido AS c2,
            t3.porcentaje AS p3,
            t3.contenido AS c3,
            t4.porcentaje AS p4,
            t4.contenido AS c4,
            t5.porcentaje AS p5,
            t5.contenido AS c5,
            t6.porcentaje AS p6,
            t6.contenido AS c6,
            t7.porcentaje AS p7,
            t7.contenido AS c7,
            t8.porcentaje AS p8,
            t8.contenido AS c8,
            t9.porcentaje AS p9,
            t9.contenido AS c9,
            t10.porcentaje AS p10,
            t10.contenido AS c10
          FROM centrocfg c
          INNER JOIN (
            SELECT idcentrocfg,periodo,contenido,porcentaje FROM temporal_contenidosxcfg
            WHERE idcentrocfg={$datos[$i]['idcentrocfg']} LIMIT 1
            ) AS t1 ON t1.`idcentrocfg`=c.`idcentrocfg`
          INNER JOIN (
            SELECT idcentrocfg,periodo,contenido,porcentaje FROM temporal_contenidosxcfg
            WHERE idcentrocfg={$datos[$i]['idcentrocfg']} LIMIT 1,1
            )AS t2 ON t2.`idcentrocfg`=c.`idcentrocfg`
          INNER JOIN (
            SELECT idcentrocfg,periodo,contenido,porcentaje FROM temporal_contenidosxcfg
            WHERE idcentrocfg={$datos[$i]['idcentrocfg']} LIMIT 2,1
            ) AS t3 ON t3.`idcentrocfg`=c.`idcentrocfg`
          INNER JOIN (
            SELECT idcentrocfg,periodo,contenido,porcentaje FROM temporal_contenidosxcfg
            WHERE idcentrocfg={$datos[$i]['idcentrocfg']} LIMIT 3,1
            ) AS t4 ON t4.`idcentrocfg`=c.`idcentrocfg`
          INNER JOIN (
            SELECT idcentrocfg,periodo,contenido,porcentaje FROM temporal_contenidosxcfg
            WHERE idcentrocfg={$datos[$i]['idcentrocfg']} LIMIT 4,1
            ) AS t5 ON t5.`idcentrocfg`=c.`idcentrocfg`
          INNER JOIN (
            SELECT idcentrocfg,periodo,contenido,porcentaje FROM temporal_contenidosxcfg
            WHERE idcentrocfg={$datos[$i]['idcentrocfg']} LIMIT 5,1
            ) AS t6 ON t6.`idcentrocfg`=c.`idcentrocfg`
          INNER JOIN (
            SELECT idcentrocfg,periodo,contenido,porcentaje FROM temporal_contenidosxcfg
            WHERE idcentrocfg={$datos[$i]['idcentrocfg']} LIMIT 6,1
            ) AS t7 ON t7.`idcentrocfg`=c.`idcentrocfg`
          INNER JOIN (
            SELECT idcentrocfg,periodo,contenido,porcentaje FROM temporal_contenidosxcfg
            WHERE idcentrocfg={$datos[$i]['idcentrocfg']} LIMIT 7,1
            ) AS t8 ON t8.`idcentrocfg`=c.`idcentrocfg`
          INNER JOIN (
            SELECT idcentrocfg,periodo,contenido,porcentaje FROM temporal_contenidosxcfg
            WHERE idcentrocfg={$datos[$i]['idcentrocfg']} LIMIT 8,1
            ) AS t9 ON t9.`idcentrocfg`=c.`idcentrocfg`
          INNER JOIN (
            SELECT idcentrocfg,periodo,contenido,porcentaje FROM temporal_contenidosxcfg
            WHERE idcentrocfg={$datos[$i]['idcentrocfg']} LIMIT 9,1
            ) AS t10 ON t10.`idcentrocfg`=c.`idcentrocfg`";
        $this->db->query($query2);
      }
    }

    function llena_tabla_reporte_apa(){

      $query="INSERT INTO `apa_ok`.`reporte_apa_xidcentrocfg` (
            `idcentrocfg`,
            `cct`,
            `turno`,
            `periodo`,
            `ciclo`,
            `idnivel`,
            `encabezado_n_nivel`,
            `encabezado_n_periodo`,
            `encabezado_n_escuela`,
            `encabezado_muni_escuela`,
            `encabezado_n_turno`,
            `encabezado_n_modalidad`,
            `encabezado_n_direc_resp`,
            `asi_est_ciclo1`,
            `asi_est_al_t`,
            `asi_est_al_1`,
            `asi_est_al_2`,
            `asi_est_al_3`,
            `asi_est_al_4`,
            `asi_est_al_5`,
            `asi_est_al_6`,
            `asi_est_gr_t`,
            `asi_est_gr_1`,
            `asi_est_gr_2`,
            `asi_est_gr_3`,
            `asi_est_gr_4`,
            `asi_est_gr_5`,
            `asi_est_gr_6`,
            `asi_est_gruposmulti`,
            `asi_est_do_t`,
            `asi_est_ac_ciclo`,
            `asi_est_h1_ciclo`,
            `asi_est_h1_al_1`,
            `asi_est_h1_al_2`,
            `asi_est_h1_al_3`,
            `asi_est_h1_al_4`,
            `asi_est_h1_al_5`,
            `asi_est_h1_al_6`,
            `asi_est_h1_gr_t`,
            `asi_est_h2_ciclo`,
            `asi_est_h2_al_1`,
            `asi_est_h2_al_2`,
            `asi_est_h2_al_3`,
            `asi_est_h2_al_4`,
            `asi_est_h2_al_5`,
            `asi_est_h2_al_6`,
            `asi_est_h2_gr_t`,
            `asi_anio_inegi`,
            `asi_rez_gedad_noasiste`,
            `asi_rez_pob_t`,
            `asi_rez_pob_m`,
            `asi_rez_pob_h`,
            `asi_rez_noasiste_t`,
            `asi_rez_noasiste_m`,
            `asi_rez_noasiste_h`,
            `asi_analfabeta_t`,
            `asi_analfabeta_m`,
            `asi_analfabeta_h`,
            `asi_lenguas_nativas`,
            `per_riesgo_al_t`,
            `per_riesgo_al_muy_alto`,
            `per_riesgo_al_alto`,
            `per_riesgo_al_medio`,
            `per_riesgo_al_bajo`,
            `per_riesgo_al_muy_alto_1`,
            `per_riesgo_al_muy_alto_2`,
            `per_riesgo_al_muy_alto_3`,
            `per_riesgo_al_muy_alto_4`,
            `per_riesgo_al_muy_alto_5`,
            `per_riesgo_al_muy_alto_6`,
            `per_riesgo_al_alto_1`,
            `per_riesgo_al_alto_2`,
            `per_riesgo_al_alto_3`,
            `per_riesgo_al_alto_4`,
            `per_riesgo_al_alto_5`,
            `per_riesgo_al_alto_6`,
            `per_ind_ciclo`,
            `per_ind_retencion`,
            `per_ind_aprobacion`,
            `per_ind_et`,
            `per_bit_datos_subestimados_inasistencia`,
            `apr_ete_ciclo_et`,
            `apr_ete_periodo_planea`,
            `apr_ete`,
            `apr_planea1_nlogro_esc_periodo`,
            `apr_planea1_nlogro_esc_lyc_i`,
            `apr_planea1_nlogro_esc_lyc_ii`,
            `apr_planea1_nlogro_esc_lyc_iii`,
            `apr_planea1_nlogro_esc_lyc_iv`,
            `apr_planea1_nlogro_esc_lyc_ii-iii-iv`,
            `apr_planea1_nlogro_esc_mat_i`,
            `apr_planea1_nlogro_esc_mat_ii`,
            `apr_planea1_nlogro_esc_mat_iii`,
            `apr_planea1_nlogro_esc_mat_iv`,
            `apr_planea1_nlogro_esc_mat_ii-iii-iv`,
            `apr_planea2_nlogro_esc_periodo`,
            `apr_planea2_nlogro_esc_lyc_i`,
            `apr_planea2_nlogro_esc_lyc_ii-iii-iv`,
            `apr_planea2_nlogro_esc_mat_i`,
            `apr_planea2_nlogro_esc_mat_ii-iii-iv`,
            `apr_planea_nlogro_estado_periodo`,
            `apr_planea_nlogro_estado_lyc_i`,
            `apr_planea_nlogro_estado_lyc_ii-iii-iv`,
            `apr_planea_nlogro_estado_mat_i`,
            `apr_planea_nlogro_estado_mat_ii-iii-iv`,
            `apr_planea_nlogro_pais_periodo`,
            `apr_planea_nlogro_pais_lyc_i`,
            `apr_planea_nlogro_pais_lyc_ii-iii-iv`,
            `apr_planea_nlogro_pais_mat_i`,
            `apr_planea_nlogro_pais_mat_ii-iii-iv`,
            `apr_prom_al_esc_esp_5`,
            `apr_prom_al_esc_esp_6-7`,
            `apr_prom_al_esc_esp_8-9`,
            `apr_prom_al_esc_esp_10`,
            `apr_prom_al_esc_mat_5`,
            `apr_prom_al_esc_mat_6-7`,
            `apr_prom_al_esc_mat_8-9`,
            `apr_prom_al_esc_mat_10`,
            `apr_planea1_ct_esc_lyc_1por`,
            `apr_planea1_ct_esc_lyc_1txt`,
            `apr_planea1_ct_esc_lyc_2por`,
            `apr_planea1_ct_esc_lyc_2txt`,
            `apr_planea1_ct_esc_lyc_3por`,
            `apr_planea1_ct_esc_lyc_3txt`,
            `apr_planea1_ct_esc_lyc_4por`,
            `apr_planea1_ct_esc_lyc_4txt`,
            `apr_planea1_ct_esc_lyc_5por`,
            `apr_planea1_ct_esc_lyc_5txt`,
            `apr_planea1_ct_esc_mat_1por`,
            `apr_planea1_ct_esc_mat_1txt`,
            `apr_planea1_ct_esc_mat_2por`,
            `apr_planea1_ct_esc_mat_2txt`,
            `apr_planea1_ct_esc_mat_3por`,
            `apr_planea1_ct_esc_mat_3txt`,
            `apr_planea1_ct_esc_mat_4por`,
            `apr_planea1_ct_esc_mat_4txt`,
            `apr_planea1_ct_esc_mat_5por`,
            `apr_planea1_ct_esc_mat_5txt`
          )
          SELECT
                      cfg.idcentrocfg AS idcentrocfg,
                      ct.cct,
                      ct.turno,
                      '2019-2020' AS periodo,
                      '2019-2020' AS ciclo,
                      cfg.nivel AS idnivel,
                      n.descr AS  encabezado_n_nivel,
                'Periodo 1' AS`encabezado_n_periodo`,
                      ct.nombre AS encabezado_n_escuela,
                      m.nombre AS encabezado_muni_escuela,
                      t.descripcion AS encabezado_n_turno,
                      '' AS encabezado_n_modalidad,
                      CONCAT(p.nombre,' ',p.apell1,' ',p.apell2) AS encabezado_n_direc_resp,
                '' AS asi_est_ciclo1,
                est.t_alumnos AS asi_est_al_t,
                      est.alumnos1 AS asi_est_al_1,
                      est.alumnos2 AS asi_est_al_2,
                      est.alumnos3 AS asi_est_al_3,
                      est.alumnos4 AS asi_est_al_4,
                      est.alumnos5 AS asi_est_al_5,
                      est.alumnos6 AS asi_est_al_6,
                      est.t_grupos AS asi_est_gr_t,
                      est.grupos1 AS asi_est_gr_1,
                      est.grupos2 AS asi_est_gr_2,
                      est.grupos3 AS asi_est_gr_3,
                      est.grupos4 AS asi_est_gr_4,
                      est.grupos5 AS asi_est_gr_5,
                      est.grupos6 AS asi_est_gr_6,
                      est.gruposmulti AS asi_est_gruposmulti,
                      est.t_docentes AS asi_est_do_t,
                      '' AS asi_est_ac_ciclo,
                      '' AS `asi_est_h1_ciclo`,
                      e1.alumnos1 AS asi_est_h1_al_1,
                      e1.alumnos2 AS asi_est_h1_al_2,
                      e1.alumnos3 AS asi_est_h1_al_3,
                      e1.alumnos4 AS asi_est_h1_al_4,
                      e1.alumnos5 AS asi_est_h1_al_5,
                      e1.alumnos6 AS asi_est_h1_al_6,
                      e1.t_alumnos AS asi_est_h1_gr_t,
                      '' AS `asi_est_h2_ciclo`,
                      e2.alumnos1 AS asi_est_h2_al_1,
                      e2.alumnos2 AS asi_est_h2_al_2,
                      e2.alumnos3 AS asi_est_h2_al_3,
                      e2.alumnos4 AS asi_est_h2_al_4,
                      e2.alumnos5 AS asi_est_h2_al_5,
                      e2.alumnos6 AS asi_est_h2_al_6,
                      e2.t_alumnos AS asi_est_h2_gr_t,
                      '' AS `asi_rez_gedad_noasiste`,
                      (re.p3A14_ptotal_m+re.p3A14_ptotal_h) AS asi_rez_pob_t,
                      re.p3A14_ptotal_m AS asi_rez_pob_m,
                      re.p3A14_ptotal_h AS asi_rez_pob_h,
                      (re.p3A14_noa_m+re.p3A14_noa_h) AS asi_rez_pob_t,
                      re.p3A14_noa_m AS asi_rez_noasiste_m,
                      re.p3A14_noa_h AS asi_rez_noasiste_h,
                      (an.analfabetismo_mayor15_m+an.analfabetismo_mayor15_h) AS asi_analfabeta_t
                      an.analfabetismo_mayor15_m AS asi_analfabeta_m,
                      an.analfabetismo_mayor15_h AS asi_analfabeta_h,
                      '' lenguas_nativas,
                      `per_riesgo_al_t`,
                      '' AS `per_riesgo_al_muy_alto`,
                      '' AS`per_riesgo_al_alto`,
                      '' AS `per_riesgo_al_medio`,
                      '' AS `per_riesgo_al_bajo`,
                      '' AS `per_riesgo_al_muy_alto_1`,
                      '' AS `per_riesgo_al_muy_alto_2`,
                      '' AS `per_riesgo_al_muy_alto_3`,
                      '' AS `per_riesgo_al_muy_alto_4`,
                      '' AS `per_riesgo_al_muy_alto_5`,
                      '' AS `per_riesgo_al_muy_alto_6`,
                      '' AS `per_riesgo_al_alto_1`,
                      '' AS `per_riesgo_al_alto_2`,
                      '' AS `per_riesgo_al_alto_3`,
                      '' AS `per_riesgo_al_alto_4`,
                      '' AS `per_riesgo_al_alto_5`,
                      '' AS `per_riesgo_al_alto_6`,
                      '' AS `per_ind_ciclo`,
                            ind.retencion AS per_ind_retencion,
                            ind.aprobacion AS per_ind_aprobacion,
                            ind.eficiencia_terminal AS per_ind_et,
                            '' AS `per_bit_datos_subestimados_inasistencia`,
                            '' AS `apr_ete_ciclo_et`,
                      '' AS `apr_ete_periodo_planea`,
                      '' AS `apr_ete`,
                      '' AS `apr_planea1_nlogro_esc_periodo`,
                            pcfg.ni_lyc AS apr_planea1_nlogro_esc_lyc_i,
                            pcfg.nii_lyc AS apr_planea1_nlogro_esc_lyc_ii,
                            pcfg.niii_lyc AS apr_planea1_nlogro_esc_lyc_iii,
                            pcfg.niv_lyc AS apr_planea1_nlogro_esc_lyc_iv,
                            (pcfg.nii_lyc+pcfg.niii_lyc+pcfg.niv_lyc) AS 'apr_planea1_nlogro_esc_lyc_ii-iii-iv',
                            pcfg.ni_mat AS apr_planea1_nlogro_esc_mat_i,
                            pcfg.nii_mat AS apr_planea1_nlogro_esc_mat_ii,
                            pcfg.niii_mat AS apr_planea1_nlogro_esc_mat_iii,
                            pcfg.niv_mat AS apr_planea1_nlogro_esc_mat_iv,
                            (pcfg.nii_mat+pcfg.niii_mat+pcfg.niv_mat) AS 'apr_planea1_nlogro_esc_mat_ii-iii-iv',
                     '' AS `apr_planea2_nlogro_esc_periodo`,
                            pcfg1.ni_lyc AS apr_planea2_nlogro_esc_lyc_i,
                            (pcfg1.nii_lyc+pcfg1.niii_lyc+pcfg1.niv_lyc) AS 'apr_planea2_nlogro_esc_lyc_ii-iii-iv',
                            pcfg1.ni_mat AS apr_planea2_nlogro_esc_mat_i,
                            (pcfg1.nii_mat+pcfg1.niii_mat+pcfg1.niv_mat) AS 'apr_planea2_nlogro_esc_mat_ii-iii-iv',
                            ent.periodo_planea AS apr_planea_nlogro_estado_periodo,
                            ent.ni_lyc AS apr_planea_nlogro_estado_lyc_i,
                            (ent.nii_lyc+ent.niii_lyc+ent.niv_lyc) AS 'apr_planea_nlogro_estado_lyc_ii-iii-iv',
                            ent.ni_mat AS apr_planea_nlogro_estado_mat_i,
                            (ent.nii_mat+ent.niii_mat+ent.niv_mat) AS 'apr_planea_nlogro_estado_mat_ii-iii-iv',
                            nac.periodo_planea AS apr_planea_nlogro_pais_periodo,
                            nac.ni_lyc AS apr_planea_nlogro_pais_lyc_i,
                            (nac.nii_lyc+nac.niii_lyc+nac.niv_lyc) AS 'apr_planea_nlogro_pais_lyc_ii-iii-iv',
                            nac.ni_mat AS apr_planea_nlogro_pais_mat_i,
                            (nac.nii_mat+nac.niii_mat+nac.niv_mat) AS 'apr_planea_nlogro_pais_mat_ii-iii-iv',
                      '' AS `apr_prom_al_esc_esp_5`,
                      '' AS `apr_prom_al_esc_esp_6-7`,
                            '' AS `apr_prom_al_esc_esp_8-9`,
                            '' AS `apr_prom_al_esc_esp_10`,
                            '' AS `apr_prom_al_esc_mat_5`,
                            '' AS `apr_prom_al_esc_mat_6-7`,
                            '' AS `apr_prom_al_esc_mat_8-9`,
                            '' AS `apr_prom_al_esc_mat_10`,
                            pct.mct_lyc_p1 AS apr_planea1_ct_esc_lyc_1por,
                            pct.mct_lyc1 AS apr_planea1_ct_esc_lyc_1txt,
                            pct.mct_lyc_p2 AS apr_planea1_ct_esc_lyc_2por,
                            pct.mct_lyc2 AS apr_planea1_ct_esc_lyc_2txt,
                            pct.mct_lyc_p3 AS apr_planea1_ct_esc_lyc_3por,
                            pct.mct_lyc3 AS apr_planea1_ct_esc_lyc_3txt,
                            pct.mct_lyc_p4 AS apr_planea1_ct_esc_lyc_4por,
                            pct.mct_lyc4 AS apr_planea1_ct_esc_lyc_4txt,
                            pct.mct_lyc_p5 AS apr_planea1_ct_esc_lyc_5por,
                            pct.mct_lyc5 AS apr_planea1_ct_esc_lyc_5txt,
                            pct.mct_mat_p1 AS apr_planea1_ct_esc_mat_1por,
                            pct.mct_mat1 AS apr_planea1_ct_esc_mat_1txt,
                            pct.mct_mat_p2 AS apr_planea1_ct_esc_mat_2por,
                            pct.mct_mat2 AS pr_planea1_ct_esc_mat_2txt,
                            pct.mct_mat_p3 AS apr_planea1_ct_esc_mat_3por,
                            pct.mct_mat3  AS apr_planea1_ct_esc_mat_3txt,
                            pct.mct_mat_p4 AS apr_planea1_ct_esc_mat_4por,
                            pct.mct_mat4 AS apr_planea1_ct_esc_mat_4txt,
                            pct.mct_mat_p4 AS apr_planea1_ct_esc_mat_5por,
                            pct.mct_mat4 AS apr_planea1_ct_esc_mat_5txt
                            FROM centrocfg cfg
                            INNER JOIN cct ct ON ct.idct=cfg.idct
                            INNER JOIN municipio m ON m.idmunicipio=ct.idmunicipio
                            INNER JOIN niveleducativo n ON n.idnivel=cfg.nivel
                            INNER JOIN turno t ON t.idturno=cfg.turno
                            LEFT JOIN personal p ON p.idcentrocfg=cfg.idcentrocfg AND idfuncion=1
                            LEFT JOIN estadistica_x_idcentrocfg est ON  est.idcentrocfg=cfg.idcentrocfg AND est.idciclo=1
                            LEFT JOIN estadistica_x_idcentrocfg e1 ON  e1.idcentrocfg=cfg.idcentrocfg AND e1.idciclo=2
                            LEFT JOIN estadistica_x_idcentrocfg e2 ON  e2.idcentrocfg=cfg.idcentrocfg AND e2.idciclo=3
                            INNER JOIN rezago_edu_xmuni re ON re.idmunicipio=ct.idmunicipio
                            INNER JOIN analfabetismo_xmuni an ON an.idmunicipio=ct.idmunicipio
                            LEFT JOIN indicadores_x_idcentrocfg ind ON ind.idcentrocfg=cfg.idcentrocfg AND ind.idciclo=1
                            LEFT JOIN planea_nlogro_x_idcentrocfg pcfg ON pcfg.idcentrocfg=cfg.idcentrocfg AND pcfg.periodo_planea='2018'
                            LEFT JOIN planea_nlogro_x_idcentrocfg pcfg1 ON pcfg1.idcentrocfg=cfg.idcentrocfg AND pcfg1.periodo_planea='2015'
                            LEFT JOIN planea_nlogro_x_entidad ent ON ent.idnivel=n.idnivel AND ent.periodo_planea='2018'
                            LEFT JOIN planea_nlogro_x_nacional nac ON nac.idnivel=n.idnivel AND nac.periodo_planea='2018'
                            LEFT JOIN planea_ctematicos_x_idcentrocfg pct ON pct.idcentrocfg=cfg.idcentrocfg
                            WHERE cfg.nivel=2";
        $this->db->query($query);

        $query2="INSERT INTO `apa_ok`.`reporte_apa_xidcentrocfg` (
            `idcentrocfg`,
            `cct`,
            `turno`,
            `periodo`,
            `ciclo`,
            `idnivel`,
            `encabezado_n_nivel`,
            `encabezado_n_periodo`,
            `encabezado_n_escuela`,
            `encabezado_muni_escuela`,
            `encabezado_n_turno`,
            `encabezado_n_modalidad`,
            `encabezado_n_direc_resp`,
            `asi_est_ciclo1`,
            `asi_est_al_t`,
            `asi_est_al_1`,
            `asi_est_al_2`,
            `asi_est_al_3`,
            `asi_est_al_4`,
            `asi_est_al_5`,
            `asi_est_al_6`,
            `asi_est_gr_t`,
            `asi_est_gr_1`,
            `asi_est_gr_2`,
            `asi_est_gr_3`,
            `asi_est_gr_4`,
            `asi_est_gr_5`,
            `asi_est_gr_6`,
            `asi_est_gruposmulti`,
            `asi_est_do_t`,
            `asi_est_ac_ciclo`,
            `asi_est_h1_ciclo`,
            `asi_est_h1_al_1`,
            `asi_est_h1_al_2`,
            `asi_est_h1_al_3`,
            `asi_est_h1_al_4`,
            `asi_est_h1_al_5`,
            `asi_est_h1_al_6`,
            `asi_est_h1_gr_t`,
            `asi_est_h2_ciclo`,
            `asi_est_h2_al_1`,
            `asi_est_h2_al_2`,
            `asi_est_h2_al_3`,
            `asi_est_h2_al_4`,
            `asi_est_h2_al_5`,
            `asi_est_h2_al_6`,
            `asi_est_h2_gr_t`,
            `asi_anio_inegi`,
            `asi_rez_gedad_noasiste`,
            `asi_rez_pob_t`,
            `asi_rez_pob_m`,
            `asi_rez_pob_h`,
            `asi_rez_noasiste_t`,
            `asi_rez_noasiste_m`,
            `asi_rez_noasiste_h`,
            `asi_analfabeta_t`,
            `asi_analfabeta_m`,
            `asi_analfabeta_h`,
            `asi_lenguas_nativas`,
            `per_riesgo_al_t`,
            `per_riesgo_al_muy_alto`,
            `per_riesgo_al_alto`,
            `per_riesgo_al_medio`,
            `per_riesgo_al_bajo`,
            `per_riesgo_al_muy_alto_1`,
            `per_riesgo_al_muy_alto_2`,
            `per_riesgo_al_muy_alto_3`,
            `per_riesgo_al_muy_alto_4`,
            `per_riesgo_al_muy_alto_5`,
            `per_riesgo_al_muy_alto_6`,
            `per_riesgo_al_alto_1`,
            `per_riesgo_al_alto_2`,
            `per_riesgo_al_alto_3`,
            `per_riesgo_al_alto_4`,
            `per_riesgo_al_alto_5`,
            `per_riesgo_al_alto_6`,
            `per_ind_ciclo`,
            `per_ind_retencion`,
            `per_ind_aprobacion`,
            `per_ind_et`,
            `per_bit_datos_subestimados_inasistencia`,
            `apr_ete_ciclo_et`,
            `apr_ete_periodo_planea`,
            `apr_ete`,
            `apr_planea1_nlogro_esc_periodo`,
            `apr_planea1_nlogro_esc_lyc_i`,
            `apr_planea1_nlogro_esc_lyc_ii`,
            `apr_planea1_nlogro_esc_lyc_iii`,
            `apr_planea1_nlogro_esc_lyc_iv`,
            `apr_planea1_nlogro_esc_lyc_ii-iii-iv`,
            `apr_planea1_nlogro_esc_mat_i`,
            `apr_planea1_nlogro_esc_mat_ii`,
            `apr_planea1_nlogro_esc_mat_iii`,
            `apr_planea1_nlogro_esc_mat_iv`,
            `apr_planea1_nlogro_esc_mat_ii-iii-iv`,
            `apr_planea2_nlogro_esc_periodo`,
            `apr_planea2_nlogro_esc_lyc_i`,
            `apr_planea2_nlogro_esc_lyc_ii-iii-iv`,
            `apr_planea2_nlogro_esc_mat_i`,
            `apr_planea2_nlogro_esc_mat_ii-iii-iv`,
            `apr_planea_nlogro_estado_periodo`,
            `apr_planea_nlogro_estado_lyc_i`,
            `apr_planea_nlogro_estado_lyc_ii-iii-iv`,
            `apr_planea_nlogro_estado_mat_i`,
            `apr_planea_nlogro_estado_mat_ii-iii-iv`,
            `apr_planea_nlogro_pais_periodo`,
            `apr_planea_nlogro_pais_lyc_i`,
            `apr_planea_nlogro_pais_lyc_ii-iii-iv`,
            `apr_planea_nlogro_pais_mat_i`,
            `apr_planea_nlogro_pais_mat_ii-iii-iv`,
            `apr_prom_al_esc_esp_5`,
            `apr_prom_al_esc_esp_6-7`,
            `apr_prom_al_esc_esp_8-9`,
            `apr_prom_al_esc_esp_10`,
            `apr_prom_al_esc_mat_5`,
            `apr_prom_al_esc_mat_6-7`,
            `apr_prom_al_esc_mat_8-9`,
            `apr_prom_al_esc_mat_10`,
            `apr_planea1_ct_esc_lyc_1por`,
            `apr_planea1_ct_esc_lyc_1txt`,
            `apr_planea1_ct_esc_lyc_2por`,
            `apr_planea1_ct_esc_lyc_2txt`,
            `apr_planea1_ct_esc_lyc_3por`,
            `apr_planea1_ct_esc_lyc_3txt`,
            `apr_planea1_ct_esc_lyc_4por`,
            `apr_planea1_ct_esc_lyc_4txt`,
            `apr_planea1_ct_esc_lyc_5por`,
            `apr_planea1_ct_esc_lyc_5txt`,
            `apr_planea1_ct_esc_mat_1por`,
            `apr_planea1_ct_esc_mat_1txt`,
            `apr_planea1_ct_esc_mat_2por`,
            `apr_planea1_ct_esc_mat_2txt`,
            `apr_planea1_ct_esc_mat_3por`,
            `apr_planea1_ct_esc_mat_3txt`,
            `apr_planea1_ct_esc_mat_4por`,
            `apr_planea1_ct_esc_mat_4txt`,
            `apr_planea1_ct_esc_mat_5por`,
            `apr_planea1_ct_esc_mat_5txt`
          )
          SELECT
                      cfg.idcentrocfg AS idcentrocfg,
                      ct.cct,
                      ct.turno,
                      '2019-2020' AS periodo,
                      '2019-2020' AS ciclo,
                      cfg.nivel AS idnivel,
                      n.descr AS  encabezado_n_nivel,
                'Periodo 1' AS`encabezado_n_periodo`,
                      ct.nombre AS encabezado_n_escuela,
                      m.nombre AS encabezado_muni_escuela,
                      t.descripcion AS encabezado_n_turno,
                      '' AS encabezado_n_modalidad,
                      CONCAT(p.nombre,' ',p.apell1,' ',p.apell2) AS encabezado_n_direc_resp,
                '' AS asi_est_ciclo1,
                est.t_alumnos AS asi_est_al_t,
                      est.alumnos1 AS asi_est_al_1,
                      est.alumnos2 AS asi_est_al_2,
                      est.alumnos3 AS asi_est_al_3,
                      est.alumnos4 AS asi_est_al_4,
                      est.alumnos5 AS asi_est_al_5,
                      est.alumnos6 AS asi_est_al_6,
                      est.t_grupos AS asi_est_gr_t,
                      est.grupos1 AS asi_est_gr_1,
                      est.grupos2 AS asi_est_gr_2,
                      est.grupos3 AS asi_est_gr_3,
                      est.grupos4 AS asi_est_gr_4,
                      est.grupos5 AS asi_est_gr_5,
                      est.grupos6 AS asi_est_gr_6,
                      est.gruposmulti AS asi_est_gruposmulti,
                      est.t_docentes AS asi_est_do_t,
                      '' AS asi_est_ac_ciclo,
                      '' AS `asi_est_h1_ciclo`,
                      e1.alumnos1 AS asi_est_h1_al_1,
                      e1.alumnos2 AS asi_est_h1_al_2,
                      e1.alumnos3 AS asi_est_h1_al_3,
                      e1.alumnos4 AS asi_est_h1_al_4,
                      e1.alumnos5 AS asi_est_h1_al_5,
                      e1.alumnos6 AS asi_est_h1_al_6,
                      e1.t_alumnos AS asi_est_h1_gr_t,
                      '' AS `asi_est_h2_ciclo`,
                      e2.alumnos1 AS asi_est_h2_al_1,
                      e2.alumnos2 AS asi_est_h2_al_2,
                      e2.alumnos3 AS asi_est_h2_al_3,
                      e2.alumnos4 AS asi_est_h2_al_4,
                      e2.alumnos5 AS asi_est_h2_al_5,
                      e2.alumnos6 AS asi_est_h2_al_6,
                      e2.t_alumnos AS asi_est_h2_gr_t,
                      '' AS `asi_rez_gedad_noasiste`,
                      (re.p3A14_ptotal_m+re.p3A14_ptotal_h) AS asi_rez_pob_t,
                      re.p3A14_ptotal_m AS asi_rez_pob_m,
                      re.p3A14_ptotal_h AS asi_rez_pob_h,
                      (re.p3A14_noa_m+re.p3A14_noa_h) AS asi_rez_pob_t,
                      re.p3A14_noa_m AS asi_rez_noasiste_m,
                      re.p3A14_noa_h AS asi_rez_noasiste_h,
                      (an.analfabetismo_mayor15_m+an.analfabetismo_mayor15_h) AS asi_analfabeta_t
                      an.analfabetismo_mayor15_m AS asi_analfabeta_m,
                      an.analfabetismo_mayor15_h AS asi_analfabeta_h,
                      '' lenguas_nativas,
                      `per_riesgo_al_t`,
                      '' AS `per_riesgo_al_muy_alto`,
                      '' AS`per_riesgo_al_alto`,
                      '' AS `per_riesgo_al_medio`,
                      '' AS `per_riesgo_al_bajo`,
                      '' AS `per_riesgo_al_muy_alto_1`,
                      '' AS `per_riesgo_al_muy_alto_2`,
                      '' AS `per_riesgo_al_muy_alto_3`,
                      '' AS `per_riesgo_al_muy_alto_4`,
                      '' AS `per_riesgo_al_muy_alto_5`,
                      '' AS `per_riesgo_al_muy_alto_6`,
                      '' AS `per_riesgo_al_alto_1`,
                      '' AS `per_riesgo_al_alto_2`,
                      '' AS `per_riesgo_al_alto_3`,
                      '' AS `per_riesgo_al_alto_4`,
                      '' AS `per_riesgo_al_alto_5`,
                      '' AS `per_riesgo_al_alto_6`,
                      '' AS `per_ind_ciclo`,
                            ind.retencion AS per_ind_retencion,
                            ind.aprobacion AS per_ind_aprobacion,
                            ind.eficiencia_terminal AS per_ind_et,
                            '' AS `per_bit_datos_subestimados_inasistencia`,
                            '' AS `apr_ete_ciclo_et`,
                      '' AS `apr_ete_periodo_planea`,
                      '' AS `apr_ete`,
                      '' AS `apr_planea1_nlogro_esc_periodo`,
                            pcfg.ni_lyc AS apr_planea1_nlogro_esc_lyc_i,
                            pcfg.nii_lyc AS apr_planea1_nlogro_esc_lyc_ii,
                            pcfg.niii_lyc AS apr_planea1_nlogro_esc_lyc_iii,
                            pcfg.niv_lyc AS apr_planea1_nlogro_esc_lyc_iv,
                            (pcfg.nii_lyc+pcfg.niii_lyc+pcfg.niv_lyc) AS 'apr_planea1_nlogro_esc_lyc_ii-iii-iv',
                            pcfg.ni_mat AS apr_planea1_nlogro_esc_mat_i,
                            pcfg.nii_mat AS apr_planea1_nlogro_esc_mat_ii,
                            pcfg.niii_mat AS apr_planea1_nlogro_esc_mat_iii,
                            pcfg.niv_mat AS apr_planea1_nlogro_esc_mat_iv,
                            (pcfg.nii_mat+pcfg.niii_mat+pcfg.niv_mat) AS 'apr_planea1_nlogro_esc_mat_ii-iii-iv',
                     '' AS `apr_planea2_nlogro_esc_periodo`,
                            pcfg1.ni_lyc AS apr_planea2_nlogro_esc_lyc_i,
                            (pcfg1.nii_lyc+pcfg1.niii_lyc+pcfg1.niv_lyc) AS 'apr_planea2_nlogro_esc_lyc_ii-iii-iv',
                            pcfg1.ni_mat AS apr_planea2_nlogro_esc_mat_i,
                            (pcfg1.nii_mat+pcfg1.niii_mat+pcfg1.niv_mat) AS 'apr_planea2_nlogro_esc_mat_ii-iii-iv',
                            ent.periodo_planea AS apr_planea_nlogro_estado_periodo,
                            ent.ni_lyc AS apr_planea_nlogro_estado_lyc_i,
                            (ent.nii_lyc+ent.niii_lyc+ent.niv_lyc) AS 'apr_planea_nlogro_estado_lyc_ii-iii-iv',
                            ent.ni_mat AS apr_planea_nlogro_estado_mat_i,
                            (ent.nii_mat+ent.niii_mat+ent.niv_mat) AS 'apr_planea_nlogro_estado_mat_ii-iii-iv',
                            nac.periodo_planea AS apr_planea_nlogro_pais_periodo,
                            nac.ni_lyc AS apr_planea_nlogro_pais_lyc_i,
                            (nac.nii_lyc+nac.niii_lyc+nac.niv_lyc) AS 'apr_planea_nlogro_pais_lyc_ii-iii-iv',
                            nac.ni_mat AS apr_planea_nlogro_pais_mat_i,
                            (nac.nii_mat+nac.niii_mat+nac.niv_mat) AS 'apr_planea_nlogro_pais_mat_ii-iii-iv',
                      '' AS `apr_prom_al_esc_esp_5`,
                      '' AS `apr_prom_al_esc_esp_6-7`,
                            '' AS `apr_prom_al_esc_esp_8-9`,
                            '' AS `apr_prom_al_esc_esp_10`,
                            '' AS `apr_prom_al_esc_mat_5`,
                            '' AS `apr_prom_al_esc_mat_6-7`,
                            '' AS `apr_prom_al_esc_mat_8-9`,
                            '' AS `apr_prom_al_esc_mat_10`,
                            pct.mct_lyc_p1 AS apr_planea1_ct_esc_lyc_1por,
                            pct.mct_lyc1 AS apr_planea1_ct_esc_lyc_1txt,
                            pct.mct_lyc_p2 AS apr_planea1_ct_esc_lyc_2por,
                            pct.mct_lyc2 AS apr_planea1_ct_esc_lyc_2txt,
                            pct.mct_lyc_p3 AS apr_planea1_ct_esc_lyc_3por,
                            pct.mct_lyc3 AS apr_planea1_ct_esc_lyc_3txt,
                            pct.mct_lyc_p4 AS apr_planea1_ct_esc_lyc_4por,
                            pct.mct_lyc4 AS apr_planea1_ct_esc_lyc_4txt,
                            pct.mct_lyc_p5 AS apr_planea1_ct_esc_lyc_5por,
                            pct.mct_lyc5 AS apr_planea1_ct_esc_lyc_5txt,
                            pct.mct_mat_p1 AS apr_planea1_ct_esc_mat_1por,
                            pct.mct_mat1 AS apr_planea1_ct_esc_mat_1txt,
                            pct.mct_mat_p2 AS apr_planea1_ct_esc_mat_2por,
                            pct.mct_mat2 AS pr_planea1_ct_esc_mat_2txt,
                            pct.mct_mat_p3 AS apr_planea1_ct_esc_mat_3por,
                            pct.mct_mat3  AS apr_planea1_ct_esc_mat_3txt,
                            pct.mct_mat_p4 AS apr_planea1_ct_esc_mat_4por,
                            pct.mct_mat4 AS apr_planea1_ct_esc_mat_4txt,
                            pct.mct_mat_p4 AS apr_planea1_ct_esc_mat_5por,
                            pct.mct_mat4 AS apr_planea1_ct_esc_mat_5txt
                            FROM centrocfg cfg
                            INNER JOIN cct ct ON ct.idct=cfg.idct
                            INNER JOIN municipio m ON m.idmunicipio=ct.idmunicipio
                            INNER JOIN niveleducativo n ON n.idnivel=cfg.nivel
                            INNER JOIN turno t ON t.idturno=cfg.turno
                            LEFT JOIN personal p ON p.idcentrocfg=cfg.idcentrocfg AND idfuncion=1
                            LEFT JOIN estadistica_x_idcentrocfg est ON  est.idcentrocfg=cfg.idcentrocfg AND est.idciclo=1
                            LEFT JOIN estadistica_x_idcentrocfg e1 ON  e1.idcentrocfg=cfg.idcentrocfg AND e1.idciclo=2
                            LEFT JOIN estadistica_x_idcentrocfg e2 ON  e2.idcentrocfg=cfg.idcentrocfg AND e2.idciclo=3
                            INNER JOIN rezago_edu_xmuni re ON re.idmunicipio=ct.idmunicipio
                            INNER JOIN analfabetismo_xmuni an ON an.idmunicipio=ct.idmunicipio
                            LEFT JOIN indicadores_x_idcentrocfg ind ON ind.idcentrocfg=cfg.idcentrocfg AND ind.idciclo=1
                            LEFT JOIN planea_nlogro_x_idcentrocfg pcfg ON pcfg.idcentrocfg=cfg.idcentrocfg AND pcfg.periodo_planea='2019'
                            LEFT JOIN planea_nlogro_x_idcentrocfg pcfg1 ON pcfg1.idcentrocfg=cfg.idcentrocfg AND pcfg1.periodo_planea='2017'
                            LEFT JOIN planea_nlogro_x_entidad ent ON ent.idnivel=n.idnivel AND ent.periodo_planea='2019'
                            LEFT JOIN planea_nlogro_x_nacional nac ON nac.idnivel=n.idnivel AND nac.periodo_planea='2019'
                            LEFT JOIN planea_ctematicos_x_idcentrocfg pct ON pct.idcentrocfg=cfg.idcentrocfg AND pct.periodo_planea='2019'
                            WHERE cfg.nivel=3
                ";
        $this->db->query($query);
    }

    function inserta_calificaciones_primaria(){
      $query="SELECT idcentrocfg FROM centrocfg where nivel=2";
      $datos=$this->db->query($query)->result_array();
      for ($i=0; $i<count($datos); $i++) {
          $query2="INSERT INTO complemento_apa (
                  `idcentrocfg`,
                  `cct`,
                  `turno`,
                  `periodo`,
                  `ciclo`,
                  `idnivel`,
                  `encabezado_n_nivel`,
                  `encabezado_n_periodo`,
                  `encabezado_n_escuela`,
                  `encabezado_muni_escuela`,
                  `encabezado_n_turno`,
                  `encabezado_n_direc_resp`,
                  `apr_prom_al_esc_esp_5`,
                  `apr_prom_al_esc_esp_6-7`,
                  `apr_prom_al_esc_esp_8-9`,
                  `apr_prom_al_esc_esp_10`,
                  `apr_prom_al_esc_mat_5`,
                  `apr_prom_al_esc_mat_6-7`,
                  `apr_prom_al_esc_mat_8-9`,
                  `apr_prom_al_esc_mat_10`
                )
                SELECT  cfg.idcentrocfg,ct.cct,cfg.turno,
                  '1' AS periodo,'2020' AS ciclo,
                  '2' AS nivel,
                  'PRIMARIA' AS encabezado_nivel,
                  'PRIMER PERIODO' AS encabezado_periodo,
                  ct.`nombre` AS encabezado_n_escuela,
                  m.nombre AS encabezado_muni_escuela,
                  IF(cfg.turno='M','MATUTINO',IF(cfg.turno='V','VESPERTINO',IF(cfg.turno='N','NOCTURNO','DISCONTINUO'))) AS turno2,
                  p.nombre AS director,
                  g.total_5_lyc,
                  e.total_67_lyc,
                  c.total_89_lyc,
                  a.total_10_lyc,
                  h.total_5_mat,
                  f.total_67_mat,
                  d.total_89_mat,
                  b.total_10_mat
                FROM centrocfg cfg
                INNER JOIN cct ct ON ct.idct=cfg.idct
                INNER JOIN municipio m ON m.idmunicipio=ct.`idmunicipio`
                INNER  JOIN personal p ON p.idcentrocfg=cfg.idcentrocfg AND p.idfuncion=1
                LEFT JOIN (
                  SELECT cfg.idcentrocfg,COUNT(*) AS total_10_lyc
                            FROM centrocfg cfg
                            INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                            INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                            INNER JOIN alumno a ON a.idalumno=e.idalumno
                            INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                            INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Español'
                            WHERE eval.p1=10 AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}
                ) AS a ON a.idcentrocfg=cfg.idcentrocfg

                LEFT JOIN (
                  SELECT cfg.idcentrocfg,COUNT(*) AS total_10_mat
                            FROM centrocfg cfg
                            INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                            INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                            INNER JOIN alumno a ON a.idalumno=e.idalumno
                            INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                            INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Matematicas'
                            WHERE eval.p1=10 AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}
                ) AS b ON b.idcentrocfg=cfg.idcentrocfg
                LEFT JOIN (
                      SELECT cfg.idcentrocfg,COUNT(*) AS total_89_lyc
                            FROM centrocfg cfg
                            INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                            INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                            INNER JOIN alumno a ON a.idalumno=e.idalumno
                            INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                            INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Español'
                            WHERE (eval.p1>=8 AND eval.p1<=9) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}
                ) AS c ON c.idcentrocfg=cfg.idcentrocfg

                LEFT JOIN (
                       SELECT cfg.idcentrocfg,COUNT(*) AS total_89_mat
                            FROM centrocfg cfg
                            INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                            INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                            INNER JOIN alumno a ON a.idalumno=e.idalumno
                            INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                            INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Matematicas'
                            WHERE (eval.p1>=8 AND eval.p1<=9) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}
                ) AS d ON d.idcentrocfg=cfg.idcentrocfg

                LEFT JOIN (
                      SELECT cfg.idcentrocfg,COUNT(*) AS total_67_lyc
                            FROM centrocfg cfg
                            INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                            INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                            INNER JOIN alumno a ON a.idalumno=e.idalumno
                            INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                            INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Español'
                            WHERE (eval.p1>=6 AND eval.p1<=7) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}
                ) AS e ON e.idcentrocfg=cfg.idcentrocfg

                LEFT JOIN (
                       SELECT cfg.idcentrocfg,COUNT(*) AS total_67_mat
                            FROM centrocfg cfg
                            INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                            INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                            INNER JOIN alumno a ON a.idalumno=e.idalumno
                            INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                            INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Matematicas'
                            WHERE (eval.p1>=6 AND eval.p1<=7) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}
                ) AS f ON f.idcentrocfg=cfg.idcentrocfg

                LEFT JOIN (
                     SELECT cfg.idcentrocfg,COUNT(*) AS total_5_lyc
                            FROM centrocfg cfg
                            INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                            INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                            INNER JOIN alumno a ON a.idalumno=e.idalumno
                            INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                            INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Español'
                            WHERE (eval.p1=5) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}
                ) AS g ON g.idcentrocfg=cfg.idcentrocfg
                LEFT JOIN (
                       SELECT cfg.idcentrocfg,COUNT(*) AS total_5_mat
                            FROM centrocfg cfg
                            INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                            INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                            INNER JOIN alumno a ON a.idalumno=e.idalumno
                            INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                            INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Matematicas'
                            WHERE (eval.p1=5) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}
                ) AS h ON h.idcentrocfg=cfg.idcentrocfg
                WHERE cfg.idcentrocfg={$datos[$i]['idcentrocfg']}
          ";
          $this->db->query($query2);
      }

    }

    function inserta_calificaciones_secundaria(){
      $query="SELECT idcentrocfg FROM centrocfg where nivel=3";
      $datos=$this->db->query($query)->result_array();
      for ($i=0; $i<count($datos); $i++) {
        $query2="
                INSERT INTO complemento_apa (
                `idcentrocfg`,
                `cct`,
                `turno`,
                `periodo`,
                `ciclo`,
                `idnivel`,
                `encabezado_n_nivel`,
                `encabezado_n_periodo`,
                `encabezado_n_escuela`,
                `encabezado_muni_escuela`,
                `encabezado_n_turno`,
                `encabezado_n_direc_resp`,
                `apr_prom_al_esc_esp_5`,
                `apr_prom_al_esc_esp_6-7`,
                `apr_prom_al_esc_esp_8-9`,
                `apr_prom_al_esc_esp_10`,
                `apr_prom_al_esc_mat_5`,
                `apr_prom_al_esc_mat_6-7`,
                `apr_prom_al_esc_mat_8-9`,
                `apr_prom_al_esc_mat_10`
              )


              SELECT  cfg.idcentrocfg,ct.cct,cfg.turno,
                '1' AS periodo,'2020' AS ciclo,
                '2' AS nivel,
                'SECUNDARIA' AS encabezado_nivel,
                'PRIMER PERIODO' AS encabezado_periodo,
                ct.`nombre` AS encabezado_n_escuela,
                m.nombre AS encabezado_muni_escuela,
                IF(cfg.turno='M','MATUTINO',IF(cfg.turno='V','VESPERTINO',IF(cfg.turno='N','NOCTURNO','DISCONTINUO'))) AS turno2,
                p.nombre AS director,
                g.total_5_lyc,
                e.total_67_lyc,
                c.total_89_lyc,
                a.total_10_lyc,
                h.total_5_mat,
                f.total_67_mat,
                d.total_89_mat,
                b.total_10_mat
              FROM centrocfg cfg
              INNER JOIN cct ct ON ct.idct=cfg.idct
              INNER JOIN municipio m ON m.idmunicipio=ct.`idmunicipio`
              INNER  JOIN personal p ON p.idcentrocfg=cfg.idcentrocfg AND p.idfuncion=1
              LEFT JOIN (
                SELECT cfg.idcentrocfg,COUNT(*) AS total_10_lyc
                          FROM centrocfg cfg
                          INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                          INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                          INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                          INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Español'
                          WHERE eval.p1=10 AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}

              ) AS a ON a.idcentrocfg=cfg.idcentrocfg

              LEFT JOIN (
                SELECT cfg.idcentrocfg,COUNT(*) AS total_10_mat
                          FROM centrocfg cfg
                          INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                          INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                          INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                          INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Matematicas'
                          WHERE eval.p1=10 AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}

              ) AS b ON b.idcentrocfg=cfg.idcentrocfg
              LEFT JOIN (
                    SELECT cfg.idcentrocfg,COUNT(*) AS total_89_lyc
                          FROM centrocfg cfg
                          INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                          INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                          INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                          INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Español'
                          WHERE (eval.p1>=8 AND eval.p1<=9) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}

              ) AS c ON c.idcentrocfg=cfg.idcentrocfg

              LEFT JOIN (
                     SELECT cfg.idcentrocfg,COUNT(*) AS total_89_mat
                          FROM centrocfg cfg
                          INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                          INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                          INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                          INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Matematicas'
                          WHERE (eval.p1>=8 AND eval.p1<=9) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}

              ) AS d ON d.idcentrocfg=cfg.idcentrocfg

              LEFT JOIN (
                    SELECT cfg.idcentrocfg,COUNT(*) AS total_67_lyc
                          FROM centrocfg cfg
                          INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                          INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                          INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                          INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Español'
                          WHERE (eval.p1>=6 AND eval.p1<=7) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}

              ) AS e ON e.idcentrocfg=cfg.idcentrocfg

              LEFT JOIN (
                     SELECT cfg.idcentrocfg,COUNT(*) AS total_67_mat
                          FROM centrocfg cfg
                          INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                          INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                          INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                          INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Matematicas'
                          WHERE (eval.p1>=6 AND eval.p1<=7) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}
              ) AS f ON f.idcentrocfg=cfg.idcentrocfg

              LEFT JOIN (
                   SELECT cfg.idcentrocfg,COUNT(*) AS total_5_lyc
                          FROM centrocfg cfg
                          INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                          INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                          INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                          INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Español'
                          WHERE (eval.p1=5) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}
              ) AS g ON g.idcentrocfg=cfg.idcentrocfg
              LEFT JOIN (
                     SELECT cfg.idcentrocfg,COUNT(*) AS total_5_mat
                          FROM centrocfg cfg
                          INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                          INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                          INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                          INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Matematicas'
                          WHERE (eval.p1=5) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']}
              ) AS h ON h.idcentrocfg=cfg.idcentrocfg
              WHERE cfg.idcentrocfg={$datos[$i]['idcentrocfg']}
        ";
        $this->db->query($query2);

      }
    }

    function update_porcentaje_cal_primaria(){
      $query="SELECT idcentrocfg FROM centrocfg where nivel=2";
      $datos=$this->db->query($query)->result_array();
      for ($i=0; $i<count($datos); $i++) {
        $query="UPDATE complemento_apa t
              JOIN
              (
                SELECT  cfg.idcentrocfg,
                                ((g.total_5_lyc*100)/i.total_alumnos) AS 'apr_prom_al_esc_esp_5',
                                    ((e.total_67_lyc*100)/i.total_alumnos) AS 'apr_prom_al_esc_esp_6-7',
                                    ((c.total_89_lyc*100)/i.total_alumnos) AS 'apr_prom_al_esc_esp_8-9',
                                    ((a.total_10_lyc*100)/i.total_alumnos) AS 'apr_prom_al_esc_esp_10',
                                    ((h.total_5_mat*100)/i.total_alumnos) AS 'apr_prom_al_esc_mat_5',
                                    ((f.total_67_mat*100)/i.total_alumnos) AS 'apr_prom_al_esc_mat_6-7',
                                    ((d.total_89_mat*100)/i.total_alumnos) AS 'apr_prom_al_esc_mat_8-9',
                                    ((b.total_10_mat*100)/i.total_alumnos) AS 'apr_prom_al_esc_mat_10'
                              FROM centrocfg cfg
                              LEFT JOIN (
                                SELECT cfg.idcentrocfg,COUNT(*) AS total_10_lyc
                                          FROM centrocfg cfg
                                          INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                                          INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                                          INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                                          INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Español'
                                          WHERE eval.p1=10 AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                              ) AS a ON a.idcentrocfg=cfg.idcentrocfg

                              LEFT JOIN (
                                SELECT cfg.idcentrocfg,COUNT(*) AS total_10_mat
                                          FROM centrocfg cfg
                                          INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                                          INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                                          INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                                          INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Matematicas'
                                          WHERE eval.p1=10 AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                              ) AS b ON b.idcentrocfg=cfg.idcentrocfg
                              LEFT JOIN (
                                    SELECT cfg.idcentrocfg,COUNT(*) AS total_89_lyc
                                          FROM centrocfg cfg
                                          INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                                          INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                                          INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                                          INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Español'
                                          WHERE (eval.p1>=8 AND eval.p1<=9) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                              ) AS c ON c.idcentrocfg=cfg.idcentrocfg

                              LEFT JOIN (
                                     SELECT cfg.idcentrocfg,COUNT(*) AS total_89_mat
                                          FROM centrocfg cfg
                                          INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                                          INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                                          INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                                          INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Matematicas'
                                          WHERE (eval.p1>=8 AND eval.p1<=9) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                              ) AS d ON d.idcentrocfg=cfg.idcentrocfg

                              LEFT JOIN (
                                    SELECT cfg.idcentrocfg,COUNT(*) AS total_67_lyc
                                          FROM centrocfg cfg
                                          INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                                          INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                                          INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                                          INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Español'
                                          WHERE (eval.p1>=6 AND eval.p1<=7) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                              ) AS e ON e.idcentrocfg=cfg.idcentrocfg

                              LEFT JOIN (
                                     SELECT cfg.idcentrocfg,COUNT(*) AS total_67_mat
                                          FROM centrocfg cfg
                                          INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                                          INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                                          INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                                          INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Matematicas'
                                          WHERE (eval.p1>=6 AND eval.p1<=7) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                              ) AS f ON f.idcentrocfg=cfg.idcentrocfg

                              LEFT JOIN (
                                   SELECT cfg.idcentrocfg,COUNT(*) AS total_5_lyc
                                          FROM centrocfg cfg
                                          INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                                          INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                                          INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                                          INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Español'
                                          WHERE (eval.p1=5) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                              ) AS g ON g.idcentrocfg=cfg.idcentrocfg
                              LEFT JOIN (
                                     SELECT cfg.idcentrocfg,COUNT(*) AS total_5_mat
                                          FROM centrocfg cfg
                                          INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                                          INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                                          INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                                          INNER JOIN asignatura_prim asig ON asig.`idasigprim`=eval.`idasig` AND asig.`descr`='Matematicas'
                                          WHERE (eval.p1=5) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                              ) AS h ON h.idcentrocfg=cfg.idcentrocfg
                              LEFT JOIN (
                    SELECT COUNT(*) AS total_alumnos,a.idcentrocfg FROM (
                      SELECT cfg.idcentrocfg
                          FROM centrocfg cfg
                          INNER JOIN grupo_prim g ON g.idcentrocfg=cfg.idcentrocfg
                          INNER JOIN expediente_prim e ON e.idgrupo=g.idgrupo
                          INNER JOIN eval_prim eval ON eval.idexpediente=e.idexpediente
                          INNER JOIN alumno a ON a.idalumno=e.idalumno
                          WHERE cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A' AND eval.p1 IS NOT NULL AND eval.`p1`!=0 GROUP BY e.`idexpediente`
                                      ) AS a
                              ) AS i ON i.idcentrocfg=cfg.idcentrocfg
                              WHERE cfg.idcentrocfg={$datos[$i]['idcentrocfg']}

              ) AS d
              SET       t.`apr_prom_al_esc_esp_5`=d.`apr_prom_al_esc_esp_5`,
                        t.`apr_prom_al_esc_esp_6-7`=d.`apr_prom_al_esc_esp_6-7`,
                        t.`apr_prom_al_esc_esp_8-9`=d.`apr_prom_al_esc_esp_8-9`,
                        t.`apr_prom_al_esc_esp_10`=d.`apr_prom_al_esc_esp_10`,
                        t.`apr_prom_al_esc_mat_5`=d.`apr_prom_al_esc_mat_5`,
                        t.`apr_prom_al_esc_mat_6-7`=d.`apr_prom_al_esc_mat_6-7`,
                        t.`apr_prom_al_esc_mat_8-9`=d.`apr_prom_al_esc_mat_8-9`,
                        t.`apr_prom_al_esc_mat_10`=d.`apr_prom_al_esc_mat_10`
              WHERE t.idcentrocfg=d.idcentrocfg";
              $this->db->query($query);

      }
      $query="SELECT idcentrocfg FROM centrocfg where nivel=3";
      $datos=$this->db->query($query)->result_array();
          for ($i=0; $i<count($datos); $i++) {
              $query="
                UPDATE complemento_apa t
                  JOIN
                  (
                    SELECT  cfg.idcentrocfg,
                                    ((g.total_5_lyc*100)/i.total_alumnos) AS 'apr_prom_al_esc_esp_5',
                                    ((e.total_67_lyc*100)/i.total_alumnos) AS 'apr_prom_al_esc_esp_6-7',
                                    ((c.total_89_lyc*100)/i.total_alumnos) AS 'apr_prom_al_esc_esp_8-9',
                                    ((a.total_10_lyc*100)/i.total_alumnos) AS 'apr_prom_al_esc_esp_10',
                                    ((h.total_5_mat*100)/i.total_alumnos) AS 'apr_prom_al_esc_mat_5',
                                    ((f.total_67_mat*100)/i.total_alumnos) AS 'apr_prom_al_esc_mat_6-7',
                                    ((d.total_89_mat*100)/i.total_alumnos) AS 'apr_prom_al_esc_mat_8-9',
                                    ((b.total_10_mat*100)/i.total_alumnos) AS 'apr_prom_al_esc_mat_10'
                                  FROM centrocfg cfg
                                  LEFT JOIN (
                                    SELECT cfg.idcentrocfg,COUNT(*) AS total_10_lyc
                                              FROM centrocfg cfg
                                              INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                                              INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                                              INNER JOIN alumno a ON a.idalumno=e.idalumno
                                              INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                                              INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Español'
                                              WHERE eval.p1=10 AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                                  ) AS a ON a.idcentrocfg=cfg.idcentrocfg

                                  LEFT JOIN (
                                    SELECT cfg.idcentrocfg,COUNT(*) AS total_10_mat
                                              FROM centrocfg cfg
                                              INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                                              INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                                              INNER JOIN alumno a ON a.idalumno=e.idalumno
                                              INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                                              INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Matematicas'
                                              WHERE eval.p1=10 AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                                  ) AS b ON b.idcentrocfg=cfg.idcentrocfg
                                  LEFT JOIN (
                                        SELECT cfg.idcentrocfg,COUNT(*) AS total_89_lyc
                                              FROM centrocfg cfg
                                              INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                                              INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                                              INNER JOIN alumno a ON a.idalumno=e.idalumno
                                              INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                                              INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Español'
                                              WHERE (eval.p1>=8 AND eval.p1<=9) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                                  ) AS c ON c.idcentrocfg=cfg.idcentrocfg

                                  LEFT JOIN (
                                         SELECT cfg.idcentrocfg,COUNT(*) AS total_89_mat
                                              FROM centrocfg cfg
                                              INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                                              INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                                              INNER JOIN alumno a ON a.idalumno=e.idalumno
                                              INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                                              INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Matematicas'
                                              WHERE (eval.p1>=8 AND eval.p1<=9) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                                  ) AS d ON d.idcentrocfg=cfg.idcentrocfg

                                  LEFT JOIN (
                                        SELECT cfg.idcentrocfg,COUNT(*) AS total_67_lyc
                                              FROM centrocfg cfg
                                              INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                                              INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                                              INNER JOIN alumno a ON a.idalumno=e.idalumno
                                              INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                                              INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Español'
                                              WHERE (eval.p1>=6 AND eval.p1<=7) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                                  ) AS e ON e.idcentrocfg=cfg.idcentrocfg

                                  LEFT JOIN (
                                         SELECT cfg.idcentrocfg,COUNT(*) AS total_67_mat
                                              FROM centrocfg cfg
                                              INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                                              INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                                              INNER JOIN alumno a ON a.idalumno=e.idalumno
                                              INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                                              INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Matematicas'
                                              WHERE (eval.p1>=6 AND eval.p1<=7) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                                  ) AS f ON f.idcentrocfg=cfg.idcentrocfg

                                  LEFT JOIN (
                                       SELECT cfg.idcentrocfg,COUNT(*) AS total_5_lyc
                                              FROM centrocfg cfg
                                              INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                                              INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                                              INNER JOIN alumno a ON a.idalumno=e.idalumno
                                              INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                                              INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Español'
                                              WHERE (eval.p1=5) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                                  ) AS g ON g.idcentrocfg=cfg.idcentrocfg
                                  LEFT JOIN (
                                         SELECT cfg.idcentrocfg,COUNT(*) AS total_5_mat
                                              FROM centrocfg cfg
                                              INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                                              INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                                              INNER JOIN alumno a ON a.idalumno=e.idalumno
                                              INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                                              INNER JOIN asignatura_sec asig ON asig.`idasigsec`=eval.`idasig` AND asig.`descr`='Matematicas'
                                              WHERE (eval.p1=5) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A'
                                  ) AS h ON h.idcentrocfg=cfg.idcentrocfg
                                  LEFT JOIN (
                        SELECT COUNT(*) AS total_alumnos,a.idcentrocfg FROM (
                          SELECT cfg.idcentrocfg
                              FROM centrocfg cfg
                              INNER JOIN grupo_sec g ON g.idcentrocfg=cfg.idcentrocfg
                              INNER JOIN expediente_sec e ON e.idgrupo=g.idgrupo
                              INNER JOIN eval_sec eval ON eval.idexpediente=e.idexpediente
                              INNER JOIN alumno a ON a.idalumno=e.idalumno
                              WHERE cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND e.`status`='A' AND eval.p1 IS NOT NULL AND eval.`p1`!=0  AND eval.`idasig` IN(1,2,3,8,9,10)
                              GROUP BY e.`idexpediente`
                                          ) AS a
                                  ) AS i ON i.idcentrocfg=cfg.idcentrocfg
                                  WHERE cfg.idcentrocfg={$datos[$i]['idcentrocfg']}

                  ) AS d
                  SET       t.`apr_prom_al_esc_esp_5`=d.`apr_prom_al_esc_esp_5`,
                            t.`apr_prom_al_esc_esp_6-7`=d.`apr_prom_al_esc_esp_6-7`,
                            t.`apr_prom_al_esc_esp_8-9`=d.`apr_prom_al_esc_esp_8-9`,
                            t.`apr_prom_al_esc_esp_10`=d.`apr_prom_al_esc_esp_10`,
                            t.`apr_prom_al_esc_mat_5`=d.`apr_prom_al_esc_mat_5`,
                            t.`apr_prom_al_esc_mat_6-7`=d.`apr_prom_al_esc_mat_6-7`,
                            t.`apr_prom_al_esc_mat_8-9`=d.`apr_prom_al_esc_mat_8-9`,
                            t.`apr_prom_al_esc_mat_10`=d.`apr_prom_al_esc_mat_10`
                  WHERE t.idcentrocfg=d.idcentrocfg
              ";
              $this->db->query($query);
          }
    }

}

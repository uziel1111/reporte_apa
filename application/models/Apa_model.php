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
      // if($this->db->query($q, array($cct,$turno,$periodo,$ciclo))->row_array()){
        return $this->db->query($q, array($cct,$turno,$periodo,$ciclo))->row_array();
      // }else{
      //   $error =$this->db->error();
      //   return $error;
      // }
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

        $query=" INSERT INTO planeaxidcentrocfg_reactivo (
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

      for ($i=1; $i<51 ; $i++) {

          if($i!=6 && $i!=22 && $i!=26 && $i!=28){

           $query=" INSERT INTO planeaxidcentrocfg_reactivo (
                     `idcentrocfg`,
                     `id_reactivo`,
                     `n_almn_eval`,
                     `n_aciertos`,
                     `id_periodo`
                   )
                   SELECT cfg.idcentrocfg, aux.id_reactivo AS id_reactivo,l.n_almn_eval_mat,
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

       $query=" INSERT INTO planeaxidcentrocfg_reactivo (
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

        $query=" INSERT INTO planeaxidcentrocfg_reactivo (
                  `idcentrocfg`,
                  `id_reactivo`,
                  `n_almn_eval`,
                  `n_aciertos`,
                  `id_periodo`
                )
                SELECT cfg.idcentrocfg, aux.id_reactivo AS id_reactivo,l.n_almn_eval_mat,
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
        $query2="INSERT INTO `test`.`temporal_contenidosxcfg` (
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
                    ((((SUM(t1.n_aciertos))*100)/((COUNT(t3.id_contenido))*t1.n_almn_eval)))AS porcen_alum_respok
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
        $query2="INSERT INTO `test`.`temporal_contenidosxcfg` (
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
                      ((((SUM(t1.n_aciertos))*100)/((COUNT(t3.id_contenido))*t1.n_almn_eval)))AS porcen_alum_respok
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

<?php
ini_set('max_execution_time', 0);
ini_set("memory_limit", "1024M");
class Apa_model extends CI_Model
{
  function __construct() {
    parent::__construct();
    $this->load->database();
  }

    function get_reporte_apa($cct,$turno,$periodo,$ciclo){
      $q = "SELECT
            *
            FROM complemento_apa
            WHERE cct = ?
            AND turno = ?
            AND periodo = ?
            AND ciclo = ?";
        return $this->db->query($q, array($cct,$turno,$periodo,$ciclo))->row_array();
    }

    function get_alumnos_baja($idreporte){
      $q = "SELECT
            *
            FROM bajas_apa
            WHERE idreporteapa = ? order by grado, grupo, nombre_alu";
      return $this->db->query($q, array($idreporte))->result_array();
    }

    function get_alumnos_mar($idreporte){
      $q = "SELECT
            *
            FROM muy_alto_riesgo
            WHERE idreporteapa = ? order by muyalto_alto desc, grado asc, grupo, nombre_alu";
      return $this->db->query($q, array($idreporte))->result_array();
    }

    function update_porcentaje_cal_primaria(){
      $query="SELECT idcentrocfg FROM centrocfg WHERE idcentrocfg NOT IN (SELECT idcentrocfg FROM `complemento_apa` WHERE periodo = 2 AND ciclo = 2021 AND apr_prom_al_esc_mat_10 IS NOT NULL) AND nivel IN (2,3) ";
      $datos=$this->db->query($query)->result_array();
      for ($i=0; $i<count($datos); $i++) {
        echo "<pre>";print_r($datos[$i]['idcentrocfg']);
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
                                FROM temp_alumnos_2do_trim_prim_secu t
                                INNER JOIN cct ct ON t.cct = ct.cct
                                INNER JOIN centrocfg cfg ON ct.idct = cfg.idct AND t.turno = cfg.turno
                                WHERE t.p2_espaniol=10 AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND t.estatus='A'
                              ) AS a ON a.idcentrocfg=cfg.idcentrocfg

                              LEFT JOIN (
                                SELECT cfg.idcentrocfg,COUNT(*) AS total_10_mat
                                FROM temp_alumnos_2do_trim_prim_secu t
                                INNER JOIN cct ct ON t.cct = ct.cct
                                INNER JOIN centrocfg cfg ON ct.idct = cfg.idct AND t.turno = cfg.turno
                                WHERE t.p2_matematicas=10 AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND t.estatus='A'
                              ) AS b ON b.idcentrocfg=cfg.idcentrocfg
                              LEFT JOIN (
                                    SELECT cfg.idcentrocfg,COUNT(*) AS total_89_lyc
                                    FROM temp_alumnos_2do_trim_prim_secu t
                                    INNER JOIN cct ct ON t.cct = ct.cct
                                    INNER JOIN centrocfg cfg ON ct.idct = cfg.idct AND t.turno = cfg.turno
                                    WHERE (t.p2_espaniol>=8 AND t.p2_espaniol<=9) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND t.estatus='A'
                              ) AS c ON c.idcentrocfg=cfg.idcentrocfg

                              LEFT JOIN (
                                    SELECT cfg.idcentrocfg,COUNT(*) AS total_89_mat
                                    FROM temp_alumnos_2do_trim_prim_secu t
                                    INNER JOIN cct ct ON t.cct = ct.cct
                                    INNER JOIN centrocfg cfg ON ct.idct = cfg.idct AND t.turno = cfg.turno
                                    WHERE (t.p2_matematicas>=8 AND t.p2_matematicas<=9) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND t.estatus='A'
                              ) AS d ON d.idcentrocfg=cfg.idcentrocfg

                              LEFT JOIN (
                                    SELECT cfg.idcentrocfg,COUNT(*) AS total_67_lyc
                                    FROM temp_alumnos_2do_trim_prim_secu t
                                    INNER JOIN cct ct ON t.cct = ct.cct
                                    INNER JOIN centrocfg cfg ON ct.idct = cfg.idct AND t.turno = cfg.turno
                                    WHERE (t.p2_espaniol>=6 AND t.p2_espaniol<=7) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND t.estatus='A'
                              ) AS e ON e.idcentrocfg=cfg.idcentrocfg

                              LEFT JOIN (
                                    SELECT cfg.idcentrocfg,COUNT(*) AS total_67_mat
                                    FROM temp_alumnos_2do_trim_prim_secu t
                                    INNER JOIN cct ct ON t.cct = ct.cct
                                    INNER JOIN centrocfg cfg ON ct.idct = cfg.idct AND t.turno = cfg.turno
                                          WHERE (t.p2_matematicas>=6 AND t.p2_matematicas<=7) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND t.estatus='A'
                              ) AS f ON f.idcentrocfg=cfg.idcentrocfg

                              LEFT JOIN (
                                   SELECT cfg.idcentrocfg,COUNT(*) AS total_5_lyc
                                    FROM temp_alumnos_2do_trim_prim_secu t
                                    INNER JOIN cct ct ON t.cct = ct.cct
                                    INNER JOIN centrocfg cfg ON ct.idct = cfg.idct AND t.turno = cfg.turno
                                          WHERE (t.p2_espaniol=5) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND t.estatus='A'
                              ) AS g ON g.idcentrocfg=cfg.idcentrocfg
                              LEFT JOIN (
                                    SELECT cfg.idcentrocfg,COUNT(*) AS total_5_mat
                                    FROM temp_alumnos_2do_trim_prim_secu t
                                    INNER JOIN cct ct ON t.cct = ct.cct
                                    INNER JOIN centrocfg cfg ON ct.idct = cfg.idct AND t.turno = cfg.turno
                                    WHERE (t.p2_matematicas=5) AND cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND t.estatus='A'
                              ) AS h ON h.idcentrocfg=cfg.idcentrocfg
                              LEFT JOIN (
                    SELECT COUNT(*) AS total_alumnos,a.idcentrocfg FROM (
                      SELECT cfg.idcentrocfg
                      FROM temp_alumnos_2do_trim_prim_secu t
                      INNER JOIN cct ct ON t.cct = ct.cct
                      INNER JOIN centrocfg cfg ON ct.idct = cfg.idct AND t.turno = cfg.turno
                          WHERE cfg.idcentrocfg={$datos[$i]['idcentrocfg']} AND t.estatus='A' AND ((t.p2_espaniol IS NOT NULL AND t.p2_espaniol!=0) OR (t.p2_matematicas IS NOT NULL AND t.p2_matematicas!=0))
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
              WHERE t.idcentrocfg=d.idcentrocfg AND t.periodo=2 AND ciclo = 2021";
              $this->db->query($query);

      }

    }



}

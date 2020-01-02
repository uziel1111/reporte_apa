<?php
class Datos_model extends CI_Model
{
  function __construct() {
    parent::__construct();
    $this->load->database();
  }

      function get_datos_apa($idcentrocfg=NULL,$periodo=NULL){
      $q = "SELECT
            cfg.idcentrocfg AS idcentrocfg,
            ct.cct,
            ct.turno,
            ? AS periodo,
            cfg.nivel AS idnivel,
            ct.nombre AS encabezado_n_escuela,
            m.nombre AS encabezado_muni_escuela,
            n.descr AS  encabezado_n_nivel,
            t.descripcion AS encabezado_n_turno,
            cfg.nivel,
            CONCAT(p.nombre,' ',p.apell1,' ',p.apell2) AS encabezado_n_direc_resp,
            est.alumnos1 AS asi_est_al_1,
            est.alumnos2 AS asi_est_al_2,
            est.alumnos3 AS asi_est_al_3,
            est.alumnos4 AS asi_est_al_4,
            est.alumnos5 AS asi_est_al_5,
            est.alumnos6 AS asi_est_al_6,
            est.t_alumnos AS asi_est_al_t,
            est.grupos1 AS asi_est_gr_1,
            est.grupos2 AS asi_est_gr_2,
            est.grupos3 AS asi_est_gr_3,
            est.grupos4 AS asi_est_gr_4,
            est.grupos5 AS asi_est_gr_5,
            est.grupos6 AS asi_est_gr_6,
            est.t_grupos AS asi_est_gr_t,
            est.t_docentes AS asi_est_do_t

            FROM centrocfg cfg
            INNER JOIN cct ct ON ct.idct=cfg.idct
            INNER JOIN municipio m ON m.idmunicipio=ct.idmunicipio
            INNER JOIN niveleducativo n ON n.idnivel=cfg.nivel
            INNER JOIN turno t ON t.idturno=cfg.turno
            INNER JOIN personal p ON p.idcentrocfg=cfg.idcentrocfg AND idfuncion=1
            LEFT JOIN estadistica_x_idcentrocfg est ON  est.`idcentrocfg`=cfg.`idcentrocfg`
            WHERE cfg.idcentrocfg= ? ";
            // echo $q;die();
      return $this->db->query($q, array($periodo,$idcentrocfg))->row_array();
      // echo '<pre>';print_r($q);die();
}

    function get_ciclo($idnivel){
    $param = ($idnivel == 2) ? "CICLO_ACTIVO_PRIM" : "CICLO_ACTIVO_SEC";
    $q = "SELECT
          valor AS ciclo from parametro where nombreparam= ? ";
          // echo $q;die();
    return $this->db->query($q, array($param))->row_array();

    // echo '<pre>';print_r($q);die();
  }

  function get_alumnos_baja($idcentrocfg,$idnivel){
    $subfijo = ($idnivel == 2) ? "prim" : "sec";
    $q= "SELECT
          CONCAT_WS(' ',a.apell1,a.apell2,a.nombre) AS nombre_alu,
          g.grado,
          g.grupo,
          CONCAT(a.calle,' #',a.numero,' ',a.colonia) AS domicilio_alu,
          a.telefono,
          cb.descripcion AS motivo
          FROM centrocfg cfg
          INNER JOIN grupo_{$subfijo} g ON g.idcentrocfg=cfg.idcentrocfg
          INNER JOIN expediente_{$subfijo} e ON e.idgrupo=g.idgrupo
          INNER JOIN alumno a ON a.idalumno=e.idalumno
          INNER JOIN movimientos_{$subfijo} mov ON mov.idexpediente=e.idexpediente
          INNER JOIN c_bajas_alumno cb ON cb.id_baja=mov.id_motivo_baja
          WHERE e.status='B'
          AND mov.id_tipomovimiento=4
          AND mov.id_motivo_baja!=9
          AND cfg.idcentrocfg=? ";
          // echo "<pre>";print_r($q);die();
          return $this->db->query($q, array($idcentrocfg))->row_array();
  }
}

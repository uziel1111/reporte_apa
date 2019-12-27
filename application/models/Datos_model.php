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
            m.nombre AS encabezado_muni_escuela
            FROM centrocfg cfg
            INNER JOIN cct ct ON ct.idct=cfg.idct
            INNER JOIN municipio m ON m.idmunicipio=ct.idmunicipio
            where cfg.idcentrocfg= ?";
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
}

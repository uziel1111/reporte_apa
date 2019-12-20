<?php
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
            FROM reporte_apa_xidcentrocfg
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
            WHERE idreporteapa = ?";
            // echo $q;die();
      return $this->db->query($q, array($idreporte))->result_array();
    }



}

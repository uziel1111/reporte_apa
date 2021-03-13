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

}

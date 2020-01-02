<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generar_datos extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Datos_model');
  }// __construct()


  function index(){
    // function index($cct,$turno,$periodo,$ciclo){
    // function index($cct=NULL,$turno=NULL,$periodo=NULL,$ciclo=NULL){
    // echo '<pre>';print_r($this->input->get());
    // echo "Hola mundo";die();
    // echo $cct;die();

    // $this->rep($cct,$turno,$periodo,$ciclo);
    // $this->rep();

    // $this->graf();
    $todos =array();
    $a=$this->Datos_model->get_datos_apa(1,1);
    $todos=array_merge($todos,$a);
    $ciclo=$this->Datos_model->get_ciclo($a['idnivel']);
    $todos=array_merge($todos,$ciclo);
    $alumnos_baja=$this->Datos_model->get_alumnos_baja($a['idcentrocfg'],$a['idnivel']);
    echo '<pre>';print_r($todos);die();
  }

}

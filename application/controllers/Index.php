<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
    	$this->load->helper('url');
    	$this->load->model('Apa_model');
	}

	function index(){
		// echo "Bienvenido :)"; die();
		//llenar planea reactivo por idcentrocfg
		// $resultado=$this->Apa_model->llenar_planeaxreactivoxcentrocfg();

		//para los contenidos tematicos
		// $resultado=$this->Apa_model->llenarcontenidos();
		// $resultado=$this->Apa_model->llena_contenidosxidcentrocfg();
		// $resultado=$this->Apa_model->inserta_calificaciones_primaria();
		// $resultado=$this->Apa_model->inserta_calificaciones_secundaria();
		
		$resultado=$this->Apa_model->update_porcentaje_cal_primaria();
		

	}
}


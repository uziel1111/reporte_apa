<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
    	$this->load->helper('url');
    	$this->load->model('Apa_model');
    	$this->load->model('DatosMunicipal_model');
    	$this->load->model('Datos_model');
	}

	function index(){
		// echo "Bienvenido :)"; die();
		// 1ro. llenamos la tabla planeaxidcentrocfg_reactivo en la cual se guarda los aciertos que tuvo la escuela por reactivo
		// $resultado=$this->Apa_model->llenar_planeaxreactivoxcentrocfg();
		//
		// para los contenidos tematicos
		// 2do. Una vez que ya tengamos los resultados de los alumnos que hayan acertado en los diferentes reactivos,vamos a obtener el porcentaje por contenido tematicos y vamos a guardarlo en la tabla temporal_contenidosxcfg
		// $resultado=$this->Apa_model->llenarcontenidos();
		// 3ro. Una vez que ya tenemos los porcentajes que obtuvieron por contenido tematico cada escuela, vamos a insertar en la tabla planea_ctematicos_x_idcentrocfg los 5 contenidos con porcentaje menor
		// $resultado=$this->Apa_model->llena_contenidosxidcentrocfg();
		//
		// En la siguiente funcion insertamos el porcentaje de alumnos con calificacion 5,calificacion de 6-7,calificacion 8-9 y por ultimo el porcentaje de alumnos con calificacion 10 del nivel primaria y secundaria en la tabla complemento_apa
		// $resultado=$this->Apa_model->update_porcentaje_cal_primaria();
		// die();
		// insertamos los contenidos tematicos por municipio y nivel
		// $this->DatosMunicipal_model->insertacontenidos_xmunxnivel(); die();
	}

	function generarCurp(){
        $datos = $this->Datos_model->get_alumnos_sin_curp();
        // print_r($datos);
        $data['array'] =  $datos;
        carga_pagina_basica($this, $data, "auxiliar/vista_auxiliar");
        // $vista = $this->load->view("auxiliar/vista_auxiliar", $dato, TRUE);
	}

	function actualizaCurpInterno(){
		$curp=$this->input->post('curp');
		$nombre=$this->input->post('nombre');
		$apellido_paterno=$this->input->post('apellido_paterno');
		// echo "llego a la funcion"; die();
	// echo $curp."\n".$nombre."\n".$apellido_paterno; die();
        $actualiza=$this->Datos_model->actualizaCurpInterno($curp,$nombre,$apellido_paterno);
echo "llego a la funcion"; die();
        $response = array('respuesta' =>"ok");
        envia_datos_json($this, $response,200);
        exit;
        // print_r($datos);

        // $vista = $this->load->view("auxiliar/vista_auxiliar", $dato, TRUE);
	}
}

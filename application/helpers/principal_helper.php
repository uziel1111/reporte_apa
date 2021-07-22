<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

if ( !function_exists( 'envia_datos_json' ) ) {
    function envia_datos_json( $contexto, $data,$status) {
        return $contexto->output
        ->set_status_header($status)
        ->set_content_type( 'application/json', 'utf-8' )
        ->set_output( json_encode( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) )
        ->_display();
    }
    // envia_datos_json()
}


if ( !function_exists( 'carga_pagina_basica' ) ) {
    function carga_pagina_basica( $contexto, $data, $vista, $header = 'header', $footer = 'footer' ) {
        $contexto->load->view( $vista, $data );
    }
    // carga_pagina_basica()
}


?>

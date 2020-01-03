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
            est.t_docentes AS asi_est_do_t,
            e1.alumnos1 AS asi_est_h1_al_1,
            e1.alumnos2 AS asi_est_h1_al_2,
            e1.alumnos3 AS asi_est_h1_al_3,
            e1.alumnos4 AS asi_est_h1_al_4,
            e1.alumnos5 AS asi_est_h1_al_5,
            e1.alumnos6 AS asi_est_h1_al_6,
            e1.t_alumnos AS asi_est_h1_gr_t,
            e2.alumnos1 AS asi_est_h2_al_1,
            e2.alumnos2 AS asi_est_h2_al_2,
            e2.alumnos3 AS asi_est_h2_al_3,
            e2.alumnos4 AS asi_est_h2_al_4,
            e2.alumnos5 AS asi_est_h2_al_5,
            e2.alumnos6 AS asi_est_h2_al_6,
            e2.t_alumnos AS asi_est_h2_gr_t,
            re.p6A11_ptotal_m AS asi_rez_pob_m,
            re.p6A11_ptotal_h AS asi_rez_pob_h,
            (re.p6A11_ptotal_m+re.p6A11_ptotal_h) AS asi_rez_pob_t,
            re.p6A11_noa_m AS asi_rez_noasiste_m,
            re.p6A11_noa_h AS asi_rez_noasiste_h,
            (re.p6A11_noa_m+re.p6A11_noa_h) AS asi_rez_pob_t,
            an.analfabetismo_mayor15_m AS asi_analfabeta_m,
            an.analfabetismo_mayor15_h AS asi_analfabeta_h,
            ind.aprobacion AS per_ind_aprobacion,
            ind.retencion AS per_ind_retencion,
            ind.`eficiencia_terminal` AS per_ind_et,
            pcfg.ni_lyc AS apr_planea1_nlogro_esc_lyc_i,
            pcfg.nii_lyc AS apr_planea1_nlogro_esc_lyc_ii,
            pcfg.niii_lyc AS apr_planea1_nlogro_esc_lyc_iii,
            pcfg.niv_lyc AS apr_planea1_nlogro_esc_lyc_iv,
            (pcfg.nii_lyc+pcfg.niii_lyc+pcfg.niv_lyc) AS 'apr_planea1_nlogro_esc_lyc_ii-iii-iv',
            pcfg.ni_mat AS apr_planea1_nlogro_esc_mat_i,
            pcfg.nii_mat AS apr_planea1_nlogro_esc_mat_ii,
            pcfg.niii_mat AS apr_planea1_nlogro_esc_mat_iii,
            pcfg.niv_mat AS apr_planea1_nlogro_esc_mat_iv,
            (pcfg.nii_mat+pcfg.niii_mat+pcfg.niv_mat) AS 'apr_planea1_nlogro_esc_mat_ii-iii-iv',
            pcfg1.`ni_lyc` AS apr_planea2_nlogro_esc_lyc_i,
            (pcfg1.`nii_lyc`+pcfg1.`niii_lyc`+pcfg1.`niv_lyc`) AS 'apr_planea2_nlogro_esc_lyc_ii-iii-iv',
            pcfg1.`ni_mat` AS apr_planea2_nlogro_esc_mat_i,
            (pcfg1.nii_mat+pcfg1.niii_mat+pcfg1.niv_mat) AS 'apr_planea2_nlogro_esc_mat_ii-iii-iv',
            ent.`periodo_planea` AS apr_planea_nlogro_estado_periodo,
            ent.`ni_lyc` AS apr_planea_nlogro_estado_lyc_i,
            (ent.nii_lyc+ent.niii_lyc+ent.niv_lyc) AS 'apr_planea_nlogro_estado_lyc_ii-iii-iv',
            ent.ni_mat AS apr_planea_nlogro_estado_mat_i,
            (ent.`nii_mat`+ent.niii_mat+ent.niv_mat) AS 'apr_planea_nlogro_estado_mat_ii-iii-iv',
            nac.`periodo_planea` AS apr_planea_nlogro_pais_periodo,
            nac.`ni_lyc` AS apr_planea_nlogro_pais_lyc_i,
            (nac.nii_lyc+nac.niii_lyc+nac.niv_lyc) AS 'apr_planea_nlogro_pais_lyc_ii-iii-iv',
            nac.`ni_mat` AS apr_planea_nlogro_pais_mat_i,
            (nac.`nii_mat`+nac.`niii_mat`+nac.`niv_mat`) AS 'apr_planea_nlogro_pais_mat_ii-iii-iv',
            pct.`mct_lyc1` AS apr_planea1_ct_esc_lyc_1por,
            pct.`mct_lyc1` AS apr_planea1_ct_esc_lyc_1txt,
            pct.`mct_lyc_p2` AS apr_planea1_ct_esc_lyc_2por,
            pct.`mct_lyc2` AS apr_planea1_ct_esc_lyc_2txt,
            pct.`mct_lyc_p3` AS apr_planea1_ct_esc_lyc_3por,
            pct.`mct_lyc3` AS apr_planea1_ct_esc_lyc_3txt,
            pct.`mct_lyc_p4` AS apr_planea1_ct_esc_lyc_4por,
            pct.`mct_lyc4` AS apr_planea1_ct_esc_lyc_4txt,
            pct.`mct_mat_p1` AS apr_planea1_ct_esc_mat_1por,
            pct.`mct_mat1` AS apr_planea1_ct_esc_mat_1txt,
            pct.`mct_mat_p2` AS apr_planea1_ct_esc_mat_2por,
            pct.mct_mat2 AS pr_planea1_ct_esc_mat_2txt,
            pct.`mct_mat_p3` AS apr_planea1_ct_esc_mat_3por,
            pct.mct_mat3  AS apr_planea1_ct_esc_mat_3txt,
            pct.mct_mat_p4 AS apr_planea1_ct_esc_mat_4por,
            pct.`mct_mat4` AS apr_planea1_ct_esc_mat_4txt
      
            FROM centrocfg cfg
            INNER JOIN cct ct ON ct.idct=cfg.idct
            INNER JOIN municipio m ON m.idmunicipio=ct.idmunicipio
            INNER JOIN niveleducativo n ON n.idnivel=cfg.nivel
            INNER JOIN turno t ON t.idturno=cfg.turno
            INNER JOIN personal p ON p.idcentrocfg=cfg.idcentrocfg AND idfuncion=1
            LEFT JOIN estadistica_x_idcentrocfg est ON  est.`idcentrocfg`=cfg.`idcentrocfg` AND est.idciclo=1
            LEFT JOIN estadistica_x_idcentrocfg e1 ON  e1.`idcentrocfg`=cfg.`idcentrocfg` AND e1.idciclo=2
            LEFT JOIN estadistica_x_idcentrocfg e2 ON  e2.`idcentrocfg`=cfg.`idcentrocfg` AND e2.idciclo=3
            LEFT JOIN rezago_edu_xmuni re ON re.idmunicipio=ct.idmunicipio 
            LEFT JOIN analfabetismo_xmuni an ON an.idmunicipio=ct.idmunicipio
            LEFT JOIN indicadores_x_idcentrocfg ind ON ind.idcentrocfg=cfg.idcentrocfg AND ind.idciclo=1
            LEFT JOIN planea_nlogro_x_idcentrocfg pcfg ON pcfg.`idcentrocfg`=cfg.`idcentrocfg` AND pcfg.`periodo_planea`='2019'
            LEFT JOIN planea_nlogro_x_idcentrocfg pcfg1 ON pcfg1.`idcentrocfg`=cfg.`idcentrocfg` AND pcfg1.`periodo_planea`='2017'
            LEFT JOIN planea_nlogro_x_entidad ent ON ent.idnivel=n.idnivel AND ent.`periodo_planea`='2019'
            LEFT JOIN planea_nlogro_x_nacional nac ON nac.idnivel=n.idnivel
            LEFT JOIN planea_ctematicos_x_idcentrocfg pct ON pct.`idcentrocfg`=cfg.`idcentrocfg` AND pct.periodo_planea='2019'
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

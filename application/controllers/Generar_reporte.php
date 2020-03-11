<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generar_reporte extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Apa_model');
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
  }


   // function rep(){
  function rep($cct,$turno,$periodo,$ciclo){
       // echo "Hola mundo";die();
    // $riesgo=$this->Apa_model->get_riesgo_abandono();
    $historico=$this->Apa_model->get_historico_mat();
    $distribucion=$this->Apa_model->get_distribucionxgrado();
    $planea_aprov=$this->Apa_model->get_planea_aprov();
    // $array_datos_escuela=$this->Apa_model->get_datos_escuela();
    $reporte_datos=$this->Apa_model->get_reporte_apa($cct,$turno,$periodo,$ciclo);

    $array_datos_escuela= array(
    "nombre" => $reporte_datos['encabezado_n_escuela'],
    "cct" => $reporte_datos['cct'],
    "director" => $reporte_datos['encabezado_n_direc_resp'],
    "turno" => $reporte_datos['encabezado_n_turno'],
    "municipio" => $reporte_datos['encabezado_muni_escuela'],
    "modalidad" => $reporte_datos['encabezado_n_modalidad']
    );

    $est_asis_alumnos = array(0 => $reporte_datos['asi_est_al_1'],1 => $reporte_datos['asi_est_al_2'],2 => $reporte_datos['asi_est_al_3'],3 => $reporte_datos['asi_est_al_4'],4 => $reporte_datos['asi_est_al_5'],5 => $reporte_datos['asi_est_al_6'] );
    $est_asis_alumnos_h1 = array(0 => $reporte_datos['asi_est_h1_al_1'],1 => $reporte_datos['asi_est_h1_al_2'],2 => $reporte_datos['asi_est_h1_al_3'],3 => $reporte_datos['asi_est_h1_al_4'],4 => $reporte_datos['asi_est_h1_al_5'],5 => $reporte_datos['asi_est_h1_al_6']);
    $est_asis_alumnos_h2 = array(0 => $reporte_datos['asi_est_h2_al_1'],1 => $reporte_datos['asi_est_h2_al_2'],2 => $reporte_datos['asi_est_h2_al_3'],3 => $reporte_datos['asi_est_h2_al_4'],4 => $reporte_datos['asi_est_h2_al_5'],5 => $reporte_datos['asi_est_h2_al_6']);

    $est_asis_gr= array(0 => $reporte_datos['asi_est_gr_1'],1 => $reporte_datos['asi_est_gr_2'],2 => $reporte_datos['asi_est_gr_3'],3 => $reporte_datos['asi_est_gr_4'],4 => $reporte_datos['asi_est_gr_5'],5 => $reporte_datos['asi_est_gr_6'] );

    $riesgo=array(0 => $reporte_datos['per_riesgo_al_muy_alto'],1 => $reporte_datos['per_riesgo_al_alto'],2 => $reporte_datos['per_riesgo_al_medio'],3 => $reporte_datos['per_riesgo_al_bajo'] );
    // echo '<pre>';print_r($reporte_datos);die();
    $riesgo_alto=array(0 => $reporte_datos['per_riesgo_al_alto_2'],1 => $reporte_datos['per_riesgo_al_alto_2'],2 => $reporte_datos['per_riesgo_al_alto_3'],3 => $reporte_datos['per_riesgo_al_alto_4'],4 => $reporte_datos['per_riesgo_al_alto_5'],5 => $reporte_datos['per_riesgo_al_alto_6'] );
    $riesgo_muy_alto=array(0 => $reporte_datos['per_riesgo_al_muy_alto_1'],1 => $reporte_datos['per_riesgo_al_muy_alto_2'],2 => $reporte_datos['per_riesgo_al_muy_alto_3'],3 => $reporte_datos['per_riesgo_al_muy_alto_4'],4 => $reporte_datos['per_riesgo_al_muy_alto_5'],5 => $reporte_datos['per_riesgo_al_muy_alto_6'] );


    $rez_ed = array(0 => $reporte_datos['asi_rez_pob_t'],1 => $reporte_datos['asi_rez_pob_m'],2 => $reporte_datos['asi_rez_pob_h']);
    $rez_na = array(0 => $reporte_datos['asi_rez_noasiste_t'],1 => $reporte_datos['asi_rez_noasiste_m'],2 => $reporte_datos['asi_rez_noasiste_h']);
    $analfabeta = array(0 => $reporte_datos['asi_analfabeta_t'],1 => $reporte_datos['asi_analfabeta_m'],2 => $reporte_datos['asi_analfabeta_h']);


    $this->graf($riesgo,$historico,$distribucion,$planea_aprov,$array_datos_escuela,$est_asis_alumnos,$est_asis_gr,$est_asis_alumnos_h1,$est_asis_alumnos_h2,$rez_ed,$rez_na,$analfabeta,$riesgo_alto,$riesgo_muy_alto,$reporte_datos);
  }

  function graf($riesgo,$historico,$distribucion,$planea_aprov,$array_datos_escuela,$est_asis_alumnos,$est_asis_gr,$est_asis_alumnos_h1,$est_asis_alumnos_h2,$rez_ed,$rez_na,$analfabeta,$riesgo_alto,$riesgo_muy_alto,$reporte_datos){
    // echo "<pre>";print_r($reporte_datos);die();

    //// Parámetros iniciales para PDF///

    $pdf = new My_tcpdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Proyecto Educativo');
    $pdf->SetTitle('Reporte APA');
    $pdf->SetSubject('Reporte APA');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    $nombre=$array_datos_escuela['nombre'];
    $cct=$array_datos_escuela['cct'];
    $director=$array_datos_escuela['director'];
    $turno=$array_datos_escuela['turno'];
    $municipio=$array_datos_escuela['municipio'];
    $modalidad=$array_datos_escuela['modalidad'];


$str_htm3 =<<<EOD
        <style>
        table td{
          border: none;
          padding: 5px !important;
          background-color:#ECECEE;
          font-size: 8px;
          padding-top:4px;
          padding-left:2px;
          padding-right:2px;
          padding-bottom:4px;
        }
        </style>
        <table WIDTH="255">
          <tbody>
            <tr>
              <td WIDTH="2"></td>
              <td WIDTH="73.88"></td>
              <td WIDTH="10"></td>
              <td WIDTH="130"></td>
              <td WIDTH="5"></td>
              <td WIDTH="25"></td>
              <td WIDTH="10"></td>
              <td WIDTH="45"></td>
              <td WIDTH="30"></td>
              <td WIDTH="40"></td>
              <td WIDTH="20"></td>
              <td WIDTH="50"></td>
              <td WIDTH="85"></td>
              <td WIDTH="2"></td>
            </tr>
            <tr>
              <td WIDTH="10"></td>
              <td WIDTH="40"><font face="Montserrat-Regular">Nombre:</font></td>
              <td WIDTH="55">&nbsp;</td>
              <td WIDTH="170"><font face="Montserrat-Bold">$nombre</font></td>
              <td WIDTH="5">&nbsp;</td>
              <td WIDTH="5">&nbsp;</td>
              <td WIDTH="5">&nbsp;</td>
              <td WIDTH="5">&nbsp;</td>
              <td WIDTH="5">&nbsp;</td>
              <td WIDTH="44"><font face="Montserrat-Regular">Municipio:</font></td>
              <td WIDTH="20">&nbsp;</td>
              <td WIDTH="156.88"><font face="Montserrat-Bold">$municipio</font></td>
              <td WIDTH="5">&nbsp;</td>
              <td WIDTH="2"></td>
            </tr>
            <tr>
              <td WIDTH="10"></td>
              <td WIDTH="85"><font face="Montserrat-Regular">CCT:</font></td>
              <td WIDTH="10">&nbsp;</td>
              <td WIDTH="130"><font face="Montserrat-Bold">$cct</font></td>
              <td WIDTH="65">&nbsp;</td>
              <td WIDTH="30"><font face="Montserrat-Regular">Turno:</font></td>
              <td WIDTH="35">&nbsp;</td>
              <td WIDTH="55"><font face="Montserrat-Bold">$turno</font></td>
              <td WIDTH="30">&nbsp;</td>
              <td WIDTH="4">&nbsp;</td>
              <td WIDTH="48">&nbsp;</td>
              <td WIDTH="23.88">&nbsp;</td>
              <td WIDTH="2"></td>
            </tr>
            <tr>
              <td WIDTH="10"></td>
              <td WIDTH="95"><font face="Montserrat-Regular">Director / Responsable:</font></td>
              <td WIDTH="1">&nbsp;</td>
              <td WIDTH="130"><font face="Montserrat-Bold">$director</font></td>
              <td WIDTH="5">&nbsp;</td>
              <td WIDTH="25">&nbsp;</td>
              <td WIDTH="10">&nbsp;</td>
              <td WIDTH="45">&nbsp;</td>
              <td WIDTH="30">&nbsp;</td>
              <td WIDTH="40">&nbsp;</td>
              <td WIDTH="51">&nbsp;</td>
              <td WIDTH="83.88">&nbsp;</td>
              <td WIDTH="2"></td>
            </tr>
            <tr>
              <td WIDTH="2"></td>
              <td WIDTH="73.88"></td>
              <td WIDTH="10"></td>
              <td WIDTH="130"></td>
              <td WIDTH="5"></td>
              <td WIDTH="25"></td>
              <td WIDTH="10"></td>
              <td WIDTH="45"></td>
              <td WIDTH="30"></td>
              <td WIDTH="40"></td>
              <td WIDTH="20"></td>
              <td WIDTH="50"></td>
              <td WIDTH="85"></td>
              <td WIDTH="2"></td>
            </tr>
          </tbody>
        </table>
EOD;

$encabezado_v = <<<EOT
    		$str_htm3
EOT;

$str_htm3 = <<<EOT
<style>
table td{
  border: none;
  padding: 5px !important;
  background-color:#ECECEE;
  padding-top:2px;
  padding-left:2px;
  padding-right:2px;
  padding-bottom:2px;
}
</style>
<table WIDTH="740">
  <tbody>
    <tr>
      <td WIDTH="10"></td>
      <td WIDTH="85"></td>
      <td WIDTH="50"></td>
      <td WIDTH="150"></td>
      <td WIDTH="40"></td>
      <td WIDTH="25"></td>
      <td WIDTH="30"></td>
      <td WIDTH="60"></td>
      <td WIDTH="30"></td>
      <td WIDTH="40"></td>
      <td WIDTH="40"></td>
      <td WIDTH="60"></td>
      <td WIDTH="165"></td>
    </tr>
    <tr>
      <td WIDTH="10"></td>
      <td WIDTH="85">Nombre:</td>
      <td WIDTH="50">&nbsp;</td>
      <td WIDTH="150"><strong>$nombre</strong></td>
      <td WIDTH="40">&nbsp;</td>
      <td WIDTH="25">&nbsp;</td>
      <td WIDTH="30">&nbsp;</td>
      <td WIDTH="60">&nbsp;</td>
      <td WIDTH="30">&nbsp;</td>
      <td WIDTH="40">Muncipio:</td>
      <td WIDTH="40">&nbsp;</td>
      <td WIDTH="60"><strong>$municipio</strong></td>
      <td WIDTH="165">&nbsp;</td>
    </tr>
    <tr>
      <td WIDTH="10"></td>
      <td WIDTH="85">CCT:</td>
      <td WIDTH="50">&nbsp;</td>
      <td WIDTH="150"><strong>$cct</strong></td>
      <td WIDTH="40">&nbsp;</td>
      <td WIDTH="25">Turno:</td>
      <td WIDTH="30">&nbsp;</td>
      <td WIDTH="60"><strong>$turno</strong></td>
      <td WIDTH="30">&nbsp;</td>
      <td WIDTH="40">Modalidad:</td>
      <td WIDTH="40">&nbsp;</td>
      <td WIDTH="60"><strong>$modalidad</strong></td>
      <td WIDTH="165">&nbsp;</td>
    </tr>
    <tr>
      <td WIDTH="10"></td>
      <td WIDTH="85">Director / Responsable:</td>
      <td WIDTH="50">&nbsp;</td>
      <td WIDTH="150"><strong>$director</strong></td>
      <td WIDTH="40">&nbsp;</td>
      <td WIDTH="25">&nbsp;</td>
      <td WIDTH="30">&nbsp;</td>
      <td WIDTH="60">&nbsp;</td>
      <td WIDTH="30">&nbsp;</td>
      <td WIDTH="40">&nbsp;</td>
      <td WIDTH="40">&nbsp;</td>
      <td WIDTH="60">&nbsp;</td>
      <td WIDTH="165">&nbsp;</td>
    </tr>
    <tr>
      <td WIDTH="10"></td>
      <td WIDTH="85"></td>
      <td WIDTH="50"></td>
      <td WIDTH="150"></td>
      <td WIDTH="40"></td>
      <td WIDTH="25"></td>
      <td WIDTH="30"></td>
      <td WIDTH="60"></td>
      <td WIDTH="30"></td>
      <td WIDTH="40"></td>
      <td WIDTH="40"></td>
      <td WIDTH="60"></td>
      <td WIDTH="165"></td>
      </tr>
  </tbody>
</table>
EOT;

$encabezado_h = <<<EOT
$str_htm3
EOT;


$pdf=$this->header_footer_v($pdf,$reporte_datos,$encabezado_v);

    ///Empieza creación de grafica de pastel PERMANENCIA
    $graph_p = new PieGraph(350,250);
    $graph_p->SetBox(false);
    $p1 = new PiePlot($riesgo);
    $graph_p->Add($p1);
    $p1->ShowBorder();
    $p1->SetColor('black');
    $p1->SetSliceColors(array('#F9EC13','#F07622','#CD2027','#DBDAD8'));
    $graph_p->SetColor('#F7F7F6');
    $graph_p->img->SetImgFormat('png');
    $graph_p->Stroke('pastel.png');
    $pdf->Image('pastel.png', 125,85,55, 39, 'png', '', '', false, 300, '', false, false, 0);
    unlink('pastel.png');
    ///Termina creación de grafica de pastel

    ///Empieza creación de grafica de barras MATRICULA
    if ($reporte_datos['encabezado_n_nivel']=='PRIMARIA'|| $reporte_datos['encabezado_n_nivel']=='primaria'){
    $data1y=$est_asis_alumnos;
    $data2y=$est_asis_alumnos_h1;
    $data3y=$est_asis_alumnos_h2;
    // print_r($data1y);
    // print_r($data2y);
    // print_r($data3y);
    // die();
    }
    else {
    $data1y= array_slice($est_asis_alumnos, 0, 3);
    $data2y= array_slice($est_asis_alumnos_h1, 0, 3);
    $data3y= array_slice($est_asis_alumnos_h2, 0, 3);
    }
// echo "<pre>";
//  print_r($est_asis_alumnos);
//     print_r($est_asis_alumnos_h1);
//     print_r($est_asis_alumnos_h2);
//     die();
    $graph = new Graph(350,200,'auto');
    $graph->SetScale("textlin");
    $theme_class=new UniversalTheme;
    $graph->SetTheme($theme_class);
    $graph->SetBackgroundImage("assets/img/background.jpg",BGIMG_FILLFRAME);
    // $graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
    // $graph->yaxis->SetTickPositions(array(0,50,100,150,200,250,300,350), array(25,75,125,175,275,325));
// $graph->y2axis->SetTickPositions(array(30,40,50,60,70,80,90));
    $graph->SetBox(false);
    $graph->ygrid->SetFill(false);
    if ($reporte_datos['encabezado_n_nivel']=='PRIMARIA'|| $reporte_datos['encabezado_n_nivel']=='primaria'){
      $graph->xaxis->SetTickLabels(array('1','2','3','4','5','6'));
    }
    else {
      $graph->xaxis->SetTickLabels(array('1','2','3'));
    }
    $graph->yaxis->HideLine(false);
    $graph->yaxis->HideTicks(false,false);
    $b1plot = new BarPlot($data1y);
    $b2plot = new BarPlot($data2y);
    $b3plot = new BarPlot($data3y);
    $gbplot = new GroupBarPlot(array($b1plot,$b2plot,$b3plot));
    $graph->Add($gbplot);
    $b1plot->SetColor("white");
    $b1plot->SetFillColor("#e68dab");
    $b2plot->SetColor("white");
    $b2plot->SetFillColor("#00adea");
    $b3plot->SetColor("white");
    $b3plot->SetFillColor("#f1a73e");
    $graph->Stroke('barras.png');
    $pdf->Image('barras.png', 20,110,80, 50, 'PNG', '', '', false, 300, '', false, false, 0);
    unlink('barras.png');
    // /Termina creación de grafica de barras

    // /Empieza creación de grafica de barras DISTRIBUCION POR GRADO
    $data1y=$riesgo_alto;
    $data2y=$riesgo_muy_alto;

    if ($reporte_datos['encabezado_n_nivel']=='PRIMARIA'|| $reporte_datos['encabezado_n_nivel']=='primaria'){
      $data1y=$riesgo_alto;
      $data2y=$riesgo_muy_alto;
    }
    else {
      $data1y= array_slice($riesgo_alto, 0, 3);
      $data2y= array_slice($riesgo_muy_alto, 0, 3);
    }



    $graph1 = new Graph(350,200,'auto');
    $graph1->SetScale("textlin");
    $theme_class=new UniversalTheme;
    $graph1->SetTheme($theme_class);
    $graph1->yaxis->title->Set("Alumnos");
    $graph1->SetBackgroundImage("assets/img/background.jpg",BGIMG_FILLFRAME);
    $graph1->SetBox(false);
    $graph1->ygrid->SetFill(false);
    // $graph1->xaxis->Hide();
    if ($reporte_datos['encabezado_n_nivel']=='PRIMARIA'|| $reporte_datos['encabezado_n_nivel']=='primaria'){
      $graph1->xaxis->SetTickLabels(array('1','2','3','4','5','6'));
    }
    else {
      $graph1->xaxis->SetTickLabels(array('1','2','3'));
    }
    $graph1->yaxis->HideLine(false);
    $graph1->yaxis->HideTicks(false,false);
    $b1plot = new BarPlot($data1y);
    $b2plot = new BarPlot($data2y);
    $gbplot = new GroupBarPlot(array($b1plot,$b2plot));
    $graph1->Add($gbplot);
    $b1plot->SetColor("white");
    $b1plot->SetFillColor("#F47B2F");
    $b2plot->SetColor("white");
    $b2plot->SetFillColor("#EE1D23");
    $graph1->Stroke('barras1.png');
    $pdf->Image('barras1.png', 115,140,80, 50, 'PNG', '', '', false, 300, '', false, false, 0);
    unlink('barras1.png');
    ///Termina creación de grafica de barras


    $pdf->SetFont('montserrat', '', 7);


$str_htm3 = <<<EOT
    <style>
    table td{
      border: none;
      padding: 5px !important;
      background-color:#e4e0df;
    }
    </style>
    <table WIDTH="527">
      <tbody>
        <tr>
          <td WIDTH="24"></td>
          <td WIDTH="500">El propósito de este reporte es aportar información que ayude a tomar decisiones a las escuelas para asegurar la asistencia, permanencia y aprendizaje de todos
            sus estudiantes. Se sugiere ampliamente que el Consejo Técnico Escolar lo analice y actúe según lo juzgue necesario.</td>
          </tr>
        </tbody>
      </table>
EOT;

$html3 = <<<EOT
		$str_htm3
EOT;

$pdf->writeHTMLCell($w=120,$h=55,$x=12,$y=60, $html3, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$pdf->Image('assets/img/admiracion.png', 15,61,5, 5, '', '', '', false, 300, '', false, false, 0);


$str_htm3 = <<<EOT
<style>
table td{
  border: none;
  padding: 5px !important;
}
</style>
<table WIDTH="257">
  <tbody>
    <tr>
      <td HEIGHT="20" style="background-color:#C2001F; text-align:center;" color="white">ASISTENCIA</td>
    </tr>
    <tr>
      <td HEIGHT="570" style="background-color:#F7F7F6;"></td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

// $pdf->writeHTMLCell($w=200,$h=55,$x=12,$y=70, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);


// $pdf->writeHTMLCell($w=200,$h=55,$x=107,$y=70, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$pdf->SetFillColor(0, 0, 127);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$pdf->SetFont('montserratb', '', 13);
// set some text for example
$txt = 'ASISTENCIA';
$txt1 = 'PERMANENCIA';
$txt2 = 'APRENDIZAJE';


// Multicell test
$pdf->SetFillColor(0, 173, 234);
$pdf->SetTextColor(255, 255, 255);
$pdf->MultiCell(92, 7,$txt, 0, 'C', 1, 0, 13, 70, 'M');
$pdf->MultiCell(92, 7,$txt1, 0, 'C', 1, 0, 107, 70, 'M');

$pdf->SetFont('montserratb', '', 11);
$pdf->SetTextColor(145, 145, 145);
$pdf->MultiCell(65, 8,"Estadística de escuela", 0, 'L', 0, 0, 20, 77, 'M');
$pdf->SetFont('montserrat', '', 10);
$pdf->MultiCell(65, 8,"1", 0, 'L', 0, 0, 65, 77, 'M');

$pdf->SetFont('montserratb', '', 11);
$pdf->MultiCell(85, 10,"Inicio de ciclo escolar 2019-2020", 0, 'L', 0, 0, 20, 82, 'M');
$pdf->MultiCell(65, 10,"1", 0, 'L', 0, 0, 65, 77, 'M');
// $pdf->MultiCell(80, 0, $left_column, 0, 'J', 1, 0, '', '', true, 0, false, true, 0);

//pinta el fondo de color de las 2 columnas de la 1ra y segunda hoja
$pdf->SetFillColor(239, 239, 239);
$pdf->MultiCell(95.75, 200,'', 0, 'C', 1, 0, 10.5, 84.57, true);
// $pdf->MultiCell(92, 200,'', 0, 'C', 1, 0, 107, 78, true);

$pdf->SetTextColor(0, 0, 0);

$asi_est_al_t=$reporte_datos['asi_est_al_t'];
$asi_est_gr_t=$reporte_datos['asi_est_gr_t'];
$asi_est_doc=$reporte_datos['asi_est_do_t'];
$pdf->SetFont('montserrat', '', 8);
if ($reporte_datos['encabezado_n_nivel']=='PRIMARIA'|| $reporte_datos['encabezado_n_nivel']=='primaria'){
$str_htm3 = <<<EOT
<style>
table td{
  border: .3px solid #BFC0C3;
  padding: 2px !important;
  padding-top:1px;
  padding-left:1px;
  padding-right:1px;
  padding-bottom:1px;
}
</style>
<table width="90mm">
  <tbody>
    <tr style="background-color:#e4e4e2; text-align:center;">
      <td width="15mm" style="background-color:#b6b6b; font-family:Montserrat-Bold; font-size:7;">&nbsp;</td>
      <td width="9.40mm"style="background-color:#b6b6b; font-family:Montserrat-Bold; font-size:7;">Total</td>
      <td width="9.03mm" style="background-color:#b6b6b; font-family:Montserrat-Bold; font-size:7;">1<sup>o</sup></td>
      <td width="9.03mm" style="background-color:#b6b6b; font-family:Montserrat-Bold; font-size:7;">2<sup>o</sup></td>
      <td width="9.03mm" style="background-color:#b6b6b; font-family:Montserrat-Bold; font-size:7;">3<sup>o</sup></td>
      <td width="9.03mm" style="background-color:#b6b6b; font-family:Montserrat-Bold; font-size:7;">4<sup>o</sup></td>
      <td width="9.03mm" style="background-color:#b6b6b; font-family:Montserrat-Bold; font-size:7;">5<sup>o</sup></td>
      <td width="9.03mm" style="background-color:#b6b6b; font-family:Montserrat-Bold; font-size:7;">6<sup>o</sup></td>
      <td width="11.40mm" style="background-color:#b6b6b; font-family:Montserrat-Bold; font-size:7;">Multigrado</td>
    </tr>
    <tr>
      <td  width="15mm" style="background-color:#e4e4e2; font-family:Montserrat-Regular; font-size:7;">Alumnos</td>
      <td width="9.40mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$asi_est_al_t</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$est_asis_alumnos[0]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$est_asis_alumnos[1]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$est_asis_alumnos[2]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$est_asis_alumnos[3]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$est_asis_alumnos[4]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$est_asis_alumnos[5]</td>
      <td width="11.40mm"></td>
    </tr>
    <tr>
      <td  width="15mm" style="background-color:#e4e4e2; font-family:Montserrat-Regular; font-size:7;">Grupos</td>
      <td width="9.40mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$asi_est_gr_t</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$est_asis_gr[0]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$est_asis_gr[1]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$est_asis_gr[2]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$est_asis_gr[3]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$est_asis_gr[4]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$est_asis_gr[5]</td>
      <td width="11.40mm"></td>
    </tr>
    <tr>
      <td  width="15mm" style="background-color:#e4e4e2; font-family:Montserrat-Regular; font-size:7;">Docentes</td>
      <td  width="9.40mm"style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7;">$asi_est_doc</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center;"></td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center;"></td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center;"></td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center;"></td>
      <td width="9.03mm" style="background-color:#ffffff; text-align:center;"></td>
      <td width="9.03mm" style="background-color:#ffffff; text-align:center;"></td>
      <td width="11.40mm"></td>
    </tr>
  </tbody>
</table>
EOT;
}

else {
  $str_htm3 = <<<EOT
  <style>
  table td{
    border: .3px solid #BFC0C3;
    padding: 2px !important;
    padding-top:1px;
    padding-left:1px;
    padding-right:1px;
    padding-bottom:1px;
  }
  </style>
  <table width="90mm">
    <tbody>
      <tr style="background-color:#e4e4e2; text-align:center;">
        <td width="15mm">&nbsp;</td>
        <td style="text-align:center; font-family:Montserrat-Bold; font-size:7;">Total</td>
        <td style="text-align:center; font-family:Montserrat-Bold; font-size:7;">1<sup>o</sup></td>
        <td style="text-align:center; font-family:Montserrat-Bold; font-size:7;">2<sup>o</sup></td>
        <td style="text-align:center; font-family:Montserrat-Bold; font-size:7;">3<sup>o</sup></td>
      </tr>
      <tr>
        <td width="15mm" style="background-color:#e4e4e2; font-family:Montserrat-Regular; font-size:7;">Alumnos</td>
        <td style="text-align:center;">$asi_est_al_t</td>
        <td style="text-align:center;">$est_asis_alumnos[0]</td>
        <td style="text-align:center;">$est_asis_alumnos[1]</td>
        <td style="text-align:center;">$est_asis_alumnos[2]</td>
      </tr>
      <tr>
        <td width="15mm" style="background-color:#e4e4e2;"><font face='Montserrat-Regular' size="7">Grupos</font></td>
        <td style="text-align:center;">$asi_est_gr_t</td>
        <td style="text-align:center;">$est_asis_gr[0]</td>
        <td style="text-align:center;">$est_asis_gr[1]</td>
        <td style="text-align:center;">$est_asis_gr[2]</td>
      </tr>
      <tr>
        <td width="15mm" style="background-color:#e4e4e2;"><font face='Montserrat-Regular' size="7">Docentes</font></td>
        <td style="text-align:center;">$asi_est_doc</td>
        <td colspan="6"></td>

      </tr>
    </tbody>
  </table>
EOT;
}
$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=90,$h=23.12,$x=12,$y=87, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$ti_ciclo_ac=$reporte_datos['asi_est_ac_ciclo'];
$ti_ciclo_h1=$reporte_datos['asi_est_h1_ciclo'];
$ti_ciclo_h2=$reporte_datos['asi_est_h2_ciclo'];
$tot_ciclo_h1=$reporte_datos['asi_est_h1_gr_t'];
$tot_ciclo_h2=$reporte_datos['asi_est_h2_gr_t'];




$str_htm3 = <<<EOT
<style>
table td{
  border: .3px solid #BFC0C3;
  padding: 2px !important;
  padding-top:1px;
  padding-left:1px;
  padding-right:1px;
  padding-bottom:1px;
}
</style>
<table WIDTH="245">
  <tbody>
    <tr>
      <td style="background-color:#DCDDDF;">Alumnos</td>
      <td style="background-color:#9E2E21;"></td>
      <td style="text-align:center;">$ti_ciclo_ac</td>
      <td style="background-color:#939598;"></td>
      <td style="text-align:center;">$ti_ciclo_h1</td>
      <td style="background-color:#399443;"></td>
      <td style="text-align:center;">$ti_ciclo_h2</td>
    </tr>
    <tr>
      <td style="background-color:#DCDDDF;">Grupos</td>
      <td style="text-align:center;" colspan="2">$asi_est_al_t</td>
      <td style="text-align:center;" colspan="2">$tot_ciclo_h1</td>
      <td style="text-align:center;" colspan="2">$tot_ciclo_h2</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=15,$y=165, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$anios_asis=$reporte_datos['asi_rez_gedad_noasiste'];

$str_htm3 = <<<EOT
<style>
table td{
  border: .3px solid #BFC0C3;
  padding: 2px !important;
  padding-top:1px;
  padding-left:1px;
  padding-right:1px;
  padding-bottom:0px;
}
</style>
<table WIDTH="245">
  <tbody>
    <tr WIDTH="245">
      <td colspan="7">REZAGO EDUCATIVO</td>
    </tr>
    <tr WIDTH="245" style="background-color:#DCDDDF;">
      <td WIDTH="95">Inasistencia escolar</td>
      <td WIDTH="70" style="text-align:center;"colspan="3">Población total</td>
      <td WIDTH="80" style="text-align:center;"colspan="3">No asiste a la escuela</td>
    </tr>
    <tr style="background-color:#DCDDDF;">
      <td>Grupo de edad que no asiste a la escuela</td>
      <td style="text-align:center;"><img src="assets/img/male.png" border="0" height="16" width="8"  /></td>
      <td style="text-align:center;"><img src="assets/img/female.png" border="0" height="16" width="8" align="middle" /></td>
      <td style="text-align:center;"><img src="assets/img/male_female.png" border="0" height="16" width="16" align="middle" /></td>
      <td style="text-align:center;"><img src="assets/img/male.png" border="0" height="16" width="8" align="middle" /></td>
      <td style="text-align:center;"><img src="assets/img/female.png" border="0" height="16" width="8" align="middle" /></td>
      <td style="text-align:center;"><img src="assets/img/male_female.png" border="0" height="16" width="16" align="middle" /></td>
    </tr>
    <tr>
      <td style="background-color:#DCDDDF; text-align:left;">$anios_asis</td>
      <td style="text-align:center;">$rez_ed[0]</td>
      <td style="text-align:center;">$rez_ed[1]</td>
      <td style="text-align:center;">$rez_ed[2]</td>
      <td style="text-align:center;">$rez_na[0]</td>
      <td style="text-align:center;">$rez_na[1]</td>
      <td style="text-align:center;">$rez_na[2]</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=15,$y=195, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$str_htm3 = <<<EOT
<style>
table td{
  border: .3px solid #BFC0C3;
  padding: 2px !important;
  padding-top:1px;
  padding-left:1px;
  padding-right:1px;
  padding-bottom:1px;
}
</style>
<table WIDTH="245">
  <tbody>
    <tr>
      <td colspan="4">ANALFABETISMO</td>
    </tr>
    <tr WIDTH="245" style="background-color:#DCDDDF;">
      <td WIDTH="140"></td>
      <td WIDTH="35" style="text-align:center;"><img src="assets/img/male.png" border="0" height="16" width="8"  /></td>
      <td WIDTH="35" style="text-align:center;"><img src="assets/img/female.png" border="0" height="16" width="8" align="middle" /></td>
      <td WIDTH="35" style="text-align:center;"><img src="assets/img/male_female.png" border="0" height="16" width="16" align="middle" /></td>
    </tr>
    <tr>
      <td style="background-color:#DCDDDF;">Población mayor de 15 años que no sabe leer ni escribir</td>
      <td style="text-align:center;">$analfabeta[0]</td>
      <td style="text-align:center;">$analfabeta[1]</td>
      <td style="text-align:center;">$analfabeta[2]</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=15,$y=230, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$pdf->MultiCell(80, 10,'Lenguas nativas: '.$reporte_datos['asi_lenguas_nativas'], 0, 'L', 1, 0, 23, 265, 'M');

$rit=$reporte_datos['per_riesgo_al_t'];
$str_htm3 = <<<EOT
<style>
table td{
  border: .3px solid #BFC0C3;
  padding: 2px !important;
  padding-top:1px;
  padding-left:1px;
  padding-right:1px;
  padding-bottom:1px;
}
</style>
<table WIDTH="245">
  <tbody>

    <tr style="background-color:#DCDDDF;">
      <td style="text-align:center;">Total</td>
      <td colspan="2" style="text-align:center;">Muy alto</td>
      <td colspan="2" style="text-align:center;">Alto</td>
      <td colspan="2" style="text-align:center;">Medio</td>
      <td colspan="2" style="text-align:center;">Bajo</td>
    </tr>
    <tr>
      <td style="text-align:center;">$rit</td>
      <td style="background-color:#D1232A;"></td>
      <td style="text-align:center;">$riesgo[0]</td>
      <td style="background-color:#F47B2F;"></td>
      <td style="text-align:center;">$riesgo[1]</td>
      <td style="background-color:#FFF101;"></td>
      <td style="text-align:center;">$riesgo[2]</td>
      <td style="background-color:#D1D2D4;"></td>
      <td style="text-align:center;">$riesgo[3]</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=110,$y=125, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

if ($reporte_datos['encabezado_n_nivel']=='PRIMARIA'|| $reporte_datos['encabezado_n_nivel']=='primaria'){
$str_htm3 = <<<EOT
<style>
table td{
  border: .3px solid #BFC0C3;
  padding: 2px !important;
  padding-top:1px;
  padding-left:1px;
  padding-right:1px;
  padding-bottom:1px;
}
</style>
<table WIDTH="245">
  <tbody>

    <tr style="background-color:#E6E7E9;">
      <td style="text-align:center;" colspan="3">Grados</td>
      <td style="text-align:center;">1<sup>o</sup></td>
      <td style="text-align:center;">2<sup>o</sup></td>
      <td style="text-align:center;">3<sup>o</sup></td>
      <td style="text-align:center;">4<sup>o</sup></td>
      <td style="text-align:center;">5<sup>o</sup></td>
      <td style="text-align:center;">6<sup>o</sup></td>
    </tr>
    <tr>
      <td style="background-color:#F5842A;">&nbsp;</td>
      <td colspan="2" style="background-color:#DCDDDF;">Alto</td>
      <td style="text-align:center;">$riesgo_alto[0]</td>
      <td style="text-align:center;">$riesgo_alto[1]</td>
      <td style="text-align:center;">$riesgo_alto[2]</td>
      <td style="text-align:center;">$riesgo_alto[3]</td>
      <td style="text-align:center;">$riesgo_alto[4]</td>
      <td style="text-align:center;">$riesgo_alto[5]</td>
    </tr>
    <tr>
      <td style="background-color:#D1232A;">&nbsp;</td>
      <td colspan="2" style="background-color:#DCDDDF;">Muy alto</td>
      <td style="text-align:center;">$riesgo_muy_alto[0]</td>
      <td style="text-align:center;">$riesgo_muy_alto[1]</td>
      <td style="text-align:center;">$riesgo_muy_alto[2]</td>
      <td style="text-align:center;">$riesgo_muy_alto[3]</td>
      <td style="text-align:center;">$riesgo_muy_alto[4]</td>
      <td style="text-align:center;">$riesgo_muy_alto[5]</td>
    </tr>
  </tbody>
</table>
EOT;
}
else {
  $str_htm3 = <<<EOT
  <style>
  table td{
    border: .3px solid #BFC0C3;
    padding: 2px !important;
    padding-top:1px;
    padding-left:1px;
    padding-right:1px;
    padding-bottom:1px;
  }
  </style>
  <table WIDTH="245">
    <tbody>

      <tr style="background-color:#E6E7E9;">
        <td style="text-align:center;" colspan="3">Grados</td>
        <td style="text-align:center;">1<sup>o</sup></td>
        <td style="text-align:center;">2<sup>o</sup></td>
        <td style="text-align:center;">3<sup>o</sup></td>
      </tr>
      <tr>
        <td style="background-color:#F5842A;">&nbsp;</td>
        <td colspan="2" style="background-color:#DCDDDF;">Alto</td>
        <td style="text-align:center;">$riesgo_alto[0]</td>
        <td style="text-align:center;">$riesgo_alto[1]</td>
        <td style="text-align:center;">$riesgo_alto[2]</td>
      </tr>
      <tr>
        <td style="background-color:#D1232A;">&nbsp;</td>
        <td colspan="2" style="background-color:#DCDDDF;">Muy alto</td>
        <td style="text-align:center;">$riesgo_muy_alto[0]</td>
        <td style="text-align:center;">$riesgo_muy_alto[1]</td>
        <td style="text-align:center;">$riesgo_muy_alto[2]</td>
      </tr>
    </tbody>
  </table>
EOT;
}
$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=110,$y=195, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);


$retencion=$reporte_datos['per_ind_retencion'];
$aprobacion=$reporte_datos['per_ind_aprobacion'];
$efic_ter=$reporte_datos['per_ind_et'];


$str_htm3 = <<<EOT
<style>
table td{
  border: .3px solid #BFC0C3;
  padding: 2px !important;
  padding-top:1px;
  padding-left:1px;
  padding-right:1px;
  padding-bottom:1px;
}
</style>
<table WIDTH="245" style="text-align:center;">
  <tbody>

    <tr style="background-color:#B7BCC8;">
      <td>Retención</td>
      <td>Aprobación</td>
      <td>Eficiencia Terminal</td>
    </tr>
    <tr>
      <td>$retencion</td>
      <td>$aprobacion</td>
      <td>$efic_ter</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=110,$y=220, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$pdf->Image('assets/img/escuela_icon.png', 16,78,5, 5, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/mat_his.png', 16,110,5, 5, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/porcen_asis.png', 16,180,4, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/lenguas_icon.png', 16,264,6, 5, '', '', '', false, 300, '', false, false, 0);

$pdf->Image('assets/img/alu_riesgo_icon.png', 110,82,3, 5, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/dist_grado_icon.png', 110,138,6, 4, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/indic_icon.png', 110,210,7, 5, '', '', '', false, 300, '', false, false, 0);



///TERMINA PRIMERA PÁGINA

/// INICIA SEGUNDA PÄGINA
$pdf=$this->header_footer_v($pdf,$reporte_datos,$encabezado_v);

$pdf->SetFont('', '', 8);
$pdf->SetFillColor(194, 0, 31);
$pdf->SetTextColor(255, 255, 255);
$pdf->MultiCell(185, 10,$txt2, 0, 'C', 1, 0, 13, 60, true);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(255, 255, 255);
$pdf->MultiCell(120, 10,$reporte_datos['apr_ete'].'% Porcentaje de alumnos egresados con aprendizajes suficientes', 0, 'L', 1, 0, 17, 80, 'M');

$pdf->MultiCell(50, 10,'Lenguaje y Comunicación', 0, 'L', 1, 0, 50, 95, 'M');
$pdf->MultiCell(50, 10,'Matemáticas', 0, 'L', 1, 0, 130, 95, 'M');


$tipo='leng';
$pdf = $this->planea_graf($pdf,$reporte_datos['apr_planea2_nlogro_esc_lyc_i'],$reporte_datos['apr_planea2_nlogro_esc_lyc_ii-iii-iv'],1,$tipo);
$pdf = $this->planea_graf($pdf,$reporte_datos['apr_planea1_nlogro_esc_lyc_i'],$reporte_datos['apr_planea1_nlogro_esc_lyc_ii-iii-iv'],2,$tipo);
$pdf = $this->planea_graf($pdf,$reporte_datos['apr_planea_nlogro_estado_lyc_i'],$reporte_datos['apr_planea_nlogro_estado_lyc_ii-iii-iv'],3,$tipo);
$pdf = $this->planea_graf($pdf,$reporte_datos['apr_planea_nlogro_pais_lyc_i'],$reporte_datos['apr_planea_nlogro_pais_lyc_ii-iii-iv'],4,$tipo);

$tipo='mat';
$pdf = $this->planea_graf($pdf,$reporte_datos['apr_planea2_nlogro_esc_mat_i'],$reporte_datos['apr_planea2_nlogro_esc_mat_ii-iii-iv'],1,$tipo);
$pdf = $this->planea_graf($pdf,$reporte_datos['apr_planea1_nlogro_esc_mat_i'],$reporte_datos['apr_planea1_nlogro_esc_mat_ii-iii-iv'],2,$tipo);
$pdf = $this->planea_graf($pdf,$reporte_datos['apr_planea_nlogro_estado_mat_i'],$reporte_datos['apr_planea_nlogro_estado_mat_ii-iii-iv'],3,$tipo);
$pdf = $this->planea_graf($pdf,$reporte_datos['apr_planea_nlogro_pais_mat_i'],$reporte_datos['apr_planea_nlogro_pais_mat_ii-iii-iv'],4,$tipo);



///Empieza creación de grafica de barras

$prom_cal_esp=array(0 => $reporte_datos['apr_prom_al_esc_esp_5'],1 => $reporte_datos['apr_prom_al_esc_esp_6-7'],2 => $reporte_datos['apr_prom_al_esc_esp_8-9'],3 => $reporte_datos['apr_prom_al_esc_esp_10'] );
$prom_cal_mat=array(0 => $reporte_datos['apr_prom_al_esc_mat_5'],1 => $reporte_datos['apr_prom_al_esc_mat_6-7'],2 => $reporte_datos['apr_prom_al_esc_mat_8-9'],3 => $reporte_datos['apr_prom_al_esc_mat_10'] );

/////Inicia gráfica español
// print_r($prom_cal_esp);
// print_r($planea_aprov); die();
$data1y=$prom_cal_esp;
$data2y=$planea_aprov[1];
$data3y=array(0,0,0,0,0,0);
$graph = new Graph(350,200,'auto');
$graph->SetScale("textlin");
$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);
$graph->yaxis->SetTickPositions(array(0,10,20,30,40), array(5,15,25,35));
$graph->SetBox(false);
$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array('5   NI','6-7  NII','8-9  NIII','10   NIV'));
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);
$b1plot = new BarPlot($data1y);
$b2plot = new BarPlot($data2y);
$gbplot = new GroupBarPlot(array($b1plot,$b2plot));
$graph->Add($gbplot);
$b1plot->SetColor("white");
$b1plot->SetFillColor("#F47B2F");
$b2plot->SetColor("white");
$b2plot->SetFillColor("#EE1D23");
$graph->Stroke('barras2.png');

$pdf->Image('barras2.png', 10,160,80, 50, 'PNG', '', '', false, 300, '', false, false, 0);

unlink('barras2.png');

/////Termina gráfica español

/////Inicia gráfica mate
$data1y=$prom_cal_mat;
$data2y=$planea_aprov[1];
$data3y=array(0,0,0,0,0,0);
$graph = new Graph(350,200,'auto');
$graph->SetScale("textlin");
$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);
$graph->yaxis->SetTickPositions(array(0,10,20,30,40), array(5,15,25,35));
$graph->SetBox(false);
$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array('5   NI','6-7  NII','8-9  NIII','10   NIV'));
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);
$b1plot = new BarPlot($data1y);
$b2plot = new BarPlot($data2y);
$gbplot = new GroupBarPlot(array($b1plot,$b2plot));
$graph->Add($gbplot);
$b1plot->SetColor("white");
$b1plot->SetFillColor("#F47B2F");
$b2plot->SetColor("white");
$b2plot->SetFillColor("#EE1D23");
$graph->Stroke('barras3.png');

$pdf->Image('barras3.png', 110,160,80, 50, 'PNG', '', '', false, 300, '', false, false, 0);

unlink('barras3.png');

/////Termina gráfica mate

$planea_ciclo=$reporte_datos['apr_planea1_nlogro_esc_periodo'];
$str_htm3 = <<<EOT
<style>
table td{
  border: .3px solid #BFC0C3;
  padding: 2px !important;
  padding-top:1px;
  padding-left:1px;
  padding-right:1px;
  padding-bottom:1px;
}
</style>
<table WIDTH="210" style="text-align:left;">
  <tbody>
    <tr>
      <td WIDTH="80">Calificaciones</td>
      <td WIDTH="20" style="background-color:#D1232A;"></td>
      <td WIDTH="90">Niveles PLANEA $planea_ciclo</td>
      <td WIDTH="20" style="background-color:#F5842A;"></td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->SetTextColor(0, 0, 0);
$pdf->writeHTMLCell($w=60,$h=30,$x=65,$y=220, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

///Contenidos temáticos

$cont_tem_lyc = array(0 => array('txt' => $reporte_datos['apr_planea1_ct_esc_lyc_1txt'] ,'por' => $reporte_datos['apr_planea1_ct_esc_lyc_1por']), 1 => array('txt' => $reporte_datos['apr_planea1_ct_esc_lyc_2txt'] ,'por' => $reporte_datos['apr_planea1_ct_esc_lyc_2por']), 2 => array('txt' => $reporte_datos['apr_planea1_ct_esc_lyc_3txt'] ,'por' => $reporte_datos['apr_planea1_ct_esc_lyc_3por']), 3 => array('txt' => $reporte_datos['apr_planea1_ct_esc_lyc_4txt'],'por' => $reporte_datos['apr_planea1_ct_esc_lyc_4por']));
$cont_tem_mat= array(0 => array('txt' => $reporte_datos['apr_planea1_ct_esc_mat_1txt'] ,'por' => $reporte_datos['apr_planea1_ct_esc_mat_1por']), 1 => array('txt' => $reporte_datos['apr_planea1_ct_esc_mat_2txt'] ,'por' => $reporte_datos['apr_planea1_ct_esc_mat_2por']), 2 => array('txt' => $reporte_datos['apr_planea1_ct_esc_mat_3txt'] ,'por' => $reporte_datos['apr_planea1_ct_esc_mat_3por']), 3 => array('txt' => $reporte_datos['apr_planea1_ct_esc_mat_4txt'],'por' => $reporte_datos['apr_planea1_ct_esc_mat_4por']));;


//////lyc
$str_htm3 = <<<EOT
<style>
table td{
  border: .3px solid #BFC0C3;
  padding: 2px !important;
  padding-top:1px;
  padding-left:1px;
  padding-right:1px;
  padding-bottom:1px;
}
</style>
<table WIDTH="222">
  <tbody>
EOT;

foreach ($cont_tem_lyc as $lyc) {
if ($lyc['txt']!=''){
// echo $lyc['txt'];
$txt=$lyc['txt'];
$por=$lyc['por'];

$str_htm3 .= <<<EOT
<tr>
  <td WIDTH="22" style="text-align:center;"><font color="red">$por%</font></td>
  <td WIDTH="200" style="text-align:left;">$txt</td>
</tr>
EOT;
}
}
// die();

$str_htm3 .= <<<EOT
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;
$pdf->writeHTMLCell($w=60,$h=30,$x=20,$y=240, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

/////mat

$str_htm3 = <<<EOT
<style>
table td{
  border: .3px solid #BFC0C3;
  padding: 2px !important;
  padding-top:1px;
  padding-left:1px;
  padding-right:1px;
  padding-bottom:1px;
}
</style>
<table WIDTH="222">
  <tbody>
EOT;

foreach ($cont_tem_mat as $mat) {
if ($mat['txt']!=''){
// echo $mat['txt'];
$txt=$mat['txt'];
$por=$mat['por'];

$str_htm3 .= <<<EOT
<tr>
  <td WIDTH="22" style="text-align:center;"><font color="red"><strong>$por%</strong></font></td>
  <td WIDTH="200" style="text-align:left;">$txt</td>
</tr>
EOT;
}
}
// die();

$str_htm3 .= <<<EOT
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;
$pdf->writeHTMLCell($w=60,$h=30,$x=105,$y=240, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$pdf->Image('assets/img/efic_ter_icon.png', 16,72,5, 5, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/planea_icon.png', 16,87,5, 6, '', '', '', false, 300, '', false, false, 0);

$pdf->Image('assets/img/esc_ver_icon.png', 16,105,6, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/esc_ver_icon.png', 16,117,6, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/esta_icon.png', 16,129,6, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/pais_icon.png', 16,141,6, 6, '', '', '', false, 300, '', false, false, 0);

$pdf->Image('assets/img/cont_tem_icon.png', 22,230,6, 6, '', '', '', false, 300, '', false, false, 0);


// $pdf->Image('assets/img/planea_icon.png', 16,85,5, 6, '', '', '', false, 300, '', false, false, 0);
// $pdf->Image('assets/img/planea_icon.png', 16,85,5, 6, '', '', '', false, 300, '', false, false, 0);


///Termina contenidos temáticos

/// INICIA TERCERA PÄGINA
// $pdf=$this->header_footer_h($pdf,$reporte_datos,$encabezado_h);
$idreporte=$reporte_datos['idreporteapa'];
$alumnos_baja=$this->Apa_model->get_alumnos_baja($idreporte);
// echo "<pre>";print_r($alumnos_baja);die();
$array_items = array_chunk($alumnos_baja, 10);
foreach ($array_items as $key => $item) {
  $array_return =  $this->pinta_al_baja($pdf, $item,$reporte_datos,$encabezado_v);
  $pdf = $array_return['pdf'];
}

/// Termina TERCERA PÄGINA

/// INICIA Cuarta PÄGINA

$alumnos_mar=$this->Apa_model->get_alumnos_mar($idreporte);
// echo "<pre>";print_r($alumnos_mar);die();
$array_items = array_chunk($alumnos_mar, 10);
foreach ($array_items as $key => $item) {
  $array_return =  $this->pinta_muy_alto($pdf, $item,$reporte_datos,$encabezado_v);
  $pdf = $array_return['pdf'];
}

// $pdf=$this->header_footer_h($pdf,$reporte_datos,$encabezado_h);
/// Termina Cuarta PÄGINA


$pdf->Output('certificado.pdf', 'I');
}


private function planea_graf($pdf,$a,$b,$yg,$tipo){

   if($b<25){
     $a1=$a-20;
     $b1=$b+20;
   }
   else {
     $a1=$a;
     $b1=$b;
   }

$str_htm3 = <<<EOT
  <style>
  table td{
    border: none;
  }
  </style>
  <table>
    <tbody>
    <tr WIDTH="105" HEIGHT="15">
      <td width="$a1" style="text-align:center;" HEIGHT="15"><strong>I</strong></td>
      <td width="5" HEIGHT="15"></td>
      <td width="$b1" style="text-align:right;" HEIGHT="15"><strong>II, III, IV</strong></td>
    </tr>
      <tr WIDTH="105" HEIGHT="15">
        <td width="$a" style="background-color:#F47B2F; text-align:center;" color="white" HEIGHT="15"><strong>$a%</strong></td>
        <td width="5" HEIGHT="15">&nbsp;</td>
        <td width="$b" style="background-color:#EE1D23; text-align:center;" color="white" HEIGHT="15"><strong>$b%</strong></td>
      </tr>
    </tbody>
  </table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;
$pdf->SetFont('', '', 7);
if ($yg==1){
$yg=100;
}
elseif ($yg==2){
$yg=112;
}
elseif ($yg==3){
$yg=124;
}
else {
$yg=136;
}

if ($tipo=='leng'){
  $xg=50;
}
else {
  $xg=130;
}

$pdf->writeHTMLCell($w=60,$h=10,$x=$xg,$y=$yg, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

return $pdf;

}

private function header_footer_v($pdf,$reporte_datos,$encabezado_v){
  $pdf->SetFont('', '', 10);
  $pdf->SetAutoPageBreak(TRUE, 0);
  $pdf->AddPage('P', 'A4');
  $pdf->Image('assets/img/encabezado.png', 0,0,210, 35, '', '', '', false, 300, '', false, false, 0);
  $pdf->Image('assets/img/pie.png', 0,282,210, 15, '', '', '', false, 300, '', false, false, 0);
  $pdf->SetAutoPageBreak(FALSE, 0);
  $pdf->SetFillColor(129, 113, 106);
  $pdf->SetFont('montserratb', '', 12);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->MultiCell(35, 10,$reporte_datos['encabezado_n_nivel'], 0, 'C', false, 0, 165, 24, 'M');
  $pdf->SetFont('montserratb', '', 10);
  // $pdf->SetTextColor(80, 76, 75);
  $pdf->SetTextColor(150, 146, 143);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->MultiCell(50, 10,$reporte_datos['encabezado_n_periodo'].' PERIODO', 0, 'R', false, 0, 143, 30, 'M');

  $pdf->SetFont('', '', 8);

  $pdf->writeHTMLCell($w=120,$h=55,$x=11.59,$y=36.78, $encabezado_v, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=false);
// $pdf->SetFillColor(0, 0, 0);
// $pdf->MultiCell(12.6, 10,'', 0, 'C', true, 0, 0, 36, 'M');

$pdf->SetFillColor(0, 0, 0);
$pdf->MultiCell(11.22, 10,'', 0, 'C', true, 0, 198.88, 30, 'M');
  return $pdf;
}

 function header_footer_h($pdf,$reporte_datos,$encabezado_h){
  $pdf->SetAutoPageBreak(TRUE, 0);
  $pdf->AddPage('L', 'A4');
  $pdf->Image('assets/img/encabezado_h.png', 0,0,300, 35, '', '', '', false, 300, '', false, false, 0);
  $pdf->Image('assets/img/pie_h.png', 0,195,300, 15, '', '', '', false, 300, '', false, false, 0);
  $pdf->SetAutoPageBreak(FALSE, 0);
  $pdf->SetFillColor(129, 113, 106);
  $pdf->SetFont('', '', 10);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->MultiCell(30, 10,$reporte_datos['encabezado_n_nivel'], 0, 'R', 1, 0, 250, 18, 'M');
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->MultiCell(50, 10,$reporte_datos['encabezado_n_periodo'].' PERIODO', 0, 'R', 1, 0, 230, 28, 'M');


  $pdf->writeHTMLCell($w=150,$h=55,$x=10,$y=40, $encabezado_h, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

  return $pdf;
}

 function pinta_al_baja($pdf,$array_datos,$reporte_datos,$encabezado_v){
  // add a page
  // $pdf->SetAutoPageBreak(TRUE, 0);
  $pdf=$this->header_footer_v($pdf,$reporte_datos,$encabezado_v);

$pdf->Image('assets/img/admiracion.png', 16,71,5, 5, '', '', '', false, 300, '', false, false, 0);
$msj = '<h2 style="font-size=300px !important; color:#919191 !important;">Alumnos que muy posiblemente han abandonado sus estudios<sup>2</sup></h2>
<table WIDTH="104mm">
      <tbody>
        <tr>
          <td  style="background-color:#e4e0df; !important; font-weight:normal !important; border:none !important;" WIDTH="10mm"></td>
          <td  style="background-color:#e4e0df; !important; font-weight:normal !important; border:none !important;" WIDTH="178mm"><font face="Montserrat-Regular">Alumnos dados de baja, que aún no han sido registrados en otra escuela de Sinaloa.<br>
Contacte inmediatamente a su padre, madre o tutor para procurar que se reintegre a la escuela con los apoyos académicos necesarios.</font></td>
          </tr>
        </tbody>
      </table>
  ';
  $html= <<<EOT
$msj
EOT;

$pdf->writeHTMLCell($w=0,$h=55,$x=12,$y=60, $html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
  $str_html='
  <style>
  table td{
    padding: 2px !important;
    border: .3px solid #BFC0C3;
    font-weight: bold;
  }
  table th{
    padding: 2px !important;
    text-align: center;
    border: .3px solid #BFC0C3;
    background-color:#E6E7E9;
  }
  </style>
  <table width= "100%">
<tr>
<th width= "40%" HEIGHT="20">Nombre</th>
<th width= "21%" >Grado / Grupo</th>
<th width= "40%">Motivo</th>
</tr>';

  // $contador = 1;
  // echo "<pre>"; print_r($array_datos); die();
  foreach ($array_datos as $key => $alumno) {

      $str_html .= '<tr>
      <td HEIGHT="20"> '.$alumno['nombre_alu'].'</td>
      <td style="text-align:center;"> '.$alumno['grado'].'<sup>o</sup>'.strtoupper($alumno['grupo']).'</td>
      <td> '.$alumno['motivo'].'</td>
      </tr>';
}

  $str_html .= '</table>';

// $str_html = "";
$html= <<<EOT
$str_html
EOT;

$pdf->writeHTMLCell($w=0,$h=55,$x=12,$y=85, $html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

  return [
    'pdf' => $pdf
    ];
}// pinta_al_baja()

function pinta_muy_alto($pdf,$array_datos,$reporte_datos,$encabezado_v){
 // add a page
 // $pdf->SetAutoPageBreak(TRUE, 0);
 $pdf=$this->header_footer_v($pdf,$reporte_datos,$encabezado_v);


$pdf->Image('assets/img/admiracion.png', 16,70,5, 5, '', '', '', false, 300, '', false, false, 0);
$msj = '<h2 style="font-size=300px !important; color:#919191 !important;">Alumnos con alto y muy alto riesgo de abandono<sup>2</sup></h2>
<table WIDTH="104mm" HEIGHT="12mm">
      <tbody>
        <tr>
          <td  style="background-color:#e4e0df; !important; font-weight:normal !important; border:none !important;" WIDTH="10mm" HEIGHT="9.7mm"></td>
          <td  style="background-color:#e4e0df; !important; font-weight:normal !important; border:none !important;" WIDTH="175mm" HEIGHT="9.7mm"><font face="Montserrat-Regular">Por combinar inasistencias, bajas calificaciones y/o años sobre la edad ideal del grado.<br>
Cite a los padres de familia en forma inmediata para acordar acciones y asegurar su permanencia en la escuela.</font></td>
          </tr>
        </tbody>
      </table>
  ';
  $html= <<<EOT
$msj
EOT;

$pdf->writeHTMLCell($w=0,$h=55,$x=12,$y=60, $html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

 $str_html='
 <style>
 table td{
   padding: 2px !important;
   border: .3px solid #BFC0C3;
   font-weight: bold;
 }
 table th{
   padding: 2px !important;
   text-align: center;
   border: .3px solid #BFC0C3;
   background-color:#E6E7E9;
 }
 </style>
 <table width= "100%">
<tr>
<th width= "55mm" HEIGHT="20">Nombre</th>
<th width= "23.4mm" >Grado / Grupo</th>
<th width= "22.18mm">Inasistencias en periodo</th>
<th width= "21.10mm">Asignaturas Reprobadas</th>
<th width= "20.11mm">Extraedad</th>
<th width= "44.15mm">Madre, Padre o Tutor</th>
</tr>';

 // $contador = 1;
 // echo "<pre>"; print_r($array_datos); die();
 foreach ($array_datos as $key => $alumno) {
  if (isset($alumno['bandera'])) {
      if ($alumno['bandera'] == 1) {
       $cuadrito='   <img src="assets/img/cuadrito-rojo.png"  height="7" padding-top="2mm" width="7" align-v="center"/>  ';
     }else if ($alumno['bandera'] == 2) {
      $cuadrito='   <img src="assets/img/cuadrito-naranja.png"  height="7" padding-top="2mm" width="7" align-v="center"/>  ';
    }
  }else{
    $cuadrito='   <img src="assets/img/cuadrito-gris.png"  height="7" padding-top="2mm" width="7" align-v="center"/>  ';
  }
     $str_html .= '<tr>
     <td width= "55mm" style="border-left-style: none;" HEIGHT="20">'.$cuadrito.$alumno['nombre_alu'].'</td>
     <td width= "23.4mm" style="text-align:center;"> '.$alumno['grado'].'<sup>o</sup>'.strtoupper($alumno['grupo']).'</td>
     <td width= "22.18mm" style="text-align:center;"> '.$alumno['inasistencias'].'</td>
     <td width= "21.10mm" style="text-align:center;"> '.$alumno['asig_reprobadas'].'</td>
     <td width= "20.11mm" style="text-align:center;" > '.$alumno['extraedad'].'</td>
     <td width= "44.15mm"> '.$alumno['nombre_madre_padre_tutor'].'</td>
     </tr>';
}

 $str_html .= '</table>';

 // echo $str_html;die();

// $str_html = "";
$html= <<<EOT
$str_html
EOT;

$pdf->writeHTMLCell($w=0,$h=55,$x=12,$y=80, $html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

 return [
   'pdf' => $pdf
   ];
}// pinta_muy_alto()


}

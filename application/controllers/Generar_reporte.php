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
    // $planea_aprov=$this->Apa_model->get_planea_aprov();
    // $array_datos_escuela=$this->Apa_model->get_datos_escuela();
    $reporte_datos=$this->Apa_model->get_reporte_apa($cct,$turno,$periodo,$ciclo);
    // echo "<pre>";print_r($reporte_datos);die();
    if (!isset($reporte_datos)) {
    echo "<h1>¡No se encontraron datos para mostrar!</h1>"; die();
    }
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

    $est_asis_gr= array(0 => $reporte_datos['asi_est_gr_1'],1 => $reporte_datos['asi_est_gr_2'],2 => $reporte_datos['asi_est_gr_3'],3 => $reporte_datos['asi_est_gr_4'],4 => $reporte_datos['asi_est_gr_5'],5 => $reporte_datos['asi_est_gr_6'],6=>$reporte_datos['asi_est_gruposmulti'] );

    $riesgo=array(0 => $reporte_datos['per_riesgo_al_muy_alto'],1 => $reporte_datos['per_riesgo_al_alto'],2 => $reporte_datos['per_riesgo_al_medio'],3 => $reporte_datos['per_riesgo_al_bajo'] );
    // echo '<pre>';print_r($reporte_datos);die();
    $riesgo_alto=array(0 => $reporte_datos['per_riesgo_al_alto_1'],1 => $reporte_datos['per_riesgo_al_alto_2'],2 => $reporte_datos['per_riesgo_al_alto_3'],3 => $reporte_datos['per_riesgo_al_alto_4'],4 => $reporte_datos['per_riesgo_al_alto_5'],5 => $reporte_datos['per_riesgo_al_alto_6'] );
    $riesgo_muy_alto=array(0 => $reporte_datos['per_riesgo_al_muy_alto_1'],1 => $reporte_datos['per_riesgo_al_muy_alto_2'],2 => $reporte_datos['per_riesgo_al_muy_alto_3'],3 => $reporte_datos['per_riesgo_al_muy_alto_4'],4 => $reporte_datos['per_riesgo_al_muy_alto_5'],5 => $reporte_datos['per_riesgo_al_muy_alto_6'] );


    $rez_ed = array(0 => number_format((float)$reporte_datos['asi_rez_pob_h']),1 => number_format((float)$reporte_datos['asi_rez_pob_m']),2 => number_format((float)$reporte_datos['asi_rez_pob_t']));
    $rez_na = array(0 => number_format((float)$reporte_datos['asi_rez_noasiste_h']),1 => number_format((float)$reporte_datos['asi_rez_noasiste_m']),2 =>number_format((float)$reporte_datos['asi_rez_noasiste_t']));
    $analfabeta = array(0 => number_format((float)$reporte_datos['asi_analfabeta_h']),1 => number_format((float)$reporte_datos['asi_analfabeta_m']),2 => number_format((float)$reporte_datos['asi_analfabeta_t']));


    $this->graf($riesgo,$historico,$distribucion,$array_datos_escuela,$est_asis_alumnos,$est_asis_gr,$est_asis_alumnos_h1,$est_asis_alumnos_h2,$rez_ed,$rez_na,$analfabeta,$riesgo_alto,$riesgo_muy_alto,$reporte_datos);
  }

  function graf($riesgo,$historico,$distribucion,$array_datos_escuela,$est_asis_alumnos,$est_asis_gr,$est_asis_alumnos_h1,$est_asis_alumnos_h2,$rez_ed,$rez_na,$analfabeta,$riesgo_alto,$riesgo_muy_alto,$reporte_datos){
    // echo "<pre>";print_r($reporte_datos);die();

    //// Parámetros iniciales para PDF///

    $pdf = new My_tcpdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Proyecto Educativo');
    $pdf->SetTitle('Reporte APA');
    $pdf->SetSubject('Reporte APA');
    // $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    $nombre=$array_datos_escuela['nombre'];
    $cct=$array_datos_escuela['cct'];
    $director=$array_datos_escuela['director'];
    $turno=$array_datos_escuela['turno'];
    $municipio=mb_strtoupper ($array_datos_escuela['municipio'], 'UTF-8');
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
              <td WIDTH="10" HEIGHT="13"></td>
              <td WIDTH="40" HEIGHT="13"><font face="Montserrat-Regular" color="#555">Nombre:</font></td>
              <td WIDTH="55" HEIGHT="13">&nbsp;</td>
              <td WIDTH="170" HEIGHT="13"><font face="Montserrat-Bold" color="#555">$nombre</font></td>
              <td WIDTH="5" HEIGHT="13">&nbsp;</td>
              <td WIDTH="5" HEIGHT="13">&nbsp;</td>
              <td WIDTH="5" HEIGHT="13">&nbsp;</td>
              <td WIDTH="5" HEIGHT="13">&nbsp;</td>
              <td WIDTH="20" HEIGHT="13">&nbsp;</td>
              <td WIDTH="60" HEIGHT="13"><font face="Montserrat-Regular" color="#555">Municipio:</font></td>
              <td WIDTH="5" HEIGHT="13">&nbsp;</td>
              <td WIDTH="140.88" HEIGHT="13"><font face="Montserrat-Bold" color="#555">$municipio</font></td>
              <td WIDTH="5" HEIGHT="13">&nbsp;</td>
              <td WIDTH="2" HEIGHT="13"></td>
            </tr>
            <tr>
              <td WIDTH="10" HEIGHT="13"></td>
              <td WIDTH="85" HEIGHT="13"><font face="Montserrat-Regular" color="#555">CCT:</font></td>
              <td WIDTH="10" HEIGHT="13">&nbsp;</td>
              <td WIDTH="60" HEIGHT="13"><font face="Montserrat-Bold" color="#555">$cct</font></td>
              <td WIDTH="35" HEIGHT="13">&nbsp;</td>
              <td WIDTH="30" HEIGHT="13"><font face="Montserrat-Regular" color="#555">Turno:</font></td>
              <td WIDTH="15" HEIGHT="13">&nbsp;</td>
              <td WIDTH="55" HEIGHT="13"><font face="Montserrat-Bold" color="#555">$turno</font></td>
              <td WIDTH="15" HEIGHT="13">&nbsp;</td>
              <td WIDTH="50" HEIGHT="13"><font face="Montserrat-Regular" color="#555">Modalidad:</font></td>
              <td WIDTH="15" HEIGHT="13">&nbsp;</td>
              <td WIDTH="45" HEIGHT="13"><font face="Montserrat-Bold" color="#555">$modalidad</font></td>
              <td WIDTH="102.88" HEIGHT="13">&nbsp;</td>
            </tr>
            <tr>
              <td WIDTH="10"></td>
              <td WIDTH="95"><font face="Montserrat-Regular" color="#555">Director / Responsable:</font></td>
              <td WIDTH="200"><font face="Montserrat-Bold" color="#555">$director</font></td>
              <td WIDTH="222.88">&nbsp;</td>
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



$pdf=$this->header_footer_v($pdf,$reporte_datos,$encabezado_v);


    ///Empieza creación de grafica de pastel PERMANENCIA
// echo "<pre>";
//     print_r(
//       array_sum($riesgo)
//     ); 
// die();
$imagenpie = "";
    if(array_sum($riesgo) != 0){
    $graph_p = new PieGraph(350,250);
    $graph_p->SetBox(false);
    $p1 = new PiePlot($riesgo);
    // echo"<pre>";
    // print_r($p1); die();
    $graph_p->Add($p1);
    $p1->ShowBorder();
    $p1->SetColor('black');
    
      // $p1->SetSliceColors(array('#ffffff'));
      $p1->SetSliceColors(array('#cd1719','#ee7521','#ffed00','#dadada'));
    
    // $graph_p->SetColor('#F7F7F6');
    $graph_p->SetColor('#EFEFEF');
    $graph_p->img->SetImgFormat('png');
    $graph_p->Stroke('pastel.png');
    
    $pdf->Image('pastel.png', 110,95,70, 50, 'png', '', '', false, 300, '', false, false, 0);
    unlink('pastel.png');
    }else{
      $str_htmmensaje = <<<EOT
    <p>SIN DATOS QUE MOSTRAR</p>
EOT;

$htmlmsn = <<<EOT
    $str_htmmensaje
EOT;

$pdf->writeHTMLCell($w=70,$h=50,$x=130,$y=115, $htmlmsn, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
    }

    ///Termina creación de grafica de pastel


    $pdf->SetFont('montserratb', '', 11);
    $pdf->SetTextColor(145, 145, 145);
    $pdf->MultiCell(99, 8,"Alumnos en riesgo de abandono escolar", 0, 'L', 0, 0, 112, 87, 'M');
    $pdf->SetFont('montserrat', '', 9);
    $pdf->MultiCell(5, 5,"2", 0, 'L', 0, 0, 193.5, 87, 'M');

    ///Empieza creación de grafica de barras MATRICULA
    if ($reporte_datos['encabezado_n_nivel']=='PRIMARIA'|| $reporte_datos['encabezado_n_nivel']=='primaria'){
    $data1y=$est_asis_alumnos_h1;
    $data2y=$est_asis_alumnos_h2;
    $data3y=$est_asis_alumnos;
    // print_r($data1y);
    // print_r($data2y);
    // print_r($data3y);
    // die();
    }
    else {
    $data1y= array_slice($est_asis_alumnos_h1, 0, 3);
    $data2y= array_slice($est_asis_alumnos_h2, 0, 3);
    $data3y= array_slice($est_asis_alumnos, 0, 3);
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
      $graph->xaxis->SetTickLabels(array('1°','2°','3°','4°','5°','6°'));
    }
    else {
      $graph->xaxis->SetTickLabels(array('1°','2°','3°'));
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
    $pdf->Image('barras.png', 12.6,128,90, 50, 'PNG', '', '', false, 300, '', false, false, 0);
    unlink('barras.png');

    $pdf->Line(12.6, 118, 103, 118,array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'phase' => 10, 'color' => array(206,206,206)));

    $pdf->SetFont('montserratb', '', 11);
    $pdf->SetTextColor(145, 145, 145);
    $pdf->MultiCell(65, 8,"Histórico de matrícula", 0, 'L', 0, 0, 20, 120, 'M');
    $pdf->SetFont('montserrat', '', 9);
    $pdf->MultiCell(5, 5,"1", 0, 'L', 0, 0, 67, 120, 'M');

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


    $style = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(192, 192, 192));
    $pdf->Line(110, 157, 195, 157, $style);

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
      $graph1->xaxis->SetTickLabels(array('1°','2°','3°','4°','5°','6°'));
    }
    else {
      $graph1->xaxis->SetTickLabels(array('1°','2°','3°'));
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
    $pdf->Image('barras1.png', 107,165,75,49, 'PNG', '', '', false, 300, '', false, false, 0);
    unlink('barras1.png');
    ///Termina creación de grafica de barras

    $pdf->SetFont('montserratb', '', 11);
    $pdf->SetTextColor(145, 145, 145);
    $pdf->MultiCell(100, 8,"Distribución por grado", 0, 'L', 0, 0, 120, 161, 'M');
    $pdf->SetFont('montserrat', '', 9);
    $pdf->MultiCell(5, 5,"2", 0, 'L', 0, 0, 167, 161, 'M');

    $pdf->SetFont('montserrat', '', 7);


$str_htm3 = <<<EOT
    <style>
    table td{
      border: none;
      padding: 10px !important;
      background-color:#e4e0df;
    }
    </style>
    <table WIDTH="200mm">
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

$pdf->writeHTMLCell($w=120,$h=55,$x=11.59,$y=60, $html3, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$pdf->Image('assets/img/admiracion.png', 14,60.8,5, 5, '', '', '', false, 300, '', false, false, 0);


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

$pdf->MultiCell(92.75, 3.4,'', 0, 'C', 1, 0, 11.59, 71, true);
$pdf->MultiCell(92.75, 3.4,$txt, 0, 'C', 1, 0, 11.59, 74.4, true);
$pdf->MultiCell(92.75, 3.4,'', 0, 'C', 1, 0, 11.59, 77.8, true);

$pdf->MultiCell(90.65, 3.4,'', 0, 'C', 1, 0, 106.64, 71, true);
$pdf->MultiCell(90.65, 3.4,$txt1, 0, 'C', 1, 0, 106.64, 74.4, true);
$pdf->MultiCell(90.65, 3.4,'', 0, 'C', 1, 0, 106.64, 77.8, true);

$pdf->SetFont('montserratb', '', 11);
$pdf->SetTextColor(145, 145, 145);
$pdf->MultiCell(65, 8,"Estadística de escuela", 0, 'L', 0, 0, 20, 85, true);
$pdf->SetFont('montserrat', '', 9);
$pdf->MultiCell(5, 5,"1", 0, 'L', 0, 0, 65, 85, true);

$pdf->SetFont('montserratb', '', 10);
$pdf->MultiCell(85, 10,"Inicio de ciclo escolar ".$reporte_datos['asi_est_ciclo1'], 0, 'L', 0, 0, 20, 90, true);

// $pdf->MultiCell(80, 0, $left_column, 0, 'J', 1, 0, '', '', true, 0, false, true, 0);

//pinta el fondo de color de las 2 columnas de la 1ra y segunda hoja
$pdf->SetFillColor(239, 239, 239);
$pdf->MultiCell(92.80, 194,'', 0, 'C', 1, 0, 11.59, 84.57, true);
$pdf->MultiCell(90.75, 194,'', 0, 'C', 1, 0, 106.63, 84.57, true);

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
    <tr style="background-color:#e4e4e2; text-align:center;" height="7.31mm">
      <td width="15mm" style="background-color:#b5b5b5; font-family:Montserrat-Bold; font-size:7;">&nbsp;</td>
      <td width="9.40mm"style="background-color:#b5b5b5; font-family:Montserrat-Bold; font-size:7; color:#545452;">Total</td>
      <td width="9.03mm" style="background-color:#b5b5b5; font-family:Montserrat-Bold; font-size:7; color:#545452;">1<sup>o</sup></td>
      <td width="9.03mm" style="background-color:#b5b5b5; font-family:Montserrat-Bold; font-size:7; color:#545452;">2<sup>o</sup></td>
      <td width="9.03mm" style="background-color:#b5b5b5; font-family:Montserrat-Bold; font-size:7; color:#545452;">3<sup>o</sup></td>
      <td width="9.03mm" style="background-color:#b5b5b5; font-family:Montserrat-Bold; font-size:7; color:#545452;">4<sup>o</sup></td>
      <td width="9.03mm" style="background-color:#b5b5b5; font-family:Montserrat-Bold; font-size:7; color:#545452;">5<sup>o</sup></td>
      <td width="9.03mm" style="background-color:#b5b5b5; font-family:Montserrat-Bold; font-size:7; color:#545452;">6<sup>o</sup></td>
      <td width="11.40mm" style="background-color:#b5b5b5; font-family:Montserrat-Bold; font-size:7; color:#545452;">Multigrado</td>
    </tr>
    <tr height="5.27mm">
      <td  width="15mm" style="background-color:#e4e4e2; font-family:Montserrat-Regular; font-size:7;">Alumnos</td>
      <td width="9.40mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$asi_est_al_t</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_alumnos[0]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_alumnos[1]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_alumnos[2]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_alumnos[3]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_alumnos[4]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_alumnos[5]</td>
      <td width="11.40mm" style="background-color:#E2E4E4; text-align:center;"></td>
    </tr>
    <tr height="5.27mm">
      <td  width="15mm" style="background-color:#e4e4e2; font-family:Montserrat-Regular; font-size:7;">Grupos</td>
      <td width="9.40mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$asi_est_gr_t</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_gr[0]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_gr[1]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_gr[2]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_gr[3]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_gr[4]</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_gr[5]</td>
      <td width="11.40mm" style="background-color:#ffffff; text-align:center; color:#545452; font-family:Montserrat-Bold; font-size:7;">$est_asis_gr[6]</td>
    </tr>
    <tr height="5.27mm">
      <td  width="15mm" style="background-color:#e4e4e2; font-family:Montserrat-Regular; font-size:7;">Docentes</td>
      <td  width="9.40mm"style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$asi_est_doc</td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center;"></td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center;"></td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center;"></td>
      <td  width="9.03mm" style="background-color:#ffffff; text-align:center;"></td>
      <td width="9.03mm" style="background-color:#ffffff; text-align:center;"></td>
      <td width="9.03mm" style="background-color:#ffffff; text-align:center;"></td>
      <td width="11.40mm" style="background-color:#E2E4E4; text-align:center;"></td>
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
        <td width="20mm">&nbsp;</td>
        <td width="12mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452">Total</td>
        <td width="12mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452">1<sup>o</sup></td>
        <td width="12mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452">2<sup>o</sup></td>
        <td width="12mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452">3<sup>o</sup></td>
        <td width="22mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452">Multigrado</td>
      </tr>
      <tr>
        <td width="20mm" style="background-color:#e4e4e2; font-family:Montserrat-Regular; font-size:7; color:#545452;">Alumnos</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:7; color:#545452;">$asi_est_al_t</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_alumnos[0]</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_alumnos[1]</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_alumnos[2]</td>
        <td width="22mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;"></td>
      </tr>
      <tr>
        <td width="20mm" style="background-color:#e4e4e2; font-family:Montserrat-Regular; font-size:7; color:#545452;">Grupos</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:7; color:#545452;">$asi_est_gr_t</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:7; color:#545452;">$est_asis_gr[0]</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:7;color:#545452;">$est_asis_gr[1]</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:7;color:#545452;">$est_asis_gr[2]</td>
        <td width="22mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452; background-color:#ffffff;">$est_asis_gr[6]</td>
      </tr>
      <tr>
        <td width="20mm" style="background-color:#e4e4e2; font-family:Montserrat-Regular; font-size:7; color:#545452;">Docentes</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  color:#545452; font-family:Montserrat-Bold; font-size:7;">$asi_est_doc</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;"></td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;"></td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;"></td>
        <td width="22mm"></td>

      </tr>
    </tbody>
  </table>
EOT;
}
$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=90,$h=23.12,$x=12,$y=95, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$ti_ciclo_ac=$reporte_datos['asi_est_h1_ciclo'];
$ti_ciclo_h1=$reporte_datos['asi_est_h2_ciclo'];
$ti_ciclo_h2=$reporte_datos['asi_est_ac_ciclo'];
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
<table width="82.28mm">
  <tbody>
    <tr>
      <td width="28.22mm" style="background-color:#E7E7E7; font-family:Montserrat-Regular; font-size:7; color:#646462;">Ciclo</td>
      <td width="3.02mm" style="background-color:#e68dab; "></td>
      <td width="15mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452; background-color:#E7E7E7">$ti_ciclo_ac</td>
      <td width="3.02mm" style="background-color:#00adea;"></td>
      <td width="15mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452; background-color:#E7E7E7">$ti_ciclo_h1</td>
      <td width="3.02mm" style="background-color:#f1a73e;"></td>
      <td width="15mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452; background-color:#E7E7E7">$ti_ciclo_h2</td>
    </tr>
    <tr>
      <td width="28.22mm" style="background-color:#E7E7E7; font-family:Montserrat-Regular; font-size:7; color:#646462;">Total de alumnos</td>
      <td width="18.02mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452; background-color:#ffffff;">$tot_ciclo_h1</td>
      <td width="18.02mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452; background-color:#ffffff;">$tot_ciclo_h2</td>
      <td width="18.02mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452; background-color:#ffffff;">$asi_est_al_t</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=82.28,$h=16,$x=15,$y=180, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$anios_asis=$reporte_datos['asi_rez_gedad_noasiste'];

$pdf->Line(12.6, 197, 103, 197,array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'phase' => 10, 'color' => array(206,206,206)));

$pdf->SetFont('montserratb', '', 11);
$pdf->SetTextColor(145, 145, 145);
$pdf->MultiCell(75, 8,"Rezago educativo del municipio", 0, 'L', 0, 0, 20, 202, 'M');
$pdf->SetFont('montserrat', '', 9);
$pdf->MultiCell(5, 5,"3", 0, 'L', 0, 0, 87, 202, 'M');

/*$rez_ed0=number_format((float)$rez_ed[0]);
$rez_ed1=number_format((float)$rez_ed[1]);
$rez_ed2=number_format((float)$rez_ed[2]);
$rez_na0=number_format((float)$rez_na[0]);
$rez_na1=number_format((float)$rez_na[1]);
$rez_na2=number_format((float)$rez_na[2]);*/


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
<table width="90mm">
  <tbody>
    <tr>
      <td width="90mm" height="6.29" style="background-color:#ffffff; font-family:Montserrat-Medium; font-size:9; border:none; color:#545452;">Inasistencia</td>
    </tr>
    <tr  style="background-color:#E7E7E7;">
      <td width="22.78mm" height="8.16" style="font-family:Montserrat-Bold; font-size:7; color:#545452;">Inasistencia escolar</td>
      <td width="33.61mm" height="8.16" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">Población total</td>
      <td width="33.61mm" height="8.16" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">No asiste a la escuela</td>
    </tr>
    <tr style="background-color:#E7E7E7;">
      <td width="22.78mm" height="11.05" style="font-family:Montserrat-Bold; font-size:7; color:#545452;">Grupo de edad que no asiste a la escuela</td>
      <td width="11.203mm"style="text-align:center;"><img src="assets/img/male.png" border="0" height="16" width="8"/></td>
      <td width="11.203mm" style="text-align:center;"><img src="assets/img/female.png" border="0" height="16" width="8" align="middle" /></td>
      <td width="11.203mm" style="text-align:center;"><img src="assets/img/male_female.png" border="0" height="16" width="16" align="middle" /></td>
      <td width="11.203mm" style="text-align:center;"><img src="assets/img/male.png" border="0" height="16" width="8" align="middle" /></td>
      <td width="11.203mm" style="text-align:center;"><img src="assets/img/female.png" border="0" height="16" width="8" align="middle" /></td>
      <td width="11.203mm" style="text-align:center;"><img src="assets/img/male_female.png" border="0" height="16" width="16" align="middle" /></td>
    </tr>
    <tr>
      <td width="22.78mm" style="background-color:#E7E7E7; font-family:Montserrat-Bold; font-size:7; color:#545452;">$anios_asis</td>
      <td width="11.20mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$rez_ed[0]</td>
      <td width="11.20mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$rez_ed[1]</td>
      <td width="11.20mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$rez_ed[2]</td>
      <td width="11.20mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$rez_na[0]</td>
      <td width="11.20mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$rez_na[1]</td>
      <td width="11.20mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$rez_na[2]</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=90,$h=30,$x=12,$y=210, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

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
<table WIDTH="90mm">
  <tbody>
    <tr>
      <td width="90mm" height="5.78mm" style="background-color:#ffffff; font-family:Montserrat-Medium; font-size:9; color:#545452; border:none;">Analfabetismo</td>
    </tr>
    <tr style="background-color:#DCDDDF;">
      <td WIDTH="43.10mm" height="8.67mm"></td>
      <td WIDTH="16.49mm" height="8.67mm" style="text-align:center;"><img src="assets/img/male.png" border="0" height="16" width="8"  /></td>
      <td WIDTH="13.94mm" height="8.67mm" style="text-align:center;"><img src="assets/img/female.png" border="0" height="16" width="8" align="middle" /></td>
      <td WIDTH="16.49mm" height="8.67mm" style="text-align:center;"><img src="assets/img/male_female.png" border="0" height="16" width="16" align="middle" /></td>
    </tr>
    <tr>
      <td width="43.10mm" height="8.5mm" style="background-color:#DCDDDF; font-family:Montserrat-Bold; font-size:7; color:#545452;">Población mayor de 15 años que no sabe leer ni escribir</td>
      <td WIDTH="16.49mm" height="8.5mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$analfabeta[0]</td>
      <td WIDTH="13.94mm" height="8.5mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$analfabeta[1]</td>
      <td WIDTH="16.49mm" height="8.5mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$analfabeta[2]</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=90,$h=22.95,$x=12.1,$y=240, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$pdf->SetFont('montserratmedium','','9');
$pdf->SetTextColor(98,87,85);
$pdf->MultiCell(80, 10,'Lengua nativa: '.$reporte_datos['asi_lenguas_nativas'], 0, 'L', 1, 0, 23, 265, 'M');

$pdf->SetFont('montserratmedium','','7');
$pdf->SetTextColor(98,87,85);
$pdf->MultiCell(5, 5,'4', 0, 'L', 1, 0, 60, 265, 'M');

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
<table WIDTH="81mm">
  <tbody>

    <tr style="background-color:#D8D8D8;">
      <td width="13.53mm" style="text-align:center; font-family:Montserrat-Regular; font-size:8; color:#545452;">Total</td>
      <td width="18.53mm" colspan="2" style="text-align:center; font-family:Montserrat-Regular; font-size:8; color:#545452;">Muy alto</td>
      <td width="18.53mm" colspan="2" style="text-align:center; font-family:Montserrat-Regular; font-size:8; color:#545452;">Alto</td>
      <td width="18.53mm" colspan="2" style="text-align:center; font-family:Montserrat-Regular; font-size:8; color:#545452;">Medio</td>
      <td width="18.53mm" colspan="2" style="text-align:center; font-family:Montserrat-Regular; font-size:8; color:#545452;">Bajo</td>
    </tr>
    <tr>
      <td width="13.53mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$rit</td>
      <td width="3.53mm" style="background-color:#cd1719;"></td>
      <td width="15mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo[0]</td>
      <td width="3.53mm" style="background-color:#ee7521;"></td>
      <td width="15mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo[1]</td>
      <td width="3.53mm" style="background-color:#ffed00;"></td>
      <td width="15mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo[2]</td>
      <td width="3.53mm" style="background-color:#dadada;"></td>
      <td width="15mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo[3]</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=81,$h=30,$x=107,$y=146, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

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
<table WIDTH="81mm">
  <tbody>

    <tr style="background-color:#E6E7E9;">
      <td width="27.82mm" style="text-align:center; font-family:Montserrat-Regular; font-size:8; color:#545452;">Grados</td>
      <td width="9.52mm" style="text-align:center; font-family:Montserrat-Regular; font-size:8; color:#545452;">1<sup>o</sup></td>
      <td width="9.52mm" style="text-align:center; font-family:Montserrat-Regular; font-size:8; color:#545452;">2<sup>o</sup></td>
      <td width="9.52mm" style="text-align:center; font-family:Montserrat-Regular; font-size:8; color:#545452;">3<sup>o</sup></td>
      <td width="9.52mm" style="text-align:center; font-family:Montserrat-Regular; font-size:8; color:#545452;">4<sup>o</sup></td>
      <td width="9.52mm" style="text-align:center; font-family:Montserrat-Regular; font-size:8; color:#545452;">5<sup>o</sup></td>
      <td width="9.52mm" style="text-align:center; font-family:Montserrat-Regular; font-size:8; color:#545452;">6<sup>o</sup></td>
    </tr>
    <tr>
      <td width="6.02mm" style="background-color:#F5842A;">&nbsp;</td>
      <td width="21.8mm"  style="text-align:center; background-color:#DCDDDF; font-family:Montserrat-Regular; font-size:7; color:#545452;">Alto</td>
      <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_alto[0]</td>
      <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_alto[1]</td>
      <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_alto[2]</td>
      <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_alto[3]</td>
      <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_alto[4]</td>
      <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_alto[5]</td>
    </tr>
    <tr>
      <td width="6.02mm" style="background-color:#D1232A;">&nbsp;</td>
      <td width="21.8mm" style="text-align:center; background-color:#DCDDDF; font-family:Montserrat-Regular; font-family:7; color:#545452;">Muy alto</td>
      <td width="9.52mm" style="text-align:center; background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_muy_alto[0]</td>
      <td width="9.52mm" style="text-align:center; background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_muy_alto[1]</td>
      <td width="9.52mm" style="text-align:center; background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_muy_alto[2]</td>
      <td width="9.52mm" style="text-align:center; background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_muy_alto[3]</td>
      <td width="9.52mm" style="text-align:center; background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-family:7; color:#545452;">$riesgo_muy_alto[4]</td>
      <td width="9.52mm" style="text-align:center; background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_muy_alto[5]</td>
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
  <table WIDTH="81mm">
    <tbody>

      <tr style="background-color:#E6E7E9;">
        <td width="24.76mm" style="text-align:center; color:#545452;">Grados</td>
        <td width="18.74mm" style="text-align:center; color:#545452;">1<sup>o</sup></td>
        <td width="18.74mm" style="text-align:center; color:#545452;">2<sup>o</sup></td>
        <td width="18.74mm" style="text-align:center; color:#545452;">3<sup>o</sup></td>
      </tr>
      <tr>
        <td width="6.02mm" style="background-color:#F5842A;">&nbsp;</td>
        <td width="18.74mm" style="background-color:#DCDDDF; color:#545452;">Alto</td>
        <td width="18.74mm" style="background-color:#ffffff; text-align:center; color:#545452;">$riesgo_alto[0]</td>
        <td width="18.74mm" style="background-color:#ffffff; text-align:center; color:#545452;">$riesgo_alto[1]</td>
        <td width="18.74mm" style="background-color:#ffffff; text-align:center; color:#545452;">$riesgo_alto[2]</td>
      </tr>
      <tr>
        <td width="6.02mm" style="background-color:#D1232A;">&nbsp;</td>
        <td width="18.74mm" style="background-color:#DCDDDF; color:#545452;">Muy alto</td>
        <td width="18.74mm" style="background-color:#ffffff; text-align:center; color:#545452;">$riesgo_muy_alto[0]</td>
        <td width="18.74mm" style="background-color:#ffffff; text-align:center; color:#545452;">$riesgo_muy_alto[1]</td>
        <td width="18.74mm" style="background-color:#ffffff; text-align:center; color:#545452;">$riesgo_muy_alto[2]</td>
      </tr>
    </tbody>
  </table>
EOT;
}
$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=81,$h=30,$x=107,$y=220, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);


  $retencion=$reporte_datos['per_ind_retencion']." %";


  $aprobacion=$reporte_datos['per_ind_aprobacion']." %";

  $efic_ter=$reporte_datos['per_ind_et']." %";



$style = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(192, 192, 192));
$pdf->Line(110, 215, 195, 215, $style);
$pdf->SetFont('montserratb', '', 11);
$pdf->SetTextColor(145, 145, 145);
$pdf->MultiCell(65, 8,"Indicadores de permanencia", 0, 'L', 0, 0, 115, 240, 'M');
$pdf->SetFont('montserrat', '', 9);
$pdf->MultiCell(5, 5,"1", 0, 'L', 0, 0, 173, 240, 'M');
$pdf->SetFont('montserratb', '', 10);
$pdf->MultiCell(100, 7,"Inicio de ciclo escolar ".$reporte_datos['per_ind_ciclo'], 0, 'L', 0, 0, 115, 245, 'M');

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
<table WIDTH="81mm" style="text-align:center;">
  <tbody>

    <tr style="background-color:#B7BCC8;">
      <td width="23.33mm" style="font-family:Montserrat-Regular; font-size:8; color:#545452;">Retención</td>
      <td width="23.33mm" style="font-family:Montserrat-Regular; font-size:8; color:#545452;">Aprobación</td>
      <td width="34.34mm" style="font-family:Montserrat-Regular; font-size:8; color:#545452;">Eficiencia Terminal</td>
    </tr>
    <tr>
      <td width="23.33mm" style="background-color:#ffffff; font-family:Montserrat-Bold; font-size:7; color:#000;">$retencion</td>
      <td width="23.33mm" style="background-color:#ffffff; font-family:Montserrat-Bold; font-size:7; color:#000;">$aprobacion</td>
      <td width="34.34mm" style="background-color:#ffffff; font-family:Montserrat-Bold; font-size:7; color:#000;">$efic_ter</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=81.46,$h=10.71,$x=110,$y=250, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$pdf->Image('assets/img/escuela_icon.png', 13,88,5, 5, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/mat_his.png', 13,120,5, 5, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/porcen_asis.png', 13,202,4, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/lenguas_icon.png', 13,265,6, 5, '', '', '', false, 300, '', false, false, 0);

$pdf->Image('assets/img/alu_riesgo_icon.png', 109,88,3, 5, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/dist_grado_icon.png', 110,161,6, 4, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/indic_icon.png', 110,240,7, 5, '', '', '', false, 300, '', false, false, 0);

//pinto la fuente

$fuente = <<<EOT
<style>
table td{
  border:none;
  padding: 2px !important;
  padding-top:1px;
  padding-left:1px;
  padding-right:1px;
  padding-bottom:1px;
  font-family:Montserrat-Bold;
}
</style>
<table WIDTH="80mm" style="text-align:left;">
  <tbody>
    <tr>
      <td width="80mm" style="font-family:Montserrat-Bold; font-size:7; color:#000;"><sup>1</sup> Estadística escolar 911.</td>
    </tr>
    <tr>
      <td width="80mm" style="font-family:Montserrat-Bold; font-size:7; color:#000;"><sup>2</sup> Sistema de Control Escolar del Estado de Sinaloa.</td>
    </tr>
    <tr>
      <td width="80mm" style="font-family:Montserrat-Bold; font-size:7; color:#000;"><sup>3</sup> INEGI, encuesta Intercensal 2015.</td>
    </tr>
    <tr>
      <td width="80mm" style="font-family:Montserrat-Bold; font-size:7; color:#000;"><sup>4</sup> INALI con información de INEGI.</td>
    </tr>
  </tbody>
</table>
EOT;

$html5fuente = <<<EOT
$fuente
EOT;
$pdf->writeHTMLCell($w=80,$h=20,$x=110,$y=260, $html5fuente, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

///TERMINA PRIMERA PÁGINA

/// INICIA SEGUNDA PÄGINA
$pdf=$this->header_footer_v($pdf,$reporte_datos,$encabezado_v);
$pdf->SetFont('montserratb', 'B', 13);
$pdf->SetFillColor(0, 173, 234);
$pdf->SetTextColor(255, 255, 255);
$pdf->MultiCell(186.3, 3.4,"", 0, 'C', 1, 0, 12.6, 58, true);
$pdf->MultiCell(186.3, 3.4,$txt2, 0, 'C', 1, 0, 12.6, 61.4, true);
$pdf->MultiCell(186.3, 3.4,"", 0, 'C', 1, 0, 12.6, 64.8, true);

$pdf->Image('assets/img/efic_ter_icon.png', 16,76,5, 5, '', '', '', false, 300, '', false, false, 0);
$pdf->SetFont('montserratb', '', 11);
$pdf->SetTextColor(145, 145, 145);
$pdf->MultiCell(65, 8,"Eficiencia terminal efectiva", 0, 'L', 0, 0, 22, 76, 'M');
$pdf->SetTextColor(145, 145, 145);
$pdf->SetFillColor(255, 255, 255);
if ($reporte_datos['apr_ete']=='') {
  $pdf->SetFont('montserratb', '', 7);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->MultiCell(120, 10,'No es posible calcular el dato por falta de información.', 0, 'L', 1, 0, 32, 83, 'M');
}
else {
  $pdf->MultiCell(20, 10,$reporte_datos['apr_ete'].'%', 0, 'L', 1, 0, 22, 82, 'M');
  $pdf->SetFont('montserratb', '', 7);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->MultiCell(120, 10,'Porcentaje de alumnos egresados con aprendizajes suficientes.', 0, 'L', 1, 0, 32, 83, 'M');
}


// $pdf->SetFillColor(0, 0, 0);
// $pdf->MultiCell(50, 4.8,'', 0, 'C', true, 0, 0, 100, 'M');
$style = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(192, 192, 192));
$pdf->Line(18, 89, 193, 89, $style);

$pdf->Image('assets/img/planea_icon.png', 16,92,5, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->SetFont('montserratb', '', 11);
$pdf->SetTextColor(145, 145, 145);
$pdf->MultiCell(65, 8,"Resultados PLANEA ".$reporte_datos['apr_planea1_nlogro_esc_periodo'], 0, 'L', 0, 0, 22, 92, 'M');
$style = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(192, 192, 192));
$pdf->Line(108.89, 98, 108.89, 156, $style);

// $pdf->SetFillColor(0, 0, 0);
// $pdf->MultiCell(68.89, 10,'', 0, 'C', true, 0, 130, 100, 'M');

$pdf->SetFont('montserratextraboldi', '', 11);
$pdf->SetTextColor(75, 74, 72);
$pdf->SetFillColor(255, 255, 255);
$pdf->MultiCell(70, 10,'Lenguaje y Comunicación', 0, 'L', 1, 0, 37, 98, 'M');
$pdf->MultiCell(50, 10,'Matemáticas', 0, 'L', 1, 0, 130, 98, 'M');

$pdf->SetTextColor(85, 85, 85);
$pdf->SetFillColor(255, 255, 255);

$pdf->Image('assets/img/escuela_icon.png', 26,109,6, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->MultiCell(50, 10,'Escuela '.$reporte_datos['apr_planea2_nlogro_esc_periodo'], 0, 'L', 1, 0, 32, 111, 'M');
$pdf->Image('assets/img/escuela_icon.png', 26,121,6, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->MultiCell(50, 10,'Escuela '.$reporte_datos['apr_planea1_nlogro_esc_periodo'], 0, 'L', 1, 0, 32, 123, 'M');
$pdf->Image('assets/img/esta_icon.png', 26,133,6, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->MultiCell(50, 10,'Estado '.$reporte_datos['apr_planea_nlogro_estado_periodo'], 0, 'L', 1, 0, 32, 135, 'M');
$pdf->Image('assets/img/pais_icon.png', 26,145,6, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->MultiCell(50, 10,'País '.$reporte_datos['apr_planea_nlogro_pais_periodo'], 0, 'L', 1, 0, 32, 147, 'M');



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

$prom_cal_esp=array(
  0 => ($reporte_datos['apr_prom_al_esc_esp_5'] == '') ? 0: $reporte_datos['apr_prom_al_esc_esp_5'],
  1 => ($reporte_datos['apr_prom_al_esc_esp_6-7'] == '') ? 0: $reporte_datos['apr_prom_al_esc_esp_6-7'],
  2 => ($reporte_datos['apr_prom_al_esc_esp_8-9'] == '') ? 0: $reporte_datos['apr_prom_al_esc_esp_8-9'],
  3 => ($reporte_datos['apr_prom_al_esc_esp_10'] == '') ? 0: $reporte_datos['apr_prom_al_esc_esp_10']  );
$prom_cal_mat=array(
  0 => ($reporte_datos['apr_prom_al_esc_mat_5'] == '') ? 0: $reporte_datos['apr_prom_al_esc_mat_5'],
  1 => ($reporte_datos['apr_prom_al_esc_mat_6-7'] == '') ? 0: $reporte_datos['apr_prom_al_esc_mat_6-7'],
  2 => ($reporte_datos['apr_prom_al_esc_mat_8-9'] == '') ? 0: $reporte_datos['apr_prom_al_esc_mat_8-9'],
  3 => ($reporte_datos['apr_prom_al_esc_mat_10'] == '') ? 0: $reporte_datos['apr_prom_al_esc_mat_10']  );

$planea_aprov_esp=array(
  0 => ($reporte_datos['apr_planea1_nlogro_esc_lyc_i'] == '' ) ? 0 :$reporte_datos['apr_planea1_nlogro_esc_lyc_i'] ,
  1 => ($reporte_datos['apr_planea1_nlogro_esc_lyc_ii'] == '' ) ? 0 :$reporte_datos['apr_planea1_nlogro_esc_lyc_ii'] ,
  2 => ($reporte_datos['apr_planea1_nlogro_esc_lyc_iii'] == '' ) ? 0 :$reporte_datos['apr_planea1_nlogro_esc_lyc_iii'] ,
  3 => ($reporte_datos['apr_planea1_nlogro_esc_lyc_iv'] == '' ) ? 0 :$reporte_datos['apr_planea1_nlogro_esc_lyc_iv']  );
$planea_aprov_mat=array(
  0 => ($reporte_datos['apr_planea1_nlogro_esc_mat_i'] == '' ) ? 0 :$reporte_datos['apr_planea1_nlogro_esc_mat_i'] ,
  1 => ($reporte_datos['apr_planea1_nlogro_esc_mat_ii'] == '' ) ? 0 :$reporte_datos['apr_planea1_nlogro_esc_mat_ii'] ,
  2 => ($reporte_datos['apr_planea1_nlogro_esc_mat_iii'] == '' ) ? 0 :$reporte_datos['apr_planea1_nlogro_esc_mat_iii'] ,
  3 => ($reporte_datos['apr_planea1_nlogro_esc_mat_iv'] == '' ) ? 0 :$reporte_datos['apr_planea1_nlogro_esc_mat_iv']  );

$vect_esp = array();
$vect_esp = array_unique(array_merge((array)$prom_cal_esp, (array)$planea_aprov_esp));

$vect_mat = array();
$vect_mat = array_unique(array_merge((array)$prom_cal_mat, (array)$planea_aprov_mat));

asort($vect_esp, 0);
asort($vect_mat, 0);

if($vect_esp[0] == 0){
  $vect_esp =array();
}
if($vect_mat[0] == 0){
  $vect_mat = array();
}

$data1y=$prom_cal_esp;
$data2y=$planea_aprov_esp;
$data3y=array(0,0,0,0,0,0);
$graph = new Graph(350,200,'auto');
$graph->SetScale("textlin");
$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);
$graph->yaxis->SetTickPositions($vect_esp, $vect_esp);
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
$b1plot->SetFillColor("#ff9c3e");
$b2plot->SetColor("white");
$b2plot->SetFillColor("#9ac27c");
$graph->Stroke('barras2.png');

$pdf->Image('barras2.png', 10,163,80, 50, 'PNG', '', '', false, 300, '', false, false, 0);

unlink('barras2.png');

/////Termina gráfica español

/////Inicia gráfica mate
$data1y=$prom_cal_mat;
$data2y=$planea_aprov_mat;
$data3y=array(0,0,0,0,0,0);
$graph = new Graph(350,200,'auto');
$graph->SetScale("textlin");
$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);
$graph->yaxis->SetTickPositions($vect_mat, $vect_mat);
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
$b1plot->SetFillColor("#ff9c3e");
$b2plot->SetColor("white");
$b2plot->SetFillColor("#9ac27c");
$graph->Stroke('barras3.png');

$pdf->Image('barras3.png', 110,163,80, 50, 'PNG', '', '', false, 300, '', false, false, 0);

$pdf->SetFont('montserratb', 'B', 11);
$pdf->SetTextColor(75, 74, 72);
$pdf->SetFillColor(255, 255, 255);
$pdf->MultiCell(170, 10,'Comparativo entre resultados de PLANEA y aprovechamiento escolar', 0, 'L', 1, 0, 35, 160, 'M');
$style = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(192, 192, 192));
$pdf->Line(108.89, 170, 108.89, 215, $style);
unlink('barras3.png');

/////Termina gráfica mate

$pdf->SetFont('montserratb', 'B', 7);

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
      <td WIDTH="10" HEIGHT="10" style="background-color:#ff9c3e;"></td>
      <td WIDTH="90">Niveles PLANEA $planea_ciclo</td>
      <td WIDTH="10" HEIGHT="10" style="background-color:#9ac27c;"></td>
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
$pdf->Image('assets/img/cont_tem_icon.png', 16,225,6, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->SetFont('montserratb', '', 11);
$pdf->SetTextColor(145, 145, 145);
$pdf->MultiCell(165, 8,"Contenidos temáticos con menor porcentaje de aciertos en la escuela", 0, 'L', 0, 0, 22, 227, 'M');
$style = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(192, 192, 192));
$pdf->Line(108.89, 235, 108.89, 275, $style);
$pdf->SetFont('montserratb', '', 7);
$pdf->SetTextColor(0, 0, 0);
$cont_tem_lyc = array(0 => array('txt' => $reporte_datos['apr_planea1_ct_esc_lyc_1txt'] ,'por' => $reporte_datos['apr_planea1_ct_esc_lyc_1por']), 1 => array('txt' => $reporte_datos['apr_planea1_ct_esc_lyc_2txt'] ,'por' => $reporte_datos['apr_planea1_ct_esc_lyc_2por']), 2 => array('txt' => $reporte_datos['apr_planea1_ct_esc_lyc_3txt'] ,'por' => $reporte_datos['apr_planea1_ct_esc_lyc_3por']), 3 => array('txt' => $reporte_datos['apr_planea1_ct_esc_lyc_4txt'],'por' => $reporte_datos['apr_planea1_ct_esc_lyc_4por']), 4 => array('txt' => $reporte_datos['apr_planea1_ct_esc_lyc_5txt'],'por' => $reporte_datos['apr_planea1_ct_esc_lyc_5por']));
$cont_tem_mat= array(0 => array('txt' => $reporte_datos['apr_planea1_ct_esc_mat_1txt'] ,'por' => $reporte_datos['apr_planea1_ct_esc_mat_1por']), 1 => array('txt' => $reporte_datos['apr_planea1_ct_esc_mat_2txt'] ,'por' => $reporte_datos['apr_planea1_ct_esc_mat_2por']), 2 => array('txt' => $reporte_datos['apr_planea1_ct_esc_mat_3txt'] ,'por' => $reporte_datos['apr_planea1_ct_esc_mat_3por']), 3 => array('txt' => $reporte_datos['apr_planea1_ct_esc_mat_4txt'],'por' => $reporte_datos['apr_planea1_ct_esc_mat_4por']), 4 => array('txt' => $reporte_datos['apr_planea1_ct_esc_mat_5txt'],'por' => $reporte_datos['apr_planea1_ct_esc_mat_5por']));


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
// echo "<pre>";print_r($cont_tem_lyc);die();
if ($cont_tem_lyc[0]['txt']=='') {
  $str_htm3 .= <<<EOT
  <tr>

    <td WIDTH="230" style="text-align:left;"><font face="Montserrat-Regular">Dato no disponible.</font></td>
  </tr>
EOT;
}
else {
  foreach ($cont_tem_lyc as $lyc) {
    if ($lyc['txt']!=''){
    // echo $lyc['txt'];
    $txt=$lyc['txt'];
    $por=$lyc['por'];

    $str_htm3 .= <<<EOT
    <tr>
      <td WIDTH="22" style="text-align:center;"><font color="red">$por%</font></td>
      <td WIDTH="230" style="text-align:left;"><font face="Montserrat-Regular">$txt</font></td>
    </tr>
EOT;
    }
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
$pdf->writeHTMLCell($w=70,$h=30,$x=16,$y=235, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

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
if ($cont_tem_mat[0]['txt']=='') {
  $str_htm3 .= <<<EOT
  <tr>

    <td WIDTH="230" style="text-align:left;"><font face="Montserrat-Regular">Dato no disponible.</font></td>
  </tr>
EOT;
}
else {
  foreach ($cont_tem_mat as $mat) {
    if ($mat['txt']!=''){
    // echo $mat['txt'];
    $txt=$mat['txt'];
    $por=$mat['por'];

    $str_htm3 .= <<<EOT
    <tr>
      <td WIDTH="22" style="text-align:center;"><font color="red"><strong>$por%</strong></font></td>
      <td WIDTH="230" style="text-align:left;"><font face="Montserrat-Regular">$txt</font></td>
    </tr>
EOT;
    }
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
$pdf->writeHTMLCell($w=70,$h=30,$x=111,$y=235, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);







// $pdf->Image('assets/img/planea_icon.png', 16,85,5, 6, '', '', '', false, 300, '', false, false, 0);
// $pdf->Image('assets/img/planea_icon.png', 16,85,5, 6, '', '', '', false, 300, '', false, false, 0);


///Termina contenidos temáticos

/// INICIA TERCERA PÄGINA
// $pdf=$this->header_footer_h($pdf,$reporte_datos,$encabezado_h);
$idreporte=$reporte_datos['idreporteapa'];
$alumnos_baja=$this->Apa_model->get_alumnos_baja($idreporte);
if($alumnos_baja == null){
  array_push($alumnos_baja,'No hay datos para mostrar');
}
// echo "<pre>";print_r($alumnos_baja);die();
$array_items = array_chunk($alumnos_baja, 25);
foreach ($array_items as $key => $item) {
  $array_return =  $this->pinta_al_baja($pdf, $item,$reporte_datos,$encabezado_v);
  $pdf = $array_return['pdf'];
}

/// Termina TERCERA PÄGINA

/// INICIA Cuarta PÄGINA

$alumnos_mar=$this->Apa_model->get_alumnos_mar($idreporte);
// echo "<pre>";print_r($alumnos_mar);die();
if($alumnos_mar == null){
  array_push($alumnos_mar,'No hay datos para mostrar');
}
$array_items = array_chunk($alumnos_mar, 25);
foreach ($array_items as $key => $item) {
  $array_return =  $this->pinta_muy_alto($pdf, $item,$reporte_datos,$encabezado_v);
  $pdf = $array_return['pdf'];
}

// $pdf=$this->header_footer_h($pdf,$reporte_datos,$encabezado_h);
/// Termina Cuarta PÄGINA


$pdf->Output('Reporte_APA_Sinaloa_'.$reporte_datos['cct'].$reporte_datos['encabezado_n_turno'].'.pdf', 'I');
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
   if ($a<27) {
     $a_fotnt_size=5;
   }
   else {
     $a_fotnt_size=12;
   }
   if ($b<27) {
     $b_fotnt_size=5;
   }
   else {
     $b_fotnt_size=12;
   }
   // echo "<pre>";
   // print_r($a);
   // die();
   if ($a==0 || $a=='') {
     $srthtml_a='';
     $srthtml_a1='';
     if ($a=='' && $b=='') {
       $srthtml_a='<td width="100" style="text-align:center; border-radius: 1em 0 0 0;" HEIGHT="15"><strong>Dato no disponible.</strong></td>';
     }
   }
   else {
     $srthtml_a='<td width="'.$a.'" style="background-color:#ff9c3e; text-align:center; border-radius: 1em 0 0 0;" color="white" HEIGHT="15"><font size="'.$a_fotnt_size.'" face="Montserrat-Regular"><strong>'.$a.'%</strong></font></td>';
     $srthtml_a1='<td width="'.$a1.'" style="text-align:center; border-radius: 1em 0 0 0;" HEIGHT="15"><strong>I</strong></td>';
   }
   if ($b==0 || $b=='') {
     $srthtml_b='';
     $srthtml_b1='';
     // if ($b=='') {
     //   $srthtml_b='<td width="100" style="text-align:center; border-radius: 1em 0 0 0;" HEIGHT="15"><strong>Dato no disponible.</strong></td>';
     // }
   }
   else {
     $srthtml_b='<td width="'.$b.'" style="background-color:#9ac27c; text-align:center; border-radius: 1em 0 0 0;" color="white" HEIGHT="15"><font size="'.$b_fotnt_size.'" face="Montserrat-Regular"><strong>'.$b.'%</strong></font></td>';
     $srthtml_b1='<td width="'.$b1.'" style="text-align:right; border-radius: 1em 0 0 0;" HEIGHT="15"><strong>II, III, IV</strong></td>';
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
      $srthtml_a1
      <td width="5" HEIGHT="15"></td>
      $srthtml_b1
    </tr>
      <tr WIDTH="105" HEIGHT="15">
        $srthtml_a
        <td width="5" HEIGHT="15">&nbsp;</td>
        $srthtml_b
      </tr>
    </tbody>
  </table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;
$pdf->SetFont('', '', 7);
if ($yg==1){
$yg=105;
}
elseif ($yg==2){
$yg=117;
}
elseif ($yg==3){
$yg=129;
}
else {
$yg=141;
}

if ($tipo=='leng'){
  $xg=60;
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

// $pdf->SetFillColor(0, 0, 0);
// $pdf->MultiCell(11.22, 10,'', 0, 'C', true, 0, 198.88, 30, 'M');
  return $pdf;
}



 function pinta_al_baja($pdf,$array_datos,$reporte_datos,$encabezado_v){
  // echo "<pre>"; print_r($array_datos); die();
  // add a page
  // $pdf->SetAutoPageBreak(TRUE, 0);
  $pdf=$this->header_footer_v($pdf,$reporte_datos,$encabezado_v);

$pdf->Image('assets/img/admiracion.png', 16,66,5, 5, '', '', '', false, 300, '', false, false, 0);
$msj = '<h2 style="font-size=300px !important; color:#919191 !important;">Alumnos que muy posiblemente han abandonado sus estudios<sup>2</sup></h2>
<table WIDTH="100mm">
      <tbody>
        <tr>
          <td  style="background-color:#e4e0df; !important; font-weight:normal !important; border:none !important;" WIDTH="10mm"></td>
          <td  style="background-color:#e4e0df; !important; font-weight:normal !important; border:none !important;" WIDTH="175mm"><font face="Montserrat-Regular" size="7" color="black">Alumnos dados de baja, que aún no han sido registrados en otra escuela de Sinaloa.<br>
Contacte inmediatamente a su padre, madre o tutor para procurar que se reintegre a la escuela con los apoyos académicos necesarios.</font></td>
          </tr>
        </tbody>
      </table>
  ';
  $html= <<<EOT
$msj
EOT;

$pdf->writeHTMLCell($w=0,$h=55,$x=12,$y=57, $html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
  $str_html='
  <style>
  table td{
    padding: 2px !important;
    border: .3px solid #BFC0C3;
    font-weight: bold;
    font-family: montserrat;
    vertical-align: middle !important;
    line-height: 15px;
  }
  table th{
    padding: 2px !important;
    text-align: center;
    border: .3px solid #BFC0C3;
    background-color:#E6E7E9;
    vertical-align: middle !important;
    line-height: 15px;
  }
  </style>
  <table width= "100%">
<tr>
<th width= "40%" HEIGHT="20">Nombre</th>
<th width= "21%" >Grado / Grupo</th>
<th width= "39%">Motivo</th>
</tr>';

  // $contador = 1;
  //
  if($array_datos[0] == 'No hay datos para mostrar'){
    $str_html .= '<tr>
    <td HEIGHT="20" colspan="3" style="color:#000000 !important;font-family: montserrat; "><font face="Montserrat" color="black"> '.$array_datos[0].'</font></td>
    </tr>';

  }else{
      foreach ($array_datos as $key => $alumno) {

      $str_html .= '<tr>
      <td HEIGHT="20" style="color:#000000 !important; font-family: montserrat;"><font face="Montserrat" color="black"> '.$alumno['nombre_alu'].'</font></td>
      <td style="text-align:center;" style="color:#000000 !important; font-family: montserrat;"><font face="Montserrat" color="black"> '.$alumno['grado'].'<sup>o</sup>'.strtoupper($alumno['grupo']).'</font></td>
      <td style="color:#000000 !important; font-family: montserrat; "><font face="Montserrat" color="black"> '.$alumno['motivo'].'</font></td>
      </tr>';
      }
}

  $str_html .= '</table>';

// $str_html = "";
$html= <<<EOT
$str_html
EOT;

$pdf->writeHTMLCell($w=0,$h=55,$x=12,$y=76, $html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

  return [
    'pdf' => $pdf
    ];
}// pinta_al_baja()

function pinta_muy_alto($pdf,$array_datos,$reporte_datos,$encabezado_v){
 // add a page
 // $pdf->SetAutoPageBreak(TRUE, 0);
 $pdf=$this->header_footer_v($pdf,$reporte_datos,$encabezado_v);


$pdf->Image('assets/img/admiracion.png', 16,66,5, 5, '', '', '', false, 300, '', false, false, 0);
$msj = '<h2 style="font-size=300px !important; color:#919191 !important;">Alumnos con alto y muy alto riesgo de abandono<sup>2</sup></h2>
<table WIDTH="104mm" HEIGHT="12mm">
      <tbody>
        <tr>
          <td  style="background-color:#e4e0df; !important; font-weight:normal !important; border:none !important;" WIDTH="10mm" HEIGHT="9.7mm"></td>
          <td  style="background-color:#e4e0df; !important; font-weight:normal !important; border:none !important;" WIDTH="176mm" HEIGHT="9.7mm"><font face="Montserrat-Regular" size="7" color="black">Por combinar inasistencias, bajas calificaciones y/o años sobre la edad ideal del grado.<br>
Cite a su padre, madre o tutor en forma inmediata para acordar acciones y asegurar su permanencia en la escuela.</font></td>
          </tr>
        </tbody>
      </table>
  ';
  $html= <<<EOT
$msj
EOT;

$pdf->writeHTMLCell($w=0,$h=55,$x=12,$y=57, $html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

 $str_html='
 <style>
 table td{
   padding: 2px !important;
   border: .3px solid #BFC0C3;
   font-weight: bold;
   font-family: montserratb;
   line-height: 10px;
 }
 table th{
   padding: 2px !important;
   text-align: center;
   border: .3px solid #BFC0C3;
   background-color:#E6E7E9;
   line-height: 10px;
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
 if($array_datos[0] == 'No hay datos para mostrar'){
  $str_html .= '<tr>
  <td HEIGHT="20" colspan="6"> <font face="Montserrat" color="black">'.$array_datos[0].'</font></td>
  </tr>';

}else{
 foreach ($array_datos as $key => $alumno) {
  if (isset($alumno['muyalto_alto'])) {
      if ($alumno['muyalto_alto'] == 'M') {
       $cuadrito='   <img src="assets/img/cuadrito-rojo.png"  height="7" padding-top="2mm" width="7" align-v="center"/>  ';
     }else if ($alumno['muyalto_alto'] == 'A') {
      $cuadrito='   <img src="assets/img/cuadrito-naranja.png"  height="7" padding-top="2mm" width="7" align-v="center"/>  ';
    }
  }else{
    $cuadrito='   <img src="assets/img/cuadrito-gris.png"  height="7" padding-top="2mm" width="7" align-v="center"/>  ';
  }
     $str_html .= '<tr>
     <td width= "55mm" style="border-left-style: none;" HEIGHT="20"><font face="Montserrat" color="black">'.$cuadrito.$alumno['nombre_alu'].'</font></td>
     <td width= "23.4mm" style="text-align:center;" > <font face="Montserrat" color="black">'.$alumno['grado'].'<sup>o</sup>'.strtoupper($alumno['grupo']).'</font></td>
     <td width= "22.18mm" style="text-align:center;"><font face="Montserrat" color="black"> '.$alumno['inasistencias'].'</font></td>
     <td width= "21.10mm" style="text-align:center;"><font face="Montserrat" color="black"> '.$alumno['asig_reprobadas'].'</font></td>
     <td width= "20.11mm" style="text-align:center;" ><font face="Montserrat" color="black"> '.$alumno['extraedad'].'</font></td>
     <td width= "44.15mm"><font face="Montserrat" color="black"> '.$alumno['nombre_madre_padre_tutor'].'</font></td>
     </tr>';
  }
}

 $str_html .= '</table>';

 // echo $str_html;die();

// $str_html = "";
$html= <<<EOT
$str_html
EOT;

$pdf->writeHTMLCell($w=0,$h=55,$x=12,$y=78, $html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

 return [
   'pdf' => $pdf
   ];
}// pinta_muy_alto()


}

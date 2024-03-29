<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
defined('BASEPATH') OR exit('No direct script access allowed');

class Generar_reporte_estatal extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('DatosEdo_model');
  }// __construct()


  function index(){
    // $datos=[];
    // array_push($datos,2);
    // array_push($datos,3);
    // array_push($datos,6);
    // for ($i=0; $i < count($datos) ; $i++) {
    //   $this->rep($datos[$i],3,"2021");
    // }

  }


  function rep($idnivel = null,$periodo = null,$ciclo = null){


    $reporte_datos=$this->DatosEdo_model->get_reporte_apa($idnivel,$periodo,$ciclo);

    if ($reporte_datos==null || $reporte_datos['idreporteapa']=='' || $reporte_datos['idreporteapa']==null) {
      echo "<h1>¡No se encontraron datos para mostrar!</h1>"; die();
    }

    $est_asis_alumnos0 = array(0 =>number_format((float) $reporte_datos['asi_est_al_1']),1 => number_format((float)$reporte_datos['asi_est_al_2']),2 => number_format((float)$reporte_datos['asi_est_al_3']),3 => number_format((float)$reporte_datos['asi_est_al_4']),4 => number_format((float)$reporte_datos['asi_est_al_5']),5 => number_format((float)$reporte_datos['asi_est_al_6']) );
    $est_asis_alumnosh1 = array(0 => number_format((float)$reporte_datos['asi_est_h1_al_1']),1 => number_format((float)$reporte_datos['asi_est_h1_al_2']),2 => number_format((float)$reporte_datos['asi_est_h1_al_3']),3 => number_format((float)$reporte_datos['asi_est_h1_al_4']),4 => number_format((float)$reporte_datos['asi_est_h1_al_5']),5 => number_format((float)$reporte_datos['asi_est_h1_al_6']));
    $est_asis_alumnosh2 = array(0 => number_format((float)$reporte_datos['asi_est_h2_al_1']),1 => number_format((float)$reporte_datos['asi_est_h2_al_2']),2 => number_format((float)$reporte_datos['asi_est_h2_al_3']),3 => number_format((float)$reporte_datos['asi_est_h2_al_4']),4 => number_format((float)$reporte_datos['asi_est_h2_al_5']),5 => number_format((float)$reporte_datos['asi_est_h2_al_6']));


    $est_asis_alumnos = array(0 => $reporte_datos['asi_est_al_1'],1 => $reporte_datos['asi_est_al_2'],2 => $reporte_datos['asi_est_al_3'],3 => $reporte_datos['asi_est_al_4'],4 => $reporte_datos['asi_est_al_5'],5 => $reporte_datos['asi_est_al_6'] );
    $est_asis_alumnos_h1 = array(0 => $reporte_datos['asi_est_h1_al_1'],1 => $reporte_datos['asi_est_h1_al_2'],2 => $reporte_datos['asi_est_h1_al_3'],3 => $reporte_datos['asi_est_h1_al_4'],4 => $reporte_datos['asi_est_h1_al_5'],5 => $reporte_datos['asi_est_h1_al_6']);
    $est_asis_alumnos_h2 = array(0 => $reporte_datos['asi_est_h2_al_1'],1 => $reporte_datos['asi_est_h2_al_2'],2 => $reporte_datos['asi_est_h2_al_3'],3 => $reporte_datos['asi_est_h2_al_4'],4 => $reporte_datos['asi_est_h2_al_5'],5 => $reporte_datos['asi_est_h2_al_6']);

    $est_asis_gr0= array(0 => number_format((float)$reporte_datos['asi_est_gr_1']),1 => number_format((float)$reporte_datos['asi_est_gr_2']),2 => number_format((float)$reporte_datos['asi_est_gr_3']),3 => number_format((float)$reporte_datos['asi_est_gr_4']),4 => number_format((float)$reporte_datos['asi_est_gr_5']),5 => number_format((float)$reporte_datos['asi_est_gr_6']),6=>number_format((float)$reporte_datos['asi_est_gruposmulti']) );

    $est_asis_gr= array(0 => $reporte_datos['asi_est_gr_1'],1 => $reporte_datos['asi_est_gr_2'],2 => $reporte_datos['asi_est_gr_3'],3 => $reporte_datos['asi_est_gr_4'],4 => $reporte_datos['asi_est_gr_5'],5 => $reporte_datos['asi_est_gr_6'],6=>$reporte_datos['asi_est_gruposmulti'] );

    $riesgo0=array(0 => number_format((float)$reporte_datos['per_riesgo_al_muy_alto']),1 => number_format((float)$reporte_datos['per_riesgo_al_alto']),2 => number_format((float)$reporte_datos['per_riesgo_al_medio']),3 => number_format((float)$reporte_datos['per_riesgo_al_bajo']) );
    $riesgo_alto0=array(0 => number_format((float)$reporte_datos['per_riesgo_al_alto_1']),1 =>number_format((float) $reporte_datos['per_riesgo_al_alto_2']),2 => number_format((float)$reporte_datos['per_riesgo_al_alto_3']),3 => number_format((float)$reporte_datos['per_riesgo_al_alto_4']),4 => number_format((float)$reporte_datos['per_riesgo_al_alto_5']),5 => number_format((float)$reporte_datos['per_riesgo_al_alto_6']) );
    $riesgo_muy_alto0=array(0 => number_format((float)$reporte_datos['per_riesgo_al_muy_alto_1']),1 => number_format((float)$reporte_datos['per_riesgo_al_muy_alto_2']),2 => number_format((float)$reporte_datos['per_riesgo_al_muy_alto_3']),3 => number_format((float)$reporte_datos['per_riesgo_al_muy_alto_4']),4 => number_format((float)$reporte_datos['per_riesgo_al_muy_alto_5']),5 => number_format((float)$reporte_datos['per_riesgo_al_muy_alto_6']) );

    $riesgo=array(0 => $reporte_datos['per_riesgo_al_muy_alto'],1 => $reporte_datos['per_riesgo_al_alto'],2 => $reporte_datos['per_riesgo_al_medio'],3 => $reporte_datos['per_riesgo_al_bajo'] );
    $riesgo_alto=array(0 => $reporte_datos['per_riesgo_al_alto_1'],1 => $reporte_datos['per_riesgo_al_alto_2'],2 => $reporte_datos['per_riesgo_al_alto_3'],3 => $reporte_datos['per_riesgo_al_alto_4'],4 => $reporte_datos['per_riesgo_al_alto_5'],5 => $reporte_datos['per_riesgo_al_alto_6'] );
    $riesgo_muy_alto=array(0 => $reporte_datos['per_riesgo_al_muy_alto_1'],1 => $reporte_datos['per_riesgo_al_muy_alto_2'],2 => $reporte_datos['per_riesgo_al_muy_alto_3'],3 => $reporte_datos['per_riesgo_al_muy_alto_4'],4 => $reporte_datos['per_riesgo_al_muy_alto_5'],5 => $reporte_datos['per_riesgo_al_muy_alto_6'] );


    $rez_ed = array(0 => number_format((float)$reporte_datos['asi_rez_pob_h']),1 => number_format((float)$reporte_datos['asi_rez_pob_m']),2 => number_format((float)$reporte_datos['asi_rez_pob_t']));
    $rez_na = array(0 => number_format((float)$reporte_datos['asi_rez_noasiste_h']),1 => number_format((float)$reporte_datos['asi_rez_noasiste_m']),2 =>number_format((float)$reporte_datos['asi_rez_noasiste_t']));
    $analfabeta = array(0 => number_format((float)$reporte_datos['asi_analfabeta_h']),1 => number_format((float)$reporte_datos['asi_analfabeta_m']),2 => number_format((float)$reporte_datos['asi_analfabeta_t']));


    $this->graf($riesgo,$est_asis_alumnos0,$est_asis_gr0,$est_asis_alumnosh1,$est_asis_alumnosh2,$est_asis_alumnos,$est_asis_gr,$est_asis_alumnos_h1,$est_asis_alumnos_h2,$rez_ed,$rez_na,$analfabeta,$riesgo_alto,$riesgo_muy_alto,$riesgo_alto0,$riesgo_muy_alto0,$riesgo0,$reporte_datos,$ciclo);



  }

  function graf($riesgo,$est_asis_alumnos0,$est_asis_gr0,$est_asis_alumnosh1,$est_asis_alumnosh2,$est_asis_alumnos,$est_asis_gr,$est_asis_alumnos_h1,$est_asis_alumnos_h2,$rez_ed,$rez_na,$analfabeta,$riesgo_alto,$riesgo_muy_alto,$riesgo_alto0,$riesgo_muy_alto0,$riesgo0,$reporte_datos,$ciclo){


    $pdf = new My_tcpdf('P', 'mm', 'LETTER', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Proyecto Educativo');
    $pdf->SetTitle('Reporte APA');
    $pdf->SetSubject('Reporte APA');

    $ciclo_tmp = ($ciclo-1)."-".$ciclo;
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
              <td WIDTH="60" HEIGHT="13"><font face="Montserrat-Regular" color="#555"></font></td>
              <td WIDTH="5" HEIGHT="13">&nbsp;</td>
              <td WIDTH="240.88" HEIGHT="13"><font face="Montserrat-Bold" color="#555">REPORTE APA DEL ESTADO DE SINALOA</font></td>
              <td WIDTH="80" HEIGHT="13"><font face="Montserrat-Regular" color="#555">Ciclo escolar:</font></td>
              <td WIDTH="142" HEIGHT="13"><font face="Montserrat-Bold" color="#555">$ciclo_tmp</font></td>
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
    $p1->SetGuideLines();

    $p1->SetSliceColors(array('#cd1719','#ee7521','#ffed00','#dadada'));

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
    if ($reporte_datos['encabezado_n_nivel']=='SECUNDARIA'|| $reporte_datos['encabezado_n_nivel']=='secundaria'){
      $data1y= array_slice($est_asis_alumnos_h1, 0, 3);
      $data2y= array_slice($est_asis_alumnos_h2, 0, 3);
      $data3y= array_slice($est_asis_alumnos, 0, 3);
    }
    else {
      $data1y=$est_asis_alumnos_h1;
      $data2y=$est_asis_alumnos_h2;
      $data3y=$est_asis_alumnos;

    }

    $graph = new Graph(350,200,'auto');
    $graph->SetScale("textlin");
    $theme_class=new UniversalTheme;
    $graph->SetTheme($theme_class);
    $graph->SetBackgroundImage("assets/img/background.jpg",BGIMG_FILLFRAME);

    $graph->SetBox(false);
    $graph->ygrid->SetFill(false);
    if ($reporte_datos['encabezado_n_nivel']=='SECUNDARIA'|| $reporte_datos['encabezado_n_nivel']=='secundaria'){
      $graph->xaxis->SetTickLabels(array('1°','2°','3°'));
    }
    else {
      $graph->xaxis->SetTickLabels(array('1°','2°','3°','4°','5°','6°'));
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
    $pdf->Image('barras.png', 12.6,128,90, 40, 'PNG', '', '', false, 300, '', false, false, 0);
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

    if ($reporte_datos['encabezado_n_nivel']=='SECUNDARIA'|| $reporte_datos['encabezado_n_nivel']=='secundaria'){
      $data1y= array_slice($riesgo_alto, 0, 3);
      $data2y= array_slice($riesgo_muy_alto, 0, 3);
    }
    else {
      $data1y=$riesgo_alto;
      $data2y=$riesgo_muy_alto;

    }


    $style = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(192, 192, 192));
    $pdf->Line(110, 157, 195, 157, $style);

    $graph1 = new Graph(350,200,'auto');
    $graph1->SetScale("textlin");
    $theme_class=new UniversalTheme;
    $graph1->SetTheme($theme_class);

    $graph1->SetBackgroundImage("assets/img/background.jpg",BGIMG_FILLFRAME);

    $graph1->SetBox(false);
    $graph1->ygrid->SetFill(false);
    // $graph1->xaxis->Hide();
    if ($reporte_datos['encabezado_n_nivel']=='SECUNDARIA'|| $reporte_datos['encabezado_n_nivel']=='secundaria'){
      $graph1->xaxis->SetTickLabels(array('1°','2°','3°'));
    }
    else {

      $graph1->xaxis->SetTickLabels(array('1°','2°','3°','4°','5°','6°'));
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
    $pdf->Image('barras1.png', 107,165,75,39, 'PNG', '', '', false, 300, '', false, false, 0);
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
          <td  style="line-height: 200%" WIDTH="500">El propósito de este reporte es aportar información que ayude a tomar decisiones a las autoridades para asegurar la asistencia, permanencia y aprendizaje de todos
            los estudiantes del estado. Se sugiere ampliamente que cada nivel educativo lo analice y actúe según lo juzgue necesario.</td>
          </tr>
        </tbody>
      </table>
EOT;

$html3 = <<<EOT
		$str_htm3
EOT;

$pdf->writeHTMLCell($w=120,$h=55,$x=11.59,$y=50, $html3, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$pdf->Image('assets/img/admiracion.png', 14,52.8,5, 5, '', '', '', false, 300, '', false, false, 0);


$pdf->SetFillColor(0, 0, 127);

$pdf->SetFont('montserratb', '', 13);
// set some text for example
$txt = 'ASISTENCIA';
$txt1 = 'PERMANENCIA';



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


//pinta el fondo de color de las 2 columnas de la 1ra y segunda hoja
$pdf->SetFillColor(239, 239, 239);
$pdf->MultiCell(92.80, 194,'', 0, 'C', 1, 0, 11.59, 84.57, true);
$pdf->MultiCell(90.75, 194,'', 0, 'C', 1, 0, 106.63, 84.57, true);

$pdf->SetTextColor(0, 0, 0);

$asi_est_al_t=number_format((float)$reporte_datos['asi_est_al_t']);
$asi_est_gr_t=number_format((float)$reporte_datos['asi_est_gr_t']);
$asi_est_doc=number_format((float)$reporte_datos['asi_est_do_t']);
$pdf->SetFont('montserrat', '', 8);
if ($reporte_datos['encabezado_n_nivel']=='SECUNDARIA'|| $reporte_datos['encabezado_n_nivel']=='secundaria'){
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
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:6; color:#545452;">$asi_est_al_t</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_alumnos0[0]</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_alumnos0[1]</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_alumnos0[2]</td>
        <td width="22mm" style="text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;"></td>
      </tr>
      <tr>
        <td width="20mm" style="background-color:#e4e4e2; font-family:Montserrat-Regular; font-size:7; color:#545452;">Grupos</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:6; color:#545452;">$asi_est_gr_t</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_gr0[0]</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:6;color:#545452;">$est_asis_gr0[1]</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  font-family:Montserrat-Bold; font-size:6;color:#545452;">$est_asis_gr0[2]</td>
        <td width="22mm" style="text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452; background-color:#ffffff;">$est_asis_gr0[6]</td>
      </tr>
      <tr>
        <td width="20mm" style="background-color:#e4e4e2; font-family:Montserrat-Regular; font-size:7; color:#545452;">Docentes</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;  color:#545452; font-family:Montserrat-Bold; font-size:6;">$asi_est_doc</td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;"></td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;"></td>
        <td width="12mm" style="text-align:center; background-color:#ffffff;"></td>
        <td width="22mm"></td>

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
        <td width="9.40mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$asi_est_al_t</td>
        <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_alumnos0[0]</td>
        <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_alumnos0[1]</td>
        <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_alumnos0[2]</td>
        <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_alumnos0[3]</td>
        <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_alumnos0[4]</td>
        <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_alumnos0[5]</td>
        <td width="11.40mm" style="background-color:#E2E4E4; text-align:center;"></td>
      </tr>
      <tr height="5.27mm">
        <td  width="15mm" style="background-color:#e4e4e2; font-family:Montserrat-Regular; font-size:7;">Grupos</td>
        <td width="9.40mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$asi_est_gr_t</td>
        <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_gr0[0]</td>
        <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_gr0[1]</td>
        <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_gr0[2]</td>
        <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_gr0[3]</td>
        <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_gr0[4]</td>
        <td  width="9.03mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$est_asis_gr0[5]</td>
        <td width="11.40mm" style="background-color:#ffffff; text-align:center; color:#545452; font-family:Montserrat-Bold; font-size:6;">$est_asis_gr0[6]</td>
      </tr>
      <tr height="5.27mm">
        <td  width="15mm" style="background-color:#e4e4e2; font-family:Montserrat-Regular; font-size:7;">Docentes</td>
        <td  width="9.40mm"style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:6; color:#545452;">$asi_est_doc</td>
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
$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=90,$h=23.12,$x=12,$y=95, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$ti_ciclo_ac=$reporte_datos['asi_est_h1_ciclo'];
$ti_ciclo_h1=$reporte_datos['asi_est_h2_ciclo'];
$ti_ciclo_h2=$reporte_datos['asi_est_ac_ciclo'];
$tot_ciclo_h1=number_format((float)$reporte_datos['asi_est_h1_gr_t']);
$tot_ciclo_h2=number_format((float)$reporte_datos['asi_est_h2_gr_t']);




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
      <td width="18.02mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452; background-color:#ffffff;">$tot_ciclo_h2</td>
      <td width="18.02mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452; background-color:#ffffff;">$tot_ciclo_h1</td>
      <td width="18.02mm" style="text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452; background-color:#ffffff;">$asi_est_al_t</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=82.28,$h=16,$x=15,$y=169, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$anios_asis=$reporte_datos['asi_rez_gedad_noasiste'];

$pdf->Line(12.6, 178, 103, 178,array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'phase' => 10, 'color' => array(206,206,206)));

$pdf->SetFont('montserratb', '', 11);
$pdf->SetTextColor(145, 145, 145);
$pdf->MultiCell(75, 8,"Rezago educativo del Estado", 0, 'L', 0, 0, 20, 182, 'M');
$pdf->SetFont('montserrat', '', 9);
$pdf->MultiCell(5, 5,"3", 0, 'L', 0, 0, 87, 182, 'M');


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

$pdf->writeHTMLCell($w=90,$h=30,$x=12,$y=190, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

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

$pdf->writeHTMLCell($w=90,$h=22.95,$x=12.1,$y=220, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

// $pdf->SetFont('montserratmedium','','9');
// $pdf->SetTextColor(98,87,85);
// $pdf->MultiCell(80, 10,'Lengua nativa: '.$reporte_datos['asi_lenguas_nativas'], 0, 'L', 1, 0, 23, 247, 'M');
//
// $pdf->SetFont('montserratmedium','','7');
// $pdf->SetTextColor(98,87,85);
// $pdf->MultiCell(5, 5,'4', 0, 'L', 1, 0, 60, 247, 'M');

$rit=number_format((float)$reporte_datos['per_riesgo_al_t']);
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
      <td width="15mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo0[0]</td>
      <td width="3.53mm" style="background-color:#ee7521;"></td>
      <td width="15mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo0[1]</td>
      <td width="3.53mm" style="background-color:#ffed00;"></td>
      <td width="15mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo0[2]</td>
      <td width="3.53mm" style="background-color:#dadada;"></td>
      <td width="15mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo0[3]</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=81,$h=30,$x=107,$y=146, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

if ($reporte_datos['encabezado_n_nivel']=='SECUNDARIA'|| $reporte_datos['encabezado_n_nivel']=='secundaria'){
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
        <td width="18.74mm" style="background-color:#ffffff; text-align:center; color:#545452;">$riesgo_alto0[0]</td>
        <td width="18.74mm" style="background-color:#ffffff; text-align:center; color:#545452;">$riesgo_alto0[1]</td>
        <td width="18.74mm" style="background-color:#ffffff; text-align:center; color:#545452;">$riesgo_alto0[2]</td>
      </tr>
      <tr>
        <td width="6.02mm" style="background-color:#D1232A;">&nbsp;</td>
        <td width="18.74mm" style="background-color:#DCDDDF; color:#545452;">Muy alto</td>
        <td width="18.74mm" style="background-color:#ffffff; text-align:center; color:#545452;">$riesgo_muy_alto0[0]</td>
        <td width="18.74mm" style="background-color:#ffffff; text-align:center; color:#545452;">$riesgo_muy_alto0[1]</td>
        <td width="18.74mm" style="background-color:#ffffff; text-align:center; color:#545452;">$riesgo_muy_alto0[2]</td>
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
        <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_alto0[0]</td>
        <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_alto0[1]</td>
        <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_alto0[2]</td>
        <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_alto0[3]</td>
        <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_alto0[4]</td>
        <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_alto0[5]</td>
      </tr>
      <tr>
        <td width="6.02mm" style="background-color:#D1232A;">&nbsp;</td>
        <td width="21.8mm" style="background-color:#DCDDDF; text-align:center; font-family:Montserrat-Regular; font-size:7; color:#545452;">Muy alto</td>
        <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_muy_alto0[0]</td>
        <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_muy_alto0[1]</td>
        <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_muy_alto0[2]</td>
        <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_muy_alto0[3]</td>
        <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_muy_alto0[4]</td>
        <td width="9.52mm" style="background-color:#ffffff; text-align:center; font-family:Montserrat-Bold; font-size:7; color:#545452;">$riesgo_muy_alto0[5]</td>
      </tr>
    </tbody>
  </table>
EOT;
}
$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=81,$h=30,$x=107,$y=205, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);


  $retencion=$reporte_datos['per_ind_retencion']." %";


  $aprobacion=$reporte_datos['per_ind_aprobacion']." %";

  $efic_ter=$reporte_datos['per_ind_et']." %";
  $inegi_ciclo = $reporte_datos['asi_anio_inegi'];



// $style = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(192, 192, 192));
// $pdf->Line(110, 217, 195, 217, $style);
// $pdf->SetFont('montserratb', '', 11);
// $pdf->SetTextColor(145, 145, 145);
// $pdf->MultiCell(65, 8,"Indicadores de permanencia", 0, 'L', 0, 0, 115, 220, 'M');
// $pdf->SetFont('montserrat', '', 9);
// $pdf->MultiCell(5, 5,"1", 0, 'L', 0, 0, 173, 220, 'M');
// $pdf->SetFont('montserratb', '', 10);
// $pdf->MultiCell(100, 7,"Inicio de ciclo escolar ".$reporte_datos['per_ind_ciclo'], 0, 'L', 0, 0, 115, 225, 'M');

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

// $pdf->writeHTMLCell($w=81.46,$h=10.71,$x=110,$y=230, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$pdf->Image('assets/img/escuela_icon.png', 13,88,5, 5, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/mat_his.png', 13,120,5, 5, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/porcen_asis.png', 13,182,4, 6, '', '', '', false, 300, '', false, false, 0);
// $pdf->Image('assets/img/lenguas_icon.png', 13,247,6, 5, '', '', '', false, 300, '', false, false, 0);

$pdf->Image('assets/img/alu_riesgo_icon.png', 109,88,3, 5, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/dist_grado_icon.png', 110,161,6, 4, '', '', '', false, 300, '', false, false, 0);
// $pdf->Image('assets/img/indic_icon.png', 110,220,7, 5, '', '', '', false, 300, '', false, false, 0);

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
      <td width="80mm" style="font-family:Montserrat-Bold; font-size:7; color:#000;"><sup>3</sup> INEGI, Censo de Población y Vivienda {$inegi_ciclo}.</td>
    </tr>
  </tbody>
</table>
EOT;

$html5fuente = <<<EOT
$fuente
EOT;
$pdf->writeHTMLCell($w=80,$h=20,$x=110,$y=240, $html5fuente, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

///TERMINA PRIMERA PÁGINA

/// INICIA SEGUNDA PÄGINA
// echo "<pre>";print_r($reporte_datos['encabezado_n_nivel']);die();
if ($reporte_datos['encabezado_n_nivel']!='ESPECIAL'){
$txt2 = 'APRENDIZAJE';
$pdf=$this->header_footer_v($pdf,$reporte_datos,$encabezado_v);
$pdf->SetFont('montserratb', 'B', 13);
$pdf->SetFillColor(0, 173, 234);
$pdf->SetTextColor(255, 255, 255);
$pdf->MultiCell(186.3, 3.4,"", 0, 'C', 1, 0, 12.6, 58, true);
$pdf->MultiCell(186.3, 3.4,$txt2, 0, 'C', 1, 0, 12.6, 61.4, true);
$pdf->MultiCell(186.3, 3.4,"", 0, 'C', 1, 0, 12.6, 64.8, true);


$style = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(192, 192, 192));
$pdf->Line(18, 89, 193, 89, $style);

$pdf->Image('assets/img/planea_icon.png', 16,92,5, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->SetFont('montserratb', '', 11);
$pdf->SetTextColor(145, 145, 145);
$pdf->MultiCell(65, 8,"Resultados PLANEA ", 0, 'L', 0, 0, 22, 92, 'M');
$style = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(192, 192, 192));
$pdf->Line(108.89, 98, 108.89, 130, $style);


$pdf->SetFont('montserratextraboldi', '', 11);
$pdf->SetTextColor(75, 74, 72);
$pdf->SetFillColor(255, 255, 255);
$pdf->MultiCell(70, 10,'Lenguaje y Comunicación', 0, 'L', 1, 0, 37, 98, 'M');
$pdf->MultiCell(50, 10,'Matemáticas', 0, 'L', 1, 0, 130, 98, 'M');

$pdf->SetTextColor(85, 85, 85);
$pdf->SetFillColor(255, 255, 255);


$pdf->Image('assets/img/esta_icon.png', 26,109,6, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->MultiCell(50, 10,'Estado '.$reporte_datos['apr_planea_nlogro_estado_periodo'], 0, 'L', 1, 0, 32, 111, 'M');
$pdf->Image('assets/img/pais_icon.png', 26,121,6, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->MultiCell(50, 10,'País '.$reporte_datos['apr_planea_nlogro_pais_periodo'], 0, 'L', 1, 0, 32, 123, 'M');



$tipo='leng';
$pdf = $this->planea_graf($pdf,$reporte_datos['apr_planea_nlogro_estado_lyc_i'],$reporte_datos['apr_planea_nlogro_estado_lyc_ii-iii-iv'],1,$tipo);
$pdf = $this->planea_graf($pdf,$reporte_datos['apr_planea_nlogro_pais_lyc_i'],$reporte_datos['apr_planea_nlogro_pais_lyc_ii-iii-iv'],2,$tipo);

$tipo='mat';
$pdf = $this->planea_graf($pdf,$reporte_datos['apr_planea_nlogro_estado_mat_i'],$reporte_datos['apr_planea_nlogro_estado_mat_ii-iii-iv'],1,$tipo);
$pdf = $this->planea_graf($pdf,$reporte_datos['apr_planea_nlogro_pais_mat_i'],$reporte_datos['apr_planea_nlogro_pais_mat_ii-iii-iv'],2,$tipo);



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
  0 => ($reporte_datos['apr_planea_nlogro_estado_lyc_i'] == '' ) ? 0 :$reporte_datos['apr_planea_nlogro_estado_lyc_i'] ,
  1 => ($reporte_datos['apr_planea_nlogro_estado_lyc_ii'] == '' ) ? 0 :$reporte_datos['apr_planea_nlogro_estado_lyc_ii'] ,
  2 => ($reporte_datos['apr_planea_nlogro_estado_lyc_iii'] == '' ) ? 0 :$reporte_datos['apr_planea_nlogro_estado_lyc_iii'] ,
  3 => ($reporte_datos['apr_planea_nlogro_estado_lyc_iv'] == '' ) ? 0 :$reporte_datos['apr_planea_nlogro_estado_lyc_iv']  );
$planea_aprov_mat=array(
  0 => ($reporte_datos['apr_planea_nlogro_estado_mat_i'] == '' ) ? 0 :$reporte_datos['apr_planea_nlogro_estado_mat_i'] ,
  1 => ($reporte_datos['apr_planea_nlogro_estado_mat_ii'] == '' ) ? 0 :$reporte_datos['apr_planea_nlogro_estado_mat_ii'] ,
  2 => ($reporte_datos['apr_planea_nlogro_estado_mat_iii'] == '' ) ? 0 :$reporte_datos['apr_planea_nlogro_estado_mat_iii'] ,
  3 => ($reporte_datos['apr_planea_nlogro_estado_mat_iv'] == '' ) ? 0 :$reporte_datos['apr_planea_nlogro_estado_mat_iv']  );

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
// echo "<pre>";
// print_r($prom_cal_esp);
// print_r($planea_aprov_esp);
// die();

$x=0;
for ($i=0; $i < count($prom_cal_esp); $i++) {
  if($prom_cal_esp[$i]==0){
    $x=$x+1;
  }
}


$x1=0;
for ($i=0; $i < count($planea_aprov_esp); $i++) {
  if($planea_aprov_esp[$i]==0){
    $x1=$x1+1;
  }
}

// echo $x1."\n".$x."\n";

if($x1<4 || $x<4){

$data1y=$prom_cal_esp;
$data2y=$planea_aprov_esp;
$data3y=array(0,0,0,0,0,0);
$graph = new Graph(350,200,'auto');
$graph->SetScale("textlin");
$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);
$vector100 = array(10, 20, 30, 40, 50, 60, 70, 80, 90, 100);
$graph->yaxis->SetTickPositions($vector100, $vect_esp);
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

$pdf->Image('barras2.png', 10,145,80, 40, 'PNG', '', '', false, 300, '', false, false, 0);

unlink('barras2.png');
}
/////Termina gráfica español

// print_r($prom_cal_mat);
// print_r($planea_aprov_mat);
// die();
$x2=0;
for ($i=0; $i < count($prom_cal_mat); $i++) {
  if($prom_cal_mat[$i]==0){
    $x2=$x2+1;
  }
}


$x3=0;
for ($i=0; $i < count($planea_aprov_mat); $i++) {
  if($planea_aprov_mat[$i]==0){
    $x3=$x3+1;
  }
}

// echo $x3."\n".$x2."\n";
// die();
if($x3<4 || $x2<4){

/////Inicia gráfica mate
$data1y=$prom_cal_mat;
$data2y=$planea_aprov_mat;
$data3y=array(0,0,0,0,0,0);
$graph = new Graph(350,200,'auto');
$graph->SetScale("textlin");
$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);
$graph->yaxis->SetTickPositions($vector100, $vect_mat);
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

$pdf->Image('barras3.png', 110,145,80, 40, 'PNG', '', '', false, 300, '', false, false, 0);

$pdf->SetFont('montserratb', 'B', 11);
$pdf->SetTextColor(75, 74, 72);
$pdf->SetFillColor(255, 255, 255);
$pdf->MultiCell(170, 10,'Comparativo entre resultados de PLANEA Estatal y aprovechamiento escolar', 0, 'L', 1, 0, 35, 140, 'M');
$style = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(192, 192, 192));
$pdf->Line(108.89, 150, 108.89, 190, $style);
unlink('barras3.png');
}
/////Termina gráfica mate

$pdf->SetFont('montserratb', 'B', 7);

$planea_ciclo=$reporte_datos['apr_planea_nlogro_estado_periodo'];
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
$pdf->writeHTMLCell($w=60,$h=30,$x=65,$y=200, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

///Contenidos temáticos
$pdf->Image('assets/img/cont_tem_icon.png', 16,210,6, 6, '', '', '', false, 300, '', false, false, 0);
$pdf->SetFont('montserratb', '', 11);
$pdf->SetTextColor(145, 145, 145);
$pdf->MultiCell(165, 8,"Contenidos temáticos con menor porcentaje de aciertos en el estado", 0, 'L', 0, 0, 22, 210, 'M');
$style = array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(192, 192, 192));
$pdf->Line(108.89, 220, 108.89, 255, $style);
$pdf->SetFont('montserratb', '', 7);
$pdf->SetTextColor(0, 0, 0);
$cont_tem_lyc = array(0 => array('txt' => $reporte_datos['apr_planea1_ct_lyc_1txt'] ,'por' => $reporte_datos['apr_planea1_ct_lyc_1por']), 1 => array('txt' => $reporte_datos['apr_planea1_ct_lyc_2txt'] ,'por' => $reporte_datos['apr_planea1_ct_lyc_2por']), 2 => array('txt' => $reporte_datos['apr_planea1_ct_lyc_3txt'] ,'por' => $reporte_datos['apr_planea1_ct_lyc_3por']), 3 => array('txt' => $reporte_datos['apr_planea1_ct_lyc_4txt'],'por' => $reporte_datos['apr_planea1_ct_lyc_4por']), 4 => array('txt' => $reporte_datos['apr_planea1_ct_lyc_5txt'],'por' => $reporte_datos['apr_planea1_ct_lyc_5por']));
$cont_tem_mat= array(0 => array('txt' => $reporte_datos['apr_planea1_ct_mat_1txt'] ,'por' => $reporte_datos['apr_planea1_ct_mat_1por']), 1 => array('txt' => $reporte_datos['apr_planea1_ct_mat_2txt'] ,'por' => $reporte_datos['apr_planea1_ct_mat_2por']), 2 => array('txt' => $reporte_datos['apr_planea1_ct_mat_3txt'] ,'por' => $reporte_datos['apr_planea1_ct_mat_3por']), 3 => array('txt' => $reporte_datos['apr_planea1_ct_mat_4txt'],'por' => $reporte_datos['apr_planea1_ct_mat_4por']), 4 => array('txt' => $reporte_datos['apr_planea1_ct_mat_5txt'],'por' => $reporte_datos['apr_planea1_ct_mat_5por']));


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
$pdf->writeHTMLCell($w=70,$h=30,$x=16,$y=220, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

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
$pdf->writeHTMLCell($w=70,$h=30,$x=111,$y=220, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);


}
///Termina contenidos temáticos

/// INICIA TERCERA PÄGINA
// $pdf=$this->header_footer_h($pdf,$reporte_datos,$encabezado_h);
$idreporte=$reporte_datos['idreporteapa'];

/// Termina TERCERA PÄGINA

/// INICIA Cuarta PÄGINA

// $ids=explode(",", $idreporte);
// echo "<pre>";
// print_r($ids);
// die();
// for ($i=0; $i <count($ids) ; $i++) {

$alumnos_mar=$this->DatosEdo_model->get_alumnos_mar(trim($idreporte,','));
// echo "<pre>";
// print_r($alumnos_mar); die();
  if($alumnos_mar == null){
    array_push($alumnos_mar,'No hay datos para mostrar');
  }else{
    $array_items = array_chunk($alumnos_mar,20);
    foreach ($array_items as $key => $item) {
      $array_return =  $this->pinta_muy_alto($pdf, $item);
      $pdf = $array_return['pdf'];
    }
  }
// }
// die();


// $pdf=$this->header_footer_h($pdf,$reporte_datos,$encabezado_h);
/// Termina Cuarta PÄGINA


$pdf->Output('Reporte_APA_Sinaloa_Estatal_'.$reporte_datos['encabezado_n_nivel'].'.pdf', 'I');
  // $ruta=$_SERVER["DOCUMENT_ROOT"]."/reporte_apa/application/libraries/2021/Estatal/";
  // $archivom = "REPORTE_ESTATAL_".$reporte_datos['encabezado_n_nivel']."_P3".".pdf";
  // $pdf->Output($ruta.$archivom,'F');
  //   flush();


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

  $pdf->AddPage('P', 'LETTER');
  $pdf->Image('assets/img/encabezado.png', 0,0,217, 35, '', '', '', false, 300, '', false, false, 0);
  $pdf->Image('assets/img/pie.png', 0,262,210, 15, '', '', '', false, 300, '', false, false, 0);
  $pdf->SetAutoPageBreak(FALSE, 0);
  $pdf->SetFillColor(129, 113, 106);
  $pdf->SetFont('montserratb', '', 12);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->MultiCell(35, 10,$reporte_datos['encabezado_n_nivel'], 0, 'C', false, 0, 170, 24, 'M');
  $pdf->SetFont('montserratb', '', 10);
  // $pdf->SetTextColor(80, 76, 75);
  $pdf->SetTextColor(150, 146, 143);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->MultiCell(50, 10,$reporte_datos['encabezado_n_periodo'].' PERIODO', 0, 'R', false, 0, 150, 30, 'M');

  $pdf->SetFont('', '', 8);

  $pdf->writeHTMLCell($w=120,$h=55,$x=11.59,$y=36.78, $encabezado_v, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=false);
  return $pdf;
}



 function pinta_al_baja($pdf,$array_datos,$reporte_datos,$encabezado_v){


  $pdf=$this->header_footer_v($pdf,$reporte_datos,$encabezado_v);


$pdf->Image('assets/img/admiracion.png', 16,66,5, 5, '', '', '', false, 300, '', false, false, 0);
$msj = '<h2 style="font-size=300px !important; color:#919191 !important;">Alumnos que muy posiblemente han abandonado sus estudios<sup>2</sup></h2>
<table WIDTH="100mm">
      <tbody>
        <tr>
          <td  style="background-color:#e4e0df; !important; font-weight:normal !important; border:none !important;" WIDTH="10mm"></td>
          <td  style="background-color:#e4e0df; !important; font-weight:normal !important; border:none !important;" WIDTH="175mm"><font face="Montserrat-Regular" size="7" color="black">Alumnos dados de baja, que aún no han sido registrados en otra escuela de Sinaloa.<br>
Se recomienda acordar acciones en lo inmediato para asegurar su continuidad en la escuela.</font></td>
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
<th width= "36%">Motivo</th>
</tr>';

  // $contador = 1;
  //
  // $escuela=$array_datos[0][''];
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

function pinta_muy_alto($pdf,$array_datos){

 // $pdf=$this->header_footer_v($pdf,$reporte_datos,$encabezado_v);
  $pdf->SetFont('', '', 10);
  $pdf->SetAutoPageBreak(TRUE, 0);

  $pdf->AddPage('P', 'LETTER');
  $pdf->Image('assets/img/encabezado.png', 0,0,217, 35, '', '', '', false, 300, '', false, false, 0);
  $pdf->Image('assets/img/pie.png', 0,262,210, 15, '', '', '', false, 300, '', false, false, 0);
  $pdf->SetAutoPageBreak(FALSE, 0);
  $pdf->SetFillColor(129, 113, 106);
  $pdf->SetFont('montserratb', '', 12);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->MultiCell(35, 10,$array_datos[0]['encabezado_n_nivel'], 0, 'C', false, 0, 170, 24, 'M');
  $pdf->SetFont('montserratb', '', 10);
  // $pdf->SetTextColor(80, 76, 75);
  $pdf->SetTextColor(150, 146, 143);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->MultiCell(50, 10,$array_datos[0]['encabezado_n_periodo'].' PERIODO', 0, 'R', false, 0, 150, 30, 'M');


$pdf->Image('assets/img/admiracion.png', 16,47,5, 5, '', '', '', false, 300, '', false, false, 0);
$msj = '<h2 style="font-size=300px !important; color:#919191 !important;">Alumnos con alto y muy alto riesgo de abandono<sup>2</sup></h2>
<table WIDTH="104mm" HEIGHT="12mm">
      <tbody>
        <tr>
          <td  style="background-color:#e4e0df; !important; font-weight:normal !important; border:none !important;" WIDTH="10mm" HEIGHT="9.7mm"></td>
          <td  style="background-color:#e4e0df; !important; font-weight:normal !important; border:none !important;" WIDTH="176mm" HEIGHT="9.7mm"><font face="Montserrat-Regular" size="7" color="black">Para identificar a los alumnos en riesgo se consideró especialmente a quienes no han tenido comunicación y participación sostenida en las
actividades académicas, así como a quienes obtuvieron muy bajas calificaciones durante este período de evaluación.</font></td>
          </tr>
        </tbody>
      </table>
  ';
  $html= <<<EOT
$msj
EOT;

$pdf->writeHTMLCell($w=0,$h=55,$x=12,$y=37, $html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);



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
<th width= "55mm" HEIGHT="20" rowspan="2">Municipio</th>
<th width= "23.4mm" rowspan="2">Total de escuelas</th>
<th width= "20.18mm" rowspan="2">Total de alumno</th>
<th width="64.15mm" colspan="3">Alumnos en riesgo de abandono</th>
<th width= "23.22mm" rowspan="2">% de alto y muy alto riesgo de abandono</th>
</tr>
<tr>
<th width= "21.38mm">Alto</th>
<th width= "21.38mm">Muy alto</th>
<th width= "21.38mm">Total</th>
</tr>
';


 if($array_datos[0] == 'No hay datos para mostrar'){
  $str_html .= '<tr>
  <td HEIGHT="20" colspan="6"> <font face="Montserrat" color="black">'.$array_datos[0].'</font></td>
  </tr>';

}else{
  // print_r($array_datos); die();

 foreach ($array_datos as $key => $alumno) {

    $total_escuelas=number_format($alumno['total_escuelas']);
    $total_alumnos=number_format($alumno['total_alumnos']);
    $total_alto=number_format($alumno['total_alto']);
    $total_muy_alto=number_format($alumno['total_muy_alto']);
    $total_alto_riesgo=number_format($alumno['total_alto_riesgo']);
     $str_html .= '<tr>
     <td width= "55mm" style="border-left-style: none; text-align:center;" HEIGHT="20"><font face="Montserrat" color="black">'.$alumno['municipio'].'</font></td>
     <td width= "23.4mm" style="text-align:center;" > <font face="Montserrat" color="black">'.$total_escuelas.'</font></td>
     <td width= "20.18mm" style="text-align:center;"><font face="Montserrat" color="black"> '.$total_alumnos.'</font></td>
     <td width= "21.38mm"><font face="Montserrat" color="black"> '.$total_alto.'</font></td>
      <td width= "21.38mm"><font face="Montserrat" color="black"> '.$total_muy_alto.'</font></td>
      <td width= "21.38mm"><font face="Montserrat" color="black"> '.$total_alto_riesgo.'</font></td>
      <td width= "23.22mm" style="text-align:center;"><font face="Montserrat" color="black"> '.$alumno['porcentaje'].'</font></td>
     </tr>';
  }
}

 $str_html .= '</table>';


$html= <<<EOT
$str_html
EOT;

$pdf->writeHTMLCell($w=0,$h=55,$x=12,$y=58, $html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

 return [
   'pdf' => $pdf
   ];
}// pinta_muy_alto()

}

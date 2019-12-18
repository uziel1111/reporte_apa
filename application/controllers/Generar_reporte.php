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
    // , 'ciclo' => $reporte_datos['asi_est_h1_ciclo'], 'total' => $reporte_datos['asi_est_h1_gr_t']
    $est_asis_alumnos_h2 = array(0 => $reporte_datos['asi_est_h2_al_1'],1 => $reporte_datos['asi_est_h2_al_2'],2 => $reporte_datos['asi_est_h2_al_3'],3 => $reporte_datos['asi_est_h2_al_4'],4 => $reporte_datos['asi_est_h2_al_5'],5 => $reporte_datos['asi_est_h2_al_6']);
    // , 'ciclo' => $reporte_datos['asi_est_h2_ciclo'], 'total' => $reporte_datos['asi_est_h1_gr_t']

    $est_asis_gr= array(0 => $reporte_datos['asi_est_gr_1'],1 => $reporte_datos['asi_est_gr_2'],2 => $reporte_datos['asi_est_gr_3'],3 => $reporte_datos['asi_est_gr_4'],4 => $reporte_datos['asi_est_gr_5'],5 => $reporte_datos['asi_est_gr_6'] );

    $riesgo=array(0 => $reporte_datos['per_riesgo_al_muy_alto'],1 => $reporte_datos['per_riesgo_al_alto'],2 => $reporte_datos['per_riesgo_al_medio'],3 => $reporte_datos['per_riesgo_al_bajo'] );
    // echo '<pre>';print_r($reporte_datos);die();
    $this->graf($riesgo,$historico,$distribucion,$planea_aprov,$array_datos_escuela,$est_asis_alumnos,$est_asis_gr,$est_asis_alumnos_h1,$est_asis_alumnos_h2,$reporte_datos);
  }

  function graf($riesgo,$historico,$distribucion,$planea_aprov,$array_datos_escuela,$est_asis_alumnos,$est_asis_gr,$est_asis_alumnos_h1,$est_asis_alumnos_h2,$reporte_datos){
    // echo "<pre>";print_r($array_datos_escuela);die();

    //// Parámetros iniciales para PDF///
    $nombre=$array_datos_escuela['nombre'];
    $cct=$array_datos_escuela['cct'];
    $director=$array_datos_escuela['director'];
    $turno=$array_datos_escuela['turno'];
    $municipio=$array_datos_escuela['municipio'];
    $modalidad=$array_datos_escuela['modalidad'];


    $pdf = new My_tcpdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('TCPDF Example 031');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    ///Se agrega el header y footer
    $pdf->SetAutoPageBreak(TRUE, 0);
    $pdf->AddPage('P', 'A4');
    $pdf->Image('assets/img/encabezado.png', 0,0,210, 35, '', '', '', false, 300, '', false, false, 0);
    $pdf->Image('assets/img/pie.png', 0,282,210, 15, '', '', '', false, 300, '', false, false, 0);
    $pdf->SetAutoPageBreak(FALSE, 0);
    $pdf->SetFillColor(129, 113, 106);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->MultiCell(30, 10,$reporte_datos['encabezado_n_nivel'], 0, 'R', 1, 0, 170, 18, 'M');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->MultiCell(50, 10,$reporte_datos['encabezado_n_periodo'].' PERIODO', 0, 'R', 1, 0, 150, 28, 'M');

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
    $pdf->Image('pastel.png', 125,80,55, 39, 'png', '', '', false, 300, '', false, false, 0);
    unlink('pastel.png');
    ///Termina creación de grafica de pastel

    ///Empieza creación de grafica de barras MATRICULA
    $data1y=$est_asis_alumnos;
    $data2y=$est_asis_alumnos_h1;
    $data3y=$est_asis_alumnos_h2;
    $graph = new Graph(350,200,'auto');
    $graph->SetScale("textlin");
    $theme_class=new UniversalTheme;
    $graph->SetTheme($theme_class);
    $graph->SetBackgroundImage("assets/img/background.jpg",BGIMG_FILLFRAME);
    $graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
    $graph->SetBox(false);
    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels(array('1','2','3','4','5','6'));
    $graph->yaxis->HideLine(false);
    $graph->yaxis->HideTicks(false,false);
    $b1plot = new BarPlot($data1y);
    $b2plot = new BarPlot($data2y);
    $b3plot = new BarPlot($data3y);
    $gbplot = new GroupBarPlot(array($b1plot,$b2plot,$b3plot));
    $graph->Add($gbplot);
    $b1plot->SetColor("white");
    $b1plot->SetFillColor("#9E2E17");
    $b2plot->SetColor("white");
    $b2plot->SetFillColor("#939598");
    $b3plot->SetColor("white");
    $b3plot->SetFillColor("#399443");
    $graph->Stroke('barras.png');
    $pdf->Image('barras.png', 20,110,80, 50, 'PNG', '', '', false, 300, '', false, false, 0);
    unlink('barras.png');
    ///Termina creación de grafica de barras

    ///Empieza creación de grafica de barras DISTRIBUCION POR GRADO
    $data1y=$distribucion[0];
    $data2y=$distribucion[1];
    $graph1 = new Graph(350,200,'auto');
    $graph1->SetScale("textlin");
    $theme_class=new UniversalTheme;
    $graph1->SetTheme($theme_class);
    $graph1->SetBackgroundImage("assets/img/background.jpg",BGIMG_FILLFRAME);
    $graph1->SetBox(false);
    $graph1->ygrid->SetFill(false);
    $graph1->xaxis->Hide();
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


    $pdf->SetFont('', '', 8);




    $str_htm3 =<<<EOD
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
    <table WIDTH="524">
      <tbody>
        <tr>
          <td WIDTH="2"></td>
          <td WIDTH="85"></td>
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
          <td WIDTH="2"></td>
          <td WIDTH="85">Nombre:</td>
          <td WIDTH="10">&nbsp;</td>
          <td WIDTH="130"><strong>$nombre</strong></td>
          <td WIDTH="5">&nbsp;</td>
          <td WIDTH="25">&nbsp;</td>
          <td WIDTH="10">&nbsp;</td>
          <td WIDTH="45">&nbsp;</td>
          <td WIDTH="30">&nbsp;</td>
          <td WIDTH="40">Municipio:</td>
          <td WIDTH="20">&nbsp;</td>
          <td WIDTH="50"><strong>$municipio</strong></td>
          <td WIDTH="85">&nbsp;</td>
          <td WIDTH="2"></td>
        </tr>
        <tr>
          <td WIDTH="2"></td>
          <td WIDTH="85">CCT:</td>
          <td WIDTH="10">&nbsp;</td>
          <td WIDTH="130"><strong>$cct</strong></td>
          <td WIDTH="5">&nbsp;</td>
          <td WIDTH="25">Turno:</td>
          <td WIDTH="10">&nbsp;</td>
          <td WIDTH="45"><strong>$turno</strong></td>
          <td WIDTH="30">&nbsp;</td>
          <td WIDTH="40">Modalidad:</td>
          <td WIDTH="20">&nbsp;</td>
          <td WIDTH="50"><strong>$modalidad</strong></td>
          <td WIDTH="85">&nbsp;</td>
          <td WIDTH="2"></td>
        </tr>
        <tr>
          <td WIDTH="2"></td>
          <td WIDTH="85">Director / Responsable:</td>
          <td WIDTH="10">&nbsp;</td>
          <td WIDTH="130"><strong>$director</strong></td>
          <td WIDTH="5">&nbsp;</td>
          <td WIDTH="25">&nbsp;</td>
          <td WIDTH="10">&nbsp;</td>
          <td WIDTH="45">&nbsp;</td>
          <td WIDTH="30">&nbsp;</td>
          <td WIDTH="40">&nbsp;</td>
          <td WIDTH="20">&nbsp;</td>
          <td WIDTH="50">&nbsp;</td>
          <td WIDTH="85">&nbsp;</td>
          <td WIDTH="2"></td>
        </tr>
        <tr>
          <td WIDTH="2"></td>
          <td WIDTH="85"></td>
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

// border: none;
// border: 1px solid black;
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

		$pdf->writeHTMLCell($w=120,$h=55,$x=10,$y=40, $encabezado_v, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

    $str_htm3 = <<<EOT
    <style>
    table td{
      border: none;
      padding: 5px !important;
      background-color:#DAD7D6;
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

$pdf->Image('assets/img/admiracion.png', 16,61,5, 5, '', '', '', false, 300, '', false, false, 0);



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
      <td HEIGHT="20" style="background-color:#C2001F; text-align:center;" color="white">PERMANENCIA</td>
    </tr>
    <tr>
      <td HEIGHT="400" style="background-color:#F7F7F6;"></td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

// $pdf->writeHTMLCell($w=200,$h=55,$x=107,$y=70, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$pdf->SetFillColor(0, 0, 127);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

// set some text for example
$txt = 'ASISTENCIA';
$txt1 = 'PERMANENCIA';
$txt2 = 'APRENDIZAJE';




// Multicell test
$pdf->SetFillColor(194, 0, 31);
$pdf->SetTextColor(255, 255, 255);
$pdf->MultiCell(92, 10,$txt, 0, 'C', 1, 0, 13, 70, 'M');
$pdf->MultiCell(92, 10,$txt1, 0, 'C', 1, 0, 107, 70, 'M');

$pdf->SetFillColor(247, 247, 246);
// $pdf->MultiCell(80, 0, $left_column, 0, 'J', 1, 0, '', '', true, 0, false, true, 0);


$pdf->MultiCell(92, 200,'', 0, 'C', 1, 0, 13, 80, true);
$pdf->MultiCell(92, 150,'', 0, 'C', 1, 0, 107, 80, true);

$pdf->SetTextColor(0, 0, 0);

$asi_est_al_t=$reporte_datos['asi_est_al_t'];
$asi_est_gr_t=$reporte_datos['asi_est_gr_t'];
$asi_est_doc=$reporte_datos['asi_est_do_t'];


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
    <tr style="background-color:#ACADB1; text-align:center;">
      <td>&nbsp;</td>
      <td>Total</td>
      <td>1<sup>o</sup></td>
      <td>2<sup>o</sup></td>
      <td>3<sup>o</sup></td>
      <td>4<sup>o</sup></td>
      <td>5<sup>o</sup></td>
      <td>6<sup>o</sup></td>
    </tr>
    <tr>
      <td style="background-color:#DCDDDF;"><font size="7">Alumnos</font></td>
      <td style="text-align:center;">$asi_est_al_t</td>
      <td style="text-align:center;">$est_asis_alumnos[0]</td>
      <td style="text-align:center;">$est_asis_alumnos[1]</td>
      <td style="text-align:center;">$est_asis_alumnos[2]</td>
      <td style="text-align:center;">$est_asis_alumnos[3]</td>
      <td style="text-align:center;">$est_asis_alumnos[4]</td>
      <td style="text-align:center;">$est_asis_alumnos[5]</td>
    </tr>
    <tr>
      <td style="background-color:#DCDDDF;"><font size="7">Grupos</font></td>
      <td style="text-align:center;">$asi_est_gr_t</td>
      <td style="text-align:center;">$est_asis_gr[0]</td>
      <td style="text-align:center;">$est_asis_gr[1]</td>
      <td style="text-align:center;">$est_asis_gr[2]</td>
      <td style="text-align:center;">$est_asis_gr[3]</td>
      <td style="text-align:center;">$est_asis_gr[4]</td>
      <td style="text-align:center;">$est_asis_gr[5]</td>
    </tr>
    <tr>
      <td style="background-color:#DCDDDF;"><font size="7">Docentes</font></td>
      <td style="text-align:center;">$asi_est_doc</td>
      <td colspan="6"></td>

    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=15,$y=90, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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
    <tr style="background-color:#DCDDDF;">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="background-color:#DCDDDF;">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=15,$y=230, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

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

$pdf->writeHTMLCell($w=60,$h=30,$x=110,$y=120, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

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
      <td colspan="3"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="background-color:#F5842A;">&nbsp;</td>
      <td colspan="2" style="background-color:#DCDDDF;"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="background-color:#D1232A;">&nbsp;</td>
      <td colspan="2" style="background-color:#DCDDDF;"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=110,$y=195, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

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

    <tr style="background-color:#B7BCC8;">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
EOT;

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=110,$y=220, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
///TERMINA PRIMERA PÁGINA

/// INICIA SEGUNDA PÄGINA
///Se agrega el header y footer
$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->AddPage('P', 'A4');
$pdf->Image('assets/img/encabezado.png', 0,0,210, 35, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/pie.png', 0,282,210, 15, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAutoPageBreak(FALSE, 0);
$pdf->writeHTMLCell($w=120,$h=55,$x=10,$y=40, $encabezado_v, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
$a=15;
$b=85;
$str_htm3 = <<<EOT
<style>
table td{
  border: none;
}
</style>
<table>
  <tbody>
  <tr WIDTH="105" HEIGHT="15">
    <td width="$a" style="text-align:center;" HEIGHT="15"><strong>I</strong></td>
    <td width="5" HEIGHT="15"></td>
    <td width="$b" style="text-align:center;" HEIGHT="15"><strong>II, III , IV</strong></td>
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
$pdf->writeHTMLCell($w=60,$h=10,$x=30,$y=100, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);


$pdf->SetFont('', '', 8);
$pdf->SetFillColor(194, 0, 31);
$pdf->SetTextColor(255, 255, 255);
$pdf->MultiCell(185, 10,$txt2, 0, 'C', 1, 0, 13, 60, true);


///Empieza creación de grafica de barras

$data1y=$planea_aprov[0];
$data2y=$planea_aprov[1];
// $data3y=array(0,0,0,0,0,0);
$graph = new Graph(350,200,'auto');
$graph->SetScale("textlin");
$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);
// $graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
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
$pdf->Image('barras2.png', 110,160,80, 50, 'PNG', '', '', false, 300, '', false, false, 0);

unlink('barras2.png');

$pdf->SetTextColor(0, 0, 0);

/// INICIA TERCERA PÄGINA
$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->AddPage('L', 'A4');
$pdf->Image('assets/img/encabezado_h.png', 0,0,300, 35, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/pie_h.png', 0,195,300, 15, '', '', '', false, 300, '', false, false, 0);
$pdf->writeHTMLCell($w=150,$h=55,$x=10,$y=40, $encabezado_h, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$pdf->SetAutoPageBreak(FALSE, 0);

$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->AddPage('L', 'A4');
$pdf->Image('assets/img/encabezado_h.png', 0,0,300, 35, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/pie_h.png', 0,195,300, 15, '', '', '', false, 300, '', false, false, 0);
$pdf->writeHTMLCell($w=150,$h=55,$x=10,$y=40, $encabezado_h, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
$pdf->SetAutoPageBreak(FALSE, 0);

$pdf->Output('certificado.pdf', 'I');



  }


}

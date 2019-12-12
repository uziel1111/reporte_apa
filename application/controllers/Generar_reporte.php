<?php

class Generar_reporte extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('My_tcpdf');
    include_once 'jpgraph/src/jpgraph.php';
    include_once 'jpgraph/src/jpgraph_pie.php';
    include_once 'jpgraph/src/jpgraph_pie3d.php';
    include_once 'jpgraph/src/jpgraph_bar.php';

  }// __construct()


  function index(){
    // echo "Hola mundo";
    $this->rep();
    // $this->graf();
  }


  function rep(){
    $pastel=array(29,14,30,322);
    // $barras=array(array(1,2,3),array(4,5,6),array(7,8,9));
    // $barras=array(1,2,3,4,5,6,7,8);
    // $this->graf($pastel,$barras);
    $this->graf($pastel);

  }

  function graf($pastel,$barras=NULL){

    $data = $pastel;
    $pdf = new My_tcpdf('P', 'mm', 'A4', true, 'UTF-8', false);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('TCPDF Example 031');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');


    $pdf->SetAutoPageBreak(TRUE, 0);
    $pdf->AddPage('P', 'A4');
    $pdf->Image('assets/img/encabezado.png', 0,0,210, 35, '', '', '', false, 300, '', false, false, 0);
    $pdf->Image('assets/img/pie.png', 0,282,210, 15, '', '', '', false, 300, '', false, false, 0);
    $pdf->SetAutoPageBreak(FALSE, 0);


    ///Empieza creación de grafica de pastel
    $graph_p = new PieGraph(350,250);
    $theme_class="DefaultTheme";
    // $graph_p->title->Set("A Simple Pie Plot 1");
    $graph_p->SetBox(true);
    $p1 = new PiePlot($data);
    $graph_p->Add($p1);
    $p1->ShowBorder();
    $p1->SetColor('black');
    $p1->SetSliceColors(array('#1E90FF','#2E8B57','#ADFF2F','#DC143C'));
    $graph_p->img->SetImgFormat('png');
    $graph_p->Stroke('pastel.png');
    ///Termina creación de grafica de pastel

    $pdf->Image('pastel.png', 130,90,35, 25, 'png', '', '', false, 300, '', false, false, 0);
    unlink('pastel.png');


    ///Empieza creación de grafica de barras
    $data1y=array(47,80,40,116,10,20);
    $data2y=array(61,30,82,105,10,20);
    $data3y=array(115,50,70,93,10,20);
    $graph = new Graph(350,200,'auto');
    $graph->SetScale("textlin");
    $theme_class=new UniversalTheme;
    $graph->SetTheme($theme_class);
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
    ///Termina creación de grafica de barras

    $pdf->Image('barras.png', 20,110,80, 50, 'PNG', '', '', false, 300, '', false, false, 0);
    unlink('barras.png');


    ///Empieza creación de grafica de barras
    $data1y=array(1,2,4,6,10,2);
    $data2y=array(6,3,8,5,7,8);
    // $data3y=array(0,0,0,0,0,0);
    $graph = new Graph(350,200,'auto');
    $graph->SetScale("textlin");
    $theme_class=new UniversalTheme;
    $graph->SetTheme($theme_class);
    // $graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
    $graph->SetBox(false);
    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels(array('1','2','3','4','5','6'));
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






    // $b3plot->SetColor("white");
    // $b3plot->SetFillColor("#FFFFFF");
    $graph->Stroke('barras1.png');
    ///Termina creación de grafica de barras

    $pdf->Image('barras1.png', 115,140,80, 50, 'PNG', '', '', false, 300, '', false, false, 0);
    unlink('barras1.png');


    $pdf->SetFont('', '', 8);

    $str_htm3 = '
		<style>
		table td{
      border: none;
      padding: 5px !important;
      background-color:#ECECEE;
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
    <td WIDTH="130"><strong>LICENCIADO BENITO JUAREZ</strong></td>
    <td WIDTH="5">&nbsp;</td>
    <td WIDTH="25">&nbsp;</td>
    <td WIDTH="10">&nbsp;</td>
    <td WIDTH="45">&nbsp;</td>
    <td WIDTH="30">&nbsp;</td>
    <td WIDTH="40">Muncipio:</td>
    <td WIDTH="20">&nbsp;</td>
    <td WIDTH="50"><strong>CULIACAN</strong></td>
    <td WIDTH="85">&nbsp;</td>
    <td WIDTH="2"></td>
    </tr>
    <tr>
    <td WIDTH="2"></td>
    <td WIDTH="85">CCT:</td>
    <td WIDTH="10">&nbsp;</td>
    <td WIDTH="130"><strong>25DPR2893V</strong></td>
    <td WIDTH="5">&nbsp;</td>
    <td WIDTH="25">Turno:</td>
    <td WIDTH="10">&nbsp;</td>
    <td WIDTH="45"><strong>MATUTINO</strong></td>
    <td WIDTH="30">&nbsp;</td>
    <td WIDTH="40">Modalidad:</td>
    <td WIDTH="20">&nbsp;</td>
    <td WIDTH="50"><strong>GENERAL</strong></td>
    <td WIDTH="85">&nbsp;</td>
    <td WIDTH="2"></td>
    </tr>
    <tr>
    <td WIDTH="2"></td>
    <td WIDTH="85">Director / Responsable:</td>
    <td WIDTH="10">&nbsp;</td>
    <td WIDTH="130"><strong>ALEYDA HERNANDEZ MONTES</strong></td>
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
		';

		$encabezado = <<<EOT
		$str_htm3
EOT;

		$pdf->writeHTMLCell($w=120,$h=55,$x=10,$y=40, $encabezado, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

    $str_htm3 = '
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
		';

		$html3 = <<<EOT
		$str_htm3
EOT;

$pdf->writeHTMLCell($w=120,$h=55,$x=12,$y=60, $html3, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$pdf->Image('assets/img/admiracion.png', 16,61,5, 5, '', '', '', false, 300, '', false, false, 0);



$str_htm3 = '
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
';

$html5 = <<<EOT
$str_htm3
EOT;

// $pdf->writeHTMLCell($w=200,$h=55,$x=12,$y=70, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$str_htm3 = '
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
';

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
$pdf->MultiCell(92, 10,$txt, 0, 'C', 1, 0, 13, 70, true);
$pdf->MultiCell(92, 10,$txt1, 0, 'C', 1, 0, 107, 70, true);

$pdf->SetFillColor(247, 247, 246);
// $pdf->MultiCell(80, 0, $left_column, 0, 'J', 1, 0, '', '', true, 0, false, true, 0);


$pdf->MultiCell(92, 200,'', 0, 'C', 1, 0, 13, 80, true);
$pdf->MultiCell(92, 150,'', 0, 'C', 1, 0, 107, 80, true);

$pdf->SetTextColor(0, 0, 0);

$str_htm3 = '
<style>
table td{
border: 1px solid black;
padding: 2px !important;
}
table th{
border: 1px solid black;
padding: 2px !important;
text-align: center;
}
</style>
<table WIDTH="245">
<tbody>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>
';

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=15,$y=90, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$str_htm3 = '
<style>
table td{
border: 1px solid black;
padding: 2px !important;
}
table th{
border: 1px solid black;
padding: 2px !important;
text-align: center;
}
</style>
<table WIDTH="245">
<tbody>
<tr>
<td colspan="7"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="2"></td>
<td colspan="2"></td>
<td colspan="2"></td>
</tr>
</tbody>
</table>';

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=15,$y=165, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);


$str_htm3 = '
<style>
table td{
border: 1px solid black;
padding: 2px !important;
}
table th{
border: 1px solid black;
padding: 2px !important;
text-align: center;
}
</style>
<table WIDTH="245">
<tbody>
<tr>
<td colspan="7">REZAGO EDUCATIVO</td>
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="3"></td>
<td colspan="3"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>';

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=15,$y=195, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$str_htm3 = '
<style>
table td{
border: 1px solid black;
padding: 2px !important;
}
table th{
border: 1px solid black;
padding: 2px !important;
text-align: center;
}
</style>
<table WIDTH="245">
<tbody>
<tr>
<td colspan="4"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>';

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=15,$y=230, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);


$str_htm3 = '
<style>
table td{
border: 1px solid black;
padding: 2px !important;
}
table th{
border: 1px solid black;
padding: 2px !important;
text-align: center;
}
</style>
<table WIDTH="245">
<tbody>

<tr>
<td>&nbsp;</td>
<td colspan="2"></td>
<td colspan="2"></td>
<td colspan="2"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>';

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=110,$y=120, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$str_htm3 = '
<style>
table td{
border: 1px solid black;
padding: 2px !important;
}
table th{
border: 1px solid black;
padding: 2px !important;
text-align: center;
}
</style>
<table WIDTH="245">
<tbody>

<tr>
<td colspan="3"></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="2"></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="2"></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>';

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=110,$y=195, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$str_htm3 = '
<style>
table td{
border: 1px solid black;
padding: 2px !important;
}
table th{
border: 1px solid black;
padding: 2px !important;
text-align: center;
}
</style>
<table WIDTH="245">
<tbody>

<tr>
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
</table>';

$html5 = <<<EOT
$str_htm3
EOT;

$pdf->writeHTMLCell($w=60,$h=30,$x=110,$y=220, $html5, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->AddPage('P', 'A4');
$pdf->Image('assets/img/encabezado.png', 0,0,210, 35, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/pie.png', 0,282,210, 15, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAutoPageBreak(FALSE, 0);

$pdf->writeHTMLCell($w=120,$h=55,$x=10,$y=40, $encabezado, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
$pdf->SetFillColor(194, 0, 31);
$pdf->SetTextColor(255, 255, 255);
$pdf->MultiCell(185, 10,$txt2, 0, 'C', 1, 0, 13, 60, true);


///Empieza creación de grafica de barras
$data1y=array(1,2,4,6);
$data2y=array(6,3,8,5);
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

$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->AddPage('L', 'A4');
$pdf->Image('assets/img/encabezado_h.png', 0,0,300, 35, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/pie_h.png', 0,195,300, 15, '', '', '', false, 300, '', false, false, 0);
$pdf->writeHTMLCell($w=150,$h=55,$x=10,$y=40, $encabezado, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
$pdf->SetAutoPageBreak(FALSE, 0);

$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->AddPage('L', 'A4');
$pdf->Image('assets/img/encabezado_h.png', 0,0,300, 35, '', '', '', false, 300, '', false, false, 0);
$pdf->Image('assets/img/pie_h.png', 0,195,300, 15, '', '', '', false, 300, '', false, false, 0);
$pdf->writeHTMLCell($w=150,$h=55,$x=10,$y=40, $encabezado, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);
$pdf->SetAutoPageBreak(FALSE, 0);

$pdf->Output('certificado.pdf', 'I');



  }


}

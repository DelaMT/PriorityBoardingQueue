<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../AdminUtil.css"/>
</head>
<body>

<?php
 echo "ID is " . $_SESSION["ID"];
require('../TCPDF/tcpdf.php');

$max = $_POST['counter'];
$id = $_POST['id'];
$pid = $_POST['pid'];
$er = $_POST['er'];
$reason = $_POST['reason'];
$i = 0;

while($i <= $max) {

    $html = '<table>
<tr>
<td>
ID
</td>
<td>
PID
</td>
<td>
Extra Reqs
</td>
<td>
Reason
</td>
</tr>';

    $html .= '<tbody>
<tr>
<td>
' . $id . '
</td>';
    $html .= '<td>
' . $pid[$i] . '</td>';
    $html .= '<td>' . $er[$i] . '</td>';
    $html .= '<td>' . $reason[$i] . '</td>';
    $html .= '</tr>
</tbody>
</table>
<br><br><br>';
$i++;
}
$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default monospaced font
$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set title of pdf
$tcpdf->SetTitle('Bill Collection Letter');

// set margins
$tcpdf->SetMargins(10, 10, 10, 10);
$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$tcpdf->SetAutoPageBreak(TRUE, 11);

// set image scale factor
$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$tcpdf->AddPage();

$tcpdf->SetFont('times', '', 10.5);

$tcpdf->writeHTML($html, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$tcpdf->Output('demo.pdf', 'I');

/*
require_once 'dompdf/lib/html5lib/Parser.php';
require_once 'dompdf/src/Autoloader.php';
//require_once 'dompdf/lib/php-svg-lib/src/autoload.php';
require_once 'dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml('ViewAllBoardingIDCard.php');

// (Optional) Setup the paper size and orientation
//$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

ob_start();
$pdf = '
// You can put your HTML code here
< h1 > Lorem Ipsum... </ h1 >
< h2 > Lorem Ipsum... </ h2 >
< h3 > Lorem Ipsum... </ h3 >
< h4 > Lorem Ipsum... </ h4 >
';


require('../TCPDF/tcpdf.php');
$ID = $_POST['ID'];
$PID = $_POST['PID'];
$ER = $_POST['Extra_Requirements'];
$reason =  $_POST['Reason'];
$temp = $_POST['temp'];
$temp2 = $_POST['temp2'];
$temp3 = $_POST['temp3'];
$temp4 = $_POST['temp4'];
$temp5 = $_POST['temp5'];
$temp6 = $_POST['temp6'];
$temp7 = $_POST['temp7'];
$temp8 = $_POST['temp8'];



$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default monospaced font
$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set title of pdf
$tcpdf->SetTitle('Bill Collection Letter');

// set margins
$tcpdf->SetMargins(10, 10, 10, 10);
$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set header and footer in pdf
$tcpdf->setPrintHeader(false);
$tcpdf->setPrintFooter(false);
$tcpdf->setListIndentWidth(3);

// set auto page breaks
$tcpdf->SetAutoPageBreak(TRUE, 11);

// set image scale factor
$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$tcpdf->AddPage();

$tcpdf->SetFont('times', '', 10.5);

$tcpdf->writeHTML($pdf, true, false, false, false, '');

//Close and output PDF document
ob_end_clean();
$tcpdf->Output('demo.pdf', 'I');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '<table style="width:110%;" class="mgarrtable">

    <tr>
        <th><h2>ID</h2></th>
        <th><h2>PID</h2></th>
        <th><h2>Extra Reqs</h2></th>
        <th><h2>Reason</h2></th>
        <!--
        MGARR TIMES - MOVE TO SEPARATE ROW
        <th><h2>Mgarr - FROM</h2></th>
        <th><h2>MTime - FROM</h2></th>
        <th><h2>Mgarr - TO</h2></th>
        <th><h2>MTime - TO</h2></th> -->
        <!--
        CIRKEWWA TIMES - MOVE TO SEPERATE ROW
        <th><h2>Cirkewwa - TO</h2></th>
        <th><h2>CTime - TO</h2></th>
        <th><h2>Cirkewwa - FROM</h2></th>
        <th><h2>CTime - FROM</h2></th> -->
    </tr>
<tr>
<td style=\'text-align:center;\'>' . $_SESSION["ID"] . '</td>
<td style=\'text-align:center;\'>' . $_SESSION["PID"] . '</td>
<td style=\'text-align:center;\'>' . $_SESSION["Extra_Requirements"] . '</td>
<td style=\'text-align:center;\'>' . $_SESSION["Reason"] . '</td>
<!--
<td style=\'text-align:center;\'>' . $temp . '</td>
<td style=\'text-align:center;\'>' . $temp2 . '</td>
<td style=\'text-align:center;\'>' . $temp3 . '</td>
<td style=\'text-align:center;\'>' . $temp4 . '</td>
<td style=\'text-align:center;\'>' . $temp5 . '</td>
<td style=\'text-align:center;\'>' . $temp6 . '</td>
<td style=\'text-align:center;\'>' . $temp7 . '</td>
<td style=\'text-align:center;\'>' . $temp8 . '</td></tr>
 -->
 </tr>
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------

//Close and output PDF document
ob_end_clean();
$pdf->Output('example_006.pdf', 'I');
*/
?>

</body>
</html>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../AdminUtil.css"/>
</head>

<body>
<?php
$temp = $_POST[]
//require_once('tcpdf/config/lang/eng.php');
require_once('C:\xampp\phpMyAdmin\vendor\tecnickcom\tcpdf\tcpdf.php');

// create new PDF document
$pdf = new TCPDF();

// set font
$pdf->SetFont('helvetica', '', 16);

// add a page
$pdf->AddPage();

// print a line
$pdf->Cell(0, 0, 'Some text');

// print html formated text
$pdf->writeHtml('<table style="width:150%;"><tr>Hello</tr></table>');

// draw a circle
//$pdf->Circle(30, 30, 10);

//Close and output PDF document
ob_end_clean();
$pdf->Output('out.pdf', 'I');

?>
</body>
</html>


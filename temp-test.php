<?php
/*
 * Template Name: Test
 */

get_header('landing');


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();

?>

<?php get_footer();?>


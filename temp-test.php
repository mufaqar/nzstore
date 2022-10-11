<?php
/*
 * Template Name: Test
 */

get_header('landing');


require "vendor/autoload.php";

use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first test');
$html2pdf->output();



// $html2pdf = new Html2Pdf();
// $html2pdf->writeHTML('<h1 style="color:pink;">CodeWall PDF</h1> <br/> <p>Convert this HTML to PDF please!</p>');
// $html2pdf->output('myPdf.pdf); // Generate and load the PDF in the browser.


?>

<?php get_footer();?>


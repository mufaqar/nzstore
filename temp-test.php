<?php
/*
 * Template Name: Test
 */

get_header('landing');





// (A) LOAD MPDF


require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();


$mpdf->WriteHTML('<h1>Hello world!</h1>');
$mpdf->Output();




?>


<?php get_footer();?>


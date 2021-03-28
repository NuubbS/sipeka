<?php 

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WrieteHTML('<h1>Hello World!</h1>');
$mpdf->Output();
?>
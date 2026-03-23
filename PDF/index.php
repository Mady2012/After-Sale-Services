<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

ob_start();

require "./bill.php";

$html = ob_get_contents();

ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'landscape');

$dompdf->render();
$filename = "report_doc.pdf";

$dompdf->stream($filename, ["Attachment" => true]);

?>
<?php



include('include/config.php');



require_once __DIR__ . 'mpdf/vendor/autoload.php';




$style= "<style>html,body{height:297mm;width:210mm;padding: 8mm 4mm 8mm 4mm}   p{font-size:14px;} div{overflow:hidden;width:65mm;height:38mm; float:left;border:1px solid;margin:0;padding:-2 0 -2 5px;} </style>";
for ($x = 0; $x < 21; $x++) {
    $data .= "<div style='page-break-inside:avoid;padding:5px;'><p>ANAND S.N.</p><P>  #54, M/S, RAJATHA ENTREPRISE V.T.STREET, SARJAPURA POST
                BENGALURU RURAL, ANEKAL, 562125</P></div>"; 
} 

$data_print = $style.'<p>'.$data.'</p>';

echo $data_print;
$mpdf = new mPDF();
// $mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML($data_print);
$mpdf->Output('mpdf.pdf','D');
?>

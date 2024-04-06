<?php

// $dbServername = "localhost";
// $dbUsername = "root";
// $dbPassword = "";
// $dbName = "techmhco_mahamandali";

$dbServername = "www.techmh.com";
$dbUsername = "techmhco_admin";
$dbPassword = "megahard@123";
$dbName = "techmhco_mahamandali";

$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM member;";
$results = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($results);

$data_style = "<style> html,body{height:297mm;width:210mm;padding: 16mm 4mm 16mm 4mm}   p{font-size:7px;} div{overflow:hidden;white-space: nowrap;width:55mm;height:38mm; float:left;border:1px solid;margin: 0 3mm 0 3mm;padding:-2 0 -2 5px;} </style>";
$data  = '';
if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($results)) {

 $data .= "<div>"; 
 $data .=  "<p>".strtoupper($row["member_name"])."</p>"; 
 $data .=  strtoupper(substr("<p style='padding:0 0 -10px 0'>".$row["adl1"].' '.$row["adl2"].' '.$row["district"].', '.$row["taluk"].', '.$row["pincode"]."</p>",0,216));
 $data .= "</div>"; 
 }

 $data_content = "<html><body><p>".$data."</p></body></html>";
 $data_print = $data_style.$data_content;
}


require_once __DIR__ . '/vendor/autoload.php';
	
$mpdf = new mPDF();
// $mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML($data_print);
$mpdf->Output('mpdf.pdf','D');

?>

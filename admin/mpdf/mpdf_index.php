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

// $sql = "SELECT * FROM member;";
// $results = mysqli_query($conn, $sql);
// $resultCheck = mysqli_num_rows($results);

// $data_style = "<style>p{font-size:7px;} div{overflow:hidden;white-space: nowrap;width:4cm;height:3.4cm; float:left;border:1px solid;padding:-2 0 -2 5px;} page { background: orange; display: block; margin: 0 auto; margin-bottom: 0.5cm; box-shadow: 0 0 0.5cm rgba(0,0,0,0.5); } page[size='A4'] { width: 21cm; height: 29.7cm; }</style>";
// $data  = '';
// if ($resultCheck > 0) {
//     while ($row = mysqli_fetch_assoc($results)) {

//  $data .= "<div>"; 
//  $data .=  "<p>".strtoupper($row["member_name"])."</p>"; 
//  $data .=  strtoupper(substr("<p style='padding:0 0 -10px 0'>".$row["adl1"].' '.$row["adl2"].' '.$row["district"].', '.$row["taluk"].', '.$row["pincode"]."</p>",0,216));
//  $data .= "</div>"; 
//  }

//  $data_content = "<p>".$data."</p>";
//  $data_print = $data_style.$data_content;
// }

require_once __DIR__ . '/vendor/autoload.php';


// // dummy data
// $data_print =  "<style>p{font-size:7px;} div{width:4cm;height:2cm; float:left;border:1px solid;padding:-2 0 -2 5px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;} page { background: orange; display: block; margin: 0 auto; margin-bottom: 0.5cm; box-shadow: 0 0 0.5cm rgba(0,0,0,0.5); } page[size='A4'] { width: 21cm; height: 29.7cm; }</style>
// <p>
//     <div>
//         <p>VISHVARDAHN</p>
//         <p>NO 102, BANASHREE STREET,<br />
//         <p>KASARAGOODU, BENGALURU-560038<br />
//         <p>BENGALURU TALUK DISTRICT</p>
//     </div>

//     <div>
//         <p>VISHVARDAHN</p>
//         <p>NO 102, BANASHREE STREET,<br />
//         <p>KASARAGOODU, BENGALURU-560038<br />
//         <p>BENGALURU TALUK DISTRICT</p>
//     </div>

//     <div>
//         <p>VISHVARDAHN</p>
//         <p>NO 102, BANASHREE STREET,<br />
//         <p>KASARAGOODU, BENGALURU-560038<br />
//         <p>BENGALURU TALUK DISTRICT</p>
//     </div>

//     <div>
//         <p>VISHVARDAHN</p>
//         <p>NO 102, BANASHREE STREET,<br />
//         <p>KASARAGOODU, BENGALURU-560038<br />
//         <p>BENGALURU TALUK DISTRICT</p>
//     </div>
// </p>";

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

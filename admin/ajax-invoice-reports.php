<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
  } else{

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>HMS | View Invoice</title>
		
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
	</head>
	<body>
		<div id="app">		
<?php include('include/sidebar.php');?>
<div class="app-content">
<?php include('include/header.php');?>
<div class="main-content" >
<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
<section id="page-title">
<div class="row">
<div class="col-sm-8">
<h1 class="mainTitle">HMS | View Invoice</h1>
</div>
<ol class="breadcrumb">
<li>
<span>HMS</span>
</li>
<li class="active">
<span>View Invoice</span>
</li>
</ol>
</div>
</section>
<div style="text-align: left; padding-left: 20px; margin-bottom: 20px;">
    <a href="invoice-reports.php" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
</div>
<div class="container-fluid container-fullw bg-white">
<div class="row">
<div class="col-md-12">
<h4 class="tittle-w3-agileits mb-4">Invoice reports</h4>
<?php
$fdate=$_POST['fromdate'];
$tdate=$_POST['todate'];
$payment=$_POST['payment'];
?>
<h5 align="center" style="color:blue">Report  <?php echo $treatment?>Invoice</h5>
	
<table class="table table-hover" id="sample-table-1">
<thead>
<tr>
<th class="center">Slno</th>
<th class="center">Print</th>
<th>Patient</th>
<th>Invoice Number</th>
<th>InvoiceDate</th>
<th>Payment Mode</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<?php
if($fdate!=null && $tdate!=null && $payment!=null )
{
$sql=mysqli_query($con,"select * from patients_history where date(vdate) between '$fdate' and '$tdate' and payment_mode='$payment'");
$cnt=1;
}
elseif($fdate!=null){
	$sql=mysqli_query($con,"select * from patients_history where vdate >='$fdate'");
	$cnt=1;
}
elseif($tdate!=null){
	$sql=mysqli_query($con,"select * from patients_history where vdate <='$tdate'");
	$cnt=1;
}
elseif($payment!=null){
	$sql=mysqli_query($con,"select * from patients_history where payment_mode='$payment'");
	$cnt=1;
}
else{
	$sql=mysqli_query($con,"select * from patients_history");
	$cnt=1;
}
while($row=mysqli_fetch_array($sql))
{
	$patient_id = $row['patients_id'];
    $patient_sql = mysqli_query($con, "select * from tblpatient where ID='$patient_id'");
    $patient_row = mysqli_fetch_array($patient_sql);
    $patient_name = $patient_row['PatientName'];

	$history_query = mysqli_query($con, "SELECT id FROM patients_history WHERE patients_id='$patient_id' and invoice_no='" . $row['invoice_no'] . "'");
	$history_row = mysqli_fetch_array($history_query);
	$history_id = $history_row['id'];

	$itemQuery = mysqli_query($con, "SELECT SUM(cost) AS total_cost FROM patients_item WHERE patients_id='$patient_id' and invoice_no='" . $row['invoice_no'] . "'");
	$itemData = mysqli_fetch_array($itemQuery);
	$invoiceAmount = $itemData['total_cost'];
?>

<tr>
<td class="center"><?php echo $cnt;?>.</td>
<td class="center">
    <a href="report_invoice.php?id=<?php echo $history_id; ?>&View=<?php echo $patient_id; ?>" target="_blank">
        <button>Print</button>
    </a>
</td>
<td><?php echo  $patient_name;?></td>
<td><?php echo  $row['invoice_no'];?></td>
<td><?php echo date('d/m/Y', strtotime($row['vdate']));?></td>
<td><?php echo  $row['payment_mode'];?></td>
<td><?php echo $invoiceAmount; ?></td>
</td>
<!--td>

<a href="view-patient.php?viewid=<!?php echo $row['ID'];?>"><i class="fa fa-eye"></i></a>

</td-->
</tr>
<?php 
$cnt=$cnt+1;
 }?></tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
			<!-- start: FOOTER -->
	<?php include('include/footer.php');?>
			<!-- end: FOOTER -->
		
			<!-- start: SETTINGS -->
	<?php include('include/setting.php');?>
			
			<!-- end: SETTINGS -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

	<script src="assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="assets/js/form-elements.js"></script>
		<script>
		$(document).ready(function() {
			$('#sample-table-1').DataTable( {
				dom: 'Bfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
					
				]
			} );
		} );
		</script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
<?php } ?>

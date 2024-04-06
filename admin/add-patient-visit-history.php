<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $note = $_POST['note'];
        $doctor = $_POST['doctor'];
		$payment = $_POST['payment'];
		$vdate = $_POST['vdate'];
        $vid = $_GET['viewid'];
		$username = $_SESSION['login'];
		//echo $username;
		$query_settings = "SELECT * FROM setting_invoice";
        $result_settings = mysqli_query($con, $query_settings);
        $row_settings = mysqli_fetch_array($result_settings);
        $prefix = $row_settings['prefix'];
		$next_num = $row_settings['next_num'];

        // Update the invoice number in the settings table
        $new_invoice_number = $next_num + 1;
        $query_update_invoice = "UPDATE setting_invoice SET next_num = '$new_invoice_number'";
        $result_update_invoice = mysqli_query($con, $query_update_invoice);

        $sql = "INSERT INTO `patients_history`(`patients_id`,`doctor`, `note`,`payment_mode`,`vdate`, `created_by`,`url1`, `url2`, `url3`, `url4`, `url5`,`invoice_no`) VALUES('$vid','$doctor','$note','$payment','$vdate','$username','','','','','',' $prefix$next_num')";
        $results_insert = mysqli_query($con, $sql);

        if ($results_insert) {
            $last_id = mysqli_insert_id($con);
            $attachmentPaths = array();
            for ($i = 1; $i <= 6; $i++) {
                $inputName = 'fileInput' . $i;
                if (isset($_FILES[$inputName]) && !empty($_FILES[$inputName]['name'])) {
                    $extension  = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);
                    $basename   = "patients_history_" . $last_id . "_file_" . $i . "." . $extension;
                    $destination  = "uploads/" . $basename;
                    $url_path = $destination;

                    if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $destination)) {
                        $query_update = "UPDATE patients_history SET url$i='$url_path' WHERE id = '$last_id';";
                        $url_update = mysqli_query($con, $query_update);

                        if ($url_update) {
                            $attachmentPaths[] = $url_path;
                        } else {
                            $msg = "Attachment $i upload failed.";
                        }
                    } else {
                        $msg = "Failed to upload Attachment $i.";
                    }
                }
            }
            if (empty($msg)) {                
				echo "<script>alert('Patient Visit History details and files uploaded successfully.');</script>";
				echo "<script>window.location.href ='add-default-treatment.php?id=" . $last_id . "&& View=" . $_GET['viewid'] . "'</script>";

            }
        } else {
            $msg = "Failed to update  Patient Medical History details.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>HMS | Add  Patient Visit</title>
		
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
<script type="text/javascript">
function valid()
{
 if(document.adddoc.npass.value!= document.adddoc.cfpass.value)
{
alert("Password and Confirm Password Field do not match  !!");
document.adddoc.cfpass.focus();
return false;
}
return true;
}
</script>


<script>
function checkemailAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#docemail").val(),
type: "POST",
success:function(data){
$("#email-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
<style>
	 label span {
        color: red;
    }

</style>
	</head>
	<body>
		<div id="app">		
<?php include('include/sidebar.php');?>
			<div class="app-content">
				
				<?php include('include/header.php');?>
						
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">HMS | Add  Patient Visit</h1>
									<h5 style="color: green; font-size:18px; ">
								<?php if($msg) { echo htmlentities($msg);}?> </h5>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>HMS</span>
									</li>
									<li class="active">
										<span>Add  Patient Visit</span>
									</li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
									
									<div class="row margin-top-30">
										<div class="col-lg-8 col-md-12">
											<div class="panel panel-white">
												<div class="panel-heading">
													<h5 class="panel-title">Add  Patient Visit</h5>
												</div>
												<div class="panel-body">
									
													<form role="form" name="adddoc" method="post" enctype="multipart/form-data" onSubmit="return valid();">
														

													<div class="form-group">
														<label for="doctor">Doctor<span >*</span>:</label>
														<select name="doctor" class="form-control">
															<?php
																$doctor_query = mysqli_query($con, "SELECT * FROM doctors");
																while ($doctor_data = mysqli_fetch_array($doctor_query)) {
																	?>
																	<option value="<?php echo htmlentities($doctor_data['doctorName']); ?>">
																		<?php echo htmlentities($doctor_data['doctorName']); ?>
																	</option>
																	<?php
																}
															?>
														</select>
													</div>
													<div class="form-group">
														<label for="note">Note<span >*</span>:</label>
														<textarea name="note" class="form-control"></textarea>
													</div>

													<div class="form-group">
														<label for="vdate">Date<span >*</span>:</label>
														<input type="date" name="vdate" class="form-control" required="true">
													</div>
													<div class="form-group">
														<label for="payment">Payment Mode<span >*</span>:</label>
														<select name="payment" class="form-control">
															<?php
																$payment_query = mysqli_query($con, "SELECT * FROM setting_payment where status='active'");
																while ($payment_data = mysqli_fetch_array($payment_query)) {
																	?>
																	<option value="<?php echo htmlentities($payment_data['mode']); ?>">
																		<?php echo htmlentities($payment_data['mode']); ?>
																	</option>
																	<?php
																}
															?>
														</select>
													</div>
													<div class="form-group">
														<label for="fileInput"> Attachment 1:</label>
														<input type="file" name="fileInput1" class="form-control-file" id="fileInput1">
													</div>

													<div class="form-group">
														<label for="fileInput"> Attachment 2:</label>
														<input type="file" name="fileInput2" class="form-control-file" id="fileInput2">
													</div>

													<div class="form-group">
														<label for="fileInput"> Attachment 3:</label>
														<input type="file" name="fileInput3" class="form-control-file" id="fileInput3">
													</div>

													<div class="form-group">
														<label for="fileInput"> Attachment 4:</label>
														<input type="file" name="fileInput4" class="form-control-file" id="fileInput4">
													</div>

													<div class="form-group">
														<label for="fileInput"> Attachment 5:</label>
														<input type="file" name="fileInput5" class="form-control-file" id="fileInput5">
													</div>		
													<div class="form-group">
														<label for="fileInput"> Attachment 6:</label>
														<input type="file" name="fileInput6" class="form-control-file" id="fileInput5">
													</div>																																																																						
														<button type="submit" name="submit" id="submit" class="btn btn-o btn-primary">
															Submit
														</button>
													</form>
												</div>
											</div>
										</div>
											
											</div>
										</div>
									<div class="col-lg-12 col-md-12">
											<div class="panel panel-white">
												
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end: BASIC EXAMPLE -->
			
					
					
						
						
					
						<!-- end: SELECT BOXES -->
						
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
		<script src="assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="assets/js/form-elements.js"></script>
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
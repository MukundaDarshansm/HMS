<?php
session_start();
error_reporting(0);
include('include/config.php');

if (empty($_SESSION['id'])) {
    header('location:logout.php');
    exit();
} else {
    if (isset($_GET['id'])) {
        $did = intval($_GET['id']); // get User id
		$pid = intval($_GET['pid']);

        if (isset($_POST['submit'])) {
            $note = $_POST['note'];
			$doctor = $_POST['doctor'];
            $sql = "UPDATE patients_medical_history SET note='$note', doctor='$doctor',url1='TAB',url2='TAB',url3='TAB',url4='TAB',url5='TAB' WHERE id='$did'";
            $results_insert = mysqli_query($con, $sql);

            if ($results_insert) {
                $attachmentPaths = array();
                for ($i = 1; $i <= 6; $i++) {
                    $inputName = 'fileInput' . $i;
                    if (isset($_FILES[$inputName]) && !empty($_FILES[$inputName]["name"])) {
                        $extension  = pathinfo($_FILES[$inputName]["name"], PATHINFO_EXTENSION);
                        $basename   = "patients_medical_history_" . $did . "_file" . $i . "." . $extension;
                        $destination  = "uploads/" . $basename;
                        $url_path = $destination;
                        if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $destination)) {
                            $query_update = "UPDATE patients_medical_history SET url$i='$url_path' WHERE id = '$did';";
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
                    //$msg = "User details and files uploaded successfully.";
					echo "<script>alert('Medical History details and files uploaded successfully.');</script>";
					echo "<script>window.location.href = 'manage-patient-medical-history.php?id=" . $pid . "'</script>";
                }
            } else {
                $msg = "Failed to update user details.";
            }
        }
	    }

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Edit Patient Medical History Details</title>
		
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
						<!-- start: MENU TOGGLER FOR MOBILE DEVICES -->
					
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Admin | Edit Patient Medical History Details</h1>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>Admin</span>
									</li>
									<li class="active">
										<span>Edit Patient Medical History Details</span>
									</li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
									<h5 style="color: green; font-size:18px; ">
								<?php if($msg) { echo htmlentities($msg);}?> </h5>
									<div class="row margin-top-30">
										<div class="col-lg-8 col-md-12">
											<div class="panel panel-white">
												<div class="panel-heading">
													<h5 class="panel-title">Edit Patient Medical History info</h5>
												</div>
												<div class="panel-body">
									<?php $sql=mysqli_query($con,"select * from patients_medical_history where id='$did'");
										while($data=mysqli_fetch_array($sql))
										{
										?>
										<h4>Patient Medical History</h4>
										<p><b> Reg. Date: </b><?php echo htmlentities($data['creationDate']);?></p>
										<?php if($data['updationDate']){?>
										<p><b> Last Updation Date: </b><?php echo htmlentities($data['updationDate']);?></p>
										<?php } ?>
										<hr />
										<form role="form" name="adddoc" method="post" enctype="multipart/form-data" onSubmit="return valid();">
														
													<div class="form-group">
														<label for="doctor">Doctor<span >*</span>:</label>
														<select name="doctor" class="form-control">
															<?php
															$doctor_query = mysqli_query($con, "SELECT * FROM doctors");
															while ($doctor_data = mysqli_fetch_array($doctor_query)) {
																$selected = ($doctor_data['doctorName'] == $data['doctor']) ? "selected" : "";
															?>
															<option value="<?php echo htmlentities($doctor_data['doctorName']); ?>" <?php echo $selected; ?>>
																<?php echo htmlentities($doctor_data['doctorName']); ?>
															</option>
															<?php
															}
															?>
														</select>

													</div>
													<div class="form-group">
														<label for="note">Note<span >*</span>:</label>
														<textarea name="note" class="form-control"><?php echo htmlentities($data['note']); ?></textarea>
													</div>

													<div class="form-group">
															<label for="fileInput1"> Attachment 1<span >*</span>:</label>
															<input type="file" name="fileInput1" class="form-control-file" id="fileInput1">
														</div>

														<div class="form-group">
															<label for="fileInput2"> Attachment 2<span >*</span>:</label>
															<input type="file" name="fileInput2" class="form-control-file" id="fileInput2">
														</div>

														<div class="form-group">
															<label for="fileInput3"> Attachment 3<span >*</span>:</label>
															<input type="file" name="fileInput3" class="form-control-file" id="fileInput3">
														</div>

														<div class="form-group">
															<label for="fileInput4"> Attachment 4<span >*</span>:</label>
															<input type="file" name="fileInput4" class="form-control-file" id="fileInput4">
														</div>

														<div class="form-group">
															<label for="fileInput5"> Attachment 5<span >*</span>:</label>
															<input type="file" name="fileInput5" class="form-control-file" id="fileInput5">
														</div>		
														<div class="form-group">
															<label for="fileInput6"> Attachments 6<span >*</span>:</label>
															<input type="file" name="fileInput6" class="form-control-file" id="fileInput">
														</div>																																																																				
														<?php } ?>
														
														
														<button type="submit" name="submit" class="btn btn-o btn-primary">
															Update
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
			<>
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

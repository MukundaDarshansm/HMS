<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
} else {
    $did = intval($_GET['id']); // get patient ID

    if (isset($_POST['submit'])) {
        // Retrieve form data
        $patiname = $_POST['patiname'];
        $patiphoneno = $_POST['patiphone'];
        $pati1phoneno = $_POST['pati1phone'];
        $patidob = $_POST['patidob'];
        $pati_group = $_POST['pati_group'];
        $pati_sex = $_POST['pati_sex'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $status = $_POST['pati_status'];
        $enrollment = $_POST['enrollment'];

        if (!empty($_FILES['newPatientPhoto']['name'])) {
            // File upload logic
            $file_name = $_FILES['newPatientPhoto']['name'];
            $temp_name = $_FILES['newPatientPhoto']['tmp_name'];
            $file_type = $_FILES['newPatientPhoto']['type'];

            // Specify the target directory to upload the file
            $target_path = "uploads/"; // Change this to your desired directory
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Create a unique file name to prevent conflicts
            $file_unique_name = time() . '_' . uniqid('', true) . '.' . $file_extension;

            // Set the final file path
            $target_file = $target_path . $file_unique_name;

            // Check if the file has the appropriate format (optional)
            $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
            if (in_array($file_type, $allowed_types)) {
                // Move the uploaded file to the specified directory
                if (move_uploaded_file($temp_name, $target_file)) {
                    // Update the patient information including the new photo path
                    $sql = mysqli_query($con, "UPDATE tblpatient SET PatientName='$patiname', PatientContno='$patiphoneno', phone_number='$pati1phoneno', PatientGender='$pati_sex', PatientEmail='$email', PatientAdd='$address', Patientdob='$patidob', status='$status', enrollment='$enrollment', blood='$pati_group', photo='$target_file' WHERE ID='$did'");
                } else {
                    echo "<script>alert('Error: Failed to upload the file.');</script>";
                }
            } else {
                echo "<script>alert('Error: Unsupported file format.');</script>";
            }
        } else {
            // If no new photo uploaded, update the patient information excluding the photo
            $sql = mysqli_query($con, "UPDATE tblpatient SET PatientName='$patiname', PatientContno='$patiphoneno', phone_number='$pati1phoneno', PatientGender='$pati_sex', PatientEmail='$email', PatientAdd='$address', Patientdob='$patidob', status='$status', enrollment='$enrollment', blood='$pati_group' WHERE ID='$did'");
        }

        if ($sql) {
            // Patient information updated successfully
            echo "<script>alert('Patient info updated Successfully');</script>";
            echo "<script>window.location.href ='manage-patient.php'</script>";
        } else {
            // Error updating patient information
            echo "<script>alert('Error: Unable to update patient information');</script>";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Edit Register Details</title>
		
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
									<h1 class="mainTitle">Admin | Edit Register Details</h1>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>Admin</span>
									</li>
									<li class="active">
										<span>Edit Register Details</span>
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
													<h5 class="panel-title">Edit Patients info</h5>
												</div>
												<div class="panel-body">
									<?php $sql=mysqli_query($con,"select * from tblpatient where ID ='$did'");
										while($data=mysqli_fetch_array($sql))
										{
										?>
										<h4><?php echo htmlentities($data['PatientName']);?></h4>
										<p><b> Reg. Date: </b><?php echo htmlentities($data['CreationDate']);?></p>
										<?php if($data['updationDate']){?>
										<p><b> Last Updation Date: </b><?php echo htmlentities($data['updationDate']);?></p>
										<?php } ?>
										<hr />
													<form role="form" name="adddoc" method="post" onSubmit="return valid();" enctype="multipart/form-data">														
														<div class="form-group">
															<label for="patiname">
															Patients Name <span >*</span>:
															</label>
															<input type="text" name="patiname" class="form-control" value="<?php echo htmlentities($data['PatientName']);?>" >
														</div>														
														<div class="form-group">
															<label for="fess">
															Patients Phone Number <span >*</span>:
															</label>
																<input type="text" id="phoneNumberInput" name="patiphone" class="form-control" required="required"  value="<?php echo htmlentities($data['PatientContno']);?>">
														</div>	
														<script>
															const phoneNumberInput = document.getElementById('phoneNumberInput');

															phoneNumberInput.addEventListener('input', function () {
																const phoneNumber = phoneNumberInput.value;
																const phoneNumberPattern = /^\d{10}$/; // This is a simple example. You may need to adjust the regular expression depending on the format you require.

																if (!phoneNumberPattern.test(phoneNumber)) {
																	phoneNumberInput.setCustomValidity('Please enter a valid 10-digit phone number.');
																} else {
																	phoneNumberInput.setCustomValidity('');
																}
															});
														</script>	
														<div class="form-group">
															<label for="fess">
															Patients Other Phone Number:
															</label>
																<input type="text" id="phoneNumber1Input" name="pati1phone" class="form-control"   value="<?php echo htmlentities($data['phone_number']);?>">
														</div>			
														<script>
															const phoneNumber1Input = document.getElementById('phoneNumber1Input');

															phoneNumber1Input.addEventListener('input', function () {
																const phoneNumber = phoneNumber1Input.value;
																const phoneNumberPattern = /^\d{10}$/; // This is a simple example. You may need to adjust the regular expression depending on the format you require.

																if (!phoneNumberPattern.test(phoneNumber)) {
																	phoneNumber1Input.setCustomValidity('Please enter a valid 10-digit phone number.');
																} else {
																	phoneNumber1Input.setCustomValidity('');
																}
															});
														</script>										
														<div class="form-group">
															<label for="fess">
															Patients Sex <span >*</span>:
															</label>
															<select name="pati_sex" class="form-control">
																<option value="Male" <?php if ($data['PatientGender'] == 'Male') echo 'selected="selected"'; ?>>Male</option>
																<option value="Female" <?php if ($data['PatientGender'] == 'Female') echo 'selected="selected"'; ?>>Female</option>
															</select>
														</div>
														<div class="form-group">
															<label for="fess">
															Patients Blood Group<span >*</span>:
															</label>
															<select name="pati_group" class="form-control">
															<option value="A+" <?php if ($data['blood'] == 'A+') echo 'selected="selected"'; ?>>A+</option>
																<option value="B+" <?php if ($data['blood'] == 'B+') echo 'selected="selected"'; ?>>B+</option>
																<option value="A-" <?php if ($data['blood'] == 'A-') echo 'selected="selected"'; ?> >A-</option>
																<option value="B+" <?php if ($data['blood'] == 'B+') echo 'selected="selected"'; ?>>B+</option>
																<option value="O+" <?php if ($data['blood'] == 'O+') echo 'selected="selected"'; ?>>O+</option>
																<option value="O-" <?php if ($data['blood'] == 'O-') echo 'selected="selected"'; ?>>O-</option>
																<option value="AB-" <?php if ($data['blood'] == 'AB-') echo 'selected="selected"'; ?>>AB-</option>
																<option value="AB+" <?php if ($data['blood'] == 'AB+') echo 'selected="selected"'; ?>>AB+</option>															</select>
														</div>


														<div class="form-group">
															<label for="fess">
															Patients DOB<span >*</span>:
															</label>
																<input type="date" name="patidob" class="form-control" required="required"  value="<?php echo htmlentities($data['Patientdob']);?>">
														</div>
														<div class="form-group">
															<label for="fess">
															Patients Email <span >*</span>:
															</label>
																<input type="email" name="email" class="form-control" required="required"  value="<?php echo htmlentities($data['PatientEmail']);?>">
														</div>														
														
														<div class="form-group">
															<label for="address">
															Patients Address<span >*</span>:
															</label>
																<textarea name="address" class="form-control" required><?php echo htmlentities($data['PatientAdd']); ?></textarea>
														</div>	
														<div class="form-group">
															<label for="newPatientPhoto">Upload New Patient Photo:</label>
															<input type="file" name="newPatientPhoto" id="newPatientPhoto" accept="image/*">
															<?php if (!empty($data['photo'])) { ?>
																<img src="<?php echo htmlentities($data['photo']); ?>" alt="Current Patient Photo" style="max-width: 200px; max-height: 200px;">
															<?php } else { ?>
																<p>No photo available</p>
															<?php } ?>
															<p class="help-block">Upload a new photo of the patient (optional).</p>
														</div>
																	<div class="form-group">
															<label for="fess">Patients Status</label>
															<select name="pati_status" class="form-control">
																<option value="active" <?php if ($data['status'] == 'active') echo 'selected="selected"'; ?>>Active</option>
																<option value="inactive" <?php if ($data['status'] == 'inactive') echo 'selected="selected"'; ?>>Inactive</option>
															</select>
														</div>			
														<div class="form-group">
															<label for="enrollment">
																Enrollment<span >*</span>:
															</label>
															<input type="text" name="enrollment" class="form-control" required="required" value="<?php echo htmlentities($data['enrollment']);?>">
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

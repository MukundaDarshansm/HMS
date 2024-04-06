<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        // Retrieve form data
        $patiname = $_POST['patiname'];
        $patiphoneno = $_POST['patiphone'];
        $pati1phoneno = $_POST['pati1phone'];
        $patidob = $_POST['patidob'];
        $pati_sex = $_POST['pati_sex'];
        $pati_blood = $_POST['pati_blood'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $status = $_POST['pati_status'];
        $enrollment = $_POST['enrollment'];

        // Check if the phone number already exists
        $check_phone_query = "SELECT * FROM tblpatient WHERE PatientContno = '$patiphoneno'";
        $check_phone_result = mysqli_query($con, $check_phone_query);
        if (mysqli_num_rows($check_phone_result) > 0) {
            echo "<script>alert('The phone number already exists. Please use a different phone number.');</script>";
        } else {
            // File upload logic
            if (!empty($_FILES['patientPhoto']['name'])) {
                $file_name = $_FILES['patientPhoto']['name'];
                $temp_name = $_FILES['patientPhoto']['tmp_name'];
                $file_type = $_FILES['patientPhoto']['type'];

                // Specify the target directory to upload the file
                $target_path = "uploads/"; // Change this to your desired directory

                // Create a unique file name to prevent conflicts
                $file_unique_name = time() . '_' . basename($file_name);

                // Set the final file path
                $target_file = $target_path . $file_unique_name;

                // Check if the file has the appropriate format (optional)
                $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
                if (in_array($file_type, $allowed_types)) {
                    // Move the uploaded file to the specified directory
                    if (move_uploaded_file($temp_name, $target_file)) {
                        // File uploaded successfully
                        $sql = mysqli_query($con, "INSERT INTO tblpatient(PatientName, PatientContno, phone_number, PatientEmail, PatientAdd, PatientGender, Patientdob, status, enrollment, blood, photo) VALUES ('$patiname','$patiphoneno','$pati1phoneno','$email','$address','$pati_sex','$patidob','$status','$enrollment','$pati_blood','$target_file')");
                        if ($sql) {
                            echo "<script>alert('Patient information added successfully');</script>";
                            echo "<script>window.location.href ='manage-patient.php'</script>";
                        } else {
                            echo "<script>alert('Error: Unable to add patient information');</script>";
                        }
                    } else {
                        echo "<script>alert('Error: Failed to upload the file.');</script>";
                    }
                } else {
                    echo "<script>alert('Error: Unsupported file format.');</script>";
                }
            } else {
                // If no file is uploaded, insert data without photo
                $sql = mysqli_query($con, "INSERT INTO tblpatient(PatientName, PatientContno, phone_number, PatientEmail, PatientAdd, PatientGender, Patientdob, status, enrollment, blood) VALUES ('$patiname','$patiphoneno','$pati1phoneno','$email','$address','$pati_sex','$patidob','$status','$enrollment','$pati_blood')");
                if ($sql) {
                    echo "<script>alert('Patient information added successfully');</script>";
                    echo "<script>window.location.href ='manage-patient.php'</script>";
                } else {
                    echo "<script>alert('Error: Unable to add patient information');</script>";
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Add Patients</title>
		
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
									<h1 class="mainTitle">Admin | Add Patients</h1>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>Admin</span>
									</li>
									<li class="active">
										<span>Add Patients</span>
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
													<h5 class="panel-title">Add Patients</h5>
												</div>
												<div class="panel-body">
									
													<form role="form" name="adddoc" method="post" onSubmit="return valid();" enctype="multipart/form-data">														
														<div class="form-group">
															<label for="Patientsname">
															Patients Name<span >*</span>:
															</label>
															<input type="text" name="patiname" class="form-control"  placeholder="Enter Patients Name" required="true">
														</div>															
														<div class="form-group">
															<label for="fess">Patients Phone Number <span >*</span>:</label>
															<input type="text" id="phoneNumberInput" name="patiphone" class="form-control"  placeholder="Enter Patients Phone Number" required="true">
														</div>
														<div class="form-group">
															<label for="fess">Patients Other Phone Number :</label>
															<input type="text" id="phoneNumber1Input" name="pati1phone" class="form-control"  placeholder="Enter Patients Other Phone Number">
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
															<label for="email">
															Patients Email:
															</label>
															<input type="email" name="email" class="form-control"  placeholder="Enter Patients Email">
														</div>
														<div class="form-group">
															<label for="address">
															Patients Address<span >*</span>:
															</label>
															<textarea name="address" class="form-control" placeholder="Enter Patient's Address" required="true"></textarea>
														</div>		
														<div class="form-group">
															<label for="address">
															Patients DOB<span >*</span>:
															</label>
															<input type="date" name="patidob" class="form-control"  placeholder="Enter Patients DOB" required="true">
														</div>	
														<div class="form-group">
															<label for="address">
															Patients Sex<span >*</span>:
															</label>
															<select name="pati_sex" class="form-control">
																<option value="Male" >Male</option>
																<option value="Female" >Female</option>
															</select>										
														</div>															
														<div class="form-group">
															<label for="patientPhoto">Upload Patient Photo:</label>
															<input type="file" name="patientPhoto" id="patientPhoto" accept="image/*">
															<p class="help-block">Please upload a photo of the patient.</p>
														</div>

														<div class="form-group">
															<label for="address">
															Patients Blood Group<span >*</span>:
															</label>
															<select name="pati_blood" class="form-control">
																<option value="A+" >A+</option>
																<option value="B+" >B+</option>
																<option value="A-" >A-</option>
																<option value="B-" >B-</option>
																<option value="O+" >O+</option>
																<option value="O-" >O-</option>
																<option value="AB+" >AB+</option>
																<option value="AB-" >AB-</option>
															</select>										
														</div>
														<div class="form-group">
															<label for="fess">Patients Status <span >*</span>:</label>
															<select name="pati_status" class="form-control">
																<option value="active" >Active</option>
																<option value="inactive" >Inactive</option>
															</select>
														</div>			
														<div class="form-group">
															<label for="enrollment">
																Enrollment<span >*</span>:
															</label>
															<input type="text" name="enrollment" class="form-control" placeholder="Enter Enrollment" required="true">
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
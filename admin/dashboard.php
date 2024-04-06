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
		<title>Admin  | Dashboard</title>
		
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
						
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Admin | Dashboard</h1>
																	</div>
								<ol class="breadcrumb">
									<li>
										<span>Admin</span>
									</li>
									<li class="active">
										<span>Dashboard</span>
									</li>
								</ol>
								
							</div>
							<a href="manage-patient.php" class="btn btn-primary">Manage Patients</a>
							
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-smile-o fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle">Manage Users</h2>
											
											<p class="links cl-effect-1">
												<a href="manage-users.php">
												<?php $result = mysqli_query($con,"SELECT * FROM users ");
													$num_rows = mysqli_num_rows($result);
													{
												?>
											Total Users :<?php echo htmlentities($num_rows);  } ?>		
												</a>
											</p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-users fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle">Manage Doctors</h2>
										
											<p class="cl-effect-1">
												<a href="manage-doctors.php">
												<?php $result1 = mysqli_query($con,"SELECT * FROM doctors ");
													$num_rows1 = mysqli_num_rows($result1);
													{
												?>
											Total Doctors :<?php echo htmlentities($num_rows1);  } ?>		
												</a>
												
											</p>
										</div>
									</div>
								</div>
								<!--div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle"> Appointments</h2>
											
											<p class="links cl-effect-1">
												<a href="book-appointment.php">
													<a href="appointment-history.php">
												<!?php $sql= mysqli_query($con,"SELECT * FROM appointment");
													$num_rows2 = mysqli_num_rows($sql);
													{
												?>
											Total Appointments :<!?php echo htmlentities($num_rows2);  } ?>	
												</a>
												</a>
											</p>
										</div>
									</div>
								</div-->

								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-smile-o fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle">Manage Patients</h2>
											
											<p class="links cl-effect-1">
												<a href="manage-patient.php">
													<?php $result = mysqli_query($con,"SELECT * FROM tblpatient ");
													$num_rows = mysqli_num_rows($result);
													{
													?>
													Total Patients :<?php echo htmlentities($num_rows);  
													} ?>		
												</a>
											</p>
										</div>
									</div>
								</div>

								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="ti-files fa-1x text-primary"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle">Total Amount Today</h2>
											
											<p class="links cl-effect-1">
												<a href="book-appointment.php">
													<a href="unread-queries.php">
												<?php 
													//$sql= mysqli_query($con,"SELECT * FROM tblcontactus where  IsRead is null");
													//$num_rows22 = mysqli_num_rows($sql);
													$totalAmountTodayQuery = mysqli_query($con, "SELECT SUM(cost) AS total_amount_today FROM patients_item WHERE date(creationDate) = CURDATE()");
													$totalAmountTodayData = mysqli_fetch_array($totalAmountTodayQuery);
													$totalAmountToday = $totalAmountTodayData['total_amount_today'];
												?>
											Total Amount Today :<?php echo $totalAmountToday ;   ?>	
												</a>
												</a>
											</p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="ti-files fa-1x text-primary"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle">Total Amount This Month</h2>
											
											<p class="links cl-effect-1">
												<a href="book-appointment.php">
													<a href="unread-queries.php">
												<?php 
												$totalAmountMonthQuery = mysqli_query($con, "SELECT SUM(cost) AS total_amount_month FROM patients_item WHERE MONTH(creationDate) = MONTH(CURDATE()) AND YEAR(creationDate) = YEAR(CURDATE())");
												$totalAmountMonthData = mysqli_fetch_array($totalAmountMonthQuery);
												$totalAmountMonth = $totalAmountMonthData['total_amount_month'];
												?>
											Total Amount This Month :<?php echo $totalAmountMonth ;   ?>	
												</a>
												</a>
											</p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="ti-files fa-1x text-primary"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle">Total Amount This Year</h2>
											
											<p class="links cl-effect-1">
												<a href="book-appointment.php">
													<a href="unread-queries.php">
												<?php 
												$totalAmountYearQuery = mysqli_query($con, "SELECT SUM(cost) AS total_amount_year FROM patients_item WHERE YEAR(creationDate) = YEAR(CURDATE())");
												$totalAmountYearData = mysqli_fetch_array($totalAmountYearQuery);
												$totalAmountYear = $totalAmountYearData['total_amount_year'];
												?>
											Total Amount This Year :<?php echo $totalAmountYear ;   ?>	
												</a>
												</a>
											</p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="ti-files fa-1x text-primary"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle">Total Patient Visit Today</h2>
											
											<p class="links cl-effect-1">
												<a href="book-appointment.php">
													<a href="unread-queries.php">
												<?php 
											$totalPatientVisitTodayQuery = mysqli_query($con, "SELECT COUNT(*) AS total_patient_visit_today FROM patients_history WHERE date(vdate) = CURDATE()");
											$totalPatientVisitTodayData = mysqli_fetch_array($totalPatientVisitTodayQuery);
											$totalPatientVisitToday = $totalPatientVisitTodayData['total_patient_visit_today'];
												?>
											Total Patient Visit Today :<?php echo $totalPatientVisitToday ;   ?>	
												</a>
												</a>
											</p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="ti-files fa-1x text-primary"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle">Total Patient Visit This Month</h2>
											
											<p class="links cl-effect-1">
												<a href="book-appointment.php">
													<a href="unread-queries.php">
												<?php 
											$totalPatientVisitMonthQuery = mysqli_query($con, "SELECT COUNT(*) AS total_patient_visit_month FROM patients_history WHERE MONTH(vdate) = MONTH(CURDATE()) AND YEAR(vdate) = YEAR(CURDATE())");
											$totalPatientVisitMonthData = mysqli_fetch_array($totalPatientVisitMonthQuery);
											$totalPatientVisitMonth = $totalPatientVisitMonthData['total_patient_visit_month'];
												?>
											Total Patient Visit This Month :<?php echo $totalPatientVisitMonth ;   ?>	
												</a>
												</a>
											</p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="ti-files fa-1x text-primary"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle">Total Patient Visit This Year</h2>
											
											<p class="links cl-effect-1">
												<a href="book-appointment.php">
													<a href="unread-queries.php">
												<?php 
											$totalPatientVisitYearQuery = mysqli_query($con, "SELECT COUNT(*) AS total_patient_visit_year FROM patients_history WHERE YEAR(vdate) = YEAR(CURDATE())");
											$totalPatientVisitYearData = mysqli_fetch_array($totalPatientVisitYearQuery);
											$totalPatientVisitYear = $totalPatientVisitYearData['total_patient_visit_year'];
												?>
											Total Patient Visit This Year :<?php echo $totalPatientVisitYear ;   ?>	
												</a>
												</a>
											</p>
										</div>
									</div>
								</div>
							</div>							
						</div>								
						
																		
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

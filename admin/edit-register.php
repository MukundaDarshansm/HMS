<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
  } else{

$did=intval($_GET['id']);// get doctor id
if(isset($_POST['submit']))
{
//$docspecialization=$_POST['Doctorspecialization'];
$regname=$_POST['regname'];
$regphoneno=$_POST['regphone'];
$regw_phone=$_POST['regw_phone'];
$regdob=$_POST['regdob'];
$reg_sex=$_POST['reg_sex'];
$email=$_POST['email'];
$address=$_POST['address'];
$doctor=$_POST['doctor'];
$regfather=$_POST['regfather'];
$referred_by=$_POST['referred_by'];
$organis=$_POST['organis'];
$register_date=$_POST['register_date'];
$sql=mysqli_query($con,"Update register set name='$regname',phone='$regphoneno',w_phone='$regw_phone',dob='$regdob',sex='$reg_sex',email='$email',address='$address',doctor='$doctor',father='$regfather',refered_by='$referred_by',organisation='$organis',reg_date='$register_date' where id='$did'");
if($sql)
{
$msg="Register Details updated Successfully";

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
													<h5 class="panel-title">Edit Register info</h5>
												</div>
												<div class="panel-body">
									<?php $sql=mysqli_query($con,"select * from register where id='$did'");
										while($data=mysqli_fetch_array($sql))
										{
										?>
										<h4><?php echo htmlentities($data['name']);?></h4>
										<p><b> Reg. Date: </b><?php echo htmlentities($data['creationDate']);?></p>
										<?php if($data['updationDate']){?>
										<p><b> Last Updation Date: </b><?php echo htmlentities($data['updationDate']);?></p>
										<?php } ?>
										<hr />
													<form role="form" name="adddoc" method="post" onSubmit="return valid();">														
														<div class="form-group">
															<label for="regname">
															 Name<span >*</span>:
															</label>
															<input type="text" name="regname" class="form-control" value="<?php echo htmlentities($data['name']);?>" >
														</div>														
														<div class="form-group">
															<label for="fess">
															 Phone Number<span >*</span>:
															</label>
																<input type="text" name="regphone" class="form-control" required="required"  value="<?php echo htmlentities($data['phone']);?>">
														</div>
														<div class="form-group">
															<label for="fess">
															WhatsApp Phone Number<span >*</span>:
															</label>
																<input type="text" name="regw_phone" class="form-control" required="required"  value="<?php echo htmlentities($data['w_phone']);?>">
														</div>
														<div class="form-group">
															<label for="fess">
																Sex<span >*</span>:
															</label>
																<input type="text" name="reg_sex" class="form-control" required="required"  value="<?php echo htmlentities($data['sex']);?>">
														</div>
														<div class="form-group">
															<label for="fess">
															DOB<span >*</span>:
															</label>
																<input type="date" name="regdob" class="form-control" required="required"  value="<?php echo htmlentities($data['dob']);?>">
														</div>
														<div class="form-group">
															<label for="fess">
															Email<span >*</span>:
															</label>
																<input type="email" name="email" class="form-control" required="required"  value="<?php echo htmlentities($data['email']);?>">
														</div>
														<div class="form-group">
															<label for="fess">
															Doctor<span >*</span>:
															</label>
																<input type="text" name="doctor" class="form-control" required="required"  value="<?php echo htmlentities($data['doctor']);?>">
														</div>
														<div class="form-group">
															<label for="fess">
															Father Or Husband<span >*</span>:
															</label>
																<input type="text" name="regfather" class="form-control" required="required"  value="<?php echo htmlentities($data['father']);?>">
														</div>
														<div class="form-group">
															<label for="address">
															Address<span >*</span>:
															</label>
																<textarea name="address" class="form-control" required><?php echo htmlentities($data['address']); ?></textarea>
														</div>
														<div class="form-group">
															<label for="fess">
															Referred By<span >*</span>:
															</label>
																<input type="text" name="referred_by" class="form-control" required="required"  value="<?php echo htmlentities($data['refered_by']);?>">
														</div>
														<div class="form-group">
															<label for="fess">
															Organisation<span >*</span>:
															</label>
																<input type="text" name="organis" class="form-control" required="required"  value="<?php echo htmlentities($data['organisation']);?>">
														</div>
														<div class="form-group">
															<label for="fess">
															Register Date<span >*</span>:
															</label>
																<input type="date" name="register_date" class="form-control" required="required"  value="<?php echo htmlentities($data['reg_date']);?>">
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

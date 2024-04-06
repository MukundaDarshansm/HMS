<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
  } else{
        if (isset($_POST['submit'])) {
            $cost = $_POST['cost'];
			$treatment = $_POST['treatment'];
			$vid=$_GET['id'];
			$View=$_GET['View'];
			$username = $_SESSION['login'];

			$query_invoice = "SELECT invoice_no FROM patients_history WHERE id = '$vid'";
			$result_invoice = mysqli_query($con, $query_invoice);
			$row_invoice = mysqli_fetch_array($result_invoice);
			$invoice_number = $row_invoice['invoice_no'];
	
            $sql = "INSERT INTO `patients_item`(`vist_id`,`patients_id`,`treatment`,`cost`,`created_by`,`invoice_no`) VALUES('$vid','$View','$treatment','$cost','$username','$invoice_number')";
            $results_insert = mysqli_query($con, $sql);
			
			if($sql)
			{
			echo "<script>alert('Patients Item info added Successfully');</script>";
			echo "<script>window.location.href ='manage-patient-items.php?id=" . $vid . "&&View=" . $View . "'</script>";
			
			}
		}
  
    
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Add  Patient Visit</title>
		
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
									<h1 class="mainTitle">Admin | Add  Patient Visit</h1>
									<h5 style="color: green; font-size:18px; ">
								<?php if($msg) { echo htmlentities($msg);}?> </h5>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>Admin</span>
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
														<label for="treatment">Treatment<span >*</span>:</label>
														<select name="treatment" id="treatment" class="form-control">
															<option value="%%">Select Treatment</option>
															<?php
																$treatment_query = mysqli_query($con, "SELECT * FROM setting");
																while ($treatment_data = mysqli_fetch_array($treatment_query)) {
																	?>
																	<option value="<?php echo htmlentities($treatment_data['treatment']); ?>">
																		<?php echo htmlentities($treatment_data['treatment']); ?>
																	</option>
																	<?php
																}
															?>
														</select>
													</div>
													<div class="form-group">
														<label for="cost">Cost<span >*</span>:</label>
														<input type="text" class="form-control" id="cost" name="cost" >
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
		<script type="text/javascript">
           $(document).ready(function() {
        $('#treatment').on("change", function() {
            var cost = $('#treatment').val();
            console.log(cost);
            
            $.ajax({
                method:"POST",
                url:"ajax.php",
                data:{
                    cost:cost
                },
                dataType:"html",
                success:function(response){
                    console.log(response);
                    $("#cost").val(response); // Change this line to set the value instead of html
                }
            });
        });
    });
    </script>
	</body>
</html>
<?php } ?>
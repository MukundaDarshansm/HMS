<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
    }
else{

    if (isset($_GET['id'])) {
        
        $visitId = $_GET['id'];     
        // Fetch item data from the database based on the item ID
        $sql_visitlineitem = "SELECT * FROM tblpatient WHERE ID='$visitId'";
        $result_visitlineitem = mysqli_query($con, $sql_visitlineitem);

        if(mysqli_num_rows($result_visitlineitem) > 0){
            $row_visitlineitem = mysqli_fetch_assoc($result_visitlineitem);
            $PatientName = $row_visitlineitem['PatientName'];
			$blood = $row_visitlineitem['blood'];
			$PatientContno = $row_visitlineitem['PatientContno'];
			$photo = $row_visitlineitem['photo'];
			$phone_number = $row_visitlineitem['phone_number'];

			$PatientGender = $row_visitlineitem['PatientGender'];
			$id = $row_visitlineitem['ID'];
		//	$blood = $row_visitlineitem['blood'];
		$Patientdob = date("d/m/Y", strtotime($row_visitlineitem['Patientdob']));

        }    
           

    }


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Id Card </title>
		
		<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
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
		<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

		<style>
    	.left-align {
       	 text-align: left;
		}
	    </style>
		<style>
			 .IdCard-box {
        max-width: 800px;
        margin: auto;
        padding: 10px; /* Adjust padding */
        border: 1px solid #eee;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
        font-size: 14px; /* Adjust font size */
        line-height: 18px; /* Adjust line height */
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
		
    }

    /* Adjust font size and padding for headings */
    .IdCard-box h2,
    .IdCard-box h3 {
        font-size: 18px;
        padding: 5px 0;
    }

    /* Adjust padding for table cells */
    .IdCard-box table td {
        padding: 2px;
        vertical-align: top;
    }

    /* Adjust font size for table content */
    .IdCard-box table p {
        font-size: 10px;
        margin: 2px 0;
    }

			.IdCard-box table tr td:nth-child(2) {
				text-align: right;
			}

			.IdCard-box table tr.top table td {
				padding-bottom: 20px;
			}

			.IdCard-box table tr.top table td.title {
				font-size: 25px;
				line-height: 45px;
				color: #333;
			}

			.IdCard-box table tr.information table td {
				padding-bottom: 40px;
			}

			.IdCard-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.IdCard-box table tr.details td {
				padding-bottom: 20px;
			}

			.IdCard-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.IdCard-box table tr.item.last td {
				border-bottom: none;
			}

			.IdCard-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.IdCard-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.IdCard-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: left;
				}
			}

			/** RTL **/
			.IdCard-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.IdCard-box.rtl table {
				text-align: right;
			}

			.IdCard-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
			
            @media print {
                body {
                    visibility: hidden;
					margin: 0; 
                }
                #element {
                    visibility: visible;
                    position: absolute;
                    left: 0;
                    top: 0;
                }
				@page { margin: 0; }
				@top-center { display: none; }
				@top-left { display: none; }
				@top-right { display: none; }
				@bottom-center { display: none; }
				@bottom-left { display: none; }
				@bottom-right { display: none; }

    /* Hide specific elements */
    .class-to-hide {
        display: none;
    }
	
	
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
									<h1 class="mainTitle">Admin | Print Id Card </h1>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>Admin</span>
									</li>
									<li class="active">
										<span>Print Id Card </span>
									</li>
								</ol>
							</div>
							<div style="text-align: left; padding-left: 20px; margin-bottom: 20px;">
								<a href="manage-patient.php" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
							</div>	
						</section>
						<div class="container-fluid container-fullw bg-white">
						    <div class="col-xl-3 float-end">
                                <a class="btn btn-light text-capitalize border-0" id="PrintIdCard" data-mdb-ripple-color="dark"><i class="fas fa-print text-primary"></i> Print</a>
                                <a class="btn btn-light text-capitalize" id="ExportInvoice" data-mdb-ripple-color="dark"><i class="far fa-file-pdf text-danger" ></i> Export</a>
                            </div>
                            <hr>                           
							<div class="container-fluid container-fullw bg-white">
								<div id="element" style="width:100%;">
									<div class="IdCard-box">
									<table style="width: 100%;">
									<tr>

									<td class="title" style="padding-bottom: 2px; width: 20%; vertical-align: top;">
										<div style="margin-bottom: -10px;">
											<img src="assets/images/logo.png" style="width: 30%;" />
										</div>
									</td>


									<td style="padding-bottom: 2px; text-align: left;">
										<h2 style="margin-top: 0; line-height: 25px;">Vasavi Health Care <br>
										<b style="line-height: 10px;">HONGIRANA TRUST (R)</b></h2>
									</td>

									</tr>
								</table>
										<hr>
										<!--h3 style="font-size: 24px; font-weight: bold;">ID Card</h3-->
										<table style="width: 100%;">
											<tr>
												<td style="text-align: left;">
													<div style="padding: 0 20px;">
														<p style="font-size: 18px; font-weight: bold;">Id : <?php echo $id; ?>,<?php echo $PatientGender; ?>,<?php echo $blood; ?></p>
														<p style="font-size: 18px; font-weight: bold;">Name : <?php echo $PatientName; ?></p>
														<p style="font-size: 18px;">DOB : <?php echo $Patientdob; ?></p>
														<p style="font-size: 18px;">Phone Number :<?php echo $PatientContno;?>,<?php echo $phone_number;?></p>
													</div>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>												    
						</div>

						<div class="container-fluid container-fullw bg-white">
							<div class="row">

							</div>
						</div>

					</div>
				</div>
			</div>

	        <?php include('include/footer.php');?>
	        <?php include('include/setting.php');?>

		</div>

		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>

		
    	<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

	    <script src="assets/js/main.js"></script>
		<script src="assets/js/form-elements.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.0/html2pdf.bundle.js"></script>
		
		<script>
    		$(document).ready(function() {
                $( "#ExportInvoice" ).on( "click", function() {
                    let element = document.getElementById('element')
                    html2pdf(element,{
                        margin:1,
                        filename:'invoice_.pdf',
                        image:{type:'jpeg',quality:0.98},
                        html2canvas:{scale:1,logging:true,dpi:192,letterRendering:true},
                        jsPDF:{unit:'mm',format:'letter',orientation:'portrait'}
                    })
                });
                $( "#PrintIdCard" ).on( "click", function() {
                    window.print();
                });    
    		});
			
		</script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>
		<!-- Your existing HTML code -->

		<!-- Your existing HTML code -->

<script>
// Simulate click on Print Invoice button
window.onload = function() {
    var printButton = document.getElementById('PrintIdCard');

    if (printButton) {
		window.print();
    }
};
</script>



	</body>
</html>
<?php } ?>
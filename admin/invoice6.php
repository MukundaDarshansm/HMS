<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
    }
else{

    if (isset($_GET['View']) && isset($_GET['id'])) {
        $patientId = $_GET['View'];
        $visitId = $_GET['id'];

        // Fetch patient data from the database based on the patient ID
        $patientQuery = mysqli_query($con, "SELECT * FROM tblpatient WHERE ID='$patientId'");
        $patientData = mysqli_fetch_assoc($patientQuery);

        $patientName = $patientData['PatientName'];
        $patientAddress = $patientData['PatientAdd'];
        $patientNumber = $patientData['PatientContno'];

        // Fetch item data from the database based on the item ID
        $sql_visitlineitem = "SELECT * FROM patients_item WHERE vist_id='$visitId'";
        $result_visitlineitem = mysqli_query($con, $sql_visitlineitem);

        if(mysqli_num_rows($result_visitlineitem) > 0){
            $row_visitlineitem = mysqli_fetch_assoc($result_visitlineitem);
            $invoice_no = $row_visitlineitem['invoice_no'];
        }    
            echo $invoice_no;
      
        $dateQuery = mysqli_query($con, "SELECT * FROM patients_history WHERE id='$visitId'");
        $dateData = mysqli_fetch_assoc($dateQuery);
        
        $vdate = $dateData['vdate'];
		$payment_mode = $dateData['payment_mode'];
        $invoicedate = date("d/m/Y", strtotime($vdate));

        $count = 1;
        $totalCost = 0;

    }


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Invoice </title>
		
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
			.invoice-box {
				max-width: 700px; /* Reduce the max-width to decrease right margin */
				margin: auto;
				padding: 5px /* Adjust padding (top/bottom remains the same, reduce right/left) */
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 10px;
				line-height: 20px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
				 

			}


			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 3px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
				padding: 2px;
				font-size: 11px;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
			
            @media print {
                body {
                    visibility: hidden;
					padding-left: 30px;
                }
                #element {
                    visibility: visible;
                    position: absolute;
                    left: 0;
                    top: 0;
                }
				@page {
    size: A5 landscape;
    margin: 0;
}


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
									<h1 class="mainTitle">Admin | Print Invoice </h1>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>Admin</span>
									</li>
									<li class="active">
										<span>Print Invoice </span>
									</li>
								</ol>
							</div>
							<div style="text-align: left; padding-left: 20px; margin-bottom: 20px;">
								<a href="manage-patient-items.php?id=<?php echo $_GET['id']; ?> && View=<?php echo $_GET['View']; ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
							</div>	
						</section>
						<div class="container-fluid container-fullw bg-white">
						    <div class="col-xl-3 float-end">
                                <a class="btn btn-light text-capitalize border-0" id="PrintInvoice" data-mdb-ripple-color="dark" ><i class="fas fa-print text-primary"></i> Print</a>
                                <button class="btn btn-light text-capitalize btn-download" data-mdb-ripple-color="dark">
									<i class="far fa-file-pdf text-danger"></i> Export
								</button>
                            </div>
                            <hr>
                            <!--Invoice Start -->
							<div id="element" style="width:100%;">
                        		<div class="invoice-box">
                        			<table cellpadding="0" cellspacing="0">
                        				<tr class="top">
                        					<td colspan="2">
                        						<table>
                        							<tr>
                        								<td class="title" style="padding-bottom: 2px;">
                        									<img
                        										src="assets/images/logo.png"
                        										style="width: 40%;"
                        									/>
                        								</td>
                        								<td style="padding-bottom: 2px; width: 60%;">
                        									<h2>Vasavi Health Care</h2>
                        									<b>HONGIRANA TRUST (R) </b><br/>
                        									BBMP Maternity Hospital Premises Palace<br />
                        									Guttahalli Circle Malleshwaram, Bangalore-560 003. <br>
															<b>Phone:</b>080-23466693/94 <br> <b>E-mail:</b>vasavihealthcare2011@gmail.com
                        								</td>
                        							</tr>
                        						</table>
                        					</td>
                        				</tr>
                        				<tr class="information">
                        					<td colspan="2">
                        						<table>
                        							<tr class="information">
														<td style="width: 50%;">
															<b>Invoice #:</b> <?php echo $invoice_no; ?><br />
															<b>Invoice Date :</b> <?php echo $invoicedate; ?>
														</td>
														<td style="text-align: right;">
															<b>Patient Name :</b> <?php echo $patientName; ?> <br />
															<b>Contact Number :</b> <?php echo $patientNumber; ?>
														</td>
													</tr>

                        						</table>
												
                        					</td>
                        				</tr>
                        				<tr class="heading">
											<td style="font-weight: bold;">Treatment Details</td>
											<td style="font-weight: bold;">Cost</td>
										</tr>


                                    <?php
                                        include('include/config.php');
                                        // Check if the id is set
                                        if (isset($_GET['id'])) {
                                            $itemId = $_GET['id'];
                                            // Perform proper validation on $itemId to prevent SQL injection
                                            $safeItemId = mysqli_real_escape_string($con, $itemId);

                                            // Fetch and display treatment details here
                                            $itemQuery = mysqli_query($con, "SELECT * FROM patients_item WHERE vist_id='$itemId'");
                                            $count = 1;
                                            $totalCost = 0;

                                            // Check if there are rows returned
                                            if (mysqli_num_rows($itemQuery) > 0) {
                                                while ($itemData = mysqli_fetch_assoc($itemQuery)) {
                                                    $treatment = htmlspecialchars($itemData['treatment']); // To prevent XSS attacks
                                                    $cost = $itemData['cost'];
                                                    $totalCost += $cost;
                                    ?>
                                    				<tr class="item">
                                    					<td><?php echo $treatment; ?></td>
                                    
                                    					<td>&#8377;<?php echo $cost; ?></td>
                                    				</tr>                                                    
                                    <?php
                                                    $count=$count+1;
                                                }
                                            } else {
                                                // Handle case when no data is found
                                                echo "<tr><td colspan='3'>No treatment data found for the visit.</td></tr>";
                                            }
                                        }
                                    ?>

                        				<tr class="total">
                        					<td>Payment Mode: <b><?php echo $payment_mode;?></b></td>
                        					<td>Total: &#8377;<?php echo $totalCost ; ?></td>
                        				</tr>
                        				<tr>
                        				    <td>Amount in Words (Rupees) : 
                                        		<script type = "text/javascript">
                                        		    var res = inWords(<?php echo $totalCost;?>);  
                                                    function inWords (num) {
                                                        var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
                                                        var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];
                                                        
                                                        if ((num = num.toString()).length > 9) return 'overflow';
                                                            n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
                                                            if (!n) return; var str = '';
                                                            str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
                                                            str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
                                                            str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
                                                            str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
                                                            str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
                                                        //return str;
                                                        return str.charAt(0).toUpperCase() + str.slice(1);
                                                    }
                                                    document.write(res);
                                         		</script>                         				    
                                            </td>
                        				</tr>
										
										<tr>
										<td>
										<br>
										
										<p  style="text-align:right;"><small>Signed and Seal :</small><br/> <b>VASAVI HEALTH CARE, HONGIRANA TRUST (R)</b></p>
										</td></tr>
                        			</table>
                        			<!--hr>
									<span class="signed-and-seal">
                        			<p>Signed and Seal :<br/> <b>VASAVI HEALTH CARE, HONGIRANA TRUST (R)</b></p>
                        			<br/>
									</span-->
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
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('#PrintInvoice').click(function() {
        var block1Content = document.getElementById('element').innerHTML;
        var printWindow = window.open('', '', 'width=800,height=500');
        if (printWindow) {
            printWindow.document.write(block1Content);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        } else {
            console.error('Print window could not be opened.');
        }
    });
    
	function printContent() {
    var block1Content = document.getElementById('element').innerHTML;
    //var printWindow = window.open('', '_blank');
   
        printWindow.document.write('<html><head><title>Print</title></head><body style="font-size: 12px; margin-left: 8mm;"><div style="padding:0.5rem 1.5rem 0.5rem 1.5rem;height:100%;">' + block1Content + '</div></body></html>');
        printWindow.document.close();
        printWindow.onload = function () {
            printWindow.print();
            printWindow.close();
        };
   
}

    $('#PrintInvoice').on('click', function() {
        printContent();
    });

    // Auto-trigger print on page load
    printContent();
});
</script>




	</body>
</html>
<?php } ?>
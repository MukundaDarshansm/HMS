<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
  } else{


$vid = $_GET['id'];
$View = $_GET['View'];

// Check if the record already exists in the patients_item table
$check_query = "SELECT * FROM patients_item WHERE vist_id = '$vid' AND patients_id = '$View'";
$check_result = mysqli_query($con, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    // echo "<script>alert('Record already exists');</script>";
    echo "<script>window.location.href ='manage-patient-items.php?id=" . $vid . "&&View=" . $View . "'</script>";
} else {
    // Fetching all treatments from the setting table where the default value is 'yes'
    $query = "SELECT cost, treatment FROM setting WHERE treat_default = 'Yes'";
    $result = mysqli_query($con, $query);

    // Loop through each fetched row and insert into the patients_item table
    while ($row = mysqli_fetch_assoc($result)) {
        // Assign fetched values to variables
        $cost = $row['cost'];
        $treatment = $row['treatment'];

        // Inserting into the patients_item table for each treatment
        $username = $_SESSION['login'];

        $query_invoice = "SELECT invoice_no FROM patients_history WHERE id = '$vid'";
        $result_invoice = mysqli_query($con, $query_invoice);
        $row_invoice = mysqli_fetch_array($result_invoice);
        $invoice_number = $row_invoice['invoice_no'];

        $sql = "INSERT INTO `patients_item`(`vist_id`,`patients_id`,`treatment`,`cost`,`created_by`,`invoice_no`) VALUES('$vid','$View','$treatment','$cost','$username','$invoice_number')";
    $results_insert = mysqli_query($con, $sql);

        if (!$results_insert) {
            echo "<script>alert('Error in inserting record');</script>";
            echo "<script>window.location.href ='manage-patient-items.php?id=" . $vid . "&&View=" . $View . "'</script>";
            exit; // Exit if there's an error in insertion
        }
    }

    // Redirect if everything is successful
    echo "<script>window.location.href ='manage-patient-items.php?id=" . $vid . "&&View=" . $View . "'</script>";
}

  }
?>

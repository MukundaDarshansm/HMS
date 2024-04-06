<?php 
include('include/config.php');

if(isset($_POST["cost"])) {
    $treatment = $_POST["cost"];
    $sql_country = "SELECT `cost` FROM `setting` where `treatment` ='$treatment'";
    $results_country = mysqli_query($con, $sql_country);
    $row_country = mysqli_fetch_array($results_country);
    $cost_val = $row_country['cost'];
    echo $cost_val;
}
?>

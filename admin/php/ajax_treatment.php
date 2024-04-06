<?php
session_start();


include_once 'dbh.php';
$request = "default";
if(isset($_POST['request'])){
    $request = $_POST['request'];
}

// DataTable data
if($request == "default"){

        $sql_customerlist="SELECT `id`,`treatment`,`cost`,`treat_default`,`status`,`creationDate`,`updationDate`  FROM `setting`;";    

    $result_customerlist=mysqli_query($conn,$sql_customerlist);
    $rows= array();
    while($row=mysqli_fetch_array($result_customerlist))
    {
        $rows[]=$row;
    }
    echo json_encode($rows);
}
/*
// Fetch user details for modal
if($request == "loadmodal"){
    $id = 0;
    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    $record = mysqli_query($conn,"SELECT * FROM contacts WHERE id=".$id);
    $response = array();

    if(mysqli_num_rows($record) > 0){
        $row = mysqli_fetch_assoc($record);
        $response = array(
            "name" => $row['name'],
            "email" => $row['email'],
            "phone" => $row['phone'],
            "address" => $row['address'],
            "city" => $row['city'],
            "pincode" => $row['pincode'],
            "state" => $row['state'],
            "dateofbirth" => $row['dateofbirth'],
            "status" => $row['status'],
            "id" => $row['id'],
        );

        echo json_encode( array("status" => 1,"data" => $response) );
        exit;
    }else{
        echo json_encode( array("status" => 0) );
        exit;
    }
}


// Insert Customer from modal
if($request == "insert"){
    $phone = "";

    if(isset($_POST['phone'])){
        $phone = mysqli_escape_string($conn,$_POST['phone']);
    }
    $record = mysqli_query($conn,"SELECT userid FROM contacts WHERE userid='".$phone."'");
    if(mysqli_num_rows($record) > 0){
        echo json_encode( array("status" => 0,"message" => "Phone Number already exists.Please use a different Phone Number") );
        exit;
    }else{
        $name = mysqli_escape_string($conn,trim($_POST['name']));
        $email = mysqli_escape_string($conn,trim($_POST['email']));
        $phone = mysqli_escape_string($conn,trim($_POST['phone']));
        $address = mysqli_escape_string($conn,trim($_POST['address']));
        $city = mysqli_escape_string($conn,trim($_POST['city']));
        $pincode = mysqli_escape_string($conn,trim($_POST['pincode']));
        $state = mysqli_escape_string($conn,trim($_POST['state']));
        $dateofbirth = mysqli_escape_string($conn,trim($_POST['dateofbirth']));
        $status = mysqli_escape_string($conn,trim($_POST['status']));
        
        $password = password_hash($phone, PASSWORD_BCRYPT);
        $auth_id = "db";

            if( $name != '' && $email != '' && $phone != '' && $address != '' && $city != '' && $pincode != '' ){
                $insertsql = "INSERT INTO contacts (`name`,`email`,`phone`,`address`,`city`,`pincode`,`state`,`dateofbirth`,`status`,`password`,`auth_id`,`userid`) VALUES ('".$name."','".$email."','".$phone."','".$address."','".$city."','".$pincode."','".$state."','".$dateofbirth."','".$status."','".$password."','".$auth_id."','".$phone."');";
                mysqli_query($conn,$insertsql);
                echo json_encode( array("status" => 1,"message" => $insertsql) );
                exit;
            }else{
                echo json_encode( array("status" => 0,"message" => "Please fill all fields...") );
                exit;
            }        

    }
}

// Update Customer from modal
if($request == "update"){
    $id = 0;
    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM contacts WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){
        $name = mysqli_escape_string($conn,trim($_POST['name']));
        $email = mysqli_escape_string($conn,trim($_POST['email']));
        $phone = mysqli_escape_string($conn,trim($_POST['phone']));
        $address = mysqli_escape_string($conn,trim($_POST['address']));
        $city = mysqli_escape_string($conn,trim($_POST['city']));
        $pincode = mysqli_escape_string($conn,trim($_POST['pincode']));
        $state = mysqli_escape_string($conn,trim($_POST['state']));
        $dateofbirth = mysqli_escape_string($conn,trim($_POST['dateofbirth']));
        $status = mysqli_escape_string($conn,trim($_POST['status']));

        
            if($name != '' && $phone != '' && $email != '' ){
                mysqli_query($conn,"UPDATE contacts SET name='".$name."',email='".$email."',phone='".$phone."',address='".$address."',city='".$city."',pincode='".$pincode."',state='".$state."',dateofbirth='".$dateofbirth."',status='".$status."'  WHERE id=".$id);
                echo json_encode( array("status" => 1,"message" => "Record updated.") );
                exit;
            }else{
                echo json_encode( array("status" => 0,"message" => "Please fill all fields.") );
                exit;
            }
        
    }else{
        echo json_encode( array("status" => 0,"message" => "Invalid ID.") );
        exit;
    }
}

// InActivate Customer
if($request == "inactivate"){
    $id = 0;
    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT `id` FROM `contacts` WHERE `id`=".$id);
    if(mysqli_num_rows($record) > 0){
        mysqli_query($conn,"UPDATE `contacts` SET `status`='inactive' WHERE `id`=".$id);
        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}

// Activate Customer
if($request == "activate"){
    $id = 0;
    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT `id` FROM `contacts` WHERE `id`=".$id);
    if(mysqli_num_rows($record) > 0){
        mysqli_query($conn,"UPDATE `contacts` SET `status`='active' WHERE `id`=".$id);
        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}

*/
?>
<?php
include(dirname(__DIR__).'/includes/connection.php');
include(dirname(__DIR__).'/constants/db.php');
include(dirname(__DIR__).'/constants/enums.php');
include(dirname(__DIR__).'/constants/regex.php');
include(dirname(__DIR__).'/constants/validation.php');
session_start();



// Run using insert queries 
$patientDetails = $_SESSION['patientDetails'];
// print_r($patientDetails);
// exit();

$firstName= $patientDetails['firstName'];
$middleName= $patientDetails['middleName'];
$lastName= $patientDetails['lastName'];
$dob= $patientDetails['dob'];
$email= $patientDetails['email'];
$gender= $patientDetails['gender'];
$maritalStatus = $patientDetails['maritalStatus'];
$bloodGroup= $patientDetails['bloodGroup'];
$password= $patientDetails['password'];
$hashedPassword = md5($password);
$address = $patientDetails['address'];
$phone = $patientDetails['telephone'];
$role= "patient";
$photo= $defaultValues['photo'].$firstName."+".$lastName;



$sql= "INSERT INTO user (firstName, middleName, lastName, email, password, bloodGroup, dob, gender, maritalStatus, role, address, phone, photo) VALUES ('$firstName',
'$middleName', '$lastName', '$email', '$hashedPassword', '$bloodGroup', '$dob', '$gender', '$maritalStatus', '$role', '$address', '$phone', '$photo')";
$resultSet= mysqli_query($conn, $sql);
$affectedRows= mysqli_affected_rows($conn);
if($affectedRows>0){
    // echo "Successfully Inserted";
    // $userDetails = ["firstName" => $firstName, "email" => $email, "role" => $role];
    // $_SESSION['userDetails']= $userDetails;
    $_SESSION['role']= $role;

    $sql1 = "SELECT * FROM user WHERE email='$email';";
    $resultSet= mysqli_query($conn, $sql1);
    $numRows= mysqli_num_rows($resultSet);
        if($numRows>0){
            $row = mysqli_fetch_assoc($resultSet);
            $_SESSION['userId']= $row['userId'];
        }

    // $data = json_encode(["userDetails"=>$userDetails]);
    
    header("HTTP/1.1 201 CREATED");
    // header('Content-Type: application/json; charset=utf-8');
    // echo $data;

    exit();

}
mysqli_close($conn);

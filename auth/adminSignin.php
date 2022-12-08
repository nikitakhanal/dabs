<?php

session_start();
include(dirname(__DIR__).'/includes/connection.php');
include(dirname(__DIR__).'/constants/regex.php');
include(dirname(__DIR__).'/constants/validation.php');

if (!isset($_POST["adminSigninDetails"])) {
    die($errorMessages["emptyData"]);
}

$email = $_POST['email'];
$password = $_POST['password'];
$hashedPassword = md5($password);

function isEmailValid($value)
{
    global $regex;
    return (preg_match($regex["email"], $value));
}

$isEmailValid = isEmailValid($email);

if (!$isEmailValid) {
    die($errorMessages['notEmail']);
}


$sql= "SELECT * FROM user WHERE email='$email' AND password='$hashedPassword'";
$resultSet= mysqli_query($conn, $sql);
// $numRows= mysqli_num_rows($resultSet);
// if($numRows>0){
if($resultSet){
    $row = mysqli_fetch_assoc($resultSet);
    // $_SESSION['firstName']= $row['firstName'];
    // $_SESSION['email']= $email;
    $_SESSION['role']= $row['role'];
    header('Location: /dabs/views/adminDashboard.php');
    exit();
}else{
    echo'<script>alert("Incorrect email or password, try again"); document.location="../admin.php"</script>';
}

mysqli_close($conn);

?>
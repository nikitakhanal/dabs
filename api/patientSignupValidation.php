<?php
include(dirname(__DIR__).'/includes/connection.php');
include(dirname(__DIR__).'/constants/db.php');
include(dirname(__DIR__).'/constants/enums.php');
include(dirname(__DIR__).'/constants/regex.php');
include(dirname(__DIR__).'/constants/validation.php');
session_start();

$errors = array();

$json = file_get_contents('php://input');
$data = json_decode($json);
$patientDetails = (array) $data; // ref: https://stackoverflow.com/a/4345609

function trimData($values)
{
    $trimmedData = array();
    foreach ($values as $key => $value) {
        if ($key == "password") {
            $trimmedData[$key] = $value;
        } else {
            $trimmedData[$key] = trim($value);
        }
    }
    return $trimmedData;
}

function toLowerCase($values)
{
    $lowerCasedData = array();
    foreach ($values as $key => $value) {
        if ($key == "password" || $key == "bloodGroup") {
            $lowerCasedData[$key] = $value;
        } else {
            $lowerCasedData[$key] = strtolower($value);
        }
    }
    return $lowerCasedData;
}

$patientDetails = toLowerCase(trimData($patientDetails));

function isAlpha($value)
{
    global $regex;
    return (preg_match($regex["alphabets"], $value));
}

function isEmailValid($value)
{   
    global $regex;
    return (preg_match($regex["email"], $value));
}

// function isEmailUnique(){
//     global $emailExists;
//     if($emailExists == 0){
//         return true;
//     }     
// }

function isDOBValid($value)
{
    global $regex;
    return (preg_match($regex["yyyy-mm-dd"], $value));
}

// function isFullNameValid($firstName, $middleName, $lastName)
// {
//     if(!empty($middleName)){
//         if (isAlpha($firstName) && isAlpha($middleName) && isAlpha($lastName)) {
//             return true;
//         }
//     }
//     else{
//         if (isAlpha($firstName) && isAlpha($lastName)) {
//             return true;
//         }
//     }
//     return false;
// }

function isPasswordValid($value)
{
    global $regex;
    return (preg_match($regex["password"], $value));
}

// validations

// $isFullNameValid = isFullNameValid($patientDetails['firstName'], $patientDetails['middleName'], $patientDetails['lastName']);
$isFirstNameValid = isAlpha($patientDetails['firstName']);
$isMiddleNameValid = isAlpha($patientDetails['middleName']);
$isLastNameValid = isAlpha($patientDetails['lastName']);
$isEmailValid = isEmailValid($patientDetails['email']);
$isDOBValid = isDOBValid($patientDetails['dob']);
$isGenderValid = in_array($patientDetails['gender'], $gender);
$isBloodGroupValid = in_array($patientDetails['bloodGroup'], $bloodGroup);
$isMaritalStatusValid = in_array($patientDetails['maritalStatus'], $maritalStatus);
$isPasswordValid = isPasswordValid($patientDetails['password']);
// $isEmailUnique = isEmailUnique();

if (!$isFirstNameValid) {
    $errors["firstName"] = "First name ". $errorMessages['notAlpha'];
}

if (!$isMiddleNameValid) {
    $errors["middleName"] = "Middle name ". $errorMessages['notAlpha'];
}

if (!$isLastNameValid) {
    // array_push($errors, array("lastName" => "Last name " . $errorMessages['notAlpha']));
    $errors["lastName"] = "Last name ". $errorMessages['notAlpha'];

}

if (!$isEmailValid) {
    // array_push($errors, array("email" => "Email " . $errorMessages['notEmail']));
    $errors["email"] = "Email " . $errorMessages['notEmail'];

}

// if(!$isEmailUnique){
//     array_push($errors, $errorMessages['repeatedEmail']);
// }

$email = $patientDetails['email'];
$query = "SELECT email FROM user WHERE email= '$email';";
$resultSet = mysqli_query($conn, $query);
$emailExists = mysqli_num_rows($resultSet);
if($emailExists > 0){
    // array_push($errors, array("email" => "Email " . $errorMessages['repeatedEmail']));
    $errors["email"] = "Email " . $errorMessages['repeatedEmail'];
}

if (!$isDOBValid) {
    // array_push($errors, array("dob" => "DOB " . $errorMessages['invalidDate']. " yyyy-mm-dd!"));
    $errors["dob"] = "DOB " . $errorMessages['invalidDate']. " yyyy-mm-dd!";
}

if (!$isGenderValid) {
    // array_push($errors, array("gender" => "Gender " . $errorMessages['notInEnum']));
    $errors["gender"] = "Gender " . $errorMessages['notInEnum'];
}

if (!$isMaritalStatusValid) {
    // array_push($errors, array("maritalStatus" => "Marital Status " . $errorMessages['notInEnum']));
    $errors["gender"] = "Gender " . $errorMessages['notInEnum'];

}

if (!$isBloodGroupValid) {
    $errors["bloodGroup"] = "Blood Group " . $errorMessages['notInEnum'];

}

if (!$isPasswordValid) {
    // array_push($errors, array("password" => $errorMessages['weakPassword']));
    $errors["password"] = "Password " . $errorMessages['weakPassword'];


}

    if(count($errors)>0){
        $data = json_encode(["errors"=>$errors]);
    
        header('Content-Type: application/json; charset=utf-8');
        echo $data;
    }else{
        $_SESSION['patientDetails']= $patientDetails;
        header('Location: ../auth/patientSignup.php');
    }


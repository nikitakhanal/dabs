<?php
include('../includes/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Appointment Booking System</title>
    <style>
      .wrapper, .wrapperTwo, .wrapperThree{
        display: flex;
        /* flex-direction: column; */
        justify-content: space-around;
        align-items: center;
      }
      .wrapperThree{
        justify-content: center;
        margin: 20px;
      }
      body{
        background-color: #f7ebec;
      }
      #print{
        text-decoration: none;
        color: #f7ebec;
        background-color: #dc3545;
        border: none;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        transition: transform 0.3s ease-in-out;
      }
      #print:hover{
        cursor: pointer;
        transform: translateY(-2px);
        box-shadow: -1px 8px 16px 0px rgba(0, 0, 0, 0.4);
      }
    </style>
<body> 


<h1 style="text-align: center; color:#dc3545;">Koshi Zonal Hospital</h1>
<hr>
<?php
if (!isset($_GET["download"])) {
    die($errorMessages["emptyData"]);
}   

$appointmentId= $_GET["appointmentId"];
$userId = $_GET["userId"];
$doctorId;

$getDoctorId = "SELECT doctorId FROM appointment WHERE appointmentId=$appointmentId AND userId=$userId;";
$resultSet = mysqli_query($conn, $getDoctorId);
          $numRows = mysqli_num_rows($resultSet);
          if($numRows > 0){
            $name = mysqli_fetch_assoc($resultSet);
            $doctorId= $name['doctorId'];
}

// echo $appointmentId." ".$userId." ".$doctorId;
// exit();


$getUser = "SELECT firstName, middleName, lastName, dob, gender FROM user WHERE userId=$userId";
$resultSet = mysqli_query($conn, $getUser);
          $numRows = mysqli_num_rows($resultSet);
          if($numRows > 0){
            $name = mysqli_fetch_assoc($resultSet);
            echo "<div class= \"wrapper\">";
            echo "<div class= \"patientInfo\">";

            echo "<h2>Patient</h2>";
            echo "<p style=\"text-transform:capitalize;\">".$name['firstName']." ".$name['middleName']." ".$name['lastName']."</p>";

            //calculating age
            $dateOfBirth = $name['dob'];
            $today = date("Y-m-d");
            $diff = date_diff(date_create($dateOfBirth), date_create($today));
            echo "<p> Age: ". $diff->format('%y')."</p>";

            echo "<p style=\"text-transform:capitalize;\"> Gender: ".$name['gender']."</p>";
            echo "</div>";
          }

$getDoctor = "SELECT firstName, middleName, lastName, specialization, nmcNo FROM (user INNER JOIN doctor ON user.userId = doctor.userId) WHERE doctorId=$doctorId;";
        $resultSet1 = mysqli_query($conn, $getDoctor);
          $numRows1 = mysqli_num_rows($resultSet1);
          if($numRows1 > 0){
            $name = mysqli_fetch_assoc($resultSet1);
            echo "<div class= \"doctorInfo\">";
            echo "<h2>Doctor</h2>";
            echo "<p style=\"text-transform:capitalize;\">".$name['firstName']." ".$name['middleName']." ".$name['lastName']."</p>";
            echo "<p style=\"text-transform:capitalize;\">".$name['specialization']."</p>";
            echo "<p style=\"text-transform:capitalize;\"> NMC No: ".$name['nmcNo']."</p>";
            echo "</div>";
          }  
          echo "</div>";
          echo "<hr>";

$appointmentInfo = "SELECT * FROM appointment WHERE appointmentId=$appointmentId;";
$resultSet1 = mysqli_query($conn, $appointmentInfo);
          $numRows1 = mysqli_num_rows($resultSet1);
          if($numRows1 > 0){
            $name = mysqli_fetch_assoc($resultSet1);
            echo "<div class= \"wrapperTwo\">";
            echo "<div class= \"appointmentInfo\">";
            echo "<h2>Appointment Details</h2>";
            echo "<p style=\"text-transform:capitalize;\"> Appointment Id: ".$name['appointmentId']."</p>";
            echo "<p style=\"text-transform:capitalize;\"> Reason: ".$name['reason']."</p>";
            echo "<p style=\"text-transform:capitalize;\"> Date: ".$name['date']."</p>";
            echo "<p style=\"text-transform:capitalize;\"> Status: ".$name['status']."</p>";
            echo "<p style=\"text-transform:capitalize;\"> TimeSlot: ".$name['timeSlot']."</p>";
            echo "<p style=\"text-transform:capitalize;\"> Token: ".$name['token']."</p>";
            echo "</div>";
            echo "</div>";
          }  
          // echo "<button onclick= \"window.print();\"> Print </button>";
          echo "<div class= \"wrapperThree\">";
          echo "<button id=\"print\" onclick= \"onClickEvent();\"> Print </button>";
          echo "<div class= \"wrapperThree\">";
?>

<script>
  function onClickEvent(){
    const button = document.getElementById("print");
    button.style.display = "none";
    window.print();
    button.style.display = "initial";

  }
</script>
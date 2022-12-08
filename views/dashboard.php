<?php
include(dirname(__DIR__) . "/includes/connection.php");
include(dirname(__DIR__) . "/timeSlot.php");
include(dirname(__DIR__) . "/includes/header.php");
session_start();
// if (count($_SESSION) == 0) {
//   header('Location: /dabs/index.php');
//   exit();
// }
if(!isset($_SESSION['role'])){
  header('Location: /dabs/index.php');
}else if($_SESSION['role']!= "patient"){
  header('Location: /dabs/index.php');
}
?>

<!-- <?php 
  // $_SESSION["firstName"] = $_POST["firstName"];
  // $_SESSION["middleName"] = $_POST["middleName"];
  // $_SESSION["lastName"] = $_POST["lastName"];
  // $_SESSION["gender"] = $_POST["gender"];
  // $_SESSION["dob"] = $_POST["dob"];
  // $_SESSION["bloodGroup"] = $_POST["bloodGroup"];
  // $_SESSION["maritalStatus"] = $_POST["maritalStatus"];
  // $_SESSION["email"] = $_POST["email"];
  // $_SESSION["password"] = $_POST["password"];
  // $_SESSION["address"] = $_POST["address"];
  // $_SESSION["telephone"] = $_POST["telephone"];
?> -->

<?php
$specialityQuery = "SELECT DISTINCT specialization FROM doctor";
$resultSet = mysqli_query($conn, $specialityQuery);
$numRows = mysqli_num_rows($resultSet);
$specializations = array();

if ($numRows > 0) {
  while ($row = mysqli_fetch_assoc($resultSet)) {
    array_push($specializations, $row["specialization"]);
  }
}
?>

<title>Dashboard</title>

</head>

<body class="dashboard">

  <nav>
    <a class="active" href="../dabs/index.php">Home</a>
    <a href="#about">About</a>
    <a href="#contact">Contact</a>
    <a href="#profile">Profile</a>
    <a href="../dabs/logout.php">Log Out</a>
  </nav>

  
  <!-- displaying dashboard as Nikita's Dashboard -->
  <h1 class="patientName"><?php echo $_SESSION['firstName'] . "'s";?> Dashboard</h1>


  <!-- creating tabs, one to view old appointments and other to book new -->
  <div class="tabs">
    <!-- <div class="tab-2"> -->
      <input class="tabsRadio" id="tab2-1" name="tabs-two" type="radio" checked="checked">
      <label for="tab2-1" class="tabLabel">Appointments</label>
      <div id="bookedAppointments" class="tabContent">
      <h4>Appointments you've booked</h4>

        <?php
          $userId = $_SESSION['userId']; // taking current user's id
          
          $doctorData= array(); 
          $appointments= array();
          $appointmentId;
          $doctorId;
          $appointmentStatus;
          $i = 0;

        // selecting all the appointments booked by the current user  
          $allAppointmentOfUser = "SELECT * FROM appointment WHERE userId = '$userId' ORDER BY date DESC;";
          $resultSet = mysqli_query($conn, $allAppointmentOfUser);
          $numRows = mysqli_num_rows($resultSet);
          if($numRows == 0){ //no appointments has been made by user
            echo "You have not booked any appointments.";
          }
          else{

          if($numRows > 0){
            // fetching all appointments made by user
              while($row = mysqli_fetch_assoc($resultSet)){
                  // $appointmentId = $row['appointmentId'];
                  // $appointmentStatus = $row['status'];
                  array_push($appointments, $row);
              }
          }

            // selecting doctor's information associated with particular appointment
            while($i< count($appointments)){
              $doctorId= $appointments[$i]['doctorId']; //doctorId in appointment table
              $doctorInfo = "SELECT * FROM (user INNER JOIN doctor ON user.userId = doctor.userId) WHERE doctorId = $doctorId;"; // doctorId in appointment table compared with doctorId in doctor table
              $resultSet = mysqli_query($conn, $doctorInfo);
              $numRows = mysqli_num_rows($resultSet);
              if($numRows > 0){
                  while($row = mysqli_fetch_assoc($resultSet)){
                      array_push($doctorData, $row);
                  }
              }
              $i++;
          }

          $timeTable = "SELECT availabilityTime FROM doctor WHERE doctorId = '$doctorId';";
          $resultSet = mysqli_query($conn, $timeTable);
          $numRows = mysqli_num_rows($resultSet);
          if($numRows > 0){
            while($row = mysqli_fetch_assoc($resultSet)){
              $availabilityTime = $row['availabilityTime'];
              }
            }
          // echo $availabilityTime;
          // exit();

          $time = getTime($availabilityTime);
          $slots = getSlots($time); // array of slots

          // $slots=  json_encode($slots);
          // $insertTimeSlot = "INSERT INTO doctorSchedule (doctorId, slots) VALUES ('$doctorId', '$slots');";
          // $resultSet= mysqli_query($conn, $insertTimeSlot);
          // $affectedRows= mysqli_affected_rows($conn);
          // if($affectedRows > 0){
          //   // echo " Successfully Inserted Into doctorSchedule";
            
          // }
          
    //inserting appointment details into table
    $count = count($appointments);
    echo "<table>
          <tr>
              <th>Doctor</th>
              <th>Appointment Id</th>
              <th>Reason</th>
              <th>Date</th>
              <th>Time</th>
              <th>Token</th>
              <th>Status</th>
              <th>Action</th>
          </tr>";

    for($i=0 ; $i < $count ; $i++){
        $appointmentId = $appointments[$i]['appointmentId'];
        $appointmentStatus = $appointments[$i]['status'];
        $fullName = $doctorData[$i]['firstName']." ".$doctorData[$i]['middleName']." ".$doctorData[$i]['lastName']; 
        echo "<tr>";
        echo "<td style=\"text-transform:capitalize;\">".  $fullName;
        echo "</td>";
        echo "<td>".  $appointments[$i]['appointmentId'];
        echo "</td>";
        echo "<td>".  $appointments[$i]['reason']; 
        echo "</td>";
        echo "<td>".  $appointments[$i]['date'];
        echo "</td>";
        echo "<td>".  $appointments[$i]['timeSlot'];
        echo "</td>";
        echo "<td>".  $appointments[$i]['token'];
        echo "</td>";
        echo "<td>".  $appointments[$i]['status']; 
        echo "</td>";
        echo "<td>
                 <form action=\"../dabs/auth/cancelAppointment.php\">
                <input type='hidden' name='appointmentId' value='$appointmentId' >";
                if($appointmentStatus == "Cancelled" || $appointmentStatus == "Declined"){
                  // echo "<button type='submit' name='cancelRequest' style='color:#000;' disabled>Cancel</button>";
                  echo "<input type='submit' name='cancelRequest' value='Cancel' disabled>";
                }else if($appointmentStatus == "Approved" || $appointmentStatus == "Pending"){
                  // echo "<button type='submit' name='cancelRequest' style='color:#000;'>Cancel</button>";
                  echo "<input type='submit' name='cancelRequest' value='Cancel'>";
                }
        echo    "</form>
              </td>";
              echo "<td>
              <form action=\"views/download.php\">
              <input type='hidden' name='appointmentId' value='$appointmentId' >
              <input type='hidden' name='userId' value='$userId' >";
              if($appointmentStatus != "Approved"){
               echo "<input type='submit' name='download' value='Download' disabled>";
              } else{
                echo "<input type='submit' name='download' value='Download'>"; 
              }
              
              echo    "</form>
              </td>";
              echo "</tr>";
    }
    echo "</table>";
  }
// exit();
?>
      </div>
    <!-- </div> -->
    
    <!-- <div class="tab-2"> -->
      <input class="tabsRadio" id="tab2-2" name="tabs-two" type="radio">
      <label for="tab2-2" class="tabLabel">New</label>
      
      <div id="bookNew" class="tabContent">
        <h4>Book a new appointment</h4>
        
        <form action="../dabs/auth/createAppointment.php" method="POST">
          <input type="hidden" name="userId" value="<?php echo $_SESSION['userId'];?>">
          <div class="appointmentFormFields">
            <div class="doctorDetails">
              
              
              <div class="formField">
                <label for="specialization">Doctor's Specialization</label>
                <select name="specialization" id="specialization">
                  <option value="">Select from dropdown</option>
                  <?php
                  foreach ($specializations as $specialization) {
                    echo "<option value=\"$specialization\">$specialization</option>";
                  }
                  ?>
                </select>
              </div>
              
              <div class="formField">
                <label for="doctor">Doctor</label>
                <select disabled name="doctorId" id="doctor">
                  <option value="">Select The Doctor</option>
                </select>
              </div>
              
              <div class="formField">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" />
              </div>

              <div class="formField">
                <label for="slot">Available Time Slot</label>
                <select disabled name="timeSlot" id="slot">
                  <option value="">Select The Slot</option>
                  <!-- php  -->
                    <!-- // for($i = 0 ; $i < count($slots) ; $i++){e
                    //   $slot =  $slots[$i];
                    //   echo "<option value=\"$slot\">".$slot."</option>";
                    //   echo " ";
                  // } -->
                  <!-- ?> -->
                </select>
              </div>
            </div>


            <div class="formFieldReason">
              <label for="reason" id="reasonLabel">Reason</label>
              <textarea disabled name="reason" id="reason" cols="30" rows="10"></textarea>
            </div>
          </div>

          <input style="width: 50vw;" type="submit" name="appointmentDetails" value="Get Appointment">
        </form>
      </div>
    <!-- </div> -->
  </div>
  <!-- </form> -->

  <script src="/dabs/js/doctorInfo.js"></script>



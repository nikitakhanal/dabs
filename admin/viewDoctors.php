<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Doctor</title>
</head>
<body>
    
</body>
</html>
<?php
include(dirname(__DIR__).'/includes/connection.php');
include(dirname(__DIR__)."/includes/header.php");
// include(dirname(__DIR__)."/includes/adminHeader.php");
include (dirname(__DIR__).'/includes/adminAuthentication.php');
?>

<html>
<body class="dashboard">  
<h2 class= "tableTitle">Doctor Details</h2>
    <table>
        <tr>
        <!-- <th>First Name</th>
        <th>Middle Name </th>
        <th>Last Name</th> -->
        <th>Full Name</th>
        <th>Specialization</th>
        <th>Degree</th>
        <th>Available Time</th>
        <th>Status</th>
        <th>NMC No</th>
        <th>Action</th>
        </tr>

<?php
$sql = "SELECT * FROM (user INNER JOIN doctor ON user.userId = doctor.userId);";
$resultSet = mysqli_query($conn, $sql);
$numRows = mysqli_num_rows($resultSet);
if($numRows > 0){
    $data= array();
    while($row = mysqli_fetch_assoc($resultSet)){
        // array_push($data, $row);
        echo "<tr>";
			// echo "<td>".$row['doctor_id']."</td>";
            echo "<td>".$row['firstName']." ".$row['middleName']." ".$row['lastName']."</td>";
			// echo "<td>".$row['firstName']."</td>";	
			// echo "<td>".$row['middleName']."</td>";							
			// echo "<td>".$row['lastName']."</td>";
			echo "<td>".$row['specialization']."</td>";
			echo "<td>".$row['degree']."</td>";
			echo "<td>".$row['availabilityTime']."</td>";
            echo "<td>".$row['status']."</td>";		
            echo "<td>".$row['nmcNo']."</td>";								
			// echo "<td>".$row['fee']."</td>";3
            $doctorId = $row['doctorId'];
            echo "<td> 
            <form action=\"../dabs/views/editDoctor.php\" method=\"GET\">
                <input type=\"hidden\" name=\"doctorId\" value=\"$doctorId\" /> 
                <input type=\"submit\" name=\"doctorUpdateDetails\" value=\"Update\" />
            </form>
            </td>";		
            echo "</tr>";
        }
    }
    ?>
    <!-- echo "<td><input hidden type='number' name='doctorId' " -->
    
</table>
</body>
</html>
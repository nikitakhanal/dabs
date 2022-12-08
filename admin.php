<?php
include(dirname(__DIR__).'/dabs/includes/connection.php');
include(dirname(__DIR__).'/dabs/includes/header.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Doctor's Appointment Booking Management System</title>
	<!-- <link rel="stylesheet" type="text/css" href="css/styles.css"> -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300,500,700&display=swap" rel="stylesheet"> -->
</head>
<body>
	<div class="main">  	

			<div class="signin">
				<form class="patientSigninForm" action="auth/adminSignin.php" method="POST">
					<label class="signinTitle" for="chk" aria-hidden="true">Sign In</label>
					<div class="fields">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="name@domain.com" required>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="password" required>
						<button class="patientSigninDetailsButton" type="submit" name="signinDetails">Sign In</button>

                        <!-- <input type="submit" name="adminSigninDetails" value="Sign In" /> -->
                    </div>
				</form>
			</div>
	</div>
</body>
</html>
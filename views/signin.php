<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Sign In</title>
</head>
<body>
    
<?php
include(dirname(__DIR__).'/includes/connection.php');
include('../includes/header.php');
?>
	
		<!-- <input type="checkbox" id="chk" aria-hidden="true"> -->

			<div class="signin">
				<form class="patientSigninForm" action="../dabs/auth/signin.php" method="POST">
					<!-- <label class="signinTitle" for="chk" aria-hidden="true">Sign In</label> -->
					<h2 class="signinTitle">Sign In</h2>
					<div class="fields">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="name@domain.com" required>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="password" required>
						<!-- <input class="button" type="submit" name="patientSigninDetails" value="Sign In" /> -->
						<button class="signinDetailsButton" type="submit" name="signinDetails">Sign In</button>
                    </div>
				</form>
			</div>
</body>
</html>
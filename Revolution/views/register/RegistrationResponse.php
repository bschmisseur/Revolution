<?php
include "../../business/UserBusinessService.php";

$userBusinessService = new UserBusinessService();

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$userName = $_POST['userName'];
$password = $_POST['password'];
$email = $_POST['email'];
$phoneNumber = $_POST['phoneNumber'];

$user = new User(0, $firstName, $lastName, $userName, $password, $email, $phoneNumber, 2);

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../../resources/css/LoginStyle.css">
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Syncopate" />
	</head>
	<body>
		<form class="login-form" action="../home/HomePage.php" method="get">
			<h2 style="font-family: Syncopate;">Login Page</h2><br/>
			<?php 		
			if($userBusinessService->createUser($user))
			{
			    $firstName = $_SESSION['currentUser']->getFirstName();
			    echo "Welcome " . $firstName . "!<br><br>";
			    echo '<input class="button" type="submit" value="Home Page">';
			}
			
			else {
			    echo "An Error had occured<br>Please return to the registration page<br><br>";
			    echo '<button class="button" formaction="RegistrationForm.html">Registration Page</button>';
			}
			?>
		</form>
	</body>
</html>
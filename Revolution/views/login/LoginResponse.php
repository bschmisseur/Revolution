<?php 
include "../../business/UserBusinessService.php";
include "../../model/ShoppingCart.php";

$userBusinessService = new UserBusinessService();

$userName = $_POST['userName'];
$password = $_POST['password'];

$user = new User(0, "", "", $userName, $password, "","", 2);

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
			if($userBusinessService->validateUser($user))
			{
			    $_SESSION['currentCart'] = new ShoppingCart();
			    $firstName = $_SESSION['currentUser']->getFirstName();
			    echo "Welcome Back " . $firstName . "!<br><br>";
			    echo '<input class="button" type="submit" value="Home Page">';
			}
			
			else {
			    echo "Invalid Credentials<br>Please return to the login page<br><br>";
			    echo '<button class="button" formaction="LoginForm.html">Login Page</button>';
			}
			?>
		</form>
	</body>
</html>
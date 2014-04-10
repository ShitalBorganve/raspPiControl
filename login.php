<?php
$errormsg = '';
if(isset($_POST['pw']))
{
	require_once('config.php');
	$pass = htmlspecialchars($_POST['pw']);
	if($adminpw == $pass)
	{
		session_start();
		$_SESSION['loggedin'] = 1;
		header('Location: index.php');
	}
	else
	{
		$errormsg = '<br />Falsches Passwort!';
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>raspBinterface - Login</title>
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>
	<div id="login">
		<form method="post" action="">
			<b>Password:</b>
			<input type="password" name="pw" /> <input type="submit" value="ok" />
		</form>
		<?php if($errormsg) { echo $errormsg; } ?>
	</div>
</body>
</html>
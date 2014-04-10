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
		$errormsg = '
        <div class="alert alert-danger">Falsches Passwort!</div>';
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>raspBinterface - Login</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/raspPiControl_login.css" rel="stylesheet">
</head>
<body>
<div id="fullscreen_bg" class="fullscreen_bg"/>

<div class="container">

	<form method="post" action="" class="form-signin">
		<h1 class="form-signin-heading text-muted">Login</h1>
        <?php if($errormsg) { echo $errormsg; } ?>
        <input type="password" class="form-control" name="pw" placeholder="Dein Passwort" />
		<button class="btn btn-lg btn-primary btn-block" type="submit">
			Einloggen
		</button>
	</form>

</div>
</body>
</html>
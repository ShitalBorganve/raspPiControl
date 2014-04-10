<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == '')
{
	header("HTTP/1.1 401 Unauthorized");
	header("Location: login.php");
	die();
}
?>
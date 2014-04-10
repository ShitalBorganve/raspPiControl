<?php
require_once('_session.inc.php');
$pid = (int) $_GET['id'];
if($pid)
{
	exec('TERM=xterm kill' . $pid);
}
header('Location: index.php#prozesse');
die();
?>
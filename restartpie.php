<?php
require_once('_session.inc.php');
exec('TERM=xterm sudo /sbin/shutdown -r 0 Reboot vom raspPiControl 2>&1', $returnvalue);
header('Location: index.php');
die();
?>
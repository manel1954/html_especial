<?php
	session_start();			
	exec("cd /home/pi/V6; sudo sh cerrar_mmdvm_30.sh");
	header("Location: panel_control.php");
?>
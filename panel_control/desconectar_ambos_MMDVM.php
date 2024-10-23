<?php
				
	exec("cd /home/pi/V30; sudo sh cerrar_bm_30.sh; sudo sh cerrar_plus_30.sh");
	header("Location: panel_control.php");
?>
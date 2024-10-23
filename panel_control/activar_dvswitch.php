<?php
exec("cd /home/pi/PI-ADER; sudo sh ejecutar_dvswitch.sh");
header("Location: panel_control.php");
?>


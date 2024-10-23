<?php
//exec("cd /home/pi/.config/autostart; sudo mv Gateway.desktop /home/pi; sudo reboot");
exec("cd /home/pi/; sudo sh cerrar_d-star.sh");
header("Location: panel_control.php");

?>


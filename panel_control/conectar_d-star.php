
<?php
exec("cd /home/pi/; sudo mv Gateway.desktop /home/pi/.config/autostart; sudo reboot");	
header("Location: panel_control.php");
?>

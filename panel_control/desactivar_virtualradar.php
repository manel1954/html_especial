<?php
        exec("cd /home/pi/PI-ADER; sudo sh cerrar_virtualradar.sh");
            exec("sudo sed -i '60c VirtualRadar=disable' /home/pi/status.ini"); 
        header("Location: panel_control.php");
?>


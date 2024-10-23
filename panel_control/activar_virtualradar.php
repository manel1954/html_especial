<?php
        exec("cd /home/pi/PI-ADER; sudo sh ejecutar_virtualradar.sh");
            exec("sed -i '60c VirtualRadar=enable' /home/pi/status.ini"); 
        header("Location: panel_control.php");
?>


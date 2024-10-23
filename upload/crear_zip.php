<?php
exec("cd /home/pi/PI-ADER; sudo sh crear_zip.sh");
header("Location: ../upload/files/Copia_PI-ADER.zip");
?>

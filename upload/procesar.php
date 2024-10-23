<?php
exec("sudo rm /var/www/html/upload/files/Copia_PI-ADER.zip");
$archivo = ($_FILES['archivo_fls'] ['tmp_name']);

if (($_FILES["archivo_fls"] ["name"]) == "Copia_PI-ADER.zip"){


$destino = "files/".$_FILES["archivo_fls"] ["name"];
move_uploaded_file($archivo,$destino);
exec("cd /home/pi/PI-ADER; sudo sh restaurar.sh");
header("Location: ../panel_control/panel_control.php");
}
else{
header("Location: fichero_no_valido.php");
}
?>


<?php
session_start();

$pass =($_POST['pass']);

//$pass="ea3eiz";
exec("sed -i '5c \$mipass=\"$pass\"\;' /var/www/html/dentro.php");
header("Location:../index.php");
?>

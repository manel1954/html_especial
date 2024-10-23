<?php  	
session_start();
//$passIng = strip_tags(sha1($_POST['pass']));
$passIng =($_POST['pass']);
$mipass="ader";
if ($passIng==$mipass){
$_SESSION['permisos'] = 1;
header("Location:/panel_control/panel_control.php");	
}
else{
header("Location:index.php");
}
?>
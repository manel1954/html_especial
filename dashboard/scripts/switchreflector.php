<?php
//ea4gkq
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

// do not touch this includes!!! Never ever!!!
include "../config/config.php";
include "../include/tools.php";
include "../include/functions.php";

//Some basic inits
$mmdvmconfigs = getMMDVMConfig();
if (!defined("MMDVMLOGPREFIX"))
   define("MMDVMLOGPREFIX", getConfigItem("Log", "FileRoot", $mmdvmconfigs));
if (!defined("TIMEZONE"))
   define("TIMEZONE", "UTC");

if (!isset($_SERVER['PHP_AUTH_USER']) && SWITCHNETWORKUSER !== "" && SWITCHNETWORKPW !== "") {
    header('WWW-Authenticate: Basic realm="Dashboard"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Zur Ausführung bitte die geforderten Login-Daten eingeben!';
    exit;
} else {
   if ($_SERVER['PHP_AUTH_USER'] == SWITCHNETWORKUSER && $_SERVER['PHP_AUTH_PW'] == SWITCHNETWORKPW) {
   $fileName = MMDVMLOGPATH."/".MMDVMLOGPREFIX."-".date("Y-m-d").".log";
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Das neueste kompilierte und minimierte CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- Optionales Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <meta http-equiv="refresh" content="10; URL=../">
    <title><?php echo getCallsign($mmdvmconfigs) ?> - MMDVM-Dashboard by DG9VH</title>

  </head>
  <body>
  <div class="page-header">
  <h1><small>MMDVM-Dashboard by DG9VH for <?php
  if (getConfigItem("General", "Duplex", $mmdvmconfigs) == "1") {
   echo "Repeater";
  } else {
   echo "Hotspot";
  }
  ?>:</small>  <?php echo getCallsign($mmdvmconfigs) ?></h1>
  <h4>MMDVMHost by G4KLX Version: <?php echo getMMDVMHostVersion() ?></h4>
  <button onclick="window.location.href='../index.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Home</button>

  </script>
</div>
<?php
$reflektor_nr=$_GET['reflector'];
checkSetup();
//include "../include/sysinfo.php";
exec( "sudo /bin/sed '/#Options/d' -i ".MMDVMINIPATH."/".MMDVMINIFILENAME);
exec( "sudo /bin/sed 's/Options=StartRef=.*$/Options=StartRef=".$reflektor_nr.";RelinkTime=20;Userlink=1;/' -i ".MMDVMINIPATH."/".MMDVMINIFILENAME);
exec( REBOOTMMDVM );

// /bin/sed '/#Options/d' -i /opt/MMDVMHost/MMDVM.ini
// #dann
// /bin/sed 's/Options=StartRef=.*$/Options=StartRef='"$Reflektor"';RelinkTime=22;Userlink=1;/' -i /opt/MMDVMHost/MMDVM.ini

?>
<div class="alert alert-info" role="alert">Switching reflector to <b><?php echo $reflektor_nr; ?></b><br>Restarting in new selected network in progress</div>
 
   <div class="panel panel-info">

<?php

$datum = date("d-m-Y");
$uhrzeit = date("H:i:s");
echo "Last Update $datum, $uhrzeit";
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<!--Page generated in '.$total_time.' seconds.-->';
      } else {

    header('WWW-Authenticate: Basic realm="Dashboard"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Zur Ausführung bitte die geforderten Login-Daten eingeben!';
    exit;
      }
   }
?> | get your own at: <a href="https://github.com/dg9vh/MMDVMHost-Dashboard">https://github.com/dg9vh/MMDVMHost-Dashboard</a>
   </div>
  </body>
</html>

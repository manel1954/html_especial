
<?php


$ip = exec('awk "NR==10{print;exit}" /home/pi/info.ini');
$dashboard_vrs="http://".$ip.":8090/VirtualRadar";
$editar_vrs="http://".$ip.":8090/VirtualRadar/WebAdmin/Settings.html";

// ==============================================================================
$Callsign = exec('awk "NR==1{print;exit}" /home/pi/info_panel_control.ini');
$Callsign = substr($Callsign, 9, 9);

$Id = exec('awk "NR==2{print;exit}" /home/pi/info_panel_control.ini');
$Id = substr($Id, 3, 9);

$frecuencia = exec('awk "NR==3{print;exit}" /home/pi/info_panel_control.ini');
$frecuencia = " FR: " . substr($frecuencia, 12, 9);

$Address = exec('awk "NR==4{print;exit}" /home/pi/info_panel_control.ini');
$Address = substr($Address, 0, 40);
// ==============================================================================

// ==============================================================================
$Callsign_plus = exec('awk "NR==11{print;exit}" /home/pi/info_panel_control.ini');
$Callsign_plus = substr($Callsign_plus, 9, 9);

$Id_plus = exec('awk "NR==12{print;exit}" /home/pi/info_panel_control.ini');
$Id_plus = substr($Id_plus, 3, 9);

$frecuencia_plus = exec('awk "NR==13{print;exit}" /home/pi/info_panel_control.ini');
$frecuencia_plus = " FR: " . substr($frecuencia_plus, 12, 9);

$Address_plus = exec('awk "NR==14{print;exit}" /home/pi/info_panel_control.ini');
$Address_plus = substr($Address_plus, 0, 40);
// ==============================================================================

// ==============================================================================
$Callsign_Radio = exec('awk "NR==6{print;exit}" /home/pi/info_panel_control.ini');
$Callsign_Radio = substr($Callsign_Radio, 9, 9);

$Id_Radio = exec('awk "NR==7{print;exit}" /home/pi/info_panel_control.ini');
$Id_Radio = substr($Id_Radio, 3, 9);

$frecuencia_Radio = exec('awk "NR==8{print;exit}" /home/pi/info_panel_control.ini');
$frecuencia_Radio = " FR: " . substr($frecuencia_Radio, 12, 9);

$Address_Radio = exec('awk "NR==9{print;exit}" /home/pi/info_panel_control.ini');
$Address_Radio = substr($Address_Radio, 0, 40);
// ==============================================================================

// ==============================================================================
$ysfr = exec('awk "NR==21{print;exit}" /home/pi/info_panel_control.ini');
$ysfr = " YSFReflector: " . substr($ysfr, 8, 15);
// ==============================================================================

// ==============================================================================
$svxlink = exec('awk "NR==27{print;exit}" /home/pi/info_panel_control.ini');
$svxlink = " SVXLINK: " . substr($svxlink, 10, 19);
// ==============================================================================

// ==============================================================================
$frecuencia_2dmr = exec('awk "NR==24{print;exit}" /home/pi/info_panel_control.ini');
$frecuencia_2dmr = " FR: " . substr($frecuencia_2dmr, 12, 9);

$Address_2dmr = exec('awk "NR==25{print;exit}" /home/pi/info_panel_control.ini');
$Address_2dmr = substr($Address_2dmr, 0, 40);

$tg = exec('awk "NR==26{print;exit}" /home/pi/info_panel_control.ini');
$tg = " TG: " . substr($tg, 13, 10);
?>

<!-- ============================================================================== -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="ea3eiz echolink Conferencia 3spain">
    <meta name="description" content="Conferencia echolink libre para todos los radioaficionados con indicativo">
    <meta name="author" content="EA3EIZ">


<!-- refresca la página cada 10 segundo (implantado por mi) -->
<!-- ====================================================== -->
<meta http-equiv="refresh" content="5" />



    <link rel="shortcut icon" href="imagenes/favicon.png">
<title>Panel Control</title>

            <link rel="stylesheet" href="css/bootstrap.min.css" >
            <link rel="stylesheet" href="css/custom.css" >
            <style type="text/css">
              .texto_azul_negro{
                color:#FB6C03;
                font-weight: bold;  
                font-size:  18 px;
              }
              .texto_verde_rojo{
                background:#0CE362;
                color:#FD0404;
                font-weight: bold;  
                font-size:  16 px;
                }
                .alert-danger{
                  height: 45px;
                  padding-top: 1px;
                  color:#0000FF;
                }
              
            </style>

</head>

<body>

<div class="franja_superior">
<div class="container">

<div class="col-md-12 text-center">
<a href="http://associacioader.com" target="_blank"><img src="../img/Logo_Ader.png" width="150"></img></a>
                   <span class="color_blanco_header"></span>
                </div>
</div>  
</div>


<hr>				
<div class="container">
<div class="row"> 
                <div class="col-md-12 text-center">
                   <span class="color_naranja">PANEL DE CONTROL</span><br><br><br>
                </div>
</div><!-- row -->




<div class="row">                  

                    <div  class="col-md-4 text-center thumbnail"><br>
                          <img src="imagenes/BACKUP.png" width="95" ></img><br>
                         <a href="../upload/crear_zip.php" class="btn btn-info btn-sm">HACER COPIA SEGURIDAD</a>
                     </div>
                     
                     <div  class="col-md-4 text-center thumbnail"><br>
                         <img src="imagenes/BACKUP.png" width="95" ></img><br>
                         <a href="../upload/form.php" class="btn btn-success btn-sm">RESTAURAR COPIA SEGURIDAD</a>
                     </div>
             
              <div class="col-md-4 text-center thumbnail"><br>
                <img src="../img/logo_dvswitch.png" width="170" ></img><br>
                <a href="../index.php" class="btn btn-success btn-sm">ABRIR DVSWITCH DASHBOARD</a>
              </div>
</div><!-- row -->    


<div class="row">  
<div  class="col-md-4"></div>
      


        <div  class="col-md-4 text-center thumbnail"><br>
                         <img src="../img/HBLINK_logoV2.png" width="319" ></img><br>
                          <a href="../index_dashboard.php" class="btn btn-warning btn-sm">HBlink`DASHBOARDLINK3</a>
                     </div>

 </div><!-- row -->                    
<!-- ============================================================================================= -->





<!-- FIN BLOQUE 3 ============================================================================= -->
<br>
</div><!-- container -->
<br>
<br>
<br>
<br>

<!-- JavaScript================================================== -->
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
	</body>
<html>

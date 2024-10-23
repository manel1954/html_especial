<?php
session_start();
$nombre=$_SESSION['miSession'] ['usuario'];
?>
<!doctype html>
<html>
<head>

    <meta charset="UTF-8"> 
  <meta http-equiv="content-type" content="text/html">
  <meta name="author" content="Manuel Díaz">
        <link rel="shortcut icon" href="imagenes/favicon.png" type="image/x-icon" />
<meta http-equiv="refresh" content="10; url=/panel_control/panel_control.php" />
  <title>ader</title>
    
            <link rel="stylesheet"href="css/bootstrap.min.css" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>


    <style>
  
  body{
    background:#333;
    }

.texto_centrado_verde{
  color:#0C0;
  font-size:30px;
  }

    </style>
</head>
<body>


  <!--  ==============  INICIO CAJA LOGIN =====================  -->  
 <div class="container"> 
 <br><br>
        <div class="row">
           <div class="col-md-6 col-md-offset-2">
                 <p class="texto_centrado_verde"><?php echo $nombre;?> &nbsp;&nbsp;-  &nbsp;&nbsp;&nbsp;ESTE FICHERO NO ES VALIDO</p>
                 <p class="texto_centrado_verde"><?php echo $nombre;?> &nbsp;&nbsp;-  &nbsp;&nbsp;&nbsp;SOLO ADMITE EL FICHERO:</p>
                 <p class="texto_centrado_verde"><?php echo $nombre;?> &nbsp;&nbsp;-  &nbsp;&nbsp;&nbsp;Copia_PI-ADER.zip</p>
                       <hr/>
                </div>
        </div><!--row-->


        
<!--                <div class="row">
           <div class="col-md-6 col-md-offset-2">
                 <div id="inner"<p class="texto_centrado_verde"><?php echo $nombre?> DESDE EL APARATADO ( DESCARGAS )</p></div>
                       <hr/>
                </div>
-->        </div><!--row-->

</div><!--container-->
    <!-- JavaScript================================================== -->
    <script src="js/bootstrap.min.js"></script>
 

</body>
</html>
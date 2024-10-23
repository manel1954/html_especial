<?php



$user =$_GET[ 'user']; // recoge el usuario



?>
<!doctype html>
<html>
<head>

    <meta charset="UTF-8">
	<meta http-equiv="content-type" content="text/html">
	<meta name="author" content="Manuel Díaz">
        <link rel="shortcut icon" href="imagenes/favicon.png" type="image/x-icon" />
<meta http-equiv="refresh" content="5; url=../menu_opciones.php" />
	<title>3spain</title>

            <link rel="stylesheet"href="css/bootstrap.min.css" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>


    <style>

	body{
		background:#333;
		}

.texto_centrado{
	color:#6AC61A;
	font-size:30px;


	}

    </style>
</head>
<body>


  <!--  ==============  INICIO CAJA LOGIN =====================  -->
 <div class="container">

 <br><br>
  <div class="row">

  			<div class="col-md-12 text-center">

                        <div id="inner"<p class="texto_centrado"><?php echo $user?>Usuario no registrado</div>

                            <hr/>

</div>
</div>
    <!-- JavaScript================================================== -->
    <script src="js/bootstrap.min.js"></script>


</body>
</html>
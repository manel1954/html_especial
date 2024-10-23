<!doctype html>
<html>
<head>
  <meta charset="UTF-8"> 
  <meta http-equiv="content-type" content="text/html">
  <meta name="author" content="Manuel Díaz">
  <link rel="shortcut icon" href="imagenes/favicon.png" type="image/x-icon" />
  <title>Formm</title>
  <link rel="stylesheet" href="../../css/bootstrap.min.css" >
<style type="text/css">
	.caja{
		background: #0A4CF5;
		width: 60px;
		height: 30px;
	}
	.caja1{
		background: #F56E0A;
		width: 360px;
		height: 40px;
	}
</style>
</head>
<body>
	<dir class="container">
	<h4>Escoge el fichero con el nombre:<h2>Copia_PI-ADER.zip</h2></h4>
	<h4>*** Cualquier otro fichero no vale ***</h4>
	<div class="row">
	<form  action="procesar.php" method="post" enctype="multipart/form-data">
		<div class="col-md-4 text-center thumbnail">
		<input  class="text-center" type="file" name="archivo_fls"></input>
		</div>
	</div>

	<div class="row">	
		<div class="col-md-4 text-center">
		<input class="btn btn-success" type="submit" value="Restaurar"></input>
		</div>
	</div>	
	</form>
</dir>


</body>
</html>
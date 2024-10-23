
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="ea3eiz echolink Conferencia 3spain">
    <meta name="description" content="Conferencia echolink libre para todos los radioaficionados con indicativo">
    <meta name="author" content="EA3EIZ">

    <link rel="shortcut icon" href="imagenes/favicon.png">
    <title>Panel Ea3eiz</title>

    <!-- CSS Bootstrap-->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="custom/bootstrap/css/bootstrap.css" rel="stylesheet">
    
<style type="text/css">
p{
font-size:18px;
}  
body{
    background:#cccccc;
}
   /*   ========   PARAMETROS CAJA LOGIN ========================================*/
   .caja_login{
    position:fixed;
    width:350px;
    top:100px;
    text-align:center;
    margin-top: 20px;
    padding: 0px 0px 0px 0px;
    background-color: #4C4C4C;
    transition: all linear 0.55s;
    -ms-transition: all linear 0.55s;
    -moz-transition: all linear 0.55s;
    -webkit-transition: all linear 0.55s;
    -o-transition: all linear 0.55s;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
   border-radius: 5px 5px 5px 5px;
   z-index:1000;
}

/*  ========   FIN PARAMETROS CAJA LOGIN ========================================*/
</style>

</head>

<body>
				
<div class="container">
                <div class="col-md-12 text-center">
                   <h2 class="color_naranja">Cambia el password para entrar al PANEL DE CONTROL</h2><br><br><br>
                </div>   
</div><!-- container -->

<!-- ============================================================================================= -->




<!--============== CAJA LOGIN ====================================-->
<div class="container">
        <div class="row">

            <div class="col-md-12 text-center">
                <div class="caja_login panel-default">
                    <div class="panel-body">
                        <p><img src="Logo_Ader.png" height="40"></p>
     <form method="post" action="cambio_password.php">

                           
                    <div class="form-group">
                          <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <input name="pass" id="pass"type="password" class="form-control" placeholder="Password:" required>
                          </div>
                    </div>
                <button class="btn btn-lg btn-success btn-block" type="submit">
                    Entrar</button>

                        </form>

              </div><!-- "col-md-4 -->
           </div>
        </div><!-- row -->
</div><!-- container -->


<!--============== FIN CAJA LOGIN ====================== -->

<!-- JavaScript================================================== -->
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>

</body>
</html>
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="ea3eiz echolink Conferencia 3spain">
    <meta name="description" content="Conferencia echolink libre para todos los radioaficionados con indicativo">
    <meta name="author" content="Ma-dis">
    <link rel="shortcut icon" href="imagenes/favicon.png">
<title>Dashboard</title>

            <link rel="stylesheet" href="../css/bootstrap.min.css" >
            <link rel="stylesheet" href="../css/style_parallax.css" />
            <link rel="stylesheet" href="../css/custom.css"/>
            <link rel="stylesheet" href="../bootstrap-lightbox.css"/>






  <style type="text/css">
 body{
      background-image:url(img/FIRMAMENTO.jpg)}
.carousel-caption{position:absolute;left:15%;right:15%;bottom:20px;z-index:10;padding-top:20px;padding-bottom:20px;color:#fff;text-align:center;text-shadow:0 1px 2px rgba(0,0,0,.6)}
.propagacion{
	background-image:url(imagenes/movil_propagacion.png);
    width:314px;
    height:600px;
	padding:100px 0px 0px 80px;
}
.texto_blanco{
color:#FFFFFF;
}

.texto_naranja{
color:#F8601B;
font-size:20px;
}

#stellar_img_04 {
    background-image:url(imagenes/parallax4.jpg);
}
h1{
  color:#F99F2A;
  font-size: 30px;
}
a:link{
font-size:30px;
}
a {

}
a:visited {
color:orange;
}
a:hover {
color:white;
}
a:active {

}
.text-center{
text-align:center;
}
</style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

 <div><a href="##" class="navbar-header">&nbsp;&nbsp;&nbsp;<img src="img/Logo_Ader.png" width="130" alt=""</a></div>

              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only"> <a href="##" onClick="cerrar_menu();"</a>Togle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>

              <div class="container">

<div class="row">
<div class="col-md-3"></div>
<div class="col-md-6">  
<a href="../../panel_control/panel_control.php" class="color_orange text-center">VOLVER A PANEL DE CONTROL</a>
</div>
</div>

              
            </div>
            <div class="navbar-collapse collapse">
            </div>
</nav>

<br><br><br><br>

<!-- CONTENIDO ============================================== -->
<section class="contenido"><!--contenido ==================== -->
<!--  ======================================================= -->
<div class="container">

<div class="row">

</div>

<!-- <br><br> -->

<div class="row">
<div class="col-md-12 thumbnail">
 <iframe align="top" frameborder="2" height="1800" scrolling="yes" src="index.php" width="1160"></iframe>
</div>
</div>
</div>
<br><br><br><br><br><br><br><br><br><br>
<!-- =================FIN  PARALLAX LINKS CONECTADOS ======================= -->



<!-- FIN  DEL CONTAINER ==================================== -->
</section><!--contenido ==================================== -->
<!--  ======================================================= -->


<!-- FOOTER ==================================== -->
<div class="container">
 <hr class="featurette-divider"></hr>
      <footer>
<p class="ir-arriba pull-right"><a href="#"><span class="glyphicon glyphicon-arrow-up"></span></a></p>

        <p class="texto_naranja">&copy; Imagen PI-ADER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Design by:&nbsp;&nbsp;<a href="http://www.ea3eiz.com/DMR/index.php" target="_blank">&nbsp;( EA3EIZ )</a></p>
      </footer>
  </div> <!--container-->
<!-- FIN  DEL FOOTER ==================================== -->



    <!-- JavaScript================================================== -->
    <script src="../js/jquery-1.11.2.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/parallax.js"></script>
    <script src="../js/jquery.stellar.min.js"></script>
    <script src="../bootstrap-lightbox.js"></script>


    <!--====   ABRE CAJA LOGIN  ======-->
 <script type="text/javascript">
function abre_caja(){
    $(".caja_login").css("top","35px");
}
	</script>
 <!--====   FIN ABRE CAJA LOGIN  ======-->

  <!--====   CIERRA CAJA LOGIN  ======-->
<script type="text/javascript">
function cerrar_caja(){
    $(".caja_login").css("top","-350px");
}	</script>
 <!--====   FIN CIERRA CAJA LOGIN  ======-->

<!--====   INICIAR EL SLIDER  ======-->
<script type="text/jscript">
    $(document).ready(function(){
        $('#myCarousel').carousel({
            interval: 3000
        });
    });
</script>
<!--====   FIN INICIAR EL SLIDER  ======-->


<!--====   CERRAR Y ABRIR MENU MOVIL ======-->
 <script type="text/jscript">
    function cerrar_menu(){
        $('.navbar-collapse').toggle("hiden");
    }

</script>
 <script type="text/jscript">
$(document).ready(function(){
	$('.ir-arriba').click(function(){
		$('body, html').animate({
			scrollTop: '0px'
		}, 300);
	});

	$(window).scroll(function(){
		if( $(this).scrollTop() > 0 ){
			$('.ir-arriba').slideDown(300);
		} else {
			$('.ir-arriba').slideUp(300);
		}
	});



	$(window).scroll(function(){
		if( $(this).scrollTop() > 0 ){
    $(".caja_login").css("top","-500px");
		}
	});






$('.propaga').click(function(){
		$('body, html').animate({
			scrollTop: '600px'
		}, 300);
	});

	$('.servi').click(function(){
		$('body, html').animate({
			scrollTop: '1500px'
		}, 300);
	});

 	$('.descarga').click(function(){
		$('body, html').animate({
			scrollTop: '2150px'
		}, 300);
	});



 $('.lin').click(function(){
		$('body, html').animate({
			scrollTop: '3750px'
		}, 300);
	});





});
</script>

<script type="text/javascript">
$.stellar({
    horizontalScrolling: false,
    responsive: true
});
</script>


</body>
</html>

function pregunta_apagar_dispositivo()
                {
                if(confirm("Estas seguro de apagar el dispositivo?"))
                document.location.href="apagar_maquina.php";
                else
                alert('Has pulsado Cancelar, click en Aceptar para volver');  
                }


function pregunta_reinicio_dispositivo()
                {
                if(confirm("Estas seguro de reiniciar el dispositivo?"))
                document.location.href="reiniciar_maquina.php";
                else
                alert('Has pulsado Cancelar, click en Aceptar para volver');  
                }



function activar_dvswitch() {
                document.location.href="activar_dvswitch.php"; 
        }


function desconectar_bm() {
               document.location.href="desconectar_MMDVMBM.php";              
        }

function conectar_plus() {
            document.location.href="conectar_MMDVMPLUS.php";
        }


function desconectar_radio() {
               document.location.href="desconectar_Radio.php";              
        }

function conectar_radio() {
            document.location.href="conectar_Radio.php";
        }


function desconectar_plus() {
               document.location.href="desconectar_MMDVMPLUS.php";              
        }





function conectar_dv4mini() {
  

            document.location.href="conectar_dv4mini.php";

        }


function desconectar_dv4mini() {
        

            document.location.href="desconectar_dv4mini.php";

        }

function desconectar_dstar() {
            document.location.href="desconectar_d-star.php";
        }
function conectar_dstar() {
            document.location.href="conectar_d-star.php";
        }
 
 function desconectar_ysf() {
            document.location.href="desconectar_ysf.php";
        } 
function conectar_ysf() {
            document.location.href="conectar_ysf.php";
        }
function desconectar_mmdvm() {
            document.location.href="desconectar_MMDVM.php";
        }

function conectar_mmdvm() {
            document.location.href="conectar_MMDVM.php";
        }
function cerrar_svxlink() {
 
            document.location.href="cerrar_svxlink.php";

        }
function iniciar_svxlink() {
  
            document.location.href="iniciar_svxlink.php";
        }

function cerrar_ysf2dmr() {
 
            document.location.href="desconectar_ysf2dmr.php";

        }
function iniciar_ysf2dmr() {
  
            document.location.href="conectar_ysf2dmr.php";
        }

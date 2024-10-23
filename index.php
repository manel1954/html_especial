<?php
  include_once 'include/config.php';
  include_once 'include/tools.php';
  include_once 'include/functions.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" lang="en">
<head>
    <meta name="robots" content="index" />
    <meta name="robots" content="follow" />
    <meta name="language" content="English" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="generator" content="DVSwitch" />
    <meta name="Author" content="Andrew Taylor (MW0MWZ), Waldek (SP2ONG)" />
    <meta name="Description" content="Dashboard based on Pi-Star Dashboard, © Andy Taylor (MW0MWZ) and adapted to DVSwitch by SP2ONG" />
    <meta name="KeyWords" content="MMDVM_Bridge,Analog_Bridge,ircDDBGateway,D-Star,ircDDB,DMRGateway,DMR,YSFGateway,YSF,C4FM,NXDNGateway,NXDN,P25Gateway,P25,DVSwitch,DL5DI,DG9VH,MW0MWZ,SP2ONG" />
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <link rel="shortcut icon" href="images/favicon.ico" sizes="16x16 32x32" type="image/png">

    <title>DVSwitch Dashboard & EasyUI</title>
    <?php include_once "include/browserdetect.php"; ?>

    <script type="text/javascript" src="scripts/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/functions.js"></script>
    <script type="text/javascript" src="scripts/pcm-player.min.js"></script>
    <script type="text/javascript"> $.ajaxSetup({ cache: false }); </script>
    <link href="css/featherlight.css" type="text/css" rel="stylesheet" />
    <script src="scripts/featherlight.js" type="text/javascript" charset="utf-8"></script>
    <script>
      function dp_menu_tg(){
        let click = document.getElementById("drop-content");
        if   (click.style.display === "none"){click.style.display = "block";}
        else {click.style.display   = "none";}
      }
    </script>
    <script>
      function dp_menu_user(){
        let click = document.getElementById("drop-content-user");
        if   (click.style.display === "none"){click.style.display = "block";}
        else {click.style.display   = "none";}
      }
    </script>
    <script> window.onload = function(){rx_mon_on.click();} </script>

<style type="text/css">
.link {background-color: #2A6594; outline:none;}
.link_rojo {background-color: #f00000; outline:none;}
.link_granate {background-color: #dc143c; outline:none;}
.link_negro {background-color: #000000; outline:none;}
.link_verde {background-color: #4D994A; outline:none;}
.link_verde_claro {background-color: #8FFF1D; outline:none;}
.link_naranja {background-color: #d9540c; outline:none;}
.link_dstar {background-color: rgb(12, 235, 142); outline:none;}
.link_nxdn {background-color: rgb(247, 99, 239); outline:none;}
.link_ysf {background-color: rgb(240, 142, 202); outline:none;}
.link_especial {background-color:rgb(36, 162, 235); outline:none;}
.link_especial {background-color:rgb(36, 66, 235); outline:none;}
.link:hover {background-color: #3a87cd; outline:none;}
.blink {background-color: #b00; outline:none; color:white}
.blink:hover {background-color: #ff5722; outline:none;color:white}
</style>

</head>

<!-- <body style="background-color: #f8f8f8f8;font: 11pt arial, sans-serif;"> -->
<body style="background-image: url(img/fondo_02.png);font: 11pt arial, sans-serif;">
 
<center>
  <fieldset style="box-shadow:0 0 10px #999; background-color:#fafafa; width:0px;margin-top:5px;margin-left:0px;margin-right:5px;font-size:13px;
                   border-top-left-radius: 10px; border-top-right-radius: 10px;border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
    <div class="container">
    <div class="header">
      <center>
        <span class="dvs"  ><b> DVSwitch Dashboard & EasyUI </font></span>
      </center>
    </div>
    <div class="content"><center>
      <div style="margin-top:8px;">
        <?php
          ob_start();

          // read dvsMU info
          if (isset($_GET['user'])) {$user=$_GET['user'];} else {$user='MAIN';}
          if (isset($_GET['exec'])) {$exec=$_GET['exec'];} else {$exec=' - ';}
          if ($user=='MAIN') {$user_no='';} else {$user_no=substr($user, -2);}
          $br = '<br>';
          $muInfo      = dvsmu_info($user);
          $path        = '/opt/'.str_replace('MAIN', 'MMDVM_Bridge', $user);
          $DVSH        = $path.'/dvswitch.sh';
          $rxPort      = $muInfo[$user]['rxPort'];
          $cur_tg      = $muInfo[$user]['tg'];
          $file_ABInfo = '/tmp/ABInfo_'.$rxPort.'.json';
          $ABINFO      = json_rw('R', $file_ABInfo);
          $ambe_mode   = $ABINFO['tlv']['ambe_mode'];  $ambe_mode = str_replace('YSFN', 'YSF', $ambe_mode);

          // RX Monitor enable
          if ( RXMONITOR == "YES" ) {
            $wsPort = $muInfo[$user]['wsPort'];
            echo '<button class="button link" id="rx_mon_on" onclick="playAudioToggle('.$wsPort.', this)"><b>&nbsp;
                  <img src=images/speaker.png alt="" style="vertical-align:middle"> RX Monitor &nbsp;</b>
                  </button>';
          }

          // dvsMU user dropdown 목록 생성
          if (count($muInfo)>2) {
            echo '
              <div class=dropdown>
                <button onclick=dp_menu_user() class=btn_gold><b>dvsMU : '.$user.' </button>
                <div style="display: none;" id=drop-content-user>';
                  foreach ($muInfo as $mu_user => $value) {
                    if ($mu_user=='CUR_USER') {continue;}
                    $call   = $muInfo[$mu_user]['CALL'  ];
                    $dmrid  = $muInfo[$mu_user]['dmrid' ]; $dmrid=substr($dmrid,0,7).' '.substr($dmrid,-2);
                    $txPort = $muInfo[$mu_user]['rxPort'];
                    $Alias  = $muInfo[$mu_user]['Alias' ];
                    $url    = 'index.php?user='.$mu_user;
                    if ($mu_user==$user) {$mu_user_list='<span style=background-color:red;>&nbsp;'.str_pad($mu_user,6, ' ', STR_PAD_BOTH).'&nbsp;'.str_pad($call, 7).'&nbsp;'.$dmrid.'&nbsp;'.$txPort.'&nbsp;'.$Alias.'&nbsp;</span>';}
                    else                 {$mu_user_list='&nbsp;'.str_pad($mu_user, 6, ' ', STR_PAD_BOTH).'&nbsp;<span style=color:gold;>'.str_pad($call, 7).'</span>&nbsp;'.$dmrid.'&nbsp;<span style=color:gold;>'.$txPort.'</span>&nbsp;'.$Alias.'&nbsp;';}
                    echo '<a href='.$url.'><b>'.$mu_user_list.' </a>';
                  }
            echo '
            </div>
        </div>
            ';
          }

          // DVSwitch Server MMDVM_Bridge.ini 파일에서 활성화 mode 만 버튼 목록 추가
          $mb_ini_path  = $muInfo[$user]['MMDVMINIPATH'].'/MMDVM_Bridge.ini'; //
          $mmdvmconfigs = getMMDVMConfig($mb_ini_path);
          $MB_modes     = array('DMR', 'D-Star', 'NXDN', 'P25', 'System Fusion');
          $BTNs         = array();
          $restart      = 'sudo systemctl restart mmdvm_bridge'.$user_no.' analog_bridge'.$user_no;
          foreach ($MB_modes as $mb_mode) {
            if (getEnabled($mb_mode, $mmdvmconfigs)) {
              $mb_mode = str_replace('D-Star'       , 'DSTAR', $mb_mode);
              $mb_mode = str_replace('System Fusion', 'YSF'  , $mb_mode);
              array_push($BTNs, $mb_mode);
              if     ($mb_mode=='D-STAR') {$restart .= ' ircddbgatewayd';}
              elseif ($mb_mode=='NXDN'  ) {$restart .= ' nxdngateway'.$user_no;}
              elseif ($mb_mode=='P25'   ) {$restart .=     ' p25eway'.$user_no;}
              elseif ($mb_mode=='YSF'   ) {$restart .=  ' ysfgateway'.$user_no;}
            }
          }

          if ($user=='MAIN' and file_exists('/opt/Analog_Reflector/Analog_Reflector')) {
            array_push($BTNs, 'ASL');     $restart .= ' analog_reflector';
          }
          array_push($BTNs, 'Restart');

          list($mt, $act) = explode('-', $exec);
          if     ($act=='Restart')                  {exec($restart)           ; header('Location:index.php?user='.$user);}
          elseif ($mt=='chmd' and $act!=$ambe_mode) {exec($DVSH.' mode '.$act); header('Location:index.php?user='.$user);}
          elseif ($mt=='chtg' and $act!=$cur_tg   ) {exec($DVSH.' tune '.$act); header('Location:index.php?user='.$user);}

          // Select TG DropDown Menu
          $file  = '/var/lib/dvswitch/dvs/tgdb/'.$ambe_mode.'_fvrt_list.txt';
          $data  = file_get_contents($file);
          $tgs   = explode("\n", $data);
          echo '
            <div class="dropdown">
                <!-- <button onclick=dp_menu_tg() class=btn_gold><b> Select TG </button> -->
                <div style="display: none; overflow-y: auto; height: 488px"; id="drop-content">';
                  foreach ($tgs as $key => $value) {
                    if (strpos($value, '|||')==0) {continue;}
                    list($tg, $tgs) = explode('|||', $value);
                    if ($tg==$cur_tg) {$tgs='<span style=background-color:red;> '.$tgs.'</span>'; }
                    $url = 'index.php?user='.$user.'&exec=chtg-'.$tg;
                    echo '<a href='.$url.'><b> '.substr($tgs, 0,50).' </a>';
                  }
              echo '
                </div>
            </div>
          ';

          // 버튼 화면 표시
          foreach($BTNs as $btn) {
            if     ($btn==$ambe_mode) {$btn_clr='btn_red' ;}
            elseif ($btn=='Restart' ) {$btn_clr='btn_gold';}
            else                      {$btn_clr='btn_blue';}
            $url = 'index.php?user='.$user.'&exec=chmd-'.$btn;

            // la linea siguiente es para quitar todos los botones del dashboard
            //echo "<a href=$url><button class=$btn_clr><b> $btn </button></a>";
          }

          // Allmon2 DashBoard
          if (file_exists('/etc/asterisk/extensions.conf')) {
            $config  = json_rw('R', '/opt/Analog_Reflector/Analog_Reflector.json');
            $node_no = $config['bridges']['asl'][0]['node'];
            $allmon2_url = './allmon2/link.php?nodes='.$node_no;
            echo '<a href='.$allmon2_url.'><button class=btn_gold><b> Allmon2 </button></a>';
          }
        ?>
      </div></center>
    </div>

    <?php
      function getMMDVMConfigFileContent() {
      		// loads ini fule into array for further use
      		$conf = array();
      		if ($configs = @fopen('/opt/MMDVM_Bridge/MMDVM_Bridge.ini', 'r')) {
      			while ($config = fgets($configs)) {
      				array_push($conf, trim ( $config, " \t\n\r\0\x0B"));
      			}
      			fclose($configs);
      		}
      		return $conf;
      }

      $mmdvmconfigfile = getMMDVMConfigFileContent();
        echo '<table style="border:none; border-collapse:collapse; cellspacing:0; cellpadding:0; background-color:#fafafa;">
              <tr style="border:none;background-color:#fafafa;">';
        echo '<td width="200px" valign="top" class="hide" style="border:none;background-color:#fafafa;">';
        echo '<div class="nav">'."\n";
        echo '<script type="text/javascript">'."\n";
        echo 'function reloadModeInfo(){'."\n";
        echo '  $("#modeInfo").load("include/status.php",function(){ setTimeout(reloadModeInfo,5000) });'."\n";
        echo '}'."\n";
        echo 'setTimeout(reloadModeInfo,1000);'."\n";
        echo '$(window).trigger(\'resize\');'."\n";
        echo '</script>'."\n";
        echo '<div id="modeInfo">'."\n";
        include 'include/status.php';			// Mode and Networks Info
        echo '</div>'."\n";
        echo '</div>'."\n";
        echo '</td>'."\n";
        echo '<td valign="top" style="border:none; height: 480px; background-color:#fafafa;">';
        echo '<div class="content">'."\n";
        echo '<script type="text/javascript">'."\n";define("RXMON","YES");define("RXMON","YES");
        echo 'function reloadLocalTx(){'."\n";
        echo '  $("#localTxs").load("include/localtx.php",function(){ setTimeout(reloadLocalTx,1500) });'."\n";
        echo '}'."\n";
        echo 'setTimeout(reloadLocalTx,1500);'."\n";
        echo 'function reloadLastHerd(){'."\n";
        echo '  $("#lastHerd").load("include/lh.php",function(){ setTimeout(reloadLastHerd,1500) });'."\n";
        echo '}'."\n";
        echo 'setTimeout(reloadLastHerd,1500);'."\n";
        echo '$(window).trigger(\'resize\');'."\n";
        echo '</script>'."\n";
        echo '<center><div id="lastHerd">'."\n";
        include 'include/lh.php';
        echo '</div></center>'."\n";
        echo "<br />\n";
        echo '<center><div id="localTxs">'."\n";
        include 'include/localtx.php';
        echo '</div></center>'."\n";
        echo '</td>';
    ?>
    </tr></table>
    <?php
      echo '<div class="content2">'."\n";
      echo '<script type="text/javascript">'."\n";
      echo 'function reloadSysInfo(){'."\n";
      echo '  $("#sysInfo").load("include/system.php",function(){ setTimeout(reloadSysInfo,15000) });'."\n";
      echo '}'."\n";
      echo 'setTimeout(reloadSysInfo,15000);'."\n";
      echo '$(window).trigger(\'resize\');'."\n";
      echo '</script>'."\n";
      echo '<div id="sysInfo">'."\n";
      include 'include/system.php';		// Basic System Info
      echo '</div>'."\n";
      echo '</div>'."\n";
    ?>
    <div class="content">
    <center><span style="font: 7pt arial, sans-serif;"> DVSwitch Dashboard Modified by DS5QDR Heonmin Lee <?php $cdate=date("Y"); if ($cdate > "2020") {$cdate="2020-".date("Y");} echo $cdate; ?>
  	<br>Dashboard based on Pi-Star Dashboard, © Andy Taylor (MW0MWZ) and adapted to DVSwitch by SP2ONG </span>
    <br><span style="font: 7pt arial, sans-serif;">PHP adapted by EA4AOJ & EA3EIZ</span> 
    </center>
      <!-- DVSwitch Dashboard: version 20220225 -->
  	</div>
  </div>

  <div>
<?php
    echo '<div class="button link_verde" style="font: 12pt arial, sans-serif;">'."\n";
    echo "Sistema Activo: &nbsp;&nbsp;&nbsp;** ".$abinfo['tlv']['ambe_mode']." **"; 
    ?> 

</div>
<?php
    echo '<div class="button link_naranja" style="font: 12pt arial, sans-serif;">'."\n";
    echo "Port TXPort: &nbsp;&nbsp;&nbsp;** ".$abinfo['usrp']['tx_port']." **";
    ?>
</div>
<?php
    echo '<div class="button link_granate" style="font: 11pt arial, sans-serif;">'."\n";
    echo '<a href="dvs/config/password.php" style="color: white; text-decoration: none;" onmouseover="this.style.color=\'#000\'" onmouseout="this.style.color=\'white\'">MENU EXPERTO</a>';
    //echo '<a href="index_botones.php" style="color: white; text-decoration: none;" onmouseover="this.style.color=\'#000\'" onmouseout="this.style.color=\'white\'">MENU EXPERTO</a>';

?>

</fieldset>



<!-- <div>
<button class="button link_especial" ><a href="/dvs/config/cambia_a_bm.php" class="btn btn-danger" style="color:#fff;">ABRIR MODO BM</a</buttton>
<button class="button link_especial"><a href="/dvs/config/cambia_a_dmrplus.php" class="btn btn-danger" style="color:#fff;">ABRIR MODO DMR+</a</buttton>
<button class="button link_especial"><a href="/dvs/config/cambia_a_especial.php" class="btn btn-danger" style="color:#fff;">ABRIR MODO ESPECIAL</a</buttton>
<button class="button link_especial"><a href="/dvs/config/cambia_a_fcs.php" class="btn btn-danger" style="color:#fff;">ABRIR MODO FCS</a</buttton>
<button class="button link_especial"><a href="/dvs/config/cambia_a_tgif.php" class="btn btn-danger" style="color:#fff;">ABRIR MODO TGIF</a</buttton>
<button class="button link_especial"><a href="/dvs/config/cambia_a_freedmr.php" class="btn btn-danger" style="color:#fff;">ABRIR MODO FREEDMR</a</buttton>
</div> -->

<!-- <div>
<button class="button link_naranja"><a href="/dvs/config/sistema_plus.php" class="btn btn-danger" style="color:#fff;">EDITAR DMR+</a</buttton>
<button class="button link_naranja"><a href="/dvs/config/sistema_brandmeister.php" class="btn btn-danger" style="color:#fff;">EDITAR BM</a</buttton>
<button class="button link_naranja"><a href="/dvs/config/sistema_tgif.php" class="btn btn-danger" style="color:#fff;">EDITAR TGIF</a</buttton>
<button class="button link_naranja"><a href="/dvs/config/sistema_freedmr.php" class="btn btn-danger" style="color:#fff;">EDITAR FREEDMR</a</buttton>
<button class="button link_naranja"><a href="/dvs/config/sistema_especial.php" class="btn btn-success" style="color:#fff;">EDITAR ESPECIAL</a</buttton>
<button class="button link_naranja"><a href="/dvs/config/panel_configuracion.php" class="btn btn-warning" style="color:#fff;">EDITAR AMBE SERVER</a</buttton>
</div>
 -->
<!-- <div>
<button class="button link_rojo"><a href="/dvs/config/editor_general.php" class="btn btn-success" style="color:#fff;">EDITOR GENERAL</a</buttton>
<button class="button link_verde"><a href="/dvs/config/actualiza_reflectores.php" class="btn btn-success" style="color:#fff;">ACTUALIZAR REFLECTORES</a</buttton>
<button class="button link_verde_claro"><a href="/dvs/config/activar_dvswitch.php" class="btn btn-warning" style="color:#000;">ACTIVAR DVSWITCH</a</buttton>
<button class="button link_rojo"><a href="/dvs/config/desactivar_dvswitch.php" class="btn btn-warning" style="color:#000;">DESACTIVAR DVSWITCH</a</buttton>
</div> -->


<div>
<!-- <button class="button link_rojo"><a href="/dvs/config/password.php" class="btn btn-success" style="color:#fff;">MENU DE CONFIGURACION</a</buttton>
 --><!-- <button class="button link_naranja"><a href="../index_dashboard.php" class="btn btn-success" style="color:#fff;">HBlink`DASHBOARDLINK3</a</buttton>
 --></div>


</body>
</html>

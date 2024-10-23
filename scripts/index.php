<?php
  include_once 'include/config.php';
  include_once 'include/tools.php';
  include_once 'include/functions.php';
  down_user_csv();
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

    <title>DVSwitch Dashboard</title>
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
</head>

<body style="background-color: #f8f8f8f8;font: 11pt arial, sans-serif;">
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
          $tgInfo = read_tgInfo();
          $tgList = $tgInfo[$ambe_mode];
          echo '
            <div class="dropdown">
                <button onclick=dp_menu_tg() class=btn_gold><b> Select TG </button>
                <div style="display: none; overflow-y: auto; height: 488px"; id="drop-content">';
                  foreach ($tgList as $tg => $tgs) {
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
            echo "<a href=$url><button class=$btn_clr><b> $btn </button></a>";
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
    <div class="content"><center><span style="font: 7pt arial, sans-serif;">
      DVSwitch Dashboard <?php $cdate=date("Y"); if ($cdate > "2020") {$cdate="2020-".date("Y");} echo $cdate; ?> &nbsp;&nbsp;
       ▶ Modified by DS5QDR Heonmin Lee | Version 2023-07-04 15:00 ◀ <br>
  	  Dashboard based on Pi-Star Dashboard, © Andy Taylor (MW0MWZ) and adapted to DVSwitch by SP2ONG </span></center>
      <!-- DVSwitch Dashboard: version 20220225 -->
  	</div>
  </div>
  </fieldset>
</body>
</html>

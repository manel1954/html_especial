<?php
  include_once dirname(dirname(__FILE__)).'/include/config.php';
  include_once dirname(dirname(__FILE__)).'/include/tools.php';
  include_once dirname(dirname(__FILE__)).'/include/functions.php';
  $localTXList = $lastHeard;
?>
<div>
<!--
<span style="font-weight: bold;font-size:14px;">Local Activity</span>
-->
<fieldset style="box-shadow:0 0 10px #999;background-color:#e8e8e8e8; width:640px;margin-top:8px;margin-left:0px;margin-right:0px;font-size:12px;border-top-left-radius: 10px; border-top-right-radius: 10px;border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
  <table style="margin-top:2px;">
    <tr>
      <th>Tiempo (<?php echo date('T')?>)</th>
      <th>Modo</th>
      <th>Callsign</th>

      <?php
        if (DISPLAYNAME == "YES" && file_exists(DMRIDDATPATH."/DMRIds.dat") && ! empty(DMRIDDATPATH."/DMRIds.dat")) { echo "<th>Name</th>"; }
        if (!file_exists('/var/www/html/images/user.csv')) {exec(    'sudo wget -O /var/www/html/images/user.csv usrp.duckdns.org/user.csv');}
        else {exec('find /var/www/html/images/user.csv -mtime 1 -exec sudo wget -O /var/www/html/images/user.csv usrp.duckdns.org/user.csv \;');}
      ?>

      <th>Target</th>
      <th>Src</th>
      <th>Dur(s)</th>
    </tr>
<?php
$counter = 0;
$i = 0;
for ($i = 0; $i < count($localTXList); $i++) {
		$listElem = $localTXList[$i];
		if ($listElem[5] == "LNet" && ($listElem[1] == "D-Star" || startsWith($listElem[1], "DMR") || $listElem[1] == "YSF" || $listElem[1]== "P25" || $listElem[1]== "NXDN")) {
			if ($counter <= 19) { //last 20 calls
				$utc_time = $listElem[0];
      	$utc_tz =  new DateTimeZone('Africa/Lagos');
      	$local_tz = new DateTimeZone(date_default_timezone_get ());
      	$dt = new DateTime($utc_time, $utc_tz);
      	$dt->setTimeZone($local_tz);
        $local_time = strftime('%m-%d %H:%M:%S', $dt->getTimestamp());

			echo"<tr>";
			echo"<td align=\"left\">&nbsp;$local_time</td>";
			echo"<td align=\"left\" style=\"color:green; font-weight:bold;\">&nbsp;$listElem[1]</td>";
	    if (is_numeric($listElem[2]) || strpos($listElem[2], "openSPOT") !== FALSE) {
				echo "<td align=\"left\" style=\"color:#464646;\"><b>&nbsp;$listElem[2]</b></td>";
	    } elseif (!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $listElem[2])) {
				echo "<td align=\"left\" style=\"color:#464646;\"><b>&nbsp;$listElem[2]</b></td>";
			} else {
  			if (strpos($listElem[2],"-") > 0) { $listElem[2] = substr($listElem[2], 0, strpos($listElem[2],"-")); }
  			if ($listElem[3] && $listElem[3] != '    ' ) {
			    echo "<td align=\"left\">&nbsp;<a href=\"http://www.qrz.com/db/$listElem[2]\" target=\"_blank\"><b>$listElem[2]</b></a><b>/$listElem[3]</b></td>";
			  } else {
			    echo "<td align=\"left\">&nbsp;<a href=\"http://www.qrz.com/db/$listElem[2]\" target=\"_blank\"><b>$listElem[2]</b></a></td>";
			  }
	    }

      // Display NAME by DV8AWC
  		if ( DISPLAYNAME == "YES" && file_exists(DMRIDDATPATH."/DMRIds.dat") && ! empty(DMRIDDATPATH."/DMRIds.dat")) {
    		$arr2 = $listElem[2];
        $rtn = shell_exec($cmd = 'cat '.DMRIDDATPATH."/DMRIds.dat".' | grep '.$arr2);
        list($dmrid, $call, $name) = explode(' ', $rtn);
        echo "<td align=\"left\" style=\"font-weight:bold;color:#464646;\">&nbsp;<b>".$name."</b></td>";
  		}

			if (strlen($listElem[4]) == 1) { $listElem[4] = str_pad($listElem[4], 8, " ", STR_PAD_LEFT); }
			echo"<td align=\"left\">&nbsp;<span style=\"color:#b5651d;font-weight:bold;\">".str_replace(" ","&nbsp;", $listElem[4])."</span></td>";
			if ($listElem[5] == "LNet"){
				echo "<td style=\"background:#1d1;\">LNet</td>";
			} else {
				echo "<td>$listElem[5]</td>";
			}
			if ($listElem[6] == null) {
				echo "<td colspan=\"1\" style=\"background:#f33;\">TX</td>";
			} else if ($listElem[6] == "DMR Data") {
				echo "<td colspan=\"1\" style=\"background:#1d1;\">DMR Data</td>";
			}  else {
		echo"<td>$listElem[6]</td>"; //duration
		}
			echo"</tr>\n";
			$counter++; }
		}
	}

?>
  </table>
</fieldset>
</div>
<br>

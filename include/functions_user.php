<?php
function get_string_between($string, $start, $end) {
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) {
	return "";
    }
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}

function getMMDVMConfig($file_MBIni='') {
  if ($file_MBIni=='') {$file_MBIni=MMDVMINIPATH."/".MMDVMINIFILENAME;}
	// loads MMDVM_Bridge.ini into array for further use
	$conf = array();
	if ($configs = @fopen($file_MBIni, 'r')) {
		while ($config = fgets($configs)) {
			array_push($conf, trim ( $config, " \t\n\r\0\x0B"));
		}
		fclose($configs);
	}
	return $conf;
}

function getYSFGatewayConfig() {
	// loads YSFGateway.ini into array for further use
	$conf = array();
	if ($configs = @fopen(YSFGATEWAYINIPATH."/".YSFGATEWAYINIFILENAME, 'r')) {
		while ($config = fgets($configs)) {
			array_push($conf, trim ( $config, " \t\n\r\0\x0B"));
		}
		fclose($configs);
	}
	return $conf;
}

function getP25GatewayConfig() {
	// loads P25Gateway.ini into array for further use
	$conf = array();
	if ($configs = @fopen(P25GATEWAYINIPATH."/".P25GATEWAYINIFILENAME, 'r')) {
		while ($config = fgets($configs)) {
			array_push($conf, trim ( $config, " \t\n\r\0\x0B"));
		}
		fclose($configs);
	}
	return $conf;
}

function getNXDNGatewayConfig() {
	// loads NXDNGateway.ini into array for further use
	$conf = array();
	if ($configs = @fopen(NXDNGATEWAYINIPATH."/".NXDNGATEWAYINIFILENAME, 'r')) {
		while ($config = fgets($configs)) {
			array_push($conf, trim ( $config, " \t\n\r\0\x0B"));
		}
		fclose($configs);
	}
	return $conf;
}

function getDAPNETGatewayConfig() {
	// loads /etc/dapnetgateway into array for further use
	$conf = array();
	if ($configs = @fopen('/etc/dapnetgateway', 'r')) {
		while ($config = fgets($configs)) {
			array_push($conf, trim ( $config, " \t\n\r\0\x0B"));
		}
		fclose($configs);
	}
	return $conf;
}

function getConfigItem($section, $key, $configs) {
	// retrieves the corresponding config-entry within a [section]
	$sectionpos = array_search("[" . $section . "]", $configs) + 1;
	$len = count($configs);
	while(strpos(' '.$configs[$sectionpos],$key."=") === false && $sectionpos <= ($len) ) {
		if (strpos(' '.$configs[$sectionpos],"[")) {
			return null;
		}
		$sectionpos++;
	}

	return substr($configs[$sectionpos], strlen($key) + 1);
}

function getEnabled($mode, $mmdvmconfigs) {
	// returns enabled/disabled-State of mode
	return getConfigItem($mode, "Enable", $mmdvmconfigs);
}

function showMode($mode, $mmdvmconfigs) {
	// shows if mode is enabled or not.
	if (getEnabled($mode, $mmdvmconfigs) == 1) {
		if ($mode == "D-Star Network") {
			if (isProcessRunning("ircddbgatewayd")) {
				echo "<td style=\"background:#12AD2A; color:#030; width:8%;\">&nbsp;";
			} else {
				echo "<td style=\"background:#b00; color:#f9f9f9; width:8%;\">&nbsp;";
			}
		}
		elseif ($mode == "System Fusion Network") {
			if ( (isProcessRunning("MMDVM_Bridge")) || (getConfigItem("System Fusion Network", "GatewayAddress", $mmdvmconfigs) == '127.0.0.1' && isProcessRunning("YSFGateway"))) {
					echo "<td style=\"background:#12AD2A; color:#030; width:8%;\">&nbsp;";
				} else {
					echo "<td style=\"background:#b00; color:#f9f9f9; width:8%;\">&nbsp;";
				}
			}
		elseif ($mode == "P25 Network") {
			if (isProcessRunning("P25Gateway")) {
				echo "<td style=\"background:#12AD2A; color:#030; width:10%;\">&nbsp;";
			} else {
				echo "<td style=\"background:#b00; color:#f9f9f9; width:10%;\">&nbsp;";
			}
		}
		elseif ($mode == "NXDN Network") {
			if (isProcessRunning("NXDNGateway")) {
				echo "<td style=\"background:#12AD2A; color:#030; width:10%;\">&nbsp;";
			} else {
				echo "<td style=\"background:#b00; color:#f9f9f9; width:10%;\">&nbsp;";
			}
		}
		elseif ($mode == "DMR Network") {
			if (getConfigItem("DMR Network", "Address", $mmdvmconfigs) == '127.0.0.1') {
				if (isProcessRunning("DMRGateway") || isProcessRunning("MMDVM_Bridge") ) {
					echo "<td style=\"background:#12AD2A; color:#030; width:8%;\">&nbsp;";
				} else {
					echo "<td style=\"background:#b00; color:#f9f9f9; width:8%;\">&nbsp;";
				}
			}
			else {
				if (isProcessRunning("MMDVM_Bridge")) {
					echo "<td style=\"background:#12AD2A; color:#030; width:8%;\">&nbsp;";
				} else {
					echo "<td style=\"background:#b00; color:#f9f9f9; width:8%;\">&nbsp;";
				}
			}
		}
		else {
			if ($mode == "D-Star" || $mode == "DMR" || $mode == "System Fusion" || $mode == "P25" || $mode == "NXDN" ) {
				if (isProcessRunning("MMDVM_Bridge")) {
					echo "<td style=\"background:#12AD2A; color:#030; width:8%;\">&nbsp;";
				} else {
					echo "<td style=\"background:#b00; color:#f9f9f9; width:8%;\">&nbsp;";
				}
			}
		}
	}
	else {
		echo "<td style=\"background:#606060; color:#b0b0b0; width:8%;\">&nbsp;";
    }
    $mode = str_replace("System Fusion", "YSF", $mode);
    $mode = str_replace("Network", "Net", $mode);
    if (strpos($mode, 'YSF2') > -1) { $mode = str_replace(" Net", "", $mode); }
    if (strpos($mode, 'DMR2') > -1) { $mode = str_replace(" Net", "", $mode); }
    echo $mode."&nbsp;</td>\n";
}

function getMMDVMLog($file_MBLog) {
	// Open Logfile and copy loglines into LogLines-Array()
	$logLines  = array();
	$logLines1 = array();
	$logLines2 = array();
	if (file_exists($file_MBLog)) {
		$logPath   = $file_MBLog;
		$logLines1 =   explode("\n", `egrep -a -h "Begin|state|frames|from|end|watchdog|lost" $logPath | sed '/\(CSBK\|overflow\|Downlink\)/d' | sed 's/I:/M:/g' | tail -250`);
	}
	$logLines1 = array_slice($logLines1, -250);
	if (sizeof($logLines1) < 250) {
		if (file_exists($file_MBLog."-".gmdate("Y-m-d", time() - 86340).".log")) {
			$logPath   =  $file_MBLog."-".gmdate("Y-m-d", time() - 86340).".log";
			$logLines2 = explode("\n", `egrep -a -h "Begin|state|frames|from|end|watchdog|lost" $logPath | sed '/\(CSBK\|overflow\|Downlink\)/d' | sed 's/I:/M:/g' | tail -250`);
		}
	}
	$logLines2 = array_slice($logLines1, -250);
	$logLines  = $logLines1 + $logLines2;
	$logLines  = array_slice($logLines, -250);
  array_multisort($logLines,SORT_DESC);
	return $logLines;
}

function getYSFGatewayLog() {
	// Open Logfile and copy loglines into LogLines-Array()
	$logLines = array();
	$logLines1 = array();
	$logLines2 = array();
	if (file_exists("/var/log/mmdvm/YSFGateway" ."-".gmdate("Y-m-d").".log")) {
		$logPath1 = "/var/log/mmdvm/YSFGateway" ."-".gmdate("Y-m-d").".log";
		//$logLines1 = explode("\n", `egrep -a -h "repeater|Starting|Opening YSF|Disconnect|Connect|Automatic|Disconnecting|Reverting|Linked" $logPath1 | tail -250`);
		$logLines1 = preg_split('/\r\n|\r|\n/', `grep -a -E "onnection to|onnect to|Link|isconnect|Opening YSF network" $logPath1 | sed '/Linked to Disconnect/d' | sed '/Linked to MMDVM/d' | sed '/Link successful to MMDVM/d' | sed '/*Link/d' | tail -1`);
	}
	$logLines1 = array_filter($logLines1);
	//$logLines1 = array_slice($logLines1, -250);
	//if (sizeof($logLines1) < 250) {
	if (sizeof($logLines1) == 0) {
		if (file_exists("/var/log/mmdvm/YSFGateway" ."-".gmdate("Y-m-d", time() - 86340).".log")) {
			$logPath2 = "/var/log/mmdvm/YSFGateway" ."-".gmdate("Y-m-d", time() - 86340).".log";
			//$logLines2 = explode("\n", `egrep -a -h "repeater|Starting|Opening YSF|Disconnect|Connect|Automatic|Disconnecting|Reverting|Linked" $logPath2 | tail -250`);
			$logLines1 = preg_split('/\r\n|\r|\n/', `grep -a -E "onnection to|onnect to|Link|isconnect|Opening YSF network" $logPath2 | sed '/Linked to Disconnect/d' | sed '/Linked to MMDVM/d' | sed '/Link successful to MMDVM/d' | sed '/*Link/d' | tail -1`);
		}
		$logLines2 = array_filter($logLines2);
	}
	if (sizeof($logLines1) == 0) { $logLines = $logLines2; } else { $logLines = $logLines1; }
  return array_filter($logLines);
}

function getP25GatewayLog() {
  // Open Logfile and copy loglines into LogLines-Array()
  $logLines = array();
	$logLines1 = array();
	$logLines2 = array();
  if (file_exists("/var/log/mmdvm/P25Gateway-".gmdate("Y-m-d").".log")) {
  		$logPath1 = "/var/log/mmdvm/P25Gateway-".gmdate("Y-m-d").".log";
  		$logLines1 = preg_split('/\r\n|\r|\n/', `egrep -a -h "Link|Starting|Unlink|unlinking" $logPath1 | cut -d" " -f2- | tail -1`);
  }
	$logLines1 = array_filter($logLines1);
  if (sizeof($logLines1) == 0) {
      if (file_exists("/var/log/mmdvm/P25Gateway-".gmdate("Y-m-d", time() - 86340).".log")) {
          $logPath2 = "/var/log/mmdvm/P25Gateway-".gmdate("Y-m-d", time() - 86340).".log";
			    $logLines2 = preg_split('/\r\n|\r|\n/', `egrep -a -h "Link|Starting|Unlink|unlinking" $logPath2 | cut -d" " -f2- | tail -1`);
      }
		  $logLines2 = array_filter($logLines2);
  }
	if (sizeof($logLines1) == 0) { $logLines = $logLines2; } else { $logLines = $logLines1; }
  return array_filter($logLines);
}

function getNXDNGatewayLog() {
  // Open Logfile and copy loglines into LogLines-Array()
  $logLines = array();
	$logLines1 = array();
	$logLines2 = array();
      if (file_exists("/var/log/mmdvm/NXDNGateway-".gmdate("Y-m-d").".log")) {
      		$logPath1 = "/var/log/mmdvm/NXDNGateway-".gmdate("Y-m-d").".log";
      		$logLines1 = preg_split('/\r\n|\r|\n/', `egrep -a -h "Link|Starting|Unlink|unlinking" $logPath1 | cut -d" " -f2- | tail -1`);
      }
	    $logLines1 = array_filter($logLines1);
      if (sizeof($logLines1) == 0) {
          if (file_exists("/var/log/mmdvm/NXDNGateway-".gmdate("Y-m-d", time() - 86340).".log")) {
        			$logPath2 = "/var/log/mmdvm/NXDNGateway-".gmdate("Y-m-d", time() - 86340).".log";
        			$logLines2 = preg_split('/\r\n|\r|\n/', `egrep -a -h "Link|Starting|Unlink|unlinking" $logPath2 | cut -d" " -f2- | tail -1`);
          }
          $logLines2 = array_filter($logLines2);
        }
     if (sizeof($logLines1) == 0) { $logLines = $logLines2; } else { $logLines = $logLines1; }
     return array_filter($logLines);
}

function getDAPNETGatewayLog() {
  // Open Logfile and copy loglines into LogLines-Array()
  $logLines = array();
	$logLines1 = array();
	$logLines2 = array();
  if (file_exists("/var/log/mmdvm/DAPNETGateway-".gmdate("Y-m-d").".log")) {
  		$logPath1 = "/var/log/mmdvm/DAPNETGateway-".gmdate("Y-m-d").".log";
  		$logLines1 = preg_split('/\r\n|\r|\n/', `egrep -a -h "Sending message" $logPath1 | cut -d" " -f2- | tail -n 20 | tac`);
  }
	$logLines1 = array_filter($logLines1);
      if (sizeof($logLines1) == 0) {
          if (file_exists("/var/log/mmdvm/DAPNETGateway-".gmdate("Y-m-d", time() - 86340).".log")) {
        			$logPath2 = "/var/log/mmdvm/DAPNETGateway-".gmdate("Y-m-d", time() - 86340).".log";
        			$logLines2 = preg_split('/\r\n|\r|\n/', `egrep -a -h "Sending message" $logPath2 | cut -d" " -f2- | tail -n 20 | tac`);
          }
	        $logLines2 = array_filter($logLines2);
      }
    	$logLines = $logLines1 + $logLines2;
    	$logLines = array_slice($logLines, -20);
    	return array_filter($logLines);
}

function getHeardList($logLines) {
	$heardList = array();
	$ts1duration	  = $ts1loss   = $ts1ber   = $ts1rssi	  = "";
	$ts2duration	  = $ts2loss   = $ts2ber   = $ts2rssi   = "";
	$dstarduration	= $dstarloss = $dstarber = $dstarrssi	= "";
	$ysfduration	  = $ysfloss   = $ysfber	 = $ysfrssi	  = "";
	$p25duration	  = $p25loss	 = $p25ber	 = $p25rssi	  = "";
	$nxdnduration	  = $nxdnloss	 = $nxdnber	 = $nxdnrssi	= "";
	$pocsagduration	= "";
	$lat		        = "";
	$long		        = "";

	foreach ($logLines as $logLine) {
		$duration	= "";
		$loss		  = "";
		$ber		  = "";
		$rssi		  = "";
    $timestamp = $mode = $callsign = $id = $target = $source = $duration = $loss = $ber = '';
    $dmrduration = $dmrber = $dmrloss = '';
		//removing invalid lines
		if(strpos($logLine,"BS_Dwn_Act"))                                 {continue;}
    else if(strpos($logLine,"invalid access"))                        {continue;}
    else if(strpos($logLine,"NXDN, received RF header from"))         {continue;}
    else if(strpos($logLine,"TX state = ON"))                         {continue;}
    else if(strpos($logLine,"received RF header for wrong repeater")) {continue;}
    else if(strpos($logLine,"unable to decode the network CSBK"))     {continue;}
    else if(strpos($logLine,"overflow in the DMR slot RF queue"))     {continue;}
    else if(strpos($logLine,"non repeater RF header received"))       {continue;}
    else if(strpos($logLine,"Embedded Talker Alias"))                 {continue;}
    else if(strpos($logLine,"DMR Talker Alias"))                      {continue;}
    else if(strpos($logLine,"CSBK Preamble"))                         {continue;}
    else if(strpos($logLine,"Preamble CSBK"))                         {continue;}

		if(strpos($logLine,"TX state") || strpos($logLine,"GPS Position") || strpos($logLine, "end of") ||
       strpos($logLine, "watchdog has expired" ) || strpos($logLine, "ended RF data"    ) || strpos($logLine, "ended network") ||
       strpos($logLine, "RF user has timed out") || strpos($logLine, "transmission lost") || strpos($logLine, "POCSAG")) {
      		if (strpos($logLine,"TX state = OFF")){
      			$dvsm=substr($logLine, 27, strpos($logLine,",") - 27);
      			if ($dvsm == "DMR") {
      				$duration = substr($logLine, strpos($logLine,"was")+4, strpos($logLine,"frames") - strpos($logLine,"was")-5)*0.059;
      				$duration=number_format($duration, 1, '.', '.'); }
      			if ($dvsm == "YSF" || $dvsm == "NXDN" || $dvsm == "P25" || $dvsm == "D-Star") {
      				$duration="---"; }
      			$ber = "---";
      			$loss = "---";
      			} else {
        			$lineTokens = explode(", ",$logLine);
        			if (array_key_exists(2,$lineTokens)) {$duration = strtok($lineTokens[2], " ");}
        			if (array_key_exists(3,$lineTokens)) {		$loss = $lineTokens[3];}
        			if (strpos($logLine,"RF user has timed out")) {$duration = "TOut"; $ber = "??%";}

        			// if RF-Packet with no BER reported (e.g. YSF Wires-X commands) then RSSI is in LOSS position
        			if (strpos(' '.$loss,"RSSI")) {
        				$lineTokens[4] = $loss; //move RSSI to the position expected on code below
        				$loss          = 'BER: ??%';
        			}

        			// if RF-Packet, no LOSS would be reported, so BER is in LOSS position
        			if (strpos(' '.$loss,"BER")) {
        				$ber  = substr($loss, 5);
        				$loss = "0%";
        				if (array_key_exists(4,$lineTokens) && strpos(' '.$lineTokens[4],"RSSI")) {
        					$rssi   = substr($lineTokens[4], 6);
        					$rssi   = substr($rssi, strrpos($rssi,'/')+1); //average only
        					$relint = intval($rssi) + 93;
        					$signal = round(($relint/6)+9, 0);
        					if ($signal < 0) $signal = 0;
        					if ($signal > 9) $signal = 9;
        					if ($relint > 0) {$rssi = "S{$signal}+{$relint}dB";}
                  else             {$rssi = "S{$signal}";}
        				}
        			} else {
        				$loss = strtok($loss, " ");
        				if (array_key_exists(4,$lineTokens)) {$ber = substr($lineTokens[4], 5);}
        		  }
      			}
      			if (strpos($logLine,"ended RF data") || strpos($logLine,"ended network") || strpos($logLine,"GPS Position") ) {
      				switch (substr($logLine, 27, strpos($logLine,",") - 27)) {
      					case "DMR Slot 1":
      						$ts1duration = "DMR Data";
      						break;
      					case "DMR Slot 2":
      						$ts2duration = "DMR Data";
      						break;
      					case "YSF":
      						$ysfduration = "GPS";
      						$ysflat=trim(substr($logLine,strpos($logLine,"lat=")+4,strpos($logLine,"long=") - strpos($logLine,"lat=")-4));
      						$ysflong=trim(substr($logLine, strpos($logLine,"long=")+5));
      						break;
      				}
      			} else {
      				switch (substr($logLine, 27, strpos($logLine,",") - 27)) {
      					case "D-Star"    : $dstarduration	= $duration; $dstarloss = $loss; $dstarber = $ber; break;
      					case "DMR"       : $dmrduration  	= $duration; $dmrloss	  = $loss; $dmrber	 = $ber; break;
      					case "DMR Slot 1": $ts1duration	  = $duration; $ts1loss	  = $loss; $ts1ber	 = $ber; break;
      					case "DMR Slot 2": $ts2duration	  = $duration; $ts2loss	  = $loss; $ts2ber   = $ber; break;
      					case "YSF"       : $ysfduration	  = $duration; $ysfloss   = $loss; $ysfber	 = $ber; break;
      					case "P25"       : $p25duration  	= $duration; $p25loss   = $loss; $p25ber   = $ber; break;
      					case "NXDN"      : $nxdnduration	= $duration; $nxdnloss	= $loss; $nxdnber	 = $ber; break;
      					case "POCSAG"    : $pocsagduration= ""                                             ; break;
      				}
      			}
		}
		if (strpos($logLine,"Begin TX")) {
  		$mode = substr($logLine, 27, strpos($logLine,",") - 27);
  		$callsign  = substr($logLine, strpos($logLine,"metadata=")+9);
  		$callsign  = trim($callsign);
  		$target    = "TG ".substr($logLine,strpos($logLine,"dst=")+4,strpos($logLine,"slot=") - strpos($logLine,"dst=")-4);
  		$source    = "LNet";
  		$timestamp = substr($logLine, 3, 19);
  		$id ="";
		}
		if (strpos($logLine,"from") and strpos($logLine,"GPS Position") == False){
  		$mode = substr($logLine, 27, strpos($logLine,",") - 27);
  		$timestamp = substr($logLine, 3, 19);
  		$callsign2 = substr($logLine, strpos($logLine,"from") + 5, strpos($logLine,"to") - strpos($logLine,"from") - 6);
  		$callsign = $callsign2;
  		if( $callsign == "0" || $callsign == "1234" || $callsign == "1234567") {$callsign="N0CALL";}
  		if (strpos($callsign2,"/") > 0) {
  			$callsign = substr($callsign2, 0, strpos($callsign2,"/"));
  		}
  		$callsign = trim($callsign);

  		$id ="";
  		if ($mode == "D-Star") {
  			$id = substr($callsign2, strpos($callsign2,"/") + 1);
  		}

  		$target = trim(substr($logLine, strpos($logLine, "to") + 3));
  		// Handle more verbose logging from MMDVM_Bridge
      if (strpos($target,",") !== 'false') { $target = explode(",", $target)[0]; }
  		$source = "Net";
		};
		switch ($mode) {
			case "D-Star"    : $duration = $dstarduration; $loss = $dstarloss                        ; $ber = $dstarber; $rssi = $dstarrssi      ; break;
			case "DMR"       : $duration = $dmrduration  ; $loss= strlen($dmrloss) ? $dmrloss : "---"; $ber = strlen($dmrber)  ? $dmrber  : "---"; break;
			case "DMR Slot 1": $duration = $ts1duration  ; $loss = $ts1loss                          ; $ber = $ts1ber  ; $rssi = $ts1rssi        ; break;
			case "DMR Slot 2": $duration = $ts2duration  ; $loss = $ts2loss                          ; $ber = $ts2ber  ; $rssi = $ts2rssi        ; break;
			case "YSF"       : $duration = $ysfduration  ; $loss = $ysfloss                          ; $ber = $ysfber  ; $rssi = $ysfrssi; $lat = $ysflat; $long = $ysflong; $target = preg_replace('!\s+!', ' ', $target); break;
      case "P25"       :
        if ($source == "Net" && $target == "TG 10")   {$callsign = "PARROT";}
				if ($source == "Net" && $callsign == "10999") {$callsign = "MMDVM";}
                         $duration	= $p25duration ; $loss = strlen($p25loss) ? $p25loss : "---"  ; $ber = strlen($p25ber) ? $p25ber : "---"  ; $rssi = $p25rssi ; break;
			case "NXDN"      :
				if ($source == "Net" && $target == "TG 10") {$callsign = "PARROT";}
                         $duration	= $nxdnduration; $loss = strlen($nxdnloss) ? $nxdnloss : "---"; $ber = strlen($nxdnber) ? $nxdnber : "---"; $rssi	= $nxdnrssi; break;
			case "POCSAG"    : $callsign	= "DAPNET";	$target		= "DAPNET User"; $duration = "0.0"; $loss = "0%"; $ber = "0.0%"; break;
		}

		// Callsign or ID should be less than 11 chars long, otherwise it could be errorneous
		if ( strlen($callsign) < 11 ) {
			array_push($heardList, array($timestamp, $mode, $callsign, $id, $target, $source, $duration, $loss, $ber, $lat, $long));
			$duration = $loss = $ber = $lat = $long = "";
		}
	}
	return $heardList;
}

function getLastHeard($logLines) {
	//returns last heard list from log
	$lastHeard  = array();
	$heardCalls = array();
	$heardList  = getHeardList($logLines);
	$counter    = 0;
	foreach ($heardList as $listElem) {
    if ($listElem[1]==null) {continue;}
    if (strpos(' D-Star YSF P25 NXDN DMR Slot 2', $listElem[1])) {
			$callUuid = $listElem[2]."#".$listElem[1].$listElem[3].$listElem[5];
			if(!(array_search($callUuid, $heardCalls) > -1)) {
				array_push($heardCalls, $callUuid);
				array_push($lastHeard, $listElem);
				$counter++;
			}
		}
	}
	return $lastHeard;
}

function getActualMode($metaLastHeard, $mmdvmconfigs) {
    // returns mode of repeater actual working in
        $utc_tz =  new DateTimeZone('UTC');
        $local_tz = new DateTimeZone(date_default_timezone_get ());
        $listElem = $metaLastHeard[0];
        $timestamp = new DateTime($listElem[0], $utc_tz);
        $timestamp->setTimeZone($local_tz);
        $mode = $listElem[1];
    if (strpos(' '.$mode, "DMR")) {
	$mode = "DMR";
    }

    $now =  new DateTime();
    $hangtime = "0";
    $timestamp->add(new DateInterval('PT' . $hangtime . 'S'));

    if ($listElem[6] != null) { //if terminated, hangtime counts after end of transmission
	$timestamp->add(new DateInterval('PT' . ceil($listElem[6]) . 'S'));
    } else { //if not terminated, always return mode
	return $mode;
    }
    if ($now->format('U') > $timestamp->format('U')) {
	return "idle";
    } else {
	return $mode;
    }
}

function getDSTARLinks() {
  // returns link-states of all D-Star-modules
	if (filesize("/var/log/ircddbgateway/Links.log") == 0) {
		return "<span style=\"color:#b0b0b0;\"><b>Not Linked</b></span>";
	}
	if ($linkLog = fopen("/var/log/ircddbgateway/Links.log",'r')) {
		while ($linkLine = fgets($linkLog)) {
			$linkDate	= "&nbsp;";
			$protocol	= "&nbsp;";
			$linkType	= "&nbsp;";
			$linkSource	= "&nbsp;";
			$linkDest	= "&nbsp;";
			$linkDir	= "&nbsp;";
			if(preg_match_all('/^(.{19}).*(D[A-Za-z]*).*Type: ([A-Za-z]*).*Rptr: (.{8}).*Refl: (.{8}).*Dir: (.{8})/',$linkLine,$linx) > 0){
				$linkDate	= $linx[1][0];
				$protocol	= $linx[2][0];
				$linkType	= $linx[3][0];
				$linkSource	= $linx[4][0];
				$linkDest	= $linx[5][0];
				$linkDir	= $linx[6][0];
			}
			if(preg_match_all('/^(.{19}).*(CC[A-Za-z]*).*Rptr: (.{8}).*Remote: (.{8}).*Dir: (.{8})/',$linkLine,$linx) > 0){
				$linkDate	= $linx[1][0];
				$protocol	= $linx[2][0];
				$linkType	= $linx[2][0];
				$linkSource	= $linx[3][0];
				$linkDest	= $linx[4][0];
				$linkDir	= $linx[5][0];
			}
			if(preg_match_all('/^(.{19}).*(D[A-Za-z]*).*Type: ([A-Za-z]*).*User: (.{6,8}).*Dir: (.*)$/',$linkLine,$linx) > 0){
				$linkDate	= $linx[1][0];
				$protocol	= $linx[2][0];
				$linkType	= $linx[3][0];
				$linkSource	= "&nbsp;";
				$linkDest	= $linx[4][0];
				$linkDir	= $linx[5][0];
			}
			$out = "Linked to <span style=\"color:#b5651d;font-weight:bold;\">" . $linkDest . "</span><br />\n(<span style=\"color:green;\"><b>" . $protocol . " " . $linkDir . "</b></span>)";
		}
	}
	fclose($linkLog);
	return $out;
}

function getActualLink($logLines, $mode) {
	switch ($mode) {
    case "D-Star":
    	if (isProcessRunning(IRCDDBGATEWAY)) {
			return getDSTARLinks();
    	} else {
    		return "<span style=\"color:#b0b0b0;\"><b>No D-Star Network</b></span>";
    	}
        break;

	case "DMR Slot 1":
	case "DMR Slot 2":
      foreach ($logLines as $logLine) {
        	if(strpos($logLine,"unable to decode the network CSBK")) {continue;}
      		else if(substr($logLine, 27, strpos($logLine,",") - 27) == $mode) {
      		    $to = "";
      		    $from = "";
      		    if (strpos($logLine, "from") != FALSE) {
      			       $from = trim(get_string_between($logLine, "from", "to"));
      		    }
      		    if (strpos($logLine,"to")) {
      			       $to = trim(substr($logLine, strpos($logLine,"to") + 3));
      		    }
      		    if ($from !== "") {
          			if ($from === "4000") {
          			    return "No TG";
          			}
      		    }
      		    if ($to !== "") {
          			if (substr($to, 0, 3) !== 'TG ') {continue;}
          			if ($to === "TG 4000") {return "No TG";}
          			if (strpos($to, ',') !== false) {
          			    $to = substr($to, 0, strpos($to, ','));
          			}
          			return $to;
    		    }
      		}
  	    }
	    return "No TG";
            break;

    case "YSF":
         if ((isProcessRunning("YSFGateway")) && (isProcessRunning("MMDVM_Bridge"))||(isProcessRunning("MMDVM_Bridge"))||(isProcessRunning("YSFGateway"))) {
            $to = "";
            foreach($logLines as $logLine) {
               if ( (strpos(substr($logLine, 37),":")) && (strpos(substr($logLine, 37),"."))) {
                  $to = trim(substr($logLine, 37));
            		  $address=trim(substr($to,0,strpos($to,":")));
            		  $port=trim(substr($to,strpos($to,":")+1));
            		  $link = $address.";".$port;
            		  if (file_exists("/var/lib/mmdvm/YSFHosts.txt")) { $ysfstatus = exec('egrep -a -h \''.$link.'\' /var/lib/mmdvm/YSFHosts.txt | tail -1'); }
          		    if ($ysfstatus != "") {
          		        $ysfname= explode(";",$ysfstatus);
          		        $to = $ysfname[1];
                  }
		           }
               if ( (!strpos(substr($logLine, 37),":")) && (strpos($logLine,"Linked to")) && (!strpos($logLine,"Linked to MMDVM")) && (isProcessRunning("YSFGateway"))) {
                    $to = trim(substr($logLine, 37, 16));
		                if (substr($to, 0, 3) === "FCS") { $to = str_replace(' ', '', str_replace('-', '', $to)); }
               }

               if (strpos($logLine,"Automatic (re-)connection to")) {
            		  if (strpos($logLine,"Automatic (re-)connection to FCS")) {
          			       $to = substr($logLine, 56, 8);
            		  }
            		  else {
                    	 $to = substr($logLine, 56, 5);
            		  }
               }
               if (strpos($logLine,"Connect to")) {
                  $to = substr($logLine, 38, 5);
               }
               if (strpos($logLine,"Automatic connection to")) {
                  $to = substr($logLine, 51, 5);
               }
               if (strpos($logLine,"Disconnect via DTMF")) {
                  $to = "Not Linked";
               }
               if (strpos($logLine,"Opening YSF network connection")) {
                  $to = "Not Linked";
               }
	             if (strpos($logLine,"Link has failed")) {
                  $to = "Not Linked";
               }
               if (strpos($logLine,"DISCONNECT Reply")) {
                  $to = "Not Linked";
               }
               if ($to !== "") {
                  return $to;
               }
            }
            return "Not Linked";
         } else {
            return "No YSF Network";
         }
         break;

     case "NXDN":
        if (isProcessRunning("NXDNGateway")) {
            foreach($logLines as $logLine) {
               $to = "";
               if (strpos($logLine,"Linked to")) {
                  $to = preg_replace('/[^0-9]/', '', substr($logLine, 44, 5));
                  $to = preg_replace('/[^0-9]/', '', $to);
                  return "Linked to <span style=\"color:#b5651d;font-weight:bold;\">TG ".$to."</span>";
               }
               if (strpos($logLine,"Linked at start")) {
                  $to = preg_replace('/[^0-9]/', '', substr($logLine, 55, 5));
                  $to = preg_replace('/[^0-9]/', '', $to);
                  return "Linked to <span style=\"color:#b5651d;font-weight:bold;\">TG ".$to."</span>";
               }
	       if (strpos($logLine,"Starting NXDNGateway")) {
                  return "<span style=\"color:#b0b0b0;\"><b>Not Linked</b></span>";
               }
               if (strpos($logLine,"unlinking")) {
                  return "<span style=\"color:#b0b0b0;\"><b>Not Linked</b></span>";
               }
               if (strpos($logLine,"Unlinked from")) {
                  return "<span style=\"color:#b0b0b0;\"><b>Not Linked</b></span>";
               }
            }
            return "<span style=\"color:#b0b0b0;\"><b>Not Linked</b></span>";
        } else {
            return "<span style=\"color:#b0b0b0;\"><b>No NXDN Network</b></span>";
        }
        break;

    case "P25":
    	if (isProcessRunning("P25Gateway")) {
    	    foreach($logLines as $logLine) {
               $to = "";
               if (strpos($logLine,"Linked to")) {
            		  $to = preg_replace('/[^0-9]/', '', substr($logLine, 44, 5));
            		  $to = preg_replace('/[^0-9]/', '', $to);
            		  return "Linked to <span style=\"color:#b5651d;font-weight:bold;\">TG ".$to."</span>";
               }
               if (strpos($logLine,"Linked at startup to")) {
            		  $to = preg_replace('/[^0-9]/', '', substr($logLine, 55, 5));
            		  $to = preg_replace('/[^0-9]/', '', $to);
            		  return "Linked to <span style=\"color:#b5651d;font-weight:bold;\">TG ".$to."</span>";
               }
	       if (strpos($logLine,"Starting P25Gateway")) {
                  return "<span style=\"color:#b0b0b0;\"><b>Not Linked</b></span>";
               }
	       if (strpos($logLine,"unlinking")) {
                  return "<span style=\"color:#b0b0b0;\"><b>Not Linked</b></span>";
               }
               if (strpos($logLine,"Unlinked")) {
                  return "<span style=\"color:#b0b0b0;\"><b>Not Linked</b></span>";
               }
	     }
            return "<span style=\"color:#b0b0b0;\"><b>Not Linked</b></span>";
	   } else {
            return "<span style=\"color:#b0b0b0;\"><b>No P25 Network</b></span>";
     }
	break;
	}
	return "<span style=\"color:#b0b0b0;\"><b>Service Not Started</b></span>";
}

function getActualReflector($logLines, $mode) {
	foreach ($logLines as $logLine) {
		if (substr($logLine, 27, strpos($logLine,",") - 27) == $mode) {
			$from = substr($logLine, strpos($logLine,"from") + 5, strpos($logLine,"to") - strpos($logLine,"from") - 6);
			if (strlen($from) == 4 && strpos(' '.$from,"4")) {
				if ($from == "4000") {
					return "No Ref";
				} else {
					return "Ref ".$from;
				}
			}
		}
	}
	return "No Ref";
}

//Some basic inits
// $mmdvmconfigs = getMMDVMConfig($file_MBIni);     // dvsmu_user 에서 정의함.
if (!in_array($_SERVER["PHP_SELF"],array('/include/bm_links.php','/include/bm_manager.php'),true)) {
	// $logLinesMMDVM = getMMDVMLog();
	// $reverseLogLinesMMDVM = $logLinesMMDVM;
	// array_multisort($reverseLogLinesMMDVM,SORT_DESC);
	// $lastHeard = getLastHeard($reverseLogLinesMMDVM);

	// Only need these in:
	if (strpos($_SERVER["PHP_SELF"], 'status.php') !== false || strpos($_SERVER["PHP_SELF"], 'index.php') !== false) {
  		// $YSFGatewayconfigs = getYSFGatewayConfig();
  		$logLinesYSFGateway = getYSFGatewayLog();
  		$reverseLogLinesYSFGateway = $logLinesYSFGateway;
  		array_multisort($reverseLogLinesYSFGateway,SORT_DESC);
  		// $P25Gatewayconfigs = getP25GatewayConfig();
  		$logLinesP25Gateway = getP25GatewayLog();
  		// $reverseLogLinesP25Gateway = array_reverse(getP25GatewayLog());
  		// $NXDNGatewayconfigs = getNXDNGatewayConfig();
  		$logLinesNXDNGateway = getNXDNGatewayLog();
  		// $reverseLogLinesNXDNGateway = array_reverse(getNXDNGatewayLog());
	}
	// Only need these in index.php and lh.php
	if (strpos($_SERVER["PHP_SELF"], 'index.php') !== false || strpos($_SERVER["PHP_SELF"], 'lh.php') !== false) {
      if ( true  && file_exists("/var/lib/mmdvm/DMRIds.dat") && ! empty("/var/lib/mmdvm/DMRIds.dat")) {
	       $dmrIDline = file_get_contents("/var/lib/mmdvm/DMRIds.dat");
	    }
	}
}

function getABInfo($filename) {
	$json = file_get_contents($filename);
	$json_data = json_decode($json,true);
	return $json_data;
}

function cidr_match($ip, $cidr) {
    $outcome = false;
    $pattern = '/^(([01]?\d?\d|2[0-4]\d|25[0-5])\.){3}([01]?\d?\d|2[0-4]\d|25[0-5])\/(\d{1}|[0-2]{1}\d{1}|3[0-2])$/';
    if (preg_match($pattern, $cidr)){
        list($subnet, $mask) = explode('/', $cidr);
        if (ip2long($ip) >> (32 - $mask) == ip2long($subnet) >> (32 - $mask)) {
            $outcome = true;
        }
    }
    return $outcome;
}

function getDMRGstat($dmrserver) {
	if (file_exists("/var/log/mmdvm/DMRGateway-".gmdate("Y-m-d").".log")) { $dmrstatus = exec('grep -a \''.$dmrserver.', Logged\|'.$dmrserver.', Closing DMR\|'.$dmrserver.', Opening DMR\|'.$dmrserver.', Connection\' /var/log/mmdvm/DMRGateway-'.gmdate("Y-m-d").'.log | tail -1 | awk \'{print $5}\'');
        } else { $dmrstatus = exec('grep -a \''.$dmrserver.', Logged\|'.$dmrserver.', Closing DMR\|'.$dmrserver.', Opening DMR\|'.$dmrserver.', Connection\' /var/log/mmdvm/DMRGateway-'.gmdate("Y-m-d", time() - 86340).'.log | tail -1 | awk \'{print $5}\''); }
	$dmrserver = str_replace('_', ' ', $dmrserver);
	if (strlen($dmrserver) > 19) { $dmrserver = substr($dmrserver, 0, 17) . '..'; }
	if (strpos($dmrstatus, 'Logged') !== false ) {
    return "<tr><td  style=\"background: #ffffed;\" colspan=\"2\"><span style=\"color:#b5651d;font-weight: bold\">".$dmrserver."</span></td></tr>\n";
  } else if (strpos($dmrstatus, 'Opening') !== false || strpos($dmrstatus, 'Closing') !== false || strpos($dmrstatus, 'Connection') !== false) {
    return "<tr><td  style=\"background: #ffffed;\" colspan=\"2\"><span style=\"color:#b0b0b0;font-weight: bold\">".$dmrserver."</span></td></tr>\n"; }
}

function dvsmu_info($cur_user){
  $user_dir     = shell_exec('ls -d /opt/user*');
  $user_dir     = str_replace("opt/", '', $user_dir);
  $USER_list    = explode('/', $user_dir);
  $USER_list[0] = 'MAIN';
  $dvsmu_json   = '/tmp/dvsmu.json';
  $muInfo       = read_dvsmu();
  if (file_exists($dvsmu_json) and (count($muInfo)-1)==count($USER_list)) {$USER_list = [$cur_user];}

  $br = '<br>';
  // $muInfo['CUR_USER'] = array('User'=> $cur_user);
  foreach ($USER_list as $key => $user) {
    $user   = trim($user);
    $AB_ini = '/opt/'.str_replace('MAIN', 'Analog_Bridge', $user).'/Analog_Bridge.ini';
    $AB_INI = parse_ini_file($AB_ini, true);
    $rxPort = $AB_INI['USRP']['rxPort'];

    if ($user=='MAIN') {$user_no=''              ; $mb_path='/opt/MMDVM_Bridge' ; $pcmPort='2222'       ; $wsPort='8080'       ;}
    else               {$user_no=substr($user,-2); $mb_path='/opt/user'.$user_no; $pcmPort='20'.$user_no; $wsPort='80'.$user_no;}

    $file_ABInfo = '/tmp/ABInfo_'.$rxPort.'.json';
    $ABInfo    = json_rw('R', $file_ABInfo); // getABInfo($file_ABInfo);
    $ambe_mode = $ABInfo['tlv']['ambe_mode'];
    $last_tune = $ABInfo['last_tune'];
    $callsign  = $ABInfo['digital']['call'];
    $dmrid     = $ABInfo['digital']['rpt'];
    $tg        = $ABInfo['digital']['tg']; if ($ambe_mode=='DSTAR') {$tg=$last_tune;}

    if ($user=='MAIN') {
      $Alias='dvsMU Main';
    } else {
      $rtn = shell_exec("sed -n '/talkerAlias/p' /var/lib/dvswitch/dvs/var".$user_no.".txt");
      list($dumy, $Alias) = explode('=', $rtn); $Alias = trim($Alias);
      if ($Alias=='') {$Alias='dvs_'.$callsign;} else {$Alias = trim($Alias);}
    }

    if ($user==$cur_user) {
      $muInfo['CUR_USER'] = array('User'=> $cur_user, 'file_ABInfo'=> $file_ABInfo, 'ambe_mode'=> $ambe_mode, 'tg'=> $tg);
    }

    $muInfo[$user] = array('CALL'=> $callsign, 'dmrid'=>$dmrid, 'Alias'=> $Alias, 'tg'=>$tg, 'rxPort'=>$rxPort, 'pcmPort'=> $pcmPort,
                           'wsPort'=> $wsPort, 'MMDVMLOGPREFIX'=> 'MMDVM_Bridge'.$user_no, 'MMDVMINIPATH'=> $mb_path);
  }
  $dvsmu_json = '/tmp/dvsmu.json';
  json_rw('W', $dvsmu_json, $muInfo);
  webproxy_activate($USER_list);
  return $muInfo;
}

function read_dvsmu() {
  $dvsmu_json = '/tmp/dvsmu.json';
  if (file_exists($dvsmu_json)) {$muInfo=json_rw('R', $dvsmu_json);}
  else                          {$muInfo=array();}
  return $muInfo;
}

function read_ABInfo() {
  $muInfo      = read_dvsmu();
  $file_ABInfo = $muInfo['CUR_USER']['file_ABInfo'];
  $ABInfo      = json_rw('R', $file_ABInfo);
  return $ABInfo;
}

function webproxy_activate($USER_list) {
  $all_webproxy = '';
  $all_AB_ini   = '';
  foreach ($USER_list as $key => $user) {
    $user = trim($user);
    if   ($user=='MAIN') {continue;}
    else {$user_no = substr($user,-2);}

    $pcmPort         = '20'.$user_no;
    $wsPort          = '80'.$user_no;
    $svc_webproxy    = 'webproxy'.$user_no.'.service';
    $file_webproxy   = '/lib/systemd/system/'.$svc_webproxy;
    $file_AB_ini     = '/opt/'.$user.'/Analog_Bridge.ini';
    $webproxy_copy   = 'sudo cp /lib/systemd/system/webproxy.service '.$file_webproxy;
    $webproxy_modify = "sudo sed -i '/^ExecStart=/c\ExecStart=\/usr\/bin\/node \/opt\/Web_Proxy\/proxy.js ".$wsPort." ".$pcmPort." ' ".$file_webproxy;
    $AB_ini_modify   = "sudo sed -i '/^pcmPort = /c\pcmPort = ".$pcmPort." ' ".$file_AB_ini;

    $chk_running = "ps -ef | grep proxy.js | grep '".$wsPort." ".$pcmPort."'";
    $rtn = shell_exec($chk_running);
    if (!strpos($rtn, '/usr/bin/node')) {
      $all_webproxy .= 'webproxy'.$user_no.' ';
      $all_AB_ini   .= 'analog_bridge'.$user_no.' ';
      exec($webproxy_copy);
      exec($webproxy_modify);
      exec($AB_ini_modify  );
    }
  }

  if (strlen($all_webproxy)>0) {
    $enable_webproxy = 'sudo systemctl enable  '.$all_webproxy;
    $restart_web_AB  = 'sudo systemctl restart '.$all_webproxy.$all_AB_ini;
    exec($enable_webproxy);
    exec($restart_web_AB );
  }
}

function call2info($call) {
  $call = trim($call);
  $call = str_replace('-RPT', '', $call);
  $name1 = $name2 = $addr1 = $addr2 = $addr3 = '';
  $dmrid = '1234567';
  $tz    = date("H:i:s ").'LocalTime';
  if     ($call==''      ) {list($name1,$addr1,$image_qrz,$image_flg)=['DVSwitch' ,'DVSwitch'   ,'./images/dvs.png','./images/dvs.png'];}
  elseif ($call=='MMDVM' ) {list($name1,$addr1,$image_qrz,$image_flg)=['Bridge'   ,'DVSWitch'   ,'./images/dvs.png','./images/dvs.png'];}
  elseif ($call=='4000'  ) {list($name1,$addr1,$image_qrz,$image_flg)=['UnLink'   ,'UnLink'     ,'./images/ulk.png','./images/ulk.png'];}
  elseif ($call=='450997') {list($name1,$addr1,$image_qrz,$image_flg)=['Echo Test','PARROT'     ,'./images/prt.png','./images/prt.png'];}
  elseif ($call=='4570'  ) {list($name1,$addr1,$image_qrz,$image_flg)=['DMR Plus' ,'IPSC2-Korea','./images/dps.png','./images/dps.png'];}
  else {
    $image_qrz = './qrz_photo/'.$call.'.png';
    $image_flg = './flag/'.call2flag($call);
    if (file_exists($image_qrz))   {$image_qrz = './qrz_photo/'.$call.'.png';}
    elseif (call_img_exist($call)) {$image_qrz = './qrz_photo/'.$call.'.png';}
    else {
      $qrz_url   = 'https://www.qrz.com/db/'.$call;
      $qrz_data  = file_get_contents($qrz_url);
      $temp_str  = explode('<meta property="og:image" content=', $qrz_data);
      // echo '<br>?---> ', count($temp_str);
      if (count($temp_str)==1) {
        $image_qrz='./images/no_qrz.png';
      } else {
        $temp_str  = explode('/>', $temp_str[1]);
        $image_url = str_replace('"', '', trim($temp_str[0]));
        if (strlen($image_url)<10) {$image_qrz='./images/no_qrz.png';}
        else {
          $image_qrz  = '/var/www/html/qrz_photo/'.$call.'.png';
          echo $image_qrz;
          $image_down = file_get_contents($image_url);
          if (!strpos($image_down, '!DOCTYPE')) {file_put_contents($image_qrz, $image_down);}
        }
      }
    }
    // 이름, 주소
    $data = shell_exec('cat /var/www/html/images/user.csv | grep ,'.$call.',');
    $data = explode("\n", $data);
    if (substr_count($data[0], ',')==6) {
      list($dmrid, $callsign, $name1, $name2, $addr1, $addr2, $addr3) = explode(',', $data[0]);
    } else {
      list($dmrid, $callsign, $name1, $name2, $addr1, $addr2, $addr3) = array('no dmrid', $call, 'no info in user db', '', call2flag($call, FALSE), '', '');
    }
    $tz = timezone($addr2.','.$addr3);
  }
  $name    = $name1.' '.$name2;
  $address = $addr1.' '.$addr2.' '.$addr3;
  if (strlen($address)>40) {$addr_font='font-size:10pt';}
  else                     {$addr_font='font-size:12pt';}
  return array($call, $dmrid, $tz, $name, $address, $addr_font, $image_qrz, $image_flg);
}

function call_img_exist($call) {
  $image_url = 'http://usrp.duckdns.org/PHOTO/'.$call.'.png';
  $image_qrz = '/var/www/html/qrz_photo/'.$call.'.png';
  $fh   = @get_headers($file);
  if (stripos($fh[0],"404 Not Found")>0 or (stripos($fh[0], "302 Found")>0 && stripos($fh[7], "404 Not Found") > 0)) {
    return false;
  } elseif (file_exists($image_qrz)) {
    $image_data = file_get_contents($image_url);
    if (strlen($image_data)==0) {return false;}
    file_put_contents($image_qrz, $image_data);
    return true;
  } else {return False;}
}

function call2flag($call, $TF=TRUE) {
  if     ($call=='4000') {return 'ulk.png';}
  elseif ($call=='4570') {return 'dmrplus.png';}
  $call = trim($call);
  $file = '/var/www/html/images/prefix.json';
  $json = file_get_contents($file);
  $FLAG = json_decode($json, true);
  $rtnF = 'XX.png';
  for( $i=1 ; $i<(strlen($call)+1) ; $i++ ) {
    $prefix = substr($call, 0, $i);
    if(array_key_exists($prefix, $FLAG)) {
      $rtnF = $FLAG[$prefix]['flag_no'].'.png';
      $rtnC = $FLAG[$prefix]['country'];
    }
  }
  if ($TF) {return $rtnF;}
  else     {return $rtnC;}
}

function timezone($city_country) {
  list($city, $country) = explode(',', $city_country);
  $file = '/var/www/html/images/timezone.json';
  $json = file_get_contents($file);
  $TIME_ZONE = json_decode($json, true);
  if     (array_key_exists($city_country, $TIME_ZONE)) {$tz=$TIME_ZONE[$city_country];}
  elseif (array_key_exists($country     , $TIME_ZONE)) {$tz=$TIME_ZONE[$country]     ;}
  else                                                 {$tz='Asia/Seoul'             ;}

  // Local Time
  $dt  = new DateTime("now", new DateTimeZone($tz));
  $rtn = $dt->format('H:i:s');

  // Standard Time Zone Name
  $timezone  = new DateTimeZone($tz);
  $date_time = new DateTime('now', $timezone);
  $std = $date_time->format('T');

  return $rtn.' '.$std;
}

function json_rw($key, $file, $array=array()) {
  if ($key=='R' or $key=='r') {
    $data  = file_get_contents($file);
    $array = json_decode($data, true);
    return $array;
  } elseif ($key=='W' or $key=='w'){
    $data = json_encode($array, JSON_PRETTY_PRINT);
    file_put_contents($file, $data);
    return $array;
  } else { return $array; }
}

function down_user_csv() {
  $user_csv = '/var/www/html/images/user.csv';
  $cmd_down = 'sudo wget -O /var/www/html/images/user.csv usrp.duckdns.org/user.csv';
  if (!file_exists($user_csv)) {
    exec($cmd_down);
  } else {
    $mtime    = filemtime($user_csv);
    $filesize = filesize($user_csv);
    if ((time()-$mtime)>3600*24*2 or $filesize < 13000000) {exec($cmd_down);}
  }
}

function read_tgInfo() {
  $file_tgInfo = '/tmp/tgInfo.json';
  if (!file_exists($file_tgInfo) or ((time()-filemtime($file_tgInfo))>3600*24)) {
    $tgsInfo = array();
    $modes   = array('DMR', 'DSTAR', 'NXDN', 'P25', 'YSF');
    foreach ($modes as $key => $mode) {
      $file_fvrt  = '/var/lib/dvswitch/dvs/tgdb/'.$mode.'_fvrt_list.txt';
      if (file_exists($file_fvrt)) {
        $read_tgs = file_get_contents($file_fvrt);
        $line_tgs = explode("\n", $read_tgs);
        $tgsInfo[$mode] = array();
        foreach ($line_tgs as $key => $tg_tgs) {
          $tg_tgs = trim($tg_tgs);
          if (strpos($tg_tgs, '|||')==0) {continue;}
          list($tg, $tgs) = explode('|||', $tg_tgs);
          $tgsInfo[$mode][$tg] = $tgs;
        }
      }
    }
    json_rw('W', $file_tgInfo, $tgsInfo);
  } else {
    $tgInfo = json_rw('R', $file_tgInfo);
  }
  return $tgInfo;
}

?>

<?php

  error_reporting(E_ALL & ~E_NOTICE);           // Report all errors except E_NOTICE

  $file = '/tmp/dvsmu.json';
  if (file_exists($file)) {
    $data  = file_get_contents($file);
    $DVSMU = json_decode($data, true);
    $cur_user = $DVSMU['CUR_USER'];
    $txPort   = $DVSMU[$cur_user]['txPort'];
    $prefix   = $DVSMU[$cur_user]['MMDVMLOGPREFIX'];
    $mb_path  = $DVSMU[$cur_user]['MMDVMINIPATH'];
  } else {
    $AB_ini   = '/opt/Analog_Bridge/Analog_Bridge.ini';
    $AB_INI   = parse_ini_file($AB_ini, true);
    $rxPort   = $AB_INI['USRP']['rxPort'];
    $prefix   = 'MMDVM_Bridge';
    $mb_path  = '/opt/MMDVM_Bridge/';
  }
                                                                    // Put remote Network or IP address from which want to see tooltip ABInfo
  define("REMOTENET"               , "127.0.0.1/32"          );     // IP address has mast /32 for netoworks use /24 etc
define("ABINFO","50385");
define("ABINFO","50385");
  define("RXMONITOR"               ,"YES"                    );     // RX Monitor                YES = enabled or NO = disabled
  define("DISPLAYNAME"             ,"YES"                    );     // Display NAME on Dashboard YES = enable  or NO = disable
  define("LOGPATH"                 , "/var/log/mmdvm"        );
  define("MMDVMLOGPREFIX"          , $prefix                 );
  define("MMDVMINIPATH"            , $mb_path                );
  define("MMDVMINIFILENAME"        , "MMDVM_Bridge.ini"      );
  define("DMRIDDATPATH"            , "/var/lib/mmdvm"        );
  define("YSFGATEWAYLOGPREFIX"     , "YSFGateway"            );
  define("YSFGATEWAYINIPATH"       , "/opt/YSFGateway"       );
  define("YSFGATEWAYINIFILENAME"   , "YSFGateway.ini"        );
  define("P25GATEWAYLOGPREFIX"     , "P25Gateway"            );
  define("P25GATEWAYINIPATH"       , "/opt/P25Gateway"       );
  define("P25GATEWAYINIFILENAME"   , "P25Gateway.ini"        );
  define("NXDNGATEWAYLOGPREFIX"    , "NXDNGateway"           );
  define("NXDNGATEWAYINIPATH"      , "/opt/NXDNGateway"      );
  define("NXDNGATEWAYINIFILENAME"  , "NXDNGateway.ini"       );
  define("LINKLOGPATH"             , "/var/log/ircddbgateway");
  define("IRCDDBGATEWAY"           , "ircddbgatewayd"        );
  define("IRCDDBGATEWAYINIFILENAME", "/etc/ircddbgateway"    );

?>

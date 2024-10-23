<?php
  include_once dirname(dirname(__FILE__)).'/include/config.php';
  include_once dirname(dirname(__FILE__)).'/include/tools.php';
  include_once dirname(dirname(__FILE__)).'/include/functions.php';
  if (!isset($_GET['user'])){ $id='MAIN';} else {$id=$_GET['userid'];}
?>
<!-- <link href="css/css.php" type="text/css" rel="stylesheet" /> -->
<fieldset style="box-shadow:0 0 10px #999; background-color:#e8e8e8e8; width:600px;margin-top:0px;margin-left:0px;margin-right:0px;
          font-size:12px;border-top-left-radius: 10px; border-top-right-radius: 10px;border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
  <?php
    $file_dvsmu = '/tmp/dvsmu_json';
    $DVSMU      = json_rw('R', $file_dvsmu);
    $rxPort     = $DVSMU[$user]['rxPort'];
    $file_ABIfo = 'tmp/ABInfo_'.$rxPort.'.json';
    $ABInfo     = json_rw('R', $file_ABInfo);



    $ambeMode = $ABInfo['tlv']['ambe_mode'];
    $ambeMode = str_replace('D-Star', 'DSTAR', $ambeMode);
    $ambeMode = str_replace('YSFN'  , 'YSF'  , $ambeMode);
    foreach ($lastHeard as $key => $lh) {
      $mode = explode(' ', $lh[1])[0]; $mode = str_replace('D-Star', 'DSTAR', $mode);
      $call = $lh[2];
      $name = $lh[3];
      $time = $lh[0]; $tm = time()-3600*9-strtotime(date($time));
      if ($mode==$ambeMode) {break;}
    }

    $call = 'DS5QDR';
    list($call, $dmrid, $tz, $name, $address, $addr_font, $image_qrz, $image_flg) = call2info($call);
    echo $image_qrz, '===', $image_flg

    if       ($lh[5]== 'Net'and $lh[6]==null) {
      $status_bar='<tr><td colspan=3 style="background-color:blue; color:white">'.$call.' → '.$lh[1].' '.$lh[4].' Listening </td></tr>';
    } elseif ($lh[5]=='LNet'and $lh[6]==null) {
      $status_bar='<tr><td colspan=3 style="background-color:red ; color:white">'.$call.' → '.$lh[1].' '.$lh[4].' Transmit  </td></tr>';
    } else                                    {
      $status_bar='<tr><td colspan=3 style="background:#f7f7f7"> Standby </td></tr>';
      ?> <script type="text/javascript">
          gain_bar.setAttribute('data-val', 0);
       </script> <?php
    }

    echo '
      <style> img {border: 1px solid #555;} </style>
      <table style="margin-top:3px;">
        <tr><td rowspan=4 width=140px><a href=http://www.qrz.com/db/'.$call.' target=_blank>
                                      <img src='.$image_qrz.' width=115px height=96px></a></td>
            <td rowspan=4 width=140px>'.'<img src='.$image_flg.' width=115px height=100px></td>
            <th style=font-size:16pt id=call><b>'.$call.'</th>
            <th style=font-size:12pt><b>'.$dmrid.'</th>
            <th style=font-size:12pt><b>'.$tz.'</th>
        </tr>
        <tr><td colspan=3 style=font-size:14pt><b>'.$name.'</td></tr>
        <tr><td colspan=3 style='.$addr_font.' width=100%>'.$address.'</td>'.$status_bar.'</tr>
      </table>';
  ?>
</fieldset>

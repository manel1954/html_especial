<?php 
 exec("sudo systemctl restart hbmon");
 exec("sudo systemctl restart hblink");
header("Location:http://149.202.49.185:7085");

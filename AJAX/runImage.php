<?php
    $wport = rand(49151,65535);
    while(stest($_SERVER['SERVER_NAME'],$wport)){
        $wport = rand(49151,65535);
    }
    $sftport = $wport+1;
    while(stest($_SERVER['SERVER_NAME'],$sftport) && $sftport==$wport){
        $sftport = rand(49151,65535);
    }
    $name = $_REQUEST["img"];
    $command = "docker pull hub.docker.local:5000/$name";
    shell_exec($command);
    $command = "docker run -d -p $sftport:22 -p $wport:4200 --name $name hub.docker.local:5000/$name";
    shell_exec($command);
    echo json_encode(array($wport,$sftport));
    function stest($ip, $portt) {
        $fp = @fsockopen($ip, $portt, $errno, $errstr, 0.1);
        if (!$fp) {
            return false;
        } else {
            fclose($fp);
            return true;
        }
    }
?>
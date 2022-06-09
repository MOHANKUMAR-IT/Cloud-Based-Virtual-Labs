<?php
    ini_set('max_execution_time', 500);
    $name = $_REQUEST['name'];
     $userImage = $_REQUEST["userImage"];
     $img = $_REQUEST["img"];
     $pwd = $_REQUEST["pwd"];
     $dependencies = $_REQUEST["data"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "virtual labs";

    $conn = mysqli_connect($servername, $username, $password, $dbname);


    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT image FROM userimages WHERE image='$img'";
    $result = mysqli_query($conn, $sql);
  
    if (mysqli_num_rows($result) > 0) {
        echo "Image exists with same name";
        mysqli_close($conn);
    }
    else {
        $sql = "INSERT INTO userimages VALUES('$name','$img','$userImage','$pwd')";
        mysqli_query($conn,$sql);
        mysqli_close($conn);

        $wport = rand(49151,65535);
        while(stest($_SERVER['SERVER_NAME'],$wport)){
            $wport = rand(49151,65535);
        }
        $sftport = $wport+1;
        while(stest($_SERVER['SERVER_NAME'],$sftport) && $sftport==$wport){
            $sftport = rand(49151,65535);
        }

        if($dependencies=='.'){
            $command = `docker run -d --name $img -p $sftport:22 -p $wport:4200 -e SIAB_PASSWORD=$pwd -e SIAB_SSL=false -e SIAB_USER=$userImage -e SIAB_SUDO=true sspreitzer/shellinabox:latest`;
            shell_exec($command);
            echo json_encode(array($wport,$sftport));
        }
        else{
            buildImage($userImage,$img,$pwd,$dependencies,$wport,$sftport);
        }
    }

    function buildImage($usr,$img,$pwd,$dependencies,$wport,$sftport){
        $dockerfiledata = "FROM ".$dependencies;
        $dockerfiledata .= "
ENV SIAB_USERCSS='Normal:+/etc/shellinabox/options-enabled/00+Black-on-White.css,Reverse:-/etc/shellinabox/options-enabled/00_White-On-Black.css;Colors:+/etc/shellinabox/options-enabled/01+Color-Terminal.css,Monochrome:-/etc/shellinabox/options-enabled/01_Monochrome.css' \
SIAB_PORT=4200 \
SIAB_ADDUSER=true \
SIAB_USER=$usr \
SIAB_USERID=1000 \
SIAB_GROUP=$usr \
SIAB_GROUPID=1000 \
SIAB_PASSWORD=$pwd \
SIAB_SHELL=/bin/bash \
SIAB_HOME=/home/$usr \
SIAB_SUDO=true \
SIAB_SSL=false \
SIAB_SERVICE=/:LOGIN \
SIAB_PKGS=none \
SIAB_SCRIPT=none

RUN apt-get update && apt-get install -y openssl curl openssh-client sudo shellinabox && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    ln -sf '/etc/shellinabox/options-enabled/00+Black on White.css' \
    /etc/shellinabox/options-enabled/00+Black-on-White.css && \
    ln -sf '/etc/shellinabox/options-enabled/00_White On Black.css' \
    /etc/shellinabox/options-enabled/00_White-On-Black.css && \
    ln -sf '/etc/shellinabox/options-enabled/01+Color Terminal.css' \
    /etc/shellinabox/options-enabled/01+Color-Terminal.css

EXPOSE 4200
EXPOSE 80
EXPOSE 443
VOLUME /etc/shellinabox /var/log/supervisor /home

ADD assets/entrypoint.sh /usr/local/sbin/

ENTRYPOINT [\"entrypoint.sh\"]
CMD [\"shellinabox\"]";


        $dockerfilepath = "Engine\\Dockerfile";
        $dockerfile = fopen($dockerfilepath, "w");
        fwrite($dockerfile, $dockerfiledata);
        fclose($dockerfile);
        $buildCommand = "cd c:\\xampp\htdocs\ITOM\AJAX\Engine && docker build -t  $img ."; 
        shell_exec($buildCommand);
        sleep(5);
        $buildCommand = "docker run -d --name $img -p $sftport:22 -p $wport:4200 $img ";
        shell_exec($buildCommand);
        echo json_encode(array($wport,$sftport));
    }
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
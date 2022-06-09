<?php
    $name = $_REQUEST["name"];
    $command = "docker stop $name";
    shell_exec($command);
    $command = "docker commit $name $name";
    shell_exec($command);
    $command = "docker tag $name hub.docker.local:5000/$name";
    shell_exec($command);
    $command = "docker push hub.docker.local:5000/$name";
    shell_exec($command);
    $command = "docker rmi -f hub.docker.local:5000/$name";
    shell_exec($command);
    $command = "docker rm hub.docker.local:5000/$name";
    shell_exec($command);
    $command = "docker rm $name";
    shell_exec($command);
    $command = "docker rmi -f $name";
    shell_exec($command);
    $command = "docker rmi -f $name";
    shell_exec($command);
    $command = 'docker image prune --filter="dangling=true" -f';
    shell_exec($command);
    echo "Commited Container Successfully";
?>
<?php
    $name = $_REQUEST["img"];

    $command = "docker rmi hub.docker.local:5000/$name";
    shell_exec($command);
    $command = "docker rm $name";
    shell_exec($command);
    $dir = "C:/localhub/registry/docker/registry/v2/repositories/$name";
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "virtual labs";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "DELETE FROM userimages where image='$name'";
    mysqli_query($conn, $sql);
    deleteDir($dir);
    echo "Image removed successfully";
    mysqli_close($conn);
   function deleteDir($dirPath) {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
?>
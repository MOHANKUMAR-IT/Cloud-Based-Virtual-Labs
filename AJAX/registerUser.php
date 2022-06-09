<?php
$user = $_REQUEST["usr"];
$pwd = $_REQUEST["pwd"];    
$pno = $_REQUEST["pno"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "virtual labs";

//Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: ".mysqli_connect_error());
}

$sql = "SELECT name, password FROM user where name='$user' and password='$pwd'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  echo 0;

} 
else {

    $sql = "INSERT INTO user VALUES('$user','$pwd','$pno')";
    mysqli_query($conn, $sql);
    echo 1;
}

mysqli_close($conn);
?>
<?php
$user = $_REQUEST["usr"];
$pwd = $_REQUEST["pwd"];    

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
$sql = "SELECT name, password FROM user where name='$user' and password='$pwd'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  // while($row = mysqli_fetch_assoc($result)) {
  //   echo "name:" . $row["name"]. " pass:".$row["password"]. "<br>";
  // }
  echo 1;
} else {
  echo 0;
}

mysqli_close($conn);
?>
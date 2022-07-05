<?php
$user = $_REQUEST["usr"];
 
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
$sql = "SELECT image FROM userimages where name='$user'";
$result = mysqli_query($conn, $sql);
$arr = array();
if($result)
if (mysqli_num_rows($result) > 0) {
    //output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $arr[]=$row;
    }
} 
echo JSON_encode($arr);
mysqli_close($conn);
?>
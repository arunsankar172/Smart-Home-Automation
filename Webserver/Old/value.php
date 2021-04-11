<?php
$servername = "localhost";   //servername
$username = "test";			 //username
$password = "1234";   //Password for Database
$dbname = "data";			 //Database name
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$id=$_GET["id"];
//$dat=$_POST['nam'];
$res= mysqli_query($conn,"SELECT val FROM state where id='".$id."'" );
$row = mysqli_fetch_assoc($res);
$st1=$row['val'];
echo $st1;
mysqli_close($conn);
?>

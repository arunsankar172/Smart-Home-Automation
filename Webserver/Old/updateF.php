<?php
$servername = "localhost";   //servername
$username = "test";			 //username
$password = "1234";   //Password for Database
$dbname = "data";			 //Database name
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$ids=$_GET["id"];
$val=$_GET["val"];
 $sql = "UPDATE state SET val='".$val."' WHERE id='".$ids."'";
if (mysqli_query($conn, $sql)) {
    echo "Updated";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);
?>

<?php
$servername = "localhost";
$dbname = "switchdata";
$username = "debian-sys-maint";
$password = "j9pqeKJ1oAmvElkW";	
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$ids=$_POST["id"];
$val=$_POST["val"];
$sql = "UPDATE switch SET state='".$val."' WHERE id='".$ids."'";
if (mysqli_query($conn, $sql)) {
    			//After Inertation
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);
?>

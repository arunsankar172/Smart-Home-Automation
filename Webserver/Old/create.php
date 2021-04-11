<?php
$servername = "localhost";
$username = "test";
$password = "1234";
$dbname = "data";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>


<!DOCTYPE html>
<html>
<head>
<style> 
body{
    font-family:verdana;
    font-size:px;
}
input[type=text] {
  width: 50%;
  padding: 12px;
  margin: 8px 0;
  font-size:18px;
  box-sizing: border-box;
  border: 3px solid red;
  border-radius: 6px;
}
.button {
  background-color: #a8321b;
  border: none;
  color: white;
  padding: 12px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  border-radius:6px;
  cursor: pointer;
}
</style>
</head>
<body>

<center>
<h1>P10 Board Input</h1>

<form action="create.php" method="POST">
  <label for="sname">Switch Name</label><br>
  <input type="text" id="sname" name="sname"><br>
  <label for="szid">Switch Zone Id</label><br>
  <input type="text" id="szid" name="switch_zone"><br><br>
  <input style="width:8%;background-color:green" type='submit' name="add" class="button"value="Add">
</form>

</center>


<?php
if(isset($_POST['add'])){
	$nam=$_POST['sname'];
	$szid=$_POST['switch_zone'];
	$val="OFF";
	$sql="INSERT INTO state (sname,switch_zone,val) VALUES ('".$nam."','".$szid."','".$val."')";
	if (mysqli_query($conn, $sql)) {
    echo "Switch Added successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
?>

</body>
</html>


<?php
$conn->close();
?>
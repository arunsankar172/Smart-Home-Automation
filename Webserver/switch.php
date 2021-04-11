<?php
date_default_timezone_set("Asia/Kolkata");
$t= date("H:i");
$now=strtotime($t);
$s[6];
$i=0;

// $json = file_get_contents("https://api.openweathermap.org/data/2.5/weather?lat=11.60&lon=78.64&appid=ba026a484ed224298bb2091171361cf9&units=metric");
// $xml = json_decode($json,TRUE); 
// $xml1 = json_decode($json);
// $rain=$xml1->weather[0]->main;
// $temp=$xml["main"]["feels_like"];

$servername = "localhost";
$dbname = "switchdata";
$username = "root";
$password = "";

// $servername = "localhost";
// $dbname = "switchdata";
// $username = "debian-sys-maint";
// $password = "j9pqeKJ1oAmvElkW";


$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM switch";
$result = mysqli_query($conn, $sql);
$man=mysqli_fetch_assoc($result);
if($man["state"]==1){
if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    if($row["id"]>=2)
	echo $row["state"];
  }
}
else {
  echo "No Data !";
}
} 



else{
	for($i=0;$i<6;$i++){
	$s[$i]=0;
}
	
	if(($now>=strtotime("6:00")) && ($now<=strtotime("18:00"))){
	$s[0]=0;
	$s[4]=0;
	$s[3]=0;
}

	
	else{
	$s[0]=1;
	$s[3]=1;
	$s[4]=1;
	
	}
for($i=0;$i<6;$i++){
	echo $s[$i];
}
}
mysqli_close($conn);	
?>
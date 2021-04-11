<?php
date_default_timezone_set("Asia/Kolkata");
$t= date("H:i");
$now=strtotime($t);
echo $t;
echo "<br>";


if(($now>=strtotime("6:00")) && ($now<=strtotime("18:00"))){
echo "1";
}
else{
	echo "2";
}
?>
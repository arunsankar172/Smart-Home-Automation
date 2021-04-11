<?php
$servername = "localhost";
$dbname = "switchdata";
$username = "root";
$password = "";		 

// $username = "debian-sys-maint";
// $password = "j9pqeKJ1oAmvElkW";		 

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT id FROM switch ORDER BY id DESC LIMIT 1;"; 
$res= mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);
$ans= $row['id'];
?>
<!doctype html>
<html>
<head>
 <meta charset="UTF-8">
    <title>Dynamic switchs Creation IoT</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<style>
body{
	font-family:verdana;
}
.button {
  background-color:grey;
  border: none;
height:auto;
  color:white;
  border-radius:5px;
  padding: 15px 40px;
  text-align: center;
  text-decoration: none;
  position: relative;
  font-size: 16px;
  margin: 13px 12px;
  cursor: pointer;
}
.butn{
  color:#cc7a00;
  border-color:#660033;
  border-style:solid;
  border-width: 3px;;
  width:200px;
  float:left;
  border-radius:11px;
  margin-top:25px;
  padding-left:10px;
  margin-left:80px;
  height:80px;
}

.zone{
    width:75%;
    background-color:#d7dade;
    padding:22px;
    margin-top:3%;
    margin-bottom:7%;
    border-radius:15px;
    /* height:400px; */
}

#zf{
      font-size:25px;
      color:black;
  }

input[type=text] {
  width: 85%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 2px solid red;
  border-radius: 4px;
}
  @media only screen and (max-width: 360px) {
  .butn {
  width:180px;
  float:none;
  margin-top:25px;
  font-family:verdana;
  padding-left:10px;
  margin-left:20px;
  height:80px;
  }
.zone{
    /* height:1000px; */
}

	</style>


</head>
 <body>
    
	<center>
	<h1>Control Dashboard</h1>
	<div id="new" style="margin-bottom:20px;">
	<?php
	
	$res1= mysqli_query($conn,'SELECT DISTINCT(zone) FROM switch ');
	while($ro = mysqli_fetch_assoc($res1)) {
	    $resa= mysqli_query($conn,"SELECT COUNT(id) FROM switch WHERE zone LIKE '".$ro['zone']."'");
        $rs = mysqli_fetch_assoc($resa);
        $a=($rs['COUNT(id)']/2)*100+130;
        echo "<div class='zone' style='height:".$a."px;'>";
        echo "<h1 id='zf' style='font-weight:bold;'>Zone: ".$ro['zone']."</h1>";
        echo "<br>";	
	
	
	$res= mysqli_query($conn,"SELECT * FROM switch WHERE zone LIKE '".$ro['zone']."'");
	while($row = mysqli_fetch_assoc($res)) {
	$i=	$row['id'];
	$tet=$row["sname"];
	if($row["state"]==1){
		echo "<div class='butn'>";
		echo $tet;
		echo "<input type='button' id='".$i."' class=button value='ON' style='background-color:green'></div>";
	
	}
	else{
		echo "<div class='butn'>";
		echo $tet;
		echo "<input type='button' id='".$i."' class=button value='OFF' style='background-color:#a3a375'></div>";
	}
	
	}
	echo "</div>";
	}
?>
</div>
</center>
<script type="text/javascript">
$(document).ready(function() {
	for(i=1;i<=<?php echo $ans;?>;i++){
	
		$("#"+i+"").on('click', function () {
		var click = $(this).val();
		//alert(click);
   		if(click=="OFF"){
                $(this).css('background-color', 'green');
				$(this).attr('value', 'ON');
                //click  = false;
				
            } else {
                $(this).css('background-color', '#a3a375');
				$(this).attr('value', 'OFF');
                //click  = true;
            }   
			 if($(this).val()=="OFF"){
				 var ans=0;
			 }
			 else{
				 var ans=1;
			 }
			var ds=this.id;
                $.ajax({
                    url: "update.php",
                    method: "POST",
                    data: {
                        val: ans,id: ds
                    },
                    success: function(data) {
                        $('#result').html(data);
                    }
                });
	 });
}
});
</script>
	
	<div id="container">
	
	</div>
</body>
 <?php
mysqli_close($conn);
?>
</html>
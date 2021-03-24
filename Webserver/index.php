<?php
$servername = "localhost";   
$username = "test";			 
$password = "1234";   
$dbname = "data";			 

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT id FROM state ORDER BY id DESC LIMIT 1;"; 
$res= mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);
$ans= $row['id'];
//$st=$row['val'];
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

}

</style>


</head>
 <body>
 <center>
    <h1>IoT Lab ON/OFF Switch</h1>
    <h3 id="result"></h3>
    
	<br>

	<?php
$res1= mysqli_query($conn,'SELECT DISTINCT(switch_zone) FROM state ');
	while($ro = mysqli_fetch_assoc($res1)) {
        $resa= mysqli_query($conn,"SELECT COUNT(id) FROM state WHERE switch_zone LIKE '".$ro['switch_zone']."'");
        $rs = mysqli_fetch_assoc($resa);
        $a=80*$rs['COUNT(id)'];
        echo "<div class='zone' style='height:".$a."px;'>";
        echo "<h1 id='zf' style='font-weight:bold;'>Zone: ".$ro['switch_zone']."</h1>";
        echo "<br>";

	$res= mysqli_query($conn,"SELECT * FROM state WHERE switch_zone LIKE '".$ro['switch_zone']."'");
	while($row = mysqli_fetch_assoc($res)) {
	$st1=$row['val'];
	$ids=$row['id'];
	$tet=$row['sname'];
	$st2="ON";
	if(strcmp($st1,$st2)==0){
		echo "<div class='butn' style='padding: 15px;'>";
		echo $tet;
		echo "<input type='button' id='".$ids."' class=button value='ON' style='background-color:green;'></div>";
	
	}
	else{
		echo "<div class='butn' style='padding: 15px;'>";
		echo $tet;
		echo "<input type='button' id='".$ids."' class=button value='OFF' style='background-color:#a3a375;'></div>";
	}
}
echo "</div>";
    }

	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<br>";

	$sql2 = "SELECT * FROM power ORDER BY id DESC"; 
	$res2= mysqli_query($conn, $sql2);
	$row2 = mysqli_fetch_assoc($res2);
	
	$voltage=$row2['voltage'];
	$current=$row2['current'];
	echo "Voltage Value is: ";
	echo $voltage;
	echo "<br>";
	echo "Current Reading : ";
	echo $current;
?>



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
			 var ans = $(this).val();
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

<script type="text/javascript">
	$(document).ready(function() {
	var k="<?php echo $ans ?>";
	$("#add").on('click', function () {
			$app=$("<input type='button' id="+k+" class=button value='OFF' style='background-color:#a3a375'>");
			$app.appendTo($("body"));
			});   
	$('#add').click(function() {
		var nes = $('#swi').val();
		//alert(nes);
            $.ajax({
            url: "create.php",
            method: "POST",
            data: {
				nam:nes
			},
            success: function(data) {
            $('#result').html(data);
            }
            });
			//window.location.reload();
			//window.location.reload();
		});
          
	});
</script>
	
	
	<div id="container">
	
	</div>
</body>
 <?php
mysqli_close($conn);
?>
</html>
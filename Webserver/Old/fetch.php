<?php
header('Content-Type: application/json');
$pdo=new PDO("mysql:dbname=data;host=10.10.110.2","test","1234");
		    $statement=$pdo->prepare("SELECT id,sname FROM state");
			$statement->execute();
			$results=$statement->fetchAll(PDO::FETCH_ASSOC);
			$json=json_encode($results);
			echo $json;
		
?>

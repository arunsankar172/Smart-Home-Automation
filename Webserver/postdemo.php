<?php
//Creates new record as per request
    //Connect to database
    $servername = "localhost";
    $username = "test";
    $password = "1234";
    $dbname = "data";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }

    //Get current date and time
    date_default_timezone_set('Asia/Kolkata');
    $d = date("Y-m-d");
    //echo " Date:".$d."<BR>";
    $t = date("H:i:s");

    if(!empty($_POST['voltage']) && !empty($_POST['current']))
    {
    	$voltage = $_POST['voltage'];
    	$current = $_POST['current'];

	    //$sql = "INSERT INTO power (current, voltage, Date, Time) VALUES ('".$current."', '".$voltage."', '".$d."', '".$t."')";

		$sql = "UPDATE power SET current='".$current."', voltage='".$voltage."', Date='".$d."', Time='".$t."' WHERE id=1";

		if ($conn->query($sql) === TRUE) {
		    echo "OK";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}


	$conn->close();
?>
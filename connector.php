

﻿<?php
	
	$hostname = "localhost";
	$username = "root";
	$password = "";
	
	$connector = new mysqli($hostname, $username, $password);
	
	$database = "bd_international_search";
	
	$sql = "CREATE DATABASE IF NOT EXISTS $database";
	if ($connector->query($sql) === TRUE) {
		//echo "Database created successfully";
	} else {
		//echo "Error creating database: " . $connector->error;
	}
	
	$connector = mysqli_connect($hostname, $username, $password, "bd_international_search");

?>
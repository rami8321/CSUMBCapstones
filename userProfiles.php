<?php

require "dbConnection.php";

$dbConn = getConnection();
		
$sql = "SELECT * FROM capstone_user WHERE username = :username";
$namedParameters = array();
$namedParameters[":username"] = $_POST['username'];

$stmt = $dbConn -> prepare($sql);
$stmt->execute($namedParameters);
$result = $stmt ->fetch();
return result;
?>
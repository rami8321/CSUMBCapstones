<?php

    <?php
	
	session_start();
	if(isset($_POST['signupForm'])){
			
		require '../dbConnection.php';
		$dbConn = getConnection();
		
		$sql = "INSERT INTO capston_user (firstName, lastName, username, email) VALUES (:fName, :lName, :email)";
		$stmt = $dbConn->prepare($sql);
		$stmt->execute(array(":fName" => $_POST['fName'],
                           ":lName" => $_POST['lName'],
                           ":email"=>$_POST['email'],
                           ":username"=>$_POST['username'],
                           ":password"=>sha1($_POST['password'])
                          ));
        
        $_SESSION["username"] = $result["username"];
        $_SESSION["profilePicture"] = $result["profilePicture"];
        header("Location: profile.php");
		
			
			
			
	}



?>
<?php
	
	session_start();
	if(isset($_POST['loginForm'])){
			
		require 'dbConnection.php';
		$dbConn = getConnection();
		
		$sql = "SELECT * FROM capstone_user
				WHERE username = :username 
				AND password= :password";
		$namedParameters = array();
		$namedParameters[":username"] = $_POST['username'];
		$namedParameters[":password"] = sha1($_POST['password']);
		
		$stmt = $dbConn -> prepare($sql);
		$stmt->execute($namedParameters);
		$result = $stmt ->fetch();
		
		if(empty($result)){
            $sql = "INSERT INTO logs (username, valid) VALUES (:username, :valid)";
        $stmt = $dbConn->prepare($sql);
        $namedParameters = array(":username"=> $_POST['username'],
							     ":valid"=> "Unsuccess");
        $stmt->execute($namedParameters);
			header("Location: login.html?error='wrong username'");
            
            
		}else if($result["username"] != "admin"){
			$_SESSION["username"] = $result["username"];
			$_SESSION["profilePicture"] = $result["profilePic"]; 
            $sql = "INSERT INTO logs (username, valid) VALUES (:username, :valid)";
        $stmt = $dbConn->prepare($sql);
        $namedParameters = array(":username"=> $result["username"],
							     ":valid"=> "Success");
        $stmt->execute($namedParameters);
			header("Location: homepage.php");
		}	
        else{
            $_SESSION["username"] = $result["username"];
			$_SESSION["profilePicture"] = $result["profilePic"];
			header("Location: adminHome.php");
        }
        
        
        
        
        
	}

    echo "HI EVERYBODY";

?>
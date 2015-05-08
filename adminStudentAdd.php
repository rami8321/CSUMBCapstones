<?php
	
	session_start();
    
	if(isset($_POST['signupForm'])){
			
		require 'dbConnection.php';
		$dbConn = getConnection();
		
		$sql = "INSERT INTO capstone_user (fName, lName, email, username, password) VALUES (:fName, :lName, :email,:username,:password)";
		$stmt = $dbConn->prepare($sql);
		$stmt->execute(array(":fName" => $_POST['fName'],
                           ":lName" => $_POST['lName'],
                           ":email"=>$_POST['email'],
                           ":username"=>$_POST['username'],
                           ":password"=>sha1($_POST['password'])
                          ));
        $_SESSION["username"] = $_POST['username'];
        
        $sql = "SELECT userId FROM capstone_user WHERE username = :userName";
		$namedParameters = array();
		$namedParameters[':userName'] = $_SESSION['username'];
		$stmt = $dbConn -> prepare($sql);
		$stmt -> execute($namedParameters);
		$id = $stmt -> fetch();
        
        $sql = "INSERT INTO capstone_profile (userId, about) VALUES (:userId, :about)";
		$stmt = $dbConn->prepare($sql);
		$stmt->execute(array(":userId" => $id['userId'],
                           ":about" => $_POST['about']
                          ));

            echo $_FILES['pictureName']['type'];
            echo $_FILES['pictureName']['name'];

            $imageType = exif_imagetype($_FILES['pictureName']['tmp_name']);//Returns 1, 2 or 3 for gif, jpg or png respectively 
            //if not 1,2 or 3 delete file -> unlink($_FILES[$fileName]['name']);
            if($imageType != 1 && $imageType !=2 && $imageType != 3){
                unlink($_FILES['pictureName']['name']);
            }else{
                $path = "img/" .  $_SESSION['username'];
                if(!file_exists($path)){//checks whether user's folder exists
                    mkdir($path);
                }

                move_uploaded_file($_FILES['pictureName']['tmp_name'], $path . "/". $_FILES['pictureName']['name']);
                $sql = "UPDATE capstone_user SET profilePic = :imageName WHERE username = :username";
                $namedParameters = array();
                $namedParameters[':imageName'] = $_FILES['pictureName']['name'];
                $namedParameters[':username'] = $_SESSION['username'];
                $dbConn = getConnection();
                $stmt = $dbConn->prepare($sql); //Preparing the statement
                $stmt->execute($namedParameters);
                $_SESSION["pofilePicture"] = $path . "/".$_FILES['pictureName']['name'];
            }
        
        
      
        header("Location: adminHome.php");
		
			
			
			
	}



?>
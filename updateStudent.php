<?php
session_start();
if (!isset($_SESSION['username'])){
    header("Location: index.php");
}

 if (isset($_GET['userId'])){
     
     $userId = $_GET['userId'];
     require 'dbConnection.php';
     $dbConn = getConnection();
     
     $sql = "SELECT * FROM capstone_user WHERE userId = :userId";
     $stmt = $dbConn -> prepare($sql);
     $stmt->execute(array(":userId"=>$userId));
     $res = $stmt->fetch();
     
 }

 if (isset($_POST['updateForm'])) {  
     
     $sql = "UPDATE capstone_user
             SET fName = :fName,
                    lName = :lName,
                    email = :email,
                    username = :username,
                    password = :password
             WHERE userId = :userId";
      $namedParameters = array();
      $namedParameters[":fName"] = $_POST['fName'];
      $namedParameters[":lName"] = $_POST['lName'];
      $namedParameters[":email"] = $_POST['email'];     
      $namedParameters[":username"] = $_POST['username'];     
      $namedParameters[":password"] = sha1($_POST['password']);         
      $namedParameters[":userId"] = $_POST['userId'];   
      $stmt = $dbConn -> prepare($sql);
      $stmt->execute($namedParameters);
      echo "Record has been updated!";
 }



?>

<a href="adminHome.php">Go Back to Admin Home</a><br />

<form method="post">
    
    Student Name: <input type="text" name="fName" value="<?=$res['fName']?>"> <br />
    Last Name <input type="text" name="lName" value="<?=$res['lName']?>"><br />
    Email <input type="text" name="email" value="<?=$res['email']?>"><br />
    Username: <input type="text" name="username" value="<?=$res['username']?>"><br />
    Password: <input type="text" name="password" value="<?=$res['password']?>"><br />
    <input type="hidden" name="userId" value="<?=$res['userId']?>"> 
    
    <input type="submit" name="updateForm" value="Update!">
    
</form>
<?php

session_start();

require "dbConnection.php";

    if(empty($_SESSION)){
        header("Location: login.html");
    }



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>CSUMB Capstones</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
     <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <link href="css/styles.css" rel="stylesheet" />
    <script type="text/css">
    .nav navbar-nav navbar-right{
        float: right;
    }
    </script>
    
    <style>
     #q1 img { cursor: pointer}
        
           .feedback{
           display: none;  
           }
           
        </style>
    
</head>
<body>

    <nav class="navbar navbar-inverse">
  <div class="container-fluid" style="background:#002a4e">
    <div class="navbar-header">
      <a class="navbar-brand" href="homepage.php">CSUMB Capstones</a>
    </div>
    <div>
      
      <ul class="nav navbar-nav navbar-right">
          <?php
                if(isset($_SESSION)){
                    echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>';
                }   

            ?>
        <li><a href="homepage.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
        <li><a href=""><span class="glyphicon glyphicon-edit"></span> Edit Page</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
  <div class="jumbotron">
    <div class="profilePicture">
      <?=$_SESSION['username']?><br/>
          
        
      <?php
      
      if(empty($_SESSION['profilePicture'])){
      	echo '<img style="border: 5px solid #CF634A" src="img/unknown.jpg" alt="Unknown user">';
      }else{
		echo '<img style="border: 5px solid #CF634A" src = "img/'. $_SESSION['username'] . '/'.$_SESSION['profilePicture'].'">';
      }
	    
		
		?>
        
      </div>
      
      
        <?php
 
        $sql = "SELECT fName, lName FROM capstone_user WHERE username = :username";
        $dbConn = getConnection();
        $stmt = $dbConn ->prepare($sql);
        $namedParameters2 = array();
		$namedParameters2[':username'] = $_SESSION['username'];
        $stmt-> execute($namedParameters2);
        $name = $stmt->fetch();

        ?>  
      
        <?php
        $sql = "SELECT userId FROM capstone_user WHERE username = :username";

        $dbConn = getConnection();
        $stmt = $dbConn ->prepare($sql);
        $namedParameters3 = array();
        $namedParameters3[':username'] = $_SESSION['username'];
        $stmt-> execute($namedParameters3);
        $userId = $stmt->fetch();

        $sql = "SELECT about FROM `capstone_profile` WHERE :userId = userId";

        $dbConn = getConnection();
        $stmt = $dbConn ->prepare($sql);
        $namedParameters4 = array();
        $namedParameters4[':userId'] = $userId['userId'];
        $stmt-> execute($namedParameters4);
        $about = $stmt->fetch();

        ?>
        
        <?php
            echo "<h1 style='color:#4193A6'> Hello ". $name['fName'] ." ".$name['lName']. "</h1>";

        ?>
     
      
      <?php
        echo "<h3 style='color:#002a4e'>About Me</h3>";
        echo "<h4> ".$about['about']. "</h4>";
      ?>
      
      
      <br/><br/> 
        Projects: Click on project(s)
      <br/><br/>
      <a href="homepage.php">
      <img style="border: 2px solid #002a4e" src="img/projects/1.png" alt="beyond binary" width="75" height="75" border="0">
      </a>

      <!--<div id = "q1">
       </div>-->

      <br/>
  </div>
    <footer style="text-align:center;">
     <p>&copy; Copyright  by CSUMB 2015</p>
    </footer>
    
    
</div>

</body>
</html>

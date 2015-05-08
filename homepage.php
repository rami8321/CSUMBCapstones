
<?php
//http://itcdland.csumb.edu/~capstone/index.php
require 'dbConnection.php';  

session_start();
function getStuff(){ 
    $dbConn = getConnection(); 
    $sql = "SELECT projectName, about FROM capstone_project"; 
    $stmt = $dbConn->prepare($sql); 
    $stmt->execute(); 
    return $stmt->fetchAll(); 
}

function getUsers($i){ 
    $dbConn = getConnection(); 
    $sql = "SELECT fName, lName, email FROM capstone_user JOIN capstone_project as p WHERE capstone_user.projectId = p.projectId
    and p.projectId = '$i'"; 
    $stmt = $dbConn->prepare($sql); 
    $stmt->execute(); 
    return $stmt->fetchAll(); 
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>CSUMB Capstones</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>		
		<script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    
    <script type="text/css">
    .nav navbar-nav navbar-right{
        float: right;
    }
    
    
    </script>
    
    
</head>
<body>

    <nav class="navbar navbar-inverse">
    <div class="container-fluid" style="background:#002a4e ">
        <div class="navbar-header">
            <a class="navbar-brand" href="homepage.php">CSUMB Capstones</a>
        </div>
        <div>
        <form class="navbar-form navbar-right" role="search">
            <div class="form-group">
                <input type="text" class="form-control" id = "user"placeholder="User search">
            </div>
            <button type="submit" class="btn btn-default" id = "userSearch"><span class="glyphicon glyphicon-search"></span>                    </button>
        </form>
          <ul class="nav navbar-nav navbar-right">
              <?php
                if(isset($_SESSION['username'])){
                    echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>';
                }   
                else{
                    echo '<li><a href="login.html"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
                }

            ?>
                     
            <li><a href="profiles.php"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
          </ul>
        </div>
    </div>
    </nav>
    
<div class="container">
  <div class="jumbotron" style="background-image:url('https://scontent-sjc.xx.fbcdn.net/hphotos-xpa1/t31.0-8/11187328_874470935959395_2193584303377549020_o.jpg');">
    <h1>Spring 2015 Capstone Festival</h1>
    <p style="padding-left:80px;">School of Information Technology and Communication Design</p> 
  </div>
    
    <?php 
         
        $i = 1;
        $projects = getStuff();
        //var_dump($appTypes);
        foreach ($projects as $type){
            
          echo '<div>' ;
          echo '<h3 style="color:#002a4e">'.$type['projectName'].'</h3>'; 
          echo '<img style="border: 2px solid #CF634A; float: left; border-radius: 10px"src="img/projects/'.$i.'.png">';
          //echo '<div style="padding:10px">';  
          echo '<p>'.$type['about'].'</p>';
          //echo '</div>';  
          echo '<div class="row">';  
            $user = getUsers($i);
            foreach ($user as $u){
            
            echo '<div class="col-sm-2">' ;
            echo '<h4 style="color: #4193A6">'.$u['fName'].' '.$u['lName'].'</h4>';   
            echo '<p>'.$u['email'].'</p>';
            echo '</div>';
                
            }
            echo '</div>';
          // echo '</br></br>';
            $i = $i + 1;
            echo '</div>';
        } 

         
        ?> 
    
    <footer>
     <p style="text-align:center;">&copy; Copyright  by CSUMB 2015</p>
    </footer>
    <script>
    
        $(document).ready(function(){
            $('#userSearch').click(function(){
            var user = $("#user").val();
            $.ajax({
            type: "get",
            url: "userProfiles.php",
            dataType: "json",
            data: {"username": $("#user").val()},
            success: function(data,status) {
                 alert(data['fName']);
            },
            complete: function(data,status) { //optional, used for debugging purposes
                 //alert(status);
            }
         })
         }
          )};
                          
    </script>
    
</div>

</body>
</html>

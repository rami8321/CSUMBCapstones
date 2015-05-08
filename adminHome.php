<?php
require 'dbConnection.php';
function getStudents()
{
    $dbConn = getConnection();
    $sql ="SELECT userId, fName FROM capstone_user ";  
    $stmt = $dbConn->prepare($sql);
	$stmt->execute();
	return $stmt->fetchAll();
}

function login()
{
    $dbConn = getConnection();
    $sql ="SELECT username, valid, date FROM logs ";  
    $stmt = $dbConn->prepare($sql);
	$stmt->execute();
	return $stmt->fetchAll();
}

?>
<?php
session_start();


if(!isset($_SESSION['username']))
{
    header("Location: login.html");
}

if(isset($_GET['deleteForm']))
{
    $dbConn = getConnection();
    echo "Deleteing record.....";
    $sql="DELETE FROM capstone_user WHERE userId = :userId";
    $namedParameters=array();
    $namedParameters[':userId'] =$_GET['userId'];
    $stmt = $dbConn->prepare($sql);
    $stmt->execute($namedParameters);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>CSUMB Capstones Admin Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
  <div class="container-fluid" style="background: #2A3769" style="color: white">
    <div class="navbar-header">
      <a class="navbar-brand" href="homepage.php">CSUMB Capstones</a>
    </div>
    <div>
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        
      </ul>
    </div>
  </div>
</nav>
<div class="container">
  <div class="jumbotron" style="background: #7EB762">
    <h1>Admin Homepage</h1>
    
  </div>
    
        <script>
        
            function confirmDeletion(fName)
            {
               
               var deleteResponse = confirm("Do you want to delete " + fName + " ?");
               if(!deleteResponse){
                   return false;
               }
               else
                   return true;
                
            }
            
        </script>
    </head>
    <body>
<?php
echo "<br/>";

?>
        
    
<h2>Add Student</h2>
     <form action="adminStudentAdd.php" method="post" enctype="multipart/form-data">
			First Name: <input type="text"name="fName"> </br><br/>
			Last Name: <input type="text" name="lName"></br><br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email: <input type ="text" name="email"> </br></br>
             About you:
            <textarea name="about" maxlength="200" cols="25" rows="5"></textarea><br/>
            Username: <input type="text" name="username"></br></br>
            Password: <input type="password" name="password" id = "password"/><span id="passwordError"></span><br /></br>
            Profile Picture: <input style="display: inline-block;"type="file" name="pictureName"/><br/><br/>
            Resume: <input style="display: inline-block;"type="file" name="resumeName"/><br/><br/>
			<input type="submit" name="signupForm" class= "btn btn-success" value="Add Student" />
			
		</form><br/><br/><br/>
<h2>Edit/Delete Students</h2>

    

<?php
    $students = getStudents();

    foreach($students as $s)
    {
        echo "<tr>";
        echo "<td>" . $s['fName'] . "</td>";
?>
    <td>
    <form action="updateStudent.php">
        <input type="hidden" name="userId" value="<?=$s['userId']?>"/>
        <input type="submit" value="update" name="updateForm"/>
        
    </form>
    </td>
    <td>
<form onsubmit="return confirmDeletion('<?=$s['fName']?>')">
        <input type="hidden" name="userId" value="<?=$s['userId']?>"/>
        <input type="submit" value="Delete " name="deleteForm"/>
        
    </form>
    </td>
    

<?php
        
    }//closes for loop

?>

    </table>
<br/><br/>

<h2>Log Report</h2><br/>
<table width="600" border="1" cellspacing=".5">
      	<tr>
      		<th>Username</th>
      		<th>Password Attempt</th>
      		<th>Date</th>
      		
      	</tr>
      	<?php
      	$logs = login();

    foreach($logs as $l)
    {
        echo "<tr>";
        echo "<td>" . $l['username'] . "</td>";
        echo "<td>" . $l['valid'] . "</td>";
        echo "<td>" . $l['date'] . "</td>";
      		
				
				
				echo "</tr>";
      		}
      	?>
      	
      	
      </table>






    </body>
</html>













<?php
session_start();
require 'inc/conn.php';
$_SESSION['from'] = "update";
$error1 = null;
$error2= null;
if(isset($_POST['update1'])){
	$make = $_POST['make1'];
	
	 $select="SELECT * FROM `maketable` WHERE name =? ";
     $stmt = mysqli_stmt_init($conn);
     if(!mysqli_stmt_prepare($stmt, $select)){
        echo "Error";
     } else {
        mysqli_stmt_bind_param($stmt, "s" ,$make);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $num=mysqli_num_rows($result);
     }
        

        if ($num == 0){
             //Create registration query
            $reg="INSERT INTO `maketable`(`name`) VALUES (?)";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$reg)){
                echo "Errrror";
            } else {
                mysqli_stmt_bind_param($stmt, "s" , $make);
                mysqli_stmt_execute($stmt);
                header('Location:update.php');
            }
                 
        } else{
           $error1 = "Motorcycle make already exists" ;//For security purposes die
        }
            

     }

//add model
if(isset($_POST['update2'])){
	$make2 = $_POST['make2'];
	$model = $_POST['model'];
	
	 $select = "SELECT * FROM `modeltable` WHERE model =? ";
     $stmt = mysqli_stmt_init($conn);
     if(!mysqli_stmt_prepare($stmt,$select)){
        echo "Error";
     } else {
        mysqli_stmt_bind_param($stmt, "s" ,$model);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        $num = mysqli_num_rows($results);

     }

    if ($num == 0){
        //Create registration query
            $reg2 ="INSERT INTO `modeltable` (mid,model) VALUES (?,?)";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$reg2)) {
                echo "Error";
            } else {
                mysqli_stmt_bind_param($stmt, "is" , $make2,$model);
                mysqli_stmt_execute($stmt);
                header('Location:update.php');
            }  
        }
    else{
          $error2 = "Motorcycle model already exists";  
        }
    

     }        

?>

<!DOCTYPE html>
<html>
<head>
	<title>ADMIN</title>
	<link rel="stylesheet" type="text/css" href="update.css">  
</head>
<body>
	<header class="header">
		<div class="wrapper">
                        <div class="logo">
                <i><b><font color="#fff" size="8px">BikerWorldKenya</font></b></i>
            </div>
            <ul class="nav-area">
                <li><a href="admin.php" id="links">Home</a></li>
                <li><a href="users.php" id="logolink">Users</a></li>
                <li><a href="dealerships.php" id="links">Dealerships</a></li>
                <li><a href="schools.php" id="links">Schools</a></li>
                <li><a href="garages.php" id="links">Garages</a></li>
                <li><a href="uploads.php" id="links">BikeUploads</a></li>
                <li><a href="gps.php" id="links">Gears&Parts</a></li>
                <li><a href="eventads.php" id="links">Events</a></li>
                <li><a href="update.php" id="links">Update Database</a></li>
                <li><a href="messages.php" id="links">Messages</a></li>
                <?php 
           if (isset($_SESSION['login_user'])) {
            echo  "<li><a href='logout.php' id='links'>Log out</a></li>" ;
              echo  "<li><h2>" .$_SESSION['login_user']. "<h2></li>";    
           }
           else{
              echo "<li><a href='login.php' id='links'>Login</a></li>";
           }
                ?>
             
            </ul>
        </div>
		<div class="form">
			<form action="update.php" method="post">
			<div class="update1">
				<h1>Add Motorcycle Make</h1><br>
                <h2><?php echo $error1; ?></h2><br>
				<input type="text" name="make1" placeholder="Add Make">
				<input type="submit" name="update1" value="Update">
				
			</div>
			<div class="update2">
				<h1>Add Motorcycle Model</h1><br>
                <h2><?php echo $error2; ?></h2><br>
				<select id="make2" name="make2">
                        <option value="">Make</option>
                        <?php
                       
                        $sql = "SELECT mid,name from maketable";
                        $result = mysqli_query($conn,$sql);
                  
                        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            echo ("<option value=\"{$row['mid']}\" " . ($pmenu == $row['mid'] ? " selected" : "") . ">{$row['name']}</option>");
                        }
                        ?>
                    </select>
				<input type="text" name="model" placeholder="Add Model">
				<input type="submit" name="update2" value="Update">
				
			</div>
			</form>
		</div>
	</header>
</body>
</html>
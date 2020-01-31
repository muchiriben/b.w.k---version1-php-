<?php
session_start();
require_once 'inc/conn.php';
$_SESSION['from'] = "admin";

?>
<!DOCTYPE html>
<html>
<head>
	<title>ADMIN</title>
	<link rel="stylesheet" type="text/css" href="admin.css">  
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
		<div class="welcome-text">
              <h2>Welcome Back Admin!!!</h2>
		</div>
	</header>
</body>
</html>
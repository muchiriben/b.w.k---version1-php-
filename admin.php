<?php
session_start();
require 'inc/conn.php';

if (!isset($_SESSION['login_user'])) {
  header("Location:error404");
  exit();
} else {
  if ($_SESSION['login_user'] != 'AdMiN') {
    header("Location:error404");
    exit();
  }
}

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
				<li><a href="admin" id="links">Home</a></li>
				<li><a href="users" id="logolink">Users</a></li>
				<li><a href="dealerships" id="links">Dealerships</a></li>
				<li><a href="ridingschools" id="links">Schools</a></li>
				<li><a href="allgarages" id="links">Garages</a></li>
				<li><a href="uploads" id="links">BikeUploads</a></li>
				<li><a href="gps" id="links">Gears&Parts</a></li>
		        <li><a href="allevents" id="links">Events</a></li>
		        <li><a href="update" id="links">Update Database</a></li>
		        <li><a href="messages" id="links">Messages</a></li>
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
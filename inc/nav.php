<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="nav.css">
</head>
<body>
    <div class="wrapper">
			<div class="logo">
				<p><b><font color="#fff" size="8px" >BikerWorldKenya</font></b></p>
			</div><br><br>
			<div class="user">	
				<?php 
           if (isset($_SESSION['login_user'])) {
           	  echo  "<a href='myprofile.php'>" .$_SESSION['login_user']. "</a>";    
           }else{ 
                echo  "<a href='login.php'>Log in/Sign up</a>";    
           }

		        ?>
           
			</div><br><br>
				<input type="checkbox" id="chk">
				<label for="chk" class="show-menu-btn">
					<i class="fas fa-bars"></i>
				</label>
			<ul class="nav-area">
				<li><a href="index.php" id="links">Home</a></li>
				<li><a href="shop.php"   id="links">Shop</a></li>
				<li><a href="rent.php" id="links">Rentals</a></li>
				<li><a href="schools.php" id="links">LearnToRide</a></li>
				<li><a href="events.php" id="links">Events</a></li>
				<li><a href="dealer.php" id="links">Dealerships</a></li>
				<li><a href="garages.php" id="links">Garages</a></li>
		        <li><a href="myprofile.php" id="links">MyProfile</a></li>
		        <li><a href="aboutus.php" id="links">AboutUs</a></li>
		        <?php 
           if (isset($_SESSION['login_user'])) {
           	echo  "<li><a href='logout.php' id='links'>Log out</a></li>" ;    
           }
		        ?>
		     
		     <label for="chk" class="hide-menu-btn">
		     	<li><i class="fas fa-times"></i></li>
		     </label>
			</ul>
		</div>
</body>
</html>

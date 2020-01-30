<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="nav.css">
</head>
<body>
    <div class="wrapper">
			<div class="logo">
				<p><b>BikerWorldKenya</b></p>
			</div><br><br>
			<div class="user">	
				<?php 
           if (isset($_SESSION['login_user'])) {
           	  echo  "<a href='myprofile'>" .$_SESSION['login_user']. "</a>";    
           }else{ 
                echo  "<a href='login'>Log in/Sign up</a>";    
           }

		        ?>
           
			</div><br><br>
				<input type="checkbox" id="chk">
				<label for="chk" class="show-menu-btn">
					<i class="fas fa-bars"></i>
				</label>
			<ul class="nav-area">
				<li><a href="index" id="links">Home</a></li>
				<li><a href="shop"   id="links">Shop</a></li>
				<li><a href="rent" id="links">Rentals</a></li>
				<li><a href="schools" id="links">LearnToRide</a></li>
				<li><a href="events" id="links">Events</a></li>
				<li><a href="dealer" id="links">Dealerships</a></li>
				<li><a href="garages" id="links">Garages</a></li>
		        <li><a href="myprofile" id="links">MyProfile</a></li>
		        <li><a href="aboutus" id="links">AboutUs</a></li>
		        <?php 
           if (isset($_SESSION['login_user'])) {
           	echo  "<li><a href='logout' id='links'>Log out</a></li>" ;    
           }
		        ?>
		     
		     <label for="chk" class="hide-menu-btn">
		     	<li><i class="fas fa-times"></i></li>
		     </label>
			</ul>
		</div>
</body>
</html>

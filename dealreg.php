<?php

$con = mysqli_connect('localhost','root','','sellmybike');
mysqli_select_db($con,'sellmybike');

if(isset($_POST['signup'])){

	$first = $_POST['fname'];
	$last = $_POST['sname'];
	$user = $_POST['uname'];
	$email = $_POST['email'];
	$pass = md5($_POST['pass']);
	$repass = md5($_POST['repass']);
	$_SESSION['uname'] = $user;

	 $select="SELECT * FROM `users` WHERE uname='$user' ";
    if (!$select){
        echo "Select Failed";
    } else{
    	$result=mysqli_query($con,$select);
        $num=mysqli_num_rows($result);
    }

        if ($num > 0){
            echo "UserName already taken <a href='signup.php'>Ok</a>" ;//For security purposes die
            die();
        }
        else{
            //Create registration query
            if($pass == $repass){
            $reg="INSERT INTO `users`(`fname`,`sname`, `uname`,`email`, `pass`, `repass`) VALUES ('$first', '$last','$user','$email','$pass','$repass')";
        }
        else{
        	echo "Password not same <a href='signup.php'>Ok</a>";

        }
        }
            if (!$reg){
                echo "Registration Query failed";
            }
            else{ 
            	mysqli_query($con,$reg);
                echo "Registration Successful";
                header('Location:login.php');
            }

}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Dealership Registration</title>
	<link rel="stylesheet" type="text/css" href="forms.css">
</head>
<body>
<header class="header">
		<div class="wrapper">
			<div class="logo">
				<img src="img/logo3.png" height="150px" width="150px;">
			</div>
			<ul class="nav-area">
				<li><a href="index.php" id="links">Home</a></li>
				<li><a href="sell.php" id="logolink">SellMyBike</a></li>
				<li><a href="Listings.php" id="links">Listings</a></li>
		        <li><a href="myprofile.php" id="links">My Profile</a></li>
		        <li><a href="search.php" id="links">Search</a></li>
		        <li><a href="search.php" id="links">Notifications</a></li>
		        <li><a href="aboutus.php" id="links">About Us</a></li>
		        <li><a href="login.php" id="links">Login</a></li>
			</ul>
		</div>

		<div class="form">
			<h1>Dealership Registration</h1>
			<form action="signup.php" method="post">
				<input type="text"     name="name"     placeholder="Dealership Name">
				<input type="text"     name="contact"  placeholder="Contact Number">
				<input type="email"    name="email"    placeholder="email">
				<input type="text"     name="location" placeholder="Location">
				<input type="password" name="pass"     placeholder="Password">
				<input type="submit"   name="signup"   value="Register">
			</form>
		</div>
	</header>
</body>
</html>
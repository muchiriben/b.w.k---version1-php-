<?php
session_start();
$_SESSION['from'] = "index";
require_once 'inc/conn.php';

//message admin
if(isset($_POST['send'])){
	$fname = mysqli_real_escape_string($conn, $_POST['fname']); 
	$sname = mysqli_real_escape_string($conn, $_POST['sname']);
	$email = mysqli_real_escape_string($conn, $_POST['mail']);
	$phone = mysqli_real_escape_string($conn, $_POST['phone']);
	$message = mysqli_real_escape_string($conn, $_POST['message']);
$mes = "INSERT INTO `messages`(`fname`,`sname`,`email`, `phone`,`message`) VALUES (?,?,?,?,?)";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $mes)){
	echo "error";
} else {

	mysqli_stmt_bind_param($stmt, "sssss" , $fname,$sname,$email,$phone,$message);
    mysqli_stmt_execute($stmt);
    header('location:index');
}


}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="index.css"> 
	<link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<header class="header">
		<?php require_once 'inc/nav.php'; ?>

<div class="slides">
        <input type="radio" name="r" id="r1" checked>
        <input type="radio" name="r" id="r2">
        <input type="radio" name="r" id="r3">
        <input type="radio" name="r" id="r4">
        <input type="radio" name="r" id="r5">

        <div class="slide s1">
          <h1>B.W.K - We are Family</h1><br>
          <h2>Join the Family</h2><br>
          <a href="signup">Braaap!!!</a>
        </div>
        <div class="slide">
          <h1>SHOP BikerWorldKenya</h1><br>
          <h2>Buy motorcycles, their parts and gears</h2><br>
          <a href="shop">Shop</a>
        </div>
        <div class="slide">
          <h1>Motorcycle rentals</h1><br>
          <h2>Rent a motorcycle when the time arises</h2><br>
          <a href="rent">Rentals</a>
        </div>
        <div class="slide">
          <h1>What you looking for?</h1><br>
          <h2>Dealerships, riding schools and garages</h2><br>
          <a href="schools">LearnToRide</a>
          <a href="dealer">Dealerships</a>
        </div>
        <div class="slide">
          <h1>View upcoming events</h1><br>
          <h2>Buy tickets for you favorite events</h2><br>
          <a href="events">Events</a>
        </div>
      </div><br>


      <div class="navigation">
        <label for="r1" class="bar"></label>
        <label for="r2" class="bar"></label>
        <label for="r3" class="bar"></label>
        <label for="r4" class="bar"></label>
        <label for="r5" class="bar"></label>
      </div>

	</header>

	<div class="bfooter" id="bfooter">
		<div class="all" id="all">
			<h1>Our Services</h1><br>
					<div class="Services">
					<a href="shop">Shop</a>
					<p>Looking to sell or buy a motorcycle,motorcycle parts or motorcycle gear?<br></p>
				</div>
				<div class="Services">
					<a href="rent">Rentals</a>
					<p>Need a motorcycle for 24hrs? Rent out your motorcylces and earn money.</p>
				</div>
				<div class="Services">
					<a href="schools">LearnToRide</a>
					<p>Want to learn how to ride? View all the best riding schools available in Kenya.</p>
				</div>
				<div class="Services">
					<a href="events">Events</a>
					<p>View the latest upcoming biking events.<br>Stay updated always.</p>
				</div>
				<div class="Services">
					<a href="dealer">Dealerships</a>
					<p>Find your favourite Dealership and Buy new bikes from them.</p>
				</div>
				<div class="Services">
					<a href="garages">Garages</a>
					<p>Bike giving you trouble?<br>Find the nearest garage around you.</p>
				</div>
             </div>
</div>
<footer class="footer">
	    <div class="help">
	    	<h1>Let Us Help You</h1><br><br>
	    	<a href="help-center">Help Center</a><br><br>
	    	<a href="contact-us">Contact Us</a><br><br>
	    	<a href="how-to-sell">How to sell on Bikerworld</a><br><br>
	    	<a href="safe">Safe Buying and Selling</a><br><br>
	    	<a href="faqs">FAQs</a>
	    </div> 
	    <div class="customer">
	    	<h1>About Us</h1><br><br>
            <a href="aboutus">About BikerWorld</a><br><br>
	    	<a href="terms">Terms and Conditions</a><br><br>
	    	<a href="policy">Privacy Policy</a>
	    </div>
 		<div class="form">
	        <h1>Contact Us</h1>
			<form action="index.php" method="POST">
				<input type="text" name="fname" placeholder="First Name" required>
				<input type="text" name="sname" placeholder="Second Name" required>
				<input type="email" name="mail" placeholder="Your Email" required>
				<input type="text" name="phone" placeholder="Phone Number: e.g 0712345678" required>
				<textarea name="message" placeholder="Your Message" required></textarea>
				<input type="submit" name="send" value="Send">
			</form>
	    </div> 	         
</footer>
<?php include_once 'inc/cpt.php'; ?>     
</body>
</html>

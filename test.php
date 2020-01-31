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
$mes="INSERT INTO `messages`(`fname`,`sname`,`email`, `phone`,`message`) VALUES ('$fname','$sname','$email','$phone','$message')";
$sql = mysqli_query($conn,$mes);
if ($sql) {
  header('location:index');
}

}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <link rel="stylesheet" type="text/css" href="test.css"> 
  <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <header class="header">
    <?php require_once 'inc/nav.php'; ?>
<br>
<div class="slider">
  <div class="slides">

    <div class="slide">
      <img src="img/enduro.jpg" width="1200px" height="450px">
    </div>
    <div class="slide">
      <img src="img/enduro.jpg" width="1200px" height="450px">
    </div>
    <div class="slide">
      <img src="img/enduro.jpg" width="1200px" height="450px">
    </div>
    <div class="slide">
      <img src="img/enduro.jpg" width="1200px" height="450px">
    </div>

  </div>
</div>
<div class="btnLeft fas fa-chevron-left"></div>
  <div class="btnRight fas fa-chevron-right"></div>
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
          <a href="school">LearnToRide</a>
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

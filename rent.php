<?php 
session_start();
$_SESSION['from'] = "rentals";
require_once "inc/conn.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Rentals</title>
	<link rel="stylesheet" type="text/css" href="shop.css">
    <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header class="header">
	<?php require_once "inc/nav.php"; ?>
	<div class="cat">
		<a href="rentad.php">RentYourBike</a>
	</div>
    
    <div class="cont">
    <h1>Rent a Bike</h1>
    <?php           
       $list = "SELECT * FROM rentals ORDER BY rand()";
       $result = mysqli_query($conn,$list);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$rid = $row["rid"];
$sid = $row["sid"];
$make = $row["make"];
$model =$row["model"];
$year = $row["year"];
$eng_size = $row["eng_size"];
$price = $row["price"];
$contact = $row["contact"];
$img1 = $row["leftim"]; 
$img2 = $row["rightim"]; 
$img3 = $row["backim"]; 
$img4 = $row["frontim"];   
   ?>
  
<div class="listings">  
<div class="img">
<?php
echo '<img src="data:image;base64,'.base64_encode( $row['frontim'] ).'" height="240px" width="440px">';
?>
</div>

<div class="desc">
 <p><?php echo "Make:\t" .$make; ?></p><br><br>
 <p><?php echo "Model:\t" .$model; ?></p><br><br>
 <p><?php echo "Year:\t" .$year; ?></p><br><br>
  <p><?php echo "Engine size:\t" .$eng_size. "cc" ;?></p><br><br>
 <p><?php echo "Price/hour:\t" .$price. "/="; ?></p><br><br>
 <p><?php echo "Contact Me:\t" .$contact; ?></p><br>
<a href="viewrental.php?id=<?php echo $row["rid"];?>" id="ref" name = "ref">View Listing</a>
</div>
</div>

<?php
}
}
?>
</div>
    </div>
</header>
<?php require_once 'inc/cpt.php'; ?>
</body>
</html>
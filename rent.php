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
		<a href="rentad">RentYourBike</a>
	</div>
    
    <div class="cont">
    <h1>Rent a Bike</h1>
    <?php           
       $list = "SELECT * FROM rentals ORDER BY rand()";
       
       //create prepared statement
       $stmt = mysqli_stmt_init($conn);

       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $list)) {

          echo "SQL STATEMENT FAILED";

       } else {

           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
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

<?php
/* encrypt url */
$data = $row["rid"];
$encrypt = $data*201820192020007;
$encode = "viewrental?v=" .urlencode(base64_encode($encrypt));
?>

<a href="<?=$encode;?>" id="ref" name = "ref">View Listing</a>
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

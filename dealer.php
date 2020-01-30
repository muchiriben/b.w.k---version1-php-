<?php 
session_start();
$_SESSION['from'] = "dealer";
require_once "inc/conn.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dealerships</title>
	<link rel="stylesheet" type="text/css" href="deal.css">
    <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header class="header">
	<?php require_once "inc/nav.php"; ?>
	<div class="cat">
		<a href="dealereg">Register Dealer</a>
	</div>
    
    <div class="cont">
    <h1>Dealerships</h1>
    <?php           
       $list = "SELECT * FROM dealers ORDER BY rand()";
       
       //create prepared statement
       $stmt = mysqli_stmt_init($conn);

       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $list)) {

          echo "SQL STATEMENT FAILED";

       } else {

           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
$did = $row["did"];
$dname = $row["dname"];
$location =$row["location"];
$pnumber = $row["pnumber"];
$email = $row["email"];
$web = $row["web"];
$slogan = $row["slogan"]; 
$logo = $row["logo"];   
   ?>
  
<div class="listings">
<div class="img">
<?php
if ($logo != null) {
  echo '<img src="data:image;base64,'.base64_encode( $logo ).'" height="240px" width="440px">';
}else{
  echo '<img src="img/logo_transparent.png" height="240px" width="440px">';
}
if ($slogan != null) {
  echo "<div class='slogan'><p>"  .$slogan. "</p></div>";
}
?>
</div><br>

<div class="desc">
 <p><?php echo "Dealer Name:\t" .$dname; ?></p><br><br>
 <p><?php echo "Location:\t" .$location; ?></p><br><br>
 <p><?php echo "Phone Number:\t" .$pnumber; ?></p><br><br>
 <p><?php echo "Email:\t" .$email; ?></p><br><br>
 <?php
   if ($web != null) {
     echo "<a href='" .$web. "'>Website</a>";
   }
 ?> 
 
<a href="dprofile?id=<?php echo $row["did"];?>" id="ref" name = "ref">Our Listings</a>
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

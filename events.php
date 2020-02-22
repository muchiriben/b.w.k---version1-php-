<?php 
session_start();
$_SESSION['from'] = "events";
require "inc/conn.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Events</title>
	<link rel="stylesheet" type="text/css" href="shop.css">
    <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header class="header">
	<?php require_once "inc/nav.php"; ?>
	<div class="cat">
		<a href="postevent">Post Event</a>
	</div>
    
    <div class="cont" id="contev">
    <h1>Coming Soon</h1>
    <?php           
       $list = "SELECT * FROM events ORDER BY rand()";
       
       //create prepared statement
       $stmt = mysqli_stmt_init($conn);

       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $list)) {

          echo "SQL STATEMENT FAILED";

       } else {

           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
$evid = $row["evid"];
$by_id = $row["by_id"];
$evname = $row["evname"];
$held_by = $row["held_by"];
$date = $row["date"];
$location =$row["location"];
$description = $row["description"]; 
$contact = $row["contact"];
$poster1 = $row["poster1"];
$poster2 = $row["poster2"];   
   ?>
  
<div class="listings">  
<div class="img" id="top">
<?php
echo '<img src="data:image;base64,'.base64_encode( $poster1 ).'">';
?>
</div>

<div class="desc">
 <p><?php echo "Event Name:\t" .$evname; ?></p><br>
 <p><?php echo "Held By:\t" .$held_by; ?></p><br>
 <p><?php echo "Date:\t" .$date; ?></p><br>
 <p><?php echo "At:\t" .$location; ?></p><br>
 <p><?php echo "Contact Us:\t" .$contact; ?></p><br><br>
 
<?php
/* encrypt url */
$data = $row["evid"];
$encrypt = $data*201820192020007;
$encode = "viewevent?v=" .urlencode(base64_encode($encrypt));
?>

<a href="<?=$encode;?>" id="ref" name = "ref">View Event</a>
</div><br>
<div class="img" id="bottom">
<?php
echo '<img src="data:image;base64,'.base64_encode( $poster2 ).'">';
?>
</div>
</div>

<?php
}
}
?>
</div>
</header>
<?php require_once 'inc/cpt.php';?>
</body>
</html>




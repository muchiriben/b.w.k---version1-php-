<?php 
session_start();
if (($_SESSION['login_user']) == null) {
  header("Location:login");
}
$_SESSION['from'] = "postev";
require_once "inc/conn.php";
$myusername = $_SESSION['login_user']; 
if(isset($_POST['post'])){

$evname = mysqli_real_escape_string($conn, $_POST["evname"]);
$held_by = mysqli_real_escape_string($conn, $_POST["held_by"]);
$date = mysqli_real_escape_string($conn, $_POST["date"]);
$location = mysqli_real_escape_string($conn, $_POST["location"]);
$description = mysqli_real_escape_string($conn, $_POST["description"]); 
$contact = mysqli_real_escape_string($conn, $_POST["contact"]);
   
$sidq = "SELECT sid FROM users WHERE uname =? ";
  //create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $sidq)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "s", $myusername);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
               $by_id = $row["sid"];
            }
         } 

$sell="INSERT INTO `events`(`by_id`,`evname`, `held_by`, `date`,`location`,`description`,`contact`) VALUES (?,?,?,?,?,?,?)";

$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sell)) {
  echo "SQL error";
} else {
  mysqli_stmt_bind_param($stmt, "issssss",$by_id,$evname,$held_by,$date,$location,$description,$contact);
  mysqli_stmt_execute($stmt);

 $last_id = mysqli_insert_id($conn);
 $_SESSION['present_ad'] = $last_id;
 header('location:evimg?v=' .$last_id );
}

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Post Event</title>
	<link rel="stylesheet" type="text/css" href="makead.css">
    <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header class="header">
	<?php require_once "inc/nav.php"; ?>
<div class="form">
	<h1>Event Details</h1>
<form action="postevent.php" method="post" name= "form" id="form">
<input type="text" placeholder="Event Name" name="evname" id="evname" required>
<input type="text" placeholder="Held By" name="held_by" id="held_by" required><br>
<input type="date" placeholder="Date" name="date" id="date" min="<?php echo date('Y-m-d'); ?>" required>
<input type="text" placeholder="Location" name="location" id="location" required><br>
<input type="text" placeholder="Description" name="description" id="description" maxlength="20" required>
<input type="text" placeholder="Contact number" name="contact" id="contact" required><br>
<input type="submit" value="Post" name="post">
</form> 
</div>
</header>
<?php require_once 'inc/cpt.php'; ?>
</body>
</html>

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
   
$byidq = "SELECT sid FROM users WHERE uname = '$myusername' ";
 $result = mysqli_query($conn,$byidq);
    if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
               $by_id = $row["sid"];
            }
         } 

$sell="INSERT INTO `events`(`by_id`,`evname`, `held_by`, `date`,`location`,`description`,`contact`) VALUES ('$by_id','$evname','$held_by','$date','$location','$description','$contact')";
 if (!$sell){
                echo "Registration Query failed";
            }
            else{ 
            	mysqli_query($conn,$sell);
                $last_id = mysqli_insert_id($conn);
                $_SESSION['present_ad'] = $last_id;
                header('location:evimg');  
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

<?php 
session_start();
if (($_SESSION['login_user']) == null) {
  header("Location:login");
}
$_SESSION['from'] = "postev";
require_once "inc/conn.php";
$myusername = $_SESSION['login_user'];
$usertype = $_SESSION['user_type'];
$error = null; 
if(isset($_POST['save'])){

$evname = mysqli_real_escape_string($conn, $_POST["evname"]);
$held_by = mysqli_real_escape_string($conn, $_POST["held_by"]);
$date = mysqli_real_escape_string($conn, $_POST["date"]);
$location = mysqli_real_escape_string($conn, $_POST["location"]);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$description = mysqli_real_escape_string($conn, $_POST["description"]); 
$contact = mysqli_real_escape_string($conn, $_POST["contact"]);

$ext = pathinfo($_FILES['poster1']['name']);
$ext1 = pathinfo($_FILES['poster2']['name']);
if ($ext["extension"] == "jpg" || $ext["extension"] == "jpeg" || $ext["extension"] == "png" || $ext["extension"] == "gif") {
       $frontim = $_FILES['poster1']['name']; 
       $first =  $_FILES['poster1']['tmp_name'];
       $imagetmp1= file_get_contents($first);  
} else {
      $error = "File uploaded is not an Image.";
}

if ($ext1["extension"] == "jpg" || $ext1["extension"] == "jpeg" || $ext1["extension"] == "png" || $ext1["extension"] == "gif") {
       $leftim = $_FILES['poster2']['name']; 
       $sec =  $_FILES['poster2']['tmp_name'];
       $imagetmp2= file_get_contents($sec);  
} else {
      $error = "File uploaded is not an Image.";
}




if($usertype == 'user') {
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
} elseif ($usertype == 'dealer') {
     $sidq = "SELECT did FROM dealers WHERE dname =? ";
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
               $by_id = $row["did"];
            }
         } 
}

if ($error == null) {
/* insert into databse */

$sell="INSERT INTO `events`(`by_id`,`user_type`,`evname`, `held_by`, `date`,`location`,`price`,`description`,`contact`,`poster1`, `poster2`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

$null = NULL;
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sell)) {
  echo "SQL error";
} else {
  mysqli_stmt_bind_param($stmt, "issssssssbb",$by_id,$usertype,$evname,$held_by,$date,$location,$price,$description,$contact,$null,$null);

$stmt->send_long_data(9, $imagetmp1);
$stmt->send_long_data(10, $imagetmp2);

mysqli_stmt_execute($stmt);

header('location:events');
}
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
<form action="postevent.php" method="post" name= "form" id="form" enctype="multipart/form-data">
  <div class="details">
    <h1>Event Details</h1><br>
    <font size="5" color="#fff"><?php echo $error; ?></font><br>
<input type="text" placeholder="Event Name" name="evname" id="evname" required>
<input type="text" placeholder="Held By" name="held_by" id="held_by" required><br>
<input type="date" placeholder="Date" name="date" id="date" min="<?php echo date('Y-m-d'); ?>" required>
<input type="text" placeholder="Location: e.g. Nairobi, South c" name="location" id="location" required><br>
<input type="text" placeholder="Price/per: e.g 2500" name="price" id="price" required>
<input type="text" placeholder="Contact: e.g. 0712345678" name="contact" id="contact" required><br>
<textarea name="description" id="description" placeholder="Description" required></textarea><br>
<a href="#" id="button">Next</a>
</div>

<script type="text/javascript">
  document.getElementById('button').addEventListener("click", function() {

   var errormessage = "";
   if(document.getElementById('evname').value == "") {
     errormessage += "Enter Event name \n";
     document.getElementById('evname').style.border = "2px solid #B40431";
   } else {
      document.getElementById('evname').style.border = "2px solid #fff";
   }

   if(document.getElementById('held_by').value == "") {
     errormessage += "Enter event holder \n";
     document.getElementById('held_by').style.border = "2px solid #B40431";
   } else {
      document.getElementById('held_by').style.border = "2px solid #fff";
   }

   if (document.getElementById('date').value == ""){
     errormessage += "Enter event date \n";
     document.getElementById('date').style.border = "2px solid #B40431";
   } else{
     document.getElementById('date').style.border = "2px solid #fff";
   }
   
   
   if(document.getElementById('location').value == "") {
     errormessage += "Enter event location \n";
     document.getElementById('location').style.border = "2px solid #B40431";
   } else {
      document.getElementById('location').style.border = "2px solid #fff";
   }

   if(document.getElementById('price').value == "") {
     errormessage += "Enter Price \n";
     document.getElementById('price').style.border = "2px solid #B40431";
   } else {
      document.getElementById('price').style.border = "2px solid #fff";
   }

   if(document.getElementById('contact').value == "") {
     errormessage += "Enter Contact \n";
     document.getElementById('contact').style.border = "2px solid #B40431";
   } else {
      document.getElementById('contact').style.border = "2px solid #fff";
   }

   if(document.getElementById('description').value == "") {
     errormessage += "Enter Description \n";
     document.getElementById('description').style.border = "2px solid #B40431";
   } else {
      document.getElementById('description').style.border = "2px solid #fff";
   }

   if (errormessage != "") {
     alert(errormessage);
     return false;
   } else {
     document.querySelector('.imgupload').style.display = "inline-block";
  document.querySelector('.details').style.display = "none";
   }
  
});
</script>

<div class="imgupload">
  <h1>UPLOAD IMAGES</h1><br>
     <input type="file" name="poster1" id="poster1" required><br>
     <input type="file" name="poster2" id="poster2" required><br>
     <input type="submit" name="save" value="Finish">
</div>
</form> 
</div>
</header>
<?php require_once 'inc/cpt.php'; ?>
</body>
</html>

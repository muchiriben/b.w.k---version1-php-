<?php
session_start();
require_once 'inc/conn.php';
$_SESSION['from'] = "editprofile";

if (($_SESSION['login_user']) == null) {
  header("Location:login");
}

$usertype = $_SESSION['user_type'];
$user = $_SESSION['login_user'];

if ($usertype == 'user') {
  
$list = "SELECT * FROM profiles WHERE uname =? ";
$stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $list)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "s", $user);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
                 $sid = $row['sid'];
                 $uname = $row['uname'];
                 $bio = $row['bio'];
                 $profilepic = $row['profilepic'];
            } 
              } 
          }

if(isset($_POST['save'])){
  $uname = mysqli_real_escape_string($conn, $_POST['name']);
  $bio = mysqli_real_escape_string($conn, $_POST['bio']);
  $picname = $_FILES['profilepic']['name']; 

if ($picname == null) {
  $edit ="UPDATE `profiles` SET uname=? , bio =?  WHERE uname =? ";
  $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $edit)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "sss", $uname, $bio, $user);
           //run parameters inside database
           mysqli_stmt_execute($stmt);    
          }
}else{

$ext = pathinfo($picname);
if ($ext["extension"] == "jpg" || $ext["extension"] == "jpeg" || $ext["extension"] == "png" || $ext["extension"] == "gif") {

  $pic = $_FILES['profilepic']['tmp_name'];
  $profilepic = file_get_contents($pic);

} else {
      $error = "File is not an Image.";
      exit();
}

  $edit ="UPDATE `profiles` SET uname=? , bio =? , profilepic =? WHERE uname =? ";
    
$null = NULL;
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $edit)) {
  echo "SQL error";
  exit();
} else {

  mysqli_stmt_bind_param($stmt, "ssbs", $uname,$bio,$null,$user);

$stmt->send_long_data(2, $profilepic);
  
mysqli_stmt_execute($stmt);
}
}

//update username in users table
$edit ="UPDATE `users` SET uname=? WHERE uname =? ";
$stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $edit)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "ss", $uname, $user);
           //run parameters inside database
           mysqli_stmt_execute($stmt);    
          }

$_SESSION['login_user'] = $uname;
header("Location:myprofile.php");            
}

} else if($usertype == 'dealer'){
     
$list = "SELECT * FROM dprofile WHERE dname =? ";
$stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $list)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "s", $user);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
                 $sid = $row['did'];
                 $uname = $row['dname'];
                 $bio = $row['bio'];
                 $profilepic = $row['profilepic'];
            } 
              } 
          }

if(isset($_POST['save'])){
  $uname = mysqli_real_escape_string($conn, $_POST['name']);
  $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $picname = $_FILES['profilepic']['name']; 

if ($picname == null) {
  $edit ="UPDATE `dprofile` SET dname=? , bio =?  WHERE dname =? ";
  $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $edit)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "sss", $uname, $bio, $user);
           //run parameters inside database
           mysqli_stmt_execute($stmt);    
          }
}else{

$ext = pathinfo($picname);
if ($ext["extension"] == "jpg" || $ext["extension"] == "jpeg" || $ext["extension"] == "png" || $ext["extension"] == "gif") {

  $pic = $_FILES['profilepic']['tmp_name'];
  $profilepic = file_get_contents($pic);

} else {
      $error = "File is not an Image.";
      exit();
}

  $edit ="UPDATE `dprofile` SET dname=? , bio =? , profilepic =? WHERE dname =? ";
    
$null = NULL;
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $edit)) {
  echo "SQL error";
  exit();
} else {

  mysqli_stmt_bind_param($stmt, "ssbs", $uname,$bio,$null,$user);

$stmt->send_long_data(2, $profilepic);
  
mysqli_stmt_execute($stmt);
}
}

//update dealers table
$edit ="UPDATE `dealers` SET dname =? , slogan =? , logo =? WHERE dname =? ";
$stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $edit)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           $null = NULL;
           mysqli_stmt_bind_param($stmt, "ssbs", $uname,$bio,$null,$user);
           //run parameters inside database
           $stmt->send_long_data(2, $profilepic);
           mysqli_stmt_execute($stmt);    
          }

$_SESSION['login_user'] = $uname;
header("Location:dealer_profile.php");            
}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Profile</title>
	<link rel="stylesheet" type="text/css" href="makead.css">
	<link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header class="header">
		<?php require_once 'inc/nav.php'; ?>
		<div class="form">
			<h1>EDIT PROFILE</h1><br><br>
			<form action="editprofile.php" method="post" enctype="multipart/form-data"> 
	           <font color="#fff"><label for="pic">Change Profile Pic:</label></font><br>
	            <input type="file" name="profilepic" id="profilepic"><br>
	            <font color="#fff"><label for="name">Change Username:</label></font><br>
	            <input type="text" name="name" id="name" placeholder="Username" maxlength="22" value="<?php echo $uname; ?>"><br>
	            <font color="#fff"><label for="bio">Edit Profile Bio:</label></font><br>
				<input id="bio" name="bio" placeholder="BIO" maxlength="30" value="<?php echo $bio ?>">
				<a href="changepass" name="ref" id="ref">Change Password</a>
				<input type="submit" name="save" id="save" value="Save">
			</form>
		</div>
	</header>
</body>
</html>
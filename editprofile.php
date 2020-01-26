<?php
session_start();
require_once 'inc/conn.php';
$_SESSION['from'] = "editprofile";

$user = $_SESSION['login_user'];
$list = "SELECT * FROM profiles WHERE uname = '$user'";
$result = mysqli_query($conn,$list);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
                 $sid = $row['sid'];
                 $uname = $row['uname'];
                 $bio = $row['bio'];
                 $profilepic = $row['profilepic'];
            } 
              }

if(isset($_POST['save'])){
	$picname = $_FILES['profilepic']['name'];
	$pic = $_FILES['profilepic']['tmp_name'];
	$profilepic = addslashes (file_get_contents($pic));
	$uname = mysqli_real_escape_string($conn, $_POST['name']);
	$bio = mysqli_real_escape_string($conn, $_POST['bio']);
 
if ($profilepic == null) {
	$edit ="UPDATE `profiles` SET uname='$uname', bio = '$bio' WHERE uname ='$user'";
}else{
	$edit ="UPDATE `profiles` SET uname='$uname', bio = '$bio', profilepic = '$profilepic' WHERE uname ='$user'";
}

$rs = mysqli_query($conn,$edit);
 if (!$rs){
                echo "Query failed";
            }
            else{ 
            $edit ="UPDATE `users` SET uname='$uname' WHERE uname ='$user'";
            $rs = mysqli_query($conn,$edit);
                $_SESSION['login_user'] = $uname;
                header("Location:myprofile.php");
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
				<input type="submit" name="save" id="save" value="Save">
			</form>
		</div>
	</header>
</body>
</html>
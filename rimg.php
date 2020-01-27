<?php
session_start();
include_once 'inc/conn.php';
$myusername = $_SESSION['login_user'];
$r_id = $_SESSION['present_ad'];


if (isset($_POST['save'])) {

if (getimagesize($_FILES['frontim']['tmp_name']) == false) {

echo "<br />Please Select An Image.";

} else {

$frontim = $_FILES['frontim']['name']; 
$leftim = $_FILES['leftim']['name'];
$rightim = $_FILES['rightim']['name'];
$backim = $_FILES['backim']['name'];

$front = $_FILES['frontim']['tmp_name'];
$left = $_FILES['leftim']['tmp_name'];
$right = $_FILES['rightim']['tmp_name'];
$back = $_FILES['backim']['tmp_name'];

//Get the content of the image and then add slashes to it 
$imagetmp1=addslashes (file_get_contents($front));
$imagetmp2=addslashes (file_get_contents($left));
$imagetmp3=addslashes (file_get_contents($right));
$imagetmp4=addslashes (file_get_contents($back));
          
$sell ="UPDATE `rentals` SET frontim='$imagetmp1',leftim = '$imagetmp2',rightim = '$imagetmp3',backim = '$imagetmp4' WHERE rid ='$r_id'";
$rs = mysqli_query($conn,$sell);
 if (!$rs){
                echo "Query failed";
            }
            else{ 
                header("Location:rent");
            }
}

}

?>

<!DOCTYPE html>
<html>
<head>
<title>Upload Image</title>
<link rel="stylesheet" type="text/css" href="makead.css">
<link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<header class="header">	
  <?php require_once 'inc/nav.php'; ?>
		<div class="form">
	<h1>UPLOAD IMAGES</h1>
<form action="rimg.php" method="post" enctype="multipart/form-data">
     <input type="file" name="frontim" id="frontim"><br>
     <input type="file" name="leftim" id="leftim"><br>
     <input type="file" name="rightim" id="rightim"><br>
     <input type="file" name="backim" id="backim"><br>
     <input type="submit" name="save" value="Finish">

</form>
</div>
</header>
</body>
</html>
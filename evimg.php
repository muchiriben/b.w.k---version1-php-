<?php
session_start();
include_once 'inc/conn.php';
$myusername = $_SESSION['login_user'];
$ev_id = $_SESSION['present_ad'];


if (isset($_POST['save'])) {

if (getimagesize($_FILES['poster1']['tmp_name']) == false) {

echo "<br />Please Select An Image.";

} else {

$poster1 = $_FILES['poster1']['name']; 
$poster2 = $_FILES['poster2']['name'];

$first = $_FILES['poster1']['tmp_name'];
$second = $_FILES['poster2']['tmp_name'];


//Get the content of the image and then add slashes to it 
$imagetmp1=addslashes (file_get_contents($first));
$imagetmp2=addslashes (file_get_contents($second));

          
$sell ="UPDATE `events` SET poster1='$imagetmp1',poster2 = '$imagetmp2' WHERE evid ='$ev_id'";
$rs = mysqli_query($conn,$sell);
 if (!$rs){
                echo "Query failed";
            }
            else{ 
                header("Location:events.php");
            }
}

}

?>

<!DOCTYPE html>
<html>
<head>
<title>Posters</title>
<link rel="stylesheet" type="text/css" href="makead.css">
</head>
<body>

<header class="header">	
  <?php require_once 'inc/nav.php'; ?>
		<div class="form">
	<h1>UPLOAD POSTERS</h1>
<form action="evimg.php" method="post" enctype="multipart/form-data">
     <input type="file" name="poster1" id="poster1"><br>
     <input type="file" name="poster2" id="poster2"><br>
     <input type="submit" name="save" value="Finish">

</form>
</div>
</header>
</body>
</html>
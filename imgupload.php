<?php
session_start();
include_once 'inc/conn.php';
$myusername = $_SESSION['login_user'];
$ad_id = $_SESSION['present_ad'];
echo $ad_id;

function array_encode($array,$mysqli){ // Convert Array for DB storage json compressed in BLOB
    $result = gzcompress(json_encode($array));
    if ($mysqli){ mysqli_real_escape_string($mysqli,$result); }
    return $result;
}

if (isset($_POST['save'])) {

$frontim = $_FILES['frontim']['name']; 
$leftim = $_FILES['leftim']['name'];
$rightim = $_FILES['rightim']['name'];
$backim = $_FILES['backim']['name'];


$arr = [];  // empty array for BLOB
$frontim = array_encode($arr,$mysqli); // json, compress; now binary         
$update ="UPDATE `uploads` SET frontim=? ,leftim=? ,rightim=? ,backim=? WHERE adid=? ";

//create prepares statement
$stmt = mysqli_stmt_init($conn);
//prepare stmt
if (!mysqli_stmt_prepare($stmt, $update)) {
          echo "SQL STATEMENT FAILED";
} else {
        //bind parameters to placeholder
        $null = NULL;
        mysqli_stmt_bind_param($stmt, "bi", $null, $ad_id);
        mysqli_stmt_send_long_data($stmt,0,$imagetmp1);
        //run parameters inside database
        mysqli_stmt_execute($stmt);
        header("Location:shop");   
}

}

?>

<!DOCTYPE html>
<html>
<head>
<title>Upload Image</title>
<link rel="stylesheet" type="text/css" href="makead.css">
</head>
<body>

<header class="header">	
  <?php require_once 'inc/nav.php'; ?>
		<div class="form">
	<h1>UPLOAD IMAGES</h1>
<form action="imgupload.php" method="post" enctype="multipart/form-data">
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
<?php
session_start();
require 'inc/conn.php';

if ($_SESSION['from'] != 'admin') {
  header("location:error404");
  exit();
}

$_SESSION['from'] = 'messages';

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>ADMIN</title>
	<link rel="stylesheet" type="text/css" href="users.css">  
</head>
<body>
	<header class="header">
      <div class="desc">
         <h1>Messages</h1><br><br>
<div class="table">
  <font color="#3498db">
<table>
  <thead>
    <tr>
    <th scope="col">Mid</th>
    <th scope="col">First Name</th>
    <th scope="col">Second Name</th>
    <th scope="col">Email</th>
    <th scope="col">Phone</th>
    <th scope="col">Message</th>
    <th scope="col">Action</th>
    </tr>
  </thead>
  <?php
  	$mess = "SELECT * FROM messages";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$mess)) {
      echo "erorr";
    } else {
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$mid = $row["mid"];
$fname = $row["fname"];
$sname = $row["sname"];
$email = $row["email"];
$phone =$row["phone"];
$message = $row["message"];
     ?>
  <tbody>
    <tr>
    <td><?php echo $mid; ?></td>
    <td><?php echo $fname; ?></td>
    <td><?php echo $sname; ?></td>
    <td><?php echo $email; ?></td>
    <td><?php echo $phone; ?></td>
    <td><?php echo $message; ?></td>
    <td><input type="submit" name="delete" value="Delete"></td>
  </tr>
  </tbody>
    <?php
        }
    }

    }
      ?>
</table>
</font>
</div><br>
      </div>
</header>
</body>
</html>
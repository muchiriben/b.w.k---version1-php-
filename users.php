<?php
session_start();
require 'inc/conn.php';

if ($_SESSION['from'] != 'admin') {
  header("location:error404");
  exit();
}

$_SESSION['from'] = "users";

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
         <h1>USERS</h1><br><br>
<div class="table">
  <font color="#3498db">
<table>
  <thead>
    <tr>
    <th scope="col">Sid</th>
    <th scope="col">First Name</th>
    <th scope="col">Second Name</th>
    <th scope="col">User Name</th>
    <th scope="col">Contact</th>
    <th scope="col">Email</th>
    <th scope="col">Reg_Date</th>
    <th scope="col">Action</th>
    </tr>
  </thead>
  <?php
  	$users = "SELECT * FROM users";
 $result = mysqli_query($conn,$users);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$sid = $row["sid"];
$fname = $row["fname"];
$sname =$row["sname"];
$uname = $row["uname"];
$contact = $row["contact"];
$email = $row["email"];
$reg_date = $row["reg_date"]; 
  	 ?>
  <tbody>
    <tr>
    <td><?php echo $sid; ?></td>
    <td><?php echo $fname; ?></td>
    <td><?php echo $sname; ?></td>
    <td><?php echo $uname; ?></td>
    <td><?php echo $contact; ?></td>
    <td><?php echo $email; ?></td>
    <td><?php echo $reg_date; ?></td>
    <td>
    <input type="submit" name="delete" Value="Delete">
    <input type="submit" name="view" Value="View">
    </td>
  </tr>
  </tbody>
    <?php
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
<?php
session_start();
require 'inc/conn.php';

if ($_SESSION['from'] != 'admin') {
  header("location:error404");
  exit();
}
$_SESSION['from'] = "uploads";

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
         <h1>UPLOADS</h1><br><br>
<div class="table">
  <font color="#3498db">
<table>
  <thead>
    <tr>
    <th scope="col">adid</th>
    <th scope="col">sid</th>
    <th scope="col">Make</th>
    <th scope="col">Model</th>
    <th scope="col">Year</th>
    <th scope="col">Price</th>
    <th scope="col">Contact</th>
    <th scope="col">Body Type</th>
    <th scope="col">Mileage</th>
    <th scope="col">Eng_size</th>
    <th scope="col">Images</th>
    <th scope="col">Action</th>
    </tr>
  </thead>
  <?php
  	$users = "SELECT * FROM uploads";
 $result = mysqli_query($conn,$users);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$adid = $row["adid"];
$sid = $row["by_id"];
$make = $row["make"];
$model =$row["model"];
$year = $row["year"];
$price = $row["price"];
$contact = $row["contact"];
$body= $row["body_type"];
$mileage = $row["mileage"];
$trans = $row["trans_type"];
$condition = $row["bike_condition"];
$size =$row["engine_size"];
$color = $row["color"];
$img1 = $row["leftim"]; 
$img2 = $row["rightim"]; 
$img3 = $row["backim"]; 
$img4 = $row["frontim"];  
  	 ?>
  <tbody>
    <tr>
    <td><?php echo $adid; ?></td>
    <td><?php echo $sid; ?></td>
    <td><?php echo $make; ?></td>
    <td><?php echo $model; ?></td>
    <td><?php echo $year; ?></td>
    <td><?php echo $price; ?></td>
    <td><?php echo $contact; ?></td>
    <td><?php echo $body; ?></td>
    <td><?php echo $mileage; ?></td>
    <td><?php echo $size; ?></td>
    <td><input type="submit" name="delete" Value="Delete"></td>
    <td><input type="submit" name="view" Value="View"></td>
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
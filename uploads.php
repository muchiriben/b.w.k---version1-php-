<?php
session_start();
$con = mysqli_connect('localhost','root','','sellmybike');
mysqli_select_db($con,'sellmybike');
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
		<div class="wrapper">
            <div class="logo">
        <i><b><font color="#fff" size="8px">BikerWorldKenya</font></b></i>
      </div>
      <ul class="nav-area">
        <li><a href="admin.php" id="links">Home</a></li>
        <li><a href="users.php" id="logolink">Users</a></li>
        <li><a href="dealerships.php" id="links">Dealerships</a></li>
        <li><a href="schools.php" id="links">Schools</a></li>
        <li><a href="garages.php" id="links">Garages</a></li>
        <li><a href="uploads.php" id="links">BikeUploads</a></li>
        <li><a href="gps.php" id="links">Gears&Parts</a></li>
            <li><a href="eventads.php" id="links">Events</a></li>
            <li><a href="update.php" id="links">Update Database</a></li>
            <li><a href="messages.php" id="links">Messages</a></li>
            <?php 
           if (isset($_SESSION['login_user'])) {
            echo  "<li><a href='logout.php' id='links'>Log out</a></li>" ;
              echo  "<li><h2>" .$_SESSION['login_user']. "<h2></li>";    
           }
           else{
              echo "<li><a href='login.php' id='links'>Login</a></li>";
           }
            ?>
         
      </ul>
    </div>
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
 $result = mysqli_query($con,$users);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$adid = $row["adid"];
$sid = $row["sid"];
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
<?php
session_start();
$con = mysqli_connect('localhost','root','','sellmybike');
mysqli_select_db($con,'sellmybike');
$_SESSION['from'] = "messages";

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
				<img src="img/logo3.png">
			</div>
			<ul class="nav-area">
        <li><a href="admin.php" id="links">Home</a></li>
        <li><a href="users.php" id="logolink">Users</a></li>
        <li><a href="uploads.php" id="links">Uploads</a></li>
            <li><a href="dealerships.php" id="links">Dealerships</a></li>
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
		</div><br>
      <div class="desc">
         <h1>Messages</h1><br><br>
<div class="table">
  <font color="#3498db">
<table>
  <thead>
    <tr>
    <th scope="col">Mid</th>
    <th scope="col">Name</th>
    <th scope="col">Email</th>
    <th scope="col">Phone</th>
    <th scope="col">Message</th>
    <th scope="col">Action</th>
    </tr>
  </thead>
  <?php
  	$mess = "SELECT * FROM messages";
 $result = mysqli_query($con,$mess);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$mid = $row["mid"];
$name = $row["name"];
$email = $row["email"];
$phone =$row["phone"];
$message = $row["message"];
  	 ?>
  <tbody>
    <tr>
    <td><?php echo $mid; ?></td>
    <td><?php echo $name; ?></td>
    <td><?php echo $email; ?></td>
    <td><?php echo $phone; ?></td>
    <td><?php echo $message; ?></td>
    <td><a href="actions.php?id=<?php echo $mid;?>" name = "table">Delete</a></td>
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
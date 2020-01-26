<?php
session_start();
$con = mysqli_connect('localhost','root','','sellmybike');
mysqli_select_db($con,'sellmybike');
$_SESSION['from'] = "dealerships";
$error = null;
$error1 = null;
if(isset($_POST['register'])){

	$first = "Dealer";
	$last = "Dealer";
	$user = $_POST['name'];
	$email = $_POST['email'];
	$pass = md5($_POST['pass']);
	$repass = md5($_POST['repass']);

	 $select="SELECT * FROM `users` WHERE uname='$user' ";
	 $result=mysqli_query($con,$select);
    if (!$result){
        echo "Select Failed";
    } else{
        $num=mysqli_num_rows($result);
       if ($num > 0){
            $error = "Dealership Name already exists";//For security purposes die
        }
        else{
            //Create registration query
            if($pass == $repass){
            $reg="INSERT INTO `users`(`fname`,`sname`, `uname`,`email`, `pass`, `repass`) VALUES ('$first', '$last','$user','$email','$pass','$repass')";
            $rs = mysqli_query($con,$reg);
            if (!$rs){
                echo "Registration Query failed";
            }
            else{ 
            	$last_id = mysqli_insert_id($con);
            	$_SESSION['last_id'] = $last_id;
            	header('location:users.php');
            }
        }
        else{
        	$error1 = "Passwords are not the same";
        }
        }
      }

   }      

?>

<!DOCTYPE html>
<html>
<head>
	<title>ADMIN</title>
	<link rel="stylesheet" type="text/css" href="update.css">  
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
		</div>

		<div class="form">
			<h1>Dealership Registration</h1>
			<form action="dealerships.php" method="post">
				<input type="text" name="name" placeholder="Name">
				<input type="email" name="email" placeholder="email">
				<input type="password" name="pass" placeholder="password">
				<input type="password" name="repass" placeholder="Re-password">
				<input type="submit" name="register" value="Register">
				<h2><?php echo $error ?></h2>
				<h2><?php echo $error1 ?></h2>
			</form>
		</div>
	</header>
</body>
</html>
<?php
session_start();
require 'inc/conn.php';
$_SESSION['from'] = "signup";

if(isset($_POST['signup'])){
    //get details
    $first = mysqli_real_escape_string($conn, $_POST['fname']);
	$last = mysqli_real_escape_string($conn, $_POST['sname']);
	$user = mysqli_real_escape_string($conn, $_POST['uname']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pass = mysqli_real_escape_string($conn, md5($_POST['pass']));
	$repass = mysqli_real_escape_string($conn, md5($_POST['repass']));
  
  //check for similar records
	$select="SELECT * FROM `users` WHERE uname='$user' ";
    if (!$select){
        echo "Select Failed";
    } else{
    	$result=mysqli_query($conn,$select);
        $num=mysqli_num_rows($result);
    }
        //if record exists
    if ($num > 0){
            echo "UserName already taken <a href='signup.php'>Ok</a>" ;//For security purposes die
            die();
        }
    else{
            //Create registration query
        if($pass == $repass){ //confirm passwords are similar and register
            $reg="INSERT INTO `users`(`fname`,`sname`, `uname`, `contact`,`email`, `pass`, `repass`) VALUES ('$first', '$last','$user',$contact,'$email','$pass','$repass')";
            if (!$reg){
                echo "Registration Query failed";
                            }
            else{ 
                mysqli_query($conn,$reg);
                $last_id = mysqli_insert_id($conn);
                $_SESSION['last_id'] = $last_id;
                header('Location:login.php');
                }
                            }
        else{
        	echo "Password not same <a href='signup.php'>Ok</a>";
                }       
        }
    
}      

?>

<!DOCTYPE html>
<html>
<head>
	<title>Sign up</title>
	<link rel="stylesheet" type="text/css" href="signup.css">
    <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header class="header">
		<?php require_once 'inc/nav.php'?>
		<div class="form">
			<h1>Sign Up</h1>
			<form action="signup.php" method="post">
				<input type="text" name="fname" placeholder="Firstname" required>
				<input type="text" name="sname" placeholder="Secondname" required><br>
				<input type="text" name="uname" placeholder="Username" required maxlength="22"><br>
                <input type="text" name="contact" placeholder="Contact" required>
				<input type="email" name="email" placeholder="email" required><br>
				<input type="password" name="pass" placeholder="password"  required pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}">
				<input type="password" name="repass" placeholder="Re-password" required pattern="(?=.*[0-9])(?=.*[A-Z]).{8,}"><br>
				<font size="4" color="#fff">Password must be 8 characters including atleast 1 uppercase letter, 1 lowercase letter and a number</font><br>
				<input type="submit" name="signup" value="Sign Up">
			</form>
		</div>
	</header>
    <?php require "inc/cpt.php"; ?>
</body>
</html>
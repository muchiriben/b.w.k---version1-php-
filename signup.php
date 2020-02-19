<?php
session_start();
require 'inc/conn.php';
$_SESSION['from'] = "signup";
$error = null;

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
	$select="SELECT * FROM `users` WHERE uname=? ";

   $stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $select)) {
   echo "SQL error";
} else {
   mysqli_stmt_bind_param($stmt, "s", $user);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);
   $num=mysqli_num_rows($result);

        //if record exists
    if ($num == 0){

          //confirm passwords are similar and register
            if($pass == $repass){ 
            $reg="INSERT INTO `users`(`fname`,`sname`, `uname`, `contact`,`email`, `pass`, `repass`) VALUES (?,?,?,?,?,?,?)";
    
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $reg)) {
  echo "SQL error";
  exit();
} else {

mysqli_stmt_bind_param($stmt, "sssssss", $first, $last,$user,$contact,$email,$pass,$repass);
  
mysqli_stmt_execute($stmt);

$last_id = mysqli_insert_id($conn);
$_SESSION['last_id'] = $last_id;
header('Location:login');
                
     }
} else{
            $error = "Passwords are not same!!";
                }       
        
} else{
            $error = "Username has already been taken";
        
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
			<h1>Sign Up</h1><br>
            <font size="5" color="#fff"><?php echo $error; ?></font><br>
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
        <font color="#fff" size="4px">Already have an account? <a href="login"> Login</a></font><br>
			</form>
		</div>
	</header>
    <?php require "inc/cpt.php"; ?>
</body>
</html>
<?php
session_start();
require 'inc/conn.php';
//error message for login
$error = null;


   if(isset($_POST['login'])) {
      // username and password sent from form 
      $myusername = mysqli_real_escape_string($conn, $_POST['uname']);
      $mypassword = mysqli_real_escape_string($conn, md5($_POST['pass'])); 
      
      $sql = "SELECT sid FROM users WHERE uname = '$myusername' and pass = '$mypassword'";
      $result = mysqli_query($conn,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $sid = $row['sid'];
//last inserted id from sign up page
if (isset($_SESSION['last_id'])) {
  $last_id = $_SESSION['last_id'];
}else{
  $last_id = $sid;
}

      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         //redirect to admin page if login is by admin
         if ($_SESSION['login_user'] == "AdMiN") {
           header("location:admin.php");
         }
         //for normal users
         else{
          //set profile information if not yet
         $select="SELECT * FROM `profiles` WHERE sid ='$last_id' ";
         $result=mysqli_query($conn,$select);
    if (!$result){
        echo "Query Failed";
    } else{
        $num=mysqli_num_rows($result);
    }

        if ($num > 0){
             header("Location:index.php");
            //For security purposes die
            die();
        }
        else{
          //profile not set up
         if(isset($_SESSION['from'])){
          if ($_SESSION['from'] == "signup") {  
            $profile = "INSERT INTO `profiles` (`sid`,`uname`) VALUES ('$last_id','$myusername')";
               $reg = mysqli_query($conn,$profile);
              header("Location:index.php");
        }
        }
           }
   }
 }
   else {
         $error = "Your Login Name or Password is invalid";
      }

    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="login.css">
  <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header class="header">
		<?php require 'inc/nav.php'; ?>
		<div class="form">
			<h1>LOGIN</h1><br>
      <font size="4" color="#fff"><?php echo $error; ?></font><br>
			<form action="login.php" method="POST">
				<input type="text" name="uname" placeholder="Username" required><br>
				<input type="password" name="pass" placeholder="password" required><br>
				<input type="submit" name="login" value="LOGIN">
			</form>
			<font color="#fff" size="4px">Don't have an account? <a href="signup.php"> Sign Up</a></font><br><br>
			<font color="#fff" size="4px"><a href="getpassword.php">Forgot your password?</a></font>
		</div>
	</header>
  <?php require 'inc/cpt.php'; ?>
</body>
</html>



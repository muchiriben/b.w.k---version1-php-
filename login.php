<?php
session_start();
require 'inc/conn.php';
//error message for login
$error = null;


   if(isset($_POST['login'])) {
      // username and password sent from form 
      $myusername = mysqli_real_escape_string($conn, $_POST['uname']);
      $mypassword = mysqli_real_escape_string($conn, md5($_POST['pass'])); 
      
      $sql = "SELECT sid FROM users WHERE uname =? and pass =? ";
      $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $sql)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "ss", $myusername , $mypassword);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
           $count = mysqli_num_rows($result);
            while($row = mysqli_fetch_assoc($result)) {
               $sid = $row['sid'];
            }
         } 
      

      // If result matched $myusername and $mypassword, table row must be 1 row
      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         $_SESSION['user_type'] = 'user';
         
         if ($_SESSION['login_user'] == "*******") {
           header("location:*****");
         }
         
         else{


         $last_id = $sid;
          //set profile information if not yet
         $select="SELECT * FROM `profiles` WHERE sid =? ";
         $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $select)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "i", $last_id);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
           $num=mysqli_num_rows($result);
          
//if there is no record in profiles for new user
        if ($num == 0){

           //profile not set up
            $profile = "INSERT INTO `profiles` (`sid`,`uname`) VALUES (?,?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $profile)) {
              echo "Errorr";
            } else {
              mysqli_stmt_bind_param($stmt, "is" , $last_id,$myusername);
              mysqli_stmt_execute($stmt);
              header("Location:index");
            }

        }
        else{
         
            header("Location:index");
            //For security purposes die
            die();

           }
   }


  } 

}  else {
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
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
      $(document).ready(function(){
       $("select.category").change(function(){
           var selectedCategory = $(this).children("option:selected").val();
           if (selectedCategory == 'dealer') {
                   location.replace('dealer_login');
           } else if(selectedCategory == 'user') {
                   location.replace('login');
           } else {
               location.replace('garage_login');
           }
       });
      });
    </script>
</head>
<body>
<header class="header">
		<?php require 'inc/nav.php'; ?>
    <div class="cat">
    <select class="category">
      <option class="option" value="user">Login As:</option>
      <option class="option" value="user">User</option>
      <option class="option" value="dealer">Dealership</option>
    </select>
  </div>
		<div class="form">
			<h1>LOGIN</h1><br>
      <font size="5" color="#fff"><?php echo $error; ?></font><br>
			<form action="login.php" method="POST">
				<input type="text" name="uname" placeholder="Username" required><br>
				<input type="password" name="pass" placeholder="password" required><br>
				<input type="submit" name="login" value="LOGIN">
			</form>
			<font color="#fff" size="4px">Don't have an account? <a href="signup"> Sign Up</a></font><br>
			<font color="#fff" size="4px"><a href="getpassword">Forgot your password?</a></font>
		</div>
	</header>
  <?php require 'inc/cpt.php'; ?>
</body>
</html>



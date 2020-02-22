 <?php
session_start();
require 'inc/conn.php';

$error = null;

if(isset($_POST['reset'])){

  $user = mysqli_real_escape_string($conn,  $_POST['uname']);
  $prevpass = mysqli_real_escape_string($conn,  md5($_POST['prevpass']));
  $pass = mysqli_real_escape_string($conn,  md5($_POST['pass']));
  $repass = mysqli_real_escape_string($conn,  md5($_POST['repass']));

   $select="SELECT * FROM `dealers` WHERE dname =? ";
   $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $select)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "s", $user);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result)>0){
      while($row = mysqli_fetch_assoc($result)) {
           $password = $row['pass'];

         }
     }
         } 
     
    if($prevpass == $password){
      if ($pass == $repass) {
          $edit ="UPDATE `dealers` SET pass='$pass', repass='$repass' WHERE dname ='$user'";
             $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $edit)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "sss", $pass, $repass, $user);
           //run parameters inside database
           mysqli_stmt_execute($stmt);   

           header("location:dealer_login"); 
          }
      }else{
          $error = "Your New Passwords are not the same";
      }
    }else{
      $error = "Your previous password or Username is incorrect";
    }
    }

?>


<!DOCTYPE html>
<html>
<head>
  <title>Change Password</title>
  <link rel="stylesheet" type="text/css" href="login.css">
  <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header class="header">
    <?php require_once 'inc/nav.php'; ?>
    <div class="form">
      <h1>Change Password</h1>
      <form action="dealer_changepass.php" method="post">
        <font size="5" color="#fff"><?php echo $error; ?></font><br>
        <input type="text" name="uname" placeholder="Dealer name" required><br>
        <input type="password" name="prevpass" placeholder="Previous Password" required><br>
        <input type="password" name="pass" placeholder="New Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br>
        <input type="password" name="repass" placeholder="Confirm password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br>
        <font size="4" color="#fff">Password must be 8 characters including atleast 1 uppercase letter, 1 lowercase letter and a number</font><br>
        <input type="submit" name="reset" value="Change">
        
      </form>
    </div>
  </header>
  <?php require 'inc/cpt.php'; ?>
</body>
</html>
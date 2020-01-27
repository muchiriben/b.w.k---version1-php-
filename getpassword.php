<?php
session_start();
require_once 'inc/conn.php';
$error = null;
if (isset($_POST['get'])) {
  $user = mysqli_real_escape_string($conn, $_POST['uname']);
  $select="SELECT * FROM `users` WHERE uname='$user' ";
  $result=mysqli_query($conn,$select);
    if (!$result){
        echo "Select Failed";
    } else{
        if(mysqli_num_rows($result)>0){
          while($row = mysqli_fetch_assoc($result)) {
           $email = $row['email'];
         }
        }else{
          $error = "Username not Found";
        }
    }

//generate random password
function random_strings($length_of_string) 
{ 
    // String of all alphanumeric character 
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 

    // Shufle the $str_result and returns substring 
    // of specified length 
    return substr(str_shuffle($str_result),  
                       0, $length_of_string); 
} 
  
// This function will generate 
// Random string of length 8 
$randpass = md5(random_strings(8));

$edit ="UPDATE `users` SET pass='$randpass', repass='$randpass' WHERE uname ='$user'";
            $rs = mysqli_query($conn,$edit);
//send email
require 'phpmailer/PHPMailerAutoload.php';      
   $mail = new PHPMailer();
   $mail->isSMTP();
   $mail->SMTPDebug = 2;
   $mail->Host = "smtp.gmail.com";
   $mail->SMTPAuth = true;
   $mail->Username = "bikerworldkenya@gmail.com";
   $mail->Password = "KeepRidingStaySafe*";
   $mail->SMTPSecure = "Tls"; //or TLS
   $mail->Port = 587; //587 for TLS

   $mail->Subject = "Reset Password";
   $mail->isHTML(true);
   $mail->Body = "<b>Reset Password.<br>This is Private information!!<br><h1>Use password:</h1>" .$randpass. "</b>";
   $mail->setFrom('bikerworldkenya@gmail.com','BikerWorldKenya');
   $mail->addAddress($email); 
   if($mail->send()){
    header("location:reset");
    echo "Mail sent";
   }else{
    echo "Mailer Error:" .$mail->ErrorInfo;
   }
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Get Password</title>
	<link rel="stylesheet" type="text/css" href="login.css">
  <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header class="header">
		<?php require_once 'inc/nav.php'; ?>
		<div class="form">
			<h1>GET NEW PASSWORD</h1><br>
      <h2><?php echo $error ?></h2>
			<form action="getpassword.php" method="post">
				<input type="text" name="uname" id="uname" placeholder="Username"><br>
				<input type="submit" name="get" id="uname" value="GET">
			</form>
			<font color="#fff" size="4px"><a href="changepass">Change Password</a></font>
		</div>
	</header>
  <?php require 'inc/cpt.php'; ?>
</body>
</html>



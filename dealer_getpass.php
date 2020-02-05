<?php
session_start();
require 'inc/conn.php';
$error = null;
if (isset($_POST['get'])) {
  $user = mysqli_real_escape_string($conn, $_POST['uname']);
  $select="SELECT * FROM `dealers` WHERE dname=? ";
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
           $email = $row['email'];
         }
        }else{
          $error = "Dealer name not Found";
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

$edit ="UPDATE `dealers` SET pass=? , repass=? WHERE dname =? ";
$stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $edit)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "sss", $randpass, $randpass, $user);
           //run parameters inside database
           mysqli_stmt_execute($stmt);   }

            
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
   $mail->Body = "<b>Reset Password.<br>This is Private information!!<br><h1>Use password(Copy):</h1>" .$randpass. "</b>";
   $mail->setFrom('bikerworldkenya@gmail.com','BikerWorldKenya');
   $mail->addAddress($email); 
   if($mail->send()){
    header("location:dealer_reset");
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
			<form action="dealer_getpass.php" method="post">
				<input type="text" name="uname" id="uname" placeholder="Dealer name"><br>
				<input type="submit" name="get" id="uname" value="GET">
			</form>
			<font color="#fff" size="4px"><a href="dealer_changepass">Change Password</a></font>
		</div>
	</header>
  <?php require 'inc/cpt.php'; ?>
</body>
</html>



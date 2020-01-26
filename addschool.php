<?php 
session_start();
require "inc/conn.php";

//check user has logged in
if (($_SESSION['login_user']) == null) {
  header("Location:login.php");
}

//initialization of important elements
$myusername = $_SESSION['login_user'];
$_SESSION['from'] = "addshule";
$error = null;


if(isset($_POST['reg'])){
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$sname = mysqli_real_escape_string($conn, $_POST["sname"]);
$location = mysqli_real_escape_string($conn, $_POST["location"]); 
$contact = mysqli_real_escape_string($conn, $_POST["contact"]);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$web = mysqli_real_escape_string($conn, $_POST['web']);
$slogan = mysqli_real_escape_string($conn, $_POST['slogan']);
$pass = mysqli_real_escape_string($conn, md5($_POST['pass']));
$repass = mysqli_real_escape_string($conn, md5($_POST['repass']));
$poster1 = $_FILES['logo']['name']; 
$first =  $_FILES['logo']['tmp_name'];
//Get the content of the image and then add slashes to it 
$imagetmp1=addslashes (file_get_contents($first));

//get the sid of user
$byidq = "SELECT sid FROM users WHERE uname = '$myusername' ";
 $result = mysqli_query($conn,$byidq);
    if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
               $by_id = $row["sid"];
            }
         } 

//check for similar records
    $select="SELECT * FROM `shule` WHERE sname='$sname' ";
    $result=mysqli_query($conn,$select);
    $num=mysqli_num_rows($result);
    
        //if record exists
    if ($num == 0){

          //check passwords are similar
      if($pass == $repass){

            $sell="INSERT INTO `shule`(`by_id`,`fname`, `lname`,`sname`, `slocation`,`contact`,`email`,`web`,`slogan`,`pass`,`repass`,`logo`) VALUES ('$by_id','$fname','$lname','$sname','$location','$contact','$email','$web','$slogan','$pass','$repass','$imagetmp1')";

            mysqli_query($conn,$sell);
            header('location:schools.php');
             
          }else{
            $error = "Passwords are not the same!!!";
          }
        }
    else{
            $error = "School name already exists!!!";
         }

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Register School</title>
	<link rel="stylesheet" type="text/css" href="makead.css">
    <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header class="header">
	<?php require_once "inc/nav.php"; ?>
<div class="form">
	<h1>Register School</h1><br>
  <font size="6" color="#fff"><?php echo $error; ?></font><br>
<form action="addschool.php" method="post" name= "form" id="form" enctype="multipart/form-data">
<input type="text" placeholder="Head Trainer's First Name" name="fname" id="fname" required>
<input type="text" placeholder="Head Trainer's Last Name" name="lname" id="lname" required><br>
<input type="text" placeholder="School Name" name="sname" id="sname" required>
<input type="text" placeholder="Location e.g Nairobi, South C" name="location" id="location" required><br>
<input type="text" placeholder="Contact number" name="contact" id="contact" required>
<input type="email" placeholder="Email" name="email" id="email" required><br>
<input type="text" placeholder="Website(optional)" name="web" id="web">
<input type="text" placeholder="Slogan(optional)" name="slogan" id="slogan"><br>
<input type="password" placeholder="Password" name="pass" id="pass" required pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}">
<input type="password" placeholder="Repeat Password" name="repass" id="repass" required pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}"><br>
<font size="4" color="#fff">Password must be 8 characters including atleast 1 uppercase letter, 1 lowercase letter and a number</font><br><br>
<label for="logo"><font color="#fff" size="4">Add School logo(optional):</font></label><br>
<input type="file" name="logo" id="logo" required><br>
<input type="submit" value="Register" name="reg">
</form> 
</div>
</header>
<?php require_once 'inc/cpt.php'; ?>
</body>
</html>

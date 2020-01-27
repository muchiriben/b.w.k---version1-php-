<?php 
session_start();
require "inc/conn.php";

//check user has logged in
if (($_SESSION['login_user']) == null) {
  header("Location:login");
}

//initialization of important elements
$myusername = $_SESSION['login_user'];
$_SESSION['from'] = "addgarage";
$error =  null;

if(isset($_POST['register'])){
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$gar_name = mysqli_real_escape_string($conn, $_POST["gar_name"]);
$gar_location = mysqli_real_escape_string($conn,$_POST["gar_location"]);
$contact = mysqli_real_escape_string($conn, $_POST["contact"]);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$web = mysqli_real_escape_string($conn, $_POST['web']);
$slogan = mysqli_real_escape_string($conn, $_POST['slogan']);
$pass = mysqli_real_escape_string($conn, md5($_POST['pass']));
$repass = mysqli_real_escape_string($conn, md5($_POST['repass']));   
$poster1 = $_FILES['logo']['name']; 
$first = $_FILES['logo']['tmp_name'];
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
    $select="SELECT * FROM `garages` WHERE gar_name='$gar_name' ";
    $result=mysqli_query($conn,$select);
    $num=mysqli_num_rows($result);
    
    //if record exists
    if ($num == 0){

        //check passwords are similar
        if($pass == $repass){ 

            $addg="INSERT INTO `garages`(`by_id`,`fname`, `lname`,`gar_name`, `gar_location`,`contact`,`email`,`web`,`slogan`,`pass`,`repass`,`logo`) VALUES ('$by_id','$fname','$lname','$gar_name','$gar_location','$contact','$email','$web','$slogan','$pass','$repass','$imagetmp1')";

            //run query
            mysqli_query($conn,$addg);
            header('location:garages');     
        }else{
            $error = "Passwords are not the same!!!";
        }
                  }
    else{
           $error = "Garage name has already been taken!!!"; 
        }


}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Register Garage</title>
	<link rel="stylesheet" type="text/css" href="makead.css">
    <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header class="header">
	<?php require_once "inc/nav.php"; ?>
<div class="form">
	<h1>Garage Details</h1><br>
    <font size="6" color="#fff"><?php echo $error; ?></font><br>
<form action="addgarage.php" method="post" name= "form" id="form" enctype="multipart/form-data">
<input type="text" placeholder="Head Mechanic's First Name" name="fname" id="fname" required>
<input type="text" placeholder="Head Mechanic's Last Name" name="lname" id="lname" required><br>
<input type="text" placeholder="Garage Name" name="gar_name" id="gar_name" required>
<input type="text" placeholder="Location e.g Nairobi, South C" name="gar_location" id="gar_location" required><br>
<input type="text" placeholder="Contact number" name="contact" id="contact" required>
<input type="email" placeholder="Email" name="email" id="email" required><br>
<input type="text" placeholder="Website(optional)" name="web" id="web">
<input type="text" placeholder="Slogan(optional)" name="slogan" id="slogan"><br>
<input type="password" placeholder="Password" name="pass" id="pass" required pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}">
<input type="password" placeholder="Repeat Password" name="repass" id="repass" required pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}"><br>
<font size="4" color="#fff">Password must be 8 characters including atleast 1 uppercase letter, 1 lowercase letter and a number</font><br><br>
<label for="logo"><font color="#fff" size="4">Add School logo(optional):</font></label><br>
<input type="file" name="logo" id="logo"><br>
<input type="submit" value="Register" name="register">
</form> 
</div>
</header>
<?php require_once 'inc/cpt.php'; ?>
</body>
</html>

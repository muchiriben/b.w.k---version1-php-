<?php
session_start();
require_once 'inc/conn.php';
if (($_SESSION['login_user']) == null) {
    header("Location:login.php");
}

$user = $_SESSION['login_user'];
  $list = "SELECT * FROM profiles WHERE uname = '$user'";
 $result = mysqli_query($conn,$list);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
                 $sid = $row['sid'];
                 $uname = $row['uname'];
                 $bio = $row['bio'];
                 $profilepic = $row['profilepic'];
            } 
              }

$bio = null;
$profilepic = null;
if(isset($_SESSION['from'])){
if ($_SESSION['from'] == "viewad") {
  if(isset($_GET['id'])){
    $sid = $_GET['id'];
    $list = "SELECT * FROM profiles WHERE sid = '$sid'";
 $result = mysqli_query($conn,$list);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
                 $uname = $row['uname'];
                 $bio = $row['bio'];
                 $profilepic = $row['profilepic'];
            } 
              } }
}else{
       $user = $_SESSION['login_user'];
  $list = "SELECT * FROM profiles WHERE uname = '$user'";
 $result = mysqli_query($conn,$list);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
                 $sid = $row['sid'];
                 $uname = $row['uname'];
                 $bio = $row['bio'];
                 $profilepic = $row['profilepic'];
            } 
              }
     }
}
  
 ?>

<!DOCTYPE html>
<html>
<head>
   <title>Profile</title>
   <link rel="stylesheet" type="text/css" href="myprofile.css">
    <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
   <header class="header">
      <?php require_once 'inc/nav.php'; ?>
      
<div class="profile">
    <div class="pic">
        <?php
        if ($profilepic == null) {
            echo '<img src="img/hrossi.jpg" height="100px" width="100px">';
        }else{
            echo '<img src="data:image;base64,'.base64_encode( $profilepic ).'" height="150px" width="200px">';
        }
?>
    </div>
    <div class="bio">
         <font color="#3498db"><h2><?php echo $uname; ?></h2>
         <h2><?php echo $bio; ?></h2></font>
         <a href="editprofile.php?id=<?php echo $sid;?>" name="ref">Edit Profile</a>
    </div>
</div>

<div class="cont">
    <h1>Listings</h1>
    <?php           
       $list = "SELECT * FROM uploads ORDER BY adid desc";
       $result = mysqli_query($conn,$list);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$adid = $row["adid"];
$sid = $row["sid"];
$make = $row["make"];
$model =$row["model"];
$year = $row["year"];
$price = $row["price"];
$contact = $row["contact"];
$body= $row["body_type"];
$mileage = $row["mileage"];
$trans = $row["trans_type"];
$condition = $row["bike_condition"];
$size =$row["engine_size"];
$color = $row["color"];
$img1 = $row["leftim"]; 
$img2 = $row["rightim"]; 
$img3 = $row["backim"]; 
$img4 = $row["frontim"];   
   ?>
  
<div class="listings">  
<div class="img">
<?php
echo '<img src="data:image;base64,'.base64_encode( $row['frontim'] ).'" height="250px" width="440px">';
?>
</div>

<div class="desc">
 <p><?php echo "Make:\t" .$make; ?></p><br><br>
 <p><?php echo "Model:\t" .$model; ?></p><br><br>
 <p><?php echo "Year:\t" .$year; ?></p><br><br>
 <p><?php echo "Price:\t" .$price; ?></p><br><br>
 <p><?php echo "Contact Me:\t" .$model; ?></p><br>
<a href="viewad.php?id=<?php echo $row["adid"];?>" id="ref" name = "ref">View Ad</a>
</div>
</div>

<?php
}
}else{
  echo '<font color = "#fff"><h2>You currently have no running Uploads!!</h2>';
  echo '<a href = "sell.php" name= "ref">Upload Now</a></font>';
}

unset($_SESSION['from']);
?>
</div>
  </div>
</header>
<?php require_once 'inc/cpt.php'; ?>
</body>
</html>
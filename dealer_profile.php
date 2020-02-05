<?php
session_start();
require_once 'inc/conn.php';
if (($_SESSION['login_user']) == null) {
  header("Location:dealer_login");
}
$usertype = 'dealer';

/* view profile */
if (!isset($_GET['v'])) {
if (($_SESSION['user_type']) != 'dealer') {
  header("Location:dealer_login");
}
 
$user = $_SESSION['login_user'];
$list = "SELECT * FROM dprofile WHERE dname =?";
//create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $list)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "s", $user);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
                 $sid = $row['did'];
                 $uname = $row['dname'];
                 $bio = $row['bio'];
                 $profilepic = $row['profilepic'];
            } 
              }
                   
} else {

     $data = $_GET['v'];

/*decrypt url*/
  $data2 = base64_decode(urldecode($data));
  $decrypt = $data2/201820192020007;
  $post_id = $decrypt;
    
  $list = "SELECT * FROM dprofile WHERE did =?";
//create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $list)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "i", $post_id);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
                 $sid = $row['did'];
                 $uname = $row['dname'];
                 $bio = $row['bio'];
                 $profilepic = $row['profilepic'];
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
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
     <script>
$(document).ready(function(){
    $("select.category").change(function(){
        var selectedCategory = $(this).children("option:selected").val();
        if (selectedCategory == "gears") {
  document.querySelector('.gears').style.display = "flex";
  document.querySelector('.bikes').style.display = "none";
  document.querySelector('.parts').style.display = "none";
  document.querySelector('.events').style.display = "none";
  document.querySelector('.rentals').style.display = "none";
      }
        else if(selectedCategory == "bikes"){
  document.querySelector('.bikes').style.display = "flex";
  document.querySelector('.gears').style.display = "none";
  document.querySelector('.parts').style.display = "none";
  document.querySelector('.events').style.display = "none";
  document.querySelector('.rentals').style.display = "none";
      }
        else if(selectedCategory == "parts"){
  document.querySelector('.parts').style.display = "flex";
  document.querySelector('.bikes').style.display = "none";
  document.querySelector('.gears').style.display = "none";
  document.querySelector('.events').style.display = "none";
  document.querySelector('.rentals').style.display = "none";
      }else if(selectedCategory == "events"){
        document.querySelector('.parts').style.display = "none";
        document.querySelector('.bikes').style.display = "none";
        document.querySelector('.gears').style.display = "none";
        document.querySelector('.events').style.display = "flex";
        document.querySelector('.rentals').style.display = "none";
      }else{
        document.querySelector('.parts').style.display = "none";
        document.querySelector('.bikes').style.display = "none";
        document.querySelector('.gears').style.display = "none";
        document.querySelector('.events').style.display = "none";
        document.querySelector('.rentals').style.display = "flex";
      }
        
    });
      
});

</script>
</head>
<body>
   <header class="header">
      <?php require_once 'inc/nav.php'; ?>
      
<div class="profile">
    <div class="pic">
    <?php
    if ($profilepic == null) {
      echo '<img src="img/hrossi.jpg" height="100px" width="100px"><br>';
    }else{
      echo '<img src="data:image;base64,'.base64_encode( $profilepic ).'" height="150px" width="200px"><br>';
    }
?>
   <font color="#fff"><h2><?php echo $uname; ?></h2>
     <h2><?php echo $bio; ?></h2></font>
  </div>
  </div>

  <div class="editcont">
    <div class="href">
      <?php
         if (!isset($_GET['v'])) { ?>
            <a href="editprofile" name="ref">Edit Profile</a>
      <?php } ?>
      
      <a href="#" name="ref">Message</a>
      <a href="#" id="button" class="button">Contact</a>
    </div> 
  </div>


<div class="cat">
    <select class="category">
      <option class="option" value="bikes" selected="">Category</option>
      <option class="option" value="bikes">Bikes</option>
      <option class="option" value="gears">Gears</option>
      <option class="option" value="parts">Parts</option>
      <option class="option" value="events">Events</option>
      <option class="option" value="rentals">Rentals</option>
    </select>
  </div>

<!----bikes section---->
<div id="bikes" class="bikes">
  <div class="cont">
    <h1>Motorcycle Listings</h1>
    <?php
       $list = "SELECT * FROM uploads WHERE by_id =? AND user_type =?";
       //create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $list)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "is", $sid,$usertype);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
           if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$adid = $row["adid"];
$sid = $row["by_id"];
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
<div class="img" id="top">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img4 ).'" >';
?>
</div>
<div class="desc">
 <p><?php echo "Make:\t" .$make; ?></p><br>
 <p><?php echo "Model:\t" .$model; ?></p><br>
 <p><?php echo "Year:\t" .$year; ?></p><br>
 <p><?php echo "Price:\t" .$price; ?></p><br>
 <p><?php echo "Contact Me:\t" .$contact; ?></p><br><br>

<?php
/* encrypt url */
$data = $adid;
$encrypt = $data*201820192020007;
$encode = "viewad?v=" .urlencode(base64_encode($encrypt));
?>

<a href="<?=$encode;?>" id="ref" name = "ref">View Listing</a>
</div><br>
   <div class="img" id="bottom">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img3 ).'">';
?>                  
</div>
</div>

<?php
}
}else{ ?>
        
     <div class='noad'>
      <?php if (!isset($_GET['v'])) { ?>
         <p>You Currently Have No Motorcycle on Sale!!!!</p><br><br>
         <a href="partad" id="ref" name="ref">SellPart</a>
      <?php } else { ?>
         <p>They Currently Have No Motorcycle on Sale!!!!</p><br><br>
      <?php } ?>
     </div>   

<?php 
}
} 
?>
</div>
  </div>


<!----gears section---->
<div id="gears" class="gears">
   <div class="cont">
    <h1>Motorcycle Gear</h1>
    <?php           
       $list = "SELECT * FROM guploads WHERE by_id =? AND user_type =?";
       //create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $list)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "is", $sid,$usertype);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
           if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$gid = $row["gid"];
$sid = $row["by_id"];
$cate = $row["cate"];
$type =$row["type"];
$brand = $row["brand"];
$gname = $row["gname"];
$price = $row["price"];
$contact = $row["contact"];
$img1 = $row["leftim"]; 
$img2 = $row["rightim"]; 
$img3 = $row["backim"]; 
$img4 = $row["frontim"];  

   ?>
  
<div class="listings">  
<div class="img" id="top">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img4 ).'">';
?>
</div>

<div class="desc">
 <p><?php echo "Category:\t" .$cate; ?></p><br>
 <p><?php echo "Type:\t" .$type; ?></p><br>
 <p><?php echo "Brand:\t" .$brand; ?></p><br>
 <p><?php echo "Name:\t" .$gname; ?></p><br>
 <p><?php echo "Price:\t" .$price; ?></p><br>
 <p><?php echo "Contact Me:\t" .$contact; ?></p><br>


<?php
/* encrypt url */
$data = $row["gid"];
$encrypt = $data*201820192020007;
$encode = "vgear?v=" .urlencode(base64_encode($encrypt));
?>

<a href="<?=$encode;?>" id="ref" name = "ref">View Listing</a>
</div><br>
<div class="img" id="bottom">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img3 ).'">';
?>
</div>
</div>

<?php
}
}else{ ?>
        
     <div class='noad'>
      <?php if (!isset($_GET['v'])) { ?>
         <p>You Currently Have No Gears on Sale!!!!</p><br><br>
         <a href="partad" id="ref" name="ref">SellGear</a>
      <?php } else { ?>
         <p>They Currently Have No Gears on Sale!!!!</p><br><br>
      <?php } ?>
     </div>   

<?php 
}
} 
?>
</div>
  </div>

<!----parts section---->
<div id="parts" class="parts">
  <div class="cont">
    <h1>Motorcycle Parts</h1>
    <?php           
       $list = "SELECT * FROM puploads WHERE by_id =? AND user_type =?";
       //create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $list)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "is", $sid, $usertype);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
           if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$sid = $row['by_id'];
$make = $row['make'];
$model = $row['model'];
$type = $row['type'];
$pname = $row['pname'];
$price = $row['price'];
$contact = $row['contact'];
$img1 = $row["leftim"]; 
$img2 = $row["rightim"]; 
$img3 = $row["backim"]; 
$img4 = $row["frontim"];   
   ?>
  
<div class="listings">  
<div class="img" id="top">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img4 ).'">';
?>
</div>

<div class="desc">
 <p><?php echo "Make:\t" .$make; ?></p><br>
 <p><?php echo "Model:\t" .$model; ?></p><br>
 <p><?php echo "Type:\t" .$type; ?></p><br>
 <p><?php echo "Part Name:\t" .$pname; ?></p><br>
 <p><?php echo "Price:\tKes" .$price; ?></p><br>
 <p><?php echo "Contact Me:\t" .$contact; ?></p><br>

<?php
/* encrypt url */
$data = $row["pid"];
$encrypt = $data*201820192020007;
$encode = "vpart?v=" .urlencode(base64_encode($encrypt));
?>

<a href="<?=$encode;?>" id="ref" name = "ref">View Listing</a>
</div><br>
<div class="img" id="bottom">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img3 ).'">';
?>
</div>
</div>

<?php
}
}else{ ?>
        
     <div class='noad'>
      <?php if (!isset($_GET['v'])) { ?>
         <p>You Currently Have No Parts on Sale!!!!</p><br><br>
         <a href="partad" id="ref" name="ref">SellPart</a>
      <?php } else { ?>
         <p>They Currently Have No Parts on Sale!!!!</p><br><br>
      <?php } ?>
     </div>    

<?php 
}
} 
?>
</div>
  </div>

<!----events section---->
<div class="events" id="events">
       <div class="cont">
    <h1>Coming Soon</h1>
    <?php           
       $list = "SELECT * FROM events WHERE by_id =? AND user_type =?";
       //create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $list)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "is", $sid, $usertype);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
           if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$evid = $row["evid"];
$by_id = $row["by_id"];
$evname = $row["evname"];
$held_by = $row["held_by"];
$date = $row["date"];
$location =$row["location"];
$description = $row["description"]; 
$contact = $row["contact"];
$poster1 = $row["poster1"];
$poster2 = $row["poster2"];   
   ?>
  
<div class="listings">  
<div class="img" id="top">
<?php
echo '<img src="data:image;base64,'.base64_encode( $poster1 ).'">';
?>
</div>

<div class="desc">
 <p><?php echo "Event Name:\t" .$evname; ?></p><br>
 <p><?php echo "Held By:\t" .$held_by; ?></p><br>
 <p><?php echo "Date:\t" .$date; ?></p><br>
 <p><?php echo "Location:\t" .$location; ?></p><br>
 <p><?php echo "Contact Us:\t" .$contact; ?></p><br><br>
 
<?php
/* encrypt url */
$data = $row["evid"];
$encrypt = $data*201820192020007;
$encode = "viewevent?v=" .urlencode(base64_encode($encrypt));
?>

<a href="<?=$encode;?>" id="ref" name = "ref">View Event</a>
</div><br>
<div class="img" id="bottom">
<?php
echo '<img src="data:image;base64,'.base64_encode( $poster2 ).'">';
?>
</div>
</div>

<?php
}
}else{ ?>
        
     <div class='noad'>
      <?php if (!isset($_GET['v'])) { ?>
         <p>You Currently Have No Upcoming Events!!!!</p><br><br>
         <a href="postevent" id="ref" name="ref">Post Event</a>
      <?php } else { ?>
         <p>They Currently Have No Upcoming Events!!!!</p><br><br>
      <?php } ?>
     </div>   

<?php 
}
} 
?>
</div>
  </div>

<!----rentals section---->
<div class="rentals">
  <div class="cont">
    <h1>Rent a Bike</h1>
    <?php           
       $list = "SELECT * FROM rentals WHERE by_id =? AND user_type =?";
       //create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $list)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "is", $sid, $usertype);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
           if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$rid = $row["rid"];
$sid = $row["by_id"];
$make = $row["make"];
$model =$row["model"];
$year = $row["year"];
$eng_size = $row["eng_size"];
$price = $row["price"];
$contact = $row["contact"];
$img1 = $row["leftim"]; 
$img2 = $row["rightim"]; 
$img3 = $row["backim"]; 
$img4 = $row["frontim"];   
   ?>
  
<div class="listings">  
<div class="img" id="top">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img4 ).'">';
?>
</div>

<div class="desc">
 <p><?php echo "Make:\t" .$make; ?></p><br>
 <p><?php echo "Model:\t" .$model; ?></p><br>
 <p><?php echo "Year:\t" .$year; ?></p><br>
  <p><?php echo "Engine size:\t" .$eng_size. "cc" ;?></p><br>
 <p><?php echo "Price/hour:\t" .$price. "/="; ?></p><br>
 <p><?php echo "Contact Me:\t" .$contact; ?></p><br><br>

<?php
/* encrypt url */
$data = $row["rid"];
$encrypt = $data*201820192020007;
$encode = "viewrental?v=" .urlencode(base64_encode($encrypt));
?>

<a href="<?=$encode;?>" id="ref" name = "ref">View Listing</a>
</div><br>
<div class="img" id="bottom">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img3 ).'">';
?>
</div>
</div>

<?php
}
}else{ ?>
        
     <div class='noad'>
      <?php if (!isset($_GET['v'])) { ?>
         <p>You Currently Have No Motorcycles for rent!!!!</p><br><br>
         <a href="rentad" id="ref" name="ref">RentYourBike</a>
      <?php } else { ?>
         <p>They Currently Have No Motorcycles for rent!!!!</p><br><br>
      <?php } ?>
     </div>    

<?php 
}
} 
?>
</div>
  </div>
</header>

 <!-- Contact Section -->
<?php
    $list = "SELECT * FROM users WHERE sid = '$sid'";
    $result = mysqli_query($conn,$list);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
                 $sid = $row['sid'];
                 $fname = $row['fname'];
                 $sname = $row['sname'];
                 $email = $row['email'];
                 $contact = $row['contact'];
            } 
              }

?>
<script type="text/javascript">
  document.getElementById('button').addEventListener("click", function() {
  document.querySelector('.bg-modal').style.display = "flex";
});
</script>
<div class="bg-modal">
  <div class="modal-contents">
    <div class="close" id="close">+</div>
    <div>
      <h1>CONTACT</h1>
      <p><?php echo $fname. " " .$sname; ?></p>
      <p><?php echo $contact; ?></p>
      <p><?php echo $email; ?></p>
    </div>
  </div>
  <script type="text/javascript">
    document.getElementById('close').addEventListener("click", function() {
  document.querySelector('.bg-modal').style.display = "none";
});
  </script>
</div>
<!--- end of modal section --->
<?php require_once 'inc/cpt.php'; ?>
</body>
</html>
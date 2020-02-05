<?php 
session_start();
$_SESSION['from'] = "bikead";
if (($_SESSION['login_user']) == null) {
  header("Location:login");
}

require "inc/conn.php";
$myusername = $_SESSION['login_user'];
$usertype = $_SESSION['user_type'];
$pmenu = $cmenu = null;
if (isset($_GET["make"]) && is_numeric($_GET["make"])) {
    $pmenu = $_GET["make"];
}
if (isset($_POST['submit'])) {
    if (isset($_POST['model'])) {
        $pmenu = $_POST['make'];
    }
    if (isset($_POST['model']) && is_numeric($_POST['model'])) {
        $cmenu = $_POST['model'];
    }
}

if(isset($_POST['save'])){
  
/* Details setting */
$make =mysqli_real_escape_string($conn, $_POST['make']);
$model =mysqli_real_escape_string($conn, $_POST['model']);
$year =mysqli_real_escape_string($conn, $_POST['year']);
$price =mysqli_real_escape_string($conn, $_POST['price']);
$contact =mysqli_real_escape_string($conn, $_POST['contact']);
$body=mysqli_real_escape_string($conn,$_POST['bodytype']);
$mileage =mysqli_real_escape_string($conn, $_POST['mileage']);
$trans =mysqli_real_escape_string($conn, $_POST['trans']);
$condition =mysqli_real_escape_string($conn, $_POST['condition']);
$size =mysqli_real_escape_string($conn, $_POST['size']);
$color =mysqli_real_escape_string($conn, $_POST['color']);

$ext = pathinfo($_FILES['frontim']['name']);
$ext = pathinfo($_FILES['leftim']['name']);
$ext = pathinfo($_FILES['rightim']['name']);
$ext = pathinfo($_FILES['backim']['name']);
if ($ext["extension"] == "jpg" || $ext["extension"] == "jpeg" || $ext["extension"] == "png" || $ext["extension"] == "gif") {
       $frontim = $_FILES['frontim']['name']; 
       $first =  $_FILES['frontim']['tmp_name'];
       $imagetmp1= file_get_contents($first); 

       $leftim = $_FILES['leftim']['name']; 
       $sec =  $_FILES['leftim']['tmp_name'];
       $imagetmp2= file_get_contents($sec); 

       $rightim = $_FILES['rightim']['name']; 
       $thrd =  $_FILES['rightim']['tmp_name'];
       $imagetmp3= file_get_contents($thrd); 

       $backim = $_FILES['backim']['name']; 
       $frth =  $_FILES['backim']['tmp_name'];
       $imagetmp4= file_get_contents($frth); 
} else {
      $error = "File is not an Image.";
      exit();
}

if($usertype == 'user') {
    $sidq = "SELECT sid FROM users WHERE uname =? ";
  //create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $sidq)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "s", $myusername);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
               $by_id = $row["sid"];
            }
         } 
} elseif ($usertype == 'dealer') {
     $sidq = "SELECT did FROM dealers WHERE dname =? ";
  //create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $sidq)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "s", $myusername);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
               $by_id = $row["did"];
            }
         } 
}
 

$sq = "SELECT name FROM maketable WHERE mid =? ";
 //create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $sq)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "i", $make);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
               $makename = $row["name"];
            }
         } 


/* insert into databse */

 $sell="INSERT INTO `uploads`(`by_id`,`user_type`, `make`, `model`, `year`, `price`, `contact`, `body_type`, `mileage`, `trans_type`, `bike_condition`, `engine_size`, `color`,`frontim`, `leftim`, `rightim` ,`backim`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
 
$null = NULL;        
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sell)) {
  echo "SQL error";
  exit();
} else {
  mysqli_stmt_bind_param($stmt, "isssiississssbbbb", $by_id,$usertype,$makename,$model,$year,$price,$contact,$body,$mileage,$trans,$condition,$size,$color,$null,$null,$null,$null);

$stmt->send_long_data(13, $imagetmp1);
$stmt->send_long_data(14, $imagetmp2);
$stmt->send_long_data(15, $imagetmp3);
$stmt->send_long_data(16, $imagetmp4);

mysqli_stmt_execute($stmt);

header('location:shop');
}
 
        

}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Shop</title>
  <script type="text/javascript">
   function autoSubmit()
            {
                with (window.document.form) {
                      if (make.selectedIndex === 0) {
                        window.location.href = 'bikead.php';
                    } else {
                        window.location.href = 'bikead.php?make=' + make.options[make.selectedIndex].value;
                    }
                }
            }
</script>
  <link rel="stylesheet" type="text/css" href="makead.css">
  <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header class="header">
  <?php require_once "inc/nav.php"; ?>
<div class="form">
<form action="bikead.php" method="post" name= "form" id="form" enctype="multipart/form-data">
  <div class="details">
    <h1>Motorcycle Details</h1><br>
                   <select id="make" name="make" onchange="autoSubmit();" required>
                        <option value="">Make</option>
                        <?php
                       
                        $sql = "SELECT mid,name from maketable";
                        $result = mysqli_query($conn,$sql);
                  
                        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            echo ("<option value=\"{$row['mid']}\" " . ($pmenu == $row['mid'] ? " selected" : "") . ">{$row['name']}</option>");
                        }
                        ?>
                    </select>
               <select id="model" name="model" required>
                <option value="">Model</option>
                <?php
                if ($pmenu != '' && is_numeric($pmenu)) {
                  
                    $sql = "SELECT * from modeltable where mid=" . $pmenu;
                    $result = mysqli_query($conn,$sql);
               $num = mysqli_num_rows($result);
                    if ($num > 0) {
                                //SUBCATEGORY stared
                                while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                                    echo ("<option value=\"{$row['model']}\" " . ($cmenu == $row['modelid'] ? " selected" : "") . ">{$row['model']}</option>");
                                }
                    }
                }
                ?>
                 </select>
    <br>
 
<select id="year" name="year" required>
  <?php
    $y=(int)date('Y') + 1;
    ?>
    <option value="">Year</option>
    <option value="<?php echo $y;?>"><?php echo $y;?></option>
      <?php
      $y--;
    for(; $y>'1950'; $y--)
    {
  ?>
  <option value="<?php echo $y;?>"><?php echo $y;?></option>
  <?php }?>
</select>
    
<input type="number" placeholder="Price:e.g 200000" name="price" id="price" required><br>
<input type="text" placeholder="Contact" name="contact" id="contact" required><br>
    
    
  <h1>Add Features</h1><br> 
  <select  name="bodytype" id="bodytype" required>
      <option value="">Body Type</option>
      <option value="Sports Bike">Sports Bike</option>
      <option value="Street Bike">Street Bike</option>
      <option value="Adventure">Adventure</option>
      <option value="Dual Spport">Dual Sport</option>
      <option value="Touring">Touring</option>
      <option value="Sport Touring">Sport Touring</option>
      <option value="Cruiser">Cruiser</option>
      <option value="SuperMoto">SuperMoto</option>
      <option value="Off-road/Dirt Bike">Off-road/Dirt Bike</option>
      <option value="SuperMoto">Scooter</option>
      <option value="Custom">Custom</option>
      <option value="Other">Other</option>
    </select>
 <input type="number" placeholder="Mileage(Kilometers)" name="mileage" id="mileage" required><br>
    
  <select  name="trans" id="trans" required>
      <option value="">Transmission Type</option>
      <option value="Manual Transmission">Manual Transmission</option>
      <option value="Automatic Transmission">Automatic Transmission</option>
      <option value="Dual Clutch Transmission(DTC)">Dual Clutch Transmission</option>
      <option value="Electric Motor">Electric Motor</option>
    </select>
    
   <select name="condition" id="condition" required>
      <option value="">Condition</option>
      <option value="Brand New">Brand New</option>
      <option value="Foreign Used">Foreign Used</option>
      <option value="Localally Used">Locally Used</option>
    </select><br>
 
<input type="number" placeholder="Engine size(cc)" name="size" id="size" required>    
<input type="text" name="color" id="color" placeholder="Color" required><br>
<a href="#" id="button">Next</a>
</div>

<script type="text/javascript">
  document.getElementById('button').addEventListener("click", function() {
  document.querySelector('.imgupload').style.display = "inline-block";
  document.querySelector('.details').style.display = "none";
});
</script>

<div class="imgupload">
  <h1>UPLOAD IMAGES</h1><br>
     <input type="file" name="frontim" id="frontim"><br>
     <input type="file" name="leftim" id="leftim"><br>
     <input type="file" name="rightim" id="rightim"><br>
     <input type="file" name="backim" id="backim"><br>
     <input type="submit" name="save" value="Finish">
</div>
</form> 
</div>
</header>
<?php require_once 'inc/cpt.php'; ?>
</body>
</html>

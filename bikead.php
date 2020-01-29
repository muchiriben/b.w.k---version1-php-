<?php 
session_start();
$_SESSION['from'] = "bikead";
if (($_SESSION['login_user']) == null) {
  header("Location:login");
}

require_once "inc/conn.php";
$myusername = $_SESSION['login_user'];
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

if(isset($_POST['next'])){
  
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
               $sid = $row["sid"];
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

 $sell="INSERT INTO `uploads`(`sid`, `make`, `model`, `year`, `price`, `contact`, `body_type`, `mileage`, `trans_type`, `bike_condition`, `engine_size`, `color`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sell)) {
  echo "SQL error";
} else {
  mysqli_stmt_bind_param($stmt, "issiississss", $sid,$makename,$model,$year,$price,$contact,$body,$mileage,$trans,$condition,$size,$color);
  mysqli_stmt_execute($stmt);

 $last_id = mysqli_insert_id($conn);
 $_SESSION['present_ad'] = $last_id;
 header('location:imgupload?v=' .$last_id );
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
  <h1>Details</h1>
<form action="bikead.php" method="post" name= "form" id="form">
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
<input type="submit" value="Next" name="next">
</form> 
</div>
</header>
<?php require_once 'inc/cpt.php'; ?>
</body>
</html>

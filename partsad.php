<?php 
session_start();
$_SESSION['from'] = "partsad";
if (($_SESSION['login_user']) == null) {
  header("Location:login");
}

require "inc/conn.php";
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

$make = mysqli_real_escape_string($conn, $_POST['make']);
$model = mysqli_real_escape_string($conn, $_POST['model']);
$type = mysqli_real_escape_string($conn, $_POST['type']);
$pname = mysqli_real_escape_string($conn, $_POST['pname']);
$year = mysqli_real_escape_string($conn, $_POST['year']);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$contact = mysqli_real_escape_string($conn, $_POST['contact']);

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


 $sellpart="INSERT INTO `puploads`(`sid`, `make`, `model`,`year`,`type`,`pname`,`price`, `contact`) VALUES (?,?,?,?,?,?,?,?)";

  $stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sellpart)) {
  echo "SQL error";
} else {
  mysqli_stmt_bind_param($stmt, "ississis", $sid,$makename,$model,$price,$type,$pname,$price,$contact);
  mysqli_stmt_execute($stmt); 
  $last_id = mysqli_insert_id($conn);
 $_SESSION['present_ad'] = $last_id;
 header('location:pimg?v=' .$last_id );
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
                        window.location.href = 'partsad.php';
                    } else {
                        window.location.href = 'partsad.php?make=' + make.options[make.selectedIndex].value;
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
<form action="partsad.php" method="post" name= "form" id="form">
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
                <option value="Universal">Universal</option>
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

<select id="type" name="type" required>
  <option id="type" value="Aftermaket Part">Aftermaket Part</option>
  <option id="type" value="OEM Part(0riginal)">OEM Part(Original Equipment Manufacturer)</option>
</select><br> 
<input type="text" name="pname" id="pname" placeholder="Part Name" required>
<input type="text" placeholder="Price:e.g 200000" name="price" id="price" required><br>
<input type="text" placeholder="Contact" name="contact" id="contact" required><br>
<input type="submit" value="Next" name="next">
</form> 
</div>
</header>
<?php require_once 'inc/cpt.php'; ?>
</body>
</html>

<?php 
session_start();
$_SESSION['from'] = "rentad";
if (($_SESSION['login_user']) == null) {
  header("Location:login.php");
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

$make = mysqli_real_escape_string($conn, $_POST['make']);
$model = mysqli_real_escape_string($conn, $_POST['model']);
$year = mysqli_real_escape_string($conn, $_POST['year']);
$eng_size = mysqli_real_escape_string($conn, $_POST['eng_size']);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$contact = mysqli_real_escape_string($conn, $_POST['contact']);


 $sidq = "SELECT sid FROM users WHERE uname = '$myusername' ";
 $result = mysqli_query($conn,$sidq);
    if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
               $sid = $row["sid"];
            }
         } 

$sq = "SELECT name FROM maketable WHERE mid = '$make' ";
 $result = mysqli_query($conn,$sq);
    if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
               $makename = $row["name"];
            }
         } 

 $sell="INSERT INTO `rentals`(`sid`, `make`, `model`, `year`,`eng_size`,`price`, `contact`) VALUES ('$sid','$makename','$model','$year','$eng_size','$price','$contact')";
 if (!$sell){
                echo "Registration Query failed";
            }
            else{ 
            	mysqli_query($conn,$sell);
                $last_id = mysqli_insert_id($conn);
                $_SESSION['present_ad'] = $last_id;
                header('location:rimg.php');
            }


}

?>
<!DOCTYPE html>
<html>
<head>
	<title>RentBike</title>
	<script type="text/javascript">
	 function autoSubmit()
            {
                with (window.document.form) {
                      if (make.selectedIndex === 0) {
                        window.location.href = 'rentad.php';
                    } else {
                        window.location.href = 'rentad.php?make=' + make.options[make.selectedIndex].value;
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
	<h1>Motorcycle Details</h1>
<form action="rentad.php" method="post" name= "form" id="form">
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
<input type="text" name="eng_size" id="eng_size" placeholder="Engine size(cc)" required><br>       
<input type="text" placeholder="Price/hour:e.g 200000" name="price" id="price" required>
<input type="text" placeholder="Contact" name="contact" id="contact" required><br>
<input type="submit" value="Next" name="next">
</form> 
</div>
</header>
</body>
</html>

<?php 
session_start();
require "inc/conn.php";

if (($_SESSION['login_user']) == null) {
  header("Location:login.php");
  exit();
}


$_SESSION['from'] = "rentad";

$myusername = $_SESSION['login_user'];
$usertype = $_SESSION['user_type'];

$pmenu = $cmenu = $error = null;
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

$make = mysqli_real_escape_string($conn, $_POST['make']);
$model = mysqli_real_escape_string($conn, $_POST['model']);
$year = mysqli_real_escape_string($conn, $_POST['year']);
$eng_size = mysqli_real_escape_string($conn, $_POST['eng_size']);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$contact = mysqli_real_escape_string($conn, $_POST['contact']);
$description =mysqli_real_escape_string($conn, $_POST['description']);

$ext = pathinfo($_FILES['frontim']['name']);
$ext1 = pathinfo($_FILES['leftim']['name']);
$ext2 = pathinfo($_FILES['rightim']['name']);
$ext3 = pathinfo($_FILES['backim']['name']);

if ($ext["extension"] == "jpg" || $ext["extension"] == "jpeg" || $ext["extension"] == "png" || $ext["extension"] == "gif") {
       $frontim = $_FILES['frontim']['name']; 
       $first =  $_FILES['frontim']['tmp_name'];
       $imagetmp1= file_get_contents($first);
} else {
      $error = "One of the files uploaded is not an Image";
}

if ($ext1["extension"] == "jpg" || $ext1["extension"] == "jpeg" || $ext1["extension"] == "png" || $ext1["extension"] == "gif") {
       $leftim = $_FILES['leftim']['name']; 
       $sec =  $_FILES['leftim']['tmp_name'];
       $imagetmp2= file_get_contents($sec);
} else {
      $error = "One of the files uploaded is not an Image";
}

if ($ext2["extension"] == "jpg" || $ext2["extension"] == "jpeg" || $ext2["extension"] == "png" || $ext2["extension"] == "gif") {
       $rightim = $_FILES['rightim']['name']; 
       $thrd =  $_FILES['rightim']['tmp_name'];
       $imagetmp3= file_get_contents($thrd);
} else {
      $error = "One of the files uploaded is not an Image";
}

if ($ext3["extension"] == "jpg" || $ext3["extension"] == "jpeg" || $ext3["extension"] == "png" || $ext3["extension"] == "gif") {
       $backim = $_FILES['backim']['name']; 
       $frth =  $_FILES['backim']['tmp_name'];
       $imagetmp4= file_get_contents($frth);
} else {
      $error = "One of the files uploaded is not an Image";
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

if ($error == null) {
/* insert into databse */

 $sell="INSERT INTO `rentals`(`by_id`,`user_type`, `make`, `model`, `year`,`eng_size`,`price`, `contact`,`description`,`frontim`, `leftim`, `rightim` ,`backim`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

 $null = NULL;
 $stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sell)) {
  echo "SQL error";
} else {
  mysqli_stmt_bind_param($stmt, "isssiiissbbbb", $by_id,$usertype,$makename,$model,$year,$eng_size,$price,$contact,$description,$null,$null,$null,$null);

$stmt->send_long_data(9, $imagetmp1);
$stmt->send_long_data(10, $imagetmp2);
$stmt->send_long_data(11, $imagetmp3);
$stmt->send_long_data(12, $imagetmp4);

  mysqli_stmt_execute($stmt);

 header('location:rent');
}
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
<form action="rentad.php" method="post" name= "form" id="form" enctype="multipart/form-data">
  <div class="details">
  <h1>Motorcycle Details</h1><br>
  <font size="5" color="#fff"><?php echo $error; ?></font><br>
                   <select id="make" name="make" onchange="autoSubmit();" required>
                        <option value="">Motorcycle Make</option>
                        <?php
                       
                        $sql = "SELECT mid,name from maketable";
                        $result = mysqli_query($conn,$sql);
                  
                        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            echo ("<option value=\"{$row['mid']}\" " . ($pmenu == $row['mid'] ? " selected" : "") . ">{$row['name']}</option>");
                        }
                        ?>
                    </select>
               <select id="model" name="model" required>
                <option value="">Motorcycle Model</option>
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
<input type="text" name="eng_size" id="eng_size" placeholder="Engine size(cc): e.g. 600" required><br>       
<input type="text" placeholder="Price/hour: e.g. 200000" name="price" id="price" required>
<input type="text" placeholder="Contact: e.g. 0712345678" name="contact" id="contact" required><br>
<textarea name="description" id="description" placeholder="Description" required></textarea><br>
<a href="#" id="button">Next</a>
</div>

<script type="text/javascript">
  document.getElementById('button').addEventListener("click", function() {

   var errormessage = "";
   if(document.getElementById('make').value == "") {
     errormessage += "EntermMotorcycle make \n";
     document.getElementById('make').style.border = "2px solid #B40431";
   } else {
      document.getElementById('make').style.border = "2px solid #fff";
   }

   if(document.getElementById('model').value == "") {
     errormessage += "Enter motorcycle model \n";
     document.getElementById('model').style.border = "2px solid #B40431";
   } else {
      document.getElementById('model').style.border = "2px solid #fff";
   }

   if (document.getElementById('year').value == ""){
     errormessage += "Enter year \n";
     document.getElementById('year').style.border = "2px solid #B40431";
   } else{
     document.getElementById('year').style.border = "2px solid #fff";
   }

   if(document.getElementById('price').value == "") {
     errormessage += "Enter Price \n";
     document.getElementById('price').style.border = "2px solid #B40431";
   } else {
      document.getElementById('price').style.border = "2px solid #fff";
   }

   if(document.getElementById('contact').value == "") {
     errormessage += "Enter Contact \n";
     document.getElementById('contact').style.border = "2px solid #B40431";
   } else {
      document.getElementById('contact').style.border = "2px solid #fff";
   }

   if(document.getElementById('eng_size').value == "") {
     errormessage += "Enter Engine size \n";
     document.getElementById('eng_size').style.border = "2px solid #B40431";
   } else {
      document.getElementById('eng_size').style.border = "2px solid #fff";
   }

   if(document.getElementById('description').value == "") {
     errormessage += "Enter Description \n";
     document.getElementById('description').style.border = "2px solid #B40431";
   } else {
      document.getElementById('description').style.border = "2px solid #fff";
   }

   if (errormessage != "") {
     alert(errormessage);
     return false;
   } else {
     document.querySelector('.imgupload').style.display = "inline-block";
  document.querySelector('.details').style.display = "none";
   }
  
});
</script>

<div class="imgupload">
  <h1>UPLOAD IMAGES</h1><br>
     <input type="file" name="frontim" id="frontim" required><br>
     <input type="file" name="leftim" id="leftim" required><br>
     <input type="file" name="rightim" id="rightim" required><br>
     <input type="file" name="backim" id="backim" required><br>
     <input type="submit" name="save" value="Finish">
</div>
</form> 
</div>
</header>
</body>
</html>

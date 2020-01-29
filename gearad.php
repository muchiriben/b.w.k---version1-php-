<?php 
session_start();
$_SESSION['from'] = "gearad";
if (($_SESSION['login_user']) == null) {
  header("Location:login");
}

require_once "inc/conn.php";
$myusername = $_SESSION['login_user'];
$pmenu = $cmenu = null;
if (isset($_GET["cate"]) && is_numeric($_GET["cate"])) {
    $pmenu = $_GET["cate"];
}
if (isset($_POST['submit'])) {
    if (isset($_POST['type'])) {
        $pmenu = $_POST['cate'];
    }
    if (isset($_POST['type']) && is_numeric($_POST['type'])) {
        $cmenu = $_POST['type'];
    }
}

if(isset($_POST['next'])){
	
$cate = mysqli_real_escape_string($conn, $_POST['cate']);
$type = mysqli_real_escape_string($conn, $_POST['type']);
$brand = mysqli_real_escape_string($conn, $_POST['brand']);
$gname = mysqli_real_escape_string($conn, $_POST['name']);
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

$sq = "SELECT cname FROM gcategories WHERE cid =? ";
 //create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $sq)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "i", $cate);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
               $cname = $row["cname"];
            }
         } 

 $sellgear="INSERT INTO `guploads`(`sid`, `cate`, `type`, `brand`, `gname`, `price`, `contact`) VALUES (?,?,?,?,?,?,?)";

     $stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sellgear)) {
  echo "SQL error";
} else {
  mysqli_stmt_bind_param($stmt, "issssis", $sid, $cname, $type , $brand ,$gname, $price, $contact);
  mysqli_stmt_execute($stmt);

 $last_id = mysqli_insert_id($conn);
 $_SESSION['present_ad'] = $last_id;
 header('location:gimg?v=' .$last_id );
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
                      if (cate.selectedIndex === 0) {
                        window.location.href = 'gearad.php';
                    } else {
                        window.location.href = 'gearad.php?cate=' + cate.options[cate.selectedIndex].value;
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
<form action="gearad.php" method="post" name= "form" id="form">
                   <select id="cate" name="cate" onchange="autoSubmit();" required>
                        <option value="">Category</option>
                        <?php
                       
                        $sql = "SELECT cid,cname from gcategories";
                        $result = mysqli_query($conn,$sql);
                  
                        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            echo ("<option value=\"{$row['cid']}\" " . ($pmenu == $row['cid'] ? " selected" : "") . ">{$row['cname']}</option>");
                        }
                        ?>
                    </select>
               <select id="type" name="type" required>
                <option value="">Type</option>
                <?php
                if ($pmenu != '' && is_numeric($pmenu)) {
                  
                    $sql = "SELECT * from gtypes where cid=" . $pmenu;
                    $result = mysqli_query($conn,$sql);
               $num = mysqli_num_rows($result);
                    if ($num > 0) {
                                //SUBCATEGORY stared
                                while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                                    echo ("<option value=\"{$row['tname']}\" " . ($cmenu == $row['tid'] ? " selected" : "") . ">{$row['tname']}</option>");
                                }
                    }
                }
                ?>
                 </select>
		<br>

<input type="text" placeholder="Brand:e.g alpinestars" name="brand" id="brand" required>
<input type="text" placeholder="Name" name="name" id="name" required><br>		
<input type="text" placeholder="Price:e.g 200000" name="price" id="price" required>
<input type="text" placeholder="Contact" name="contact" id="contact" required><br>		
<input type="submit" value="Next" name="next">
</form> 
</div>
</header>
<?php require_once 'inc/cpt.php'; ?>
</body>
</html>

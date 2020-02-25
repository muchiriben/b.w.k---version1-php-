<?php 
session_start();
$_SESSION['from'] = "bikes";
require "inc/conn.php";
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="description" content="Buy sell Motorcycles, Motorcycle gear and parts">
  <title>Shop BikerWorldKenya</title>
  <link rel="stylesheet" type="text/css" href="shop.css">
    <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
$(document).ready(function(){
    $("select.category").change(function(){
        var selectedCategory = $(this).children("option:selected").val();
        if (selectedCategory == "gears") {
          location.replace("gears");
        }
        else if(selectedCategory == "bikes"){
            location.replace("shop");
        }
        else if(selectedCategory == "parts"){
          location.replace("parts");
        }
        
    });
});
</script>
</head>
<body>
<header class="header">
  <?php require_once "inc/nav.php"; ?>
  <div class="cat">
    <select class="category">
      <option class="option" value="" selected="">Category</option>
      <option class="option" value="bikes">Bikes</option>
      <option class="option" value="gears">Gears</option>
      <option class="option" value="parts">Parts</option>
    </select>
    <a href="makead.php">SellYourBike</a>
  </div>
    
    <div class="cont" id="contshop">
    <h1>Motorcycle Listings</h1>
    <?php
       //create sql template           
       $list = "SELECT * FROM uploads ORDER BY rand()";
       
       //create prepared statement
       $stmt = mysqli_stmt_init($conn);

       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $list)) {

          echo "SQL STATEMENT FAILED";

       } else {

           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);

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
 <p><?php echo "Price:\t" .$price."/="; ?></p><br>
 <p><?php echo "Contact Me:\t" .$contact; ?></p><br><br>

<?php
/* encrypt url */
$data = $adid;
$encrypt = $data*201820192020007;
$encode = "viewad?v=" .urlencode(base64_encode($encrypt));
?>

<a href="<?=$encode;?>" id="ref" name = "ref">View Motorcycle</a>
</div><br>
   <div class="img" id="bottom">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img3 ).'">';
?>
</div>
</div>

<?php
}
}
?>
                  
</div>
</header>
<?php include_once 'inc/cpt.php';  ?>
</body>
</html>

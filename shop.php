<?php 
session_start();
$_SESSION['from'] = "bikes";
require_once "inc/conn.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Shop</title>
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
        	location.replace("gears.php");
        }
        else if(selectedCategory == "bikes"){
            location.replace("shop.php");
        }
        else if(selectedCategory == "parts"){
        	location.replace("parts.php");
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
    
    <div class="cont">
    <h1>Motorcycle Listings</h1>
    <?php           
       $list = "SELECT * FROM uploads ORDER BY rand()";
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
echo '<img src="data:image;base64,'.base64_encode( $row['frontim'] ).'" height="240px" width="440px">';
?>
</div>
<div class="desc">
 <p><?php echo "Make:\t" .$make; ?></p><br><br>
 <p><?php echo "Model:\t" .$model; ?></p><br><br>
 <p><?php echo "Year:\t" .$year; ?></p><br><br>
 <p><?php echo "Price:\t" .$price; ?></p><br><br>
 <p><?php echo "Contact Me:\t" .$contact; ?></p><br>
<a href="viewad.php?id=<?php echo $row["adid"];?>" id="ref" name = "ref">View Listing</a>
</div>
</div>

<?php
}
}
?>
</div>
	</div>
</header>
<?php include_once 'inc/cpt.php';  ?>
</body>
</html>
<?php
session_start();
require_once 'inc/conn.php';
$_SESSION['from'] = "viewad";
$data = $_GET['v'];

/*decrypt url*/
  $data2 = base64_decode(urldecode($data));
  $decrypt = $data2/201820192020007;
  $adid = $decrypt;


$list = "SELECT * FROM uploads WHERE adid = '$adid'";
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
}
 }
$user = "SELECT * FROM users WHERE sid = '$sid'";
 $result = mysqli_query($conn,$user);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
                    $name = $row['uname'];
            }
          }

 ?>

<!DOCTYPE html>
<html>
<head>
   <title>ViewAD</title>
   <link rel="stylesheet" type="text/css" href="view.css">
   <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <header class="header">
      <?php require 'inc/nav.php'; ?>
      <div class="name">
         <h1><?php echo "Post by: " .$name; ?></h1>
      </div>   
<div class="images">
<div class="img">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img4 ).'">';
?>
</div>
<div class="img">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img3 ).'">';
?>
</div>
<div class="img">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img2 ).'">';
?>
</div>
<div class="img">
<?php
echo '<img src="data:image;base64,'.base64_encode( $img1 ).'">';
?>
</div>
</div>

<table>
  <thead>
    <tr>
    <th scope="col">CATEGORY</th>
    <th scope="col">DETAILS</th>
    </tr>
  </thead>
  <tbody>
    <tr>
    <th scope="row">MAKE</th>
    <td><?php echo $make; ?></td>
  </tr>
  <tr>
    <th scope="row">MODEL</th>
    <td><?php echo $model; ?></td>
  </tr>
  <tr>
    <th scope="row">PRICE</th>
    <td><?php echo "Ksh." .$price. "/="; ?></td>
    </tr> 
  <tr>
    <th scope="row">COLOR</th>
    <td><?php echo $color; ?></td>
    </tr> 
    <tr>
    <th scope="row">BODY TYPE</th>
    <td><?php echo $body; ?></td>
    </tr> 
    <tr>
    <th scope="row">MILEAGE</th>
    <td><?php echo $mileage. "km"; ?> </td>
    </tr> 
    <tr>
    <th scope="row">TRANSMISSION</th>
    <td><?php echo $trans; ?></td>
    </tr> 
    <tr>
    <th scope="row">CONDITION</th>
    <td><?php echo $condition; ?></td>
    </tr> 
    <tr>
    <th scope="row">ENGINE SIZE</th>
    <td><?php echo $size. "cc" ;?></td>
    </tr> 
    <tr>
    <th scope="row">CONTACT</th>
    <td><?php echo $contact;?></td>
    </tr>   
  </tbody>
  <tfoot>
    <tr>
      <th>
        <td>
<?php
/* encrypt url */
$data = $sid;
$encrypt = $data*201820192020007;
$encode = "myprofile?v=" .urlencode(base64_encode($encrypt));
?>

<a href="<?=$encode;?>" id="ref" name = "ref">View Profile</a></td>
      </th>
    </tr>
  </tfoot>
</table>
</header>
<?php require_once 'inc/cpt.php'; ?>
</body>
</html>
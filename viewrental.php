<?php
session_start();
require_once 'inc/conn.php';
$_SESSION['from'] = "viewrental";
$data = $_GET['v'];

/*decrypt url*/
  $data2 = base64_decode(urldecode($data));
  $decrypt = $data2/201820192020007;
  $r_id = $decrypt;

$list = "SELECT * FROM rentals WHERE rid = '$r_id'";
 $result = mysqli_query($conn,$list);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$sid = $row["sid"];
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
   <title>Rentals</title>
   <link rel="stylesheet" type="text/css" href="view.css">
   <link href="https://fonts.googleapis.com/css?family=Ibarra+Real+Nova&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <header class="header">
      <?php require_once 'inc/nav.php'; ?>
      <div class="name">
         <h1><?php echo "Post by: " .$name; ?></h1>
      </div>   
<div class="image">
<?php
echo '<div class="img">
    <img src="data:image;base64,'.base64_encode( $img4 ).'" height="280px" width="380px">
  </div>';
echo '<div class="img">
    <img src="data:image;base64,'.base64_encode( $img3 ).'" height="280px" width="380px">
  </div><br>';
  echo '<div class="img">
    <img src="data:image;base64,'.base64_encode( $img2 ).'" height="280px" width="380px">
  </div>';
  echo '<div class="img">
    <img src="data:image;base64,'.base64_encode( $img1 ).'" height="280px" width="380px">
  </div>';
?>
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
    <th scope="row">YEAR</th>
    <td><?php echo $year ;?></td>
    </tr>
  <th scope="row">ENGINE SIZE</th>
    <td><?php echo $eng_size. "cc" ;?></td>
    </tr> 
  <tr>
    <th scope="row">PRICE</th>
    <td><?php echo "Ksh." .$price. "/="; ?></td>
    </tr> 
    <tr>
    <th scope="row">CONTACT</th>
    <td><?php echo $contact;?></td>
    </tr>   
  </tbody>
  <tfoot>
    <tr>
      <th>
        <td><?php
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
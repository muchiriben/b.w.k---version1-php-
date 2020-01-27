<?php
session_start();
require_once 'inc/conn.php';
$_SESSION['from'] = "vpart";
$data = $_GET['v'];

/*decrypt url*/
  $data2 = base64_decode(urldecode($data));
  $decrypt = $data2/201820192020007;
  $pid = $decrypt;

 $list = "SELECT * FROM puploads WHERE pid = $pid";
       $result = mysqli_query($conn,$list);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$sid = $row['sid'];
$make = $row['make'];
$model = $row['model'];
$type = $row['type'];
$pname = $row['pname'];
$price = $row['price'];
$contact = $row['contact'];
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
    <th scope="row">Make</th>
    <td><?php echo $make; ?></td>
  </tr>
  <tr>
    <th scope="row">Model</th>
    <td><?php echo $model; ?></td>
  </tr>
  <tr>
    <th scope="row">Type</th>
    <td><?php echo $type; ?></td>
    </tr> 
  <tr>
    <th scope="row">Part Name</th>
    <td><?php echo $pname; ?></td>
    </tr> 
    <tr>
    <th scope="row">Price</th>
    <td><?php echo "Ksh." .$price. "/="; ?></td>
    </tr> 
    <th scope="row">CONTACT</th>
    <td><?php echo $contact;?></td>
    </tr>   
  </tbody>
  <tfoot>
    <tr>
      <th>
        <td><?php
/* encrypt url */
$data = $row["sid"];
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
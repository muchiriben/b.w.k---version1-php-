<?php
session_start();
require_once 'inc/conn.php';
$_SESSION['from'] = "viewevent";
$data = $_GET['v'];

/*decrypt url*/
  $data2 = base64_decode(urldecode($data));
  $decrypt = $data2/201820192020007;
  $ev_id = $decrypt;

$list = "SELECT * FROM events WHERE evid = '$ev_id'";
 $result = mysqli_query($conn,$list);
    if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$evid = $row["evid"];
$by_id = $row["by_id"];
$usertype = $row["user_type"];
$evname = $row["evname"];
$held_by = $row["held_by"];
$date = $row["date"];
$location =$row["location"];
$description = $row["description"]; 
$contact = $row["contact"];
$poster1 = $row["poster1"];
$poster2 = $row["poster2"];   
}
 }
 
if($usertype == 'user') {
    $sidq = "SELECT uname FROM users WHERE sid =? ";
  //create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $sidq)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "i", $by_id);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
               $name = $row["uname"];
            }
         } 
} elseif ($usertype == 'dealer') {
    $sidq = "SELECT dname FROM dealers WHERE did =? ";
  //create prepares statement
       $stmt = mysqli_stmt_init($conn);
       //prepare stmt
       if (!mysqli_stmt_prepare($stmt, $sidq)) {
          echo "SQL STATEMENT FAILED";
       } else {
           //bind parameters to placeholder
           mysqli_stmt_bind_param($stmt, "i", $by_id);
           //run parameters inside database
           mysqli_stmt_execute($stmt);
           $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)) {
               $name = $row["dname"];
            }
         } 
}

 ?>

<!DOCTYPE html>
<html>
<head>
   <title>Events</title>
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
    <img src="data:image;base64,'.base64_encode( $poster2 ).'" height="280px" width="380px">
  </div>';
echo '<div class="img">
    <img src="data:image;base64,'.base64_encode( $poster1 ).'" height="280px" width="380px">
  </div><br>';
?>
<div class="ticket">
  <a href="tickets.php">Get Tickets</a>
  <a href="pin.php">Pin Location</a>
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
    <th scope="row">Event Name</th>
    <td><?php echo $evname; ?></td>
  </tr>
  <tr>
    <th scope="row">Held By</th>
    <td><?php echo $held_by; ?></td>
  </tr>
  <tr>
    <th scope="row">Date</th>
    <td><?php echo $date ;?></td>
    </tr>
  <th scope="row">Location</th>
    <td><?php echo $location ;?></td>
    </tr> 
  <tr>
    <th scope="row">Description</th>
    <td><?php echo $description; ?></td>
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
$data = $by_id;
$encrypt = $data*201820192020007;
if($usertype == 'user') { 
   $encode = "myprofile?v=" .urlencode(base64_encode($encrypt));
} elseif ($usertype == 'dealer') { 
   $encode = "dealer_profile?v=" .urlencode(base64_encode($encrypt)); 
}
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
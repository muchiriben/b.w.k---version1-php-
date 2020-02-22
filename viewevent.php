<?php
session_start();
require 'inc/conn.php';
$_SESSION['from'] = "viewevent";

$data = $_GET['v'];
/*decrypt url*/
  $data2 = base64_decode(urldecode($data));
  $decrypt = $data2/201820192020007;
  $ev_id = $decrypt;

$list = "SELECT * FROM events WHERE evid =? ";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $list)){
  echo 'errrror';
} else {
  mysqli_stmt_bind_param($stmt, "i" , $ev_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  if (mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)) {
$evid = $row["evid"];
$by_id = $row["by_id"];
$usertype = $row["user_type"];
$evname = $row["evname"];
$held_by = $row["held_by"];
$date = $row["date"];
$location =$row["location"];
$price = $row["price"];
$description = $row["description"]; 
$contact = $row["contact"];
$poster1 = $row["poster1"];
$poster2 = $row["poster2"];   
}
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
         <h1><?php echo "Event Posted by: " .$name; ?></h1>
      </div>   
<div class="image">
<?php
echo '<div class="img">
    <img src="data:image;base64,'.base64_encode( $poster2 ).'" height="280px" width="380px">
  </div>';
echo '<div class="img">
    <img src="data:image;base64,'.base64_encode( $poster1 ).'" height="280px" width="380px">
  </div>';
?>
<div class="ticket">
  <a href="#" id="getickets" name="getickets">Get Tickets</a>
  <a href="https://www.google.com/maps/" target="_blank">Find Location</a>
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
    <th scope="row">Ticket Price</th>
    <td><?php 
    if ($price == 0) {
       $price = 'No charges';
       echo $price;
    } else { echo $price;  } ?>
    </td>
    </tr> 
    <tr>
    <th scope="row">CONTACT</th>
    <td><?php echo $contact;?></td>
    </tr>
    <tr>
      <th></th>
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
    </tr>   
  </tbody>
  <tfoot>
    <tr>
    <th scope="col" colspan="2">DESCRIPTION</th>
    </tr>
    <tr>
      <td colspan="2"><?php echo $description;?></td>
    </tr>
  </tfoot>
</table>
</header>

<!---modal section of tickets ---->
<script type="text/javascript">
  document.getElementById('getickets').addEventListener("click", function() {
  document.querySelector('.bg-modal').style.display = "flex";
});
</script>
<div class="bg-modal">
  <div class="modal-contents">
    <div class="close" id="close">+</div>
    <div>
      <h1>Get Tickets</h1>
      <a href="https://www.mtickets.com/" target="_blank">mtickets.com</a>
      <a href="">ticketsasa.com</a>
      <a href="">ticketkenya.com</a>
      <a href="">254tickets.com</a>
      <a href="">supertickets.com</a><br>
      <font size="4" color="#3498db">(Check the posters to find more information on how to access the tickets if they are not available in the above websites.)</font><br>
    </div>
  </div>
  <script type="text/javascript">
    document.getElementById('close').addEventListener("click", function() {
  document.querySelector('.bg-modal').style.display = "none";
});
  </script>
</div>


<?php require_once 'inc/cpt.php'; ?>
</body>
</html>
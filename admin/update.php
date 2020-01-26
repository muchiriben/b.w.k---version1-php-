<?php
session_start();
require 'inc/conn.php';
$_SESSION['from'] = "update";
$error1 = null;
$error2= null;
if(isset($_POST['update1'])){
	$make = $_POST['make1'];
	
	 $select="SELECT * FROM `maketable` WHERE name = '$make' ";
	 $result=mysqli_query($conn,$select);
    if (!$select){
        echo "Query Failed";
    } else{
        $num=mysqli_num_rows($result);
    }

        if ($num > 0){
            $error1 = "Motorcycle make already exists" ;//For security purposes die
        }
        else{
            //Create registration query
            $reg="INSERT INTO `maketable`(`name`) VALUES ('$make')";
            $rs = mysqli_query($conn,$reg);
            if (!$rs){
                echo "Registration Query failed";
            }
            else{ 
            	header('Location:update.php');
            }
        }
            

     }

//add model
if(isset($_POST['update2'])){
	$make2 = $_POST['make2'];
	$model = $_POST['model'];
	
	 $select="SELECT * FROM `modeltable` WHERE model = '$model'";
	 $result=mysqli_query($conn,$select);
    if (!$result){
        echo "Query Failed";
    } else{
        $num=mysqli_num_rows($result);
        if ($num > 0){
            $error2 = "Motorcycle model already exists";
        }
        else{
            //Create registration query
            $reg2 ="INSERT INTO `modeltable` (mid,model) VALUES ($make2,'$model')";
            $rs = mysqli_query($conn,$reg2);
            if (!$rs){
                echo "Registration Query failed";
            }
            else{ 
            	header('Location:update.php');
            }
        }
    }

     }        

?>

<!DOCTYPE html>
<html>
<head>
	<title>ADMIN</title>
	<link rel="stylesheet" type="text/css" href="update.css">  
</head>
<body>
	<header class="header">
		<?php require_once 'inc/adminnav.php'; ?>
		<div class="form">
			<form action="update.php" method="post">
			<div class="update1">
				<h1>Add Motorcycle Make</h1>
				<input type="text" name="make1" placeholder="Add Make">
				<input type="submit" name="update1" value="Update">
				<h2><?php echo $error1; ?></h2><br>
			</div>
			<div class="update2">
				<h1>Add Motorcycle Model</h1><br>
				<select id="make2" name="make2">
                        <option value="">Make</option>
                        <?php
                       
                        $sql = "SELECT mid,name from maketable";
                        $result = mysqli_query($conn,$sql);
                  
                        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                            echo ("<option value=\"{$row['mid']}\" " . ($pmenu == $row['mid'] ? " selected" : "") . ">{$row['name']}</option>");
                        }
                        ?>
                    </select>
				<input type="text" name="model" placeholder="Add Model">
				<input type="submit" name="update2" value="Update">
				<h2><?php echo $error2; ?></h2>
			</div>
			</form>
		</div>
	</header>
</body>
</html>
<?php
session_start();
require_once 'inc/conn.php';
$_SESSION['from'] = "admin";

?>
<!DOCTYPE html>
<html>
<head>
	<title>ADMIN</title>
	<link rel="stylesheet" type="text/css" href="admin.css">  
</head>
<body>
	<header class="header">
		    <?php require_once 'inc/adminnav.php'; ?>
		<div class="welcome-text">
              <h2>Welcome Back Admin!!!</h2>
		</div>
	</header>
</body>
</html>
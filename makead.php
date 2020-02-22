<?php
session_start();
require 'inc/conn.php';

if (isset($_SESSION['from'])) {
	if ($_SESSION['from'] == "bikes") {
	header("Location:bikead");
	exit();
}
else if($_SESSION['from'] == "gears"){
	header("Location:gearad");
	exit();
}
else if ($_SESSION['from'] == "parts") {
	header("Location:partsad");
	exit();
}

}


?>
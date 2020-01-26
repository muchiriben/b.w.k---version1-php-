<?php
session_start();
require_once 'inc/conn.php';
echo $_SESSION['from'];
if (isset($_SESSION['from'])) {
	if ($_SESSION['from'] == "bikes") {
	header("Location:bikead.php");
}
else if($_SESSION['from'] == "gears"){
	header("Location:gearad.php");
}
else if ($_SESSION['from'] == "parts") {
	header("Location:partsad.php");
}

}


?>
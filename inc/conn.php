<?php
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "bikerworld";
// Create connection
$conn = mysqli_connect($host,$dbusername,$dbpassword,$dbname);
mysqli_select_db($conn,'bikerworld');

if (!$conn) {
	echo "Database connection error";
}
?>
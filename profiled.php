<?php
session_start();
require_once 'inc/conn.php';
if (!isset($_SESSION['from'])) {
	header("Location:error404");
} else {
	if (($_SESSION['from']) != 'profile') {
	header("Location:error404");
} else {


if (isset($_GET['a'])) {
	/*decrypt url*/
    $data = $_GET['a'];
    $data2 = base64_decode(urldecode($data));
    $decrypt = $data2/201820192020007;
    $lid = $decrypt;
	$del = "DELETE FROM uploads WHERE adid =?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $del)) {
		header("location:myprofile?res=0");
	} else {
		mysqli_stmt_bind_param($stmt, "i" , $lid);
		mysqli_stmt_execute($stmt);
		header("location:myprofile?res=1");
	}

} else if (isset($_GET['g'])) {
	/*decrypt url*/
    $data = $_GET['g'];
    $data2 = base64_decode(urldecode($data));
    $decrypt = $data2/201820192020007;
    $lid = $decrypt;
	$del = "DELETE FROM guploads WHERE gid =?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $del)) {
		header("location:myprofile?res=0");
	} else {
		mysqli_stmt_bind_param($stmt, "i" , $lid);
		mysqli_stmt_execute($stmt);
		header("location:myprofile?res=1");
	}

} else if (isset($_GET['p'])) {
	/*decrypt url*/
    $data = $_GET['p'];
    $data2 = base64_decode(urldecode($data));
    $decrypt = $data2/201820192020007;
    $lid = $decrypt;
	$del = "DELETE FROM puploads WHERE pid =?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $del)) {
		header("location:myprofile?res=0");
	} else {
		mysqli_stmt_bind_param($stmt, "i" , $lid);
		mysqli_stmt_execute($stmt);
		header("location:myprofile?res=1");
	}

} else if (isset($_GET['r'])) {
	/*decrypt url*/
    $data = $_GET['r'];
    $data2 = base64_decode(urldecode($data));
    $decrypt = $data2/201820192020007;
    $lid = $decrypt;
	$del = "DELETE FROM rentals WHERE rid =?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $del)) {
		header("location:myprofile?res=0");
	} else {
		mysqli_stmt_bind_param($stmt, "i" , $lid);
		mysqli_stmt_execute($stmt);
		header("location:myprofile?res=1");
	}

} else if (isset($_GET['e'])) {
	/*decrypt url*/
    $data = $_GET['e'];
    $data2 = base64_decode(urldecode($data));
    $decrypt = $data2/201820192020007;
    $lid = $decrypt;
	$del = "DELETE FROM events WHERE evid =?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $del)) {
		header("location:myprofile?res=0");
	} else {
		mysqli_stmt_bind_param($stmt, "i" , $lid);
		mysqli_stmt_execute($stmt);
		header("location:myprofile?res=1");
	}

}


}
}



?>
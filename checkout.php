<?php
include("header.php");
if(!$_SESSION['user_name']){
	header("location: login.php");
}
else{

include("connection.php");
$uname = $_SESSION['user_name'];
if (isset($_SERVER['HTTP_CLIENT_IP']))
$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
else if(isset($_SERVER['HTTP_X_FORWARDED']))
	$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
else if(isset($_SERVER['HTTP_FORWARDED']))
	$ipaddress = $_SERVER['HTTP_FORWARDED'];
else if(isset($_SERVER['REMOTE_ADDR']))
	$ipaddress = $_SERVER['REMOTE_ADDR'];
else
	$ipaddress = 'UNKNOWN';
$userip = $ipaddress;
if(isset($_GET['id']))
{
    $id=mysqli_real_escape_string($con,$_GET['id']);
    $chk=mysqli_query($con,"select * from cart WHERE id='$id' AND ip='$userip'");
    $chk3=mysqli_fetch_assoc($chk);
    $pid = $chk3['pro_id'];
    $pcat = $chk3['pro_cat'];
    $pqty = $chk3['quantity'];
    $insertorder = "INSERT into orders(USER_NAME, PRO_ID, PRO_CAT, QUANTITY) values ('$uname','$pid','$pcat','$pqty')";
    $queryexe = mysqli_query($con,$insertorder);
    if($queryexe){
        $cart_del1 = "delete from cart where ip='$userip' AND id='$id'";
        $cart_del2 = mysqli_query($con,$cart_del1);
    }
}
else{
$chk1 = "SELECT * FROM cart WHERE ip='$userip'";
$chk2 = mysqli_query($con,$chk1);
while($chk3 = mysqli_fetch_assoc($chk2)){
	$pid = $chk3['pro_id'];
	$pcat = $chk3['pro_cat'];
	$pqty = $chk3['quantity'];
	$insertorder = "INSERT into orders(USER_NAME, PRO_ID, PRO_CAT, QUANTITY) values ('$uname','$pid','$pcat','$pqty')";
    $queryexe = mysqli_query($con,$insertorder);
}
    if($queryexe){
		$cart_del1 = "delete from cart where ip='$userip'";
		$cart_del2 = mysqli_query($con,$cart_del1);
	}
}}
?>
<html>
<head lang="en-US">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-compatible" Content="IE-edge">
        <meta name="viewport" content="width-device-width">
        <title>Studyleague IT Solutions - Web Intermediate</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
</head>
<body>

	
	
	<h1 align="center" >THANKYOU FOR ORDERING!!!!</h1>

</body>	
</html>
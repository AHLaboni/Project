<?php
session_start();
$Username=$_SESSION["username"];
?>
<!DOCTYPE html>
<html>
<head>
<title>HomePage</title>
</head>
<body>
	<h1>
<?php
if(!isset($_SESSION["username"])){
	header("Location:login.php");
}	
include 'header.php';

	echo'<br>';
	echo ' <form>
	<center>
	<a href="orderlist.php">Order list</a>
	<a href="orderhistory.php">Order History</a>
	<a href="livechat.php">Live Chat</a>
	</center>
	</form>';

	echo '<h3><center>Online Grocery Shop</center></center></h3>	
	<fieldset></fieldset>
	<h3><center>Our Services</center></center></h3>
	<fieldset>
	<p>Chaldal.com is an online shop available in Dhaka, Chattogram, Jashore, Khulna, Sylhet, Gazipur, Rajshahi and Narayanganj. We believe time is valuable to our fellow residents, and that they should not have to waste hours in traffic, brave bad weather and wait in line just to buy basic necessities like eggs!
	 This is why Chaldal delivers everything you need right at your door-step and at no additional cost.</p>
	</fieldset>';

?>

	
<?php include 'footer.php';?>
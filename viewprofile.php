<?php 
session_start();
$Username=$_SESSION["username"];
$UserIndex=-1;
$First_Name =$Last_Name =$Email =$Mobile_no =$SHR =$Gender =$Country="";
$img="";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Profile</title>
</head>
<body>
<h1>
<?php
include 'header.php';
?>
</h1>
<?php
if(filesize("data.json")>0){
		$f = fopen("data.json", 'r');
		$s = fread($f, filesize("data.json"));
		$data = json_decode($s);
		for ($x = 0; $x < count($data); $x++) {
			if($data[$x]->username===$Username){
				$UserIndex=$x;
				break;
			}
		}
		$First_Name=$data[$UserIndex]->firstname;
		$Last_Name=$data[$UserIndex]->lastname;
		$Gender=$data[$UserIndex]->gender;
		$Email=$data[$UserIndex]->email;
		$Mobile_no=$data[$UserIndex]->mobile_no;
		$SHR=$data[$UserIndex]->address;
		$Country=$data[$UserIndex]->country;
		$img=$data[$UserIndex]->image;

		fclose($f);
}
?>
<br><br>
<fieldset>
	<legend>Profile Photo</legend>
	<img src="img\<?php echo $img ?>" height = "200" width="200" alt="Profile Picture">

</fieldset>
<br><br>
<fieldset>
	<legend>Bio</legend>


</fieldset>
<br><br>
<fieldset>

	<legend>Profile Info</legend>
	<fieldset>
		<legend>General Info</legend>
		<label><b>First Name:</b></label>
		<label><?php echo $First_Name ?></label>
		<hr>
		<label><b>Last Name:</b></label>
		<label><?php echo $Last_Name ?></label>
		<hr>
		<label><b>Gender:</b></label>
		<label><?php echo $Gender ?></label>
		<hr>
		<label><b>Date of birth:</b></label>
		<hr>
		<label><b>NID number:</b></label>
		<hr>
		<label><b>Nationality:</b></label>
		<hr>
		<label><b>Blood group:</b></label>
	</fieldset>
<br>
	<fieldset>
		<legend>Contact Info</legend>
		<label><b>Email:</b></label>
		<label><?php echo $Email ?></label>
		<hr>
		<label><b>Mobile No:</b></label>
		<label><?php echo $Mobile_no ?></label>
	</fieldset>
<br>
	<fieldset>
		<legend>Address</legend>
		<label><b>Street:</b></label>
		<label><?php echo $SHR ?></label>
		<hr>
		<label><b>Country:</b></label>
		<label><?php echo $Country ?></label>
	</fieldset>
</fieldset>
</body>
</html>

<?php include 'footer.php';?>
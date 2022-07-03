<?php
session_start();
if(!isset($_SESSION["username"])){
	header("Location:login.php");
}
$Username=$_SESSION["username"];
$UserIndex=-1;
$errorcount=0;
$First_Name =$Last_Name =$Email =$Mobile_no =$SHR =$Gender =$Country =$DOB=$NID=$Nationality=$Blood=$BIO="";
$img="";
$firstnameErrMsg =$lastnameErrMsg = $genderErrMsg = $emailErrMsg = $mobileErrMsg = $address1ErrMsg = $countryErrMsg ="";
$InfoStatus="";
$uppercase=$lowercase=$number=$specialChars="";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Profile</title>
</head>
<body>
<?php
include 'header.php';
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
		$DOB=$data[$UserIndex]->dob;
		$NID=$data[$UserIndex]->nid;
		$Nationality=$data[$UserIndex]->nationality;
		$BIO=$data[$UserIndex]->bio;
		$Blood=$data[$UserIndex]->blood;


		fclose($f);
		}

		if ($_SERVER['REQUEST_METHOD'] === "POST") {

		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		$First_Name = test_input($_POST['firstname']);
		$Last_Name = test_input($_POST['lastname']);
		$Email = test_input($_POST['email']);
		$Mobile_no = test_input($_POST['mobile_no']);
		$SHR = test_input($_POST['address']);
		$Gender = isset($_POST['gender']) ? test_input($_POST['gender']):NULL;
		$Country = isset($_POST['country']) ? test_input($_POST['country']):NULL;
		$DOB=isset($_POST['dob']) ? test_input($_POST['dob']):NULL;
		$NID=test_input($_POST['nid']);
		$Nationality=test_input($_POST['nationality']);
		$Blood=isset($_POST['blood']) ? test_input($_POST['blood']):NULL;
		$BIO=test_input($_POST['bio']);
		$img=test_input($_POST['imgurl']);
		if($img==""){
			$img="DefaultUser.png";
		}
		

		if(empty($First_Name)){
			$firstnameErrMsg = "First Name is Empty";
			$errorcount++;
		}
		else{
			if (!preg_match("/^[a-zA-Z-' ]*$/",$First_Name)) {
				$errorcount++;
				$firstnameErrMsg = "Only letters and spaces";
			}}
		if(empty($Last_Name)){
			$lastnameErrMsg = "Last Name is Empty";
			$errorcount++;
		}
		else {
			if (!preg_match("/^[a-zA-Z-' ]*$/",$Last_Name)) {
				$errorcount++;
				$lastnameErrMsg = "Only letters and spaces";
			}
		}
		if(empty($Gender)){
			$genderErrMsg = "Gender is Empty";
			$errorcount++;
		}

		if(empty($Country)){
			$countryErrMsg = "Country is Empty";
			$errorcount++;
		}
		if(empty($Mobile_no)){
			$mobileErrMsg = "Mobile  is Empty";
			$errorcount++;
		}
		if(empty($Email)){
			$emailErrMsg = "Email  is Empty";
			$errorcount++;
		}
		else {
			if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
				$emailErrMsg .= "Please correct your email";
				$errorcount++;
			}
		}
		if(empty($SHR)){
			$address1ErrMsg = "Address is Empty";
			$errorcount++;
		}

		if($errorcount==0){
			if(filesize("data.json")>0){
				$f = fopen("data.json", 'r');
				$s = fread($f, filesize("data.json"));
				$data = json_decode($s);
				$data[$UserIndex]->firstname=$First_Name;
				$data[$UserIndex]->lastname=$Last_Name;
				$data[$UserIndex]->gender=$Gender;
				$data[$UserIndex]->email=$Email;
				$data[$UserIndex]->mobile_no=$Mobile_no;
				$data[$UserIndex]->address=$SHR;
				$data[$UserIndex]->country=$Country;
				$data[$UserIndex]->image=$img;
				$data[$UserIndex]->dob=$DOB;
				$data[$UserIndex]->nid=$NID;
				$data[$UserIndex]->nationality=$Nationality;
				$data[$UserIndex]->bio=$BIO;
				$data[$UserIndex]->blood=$Blood;
				fclose($f);
				$f = fopen("Data.json", "w");
				fwrite($f, json_encode($data));
				fclose($f);
			}
			$InfoStatus="Changes saved successfully";
		}
	}
?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="POST" novalidate>
<br><br>
<fieldset>
	<legend>Profile Photo</legend>
	<img src="img\<?php echo $img ?>" height = "100" width="100" alt="Profile Picture">
	<input type="text" id="impurl1" name="imgurl" value="<?php echo $img;?>">
	<input type="file" id="imgurl" name="imgurl" accept="image/*">
</fieldset>
<br><br>
<fieldset>
	<legend>Bio</legend>
	<label for="bio"> Write something about you</label>
	<input type="text" id="bio" name="bio" value="<?php echo $BIO;?>">
</fieldset>
<br><br>
<fieldset>

	<legend>Profile Info</legend>
	<fieldset>
		<legend>General Info</legend>
		<label for="fname"><b>First Name:</b></label>
		<input type="text" name="firstname" id="fname" value="<?php echo $First_Name;?>">
		<span style="color: red">*
		<?php
			echo $firstnameErrMsg;
		?>
		</span>
		<br><br>
		<label for="lname"><b>Last Name:</b></label>
		<input type="text" name="lastname" id="lname" value="<?php echo $Last_Name;?>">
		<span style="color: red">*
		<?php
			echo $lastnameErrMsg;
		?>
		</span>
		<br><br>
		<label><b>Gender:</b></label>
		<input type="radio" id="male" name="gender" value="Male" <?php if($Gender=="Male"){echo "checked";}?> >
		<label for="male">Male</label>
		<input type="radio" id="female" name="gender" value="Female" <?php if($Gender=="Female"){echo "checked";}?> >
		<label for="female">Female</label>
		<span style="color: red">*
		<?php
			echo $genderErrMsg;
		?>
		</span>
		<br><br>
		<label for="dob"><b>Date of birth:</b></label>
		<input type="date" id="dob" name="dob"value="<?php echo $DOB;?>">
		<br><br>
		<label for ="nid"><b>NID number:</b></label>
		<input type="number" id="nid" name="nid" value="<?php echo $NID;?>">
		<br><br>
		<label for="nationality"><b>Nationality:</b></label>
		<input type="text" id="nationality" name="nationality" value="<?php echo $Nationality;?>">
		<br><br>
		<label for=blood><b>Blood group:</b></label>
		<select id="blood" name="blood">
			<option>A Positive</option>
		    <option>A Negative</option>
		    <option>A Unknown</option>
		    <option>B Positive</option>
		    <option>B Negative</option>
		    <option>B Unknown</option>
		    <option>AB Positive</option>
		    <option>AB Negative</option>
		    <option>AB Unknown</option>
		    <option>O Positive</option>
		    <option>O Negative</option>
		    <option>O Unknown</option>
		    <option>Unknown</option>
		    <option value="<?php echo $Blood;?>"selected><?php echo $Blood;?></option>
		</select>
	</fieldset>
<br>
	<fieldset>
		<legend>Contact Info</legend>
		<label for="email"><b>Email</b></label>
		<input type="text" name="email" id="email"value="<?php echo $Email;?>">
		<span style="color: red">*
		<?php
			echo $emailErrMsg;
		?>
		</span>
		<br><br>
		<label for="mno"><b>Mobile No</b></label>
		<input type="number" name="mobile_no" id="mno"value="<?php echo $Mobile_no;?>">
		<span style="color: red">*
		<?php
			echo $mobileErrMsg;
		?>
		</span>
	</fieldset>
<br>
	<fieldset>
		<legend>Address</legend>
		<label for="address"><b>Street/House/Road</b></label>
		<input type="text" name="address" id="address"value="<?php echo $SHR;?>">
		<span style="color: red">*
		<?php
			echo $address1ErrMsg;
		?>
		</span>
		<br><br>
		<label for="country"><b>Country</b></label>
		<select id="country" name="country">
			<option value="Afghanistan">Bangladesh</option>
			<option value="Albania">Inida</option>
			<option value="Algeria">USA</option>
			<option value="<?php echo $Country;?>"selected><?php echo $Country;?></option>

		</select>
		<span style="color: red">*
		<?php
			echo $countryErrMsg;
		?>
		</span>
	</fieldset>
</fieldset>
<br>
<input type="submit" name="submit" value="save change">
</form>
<h1><?php
			echo $InfoStatus;
?></h1>
</body>
</html>
<?php include 'footer.php';?>
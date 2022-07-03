<!DOCTYPE html>
<html>
<head>
<title>Registration</title>
</head>
<body>
	<?php 
	
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
		$Password = test_input($_POST['password']);
		$Username = test_input($_POST['username']);
		$CPassword = test_input($_POST['cpassword']);

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
		if(empty($Password)){
			$passwordErrMsg = "Password is Empty";
			$errorcount++;
		}
		else if(!empty($Password)and $CPassword==$Password){
			$uppercase = preg_match('@[A-Z]@', $Password);
			$lowercase = preg_match('@[a-z]@', $Password);
			$number    = preg_match('@[0-9]@', $Password);
			$specialChars = preg_match('@[^\w]@', $Password);
				if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($Password) < 8) {
    					$passwordErrMsg="Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
    						$errorcount++;
						}
		}
		if(empty($CPassword)){
			$cpasswordErrMsg = "Retype password here";
			$errorcount++;
		}
		if($CPassword!=$Password){
			$cpasswordErrMsg = "Confirmed Password not same";
			$errorcount++;
		}
		
		if(empty($Username)){
			$usernameErrMsg = "Username is Empty";
			$errorcount++;
		}
		else
		{
			if(filesize("data.json")>0){
					$f = fopen("data.json", 'r');
					$s = fread($f, filesize("data.json"));
					$data = json_decode($s);
					for ($x = 0; $x < count($data); $x++) {
						if($data[$x]->username===$Username){
							$usernameErrMsg = "Username Already Exist";
							$errorcount++;
							break;
						}
					}
					fclose($f);
			}

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
			if(filesize("data.json")<=0){
			$arr = array(array('firstname' => $First_Name, 'lastname' => $Last_Name ,'gender' => $Gender,'email'=> $Email,'mobile_no'=>$Mobile_no,'address'=> $SHR,'country'=>$Country,'password'=>$Password,'username'=>$Username,'image'=>$Image));
			$f = fopen("data.json", "a");
			fwrite($f, json_encode($arr));
			fclose($f);
			}
			else if(filesize("data.json")>0){
			$arr2 = array('firstname' => $First_Name, 'lastname' => $Last_Name ,'gender' => $Gender,'email'=> $Email,'mobile_no'=>$Mobile_no,'address'=> $SHR,'country'=>$Country,'password'=>$Password,'username'=>$Username,'image'=>$Image);
			$f = fopen("data.json", 'r');
			$s = fread($f, filesize("data.json"));
			$data = json_decode($s);
			array_push($data, $arr2);
			fclose($f);
			$f = fopen("data.json", "w");
			fwrite($f, json_encode($data));
			fclose($f);
			}

			$registrationStatus="Registration Successfull";
		}

		else{
			$registrationStatus="Registration failed";
		}	
	}		
?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="POST" novalidate>
	<fieldset>
    <legend>General</legend>
		<label for="fname">First Name:</label>
		<input type="text" name="firstname" id="fname" value="<?php if($registrationStatus!="Registration Successfull"){echo $First_Name;}?>">
		<span style="color: red">*
		<?php
			echo $firstnameErrMsg;
		?>
		</span>
		<br><br>
		<label for="lname">Last Name:</label>
		<input type="text" name="lastname" id="lname"value="<?php if($registrationStatus!="Registration Successfull"){echo $Last_Name;}?>">
		<span style="color: red">*
		<?php
			echo $lastnameErrMsg;
		?>
		</span>
		<br><br>
		<label>Gender</label>
		<input type="radio" id="male" name="gender" value="Male" <?php if($Gender=="Male"and $registrationStatus!="Registration Successfull"){echo "checked";}?> >
		<label for="male">Male</label>
		<input type="radio" id="female" name="gender" value="Female" <?php if($Gender=="Female"and $registrationStatus!="Registration Successfull"){echo "checked";}?> >
		<label for="female">Female</label>
		<span style="color: red">*
		<?php
			echo $genderErrMsg;
		?>
		</span>
	</fieldset>
	<fieldset>
		<legend>Contact</legend>
		<label for="email">Email</label>
		<input type="text" name="email" id="email"value="<?php if($registrationStatus!="Registration Successfull"){echo $Email;}?>">
		<span style="color: red">*
		<?php
			echo $emailErrMsg;
		?>
		</span>
		<br><br>
		<label for="mno">Mobile No</label>
		<input type="number" name="mobile_no" id="mno"value="<?php if($registrationStatus!="Registration Successfull") {echo $Mobile_no;}?>">
		<span style="color: red">*
		<?php
			echo $mobileErrMsg;
		?>
		</span>

	</fieldset>
	<fieldset>
		<legend>Address</legend>
		<label for="address">Street/House/Road</label>
		<input type="text" name="address" id="address"value="<?php if($registrationStatus!="Registration Successfull"){echo $SHR;}?>">
		<span style="color: red">*
		<?php
			echo $address1ErrMsg;
		?>
		</span>
		<br><br>
		<label for="country">Country</label>
		<select id="country" name="country">
			<option value="Bangladesh">Bangladesh</option>
			<option value="India">India</option>
			<option value="USA">USA</option>
			<option value="<?php if($registrationStatus!="Registration Successfull"){echo $Country;}?>"selected><?php if($registrationStatus!="Registration Successfull"){echo $Country;}?></option>

		</select>
		<span style="color: red">*
		<?php
			echo $countryErrMsg;
		?>
		</span>
	</fieldset>
	<fieldset>
		<legend>Log in Info</legend>
		<label for="username">Username</label>
		<input type="text" name="username" id="username"value="<?php if($registrationStatus!="Registration Successfull"){echo $Username;}?>">
		<span style="color: red">*
		<?php
			echo $usernameErrMsg;
		?>
		</span>
		<br><br>
		<label for="password">New password</label>
		<input type="password" name="password" id="password"value="<?php if($registrationStatus!="Registration Successfull"){echo $Password;}?>">
		<span style="color: red">*
		<?php
			echo $passwordErrMsg;
		?>
		</span>
		</span>
		<br><br>
		<label for="cpassword">Confirm password</label>
		<input type="password" name="cpassword" id="cpassword"value="<?php if($registrationStatus!="Registration Successfull"){echo $CPassword;}?>">
		<span style="color: red">*
		<?php
			echo $cpasswordErrMsg;
		?>
		</span>

	</fieldset>
	<br>
	<input type="Submit" value="Registration">
</form>
<br>

<form action="users-database.php">
	<label >Registered users</label>
	<input type="Submit" value="Click here">
</form>
<br>
<form action="login.php">
	<label >Already have an account? To log in</label>
	<input type="Submit" value="Click here">
</form>

<h1><?php
			echo $registrationStatus;
?></h1>
</body>
</html>
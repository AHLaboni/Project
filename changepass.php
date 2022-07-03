<?php
session_start();
if(!isset($_SESSION["username"])){
	header("Location:login.php");
}
$Username=$_SESSION["username"];
$passwordErrMsg=$cpasswordErrMsg=$CurentPassErrMsg="";
$Password=$CPassword=$CurentPass="";
$ChangeStatus="";
$count1=0;
$errorcount=0;
$uppercase=$lowercase=$number=$specialChars="";
$userindexD=-1;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Change Password</title>
</head>
<body>
<?php
	include 'header.php';
	if ($_SERVER['REQUEST_METHOD'] === "POST"){
			function test_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
			$Password = test_input($_POST['password']);
			$CPassword = test_input($_POST['cpassword']);
			$CurentPass = test_input($_POST['CurentPass']);
			
			if(empty($Password)){
				$passwordErrMsg = "New password is Empty";
				$errorcount++;
			}
			if(empty($CPassword)){
				$cpasswordErrMsg = "Confirmed password is Empty";
				$errorcount++;
			}
			if(empty($CurentPass)){
				$CurentPassErrMsg = "Current password is Empty";
				$errorcount++;
			}
			if($Password!=""and $CPassword!=""and $Password!=$CPassword)	{
				$cpasswordErrMsg="Confirmed password is not same";
				$errorcount++;
			}
			if(!empty($Password)and!empty($CPassword)and $CPassword==$Password){
			$uppercase = preg_match('@[A-Z]@', $Password);
			$lowercase = preg_match('@[a-z]@', $Password);
			$number    = preg_match('@[0-9]@', $Password);
			$specialChars = preg_match('@[^\w]@', $Password);
				if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($Password) < 8) {
    					$passwordErrMsg="Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
    						$errorcount++;
						}
			}


			if(filesize("Data.json")>0){
					$f = fopen("Data.json", 'r');
					$s = fread($f, filesize("Data.json"));
					$data = json_decode($s);
					for ($x = 0; $x < count($data); $x++) {
						if($data[$x]->username===$Username){
							$userindexD=$x;
							break;
							}
						}
						fclose($f);
					}
			if($data[$userindexD]->password!=$CurentPass){
				$CurentPassErrMsg = "Current password does not match";
				$errorcount++;
			}

			if($errorcount==0){
				$data[$userindexD]->password=$Password;
				$f = fopen("Data.json", "w");
				fwrite($f, json_encode($data));
				fclose($f);

				$ChangeStatus="Password Changed Successfully";

				}
			}


?>	<br><br>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="POST" novalidate>
<fieldset>
		<legend> Change Password</legend>
		<label for="CurentPass">Current Password</label>
		<input type="password" name="CurentPass" id="CurentPass"value="<?php if($ChangeStatus!="Password Changed Successfully"){echo $CurentPass;}?>">
		<span style="color: red">*
		<?php
			echo $CurentPassErrMsg;
		?>
		</span>
			<br><br>
		<label for="password">New Password</label>
		<input type="password" name="password" id="password"value="<?php if($ChangeStatus!="Password Changed Successfully"){echo $Password;}?>">
		<span style="color: red">*
		<?php
			echo $passwordErrMsg;
		?>
		</span>
		<br><br>
		<label for="cpassword">Confirm Password</label>
		<input type="password" name="cpassword" id="cpassword"value="<?php if($ChangeStatus!="Password Changed Successfully"){echo $CPassword;}?>">
		<span style="color: red">*
		<?php
			echo $cpasswordErrMsg;
		?>
		</span>
	
</fieldset>
<br>
<input type="submit" name="submit" value="Save Changes">
</form>
<h1><?php
			echo $ChangeStatus;
?></h1>
</body>
</html>
<?php include 'footer.php';?>

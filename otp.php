<?php
session_start();
$passwordErrMsg=$cpasswordErrMsg=$OTPErrMsg="";
$Password=$CPassword=$OTP="";
$uppercase=$lowercase=$number=$specialChars="";
$ResetStatus="";
$errorCount=0;
$userindex=-1;
$userindexD=-1;
$Username="";
if(isset($_SESSION["PassReset"])){
	$Username=$_SESSION["PassReset"];
}
if(!isset($_SESSION["PassReset"])){
	header("Location:forget.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Forgot Password</title>
</head>
<body>
<?php
		if ($_SERVER['REQUEST_METHOD'] === "POST"){
			function test_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}

			$Password=test_input($_POST['password']);
			$CPassword=test_input($_POST['cpassword']);
			$OTP=test_input($_POST['OTP']);

			if(empty($Password)){
					$passwordErrMsg="Password is empty";
					$errorCount++;
			}
			else if(!empty($Password)and $CPassword==$Password){
			$uppercase = preg_match('@[A-Z]@', $Password);
			$lowercase = preg_match('@[a-z]@', $Password);
			$number    = preg_match('@[0-9]@', $Password);
			$specialChars = preg_match('@[^\w]@', $Password);
				if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($Password) < 8) {
    					$passwordErrMsg="Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
    						$errorCount++;
						}
			}
			if(empty($CPassword)){
					$cpasswordErrMsg="Retype Password here";
					$errorCount++;
			}
			if($Password!=$CPassword){
					$cpasswordErrMsg="Confirmed password not same";
					$errorCount++;
			}

			if(empty($OTP)){
					$OTPErrMsg="You must Fill OTP";
					$errorCount++;
			}
			else{
					if(filesize("OTP.json")>0){
					$f = fopen("OTP.json", 'r');
					$s = fread($f, filesize("OTP.json"));
					$data = json_decode($s);
					for ($x = 0; $x < count($data); $x++) {
						if($data[$x]->username===$Username){
							$userindex=$x;
							break;
							}
						}
					}
					if(filesize("OTP.json")>0){
					$f = fopen("OTP.json", 'r');
					$s = fread($f, filesize("OTP.json"));
					$data = json_decode($s);
					if($data[$userindex]->OTP!=$OTP){
						$OTPErrMsg="OTP does not match";
						$errorCount++;
							}
					
					}	
					
				}

				if($errorCount==0){


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
					}

					if(filesize("Data.json")>0){
							$f = fopen("Data.json", 'r');
							$s = fread($f, filesize("Data.json"));
							$data = json_decode($s);
							$data[$userindexD]->password = $Password;
							fclose($f);
							$f = fopen("Data.json", "w");
							fwrite($f, json_encode($data));
							fclose($f);
					}
							
					$ResetStatus="Password Reset Successful";
					session_unset();
					session_destroy();

				}

		}

?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="POST" novalidate>
	</fieldset>
<fieldset>
		<legend> Reset Password</legend>
		<label for="password">New Password</label>
		<input type="password" name="password" id="password"value="<?php if($ResetStatus!="Password Reset Successful"){echo $Password;}?>">
		<span style="color: red">*
		<?php
			echo $passwordErrMsg;
		?>
		</span>
		<br><br>
		<label for="cpassword">Confirm Password</label>
		<input type="password" name="cpassword" id="cpassword"value="<?php if($ResetStatus!="Password Reset Successful"){echo $CPassword;}?>">
		<span style="color: red">*
		<?php
			echo $cpasswordErrMsg;
		?>
		</span>

		<br><br>
		<label for="OTP">Enter OTP</label>
		<input type="number" name="OTP" id="OTP">
		<span style="color: red">*
		<?php
			echo $OTPErrMsg;
		?>
		</span>

</fieldset>
<br>
<input type="submit" name="submit" value="Save Changes">
</form>
<br>
<form action="Forgot.php">
	<label >Did not got OTP?</label>
	<input type="Submit" value="Click here">
</form>

<h1>
		<?php
			echo $ResetStatus;
		?>	
	</h1>
	<?php 
		if($ResetStatus=="Password Reset Successful"){
				echo 	"<form action="."login.php".">";
				echo	"<label >To log in </label>";
				echo	"<input type="."Submit"." value="."Click_Here".">";
				echo 	"</form>";
				}
	?>
</body>
</html>

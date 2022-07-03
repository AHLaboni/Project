<?php 
session_start();
$cookie_name="user";
$usernameErrMsg="";
$Remembered="";
$Otpstatus="";
$errorcount=0;
$count1=0;
$userindex=-1;
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
if(isset($_COOKIE[$cookie_name])) {
			  $Remembered = $_COOKIE[$cookie_name];
			}
	if ($_SERVER['REQUEST_METHOD'] === "POST"){
			function test_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
			$Username = test_input($_POST['username']);
			if (empty($Username)){
								$usernameErrMsg="Username is empty";
								$errorcount++;
						}
			else{
				if(filesize("data.json")>0){
					$f = fopen("data.json", 'r');
					$s = fread($f, filesize("data.json"));
					$data = json_decode($s);
					for ($x = 0; $x < count($data); $x++) {
						if($data[$x]->username==$Username){
							$count1++;
						}
					}
					if($count1===0){
						$usernameErrMsg="Username does not exist";
						$errorcount++;
					}
				}
			}

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
			if($errorcount==0){
						if(filesize("OTP.json")<=0){
						$arr = array(array('username'=>$Username,'OTP'=> rand(1000,9999)));
						$f = fopen("OTP.json", "a");
						fwrite($f, json_encode($arr));
						fclose($f);
						}
						elseif (filesize("OTP.json")>0 and $userindex==-1) {
							$arr2 = array('username'=>$Username,'OTP'=> rand(1000,9999));
							$f = fopen("OTP.json", 'r');
							$s = fread($f, filesize("OTP.json"));
							$data = json_decode($s);
							array_push($data, $arr2);
							fclose($f);
							$f = fopen("OTP.json", "w");
							fwrite($f, json_encode($data));
							fclose($f);
						}
						else{
							$f = fopen("OTP.json", 'r');
							$s = fread($f, filesize("OTP.json"));
							$data = json_decode($s);
							$data[$userindex]->OTP = rand(1000,9999);
							fclose($f);
							$f = fopen("OTP.json", "w");
							fwrite($f, json_encode($data));
							fclose($f);

						}
							$Otpstatus = "OTP Sent";
							$_SESSION["PassReset"] = $Username;
						}
			else{
						$Otpstatus = "Failed to send OTP";
					}
		}
?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"method="POST" novalidate>
	<fieldset>
		<legend>Send OTP</legend>
		<label for="username">Username</label>
	<input type="text" name="username" id="username" value="<?php if($Otpstatus!="OTP Sent"){echo $Remembered; }?>">
	<span style="color: red">*
		<?php
			echo $usernameErrMsg;
		?>
		</span>
		<br><br>
		<input type="submit" name="submit" value="Send">
</form>
</fieldset>
<h1>
	<?php
			echo $Otpstatus;
	?>
	</h1>
	<?php 
		if($Otpstatus=="OTP Sent"){
				echo 	"<form action="."otp.php".">";
				echo	"<label >To reset password using OTP </label>";
				echo	"<input type="."Submit"." value="."Click_Here".">";
				echo 	"</form>";
				}
	?>
</form>
</body>
</html>
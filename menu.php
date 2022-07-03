<?php
$Username=$_SESSION["username"];
$UserIndex=-1;
$img="";
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
		$img=$data[$UserIndex]->image;
		fclose($f);
}
		
		echo	"<img src="."img/".$img." height="."30" ."width="."30".">";
		echo " <h3> Welcome, " . $Username . "</h3>";

	echo '<form>
		<a href="homepage.php">Home</a>-
		<a href="viewprofile.php">View Profile</a>-
		<a href="editprofile.php">Edit Profile</a>-
		<a href="changepass.php">Change Password</a>-
		<a href="logout.php">Logout</a>
	</form>'
?>

<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 2px solid black;
  border-collapse: collapse;
}
</style>
</head>
<body>
<?php
	if(filesize("data.json")<=0){
		echo"No users Available";
	}
	else{
$f = fopen("data.json", 'r');
	$s = fread($f, filesize("data.json"));
	$data = json_decode($s);

	echo "<table>";
	echo "<tr>";
	echo "<th>Firstname</th>";
	echo "<th>LastName</th>";
	echo "<th>Gender</th>";
	echo "<th>Email</th>";
	echo "<th>Mobile No</th>";
	echo "<th>Address</th>";
	echo "<th>Country</th>";
	echo "<th>Username</th>";
	echo "</tr>";
	for ($x = 0; $x < count($data); $x++) {
	echo "<tr>";
  	echo "<td>" . $data[$x]->firstname . "</td>";
	echo "<td>" . $data[$x]->lastname . "</td>";
	echo "<td>" . $data[$x]->gender . "</td>";
	echo "<td>" . $data[$x]->email . "</td>";
	echo "<td>" . $data[$x]->mobile_no . "</td>";
	echo "<td>" . $data[$x]->address . "</td>";
	echo "<td>" . $data[$x]->country . "</td>";
	echo "<td>" . $data[$x]->username . "</td>";
	echo "</tr>";
	}
	echo "</table>";
	fclose($f);
	}
	?>
</body>
</html>

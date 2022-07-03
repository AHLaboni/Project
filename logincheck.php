<?php
session_start();

$data = file_get_contents('data.json');
$mydata = json_decode($data);


if(isset($_POST["submit"]))

{
     foreach($mydata as  $key => $udata)
     {
     
                    
               if($udata->uname==$_POST["uname"] && $udata->password==$_POST["password"])
               {

                    $_SESSION["uname"]=$_POST["uname"];
                    $_SESSION["password"]=$_POST["password"];
                    header("location: ../View/profile.php");
               }     
     }
     

     echo "<h1>Your username or password is incorrect !<h1>";
          
}

?>

<?php
$name=$uname=$gr=$emailerr=$cp=$nameerr=$unameerr="";
if(isset($_POST["submit"]))
{

    $name= $_REQUEST['name']; 

    if(empty($name) || strlen($name)<3)
    {
        $nameerr= "The Name Must Be At Least 3 Characters";
    }
    else
    {
        $nameerr= "Name = ".$name;
    }
     
    $uname= $_REQUEST['uname'];
    if(empty($uname) || strlen($uname)<6)
    {
        $unameerr= "The User Name Must Be At Least 5 Characters";
    }
    else
    {
        $unameerr= "User name = ".$uname;
    } 
    if(isset($_POST["gender"]))
    {
        $gr= "Gender =".$_POST["gender"] ;
    }
    else{
        $gr= "Please select your gender ";
    } 
    $email= $_REQUEST['email'];

        if(empty($email) || !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",$email))
        {
            $emailerr= "Please enter a valid email";
        }
        else
        {
            $emailerr= "Email Address = ".$email;
        }

        $password= $_REQUEST['password']; 
        $confirmpassword=$_REQUEST['confirmpassword'];
    
            if(empty($password) || strlen($password)<6)
            {
                $cp=  "The Password Field Must Be At Least 5 Characters";
            }
            else if($password != $confirmpassword)
            {
                $cp= "The Confirm Password Confirmation Does not Match";
            }
            else
            {
                $cp= "Password is valid";
            }

    $formdata = array(
        'name'=> $_POST["name"],
        'uname'=> $_POST["uname"],
        'gender'=> $_POST["gender"],
        'email'=>$_POST["email"],
        'password'=> $_POST["password"],
        'confirmpassword'=>$_POST["confirmpassword"]
     );
     $existingdata = file_get_contents('data.json');
     $tempJSONdata = json_decode($existingdata);
     $tempJSONdata[] =$formdata;
     $jsondata = json_encode($tempJSONdata, JSON_PRETTY_PRINT);
    
     if(file_put_contents('data.json', $jsondata)) {
          echo "Data successfully saved <br>";
      }
     else 
     {
          echo "no data saved";
     }
}
?>
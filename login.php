<?php

$page_title = "Login Page";
require_once('includes/config.inc.php');
require_once("includes/header.inc.php");
require_once('includes/Utils.php');
require_once('includes/dataaccess/loginDataAccess.php');

require_once("includes/header.inc.php");
$Utils = new Utils();



?>



<?php
if($_POST)
{



    
    include 'config.php';
    $username=$_POST['username'];
    if(strpos($username, '@') ==false){
        echo ('this is not a valid email, "@" ia missing <br>');

    }  if
        (strpos($username, '.') ==false){
        echo ('this is not a valid email, "." is missing <br>');
    
    

    }




    $password=$_POST['password'];
    $sUser=mysqli_real_escape_string($conn,$username);
    $sPass=mysqli_real_escape_string($conn,md5($password));
    // For Security 

    $query="SELECT * From users where user_email='$sUser' and user_password='$sPass' and user_active ='yes'" ;
    $result=mysqli_query($conn,$query);

        //echo(md5($password));
        //die();
    if(mysqli_num_rows($result)==1)
    {
        //session_start();
        //s
        $_SESSION['anything']='something';
        header('location:transaction-list.php');
    }else{
        echo "email and or password is incorrect";

    }
}

    




?>

<form method="POST">
    Email Adress:<br>
    <input type="text" name="username"><br>
    Password:<br>
    <input type="password" name="password"><br>
    <input type="submit">

</form>




<?php


// check for the query string param
//if(isset($_POST['btnSubmit'])){

	// remember that some HTML controls will not post if the user
	// does not set them, so we may need to use isset()
//	$login->id = $_POST['txtEmail'];
//	$login->date = $_POST['txtPassword'];
	
	
//}


require_once("includes/footer.inc.php");

?>

	
</script>

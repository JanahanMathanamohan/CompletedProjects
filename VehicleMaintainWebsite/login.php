<?php  ?>
<?php
session_start(); 
if( isset($_SESSION["user"]))
{
     header('Location: index.php');
}
else {
         $number_of_rows=checkpass();
         if($number_of_rows==1)
            {   
                $user = (is_numeric($_POST['user']) ? (int)$_POST['user'] : 0);
                $_SESSION["user"] = $user;
                
                if($user>=1000000000)
                {   
                    
                    header('Location: MechanicSignin.php');
                }else
                {
                    header('Location: DriverSignin.php');
                }
            }
            else{
                
                header('Location: FailedLogin.php');
            }
        
     }

function checkpass()
{
require_once('../config.php');
$pw = $_POST['pw'];
$user = (is_numeric($_POST['user']) ? (int)$_POST['user'] : 0);
$sql="SELECT Driver_Id AS ID
From driver
where Driver_Id = $user and Driver_PW = '$pw'  
UNION
SELECT Mechanic_Id AS ID
from mechanic
where Mechanic_ID = $user  and Mechanic_PW = '$pw'  
";
$result=mysql_query($sql,$conn) or die(mysql_error());
return  mysql_num_rows($result);
}
?>
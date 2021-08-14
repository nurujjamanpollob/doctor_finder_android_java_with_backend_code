<?php
include '../controllers/apicontrollers.php';
$apicontroller=new Apicontrollers();
extract($_GET);
if
(
    isset($logintype) && $logintype == "Google" &&
    isset($email) && $email != "" &&
    isset($name) && $name != "" &&
    isset($image) && $image != "" &&
    isset($platform) && $platform != "" &&
    isset($reg_id) && $reg_id != ""
)
{
    $checkuser=$apicontroller->checkuseremail($email);
    if($checkuser)
    {
        $loginauth=$apicontroller->mobileuserlogin("non","non",$email);
        if($loginauth)
        {
            $arr[]=array("status"=>"Success","User_info"=>$loginauth);
            echo json_encode($arr);
        }
        else
        {
            echo '[{"status":"Failed","Error":"Invalid Authentication"}]';
        }
    }
    else
    {
        $userregister = $apicontroller->userregister($name,$email,"",$image,$logintype,$reg_id,$platform);
        if ($userregister)
        {
            $mainarray[] = array("status" => "Success", "User_info" => $userregister);
            echo json_encode($mainarray);
        }
        else
        {
            echo '[{"status":"Failed","Error":"Please Try Again"}]';
        }
    }
}
elseif(
    isset($logintype) && $logintype == "Facebook" &&
    isset($email) && $email != "" &&
    isset($name) && $name != "" &&
    isset($image) && $image != "" &&
    isset($platform) && $platform != "" &&
    isset($reg_id) && $reg_id != ""
)
{
    $checkuser=$apicontroller->checkuseremail($email);
    if($checkuser)
    {
        $loginauth=$apicontroller->mobileuserlogin("non","non",$email);
        if($loginauth)
        {
            $arr[]=array("status"=>"Success","User_info"=>$loginauth);
            echo json_encode($arr);
        }
        else
        {
            echo '[{"status":"Failed","Error":"Invalid Authentication"}]';
        }
    }
    else
    {
        $userregister = $apicontroller->userregister($name,$email,"",$image,$logintype,$reg_id,$platform);
        if ($userregister)
        {
            $mainarray[] = array("status" => "Success", "User_info" => $userregister);
            echo json_encode($mainarray);
        }
        else
        {
            echo '[{"status":"Failed","Error":"Please Try Again"}]';
        }
    }
}
else{
    if(
        isset($username) && $username != "" &&
        isset($password) && $password != ""
    )
    {
        $uname = $username;
        $pass = $apicontroller->encrypt_decrypt("encrypt",$password);
        $loginauth=$apicontroller->mobileuserlogin($uname,$pass,"non");
        if($loginauth)
        {
            $arr[]=array("status"=>"Success","User_info"=>$loginauth);
            echo json_encode($arr);
        }
        else
        {
            echo '[{"status":"Failed","Error":"Invalid Login Username And Password"}]';
        }
    }
    else
    {
        echo '[{"status":"Failed","Error":"Username And Password Not Set"}]';
    }
}

/* App Userlogin http://192.168.1.113/clinicadmin/Apicontrollers/userlogin.php?username={}&password={}  */
/* Login With Google  http://192.168.1.113/clinicadmin/Apicontrollers/userlogin.php?logintype=Google&email={}&name={}&image={}&reg_id={}  */
/* Login With Facebook  http://192.168.1.113/clinicadmin/Apicontrollers/userlogin.php?logintype=Facebook&email={}&name={}&image={}&reg_id={}  */

?>
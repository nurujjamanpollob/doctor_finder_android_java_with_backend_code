<?php
include '../controllers/apicontrollers.php';
$apicontroller=new Apicontrollers();
extract($_REQUEST);
if(
    isset($username) && $username != "" &&
    isset($email) && $email != "" &&
    isset($password) && $password != "" &&
    isset($reg_id) && $reg_id != "" &&
    isset($platform) && $platform != ""
)
{
    $checkuser=$apicontroller->checkuseremail($email);
    if($checkuser)
    {
        echo '[{"status":"Failed","Error":"This Email Id Is Already In Exists"}]';
    }
    else
    {
        $pass = $apicontroller->encrypt_decrypt("encrypt", $password);
        $regtype="appuser";

            $userregister = $apicontroller->userregister($username, $email, $pass, "test.png",$regtype,$reg_id,$platform);
            if ($userregister)
            {
                $mainarray[]= array("status" => "Success", "UserDetail" => $userregister);
                echo json_encode($mainarray);
            }
            else
            {
                echo '[{"status":"Failed","Error":"Please Try Again"}]';
            }

    }
}
else
{
    echo '[{"status":"Failed","Error":"All Field is Required"}]';
}
?>
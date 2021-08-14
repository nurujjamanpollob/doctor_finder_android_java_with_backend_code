<?php
include '../controllers/apicontrollers.php';
$apicontroller=new Apicontrollers();
extract($_REQUEST);
if(
    isset($username) && $username != "" &&
    isset($email) && $email != "" &&
    isset($password) && $password != "" &&
    isset($reg_id) && $reg_id != "" &&
    isset($platform) && $platform != "" &&
    isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""
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
        $tmp_file = $_FILES['file']['tmp_name'];
        $file_path = "../uploads/" . "mobileuser_" . time().".png";
        $imagename = "mobileuser_" . time().".png";
        $regtype="appuser";
        if (move_uploaded_file($tmp_file, $file_path))
        {
            if($_FILES['file']['size'] > 1048576)
            {
                $apicontroller->compress($file_path,$file_path, 80);
            }
            $userregister = $apicontroller->userregister($username, $email, $pass, $imagename,$regtype,$reg_id,$platform);
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
        else
        {
            echo '[{"status":"Failed","Error":"File Uploading Error"}]';
        }
    }
}
else
{
    echo '[{"status":"Failed","Error":"All Field is Required"}]';
}

?>
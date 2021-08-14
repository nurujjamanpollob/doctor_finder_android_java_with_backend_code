<?php
include '../controllers/apicontrollers.php';
$apicontroller=new Apicontrollers();
extract($_GET);
if(isset($profile_id) && $profile_id != "")
{
    $review=$apicontroller->getallreviewbyid($profile_id);
    if($review)
    {
        $arr[]=array("status"=>"Success","List_review"=>$review);
        echo json_encode($arr);
    }
    else
    {
        echo '[{"status":"Failed","Error":"Review Not Found"}]';
    }
}
else
{
    echo '[{"status":"Failed","Error":"please select Doctor.. "}]';
}
?>
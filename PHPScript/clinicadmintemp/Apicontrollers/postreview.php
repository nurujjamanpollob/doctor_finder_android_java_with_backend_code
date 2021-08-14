<?php
include '../controllers/apicontrollers.php';
$apicontroller=new Apicontrollers();
extract($_GET);
if(
    isset($user_id) && $user_id!= "" &&
    isset($profile_id) && $profile_id!= "" &&
    isset($review_text) && $review_text!= "" &&
    isset($ratting) && $ratting!= ""
)
{
    $insertreview=$apicontroller->publishreview($user_id,$profile_id,$review_text,$ratting);
    if($insertreview)
    {
        echo '[{"status":"Success","Error":"Review Publish Successfully"}]';
    }
    else
    {
        echo '[{"status":"Failed","Error":"Review Not Publish Please Try Again"}]';
    }
}
else
{
    echo '[{"status":"Failed","Error":"Get Variable Not Set"}]';
}

?>
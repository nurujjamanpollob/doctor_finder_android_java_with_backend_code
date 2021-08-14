<?php
include '../controllers/apicontrollers.php';
$apicontroller = new Apicontrollers();
extract($_GET);
if(
    isset($user_id) && $user_id != "" &&
    isset($doctor_id) && $doctor_id != "" &&
    isset($date) && $date != "" &&
    isset($time) && $time != "" &&
    isset($phone) && $phone != "" &&
    isset($timestamp) && $timestamp != "" &&
    isset($desc) && $desc != ""
){
    $created_at=time();
    $bookapointment=$apicontroller->bookapointment($user_id,$doctor_id,$date,$time,$timestamp,$desc,$created_at,$phone);
    if($bookapointment)
    {
        echo '[{"status":"Success","Massage":"Appointment Book Successfully"}]';
    }
    else
    {
        echo '[{"status":"Failed","Error":"Required All field"}]';
    }
}
else
{
    echo '[{"status":"Failed","Error":"Required All field"}]';
}

?>
<?php
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$querystring=$_POST['profile_id'];
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$removeimage=$admin->profiledetail($id);
if($removeimage){
    $image=$removeimage->icon;
    $admin->unlinkimage($image,"../uploads");
}
$profile = $admin->deleteprofile($id);
$remove=$admin->deletereviewandapoinment($id);
if($profile)
{
    echo "True";
}
else
{
    echo "False";
}
?>
<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$removmuimage=$admin->getmuimage($id);
if($removmuimage)
{
    foreach($removmuimage as $res)
    {
        $icon=$res['image'];
        $admin->unlinkimage($icon,"../uploads");
    }
}
$mobileuser = $admin->deletemobileuser($id);
$review=$admin->removereviewandapoinment($id);
if($mobileuser)
{
    echo "True";
}
else
{
  
}
?>
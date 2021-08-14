<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$delappointment=$admin->deleteappointment($id);
if($delappointment){
    echo "true";
}
else{
    echo "false";
}
?>
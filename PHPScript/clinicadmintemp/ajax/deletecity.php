<?php
// Please remove this line when you have any kind of problem and want to see error //
error_reporting(E_ERROR | E_PARSE);

$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$removecity=$admin->deletecity($id);
$getAllProfile=$admin->getallprofilebycity($id);
foreach ($getAllProfile as $row)
{
    $icon=$row['icon'];
    $pid=$row['id'];
    $admin->unlinkimage($icon,"../uploads");
    $deleteprofile=$admin->deleteprofilebycity($id);
    $deletereviewbydoctor=$admin->deletereviewbydoctor($pid);
    $deleteapointment=$admin->deleteapointmenttbydoctor($pid);
}
if($removecity)
{
    echo "True";
}
else
{
    echo "False";
}
?>
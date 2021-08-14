<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$removspimage=$admin->getspimage($id);
if($removspimage)
{
    foreach($removspimage as $row)
    {
        $admin->unlinkimage($row['icon'],'../uploads');
        $admin->removespecialist($id);
    }
}
$removeimage=$admin->getspecialcategoryprofile($id);
if($removeimage)
{
    foreach($removeimage as $res)
    {
        $icon=$res['icon'];
        $pid=$res['id'];
        $admin->unlinkimage($icon,"../uploads");
        $deleteprofile=$admin->deleteprofilebyspid($id);
        $deletereview=$admin->deletereviewandapoinment($pid);
    }
}
if($removspimage)
{
    echo "True";
}
else
{
    echo "False";
}
?>
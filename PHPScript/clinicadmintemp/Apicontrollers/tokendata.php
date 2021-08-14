<?php
include'../application/config.php';
if (isset($_POST['device_id']) )
{
    $device_id=$_POST['device_id'];

    $sql = "insert into clinic_tokendata values(NULL,'".$device_id."')";
    $res = mysqli_query($conn,$sql);
    if($res){
            
            $json[]=array("id"=>"True");
            $jdata['Status'] =  $json;
            echo json_encode($jdata);
    }
    else{
        $ar[]=array("id"=>"False");
        $arr['Status']=$ar;
        echo json_encode($arr);
    }
}
else{
    $ar[]=array("id"=>"False");
    $arr['Status']=$ar;
    echo json_encode($arr);
    //echo '<pre>',print_r($arr,1),'</pre>';
}
?>
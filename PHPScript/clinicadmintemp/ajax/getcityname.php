<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$id=$val[1];
$city=$admin->getcitydetail($id);
?>
<div class="form-group form-animate-text">
    <input type="hidden" name="id" value="<?php echo $city->id; ?>">
    <input class="form-text" type="text" name="cityname" value="<?php echo $city->name; ?>"  required >
    <span class="bar"></span>
    <label>City Name</label>
</div>
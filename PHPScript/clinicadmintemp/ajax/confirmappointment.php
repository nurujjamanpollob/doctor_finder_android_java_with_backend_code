<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$appointment_id=$val[1];
$res=$admin->getappointment($appointment_id);
?>
<input type="hidden" name="user_id" value="<?php echo $res->user_id; ?>"/>
<input type="hidden" name="date" value="<?php echo $res->date; ?>"/>
<input type="hidden" name="time" value="<?php echo $res->time; ?>"/>
<input type="hidden" name="id" value="<?php echo $res->id; ?>"/>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><i class="icon icon-info"></i> Confirm Appointment </h4>
</div>
<div class="modal-body" id="showuserinfo">
    <h4>Your Appointment Has Been Confirm !!!</h4>
    <div class="form-group form-animate-text">
        <textarea class="form-text" name="remark" required></textarea>
        <span class="bar"></span>
        <label>Write Remark</label>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" name="confirmappointment">Confirm Appointment</button>
</div>




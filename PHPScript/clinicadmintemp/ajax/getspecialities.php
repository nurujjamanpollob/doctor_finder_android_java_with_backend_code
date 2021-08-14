<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$sp_id=$val[1];
$specialities = $admin->getspecialititesdetail($sp_id);
?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="icon icon-list"></i> Edit Specialist</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="id" value="<?php echo $specialities['id']; ?>">
        <input type="hidden" name="icon" value="<?php echo $specialities['icon']; ?>">
        <input type="hidden" name="sp_id" value="1">

       <!-- <div class="form-group form-animate-text" style="margin-top: 5px;">
            <select class="form-text" name="sp_id" required>
                <?php
/*                if($specialities['sp_id'] == 1){
                    */?>
                    <option value="1" selected>Doctors</option>
                    <option value="2">Pharmacies</option>
                    <option value="3">Hospitals</option>
                    <?php
/*                }
                elseif($specialities['sp_id'] == 2){
                    */?>
                    <option value="1">Doctors</option>
                    <option value="2" selected>Pharmacies</option>
                    <option value="3">Hospitals</option>
                    <?php
/*                }
                else{
                    */?>
                    <option value="1">Doctors</option>
                    <option value="2">Pharmacies</option>
                    <option value="3" selected>Hospitals</option>
                    <?php
/*                }
                */?>
            </select>
            <span class="bar"></span>
        </div>-->
        <div class="form-group form-animate-text"  >
            <input class="form-text" type="text" value="<?php echo $specialities['name']; ?>" name="spname"  required >
            <span class="bar"></span>
            <label>Specialities Name</label>
        </div>
        <div class="form-group form-animate-text">
            <img src="uploads/<?php echo $specialities['icon']; ?>" style="height:100px; width:150px;border-radius: 15px;" />
            <input class="form-text"  type="file" name="file">
            <span class="bar"></span>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="updatespecialities">Update Specialities</button>
    </div>

<?php
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$id=$_POST['querystring'];
if($id == 1) {
    $sepcialities = $admin->getspecialities($id);
    ?>
    <select class="form-text" name="sp_id" required>
        <option value="">Select Specialities</option>
        <?php
        foreach ($sepcialities as $value) {
            if ($res->spcat_id == $value['id']) {
                ?>
                <option
                    value="<?php echo $value['id']; ?>" selected><?php echo $value['name']; ?></option>
                <?php
            } else {
                ?>
                <option
                    value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                <?php
            }
        }
        ?>
    </select>
    <?php
}
else{
    ?>
    <input type="hidden" name="sp_id" value="0">
    <?php
}
    ?>

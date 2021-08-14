<?php
$querystring=$_POST['querystring'];
include '../controllers/ajaxcontroler.php';
$admin = new ajaxcontroler();
$enc_str=$admin->encrypt_decrypt("decrypt",$querystring);
$val=explode("=",$enc_str);
$user_id=$val[1];
$userinfo = $admin->getuserinfo($user_id);
?>

<table class="table table-striped table-bordered" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th style="text-align: center;" colspan="2">
            <?php
            if($userinfo->reg_type == "appuser")
            {
                $image = "uploads/$userinfo->image";
            }
            else{
             $image = $userinfo->image;
            }
            ?>
            <img src="<?php echo $image; ?>" style="height: 70px;width: 70px;border-radius: 40px;">
        </th>
    </tr>
    <tr>
        <th>Person Name</th>
        <td><?php echo $userinfo->username; ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?php echo $userinfo->email; ?></td>
    </tr>
    <tr>
        <th>Created_at</th>
        <td><?php echo date("d-M-Y H:i:sa",$userinfo->created_at); ?></td>
    </tr>
    <tr>
        <th>Login With</th>
        <td>
            <?php
            if($userinfo->reg_type == "appuser"){
                echo "Login With Application";
            }
            elseif($userinfo->reg_type == "Google"){
                echo "Login With Google Plus";
            }
            else{
                echo "Login With Facebook";
            }
            ?>
        </td>
    </tr>
    </thead>
</table>
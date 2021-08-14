<?php
include "../application/db_config.php";
class ajaxcontroler
{
    function encrypt_decrypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = SECRET_KEY;
        $secret_iv = SECRET_IV;
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if( $action == 'encrypt' )
        {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' )
        {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
    public function unlinkimage($icon,$path)
    {
        if(file_exists("$path/$icon"))
        {
            unlink("$path/$icon");
        }
    }
    public function get_session()
    {
        return $_SESSION['login'];
    }
    public function user_logout()
    {
        $_SESSION['login'] = FALSE;
        session_destroy();
    }
    public function getspecialititesdetail($sp_id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_specialist WHERE id=:sp_id");
        $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
            $array=array("id"=>$data->id,"sp_id"=>$data->sp_id,"name"=>$data->name,"icon"=>$data->icon);
            return $array;
        }
        else
        {
            return false;
        }
    }

    public function getspimage($id){
        $db = getDB();
        $stmt = $db->prepare("SELECT id,icon FROM clinic_specialist WHERE id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            foreach($stmt as $row){
                $array[]=$row;
            }
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function removespecialist($id){
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM clinic_specialist WHERE id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            return true;
        }
        else{
            return false;
        }

    }
    public function getspecialcategoryprofile($id){
        $db = getDB();
        $stmt = $db->prepare("SELECT id,icon FROM clinic_profile WHERE spcat_id=:sp_id");
        $stmt->bindParam("sp_id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            foreach($stmt as $row){
                $array[]=$row;
            }
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function deleteprofilebyspid($id){
        $db = getDB();
        $stmt=$db->prepare("Delete From clinic_profile where spcat_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            return true;
        }
        else{
            return false;
        }
    }
    public function deletereviewandapoinment($id){
        $db = getDB();
        $stmt=$db->prepare("Delete From clinic_reviewratting where doctor_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt1=$db->prepare("Delete From clinic_bookapointment where doctor_id=:id");
        $stmt1->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $stmt1->execute();
        $count=$stmt->rowCount();
        if($count){
            return true;
        }
        else{
            return false;
        }
    }

    public function getspecialities($sp_id){
        $db = getDB();
        $stmt = $db->prepare("Select * from clinic_specialist WHERE sp_id=:sp_id");
        $stmt->bindParam("sp_id", $sp_id, PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            foreach($stmt as $row){
                $array[]=array("id"=>$row['id'],"name"=>$row['name']);
            }
            return $array;
        }
        else{
            return false;
        }

    }
    public function profiledetail($id)
    {

        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_profile where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = $data;
        if($count)
        {
            return $array;
        }
        else{
            return false;
        }

    }
    public function deleteprofile($id)
    {
        $db=getDB();
        $stmt = $db->prepare("delete FROM clinic_profile where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function getcitydetail($id){
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_city where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = $data;
        if($count)
        {
            return $array;
        }
        else{
            return false;
        }
    }

	
	public function getmuimage($id){
        $db = getDB();
        $stmt = $db->prepare("SELECT id,image FROM clinic_users WHERE id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            foreach($stmt as $row){
                $array[]=$row;
            }
            return $array;
        }
        else
        {
            return false;
        }
    }
	public function deletemobileuser($id){
        $db = getDB();
        $stmt = $db->prepare("delete FROM clinic_users WHERE id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount(); 
		if($count){
			return true;
        }
        else{
            return false;
        }
    }
	public function deletereview($id){
        $db = getDB();
        $stmt = $db->prepare("delete FROM clinic_reviewratting WHERE id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount(); 
		if($count){
			return true;
        }
        else{
            return false;
        }
    }

    public function getuserinfo($user_id){

        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_users where id=:id");
        $stmt->bindParam("id", $user_id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = $data;
        if($count)
        {
            return $array;
        }
        else{
            return false;
        }

    }

    public function getappointment($id){
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_bookapointment where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = $data;
        if($count)
        {
            return $array;
        }
        else{
            return false;
        }

    }

    public function deletereviewdata($id){
        $db=getDB();
        $stmt = $db->prepare("delete from clinic_reviewratting where user_id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    public function deletecity($id)
    {
        $db=getDB();
        //echo "delete FROM clinic_city where id=:id"; exit;
        $stmt = $db->prepare("delete FROM clinic_city where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function getallprofilebycity($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT id FROM clinic_profile WHERE city=:city");
        $stmt->bindParam("city", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count){
            foreach($stmt as $row){
                $array[]=$row;
            }
            return $array;
        }
        else
        {
            return false;
        }

    }

    public function deleteprofilebycity($id)
    {
        $db=getDB();
        $stmt = $db->prepare("delete FROM clinic_profile where city=:city");
        $stmt->bindParam("city", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function deletereviewbydoctor($id)
    {
        $db=getDB();
        $stmt = $db->prepare("delete FROM clinic_reviewratting where doctor_id=:doctor_id");
        $stmt->bindParam("doctor_id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function deleteapointmenttbydoctor($id)
    {
        $db=getDB();
        $stmt = $db->prepare("DELETE FROM clinic_bookapointment where doctor_id=:doctor_id");
        $stmt->bindParam("doctor_id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public  function deleteappointment($id){
        $db=getDB();
        $stmt = $db->prepare("DELETE FROM clinic_bookapointment where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function gethealthplandetail($plan_id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_localhealthplane WHERE id=:id");
        $stmt->bindParam("id", $plan_id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
            $array=array("id"=>$data->id,"icon"=>$data->icon,"desc"=>$data->desc,"phone_no"=>$data->phone_no,"url"=>$data->url);
            return $array;
        }
        else
        {
            return false;
        }
    }

    public function geticon($id){
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_localhealthplane where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        if($count)
        {
            return $data->icon;
        }
        else{
            return false;
        }
    }
    public function removehealthplan($id){
        $db=getDB();
        $stmt = $db->prepare("DELETE FROM clinic_localhealthplane where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


}
?>
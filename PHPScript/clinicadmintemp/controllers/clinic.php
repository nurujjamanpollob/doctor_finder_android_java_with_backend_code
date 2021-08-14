<?php
include "application/db_config.php";
class dashboard
{
    function encrypt_decrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = SECRET_KEY;
        $secret_iv = SECRET_IV;
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' )
        {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
    public function unlinkimage($icon,$path){
        if(file_exists("$path/$icon")){
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
    public function getuserinfo($uid)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_adminlogin WHERE id=:id");
        $stmt->bindParam("id", $uid,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
            $array=array("username"=>$data->username,"image"=>$data->icon,"email"=>$data->email);
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function insertspecialities($sp_id,$spname,$icon,$time){

        $db = getDB();
        $stmt = $db->prepare("INSERT INTO clinic_specialist(sp_id,name,icon,created_at) VALUES (:sp_id,:name,:icon,:time)");
        $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
        $stmt->bindParam("name", $spname,PDO::PARAM_STR);
        $stmt->bindParam("icon", $icon,PDO::PARAM_STR);
        $stmt->bindParam("time", $time,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{

        }
    }
    public  function selectspecilitites($search,$check,$start,$per_page,$sp_id){
        $db = getDB();
        if($sp_id != "none")
        {
            if ($check == "total")
            {
                $stmt = $db->prepare("SELECT * FROM clinic_specialist where sp_id=:sp_id ORDER BY id DESC ");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count)
                {
                    return $count;
                }
                else
                {
                    return false;
                }
            } elseif ($check == "search") {
                $stmt = $db->prepare("SELECT * FROM clinic_specialist where sp_id=:sp_id AND name LIKE '%" . $search . "%' ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if($count){
                    return $array;
                }
                else{
                    return false;
                }

            } elseif ($check == "searchtotal")
            {
                $stmt = $db->prepare("SELECT * FROM clinic_specialist where sp_id=:sp_id AND name LIKE '%" . $search . "%' ORDER BY id DESC");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total) {
                    return $total;
                }
                else {
                    return false;
                }
            }
            else
            {
                $stmt = $db->prepare("SELECT * FROM clinic_specialist where sp_id=:sp_id ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if($count)
                {
                    return $array;
                }
                else{
                    return false;
                }
            }
        }
        else {
            if ($check == "total") {
                $stmt = $db->prepare("SELECT * FROM clinic_specialist ORDER BY id DESC");
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count) {
                    return $count;
                } else {
                    return false;
                }
            } elseif ($check == "search") {
                $stmt = $db->prepare("SELECT * FROM clinic_specialist where name LIKE '%" . $search . "%' ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count=$stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if ($count) {
                    return $array;
                } else {
                    return false;
                }
            } elseif ($check == "searchtotal") {
                $stmt = $db->prepare("SELECT * FROM clinic_specialist where name LIKE '%" . $search . "%' ORDER BY id DESC");
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else{
                    return false;
                }
            } else {
                $stmt = $db->prepare("SELECT * FROM clinic_specialist ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }

                if($count)
                {
                    return $array;
                }
                else{
                    return false;
                }
            }
        }
    }
    public function updatespecilities($id,$sp_id,$spname,$icon){
        $db = getDB();
        if($icon == "No"){
            $stmt = $db->prepare("update clinic_specialist Set sp_id=:sp_id,name=:spname WHERE id=:id");
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
            $stmt->bindParam("spname", $spname,PDO::PARAM_STR);
            $stmt->execute();
            $count=$stmt->rowCount();
            if($count){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $stmt = $db->prepare("update clinic_specialist Set sp_id=:sp_id,name=:spname,icon=:icon WHERE id=:id");
            $stmt->bindParam("id", $id,PDO::PARAM_STR);
            $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
            $stmt->bindParam("spname", $spname,PDO::PARAM_STR);
            $stmt->bindParam("icon", $icon,PDO::PARAM_STR);
            $stmt->execute();
            $count=$stmt->rowCount();
            if($count){
                return true;
            }
            else{
                return false;
            }
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
    public function getcity(){
        $db = getDB();
        $stmt = $db->prepare("Select * from clinic_city ORDER BY id asc");
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            foreach($stmt as $row)
            {
                $array[]=$row;
            }
            return $array;
        }
        else
        {
            return false;
        }
    }
    public function insertprofile($mcatid,$sp_id,$name,$phone,$validate_email,$hours,$address,$about,$services,$lat,$lon,$fb,$gplus,$twiter,$icon,$city,$helthcare){
        $db = getDB();
		if($helthcare == "no" )
		{
        	$stmt = $db->prepare("INSERT INTO clinic_profile (`mcat_id`, `spcat_id`, `icon`, `name`, `phone`, `email`,`hours`, `lat`, `lon`, `about`, `services`, `city`, `goole_plus`, `facebook`, `twiter`,`address`)
         VALUES
        (:mcat_id,:spcat_id,:icon,:name,:phone,:email,:hours,:lat,:lon,:about,:services,:city,:gool_plus,:facebook,:twiter,:address)");
		}
		else
		{
			$stmt = $db->prepare("INSERT INTO clinic_profile (`mcat_id`, `spcat_id`, `icon`, `name`, `phone`, `email`,`hours`, `lat`, `lon`, `about`, `services`, `city`, `goole_plus`, `facebook`, `twiter`,`address`,`helthcare`)
         VALUES
        (:mcat_id,:spcat_id,:icon,:name,:phone,:email,:hours,:lat,:lon,:about,:services,:city,:gool_plus,:facebook,:twiter,:address,:helthcare)");
		$stmt->bindParam("helthcare", $helthcare,PDO::PARAM_STR);
		}
        $stmt->bindParam("mcat_id", $mcatid,PDO::PARAM_STR);
        $stmt->bindParam("spcat_id", $sp_id,PDO::PARAM_STR);
        $stmt->bindParam("name", $name,PDO::PARAM_STR);
        $stmt->bindParam("phone", $phone,PDO::PARAM_STR);
        $stmt->bindParam("email", $validate_email,PDO::PARAM_STR);
        $stmt->bindParam("hours", $hours,PDO::PARAM_STR);
        $stmt->bindParam("address", $address,PDO::PARAM_STR);
        $stmt->bindParam("lat", $lat,PDO::PARAM_STR);
        $stmt->bindParam("lon", $lon,PDO::PARAM_STR);
        $stmt->bindParam("about", $about,PDO::PARAM_STR);
        $stmt->bindParam("services", $services,PDO::PARAM_STR);
        $stmt->bindParam("city", $city,PDO::PARAM_STR);
        $stmt->bindParam("gool_plus", $gplus,PDO::PARAM_STR);
        $stmt->bindParam("facebook", $fb,PDO::PARAM_STR);
        $stmt->bindParam("twiter", $twiter,PDO::PARAM_STR);
        $stmt->bindParam("icon", $icon,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    public  function selectallprofile($search,$check,$start,$per_page,$sp_id){
        $db = getDB();
        if($sp_id != "none")
        {
            if ($check == "total")
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id=:sp_id ORDER BY id DESC ");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count)
                {
                    return $count;
                }
                else
                {
                    return false;
                }
            } elseif ($check == "search") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id=:sp_id AND (name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ) ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if($count){
                    return $array;
                }
                else{
                    return false;
                }

            }
            elseif ($check == "searchtotal")
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id=:sp_id AND (name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ) ORDER BY id DESC");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id=:sp_id ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if($count)
                {
                    return $array;
                }
                else{
                    return false;
                }
            }
        }
        else {
            if ($check == "total") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile ORDER BY id DESC");
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count) {
                    return $count;
                } else {
                    return false;
                }
            } elseif ($check == "search") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count=$stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if ($count) {
                    return $array;
                } else {
                    return false;
                }
            }
            elseif ($check == "searchtotal") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ORDER BY id DESC");
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows)
                {
                    $array[] = $rows;
                }
                if($count)
                {
                    return $array;
                }
                else
                {
                    return false;
                }
            }
        }
    }

    public  function selectalldoctorprofile($search,$check,$start,$per_page,$sp_id){
        $db = getDB();
        if($sp_id != "none")
        {
            if ($check == "total")
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='1' ORDER BY id DESC ");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count)
                {
                    return $count;
                }
                else
                {
                    return false;
                }
            } elseif ($check == "search") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='1' AND (name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ) ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if($count){
                    return $array;
                }
                else{
                    return false;
                }

            }
            elseif ($check == "searchtotal")
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='1' AND (name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ) ORDER BY id DESC");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='1' ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if($count)
                {
                    return $array;
                }
                else{
                    return false;
                }
            }
        }
        else {
            if ($check == "total") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='1' ORDER BY id DESC");
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count) {
                    return $count;
                } else {
                    return false;
                }
            } elseif ($check == "search") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='1'and name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count=$stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if ($count) {
                    return $array;
                } else {
                    return false;
                }
            }
            elseif ($check == "searchtotal") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='1'and name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ORDER BY id DESC");
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='1' ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows)
                {
                    $array[] = $rows;
                }
                if($count)
                {
                    return $array;
                }
                else
                {
                    return false;
                }
            }
        }
    }
    
    public  function selectallpharmacyprofile($search,$check,$start,$per_page,$sp_id){
        $db = getDB();
        if($sp_id != "none")
        {
            if ($check == "total")
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='2' ORDER BY id DESC ");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count)
                {
                    return $count;
                }
                else
                {
                    return false;
                }
            } elseif ($check == "search") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='2' AND (name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ) ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if($count){
                    return $array;
                }
                else{
                    return false;
                }

            }
            elseif ($check == "searchtotal")
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='2' AND (name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ) ORDER BY id DESC");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='2' ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if($count)
                {
                    return $array;
                }
                else{
                    return false;
                }
            }
        }
        else {
            if ($check == "total") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='2' ORDER BY id DESC");
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count) {
                    return $count;
                } else {
                    return false;
                }
            } elseif ($check == "search") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='2'and name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count=$stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if ($count) {
                    return $array;
                } else {
                    return false;
                }
            }
            elseif ($check == "searchtotal") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='2'and name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ORDER BY id DESC");
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='2' ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows)
                {
                    $array[] = $rows;
                }
                if($count)
                {
                    return $array;
                }
                else
                {
                    return false;
                }
            }
        }
    }

    public  function selectallhospitalprofile($search,$check,$start,$per_page,$sp_id){
        $db = getDB();
        if($sp_id != "none")
        {
            if ($check == "total")
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='3' ORDER BY id DESC ");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count)
                {
                    return $count;
                }
                else
                {
                    return false;
                }
            } elseif ($check == "search") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='3' AND (name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ) ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if($count){
                    return $array;
                }
                else{
                    return false;
                }

            }
            elseif ($check == "searchtotal")
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='3' AND (name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ) ORDER BY id DESC");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='3' ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if($count)
                {
                    return $array;
                }
                else{
                    return false;
                }
            }
        }
        else {
            if ($check == "total") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='3' ORDER BY id DESC");
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count) {
                    return $count;
                } else {
                    return false;
                }
            } elseif ($check == "search") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='3'and name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count=$stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if ($count) {
                    return $array;
                } else {
                    return false;
                }
            }
            elseif ($check == "searchtotal") {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='3'and name LIKE '%" . $search . "%' OR phone LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' ORDER BY id DESC");
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                $stmt = $db->prepare("SELECT * FROM clinic_profile where mcat_id='3' ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows)
                {
                    $array[] = $rows;
                }
                if($count)
                {
                    return $array;
                }
                else
                {
                    return false;
                }
            }
        }
    }

    public function getcategorynamewithid($id){
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_specialist where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = array("name"=>$data->name);
        if($count)
        {
            return $array;
        }
        else{
            return false;
        }
    }

    public function editprofile($update_id,$mcatid,$sp_id,$name,$phone,$validate_email,$hours,$address,$about,$services,$lat,$lon,$fb,$gplus,$twiter,$city,$icon,$helthcare){
        $db = getDB();
        if($icon == "no")
		{
			if($helthcare == "non")
			{
				$stmt = $db->prepare("Update clinic_profile Set
        mcat_id=:mcat_id,spcat_id=:spcat_id,name=:name,phone=:phone,
        email=:email,hours=:hours,lat=:lat,lon=:lon,about=:about,services=:services,
        city=:city,goole_plus=:gool_plus,facebook=:facebook,twiter=:twiter,address=:address where id=:update_id");
			}
			else
			{
				$stmt = $db->prepare("Update clinic_profile Set
        mcat_id=:mcat_id,spcat_id=:spcat_id,name=:name,phone=:phone,
        email=:email,hours=:hours,lat=:lat,lon=:lon,about=:about,services=:services,
        city=:city,goole_plus=:gool_plus,facebook=:facebook,twiter=:twiter,address=:address,helthcare=:helthcare where id=:update_id");
				$stmt->bindParam("helthcare", $helthcare,PDO::PARAM_STR);
			}  
        }
        else 
		{
			if($helthcare == "none")
			{
				$stmt = $db->prepare("Update clinic_profile Set
        mcat_id=:mcat_id,spcat_id=:spcat_id,icon=:icon,name=:name,phone=:phone,
        email=:email,hours=:hours,lat=:lat,lon=:lon,about=:about,services=:services,
        city=:city,goole_plus=:gool_plus,facebook=:facebook,twiter=:twiter,address=:address where id=:update_id");
			
			}
			else
			{
				$stmt = $db->prepare("Update clinic_profile Set
        mcat_id=:mcat_id,spcat_id=:spcat_id,icon=:icon,name=:name,phone=:phone,
        email=:email,hours=:hours,lat=:lat,lon=:lon,about=:about,services=:services,
        city=:city,goole_plus=:gool_plus,facebook=:facebook,twiter=:twiter,address=:address,helthcare=:helthcare where id=:update_id");
			$stmt->bindParam("helthcare", $helthcare,PDO::PARAM_STR);
			
			}
            $stmt->bindParam("icon", $icon,PDO::PARAM_STR);
        }
        $stmt->bindParam("mcat_id", $mcatid,PDO::PARAM_STR);
        $stmt->bindParam("spcat_id", $sp_id,PDO::PARAM_STR);
        $stmt->bindParam("name", $name,PDO::PARAM_STR);
        $stmt->bindParam("phone", $phone,PDO::PARAM_STR);
        $stmt->bindParam("email", $validate_email,PDO::PARAM_STR);
        $stmt->bindParam("hours", $hours,PDO::PARAM_STR);
        $stmt->bindParam("address", $address,PDO::PARAM_STR);
        $stmt->bindParam("lat", $lat,PDO::PARAM_STR);
        $stmt->bindParam("lon", $lon,PDO::PARAM_STR);
        $stmt->bindParam("about", $about,PDO::PARAM_STR);
        $stmt->bindParam("services", $services,PDO::PARAM_STR);
        $stmt->bindParam("city", $city,PDO::PARAM_STR);
        $stmt->bindParam("gool_plus", $gplus,PDO::PARAM_STR);
        $stmt->bindParam("facebook", $fb,PDO::PARAM_STR);
        $stmt->bindParam("twiter", $twiter,PDO::PARAM_STR);
        $stmt->bindParam("update_id", $update_id,PDO::PARAM_STR);

        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
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
        else
        {
            return false;
        }
    }
    public function selectcty($search,$check,$start,$per_page)
    {
        $db=getDB();
        if ($check == "total")
        {
            $stmt = $db->prepare("SELECT * FROM clinic_city  ORDER BY id asc ");
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count)
            {
                return $count;
            }
            else
            {
                return false;
            }
        }
        elseif ($check == "search")
        {
            $stmt = $db->prepare("SELECT * FROM clinic_city where name LIKE '%" . $search . "%' ORDER BY id asc LIMIT $start,$per_page");
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows)
            {
                $array[] = $rows;
            }
            if($count){
                return $array;
            }
            else{
                return false;
            }

        }
        elseif ($check == "searchtotal")
        {
            $stmt = $db->prepare("SELECT * FROM clinic_city where name LIKE '%" . $search . "%' ORDER BY id asc");
            $stmt->execute();
            $total = $stmt->rowCount();
            if($total)
            {
                return $total;
            }
            else
            {
                return false;
            }
        }
        else
        {
            $stmt = $db->prepare("SELECT * FROM clinic_city  ORDER BY id asc LIMIT $start,$per_page");
            $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count)
            {
                return $array;
            }
            else{
                return false;
            }
        }
    }
    public function checkcity($cityname){
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_city where name=:name");
        $stmt->bindParam("name", $cityname,PDO::PARAM_STR);
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
    public function insertcity($cityname)
    {
        $db=getDB();
        $time=time();
        $stmt = $db->prepare("insert into clinic_city (name,created_at) values (:cityname,:created_at)");
        $stmt->bindParam("cityname", $cityname,PDO::PARAM_STR);
        $stmt->bindParam("created_at", $time,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function updatecity($id,$cityname)
    {
        $db=getDB();
        $stmt = $db->prepare("update clinic_city set name=:cityname where id=:id ");
        $stmt->bindParam("cityname", $cityname,PDO::PARAM_STR);
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

	public  function selectmobileuser($search,$check,$start,$per_page,$sp_id){
        $db = getDB();
        if($sp_id == "none")
        {
            if ($check == "total") {
                $stmt = $db->prepare("SELECT * FROM clinic_users ORDER BY id DESC");
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count) {
                    return $count;
                } else {
                    return false;
                }
            } elseif ($check == "search") {
                $stmt = $db->prepare("SELECT * FROM clinic_users where username LIKE '%" . $search . "%' ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count=$stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if ($count) {
                    return $array;
                } else {
                    return false;
                }
            } elseif ($check == "searchtotal") {
                $stmt = $db->prepare("SELECT * FROM clinic_users where username LIKE '%" . $search . "%' ORDER BY id DESC");
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else{
                    return false;
                }
            } else {
                $stmt = $db->prepare("SELECT * FROM clinic_users ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }

                if($count)
                {
                    return $array;
                }
                else{
                    return false;
                }
            }
        }
    }
		
	public  function selectreview($search,$check,$start,$per_page,$sp_id){
        $db = getDB();
        if($sp_id == "none")
        {
            if ($check == "total") {
                $stmt = $db->prepare("SELECT * FROM clinic_reviewratting ORDER BY id DESC");
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count) {
                    return $count;
                } else {
                    return false;
                }
            } elseif ($check == "search") {
                $stmt = $db->prepare("SELECT * FROM clinic_reviewratting where review_text LIKE '%" . $search . "%' ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count=$stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }
                if ($count) {
                    return $array;
                } else {
                    return false;
                }
            } elseif ($check == "searchtotal") {
                $stmt = $db->prepare("SELECT * FROM clinic_reviewratting where review_text LIKE '%" . $search . "%' ORDER BY id DESC");
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else{
                    return false;
                }
            } else {
                $stmt = $db->prepare("SELECT * FROM clinic_reviewratting ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }

                if($count)
                {
                    return $array;
                }
                else{
                    return false;
                }
            }
        }
    }
	public function getdoctornamewithid($id){
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_profile where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = array("name"=>$data->name);
        if($count)
        {
            return $array;
        }
        else{
            return false;
        }
    }
	public function getusernamewithid($id){
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_users where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = array("name"=>$data->username);
        if($count)
        {
            return $array;
        }
        else{
            return false;
        }
    }

	public function getadmininfo($uid)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_adminlogin WHERE id=:id");
        $stmt->bindParam("id", $uid,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
            $array=array("id"=>$data->id,"username"=>$data->username,"password"=>$data->password);
            return $array;
        }
        else
        {
            return false;
        }
    }

	 public function updatepassword($id,$newpwd){
        $db=getDB();
        $stmt = $db->prepare("update clinic_adminlogin set password=:newpwd where id=:id ");
        $stmt->bindParam("newpwd", $newpwd,PDO::PARAM_STR);
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
	
	public function getadmininfowithid($uid)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_adminlogin WHERE id=:id");
        $stmt->bindParam("id", $uid,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
            $array=array("id"=>$data->id,"username"=>$data->username,"fullname"=>$data->fullname,"email"=>$data->email,"phone"=>$data->phone,"icon"=>$data->icon);
            return $array;
        }
        else
        {
            return false;
        }
    }
	
	public function editadminprofile($update_id,$username,$fullname,$email,$phone,$icon){
        $db = getDB();
		
		if($icon == "no"){
            $stmt = $db->prepare("Update clinic_adminlogin Set
        username=:username,fullname=:fullname,email=:email,phone=:phone where id=:update_id");
        }
        else {
            $stmt = $db->prepare("Update clinic_adminlogin Set
        username=:username,fullname=:fullname,email=:email,phone=:phone,icon=:icon where id=:update_id");
            $stmt->bindParam("icon", $icon,PDO::PARAM_STR);
        }
		
        $stmt->bindParam("username", $username,PDO::PARAM_STR);
        $stmt->bindParam("fullname", $fullname,PDO::PARAM_STR);
        $stmt->bindParam("email", $email,PDO::PARAM_STR);
        $stmt->bindParam("phone", $phone,PDO::PARAM_STR);
        $stmt->bindParam("update_id", $update_id,PDO::PARAM_STR);

        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
	
	public function getnotificationinfo()
    {
		$db = getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_notification");
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
            $array=array("id"=>$data->id,"apikey"=>$data->apikey,"passphrace"=>$data->passphrace,"certificate"=>$data->certificate,"environment"=>$data->environment);
            return $array;
        }
        else
        {
            return false;
        }
	}
	public function getnotificationinfoid($uid)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_notification WHERE id=:id");
        $stmt->bindParam("id", $uid,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
            $array=array("id"=>$data->id,"apikey"=>$data->apikey,"passphrace"=>$data->passphrace,"certificate"=>$data->certificate,"environment"=>$data->environment);
            return $array;
        }
        else
        {
            return false;
        }
    }
	
	public function addnotification($apikey,$passphrace,$certificate,$environment){
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO clinic_notification (`apikey`, `passphrace`, `certificate`, `environment`)
         VALUES(:apikey,:passphrace,:certificate,:environment)");
       	$stmt->bindParam("certificate", $certificate,PDO::PARAM_STR);
	   	$stmt->bindParam("apikey", $apikey,PDO::PARAM_STR);
        $stmt->bindParam("passphrace", $passphrace,PDO::PARAM_STR);
        $stmt->bindParam("environment", $environment,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
	
	public function editnotification($update_id,$apikey,$passphrace,$certificate,$environment){
        $db = getDB();
		
		if($certificate == "no"){
            $stmt = $db->prepare("Update clinic_notification Set
        apikey=:apikey,passphrace=:passphrace,environment=:environment where id=:update_id");
        }
        else {
            $stmt = $db->prepare("Update clinic_notification Set
        apikey=:apikey,passphrace=:passphrace,certificate=:certificate,environment=:environment where id=:update_id");
            $stmt->bindParam("certificate", $certificate,PDO::PARAM_STR);
        }

        $stmt->bindParam("apikey", $apikey,PDO::PARAM_STR);
        $stmt->bindParam("passphrace", $passphrace,PDO::PARAM_STR);
        $stmt->bindParam("environment", $environment,PDO::PARAM_STR);
        $stmt->bindParam("update_id", $update_id,PDO::PARAM_STR);

        $stmt->execute();
        $count=$stmt->rowCount();
        if($count)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public  function getappointment($search,$check,$start,$per_page){
        $db = getDB();

            if ($check == "total") {
                $stmt = $db->prepare("SELECT * FROM clinic_bookapointment ORDER BY id DESC");
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count) {
                    return $count;
                } else {
                    return false;
                }
            }
            elseif ($check == "search")
            {
                $stmt = $db->prepare("SELECT * FROM clinic_bookapointment Where `phone` LIKE '%".$search."%' OR `desc` LIKE '%".$search."%' ORDER BY id DESC LIMIT $start,$per_page  ");
                $stmt->execute();
                $count=$stmt->rowCount();
                foreach ($stmt as $rows)
                {
                    $array[] = $rows;
                }
                if ($count)
                {
                    return $array;
                } else {
                    return false;
                }
            } elseif ($check == "searchtotal") {
                $stmt = $db->prepare("SELECT * FROM clinic_bookapointment Where `phone` LIKE '%".$search."%' OR `desc` LIKE '%".$search."%' ORDER BY id DESC ");
                $stmt->execute();
                $total = $stmt->rowCount();
                if($total)
                {
                    return $total;
                }
                else{
                    return false;
                }
            } else {
                $stmt = $db->prepare("SELECT * FROM clinic_bookapointment ORDER BY id DESC LIMIT $start,$per_page");
                $stmt->execute();
                $count = $stmt->rowCount();
                foreach ($stmt as $rows) {
                    $array[] = $rows;
                }

                if($count)
                {
                    return $array;
                }
                else{
                    return false;
                }
            }
        }

    public function getdoctorname($doctor_id){
        $db = getDB();
        $stmt = $db->prepare("SELECT name,id FROM clinic_profile WHERE id=:id");
        $stmt->bindParam("id", $doctor_id,PDO::PARAM_STR);
        $stmt->execute();
        $count=$stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if($count)
        {
            return $data;
        }
        else
        {
            return false;
        }
    }

    public function getcount(){
        $db = getDB();
        $profile = $db->prepare("SELECT id FROM clinic_profile where mcat_id='1'");
        $profile->execute();
        $totalprofile=$profile->rowCount();

        $appuser = $db->prepare("SELECT id FROM clinic_users");
        $appuser->execute();
        $totalappusers=$appuser->rowCount();

        $review = $db->prepare("SELECT id FROM clinic_reviewratting");
        $review->execute();
        $totalreview=$review->rowCount();

        $pharmacy = $db->prepare("SELECT id FROM clinic_profile where mcat_id='2'");
        $pharmacy->execute();
        $totalpharmacy=$pharmacy->rowCount();

        $city = $db->prepare("SELECT id FROM clinic_city");
        $city->execute();
        $totalcity=$city->rowCount();

        $hospital = $db->prepare("SELECT id FROM clinic_profile where mcat_id='3'");
        $hospital->execute();
        $totalhospital=$hospital->rowCount();

        $specialist = $db->prepare("SELECT id FROM clinic_specialist");
        $specialist->execute();
        $totalspecialist=$specialist->rowCount();

        $arr=array("tprofile"=>$totalprofile,"tappusers"=>$totalappusers,"treview"=>$totalreview,"tpharmacy"=>$totalpharmacy,"tcity"=>$totalcity,"thospital"=>$totalhospital,"tspecialist"=>$totalspecialist);

        return $arr;
    }

    public function getregid($id){

        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_users where id=:id");
        $stmt->bindParam("id", $id,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = $data;
        if($count)
        {
            return $array;
        }
        else
        {
            return false;
        }

    }
    public function getnotificationsetting(){
        $db=getDB();
        $stmt = $db->prepare("SELECT * FROM clinic_notification");
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        $array = $data;
        if($count)
        {
            return $array;
        }
        else
        {
            return false;
        }
    }

    public function android_push($msg,$reg_id,$apikey)
    {
        $data=$msg;
        /*AIzaSyAu19qPvaNCDuhFFCN8qqMU_i7rt8vwO5g*/
        define( 'API_ACCESS_KEY', $apikey );
        $registrationIds = array( $reg_id );
        $message = array("price" => $data);
        $fields = array
        (
            'registration_ids' 	=> $registrationIds,
            'data'			=> $message
        );
        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch);
        curl_close( $ch );
        $result = json_decode($result);
        return $result;

    }
    public function updateappointment($id){

        $db=getDB();
        $stmt = $db->prepare("UPDATE clinic_bookapointment set is_send=1 where id=:id");
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
    public function updateappointmentreject($id)
    {
        $db=getDB();
        $stmt = $db->prepare("UPDATE clinic_bookapointment set is_reject=1 where id=:id");
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

    public function selectnoti($search,$check,$start,$per_page)
    {
        $db=getDB();
        if ($check == "total")
        {
            $stmt = $db->prepare("SELECT * FROM clinic_sendnotification  ORDER BY id DESC ");
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count)
            {
                return $count;
            }
            else
            {
                return false;
            }
        }
        else
        {
            $stmt = $db->prepare("SELECT * FROM clinic_sendnotification  ORDER BY id DESC LIMIT $start,$per_page");
            $stmt->bindParam("sp_id", $sp_id,PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            foreach ($stmt as $rows) {
                $array[] = $rows;
            }
            if($count)
            {
                return $array;
            }
            else{
                return false;
            }
        }
    }
    public function insertnotification($message)
    {
        $db=getDB();
        $stmt = $db->prepare("insert into clinic_sendnotification (message) values (:message)");
        $stmt->bindParam("message", $message,PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function iphone_push($msg,$reg_id,$pass,$certificate,$env_mt){

        $tHost = $env_mt;
        $tPort = 2195;
        $tCert = 'uploads/'.$certificate;
        $tPassphrase = $pass;
        $tToken = $reg_id;
        $tAlert = $msg;
        $tBadge = 8;
        $tSound = 'default';
        $tPayload = $msg;
        $tBody['aps'] = array
        (
            'alert' => $tAlert,
            'badge' => $tBadge,
            'sound' => $tSound,
        );
        $tBody ['payload'] = $tPayload;
        $tBody = json_encode ($tBody);
        $tContext = stream_context_create ();
        stream_context_set_option ($tContext, 'ssl', 'local_cert', $tCert);
        stream_context_set_option ($tContext, 'ssl', 'passphrase', $tPassphrase);
        $tSocket = stream_socket_client ('ssl://'.$tHost.':'.$tPort, $error, $errstr, 100, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $tContext);
        if (!$tSocket)
            exit ("APNS Connection Failed: $error $errstr" . PHP_EOL);
        $tMsg = chr (0) . chr (0) . chr (32) . pack ('H*', $tToken) . pack ('n', strlen ($tBody)) . $tBody;
        $tResult = fwrite ($tSocket, $tMsg, strlen ($tMsg));
        if ($tResult)
        {
            /*error_reporting(E_ALL);
            ini_set('display_errors', 1);
            print_r("[APNS] push successful! ::: $tBody ($tResult bytes)"); */
            return true;
            fclose ($tSocket);
        }
        else
        {
            /*echo 'Could not Deliver Message to APNS' . PHP_EOL;*/
            return false;
            fclose ($tSocket);
        }

    }
    function compress($source, $destination, $quality)
    {
        $info = getimagesize($source);
        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);
        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);
        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);
        imagejpeg($image, $destination, $quality);
        return $destination;
    }



}
?>
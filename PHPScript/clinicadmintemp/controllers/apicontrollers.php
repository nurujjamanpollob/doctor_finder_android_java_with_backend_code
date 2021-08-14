<?php
include "../application/db_config.php";
class Apicontrollers
{
    function encrypt_decrypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = SECRET_KEY;
        $secret_iv = SECRET_IV;
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if($action == 'encrypt')
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
    public function userregister($username,$email,$password,$image,$retype,$res_id,$platform)
    {
        $db=getDB();
        $time = time();
        $stmt = $db->prepare("insert into clinic_users (username,email,password,image,created_at,reg_type,reg_id,platform) values (:username,:email,:password,:image,:created_at,:reg_type,:reg_id,:platform)");
        $stmt->bindParam("username", $username, PDO::PARAM_STR);
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
        $stmt->bindParam("password", $password, PDO::PARAM_STR);
        $stmt->bindParam("image", $image, PDO::PARAM_STR);
        $stmt->bindParam("created_at", $time, PDO::PARAM_STR);
        $stmt->bindParam("reg_type", $retype, PDO::PARAM_STR);
        $stmt->bindParam("reg_id", $res_id, PDO::PARAM_STR);
        $stmt->bindParam("platform", $platform, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count)
        {
            $stmt1 = $db->prepare("Select * from clinic_users where email=:email");
            $stmt1->bindParam("email", $email, PDO::PARAM_STR);
            $stmt1->execute();
            $data = $stmt1->fetch(PDO::FETCH_OBJ);
            if($data->reg_type == "appuser"){
                $images=IMAGEPATH.$data->image;
            }
            else{
                $images=$data->image;
            }
            $arr=array("id"=>$data->id,"username"=>$data->username,"email"=>$data->email,"image"=>$images,"created_at"=>$data->created_at);
            return $arr;
        }
        else
        {
            return false;
        }
    }
    public function checkuseremail($email)
    {
        $db=getDB();
        $stmt = $db->prepare("Select id from clinic_users where email=:email");
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
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
    public function mobileuserlogin($uname,$pass,$email)
    {
        if($uname == "non" && $pass == "non")
        {
            $db = getDB();
            $stmt = $db->prepare("Select * from clinic_users where email=:email");
            $stmt->bindParam("email", $email, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            if($data->reg_type == "appuser"){
                $images=IMAGEPATH.$data->image;
            }
            else{
                $images=$data->image;
            }
            $arr=array("id"=>$data->id,"username"=>$data->username,"email"=>$data->email,"image"=>$images,"created_at"=>$data->created_at);
            if ($count)
            {
                return $arr;
            }
            else
            {
                return false;
            }
        }
        else
        {
            // Report all errors except E_NOTICE
            error_reporting(E_ALL & ~E_NOTICE);
            $db = getDB();
            //old query
            //echo "Select * from clinic_users where email=:username OR username=:username AND password=:password"; exit;
            $stmt = $db->prepare("Select * from clinic_users where (email=:username OR username=:username) AND password=:password LIMIT 1");
            $stmt->bindParam("username", $uname, PDO::PARAM_STR);
            $stmt->bindParam("password", $pass, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            if($data->reg_type == "appuser"){
                $images=IMAGEPATH.$data->image;
            }
            else
            {
                $images=$data->image;
            }
            $arr=array("id"=>$data->id,"username"=>$data->username,"email"=>$data->email,"image"=>$images,"created_at"=>$data->created_at);
            if ($count)
            {
                return $arr;
            }
            else
            {
                return false;
            }
        }
    }
    public function getallcity()
    {
        $db = getDB();
        $stmt = $db->prepare("Select * from clinic_city ORDER BY id ASC");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count) {

            while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
                $arr[]=$data;
            }
            return $arr;
        } else {
            return false;
        }
    }
    public function getspecialities($id)
    {
        $db = getDB();
        $stmt = $db->prepare("Select * from clinic_specialist Where sp_id=:id ORDER BY id DESC");
        $stmt->bindParam("id", $id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count)
        {
            while($data = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $arr[]=$data;
            }
            return $arr;
        }
        else
        {
            return false;
        }
    }
    public function getratting($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT id, AVG(ratting) AS ratavg FROM clinic_reviewratting WHERE doctor_id=:id");
        $stmt->bindParam("id", $id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count)
        {
            while($data = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $avg = $data['ratavg'];
                $vg1 = (string)round($avg, 1);
            }
            return $vg1;
        }
        else
        {
            return false;
        }
    }
    public function getprofilealphabetorder($specialities_id,$lat,$lon,$orderby,$radius){
        $db = getDB();
        if($orderby == ""){
            $stmt = $db->prepare("
                SELECT *,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance
                from clinic_profile where spcat_id = $specialities_id  ORDER BY distance ASC ");
        }
        elseif($orderby == "a-z")
        {
                $stmt = $db->prepare("
                SELECT *,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance
                from clinic_profile where spcat_id = $specialities_id ORDER BY name ASC ");
        }
        elseif($orderby == "z-a"){
                 $stmt = $db->prepare("
                SELECT *,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance
                from clinic_profile where spcat_id = $specialities_id ORDER BY name DESC ");
        }
        else{
                $stmt = $db->prepare("
                SELECT *,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance
                from clinic_profile where spcat_id=$specialities_id && city=:city_id ORDER BY distance DESC ");
                 $stmt->bindParam("city_id", $orderby, PDO::PARAM_STR);
        }
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count)
        {
            while($data = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $ratting =$this->getratting($data['id']);
                $radiusdata = $data['distance'] * 1.609344;
                $km = round($radiusdata,2);
                if($radius != "none")
                {
                    if($km <= $radius)
                    {
                        $arr[] = array
                        (
                            "id" => $data['id'],
                            "distance" => $data['distance'],
                            "distancekm" => $km,
                            "icon" => $data['icon'],
                            "name" => $data['name'],
                            "services" => $data['services'],
                            "ratting" => $ratting
                        );
                    }
                }
                else
                    {
                    $arr[] = array(
                        "id" => $data['id'],
                        "distance" => $data['distance'],
                        "distancekm" => $km,
                        "icon" => $data['icon'],
                        "name" => $data['name'],
                        "services" => $data['services'],
                        "ratting" => $ratting
                    );
                }
            }
            if(isset($arr)){
                return $arr;
            }
            else{
                return false;
            }

        }
        else
        {
            return false;
        }
    }

    public function bookapointment($user_id,$doctor_id,$date,$time,$timestamp,$desc,$created_at,$phone){

        $db=getDB();
        $stmt = $db->prepare("INSERT INTO clinic_bookapointment ( `user_id`, `doctor_id`, `date`, `time`,`timestamp`, `desc`, `created_at`,`phone`) VALUES (:user_id,:doctor_id,:date,:time,:timestamp,:desc,:created_at,:phone)");
        $stmt->bindParam("user_id", $user_id, PDO::PARAM_STR);
        $stmt->bindParam("doctor_id", $doctor_id, PDO::PARAM_STR);
        $stmt->bindParam("date", $date, PDO::PARAM_STR);
        $stmt->bindParam("time", $time, PDO::PARAM_STR);
        $stmt->bindParam("timestamp", $timestamp, PDO::PARAM_STR);
        $stmt->bindParam("desc", $desc, PDO::PARAM_STR);
        $stmt->bindParam("created_at", $created_at, PDO::PARAM_STR);
        $stmt->bindParam("phone", $phone, PDO::PARAM_STR);
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
    public function getfullprofiledetail($profile_id,$lat,$lon)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * ,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance FROM clinic_profile WHERE id=:profile_id ORDER BY distance ASC");
        $stmt->bindParam("profile_id", $profile_id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        if ($count)
        {
            return $data;
        }
        else
        {
            return false;
        }
    }
    public function publishreview($user_id,$profile_id,$review_text,$ratting){
        $time=time();
        $db=getDB();
        $stmt = $db->prepare("INSERT INTO clinic_reviewratting (`user_id`, `doctor_id`, `review_text`, `ratting`,`created_at`) VALUES (:user_id,:profile_id,:review_text,:ratting,:created_at)");
        $stmt->bindParam("user_id", $user_id, PDO::PARAM_STR);
        $stmt->bindParam("profile_id", $profile_id, PDO::PARAM_STR);
        $stmt->bindParam("review_text", $review_text, PDO::PARAM_STR);
        $stmt->bindParam("ratting", $ratting, PDO::PARAM_STR);
        $stmt->bindParam("created_at", $time, PDO::PARAM_STR);
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

    public function getallreviewbyid($profile_id)
    {
        $db = getDB();
        $stmt = $db->prepare("Select * from clinic_reviewratting Where doctor_id=:doctor_id ORDER BY id DESC");
        $stmt->bindParam("doctor_id", $profile_id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count)
        {
            while($data = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $stmt1 = $db->prepare("Select * from clinic_users Where id='".$data['user_id']."'");
                $stmt1->execute();
                $data1=$stmt1->fetch(PDO::FETCH_OBJ);
                if($data1->reg_type == "appuser")
                {
                    $images=IMAGEPATH.$data1->image;
                }
                else
                {
                    $images=$data1->image;
                }
                $arr[]=array("id"=>$data['id'],"username"=>$data1->username,"userimage"=>$images,"review_text"=>$data['review_text'],"ratting"=>$data['ratting'],"created_at"=>$data['created_at']);
            }
            return $arr;
        }
        else
        {
            return false;
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

    public function getcityid($city){
        $db=getDB();
        $stmt = $db->prepare("Select id from clinic_city where name=:city");
        $stmt->bindParam("city", $city, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);
        if($count)
        {
            return $data;
        }
        else
        {
            return false;
        }
    }



    public function getprofileforhospitalandphramarcie($specialities_id,$lat,$lon,$orderby,$radius){
        $db = getDB();
        if($orderby == ""){
            $stmt = $db->prepare("
                SELECT *,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance
                from clinic_profile where mcat_id = $specialities_id  ORDER BY distance ASC ");
        }
        elseif($orderby == "a-z")
        {
            $stmt = $db->prepare("
                SELECT *,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance
                from clinic_profile where mcat_id = $specialities_id ORDER BY name ASC ");
        }
        elseif($orderby == "z-a")
        {
            $stmt = $db->prepare("
                SELECT *,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance
                from clinic_profile where mcat_id = $specialities_id ORDER BY name DESC ");
        }
        else{
            $stmt = $db->prepare("
                SELECT *,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( `lat` ) ) *
                COS( RADIANS( `lon` ) - RADIANS( $lon ) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( `lat` ) ) ) ) AS distance
                from clinic_profile where mcat_id=$specialities_id && city=:city_id ORDER BY distance DESC ");
            $stmt->bindParam("city_id", $orderby, PDO::PARAM_STR);
        }

        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count)
        {
            while($data = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $ratting =$this->getratting($data['id']);
                $radiusdata = $data['distance'] * 1.609344;
                $km = round($radiusdata,2);
                if($radius != "none")
                {
                    if($km <= $radius)
                    {
                        $arr[] = array
                        (
                            "id" => $data['id'],
                            "distance" => $data['distance'],
                            "distancekm" => $km,
                            "icon" => $data['icon'],
                            "name" => $data['name'],
                            "services" => $data['services'],
                            "ratting" => $ratting
                        );
                    }
                }
                else
                {
                    $arr[] = array(
                        "id" => $data['id'],
                        "distance" => $data['distance'],
                        "distancekm" => $km,
                        "icon" => $data['icon'],
                        "name" => $data['name'],
                        "services" => $data['services'],
                        "ratting" => $ratting
                    );
                }
            }
            if(isset($arr))
            {
                return $arr;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}
?>
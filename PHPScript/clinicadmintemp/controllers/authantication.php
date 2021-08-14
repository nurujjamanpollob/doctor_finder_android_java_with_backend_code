<?php 
	include "application/db_config.php";
	class Admin
	{

		public function check_login($username, $password)
		{
			$db = getDB();
			
			$stmt = $db->prepare("SELECT id FROM clinic_adminlogin WHERE  (username=:username or email=:username) AND  password=:password");
			$stmt->bindParam("username", $username,PDO::PARAM_STR);
			$stmt->bindParam("password", $password,PDO::PARAM_STR);
			$stmt->execute();
			$count=$stmt->rowCount();
			$data=$stmt->fetch(PDO::FETCH_OBJ);
			$db = null;
			if($count)
			{
				$_SESSION['login'] = true;
				$_SESSION['uid']=$data->id;
				return true;
			}
			else
			{
				return false;
			}
		}


		/*public function reg_user($name,$username,$password,$email)
		{
			$password = md5($password);
			$sql="SELECT * FROM users WHERE uname='$username' OR uemail='$email'";
			
			//checking if the username or email is available in db
			$check =  $this->db->query($sql) ;
			$count_row = $check->num_rows;

			//if the username is not in db then insert to the table
			if ($count_row == 0){
				$sql1="INSERT INTO users SET uname='$username', upass='$password', fullname='$name', uemail='$email'";
				$result = mysqli_query($this->db,$sql1) or die(mysqli_connect_errno()."Data cannot inserted");
        		return $result;
			}
			else { return false;}
		}*/


		/*** for login process ***/
		/*public function check_login($emailusername, $password){
        	
        	$password = md5($password);
			$sql2="SELECT uid from users WHERE uemail='$emailusername' or uname='$emailusername' and upass='$password'";
			
			//checking if the username is available in the table
        	$result = mysqli_query($this->db,$sql2);
        	$user_data = mysqli_fetch_array($result);
        	$count_row = $result->num_rows;
		
	        if ($count_row == 1) {
	            // this login var will use for the session thing
	            $_SESSION['login'] = true; 
	            $_SESSION['uid'] = $user_data['uid'];
	            return true;
	        }
	        else{
			    return false;
			}
    	}*/

    	/*** for showing the username or fullname ***/
    	public function get_fullname()
		{
    		$sql3="SELECT * FROM tbl_stores_deliverysystem ";
	        $result = mysqli_query($this->db,$sql3);
			while($user_data = mysqli_fetch_array($result))
			{
				$row[]=$user_data;
			}
			return $row;
    	}


    	/*** starting the session ***/
	    public function get_session()
		{
	        return $_SESSION['login'];
	    }

	    public function user_logout()
		{
	        $_SESSION['login'] = FALSE;
	        session_destroy();
	    }

	}
?>
<?php
/* View Profile List With Main category Id  */
include '../controllers/apicontrollers.php';
$apicontroller=new Apicontrollers();
extract($_GET);
if(isset($category_id) && $category_id == 2 OR $category_id == 3)
{
    if
    (
        isset($lat) && $lat != "" &&
        isset($lon) && $lon != "" &&
        isset($orderby) && ($orderby == "a-z" OR $orderby=="z-a")
    )
    {
        $profile=$apicontroller->getprofileforhospitalandphramarcie($category_id,$lat,$lon,$orderby,"none");
        if($profile)
        {
            $arr[]=array("status"=>"Success","List_profile"=>$profile);
            echo json_encode($arr);
        }
        else
        {
            echo '[{"status":"Failed","Error":"Profile Not Found"}]';
        }
    }
    elseif
    (
        isset($lat) && $lat != "" &&
        isset($lon) && $lon != "" &&
        isset($city)
    )
    {
        if(isset($current_city) && $current_city != "")
        {
            $getcityid = $apicontroller->getcityid($current_city);
            if($getcityid)
            {
                $profile = $apicontroller->getprofileforhospitalandphramarcie($category_id, $lat, $lon, $getcityid->id,"none");
            }
            else
            {
                $profile = false;
            }
        }
        else
        {
            $profile = $apicontroller->getprofileforhospitalandphramarcie($category_id, $lat, $lon, $city,"none");
        }
        if($profile)
        {
            $arr[]=array("status"=>"Success","List_profile"=>$profile);
            echo json_encode($arr);
        }
        else
        {
            if(isset($current_city))
            {
                echo '[{"status":"Failed","Error":"Profile Not Found In This Location"}]';
            }
            else
            {
                echo '[{"status":"Failed","Error":"Profile Not Found In This City"}]';
            }
        }
    }
    else
    {
        if(
            isset($lat) && $lat != "" &&
            isset($lon) && $lon != "" &&
            isset($radius) && $radius != ""
        )
        {
            $profile=$apicontroller->getprofileforhospitalandphramarcie($category_id,$lat,$lon,"",$radius);
            if($profile)
            {
                $arr[]=array("status"=>"Success","List_profile"=>$profile);
                echo json_encode($arr);
            }
            else
            {
                echo '[{"status":"Failed","Error":"Profile Not Found "}]';
            }
        }
        else
        {
            echo '[{"status":"Failed","Error":"Variable not set"}]';
        }
    }
}
else
{
    echo '[{"status":"Failed","Error":"Entered category id is not valid "}]';
}

/*  Get Profile list with alphabetically  http://192.168.1.104/clinicadmin/Apicontrollers/getprofile.php?lat={}&lon={}&orderby={fixed value a-z OR z-a}  */
/*  Get Profile list with city wise  http://192.168.1.104/clinicadmin/Apicontrollers/getprofile.php?lat={}&lon={}&city={ city id}  */
/*  Get Profile list with Nearest Order  http://192.168.1.104/clinicadmin/Apicontrollers/getprofile.php?lat={}&lon={}  */

?>
<?php
include '../controllers/apicontrollers.php';
$apicontroller=new Apicontrollers();
extract($_GET);
if(
isset($profile_id) && $profile_id != "" &&
isset($lat) && $lat != "" &&
isset($lon) && $lon != ""
) 
{
    $pr=$apicontroller->getfullprofiledetail($profile_id,$lat,$lon);
    if($pr)
    {
        $radiusdata = $pr->distance * 1.609344;
        $km = round($radiusdata,2);
        $ratting=$apicontroller->getratting($pr->id);
        $mainarr[]=array(
            "id"=>$pr->id,
            "ratting"=>$ratting,
			"icon"=>$pr->icon,
			"name"=>$pr->name,
			"phone"=>$pr->phone,
			"email"=>$pr->email,
			"hours"=>$pr->hours,
			"lat"=>$pr->lat,
			"lon"=>$pr->lon,
			"about"=>$pr->about,
			"services"=>$pr->services,
			"address"=>$pr->address,
			"goole_plus"=>$pr->goole_plus,
			"helthcare"=>$pr->helthcare,
			"facebook"=>$pr->facebook,
			"twiter"=>$pr->twiter,
			"distance"=> $pr->distance,
            "distancekm" => $km
        );
        $arr[]=array("status"=>"Success","profile_detail"=>$mainarr);
        echo json_encode($arr);
    }
    else
    {
        echo '[{"status":"Failed","Error":"Profile id is wrong"}]';
    }
}
else
{
    echo '[{"status":"Failed","Error":"variable not set"}]';
}
?>
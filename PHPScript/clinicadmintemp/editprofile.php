<?php
session_start();
include 'controllers/clinic.php';
$admin = new dashboard();
if(!$admin->get_session())
{
    header("location:index.php");
}
if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != "")
{
    $qrstring=$admin->encrypt_decrypt("decrypt",$_SERVER['QUERY_STRING']);
    $val=explode("=",$qrstring);
    $id=$val[1];
    $res=$admin->profiledetail($id);
    if($res)
    {
        $mcat_id=$res->mcat_id;
        $sepcialities = $admin->getspecialities(1);
        $citydata=$admin->getcity();
    }
    else
    {
        ?>
        <script>
            alert("! Oops Some Thing want wrong !!!");
            window.location='profile.php';
        </script>
        <?php
    }
}
else{
    ?>
    <script>
        alert("! Oops Some Thing want wrong !!!");
        window.location='profile.php';
    </script>
    <?php
}
if(isset($_REQUEST['updateprofile'])){

    if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
        $reomveimage=$admin->unlinkimage($_POST['image'],"uploads");
        $path = $_FILES['file']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $tmp_file=$_FILES['file']['tmp_name'];
        $file_path="uploads/"."profile_".time().".".$ext;
        $imagename= "profile_".time().".".$ext;
        if(move_uploaded_file($tmp_file,$file_path))
        {
            if($_FILES['file']['size'] > 1048576)
            {
                $admin->compress($file_path,$file_path, 80);
            }
            extract($_REQUEST);
			if($_POST['mcatid']==1)
			{
				$addprofile=$admin->editprofile($update_id,$mcatid,$sp_id,$name,$phone,$validate_email,$hours,$address,$about,$services,$lat,$lon,$fb,$gplus,$twiter,$city,$imagename,$helthcare);
			}
			else
			{
				$addprofile=$admin->editprofile($update_id,$mcatid,0,$name,$phone,$validate_email,$hours,$address,$about,$services,$lat,$lon,$fb,$gplus,$twiter,$city,$imagename,"none");
			}
            
            if($addprofile)
            {
                ?>
                    <?php
                    extract($_REQUEST);
                    if($_POST['mcatid']==1)
                    {
                    ?>
                    <script>
                        window.location='doctors.php';
                    </script>
                    <?php
                    extract($_REQUEST);
                    } elseif ($_POST['mcatid']==2) {
                    ?>
                        <script>
                            window.location='pharmacy.php';
                        </script>
                    <?php
                    extract($_REQUEST);
                    } elseif ($_POST['mcatid']==3) {
                    ?>
                        <script>
                            window.location='hospital.php';
                        </script>
                    <?php
                    } else {
                    ?>
                        <script>
                            window.location='profile.php';
                        </script>
                    <?php
                    }
                    ?>
                <?php
            }
            else
            {

            }
        }
        else
        {
            ?>
            <script>
                alert("! Error For Uploading file !!!");
            </script>
            <?php
        }
    }
    else{

        extract($_REQUEST);
		if($_POST['mcatid']==1)
		{
			$addprofile=$admin->editprofile($update_id,$mcatid,$sp_id,$name,$phone,$validate_email,$hours,$address,$about,$services,$lat,$lon,$fb,$gplus,$twiter,$city,"no",$helthcare);
		}
		else
		{
			$addprofile=$admin->editprofile($update_id,$mcatid,$sp_id,$name,$phone,$validate_email,$hours,$address,$about,$services,$lat,$lon,$fb,$gplus,$twiter,$city,"no","none");
		}
        
        if($addprofile)
        {
            ?>
                    <?php
                    extract($_REQUEST);
                    if($_POST['mcatid']==1)
                    {
                    ?>
                    <script>
                        window.location='doctors.php';
                    </script>
                    <?php
                    extract($_REQUEST);
                    } elseif ($_POST['mcatid']==2) {
                    ?>
                        <script>
                            window.location='pharmacy.php';
                        </script>
                    <?php
                    extract($_REQUEST);
                    } elseif ($_POST['mcatid']==3) {
                    ?>
                        <script>
                            window.location='hospital.php';
                        </script>
                    <?php
                    } else {
                    ?>
                        <script>
                            window.location='profile.php';
                        </script>
                    <?php
                    }
                    ?>
            <?php
        }
        else
        {

        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Clinic Admin Panel Login Witch control android and ios application data.">
    <meta name="author" content="Freaktemplate">
    <meta name="keyword" content="Mobile App With Web development and design technology">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clinic Admin | Edit Profile</title>
    <!-- start: Css -->
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
    <!-- plugins -->
    <link rel="stylesheet" type="text/css" href="asset/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="asset/css/simple-line-icons.css"/>
    <link rel="stylesheet" type="text/css" href="asset/css/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="asset/css/mediaelementplayer.css"/>
    <link rel="stylesheet" type="text/css" href="asset/css/red.css"/>
    <link href="asset/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src='http://maps.google.com/maps/api/js?key=AIzaSyBiVfFZRtrGy8AmV5UH7WZEou_3Hpbc_xg&sensor=false&libraries=places'></script>
    <script src="asset/js/locationpicker.js"></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>

<body class="dashboard">
<?php
include 'include/header.php';
?>
<div class="container-fluid mimin-wrapper">
    <?php
    include 'include/sidebar.php';
    ?>
    <div id="content">
        <div class="panel">
            <div class="panel-body">
                <div class="col-md-12 col-sm-12">
                    <h4 class="animated fadeInLeft"><i class="icon icon-list"></i> Update Profile Detail</h4>
                    <div style="margin-top: -31px;padding-bottom: 6px;" class="animated fadeInRight" align="right"><a href="profile.php" class="badge badge-primary"><i class="fa fa-long-arrow-left"></i> Back</a></div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-12 panel">
                <div class="col-md-12 panel-heading">
                    <h4>Filling Up Profile Detail</h4>
                </div>
                <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                    <div class="col-md-12">
                        <form class="cmxform signupForm" method="post" enctype="multipart/form-data" >
                            <div id="firststep">
                                <div class="col-md-6">
                                    <input type="hidden" name="image" value="<?php echo $res->icon; ?>">
                                    <input type="hidden" name="update_id" value="<?php echo $res->id; ?>">
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <select class="form-text"  onchange="getcategory(this.value);" name="mcatid" required>
                                            <?php

                                                if($res->mcat_id == 1)
                                                {
                                                    ?>
                                                    <option value="1" selected>Doctors</option>
                                                    <option value="2">Pharmacies</option>
                                                    <option value="3">Hospitals</option>
                                                    <?php
                                                }
                                                elseif($res->mcat_id == 2)
                                                {
                                                    ?>
                                                    <option value="1">Doctors</option>
                                                    <option value="2" selected>Pharmacies</option>
                                                    <option value="3">Hospitals</option>
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    <option value="1" >Doctors</option>
                                                    <option value="2">Pharmacies</option>
                                                    <option value="3" selected>Hospitals</option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;" id="showselected">
                                        <select class="form-text" name="sp_id" required>
                                            <option value="">Select Specialities</option>
                                            <?php
                                            foreach($sepcialities as $value)
                                            {
                                                if($res->spcat_id == $value['id'])
                                                {
                                                    ?>
                                                    <option value="<?php echo $value['id']; ?>" selected><?php echo $value['name']; ?></option>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                       <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <div>Select Profile Icon</div>
                                        <input type="file" class="form-text" name="file" id="file">
                                        <span class="bar"></span>
                                        <img align="right"  id="myimage" src="uploads/<?php echo $res->icon; ?>" style="height: 80px;width: 120px;margin-top: -81px;border-radius: 15px;">
                                    </div>
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <input type="text" class="form-text" name="name" value="<?php echo $res->name; ?>" required>
                                        <span class="bar"></span>
                                        <label>Name</label>
                                    </div>
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <input type="text" class="form-text" value="<?php echo $res->phone; ?>" name="phone" required>
                                        <span class="bar"></span>
                                        <label>Phone No.</label>
                                    </div>

                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <input type="text" class="form-text"  id="validate_email" value="<?php echo $res->email; ?>" name="validate_email" required>
                                        <span class="bar"></span>
                                        <label>Email</label>
                                    </div>
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <input type="text" class="form-text"  name="hours" value="<?php echo $res->hours; ?>" required >
                                        <span class="bar"></span>
                                        <label>Office Hours For ex : 09:00 AM To 08:00 PM</label>
                                    </div>
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <textarea class="form-text"  name="address" required><?php echo $res->address; ?></textarea>
                                        <span class="bar"></span>
                                        <label>Address</label>
                                    </div>
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <textarea class="form-text"  name="about" required><?php echo $res->about; ?></textarea>
                                        <span class="bar"></span>
                                        <label>About/Descriptions</label>
                                    </div>
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <textarea class="form-text"  name="services" required><?php echo $res->services ?></textarea>
                                        <span class="bar"></span>
                                        <label>Services</label>
                                    </div>
                                    <?php
									if($res->mcat_id == 1)
									{ 
									?>
                                    <div id="helthcare" class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <textarea class="form-text"  name="helthcare" required><?php echo $res->helthcare; ?></textarea>
                                        <span class="bar"></span>
                                        <label>Helth Care</label>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <select class="form-text"  name="city" required>
                                            <option value="">Select City</option>
                                            <?php
                                            foreach($citydata as $value)
                                            {
                                                if($res->city == $value['id']) {
                                                    ?>
                                                    <option
                                                        value="<?php echo $value['id']; ?>" selected><?php echo $value['name']; ?></option>
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    <option
                                                        value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <input type="text" class="form-text" id="us2-address" name="location" required>
                                        <span class="bar"></span>
                                        <label>Search Location</label>
                                    </div>
                                    <div class="form-group form-animate-text" >
                                        <div id="us2" style="height: 300px;"></div>
                                    </div>
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <input type="text" class="form-text" id="us2-lat" name="lat" required>
                                        <span class="bar"></span>
                                        <label>Latitude</label>
                                    </div>
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <input type="text" class="form-text" id="us2-lon" name="lon" required>
                                        <span class="bar"></span>
                                        <label>Longitude</label>
                                    </div>
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <input type="text" class="form-text" value="<?php echo $res->facebook; ?>" name="fb" >
                                        <span class="bar"></span>
                                        <label>Facebook Link (Optional)</label>
                                    </div>
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <input type="text" class="form-text" value="<?php echo $res->goole_plus; ?>"  name="gplus">
                                        <span class="bar"></span>
                                        <label>Google Plus Link (Optional)</label>
                                    </div>
                                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                        <input type="text" class="form-text"  name="twiter" value="<?php echo $res->twiter; ?>">
                                        <span class="bar"></span>
                                        <label>Twitter Link(Optional)</label>
                                    </div>
                                </div>
                                <div class="col-md-12" align="right">
                                    <input class="submit btn btn-danger" type="submit" name="updateprofile"  value="Update Profile">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        <?php
        if($res->mcat_id == 1)
        {
            ?>
              $("#showselected").show();
            <?php
        }
        else
        {
            ?>
              $("#showselected").hide();
            <?php
        }
        ?>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#myimage').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#file").change(function(){
            readURL(this);
        });
        function getspecilities(id){
            $.ajax({
                type: "POST",
                url: "ajax/getspecialities.php",
                data: {querystring:id},
                cache: false,
                success: function (data)
                {
                    if (data)
                    {
                        $('#showspecilitiesdetail').replaceWith($('#showspecilitiesdetail').html(data));
                    }
                    else
                    {

                    }
                }
            });
        }

        function getcategory(id){
            if(id == 1){
                $("#showselected").show();
                $("#helthcare").show();
            }
            else{
                $("#showselected").hide();
                $("#helthcare").hide();
            }
            
        }
        $('#us2').locationpicker({
            location:
            {
                latitude: <?php echo $res->lat; ?>,
                longitude: <?php echo $res->lon; ?>
            },
            radius: 300,
            inputBinding:
            {
                latitudeInput: $('#us2-lat'),
                longitudeInput: $('#us2-lon'),
                radiusInput: $('#us2-radius'),
                locationNameInput: $('#us2-address')
            },
            enableAutocomplete: true
        });
    </script>
    <!-- start: Javascript -->
    <script src="asset/js/jquery.min.js"></script>
    <script src="asset/js/jquery.ui.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <!-- plugins -->
    <script src="asset/js/moment.min.js"></script>
    <script src="asset/js/jquery.validate.min.js"></script>
    <script src="asset/js/icheck.min.js"></script>
    <script src="asset/js/jquery.nicescroll.js"></script>
    <!-- custom -->
    <script src="asset/js/main.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $(".signupForm").validate({
                errorElement: "em",
                errorPlacement: function(error, element) {
                    $(element.parent("div").addClass("form-animate-error"));
                    error.appendTo(element.parent("div"));
                },
                success: function(label) {
                    $(label.parent("div").removeClass("form-animate-error"));
                },
                rules: {
                    validate_firstname: "required",
                    validate_lastname: "required",
                    validate_username:
                    {
                        required: true,
                        minlength: 2
                    },
                    validate_password:
                    {
                        required: true,
                        minlength: 5
                    },
                    validate_confirm_password:
                    {
                        required: true,
                        minlength: 5,
                        equalTo: "#validate_password"
                    },
                    validate_email: {
                        required: true,
                        email: true
                    },
                    validate_agree: "required"
                },
                messages: {
                    validate_firstname: "Please enter your firstname",
                    validate_lastname: "Please enter your lastname",
                    validate_username:
                    {
                        required: "Please enter a username",
                        minlength: "Your username must consist of at least 2 characters"
                    },
                    validate_password:
                    {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    validate_confirm_password:
                    {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long",
                        equalTo: "Please enter the same password as above"
                    },
                    validate_email: "Please enter a valid email address",
                    validate_agree: "Please accept our policy"
                }
            });


        });
    </script><!-- end: Javascript -->

</body>
</html>





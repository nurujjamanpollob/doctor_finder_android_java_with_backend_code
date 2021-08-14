<?php
session_start();
include 'controllers/clinic.php';
$admin = new dashboard();
if(!$admin->get_session())
{
    header("location:index.php");
}
if(isset($_POST['updateprofile']))
{
	$name=$_POST['name'];
	$fullname=$_POST['fullname'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$id=$_POST['id'];
	if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
	{
		$data=$admin->getadmininfowithid($id);
		if($data)
		{
			$reomveimage=$admin->unlinkimage($data['icon'],"uploads");	
		}
        
        $path = $_FILES['file']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $tmp_file=$_FILES['file']['tmp_name'];
        $file_path="uploads/"."admin_".time().".".$ext;
        $imagename= "admin_".time().".".$ext;
        if(move_uploaded_file($tmp_file,$file_path))
        {
         
            $editprofile=$admin->editadminprofile($id,$name,$fullname,$email,$phone,$imagename);
            if($editprofile)
            {
                ?>
                <script>
                    window.location='myprofile.php';
                </script>
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
	else
	{
            $editprofile=$admin->editadminprofile($id,$name,$fullname,$email,$phone,"no");
            if($editprofile)
            {
                ?>
                <script>
                    window.location='myprofile.php';
                </script>
                <?php
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
    <title>Clinic Admin | Profile</title>
    <!-- start: Css -->
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
    <!-- plugins -->
    <link rel="stylesheet" type="text/css" href="asset/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="asset/css/simple-line-icons.css"/>
    <link rel="stylesheet" type="text/css" href="asset/css/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="asset/css/mediaelementplayer.css"/>
    <link rel="stylesheet" type="text/css" href="asset/css/red.css"/>
    <link href="asset/css/style.css" rel="stylesheet">
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
                    <h4 class="animated fadeInLeft"><i class="icon icon-list"></i> Admin Profile </h4>
                    <div style="margin-top: -31px;padding-bottom: 6px;" class="animated fadeInRight" align="right"><a href="dashboard.php" class="badge badge-primary"><i class="fa fa-long-arrow-left"></i> Back</a></div>
                </div>
            </div>
        </div>

         <?php 
		 	$id=$_SESSION['uid'];
			$admininfo = $admin->getadmininfowithid($id);
		 	
		 ?>       

        <div class="col-md-12">
            <div class="col-md-12 panel">
                <div class="col-md-12 panel-heading">
                    <h4>Filling Up Profile Detail</h4>
                </div>
                <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                    <div class="col-md-12">
                        <form class="cmxform signupForm" method="post" enctype="multipart/form-data" action="">
                            <div id="firststep">
                            <div class="col-md-12">
                            	<div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <div></div>
                                    <input type="file" onchange="PreviewImage()"   class="form-text"  name="file" id="file" accept="image/*" style="visibility:hidden;" >
                                    <img align="left" id="catimage" onClick="selectimage()" src="uploads/<?php echo $admininfo['icon'];?>" style="height: 80px;width: 120px;margin-top: -81px;border-radius: 15px;">
                                    <span class="bar"></span>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <input type="text" class="form-text" value="<?php echo $admininfo['username'];?>" name="name" required>
                                    <span class="bar"></span>
                                    <label>Name</label>
                                </div>
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <input type="text" class="form-text" value="<?php echo $admininfo['fullname'];?>" name="fullname" required>
                                    <span class="bar"></span>
                                    <label>Full Name</label>
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <input type="email" class="form-text" value="<?php echo $admininfo['email'];?>"  id="validate_email" name="email" required>
                                    <span class="bar"></span>
                                    <label>Email</label>
                                </div>
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <input type="text" class="form-text" value="<?php echo $admininfo['phone'];?>" name="phone" required>
                                    <span class="bar"></span>
                                    <label>Phone No.</label>
                                </div>
                            </div>
                            <div class="col-md-12" align="right">
                            	<input type="hidden" name="id" value="<?php echo $admininfo['id'];?>">
                                <input class="submit btn btn-danger" type="submit" name="updateprofile"  value="Save Changes">
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    </div>
        

        
    </div>
</div>

<script>
    function selectimage()
	{
		var x =document.getElementById('file');
		x.click();
		
	}
	function PreviewImage() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("file").files[0]);

            oFReader.onload = function (oFREvent) {
                document.getElementById("catimage").src = oFREvent.target.result;
            };
        };
	
    function deletemobileuser(id)
    {
        var x = confirm("Are you sure want to delete ?");
        if(x) {
            $.ajax({
                type: "POST",
                url: "ajax/deletemobileuser.php",
                data: {querystring: id},
                cache: false,
                success: function (data)
                {
                    if (data)
                    {
                        window.location='mobileuser.php';
                    }
                    else
                    {
                        alert("Please Try Again Latter..");
					}
                }
            });
        }
        else{
            return false;
        }
    }
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
        $("#specilitits").validate({
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
                validate_username: {
                    required: "Please enter a username",
                    minlength: "Your username must consist of at least 2 characters"
                },
                validate_password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                validate_confirm_password: {
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





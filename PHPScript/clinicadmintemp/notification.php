<?php
session_start();
include 'controllers/clinic.php';
$admin = new dashboard();
if(!$admin->get_session())
{
    header("location:index.php");
}
if(isset($_POST['updatenotification']))
{
    
	$apikey=$_POST['apikey'];
	$apnspass=$_POST['apnspass'];
    $environment=$_POST['environment'];
	$id=$_POST['id'];
	if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
	{
		$data=$admin->getnotificationinfoid($id);
		if($data)
		{
			$reomveimage=$admin->unlinkimage($data['certificate'],"uploads");	
		}
        
        $path = $_FILES['file']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $tmp_file=$_FILES['file']['tmp_name'];
        $file_path="uploads/"."certificate_".time().".".$ext;
        $imagename= "certificate_".time().".".$ext;
        if(move_uploaded_file($tmp_file,$file_path))
        {
         
            $editnotification=$admin->editnotification($id,$apikey,$apnspass,$imagename,$environment);
            if($editnotification)
            {
                ?>
                <script>
                    window.location='notification.php';
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
            $editnotification=$admin->editnotification($id,$apikey,$apnspass,"no",$environment);
            if($editnotification)
            {
                ?>
                <script>
                    window.location='notification.php';
                </script>
                <?php
            }

	}
}


if(isset($_POST['insertnotification']))
{
	$apikey=$_POST['apikey'];
	$apnspass=$_POST['apnspass'];
    $environment=$_POST['environment'];
	$path = $_FILES['file']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $tmp_file=$_FILES['file']['tmp_name'];
   	$file_path="uploads/"."certificate_".time().".".$ext;
    $imagename= "certificate_".time().".".$ext;
    if(move_uploaded_file($tmp_file,$file_path))
    {
    	$addnotification=$admin->addnotification($apikey,$apnspass,$imagename,$environment);
        if($addnotification)
        {
			?>
			<script>
			window.location='notification.php';
			</script>
			<?php
        }
        else
        {
			?>
            <script>
			alert("Network Error Try Again..");
			</script>
            <?php 
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
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="description" content="Clinic Admin Panel Login Witch control android and ios application data.">
    <meta name="author" content="Freaktemplate">
    <meta name="keyword" content="Mobile App With Web development and design technology">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clinic Admin | Notification</title>
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
                    <h4 class="animated fadeInLeft"><i class="icon icon-list"></i> Notification </h4>
                    <div style="margin-top: -31px;padding-bottom: 6px;" class="animated fadeInRight" align="right"><a href="dashboard.php" class="badge badge-primary"><i class="fa fa-long-arrow-left"></i> Back</a></div>
                </div>
            </div>
        </div>

         <?php
			$notificationinfo = $admin->getnotificationinfo();

			if($notificationinfo)
			{?>
				<div class="col-md-12">
            <div class="col-md-12 panel">
                <div class="col-md-12 panel-heading">
                    <h4>Update Notification Detail</h4>
                </div>
                <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                    <div class="col-md-12">
                        <form class="cmxform signupForm" method="post" enctype="multipart/form-data" action="">
                            <div id="firststep">
                            <div class="col-md-6">

                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <input type="text" class="form-text" value="<?php echo $notificationinfo['apikey'];?>" name="apikey" required>
                                    <span class="bar"></span>
                                    <label>Google API Key</label>
                                </div>
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <input type="text" class="form-text" value="<?php echo $notificationinfo['passphrace'];?>" name="apnspass" required>
                                    <span class="bar"></span>
                                    <label>Apns Passphrace</label>
                                </div>
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">

                                    <input type="file" class="form-text"  name="file" id="file" accept=".pem"  >
                                    <span class="badge badge-success"><?php echo "Already Selected file : ".$notificationinfo['certificate'];?></span>
                                    <span class="bar"></span>
                                    <label>Upload Certificate</label>
                                </div>
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <select class="form-text" name="environment" required>
                                        <?php
                                        if($notificationinfo['environment'] == "gateway.push.apple.com")
                                        {
                                            ?>
                                            <option value="gateway.push.apple.com" selected>Live</option>
                                            <option value="gateway.sandbox.push.apple.com">Sandbox</option>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <option value="gateway.push.apple.com">Live</option>
                                            <option value="gateway.sandbox.push.apple.com" selected>Sandbox</option>
                                            <?php
                                        }

                                        ?>

                                    </select>
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                 <input type="hidden" name="id" value="<?php echo $notificationinfo['id'];?>">
                                <input class="submit btn btn-danger" type="submit" name="updatenotification"  value="Save Changes">
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
    </div>
    </div>
                
			<?php }
			else
			{?>
				<div class="col-md-12">
            <div class="col-md-12 panel">
                <div class="col-md-12 panel-heading">
                    <h4>Filling Up Notification Detail</h4>
                </div>
                <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                    <div class="col-md-12">
                        <form class="cmxform signupForm" method="post" enctype="multipart/form-data" action="">
                            <div id="firststep">
                            <div class="col-md-6">
                                
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <input type="text" class="form-text" value="" name="apikey" required>
                                    <span class="bar"></span>
                                    <label>Google API Key</label>
                                </div>
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <input type="text" class="form-text" value="" name="apnspass" required>
                                    <span class="bar"></span>
                                    <label>Apns Passphrace</label>
                                </div>
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <div></div>
                                    <input type="file" class="form-text"  name="file" id="file" accept=".pem"  required>
                                    <span class="bar"></span>
                                    <label>Upload Certificate</label>
                                </div>
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <select class="form-text" name="environment" required>
                                        <option value="">Select Environment</option>
                                        <option value="gateway.push.apple.com">Live</option>
                                        <option value="gateway.sandbox.push.apple.com">Sandbox</option>
                                    </select>
                                    <span class="bar"></span>
                                </div>
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                <input class="submit btn btn-danger" type="submit" name="insertnotification"  value="Save">
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
    </div>
    </div>
			<?php
            }
		 ?>       

        
</div>

<script>
    
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
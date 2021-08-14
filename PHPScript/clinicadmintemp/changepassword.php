<?php
session_start();
include 'controllers/clinic.php';
$admin = new dashboard();
if(!$admin->get_session())
{
    header("location:index.php");
}
if(isset($_POST['changepassword']))
{
	$oldpwd=$_POST['oldpwd'];
	$newpwd=$_POST['newpwd'];
	$confirmpwd=$_POST['confirmpwd'];
	$id=$_SESSION['uid'];
	$admininfo = $admin->getadmininfo($id);
	if($oldpwd == $admininfo['password'])
	{
		if($newpwd == $confirmpwd)
		{
			
			$update=$admin->updatepassword($id,$newpwd);
			if($update)
			{
				?>
        		<script>
            		alert("Password Change Successfully..");
					window.location='changepassword.php';
            	</script>
        		<?php 
			}
			else
			{
				?>
        		<script>
            		alert("Network Error Please Trt Again");
					window.location='changepassword.php';
            	</script>
        		<?php 
			}
		}
		else
		{
			?>
        	<script>
            	alert("New Password And Confirm Password Are Not Match");
				window.location='changepassword.php';
            </script>
        <?php 
		}
		
	}
	else
	{
		?>
        	<script>
            	alert("Old Password Wrong...");
				window.location='changepassword.php';
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
    <title>Clinic Admin | Change Password</title>
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
                    <h4 class="animated fadeInLeft"><i class="icon icon-list"></i> Change Password</h4>
                    <div style="margin-top: -31px;padding-bottom: 6px;" class="animated fadeInRight" align="right"><a href="dashboard.php" class="badge badge-primary"><i class="fa fa-long-arrow-left"></i> Back</a></div>
                </div>
            </div>
        </div>

                <script>
                    function redirectpage(val){
                        window.location='specialities.php?sp_category='+val;
                    }
                </script>

	

        <div class="col-md-12 top-20 padding-0" style="margin-top: -0px;">
            <div class="col-md-12">

                <div class="panel">
                    <div class="panel-body">
   						
                        <div class="modal-dialog">
                <div class="modal-content">
                    <form class="cmxform" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="icon icon-list"></i> Change Password</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group form-animate-text"  >
                                <input class="form-text" type="password" name="oldpwd"  required >
                                <span class="bar"></span>
                                <label>Old Password</label>
                            </div>
                            <div class="form-group form-animate-text"  >
                                <input class="form-text" type="password" name="newpwd"  required >
                                <span class="bar"></span>
                                <label>New Password</label>
                            </div>
                            <div class="form-group form-animate-text"  >
                                <input class="form-text" type="password" name="confirmpwd"  required >
                                <span class="bar"></span>
                                <label>Confirm Password</label>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="changepassword">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>                     

                    </div>
                </div>
            </div>
        </div>
        

        
    </div>
</div>

<script>
    
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





<?php
session_start();
include 'controllers/clinic.php';
$admin = new dashboard();
if(!$admin->get_session())
{
    header("location:index.php");
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
    <title>Clinic Admin | Dashboard</title>
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

   $count=$admin->getcount();
   ?>
    <div id="content">
        <div class="panel">
            <div class="panel-body">
                <div class="col-md-12 col-sm-12">
                    <h4 class="animated fadeInLeft"><i class="glyphicon glyphicon-dashboard"></i> Dashboard</h4>
                </div>
            </div>
        </div>
        <div class="col-md-12 padding-0">
            <div class="col-md-3">
                <div class="panel box-v1">
                        <div class="panel-heading bg-white border-none">
                            <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                                <h4 class="text-left">Doctors</h4>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                <h4>
                                    <span class="glyphicon-user glyphicon text-right"></span>
                                </h4>
                            </div>
                        </div>
                        <div class="panel-body text-center">
                            <h1>+<?php echo $count['tprofile']; ?></h1>
                            <p>Total Doctors</p>
                            <hr>
                            <a href="doctors.php" style="cursor: pointer;">
                            View Details
                            </a>
                        </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel box-v1">
                    <div class="panel-heading bg-white border-none">
                        <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                            <h4 class="text-left">Pharmacy</h4>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                            <h4>
                                <span class="fa fa-medkit text-right"></span>
                            </h4>
                        </div>
                    </div>
                    <div class="panel-body text-center">
                        <h1>+<?php echo $count['tpharmacy']; ?></h1>
                        <p>Total Pharmacy</p>
                        <!-- clinic.php = 1056 -->
                        <hr>
                        <a href="pharmacy.php" style="cursor: pointer;">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel box-v1">
                    <div class="panel-heading bg-white border-none">
                        <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                            <h4 class="text-left">Hospitals</h4>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                            <h4>
                                <span class="fa fa-hospital-o text-right"></span>
                            </h4>
                        </div>
                    </div>
                    <div class="panel-body text-center">
                        <h1>+<?php echo $count['thospital']; ?></h1>
                        <p>Total Hospitals</p>
                        <hr>
                        <a href="hospital.php" style="cursor: pointer;">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel box-v1">
                    <div class="panel-heading bg-white border-none">
                        <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                            <h4 class="text-left"> Specialties</h4>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                            <h4>
                                <span class="fa-list fa text-right"></span>
                            </h4>
                        </div>
                    </div>
                    <div class="panel-body text-center">
                        <h1>+<?php echo $count['tspecialist'] ?></h1>
                        <p> Specialties Doctors</p>
                        <hr>
                        <a href="specialities.php" style="cursor: pointer;">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel box-v1">
                    <div class="panel-heading bg-white border-none">
                        <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                            <h4 class="text-left">City</h4>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                            <h4>
                                <span class="fa fa-building text-right"></span>
                            </h4>
                        </div>
                    </div>
                    <div class="panel-body text-center">
                        <h1>+<?php echo $count['tcity']; ?></h1>
                        <p>Total City</p>
                        <hr>
                        <a href="city.php" style="cursor: pointer;">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel box-v1">
                    <div class="panel-heading bg-white border-none">
                        <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                            <h4 class="text-left">Reviews</h4>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                            <h4>
                                <span class="glyphicon-comment glyphicon text-right"></span>
                            </h4>
                        </div>
                    </div>
                    <div class="panel-body text-center">
                        <h1>+<?php echo $count['treview'] ?></h1>
                        <p>Total Doctors Reviews</p>
                        <hr>
                        <a href="review.php" style="cursor: pointer;">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel box-v1">
                    <div class="panel-heading bg-white border-none">
                        <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                            <h4 class="text-left">App Users</h4>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                            <h4>
                                <span class="fa fa-users text-right"></span>
                            </h4>
                        </div>
                    </div>
                    <div class="panel-body text-center">
                        <h1>+<?php echo $count['tappusers']; ?></h1>
                        <p>Total App Users</p>
                        <hr>
                        <a href="mobileuser.php" style="cursor: pointer;">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function getuserinfo(id){
        $.ajax({
            type: "POST",
            url: "ajax/getuserinfo.php",
            data: {querystring: id},
            cache: false,
            success: function (data)
            {
                $('#showuserinfo').replaceWith($('#showuserinfo').html(data));
            }
        });
    }
</script>
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
</body>
</html>
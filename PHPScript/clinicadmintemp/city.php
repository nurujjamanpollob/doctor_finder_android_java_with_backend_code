<?php
session_start();
include 'controllers/clinic.php';
$admin = new dashboard();
if(!$admin->get_session())
{
    header("location:index.php");
}
if(isset($_POST['addcity']))
{
    if (isset($_POST['cityname']) && $_POST['cityname'] != "")
    {
        $cityname=$_POST['cityname'];
        $find = $admin->checkcity($cityname);
        if($find)
        {
            ?>
            <script>alert("This City Name Is Already in exists");</script>
            <?php
        }
        else
        {
            $insertcity=$admin->insertcity($cityname);
            if($insertcity)
            {
                ?>
                <script>window.location='city.php'</script>
                <?php
            }
            else
            {
                ?>
                <script>alert("Please Try Again...");</script>
                <?php
            }
        }
    }
    else
    {
        ?>
        <script>
            alert("! City Name Is Required !!!");
        </script>
        <?php
    }
}
if(isset($_POST['updatecity'])){
    if(isset($_POST['cityname']) && $_POST['cityname'] != "")
    {
        $cityname=$_POST['cityname'];
        $id=$_POST['id'];
        $update=$admin->updatecity($id,$cityname);
        if($update)
        {
            ?>
            <script>
                window.location='city.php';
            </script>
            <?php
        }
    }
    else
    {
        ?>
        <script>
            alert("! City Name Is Required !!!");
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
    <title>Clinic Admin | City</title>
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
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
                    <h4 class="animated fadeInLeft"><i class="icon icon-list"></i> City</h4>
                    <div style="margin-top: -31px;padding-bottom: 6px;" class="animated fadeInRight" align="right"><a href="dashboard.php" class="badge badge-primary">
                            <i class="fa fa-long-arrow-left"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <a href="#modal" data-toggle="modal" class="btn btn-primary" ><i class="icon icon-plus"></i> Add New City</a>
        </div>
        <script>
            function redirectpage(val)
            {
                window.location='specialities.php?sp_category='+val;
            }
        </script>
        <div class="col-md-12 top-20 padding-0" style="margin-top: -0px;">
            <div class="col-md-12">

                <div class="panel">
                    <div class="panel-body">
                        <div class="col-md-12 padding-0" style="padding-bottom:20px;">
                            <?php
                            $per_page = 10;
                            if(isset($_GET['page']))
                            {
                                $pageset = $_GET['page'];
                                if ($pageset == 1)
                                {
                                    $start = 0;
                                    $page = $per_page;
                                }
                                else
                                {
                                    $page = $_GET['page'] * $per_page;
                                    $start = $page - $per_page;
                                }
                            }
                            else
                            {
                                $start = 0;
                                $page = $per_page;
                            }
                            if (isset($_GET['search']))
                            {
                                $search = $_GET['search'];
                                $qutotal = $admin->selectcty($search, "searchtotal", "none", "none" );
                                $query = $admin->selectcty($search, "search", $start, $per_page);
                            }
                            else
                            {
                                $query = $admin->selectcty("none", "none", $start, $per_page);
                                $qutotal = $admin->selectcty("none", "total", "none", "none");
                            }
                           ?>

                            <div class="col-md-6">
                                <div class="col-lg-12">
                                    <form name="formserch" method="get">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" value="<?php  if(isset($_GET['search'])) echo $_GET['search']; ?>" placeholder="Search With City Name" aria-label="...">
                                            <?php
                                            if(isset($_GET['sp_category']) && $_GET['sp_category'] != ""){
                                                ?>
                                                <input type="hidden" name="sp_category" value="<?php echo $_GET['sp_category']; ?>">
                                                <?php
                                            }
                                            ?>
                                            <input type="hidden" name="page" value="1">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-primary dropdown-toggle"  >Search</button>
                                                <a href="city.php" type="submit" class="btn btn-primary dropdown-toggle"  >Reset</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="responsive-table col-md-12">
                            <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>City Name</th>
                                    <th>Created_at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($query)
                                {
                                    foreach ($query as $res)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $res['id']; ?></td>
                                            <td><?php echo $res['name'] ?></td>
                                            <td><?php echo date("d-M-Y H:i:sa",$res['created_at']); ?></td>
                                            <td>
                                                <?php
                                                $qstring="specialitiesid=".$res['id'];
                                                $enc_str=$admin->encrypt_decrypt("encrypt",$qstring);
                                                ?>
                                                <a href="#specilitiesdetail" data-toggle="modal" onclick="getcityname('<?php echo $enc_str; ?>')" class="badge badge-warning"><i class="icon-pencil"></i> Edit</a>
                                                <a href="#" onclick="deletecity('<?php echo $enc_str; ?>')" class="badge badge-danger"><i class="fa fa-remove"></i> Delete</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <tr>
                                        <td colspan="4" align="center">* City Not Found *</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <ul class="pagination pagination-without-border pull-left m-t-0">
                                <?php
                                $total = $qutotal;
                                $j1 = ceil($total / $per_page);
                                $next = ceil($total / $per_page);
                                $pagename="city.php?";
                                if($total){
                                    if(isset($_GET['page'])) {
                                        $pageval = $_GET['page'];
                                    }
                                    else{
                                        $pageval=1;
                                    }
                                    if ($pageval == 1)
                                    {
                                        ?>
                                        <li class="disabled">
                                            <a href="javascript:void(0)" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else
                                    {
                                        $prev = $pageval - 1;
                                        if(isset($_GET['search']))
                                        {
                                            ?>
                                            <li>
                                                <a href="<?php echo $pagename; ?>page=<?php echo $prev; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        else{
                                            ?>
                                            <li>
                                                <a href="<?php echo $pagename; ?>page=<?php echo $prev; ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    for ($i = 1; $i <= $j1; $i++) {
                                        if(isset($_GET['search'])) {

                                            if ($pageval == $i) {
                                                ?>
                                                <li class="active"><a href="#"><?php echo $i; ?><span
                                                            class="sr-only">(current)</span></a>
                                                </li>
                                                <?php
                                            } else {
                                                ?>
                                                <li><a href="<?php echo $pagename; ?>?page=<?php echo $i; ?>&search=<?php echo $_GET['search'];  ?>"><?php echo $i; ?><span
                                                            class="sr-only">(current)</span></a></li>
                                                <?php
                                            }
                                        }
                                        else{
                                            if ($pageval == $i) {
                                                ?>
                                                <li class="active"><a href="#"><?php echo $i; ?><span
                                                            class="sr-only">(current)</span></a>
                                                </li>
                                                <?php
                                            } else {
                                                ?>
                                                <li><a href="<?php echo $pagename; ?>page=<?php echo $i; ?>"><?php echo $i; ?><span
                                                            class="sr-only">(current)</span></a></li>
                                                <?php
                                            }
                                        }
                                    }
                                    if ($next == $pageval) {
                                        ?>
                                        <li class="disabled">
                                            <a href="javascript:void(0)"aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    else
                                    {
                                        $next1 = $pageval + 1;
                                        if(isset($_GET['search']))
                                        {
                                            ?>
                                            <li>
                                                <a href="<?php echo $pagename; ?>page=<?php echo $next1; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li>
                                                <a href="<?php echo $pagename; ?>page=<?php echo $next1; ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                                else
                                {
                                    ?>
                                    <li class="disabled">
                                        <a href="javascript:void(0)" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="disabled">
                                        <a href="javascript:void(0)" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="cmxform signupForm" id="signupForm" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="icon icon-list"></i> Add New City</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group form-animate-text">
                                <input class="form-text" type="text" name="cityname"  required >
                                <span class="bar"></span>
                                <label>City Name</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="addcity">Add City</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="specilitiesdetail">
            <div class="modal-dialog">
                <form class="cmxform" id="specilitits"  method="post" enctype="multipart/form-data">
                    <div class="modal-content" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="icon icon-list"></i> Edit City</h4>
                        </div>
                        <div class="modal-body" id="showspecilitiesdetail">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="updatecity">Update City</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function getcityname(id){
        $.ajax({
            type: "POST",
            url: "ajax/getcityname.php",
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
    function deletecity(id)
    {
        var x = confirm("Are you sure want to delete ?");
        if(x) {
            $.ajax({
                type: "POST",
                url: "ajax/deletecity.php",
                data: {querystring: id},
                cache: false,
                success: function (data)
                {
                    if (data == "True")
                    {
                        window.location='city.php';
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
            messages:
            {
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
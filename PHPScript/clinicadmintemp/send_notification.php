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
    ?>
    <div id="content">
        <div class="panel">
            <div class="panel-body">
                <div class="col-md-12 col-sm-12">
                    <h4 class="animated fadeInLeft"><i class="icon icon-list"></i> Notification</h4>
                    <div style="margin-top: -31px;padding-bottom: 6px;" class="animated fadeInRight" align="right"><a href="dashboard.php" class="badge badge-primary"><i class="fa fa-long-arrow-left"></i> Back</a></div>
                </div>
            </div>
        </div>

            <div class="col-md-2">
                <a href="#modal" data-toggle="modal" class="btn btn-primary" ><i class="icon icon-plus"></i> Send Notification</a>
            </div>


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
                                if(isset($_GET['sp_category']) && $_GET['sp_category'] != ""){
                                    $sp_id=$_GET['sp_category'];
                                    if (isset($_GET['search']))
                                    {
                                        $search = $_GET['search'];
                                        $qutotal = $admin->selectnoti($search, "searchtotal", "none", "none" ,$sp_id);
                                        $query = $admin->selectnoti($search, "search", $start, $per_page,$sp_id);
                                    }
                                    else
                                    {
                                        $query = $admin->selectnoti("none", "none", $start, $per_page,$sp_id);
                                        $qutotal = $admin->selectnoti("none", "total", "none", "none",$sp_id);
                                    }
                                }
                                else
                                {
                                    if (isset($_GET['search'])) {
                                        $search = $_GET['search'];
                                        $qutotal = $admin->selectnoti($search, "searchtotal", "none", "none","none");
                                        $query = $admin->selectnoti($search, "search", $start, $per_page,"none");
                                    } else {
                                        $query = $admin->selectnoti("none", "none", $start, $per_page,"none");
                                        $qutotal = $admin->selectnoti("none", "total", "none", "none","none");
                                    }
                                }?>

                        </div>


                        <div class="responsive-table col-md-12">
                            <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Message</th>
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
                                            <td><?php echo $res['message']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <tr>
                                        <td colspan="6" align="center">* Notification Message Not Found *</td>
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
                                if(isset($_GET['sp_category']) && $_GET['sp_category'] != ""){
                                    $pagename="send_notification.php?sp_category=".$_GET['sp_category']."&";
                                }
                                else{
                                    $pagename="send_notification.php?";
                                }
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
                                    } else {
                                        $next1 = $pageval + 1;
                                        if(isset($_GET['search'])) {
                                            ?>
                                            <li>
                                                <a href="<?php echo $pagename; ?>page=<?php echo $next1; ?>&search=<?php echo $_GET['search']; ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        else{
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
                                else{
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
                            <h4 class="modal-title"><i class="icon icon-list"></i> Notification Message</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group form-animate-text">
                                <input class="form-text" type="text" id="message" name="message"  required >
                                    <span class="bar"></span>
                                <label>Message</label>
                                <label for="textarea-input" class=" form-control-label">Message</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input id="submit" class="btn btn-primary btn-sm" onclick="myFunction()" type="button" name="submit" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        function myFunction() {
        var message = document.getElementById("message").value;
        // Returns successful data submission message when the entered information is stored in database.
        var dataString = 'message1=' + message;
        if (message == '') {
        alert("Please Fill The Message Fields");
        } else {
        // AJAX code to submit form.
        $.ajax({
        type: "POST",
        url: "ajax/insert_notify.php",
        data: dataString,
        cache: false,
            success: function(html) {
                if (html == 1) {
                alert("!!! Notification Sent !");
                } else {
                    alert("!!! Something went wrong !");
                }
            //alert(html);

            }
        });
        }
        return false;
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


</body>
</html>





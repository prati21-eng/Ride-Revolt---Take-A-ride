<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
	{
header('location:index.php');
}
else{
// Code for change password
if(isset($_POST['submit']))
{
$brand=$_POST['brand'];
$id=$_GET['id'];
$sql="update  tblbrands set BrandName=:brand where id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(':brand',$brand,PDO::PARAM_STR);
$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();

$msg="Brand updted successfully";

}
?>
            <!DOCTYPE HTML>
            <html lang="en">

            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width,initial-scale=1">
                <meta name="keywords" content="">
                <meta name="description" content="">
                <title>Ride Revolt- Take A Ride</title>
                <!--Bootstrap -->
                <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
                <!--Custome Style -->
                <link rel="stylesheet" href="assets/css/styles.css" type="text/css">
                <!--OWL Carousel slider-->
                <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
                <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
                <!--slick-slider -->
                <link href="assets/css/slick.css" rel="stylesheet">
                <!--bootstrap-slider -->
                <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
                <!--FontAwesome Font Style -->
                <link href="assets/css/font-awesome.min.css" rel="stylesheet">

                <!-- SWITCHER -->
                <link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
                <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all"
                    data-default-color="true" />
                <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
                <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
                <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
                <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
                <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />

                <!-- Fav and touch icons -->
                <link rel="apple-touch-icon-precomposed" sizes="144x144"
                    href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
                <link rel="apple-touch-icon-precomposed" sizes="114x114"
                    href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
                <link rel="apple-touch-icon-precomposed" sizes="72x72"
                    href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
                <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
                <link rel="shortcut icon" href="assets/images/favicon-icon/24x24.png">
                <!-- Google-Font-->
                <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
                <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
                <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
                <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
            </head>

            <body>

                <!-- Start Switcher -->
                <?php include('includes/colorswitcher.php'); ?>
                <!-- /Switcher -->

                <!--Header-->
                <?php include('includes/header.php'); ?>
                <!--Page Header-->
                <!-- /Header -->

                <!--Page Header-->
                <section class="page-header profile_page">
                    <div class="container">
                        <div class="page-header_wrap">
                            <div class="page-heading">
                                <h1>Brand</h1>
                            </div>
                            <ul class="coustom-breadcrumb">
                                <li><a href="#">Home</a></li>
                                <li>Brand</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Dark Overlay-->
                    <div class="dark-overlay"></div>
                </section>
                <!-- /Page Header-->
                <div class="ts-main-content">

                <div class="content-wrapper">
                <div class="container">

                    <div class="row justify-conent-center">
                        <div class="col-md-12">

                            <h2 class="page-title">Update Brand</h2>

                            <div class="row">
                                <div class="col-md-10">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Form fields</div>
                                        <div class="panel-body">
                                            <form method="post" name="chngpwd" class="form-horizontal" onSubmit="return valid();">


                        <?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Brand Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="brand" id="brand" required>
                                                    </div>
                                                </div>
                                                <div class="hr-dashed"></div>




                                                <div class="form-group">
                                                    <div class="col-sm-8 col-sm-offset-4">

                                                        <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                                    </div>
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
        </div>
                </div>
                <!--/my-vehicles-->
                <?php include('includes/footer.php'); ?>

                <!-- Scripts -->
                <script src="assets/js/jquery.min.js"></script>
                <script src="assets/js/bootstrap.min.js"></script>
                <script src="assets/js/interface.js"></script>
                <!--Switcher-->
                <script src="assets/switcher/js/switcher.js"></script>
                <!--bootstrap-slider-JS-->
                <script src="assets/js/bootstrap-slider.min.js"></script>
                <!--Slider-JS-->
                <script src="assets/js/slick.min.js"></script>
                <script src="assets/js/owl.carousel.min.js"></script>
            </body>

            </html>
<?php } ?>
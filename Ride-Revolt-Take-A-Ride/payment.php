<?php
session_start();
include('includes/config.php');
?>


<!DOCTYPE HTML>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <title>Ride Revolt-Make A Ride | Vehicle Details</title>
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
  <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
  <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
  <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
  <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
  <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
  <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="assets/images/favicon-icon/24x24.png">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
  <style>
    .rowpay {
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      margin: 0 -16px;
    }

    .col-25pay {
      -ms-flex: 25%;
      flex: 25%;
    }

    .col-50pay {
      -ms-flex: 50%;
      flex: 50%;
    }

    .col-75pay {
      -ms-flex: 75%;
      flex: 75%;
    }

    .col-25pay,
    .col-50pay,
    .col-75pay {
      padding: 0 16px;
    }

    .containerpay {
      background-color: #f2f2f2;
      padding: 5px 20px 15px 20px;
      border: 1px solid lightgrey;
      border-radius: 3px;
    }

    input[type=text].inputpay {
      width: 100%;
      margin-bottom: 20px;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    label.labelpay {
      margin-bottom: 10px;
      display: block;
    }

    .icon-containerpay {
      margin-bottom: 20px;
      padding: 7px 0;
      font-size: 24px;
    }

    .btnpay {
      background-color: #04AA6D;
      color: white;
      padding: 12px;
      margin: 10px 0;
      border: none;
      width: 100%;
      border-radius: 3px;
      cursor: pointer;
      font-size: 17px;
    }

    .btnpay:hover {
      background-color: #45a049;
    }

    span.pricepay {
      float: right;
      color: grey;
    }

    /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (and change the direction - make the "cart" column go on top) */
    @media (max-width: 800px) {
      .rowpay {
        flex-direction: column-reverse;
      }

      .col-25pay {
        margin-bottom: 20px;
      }
    }
  </style>
</head>

<body>

  <!-- Start Switcher -->
  <?php include('includes/colorswitcher.php'); ?>
  <!-- /Switcher -->

  <!--Header-->
  <?php include('includes/header.php'); ?>
  <!-- /Header -->
  <div class="container" style="margin-top: 30px;margin-bottom: 30px;">
    <div class="rowpay">
      <div class="col-75pay">
        <div class="containerpay">
          <form action="vehical-details.php?vhid=<?php echo $_POST['vhid'] ?>" method="post" class="formpay">
            <input type="text" name="fromdate" value="<?php echo $_POST['fromdate'] ?>" hidden>
            <input type="text" name="todate" value="<?php echo $_POST['todate'] ?>" hidden>
            <input type="text" name="message" value="<?php echo $_POST['message'] ?>" hidden>
            <div class="rowpay">
              <div class="col-50pay">
                <h3 class="headingpay">Billing Address</h3>
                <label for="fname" class="labelpay"><i class="fa fa-user iconpay"></i> Full Name</label>
                <input type="text" id="fname" name="firstname" placeholder="John M. Doe" class="inputpay">
                <label for="email" class="labelpay"><i class="fa fa-envelope iconpay"></i> Email</label>
                <input type="text" id="email" name="email" placeholder="john@example.com" class="inputpay">
                <label for="adr" class="labelpay"><i class="fa fa-address-card-o iconpay"></i> Address</label>
                <input type="text" id="adr" name="address" placeholder="542 W. 15th Street" class="inputpay">
                <label for="city" class="labelpay"><i class="fa fa-institution iconpay"></i> City</label>
                <input type="text" id="city" name="city" placeholder="New York" class="inputpay">
                <div class="rowpay">
                  <div class="col-50pay">
                    <label for="state" class="labelpay">State</label>
                    <input type="text" id="state" name="state" placeholder="NY" class="inputpay">
                  </div>
                  <div class="col-50pay">
                    <label for="zip" class="labelpay">Zip</label>
                    <input type="text" id="zip" name="zip" placeholder="10001" class="inputpay">
                  </div>
                </div>
              </div>
              <div class="col-50pay">
                <h3 class="headingpay">Payment</h3>
                <label for="fname" class="labelpay">Accepted Cards</label>
                <div class="icon-containerpay">
                  <i class="fa fa-cc-visa iconpay" style="color:navy;"></i>
                  <i class="fa fa-cc-amex iconpay" style="color:blue;"></i>
                  <i class="fa fa-cc-mastercard iconpay" style="color:red;"></i>
                  <i class="fa fa-cc-discover iconpay" style="color:orange;"></i>
                </div>
                <label for="cname" class="labelpay">Name on Card</label>
                <input type="text" id="cname" name="cardname" placeholder="John More Doe" class="inputpay">
                <label for="ccnum" class="labelpay">Credit card number</label>
                <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444" class="inputpay">
                <label for="expmonth" class="labelpay">Exp Month</label>
                <input type="text" id="expmonth" name="expmonth" placeholder="September" class="inputpay">
                <div class="rowpay">
                  <div class="col-50pay">
                    <label for="expyear" class="labelpay">Exp Year</label>
                    <input type="text" id="expyear" name="expyear" placeholder="2018" class="inputpay">
                  </div>
                  <div class="col-50pay">
                    <label for="cvv" class="labelpay">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="352" class="inputpay">
                  </div>
                </div>
              </div>
            </div>
            <label>
              <input type="checkbox" checked="checked" name="sameadr" class="checkboxpay"> Shipping address same as billing
            </label>
            <input type="submit" name="submit" value="Continue to checkout" class="btnpay">
          </form>
        </div>
      </div>

    </div>
  </div>
  <!--Footer -->
  <?php include('includes/footer.php'); ?>
  <!-- /Footer-->

  <!--Back to top-->
  <div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
  <!--/Back to top-->

  <!--Login-Form -->
  <?php include('includes/login.php'); ?>
  <!--/Login-Form -->

  <!--Register-Form -->
  <?php include('includes/registration.php'); ?>

  <!--/Register-Form -->

  <!--Forgot-password-Form -->
  <?php include('includes/forgotpassword.php'); ?>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/interface.js"></script>
  <script src="assets/switcher/js/switcher.js"></script>
  <script src="assets/js/bootstrap-slider.min.js"></script>
  <script src="assets/js/slick.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>

</body>

</html>
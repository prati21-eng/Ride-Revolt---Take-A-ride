<header>
  <div class="default-header">
    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-md-2">
          <div class="logo">
            <a href="index.php">
              <img src="assets/images/logo.jpg" alt="image" style="width: 200px; height: 50px;"/>
            </a>
          </div>
        </div>  
        <div class="col-sm-9 col-md-10">
          <div class="header_info">
            <div class="header_widgets">
              <div class="circle_icon">
                <i class="fa fa-envelope" aria-hidden="true"></i>
              </div>
              <p class="uppercase_text">For Support Mail us : </p>
              <a href="mailto:info@example.com">RideRevolt-TakeARide@gmail.com</a>
            </div>
            <div class="header_widgets">
              <div class="circle_icon">
                <i class="fa fa-phone" aria-hidden="true"></i>
              </div>
              <p class="uppercase_text">Service Helpline Call Us: </p>
              <a href="tel:61-1234-5678-09">+91-8856985713</a>
            </div>
            <div class="social-follow">
              <ul>
                <li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true" style="color: blue"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true" style="color: skyblue"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true" style="color: blue"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus-square" aria-hidden="true" style="color: blue"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram" aria-hidden="true" style="color :red"></i></a></li>
              </ul>
            </div>
            <?php if (strlen($_SESSION['login']) == 0) { ?>
              <div class="login_btn">
                <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login / Register</a>
              </div>
            <?php } else { 
              echo "Welcome To Ride Revolt-Make A Ride";
            } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Navigation -->
  <nav id="navigation_bar" class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button id="menu_slide" data-target="#navigation" aria-expanded="false" data-toggle="collapse"
          class="navbar-toggle collapsed" type="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div class="header_wrap">
        <?php
        $email = $_SESSION['login'];
        $sql = "SELECT id,FullName FROM tblusers WHERE EmailId=:email ";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        ?>

        <?php if ($_SESSION['login']) { ?>
          <div class="user_login">
            <ul>
              <li class="dropdown">
                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-user-circle" aria-hidden="true"></i>
                  <?php
                  if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                      echo htmlentities($result->FullName);
                      $_SESSION['user_id'] = $result->id;
                    }
                  }
                  ?>
                  <i class="fa fa-angle-down" aria-hidden="true"></i>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="my-booking.php">My Booking</a></li>
                  <li><a href="brand.php">Brand</a></li>
                  <li><a href="manage_brand.php">Manage Brand</a></li>
                  <li><a href="post-avehical.php">Post a Vehicle</a></li>
                  <li><a href="manage-vehicles.php">Manage Vehicles</a></li>
                  <li><a href="profile.php">Profile Settings</a></li>
                  <li><a href="update-password.php">Update Password</a></li>
                  <li><a href="logout.php">Sign Out</a></li>
                </ul>
              </li>
            </ul>
          </div>
        <?php } ?>

        <div class="header_search">
          <div id="search_toggle"><i class="fa fa-search" aria-hidden="true"></i></div>
          <form action="search.php" method="get" id="header-search-form">
            <input type="text" placeholder="Search City..." name="q" class="form-control">
            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
          </form>
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="page.php?type=aboutus">About Us</a></li>
          <li><a href="bike-listing.php">Bike Listing</a></li>
          <li><a href="page.php?type=faqs">FAQs</a></li>
          <li><a href="contact-us.php">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navigation end -->

</header>
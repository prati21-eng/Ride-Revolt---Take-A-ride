<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
	header('location:index.php');
} else {

	if (isset($_POST['submit'])) {
		$vehicletitle = $_POST['vehicletitle'];
		$city = $_POST['city'];
		$brand = $_POST['brandname'];
		$vehicleoverview = $_POST['vehicalorcview'];
		$priceperday = $_POST['priceperday'];
		$fueltype = $_POST['fueltype'];
		$modelyear = $_POST['modelyear'];
		$seatingcapacity = $_POST['seatingcapacity'];
		$vimage1 = $_FILES["img1"]["name"];
		$vimage2 = $_FILES["img2"]["name"];
		$vimage3 = $_FILES["img3"]["name"];
		$vimage4 = $_FILES["img4"]["name"];
		$vimage5 = $_FILES["img5"]["name"];
		$airconditioner = $_POST['airconditioner'];
		$powerdoorlocks = $_POST['powerdoorlocks'];
		$antilockbrakingsys = $_POST['antilockbrakingsys'];
		$brakeassist = $_POST['brakeassist'];
		$powersteering = $_POST['powersteering'];
		$driverairbag = $_POST['driverairbag'];
		$passengerairbag = $_POST['passengerairbag'];
		$powerwindow = $_POST['powerwindow'];
		$cdplayer = $_POST['cdplayer'];
		$centrallocking = $_POST['centrallocking'];
		$crashcensor = $_POST['crashcensor'];
		$leatherseats = $_POST['leatherseats'];
		move_uploaded_file($_FILES["img1"]["tmp_name"], "admin/img/vehicleimages/" . $_FILES["img1"]["name"]);
		move_uploaded_file($_FILES["img2"]["tmp_name"], "admin/img/vehicleimages/" . $_FILES["img2"]["name"]);
		move_uploaded_file($_FILES["img3"]["tmp_name"], "admin/img/vehicleimages/" . $_FILES["img3"]["name"]);
		move_uploaded_file($_FILES["img4"]["tmp_name"], "admin/img/vehicleimages/" . $_FILES["img4"]["name"]);
		move_uploaded_file($_FILES["img5"]["tmp_name"], "admin/img/vehicleimages/" . $_FILES["img5"]["name"]);

		$user_id = $_SESSION['user_id'];
		$sql = "INSERT INTO tblvehicles(user_id,VehiclesTitle,VehiclesBrand,VehiclesOverview,PricePerDay,FuelType,ModelYear,SeatingCapacity,Vimage1,Vimage2,Vimage3,Vimage4,Vimage5,AirConditioner,PowerDoorLocks,AntiLockBrakingSystem,BrakeAssist,PowerSteering,DriverAirbag,PassengerAirbag,PowerWindows,CDPlayer,CentralLocking,CrashSensor,LeatherSeats,city) VALUES(:user_id,:vehicletitle,:brand,:vehicleoverview,:priceperday,:fueltype,:modelyear,:seatingcapacity,:vimage1,:vimage2,:vimage3,:vimage4,:vimage5,:airconditioner,:powerdoorlocks,:antilockbrakingsys,:brakeassist,:powersteering,:driverairbag,:passengerairbag,:powerwindow,:cdplayer,:centrallocking,:crashcensor,:leatherseats,:city)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_STR);
		$query->bindParam(':vehicletitle', $vehicletitle, PDO::PARAM_STR);
		$query->bindParam(':brand', $brand, PDO::PARAM_STR);
		$query->bindParam(':vehicleoverview', $vehicleoverview, PDO::PARAM_STR);
		$query->bindParam(':priceperday', $priceperday, PDO::PARAM_STR);
		$query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
		$query->bindParam(':modelyear', $modelyear, PDO::PARAM_STR);
		$query->bindParam(':seatingcapacity', $seatingcapacity, PDO::PARAM_STR);
		$query->bindParam(':vimage1', $vimage1, PDO::PARAM_STR);
		$query->bindParam(':vimage2', $vimage2, PDO::PARAM_STR);
		$query->bindParam(':vimage3', $vimage3, PDO::PARAM_STR);
		$query->bindParam(':vimage4', $vimage4, PDO::PARAM_STR);
		$query->bindParam(':vimage5', $vimage5, PDO::PARAM_STR);
		$query->bindParam(':airconditioner', $airconditioner, PDO::PARAM_STR);
		$query->bindParam(':powerdoorlocks', $powerdoorlocks, PDO::PARAM_STR);
		$query->bindParam(':antilockbrakingsys', $antilockbrakingsys, PDO::PARAM_STR);
		$query->bindParam(':brakeassist', $brakeassist, PDO::PARAM_STR);
		$query->bindParam(':powersteering', $powersteering, PDO::PARAM_STR);
		$query->bindParam(':driverairbag', $driverairbag, PDO::PARAM_STR);
		$query->bindParam(':passengerairbag', $passengerairbag, PDO::PARAM_STR);
		$query->bindParam(':powerwindow', $powerwindow, PDO::PARAM_STR);
		$query->bindParam(':cdplayer', $cdplayer, PDO::PARAM_STR);
		$query->bindParam(':centrallocking', $centrallocking, PDO::PARAM_STR);
		$query->bindParam(':crashcensor', $crashcensor, PDO::PARAM_STR);
		$query->bindParam(':leatherseats', $leatherseats, PDO::PARAM_STR);
		$query->bindParam(':city', $city, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {
			$msg = "Vehicle posted successfully";
		} else {
			$error = "Something went wrong. Please try again";
		}
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
		<title>Ride Revolt-Make A Ride</title>
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
						<h1>Post A Vehicle</h1>
					</div>
					<ul class="coustom-breadcrumb">
						<li><a href="#">Home</a></li>
						<li>Post A Vehicle</li>
					</ul>
				</div>
			</div>
			<!-- Dark Overlay-->
			<div class="dark-overlay"></div>
		</section>
		<!-- /Page Header-->
		<div class="ts-main-content">

			<div class="content-wrapper">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">

							<div class="ts-main-content">
								<?php include('includes/leftbar.php'); ?>
								<div class="content-wrapper">
									<div class="container-fluid">

										<div class="row">
											<div class="col-md-12">

												<h2 class="page-title">Post A Vehicle <?php echo $_SESSION['fname']; ?></h2>

												<div class="row">
													<div class="col-md-12">
														<div class="panel panel-default">
															<div class="panel-heading">Basic Info</div>
															<?php if ($error) { ?>
																<div class="errorWrap"><strong>ERROR</strong>:
																	<?php echo htmlentities($error); ?>
																</div>
															<?php } else if ($msg) { ?>
																	<div class="succWrap"><strong>SUCCESS</strong>:
																	<?php echo htmlentities($msg); ?>
																	</div>
															<?php } ?>

															<div class="panel-body">
																<form method="post" class="form-horizontal"
																	enctype="multipart/form-data">
																	<div class="form-group">
																		<label class="col-sm-2 control-label">Vehicle
																			Title<span style="color:red">*</span></label>
																		<div class="col-sm-4">
																			<input type="text" name="vehicletitle"
																				class="form-control" required>
																		</div>
																		<label class="col-sm-2 control-label">Select
																			Brand<span style="color:red">*</span></label>
																		<div class="col-sm-4">
																			<select class="selectpicker" name="brandname"
																				required>
																				<option value=""> Select </option>
																				<?php $ret = "select id,BrandName from tblbrands";
																				$query = $dbh->prepare($ret);
																				//$query->bindParam(':id',$id, PDO::PARAM_STR);
																				$query->execute();
																				$results = $query->fetchAll(PDO::FETCH_OBJ);
																				if ($query->rowCount() > 0) {
																					foreach ($results as $result) {
																						?>
																						<option
																							value="<?php echo htmlentities($result->id); ?>">
																							<?php echo htmlentities($result->BrandName); ?>
																						</option>
																					<?php }
																				} ?>

																			</select>
																		</div>
																	</div>

																	<div class="hr-dashed"></div>
																	<div class="form-group">
																		<label class="col-sm-2 control-label">Vehical
																			Overview<span style="color:red">*</span></label>
																		<div class="col-sm-10">
																			<textarea class="form-control"
																				name="vehicalorcview" rows="3"
																				required></textarea>
																		</div>
																	</div>

																	<div class="hr-dashed"></div>
																	<div class="form-group">
																		<label class="col-sm-2 control-label">City<span
																				style="color:red">*</span></label>
																		<div class="col-sm-10">
																			<input class="form-control" name="city"
																				required></input>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-sm-2 control-label">Price Per
																			Day(in INR)<span
																				style="color:red">*</span></label>
																		<div class="col-sm-4">
																			<input type="text" name="priceperday"
																				class="form-control" required>
																		</div>
																		<label class="col-sm-2 control-label">Select Fuel
																			Type<span style="color:red">*</span></label>
																		<div class="col-sm-4">
																			<select class="selectpicker" name="fueltype"
																				required>
																				<option value=""> Select </option>

																				<option value="Petrol">Petrol</option>
																				<option value="Diesel">Diesel</option>
																				<option value="CNG">CNG</option>
																			</select>
																		</div>
																	</div>


																	<div class="form-group">
																		<label class="col-sm-2 control-label">Model
																			Year<span style="color:red">*</span></label>
																		<div class="col-sm-4">
																			<input type="text" name="modelyear"
																				class="form-control" required>
																		</div>
																		<label class="col-sm-2 control-label">Seating
																			Capacity<span style="color:red">*</span></label>
																		<div class="col-sm-4">
																			<input type="text" name="seatingcapacity"
																				class="form-control" required>
																		</div>
																	</div>
																	<div class="hr-dashed"></div>


																	<div class="form-group">
																		<div class="col-sm-12">
																			<h4><b>Upload Images</b></h4>
																		</div>
																	</div>


																	<div class="form-group">
																		<div class="col-sm-4">
																			Image 1 <span style="color:red">*</span><input
																				type="file" name="img1" required>
																		</div>
																		<div class="col-sm-4">
																			Image 2<span style="color:red">*</span><input
																				type="file" name="img2" required>
																		</div>
																		<div class="col-sm-4">
																			Image 3<span style="color:red">*</span><input
																				type="file" name="img3" required>
																		</div>
																	</div>


																	<div class="form-group">
																		<div class="col-sm-4">
																			Image 4<span style="color:red">*</span><input
																				type="file" name="img4" required>
																		</div>
																		<div class="col-sm-4">
																			Image 5<input type="file" name="img5">
																		</div>

																	</div>
																	<div class="hr-dashed"></div>
															</div>
														</div>
													</div>
												</div>

												<div class="contact_detail">

													<div class="row">
														<div class="col-md-12">
															<div class="panel panel-default">
																<div class="panel-heading">Accessories</div>
																<div class="panel-body" style="height: 150px;">

																	<div class="col-sm-3">
																		<div class="checkbox checkbox-inline">
																			<input type="checusdkbox"
																				id="antilockbrakingsys"
																				name="antilockbrakingsys" value="1">
																			<label for="antilockbrakingsys"> AntiLock
																				Braking System </label>
																		</div>
																	</div>
																	<div class="checkbox checkbox-inline">
																		<input type="checkbox" id="brakeassist"
																			name="brakeassist" value="1">
																		<label for="brakeassist"> Brake Assist </label>
																	</div>



																	<div class="form-group">
																		<div class="col-sm-3">
																			<div class="checkbox checkbox-inline">
																				<input type="checkbox" id="powersteering"
																					name="powersteering" value="1">
																				<input type="checkbox" id="powersteering"
																					name="powersteering" value="1">
																				<label for="inlineCheckbox5"> Smooth
																					Handling
																				</label>
																			</div>
																		</div>


																		<div class="col-sm-3">
																			<div class="checkbox h checkbox-inline">
																				<input type="checkbox" id="centrallocking"
																					name="centrallocking" value="1">
																				<label for="centrallocking">Central
																					Locking</label>
																			</div>
																		</div>
																		<div class="col-sm-3">
																			<div class="checkbox checkbox-inline">
																				<input type="checkbox" id="crashcensor"
																					name="crashcensor" value="1">
																				<label for="crashcensor"> Crash Sensor
																				</label>
																			</div>
																		</div>
																		<div class="col-sm-3">
																			<div class="checkbox checkbox-inline">
																				<input type="checkbox" id="leatherseats"
																					name="leatherseats" value="1">
																				<label for="leatherseats"> Leather Seats
																				</label>
																			</div>
																		</div>
																	</div>




																	<div class="form-group text-center"
																		style="margin-top: 50px;">
																		<div class="col-sm-8 ">
																			<button class="btn btn-default"
																				type="reset">Cancel</button>
																			<button class="btn btn-primary" name="submit"
																				type="submit">Save
																				changes</button>
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
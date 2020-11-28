<?php
$conn = mysqli_connect(
    'localhost',
    'root',
    'my7073319',
    'realestates',
    3307);
$query = "SELECT * from house";
$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>매물 리스트</title>
	<meta charset="UTF-8">
	
	<!-- Favicon -->
	<link href="img/favicon.ico" rel="shortcut icon"/>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,500i,600,600i,700,700i&display=swap" rel="stylesheet">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/magnific-popup.css"/>
	<link rel="stylesheet" href="css/slicknav.min.css"/>
	<link rel="stylesheet" href="css/owl.carousel.min.css"/>

	<!-- Main Stylesheets -->
	<link rel="stylesheet" href="css/style.css"/>


	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

	<!-- Header section  -->
	<header class="header-section hs-bd">
		<a href="list.php" class="site-logo"><img src="img/logo.png" alt="logo"></a>
		<div class="header-controls">
			<button class="nav-switch-btn"><i class="fa fa-bars"></i></button>
			<button class="search-btn"><i class="fa fa-search"></i></button>
		</div>
		<ul class="main-menu">
			<li><a href="list.php">Home</a></li>
			<li><a href="list.php">About the Artist </a></li>
			<li>
				<a href="list.php">Portfolio</a>
				<ul class="sub-menu">
					<li><a href="list.php">Portfolio 1</a></li>
					<li><a href="list.php">Portfolio 2</a></li>
					<li><a href="list.php">Portfolio 3</a></li>
				</ul>
			</li>
			<li><a href="list.php">Blog</a></li>
			<li><a href="list.php">Elements</a></li>
			<li><a href="list.php">Contact</a></li>
			<li class="search-mobile">
				<button class="search-btn"><i class="fa fa-search"></i></button>
			</li>
		</ul>
	</header>
	<div class="clearfix"></div>
	<!-- Header section end  -->

	<!-- Portfolio section  -->
	<div class="portfolio-section">
		<ul class="portfolio-filter controls text-center">
			<li class="control" data-filter="all">All</li>
			<li class="control" data-filter=".monthly">월세</li>
			<li class="control" data-filter=".jeonse">전세</li>
			<li class="control" data-filter=".sell">매매</li>
		</ul>                                                           
		<div class="row portfolio-gallery m-0">
			<?php
			while($row = mysqli_fetch_array($result)){
				$image_query = "SELECT image FROM image WHERE id=".$row['id'];
                $image_result = mysqli_query($conn,$image_query);
                $image_first = mysqli_fetch_array($image_result);
				switch($row['deal_type']){
					case 1:
						?>
						<div class="mix col-xl-2 col-md-3 col-sm-4 col-6 p-0 monthly">
							<?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $image_first['image'] ).'" class="portfolio-item img-popup set-bg"/>'; ?>
							<?php echo $row['title'];?>
						</div>
						<?php
					break;
					case 2:
						?>
						<div class="mix col-xl-2 col-md-3 col-sm-4 col-6 p-0 jeonse">
							<?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $image_first['image'] ).'" class="portfolio-item img-popup set-bg"/>'; ?>
							<?php echo $row['title'];?>
						</div>
						<?php
					break;
					case 3:
						?>
						<div class="mix col-xl-2 col-md-3 col-sm-4 col-6 p-0 sell">
							<?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $image_first['image'] ).'" class="portfolio-item img-popup set-bg"/>'; ?>
							<?php echo $row['title'];?>
						</div>
						<?php
					break;
				}
			}	
			?>
		</div>
	</div>
	<!-- Portfolio section end  -->
	
	

	<!-- Search model -->
	<div class="search-model">
		<div class="h-100 d-flex align-items-center justify-content-center">
			<div class="search-close-switch">+</div>
			<form class="search-model-form">
				<input type="text" id="search-input" placeholder="Search here.....">
			</form>
		</div>
	</div>
	<!-- Search model end -->

	<!--====== Javascripts & Jquery ======-->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.slicknav.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/circle-progress.min.js"></script>
	<script src="js/mixitup.min.js"></script>
	<script src="js/instafeed.min.js"></script>
	<script src="js/masonry.pkgd.min.js"></script>
	<script src="js/main.js"></script>

	</body>
</html>

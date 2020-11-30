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
	<link rel="stylesheet" href="css/list-style.css"/>


	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>

	<!-- Header section  -->
	<header class="header-section hs-bd">
		<a href="list.php" class="site-logo">다대포 공인중개사무소</a>
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
		<ul class="portfolio-filter controls text-center">
			<li class="control" data-filter=".allType">All</li>
			<li class="control" data-filter=".apartment">아파트</li>
			<li class="control" data-filter=".house">주택</li>
			<li class="control" data-filter=".oneRoom">원룸</li>
			<li class="control" data-filter=".office">오피스텔</li>
			<li class="control" data-filter=".building">건물</li>
			<li class="control" data-filter=".east">동향</li>
			<li class="control" data-filter=".west">서향</li>
			<li class="control" data-filter=".south">남향</li>
			<li class="control" data-filter=".north">북향</li>
		</ul>                                                           
		<div class="row portfolio-gallery m-0">
			<?php
			while($row = mysqli_fetch_array($result)){
				$image_query = "SELECT image FROM image WHERE id=".$row['id'];
                $image_result = mysqli_query($conn,$image_query);
				$image_first = mysqli_fetch_array($image_result);
				$classString = '"mix col-xl-2 col-md-3 col-sm-4 col-6 p-0';
				switch($row['deal_type']){
					case 1:
						$classString = $classString.' monthly';
					break;
					case 2:
						$classString = $classString.' jeonse';
					break;
					case 3:
						$classString = $classString.' sell';
					break;
				}
				$classString = $classString.' allType';
				switch($row['type']){
					case 1:
						$classString = $classString.' apartment';
					break;
					case 2:
						$classString = $classString.' house';
					break;
					case 3:
						$classString = $classString.' oneRoom';
					break;
					case 4:
						$classString = $classString.' office';
					break;
					case 5:
						$classString = $classString.' building';
					break;
				}
				switch($row['direction']){
					case 1:
						$classString = $classString.' east';
					break;
					case 2:
						$classString = $classString.' west';
					break;
					case 3:
						$classString = $classString.' south';
					break;
					case 4:
						$classString = $classString.' north';
					break;
				}
				$classString = $classString.' "';
				?>
				<div class=<?=$classString?>>
					<?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $image_first['image'] ).'" class="portfolio-item img-popup set-bg"/>'; ?>
					<?php echo $row['title'];?>
				</div>
				<?php
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
	<script src="js/list-main.js"></script>

	</body>
</html>

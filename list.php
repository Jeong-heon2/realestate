<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require('connection.php');
$appKey = file_get_contents("keys/appkey", true);

$query = "SELECT * from house";
$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>다대포 공인중개사무소</title>
	<meta charset="UTF-8">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/magnific-popup.css"/>
	<link rel="stylesheet" href="css/slicknav.min.css"/>
	<link rel="stylesheet" href="css/owl.carousel.min.css"/>

	<!-- Main Stylesheets -->
	<link rel="stylesheet" href="css/list-style.css"/>
</head>
<body>
<div class="box">
	<!-- Header section  -->
	<div class="row header" >
        <p>
            <span class="ui_logo">
				다대포 공인중개사무소&nbsp&nbsp051-266-7333
			</span>
			
			<a href="index.php" class="ui_map">
				지도로 돌아가기
			</a>

            <?php if(!isset($_SESSION['user_id'])) {?>
            <a href="login.php" class="ui_login">
                로그인
            </a>
            <?php } else {?>
                <a href="insert.php" style="color: red;" class="ui_login">
                    매물 등록
                </a>
            <?php
            } ?>
        </p>

    </div>
	<!-- Header section end  -->

	<div class="header2">
		<fieldset data-filter-group data-logic="and" class="portfolio-filter controls text-center">
		    <label>월세</label>
    		<input type="checkbox" value=".monthly"/>

    		<label>전세</label>
    		<input type="checkbox" value=".jeonse"/>

			<label>매매</label>
    		<input type="checkbox" value=".sell"/>

    		<label>아파트</label>
    		<input type="checkbox" value=".apartment"/>

			<label>주택</label>
    		<input type="checkbox" value=".house"/>

			<label>원룸</label>
    		<input type="checkbox" value=".oneRoom"/>
			
			<label>오피스텔</label>
    		<input type="checkbox" value=".office"/>

			<label>건물</label>
    		<input type="checkbox" value=".building"/>

			<label>동향</label>
    		<input type="checkbox" value=".east"/>

			<label>서향</label>
    		<input type="checkbox" value=".west"/>

			<label>남향</label>
    		<input type="checkbox" value=".south"/>

			<label>북향</label>
    		<input type="checkbox" value=".north"/>
		</fieldset>                
	</div>

	<!-- Portfolio section  -->
	<div class="portfolio-section">              
		<div class="row portfolio-gallery m-0">
			<?php
			while($row = mysqli_fetch_array($result)){
				$image_query = "SELECT image FROM image WHERE id=".$row['id'];
                $image_result = mysqli_query($conn,$image_query);
				$image_first = mysqli_fetch_array($image_result);
				$classString = '"mix col-xl-2 col-md-3 col-sm-4 col-6 p-0';
				$type = '';
				$direction = '';
				$dealType = '';
				$title = $row['title'];
				$price = '';
				$area_m2 = $row['area_m2'];
				$area_py = $row['area_py'];
				$memo = "";
        		if(isset($_SESSION['user_id'])){
		            $memo = $row['memo'];
		            $memo = str_replace("\r\n", "\\n", $memo);
		        }
				switch($row['deal_type']){
					case 1:
						$classString = $classString.' monthly';
						$dealType = "월세";
						$tmp = (int)$row['deposit'];
						$price = '보증금 ';
        				if ((int)($tmp/100000000) > 0){
				            //억 이상
        				    $price = $price.(int)($tmp/100000000)." 억 ";
				            $tmp = $tmp % 100000000;
				            if((int)($tmp/10000000) > 0) {
				                $price = $price.(int)($tmp / 10000000)." 천만 ";
				            }
				        }elseif ((int)($tmp/10000000) > 0){
				            //억 미만 천만 이상
    		    		    $price = $price.(int)($tmp/10000000)." 천 ";
				            $tmp = $tmp % 10000000;
				            if((int)($tmp/1000000)> 0) {
    				            $price = $price.(int)($tmp / 1000000)." 백만 ";
    				        }
    				    }else{
    				        //천만 미만
    				        if((int)($tmp/1000000) > 0){
    				            $price = $price.(int)($tmp/1000000)." 백 ";
    		 		           	$tmp = $tmp % 1000000;
    		 		           	if((int)($tmp/100000) > 0) {
    				                $price = $price.(int)($tmp / 100000)." 십만 ";
    				            }
    				        }else{
    				            $price = $price.(int)($tmp/100000)." 십만 ";
    				        }
						}
						$price .= '/ 월세가 ';
						$tmp = (int)$row['price'];
		        		if ((int)($tmp/100000000) > 0){
				            //억 이상
    		    		    $price = $price.(int)($tmp/100000000)." 억 ";
				            $tmp = $tmp % 100000000;
				            if((int)($tmp/10000000) > 0) {
				                $price = $price.(int)($tmp / 10000000)." 천만";
				            }
				        }elseif ((int)($tmp/10000000) > 0){
				            //억 미만 천만 이상
    		    		    $price = $price.(int)($tmp/10000000)." 천 ";
				            $tmp = $tmp % 10000000;
				            if((int)$tmp/1000000 > 0) {
    				            $price = $price.(int)($tmp / 1000000)." 백만";
    				        }
    				    }else{
    				        //천만 미만
    				        if((int)($tmp/1000000) > 0){
    				            $price = $price.(int)($tmp/1000000)." 백 ";
    		 		           	$tmp = $tmp % 1000000;
    		 		           	if((int)($tmp/100000) > 0) {
    				                $price = $price.(int)($tmp / 100000)." 십만";
    				            }
    				        }else{
    				            $price = $price.(int)($tmp/100000)." 십만";
    				        }
						}
					break;
					case 2:
						$classString = $classString.' jeonse';
						$dealType = "전세";
						$price .= '전세가 ';
						$tmp = (int)$row['price'];
		        		if ((int)($tmp/100000000) > 0){
				            //억 이상
    		    		    $price = $price.(int)($tmp/100000000)." 억 ";
				            $tmp = $tmp % 100000000;
				            if((int)($tmp/10000000) > 0) {
				                $price = $price.(int)($tmp / 10000000)." 천만";
				            }
				        }elseif ((int)($tmp/10000000) > 0){
				            //억 미만 천만 이상
    		    		    $price = $price.(int)($tmp/10000000)." 천 ";
				            $tmp = $tmp % 10000000;
				            if((int)$tmp/1000000 > 0) {
    				            $price = $price.(int)($tmp / 1000000)." 백만";
    				        }
    				    }else{
    				        //천만 미만
    				        if((int)($tmp/1000000) > 0){
    				            $price = $price.(int)($tmp/1000000)." 백 ";
    		 		           	$tmp = $tmp % 1000000;
    		 		           	if((int)($tmp/100000) > 0) {
    				                $price = $price.(int)($tmp / 100000)." 십만";
    				            }
    				        }else{
    				            $price = $price.(int)($tmp/100000)." 십만";
    				        }
						}
					break;
					case 3:
						$classString = $classString.' sell';
						$dealType = "매매";
						$price .= '매매가 ';
						$tmp = (int)$row['price'];
		        		if ((int)($tmp/100000000) > 0){
				            //억 이상
    		    		    $price = $price.(int)($tmp/100000000)." 억 ";
				            $tmp = $tmp % 100000000;
				            if((int)($tmp/10000000) > 0) {
				                $price = $price.(int)($tmp / 10000000)." 천만";
				            }
				        }elseif ((int)($tmp/10000000) > 0){
				            //억 미만 천만 이상
    		    		    $price = $price.(int)($tmp/10000000)." 천 ";
				            $tmp = $tmp % 10000000;
				            if((int)$tmp/1000000 > 0) {
    				            $price = $price.(int)($tmp / 1000000)." 백만";
    				        }
    				    }else{
    				        //천만 미만
    				        if((int)($tmp/1000000) > 0){
    				            $price = $price.(int)($tmp/1000000)." 백 ";
    		 		           	$tmp = $tmp % 1000000;
    		 		           	if((int)($tmp/100000) > 0) {
    				                $price = $price.(int)($tmp / 100000)." 십만";
    				            }
    				        }else{
    				            $price = $price.(int)($tmp/100000)." 십만";
    				        }
						}
					break;
				}
				switch($row['type']){
					case 1:
						$classString = $classString.' apartment';
						$type = "아파트";
					break;
					case 2:
						$classString = $classString.' house';
						$type = "주택";
					break;
					case 3:
						$classString = $classString.' oneRoom';
						$type = "원룸";
					break;
					case 4:
						$classString = $classString.' office';
						$type = "오피스텔";
					break;
					case 5:
						$classString = $classString.' building';
						$type = "건물";
					break;
				}
				switch($row['direction']){
					case 1:
						$classString = $classString.' east';
						$direction = "동향";
					break;
					case 2:
						$classString = $classString.' west';
						$direction = "서향";
					break;
					case 3:
						$classString = $classString.' south';
						$direction = "남향";
					break;
					case 4:
						$classString = $classString.' north';
						$direction = "북향";
					break;
				}
				$classString .= ' '.$row['title'];
				$classString = $classString.' "';
				$popup = 'popup'.$row['id'];
				?>
				<div id="<?=$popup?>" class="white-popup mfp-hide">
					<div id="popup-header"><span id="popup-title">제목 : <?=$title?></span><span id="popup-id">매물 번호 : <?=$row['id']?></span></div>
					<div id="popup-deal"><span id="popup-type">&middot종류 : <?=$type?></span><span id="popup-dealType">&middot거래 : <?=$dealType?></span><span id="popup-price">&middot가격 : <?=$price?></span></div>
					<div id="popup-detail"><span id="popup-address">&middot주소 : <?=$row['address']?></span><span id="popup-area">&middot면적 : <?=$area_m2?> m<sup>2</sup> / <?=$area_py?> 평</span><span id="popup-dir">&middot방향 : <?=$direction?></span></div>
					<div id="popup-exp"><span id="popup-explan">&middot설명</span><div id="explanation"><?=$row['explanation']?></div></div>
					<?php
					if(isset($_SESSION['user_id'])){
						?>
						<div id="popup-memo"><span id="popup-memo2">&middot메모 : <?=$row['memo']?></span></div>
						<?php
					}
					$image_query2 = "SELECT image FROM image WHERE id=".$row['id'];
                	$image_result2 = mysqli_query($conn,$image_query);
					while($image=mysqli_fetch_array($image_result2)){
						?>
						<div id="line-div"><pre></div>
						<div id="line-div"><pre></div>
						<img src="data:image/jpeg;base64,<?=base64_encode( $image['image'] )?>"/>
						<?php
					}
					?>
				</div>
				<?php $popup = '#'.$popup; ?>
				<div class=<?=$classString?>>
					<img src="data:image/jpeg;base64,<?=base64_encode( $image_first['image'] )?>" class="portfolio-item popup set-bg" href="<?=$popup?>"/>
					<div id="inf_type" class="popup" href="<?=$popup?>"><span id="inf_dealType"><?=$dealType?></span><span id="type"><?=$type?></span><span id="inf_dir"><?=$direction?></span><span id="inf_area"><?=$area_m2?> m<sup>2</sup> / <?=$area_py?> 평</span></div>
					<div id="inf_title" class="popup" href="<?=$popup?>"><?=$title?></div>
					<div id="inf_price" class="popup" href="<?=$popup?>"><?=$price?></div>
				</div>
				<?php
			}	
			?>
		</div>
	</div>
	<!-- Portfolio section end  -->	

	<!--====== Javascripts & Jquery ======-->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.slicknav.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/circle-progress.min.js"></script>
	<script src="js/mixitup.min.js"></script>
	<script src="js/mixitup-multifilter.min.js"></script>
	<script src="js/instafeed.min.js"></script>
	<script src="js/masonry.pkgd.min.js"></script>
	<script src="js/list-main.js"></script>

	</body>
</div>
</html>

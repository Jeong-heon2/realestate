<?php
header('Content-Type: text/html; charset=utf-8');
require('connection.php');
$appKey = file_get_contents("keys/appkey", true);

$sql = "SELECT * FROM house";
$result = mysqli_query($conn, $sql);
$list = '';


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>마커 생성하기</title>
    <link rel="stylesheet" type="text/css" href="css/main_map.css?">
</head>
<body >
<div class="box">
    <div class="row header" >
        <p>
            <span class="ui_logo">
                다대포 공인중개사
            </span>
            <a href="login.html" class="ui_login">
                로그인
            </a>
        </p>

    </div>
    <div class="row header2">
        <span class="search_section">
            <form>
                <input type="text" name="search_arg" placeholder="검색어 입력" class="search">
                <input type="submit">
            </form>
        </span>
    </div>
    <div class="row map">
        <div id="detail">
            ff
        </div>
        <div id="map"></div>

    </div>

    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?=$appKey?>"></script>
    <script>
        var mapContainer = document.getElementById('map'), // 지도를 표시할 div
            mapOption = {
                center: new kakao.maps.LatLng(35.0510087, 128.9677272), // 지도의 중심좌표
                level: 5 // 지도의 확대 레벨
            };

        var map = new kakao.maps.Map(mapContainer, mapOption); // 지도를 생성합니다
        var lat;
        var long;
        var markerPosition;
        var content;
        var title;
        var customOverlay;
        // 검색 결과 목록이나 마커를 클릭했을 때 장소명을 표출할 인포윈도우를 생성합니다
        var infowindow = new kakao.maps.InfoWindow({zIndex:1});
        <?php
        while($row = mysqli_fetch_array($result)) {

        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
        $price = $row['price'];
        ?>
        // 마커가 표시될 위치입니다
        lat = <?=$latitude?>;
        long = <?=$longitude?>;
        price = "<?=$price?>";
        markerPosition  = new kakao.maps.LatLng(lat, long);

        // 마커를 생성합니다
        marker = new kakao.maps.Marker({
            position: markerPosition
        });
        // 커스텀 오버레이에 표시할 내용입니다
        // HTML 문자열 또는 Dom Element 입니다
        var content = '<div class="customoverlay">' +
            '  <a onclick="display_detail();"  target="_blank">' +
            '    <span class="title">'+price+'</span>' +
            '  </a>' +
            '</div>';



        // 커스텀 오버레이를 생성합니다
        var customOverlay = new kakao.maps.CustomOverlay({
            position: markerPosition,
            content: content,
            yAnchor: 1
        });


        // 커스텀 오버레이를 지도에 표시합니다
        customOverlay.setMap(map);

        // 마커가 지도 위에 표시되도록 설정합니다
        marker.setMap(map);

        // 아래 코드는 지도 위의 마커를 제거하는 코드입니다
        // marker.setMap(null);
        <?php
        }
        ?>
        // 지도에 클릭 이벤트를 등록합니다
        // 지도를 클릭하면 마지막 파라미터로 넘어온 함수를 호출합니다
        kakao.maps.event.addListener(map, 'click', function(mouseEvent) {
            document.getElementById('detail').style.display = 'none';


        });
        function display_detail(){
            document.getElementById('detail').style.display = 'block';
        }

    </script>
</div>

</body>
</html>

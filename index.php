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

</head>
<body>
<div id="map" style="width:100%;height:500px;"></div>

<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?=$appKey?>"></script>
<script>
    var mapContainer = document.getElementById('map'), // 지도를 표시할 div
        mapOption = {
            center: new kakao.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
            level: 10 // 지도의 확대 레벨
        };

    var map = new kakao.maps.Map(mapContainer, mapOption); // 지도를 생성합니다
    var lat;
    var long;
    var markerPosition;
    <?php
    while($row = mysqli_fetch_array($result)) {

        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
        ?>
        // 마커가 표시될 위치입니다
        lat = <?=$latitude?>;
        long = <?=$longitude?>;
        markerPosition  = new kakao.maps.LatLng(lat, long);

        // 마커를 생성합니다
        marker = new kakao.maps.Marker({
            position: markerPosition
        });

        // 마커가 지도 위에 표시되도록 설정합니다
        marker.setMap(map);

        // 아래 코드는 지도 위의 마커를 제거하는 코드입니다
        // marker.setMap(null);
    <?php
    }
    ?>

</script>
</body>
</html>

<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('세션이 만료되었습니다. 다시 로그인 해주세요');";
    echo "window.location.replace('login.php');</script>";
    exit;
}

$appKey = file_get_contents("keys/appkey", true);

require('connection.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM house where id = ".$id;
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
        $arr = array(
            'title'=>$row['title'],
            'id'=>$row['id'],
            'price'=>$row['price'],
            'area_m2'=>$row['area_m2'],
            'area_py'=>$row['area_py'],
            'address'=>$row['address'],
            'address_detail'=>$row['address_detail'],
            'latitude'=>$row['latitude'],
            'longitude'=>$row['longitude'],
            'direction'=>$row['direction'],
            'deal_type'=>$row['deal_type'],
            'type'=>$row['type'],
            'explanation'=>$row['explanation'],
            'memo'=>$row['memo'],
        );
    }
}else{
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('잘못된 접근입니다. ');";
    echo "window.location.replace('index.php');</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>매물 수정</title>

    <link rel="stylesheet" type="text/css" href="css/insert_form.css">


</head>
<body>
<h1>매물 수정하기</h1>

<div id="map" style="width:100%;height:350px;"></div>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?=$appKey?>&libraries=services"></script>
<script type="text/javascript" >
    var marker;
    var mapContainer = document.getElementById('map'), // 지도를 표시할 div
        mapOption = {
            center: new kakao.maps.LatLng(<?=$arr['latitude']?>, <?=$arr['longitude']?>), // 지도의 중심좌표
            level: 3 // 지도의 확대 레벨
        };

    // 지도를 생성합니다
    var map = new kakao.maps.Map(mapContainer, mapOption);
    var coords = new kakao.maps.LatLng(<?=$arr['latitude']?>, <?=$arr['longitude']?>);
    // 결과값으로 받은 위치를 마커로 표시합니다
    marker = new kakao.maps.Marker({
        map: map,
        position: coords
    });
    // 인포윈도우로 장소에 대한 설명을 표시합니다
    var infowindow = new kakao.maps.InfoWindow({
        content: '<div style="width:150px;text-align:center;padding:6px 0;"><?=$arr['address']?></div>'
    });
    infowindow.open(map, marker);

</script>

<form action="process_update.php" method="post" enctype="multipart/form-data">
    <div id="form-div">
        <form class="form" id="form1">
            <input type="hidden" name="old_id" value="<?=$id?>">
            제목
            <p class="name">
                <input name="title" type="text" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="매물 이름" id="name" value="<?=$arr['title']?>"/>
            </p>
            매물 번호
            <p class="name">
                <input name="id" type="number" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="매물 번호" id="id" value="<?=$arr['id']?>" />
            </p>
            가격
            <p class="name">
                <input name="price" type="number" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="가격" id="price" value="<?=$arr['price']?>"/>
            </p>
            면적
            <p class="name">
                <label>
                    <input name="area_m2" type="number" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="면적 m^2" id="area_m2" value="<?=$arr['area_m2']?>"/>
                    <input name="area_py" type="number" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="면적 평수" id="area_py" value="<?=$arr['area_py']?>"/>
                </label>

            </p>
            주소
            <p class="insert_address">
                <input name="address" type="text" class="validate[required,custom[address]] feedback-input" id="address" placeholder="주소" value="<?=$arr['address']?>"/>
            </p>
            <button type="button" id="popup_open_btn" style="font-size: 25px" onclick="searchAddress();">주소 찾기</button>
            <script type="text/javascript">


                function searchAddress(){
                    // 주소로 좌표를 검색합니다
                    let val = document.getElementById('address').value;
                    // 주소-좌표 변환 객체를 생성합니다
                    var geocoder = new kakao.maps.services.Geocoder();
                    geocoder.addressSearch(val, function(result, status) {

                        // 정상적으로 검색이 완료됐으면
                        if (status === kakao.maps.services.Status.OK) {
                            if(marker !== undefined ){
                                marker.setMap(null);
                            }
                            var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

                            // 결과값으로 받은 위치를 마커로 표시합니다
                            marker = new kakao.maps.Marker({
                                map: map,
                                position: coords
                            });

                            // 인포윈도우로 장소에 대한 설명을 표시합니다
                            var infowindow = new kakao.maps.InfoWindow({
                                content: '<div style="width:150px;text-align:center;padding:6px 0;">'+val+'</div>'
                            });
                            infowindow.open(map, marker);

                            // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                            map.setCenter(coords);

                            document.getElementById("insert_address_detail").style.display = 'inline';
                            document.getElementById("latitude").value = result[0].y;
                            document.getElementById("longitude").value = result[0].x;

                        }else{
                            alert("올바른 주소를 입력해주세요");
                            document.getElementById("insert_address_detail").style.display = 'none';
                        }
                    });
                }
            </script>
            <p>
                <input name="address_detail" type="text" class="validate[required,custom[address]] feedback-input" placeholder="상세 주소" value="<?=$arr['address_detail']?>"/>
            </p>
            <input type="hidden" name="latitude" id="latitude" value="<?=$arr['latitude']?>">
            <input type="hidden" name="longitude" id="longitude"  value="<?=$arr['longitude']?>">
            <p>
                <label>
                    <select id="select_dir" name="direction" style="font-size: 20px">
                        <option value="3">남향</option>
                        <option value="4">북향</option>
                        <option value="2">서향</option>
                        <option value="1">동향</option>
                    </select>
                    <select id="select_dealType" name="deal_type" style="font-size: 20px">
                        <option value="3">매매</option>
                        <option value="2">전세</option>
                        <option value="1">월세</option>
                    </select>
                    <select id="select_type" name="type" style="font-size: 20px">
                        <option value="1">아파트</option>
                        <option value="2">주택</option>
                        <option value="3">원룸</option>
                        <option value="4">오피스텔</option>
                        <option value="5">건물</option>
                    </select>
                </label>

            </p>
            <p></p>세부정보
            <p class="text">
                <textarea name="explanation" class="validate[required,length[6,300]] feedback-input" id="comment" placeholder="more info"><?=$arr['explanation']?></textarea>
            </p>
            메모
            <p class="text">
                <textarea name="memo" class="validate[required,length[6,300]] feedback-input" id="comment" placeholder="memo"><?=$arr['memo']?></textarea>
            </p>
            이미지 추가하기
            <p>
                <input type="file" name="upload[]" accept="image/*" style="font-size: 25px" multiple>
            </p>


            <div class="submit">
                <input type="submit" class="btn" value="SEND">
            </div>
        </form>
    </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    // value 값으로 선택
    $("#select_type").val("<?=$arr['type']?>").prop("selected", true);
    $("#select_dealType").val("<?=$arr['deal_type']?>").prop("selected", true);
    $("#select_dir").val("<?=$arr['direction']?>").prop("selected", true);
</script>
</body>
</html>
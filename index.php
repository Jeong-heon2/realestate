<?php
header('Content-Type: text/html; charset=utf-8');
require('connection.php');
$appKey = file_get_contents("keys/appkey", true);

$sql = "SELECT * FROM house";
$result = mysqli_query($conn, $sql);

$sql2 = "select id, image_id from image";
$img_res = mysqli_query($conn, $sql2);


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>다대포 공인중개사무소</title>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/main_map.css?">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>
<body >
<div class="box">
    <div class="row header" >
        <p>
            <span class="ui_logo">
                다대포 공인중개사무소
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
            <div id="wrapper">
                <div id="slider-wrap">

                </div>


            </div>
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
        var id;
        // 검색 결과 목록이나 마커를 클릭했을 때 장소명을 표출할 인포윈도우를 생성합니다
        var infowindow = new kakao.maps.InfoWindow({zIndex:1});
        <?php
        while($row = mysqli_fetch_array($result)) {

        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
        $price = $row['price'];
        $id = $row['id'];
        ?>
        // 마커가 표시될 위치입니다
        lat = <?=$latitude?>;
        long = <?=$longitude?>;
        price = "<?=$price?>";
        id = "<?=$id?>";
        markerPosition  = new kakao.maps.LatLng(lat, long);

        // 마커를 생성합니다
        marker = new kakao.maps.Marker({
            position: markerPosition
        });
        // 커스텀 오버레이에 표시할 내용입니다
        // HTML 문자열 또는 Dom Element 입니다
        var content = '<div class="customoverlay">' +
            '  <a onclick="display_detail(\'' + id + '\');"  target="_blank">' +
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
        function display_detail(id){
            document.getElementById('detail').style.display = 'block';
            var getId;
            $('#slider-wrap *').remove();
            var img_exist = false;
            var cnt = 0;
            <?php
            while($row = mysqli_fetch_array($img_res)) {
                $hid = $row['id'];
            ?>
                getId = <?=$hid?>;
                if(getId == id){
                    if(!img_exist){
                        var $ul = $("<ul>", {id: "slider"});
                        $("#slider-wrap").append($ul);
                        img_exist = true;
                    }
                    $('#slider').append($('<li><img src="imageView.php?image_id=<?php echo $row["image_id"]; ?>"></li>'));
                    cnt++;
                }

            <?php
            }
            ?>
            if(img_exist){
                var wrap = $('#slider-wrap');
                wrap.append($('<div class="btns" id="next"><i class="fa fa-arrow-right"></i></div>'));
                wrap.append($('<div class="btns" id="previous"><i class="fa fa-arrow-left"></i></div>'));
                wrap.append($('<div id="counter"></div>'));
                wrap.append($('<div id="pagination-wrap"></div>'));
                $('#pagination-wrap').append($('<ul></ul>'));


                //current position
                var pos = 0;
                //number of slides
                var totalSlides = $('#slider-wrap ul li').length;
                //get the slide width
                var sliderWidth = $('#slider-wrap').width();

                /*****************
                 BUILD THE SLIDER
                 *****************/
                //set width to be 'x' times the number of slides
                $('#slider-wrap ul#slider').width(sliderWidth*totalSlides);

                //next slide
                $('#next').click(function(){
                    slideRight();
                });

                //previous slide
                $('#previous').click(function(){
                    slideLeft();
                });



                /*************************
                 //*> OPTIONAL SETTINGS
                 ************************/
                    //automatic slider
                var autoSlider = setInterval(slideRight, 3000);

                //for each slide
                $.each($('#slider-wrap ul li'), function() {

                    //create a pagination
                    var li = document.createElement('li');
                    $('#pagination-wrap ul').append(li);
                });

                //counter
                countSlides();

                //pagination
                pagination();

                //hide/show controls/btns when hover
                //pause automatic slide when hover
                $('#slider-wrap').hover(
                    function(){ $(this).addClass('active'); clearInterval(autoSlider); },
                    function(){ $(this).removeClass('active'); autoSlider = setInterval(slideRight, 3000); }
                );
                /***********
                 SLIDE LEFT
                 ************/
                function slideLeft(){
                    pos--;
                    if(pos==-1){ pos = totalSlides-1; }
                    $('#slider-wrap ul#slider').css('left', -(sliderWidth*pos));

                    //*> optional
                    countSlides();
                    pagination();
                }


                /************
                 SLIDE RIGHT
                 *************/
                function slideRight(){
                    pos++;
                    if(pos==totalSlides){ pos = 0; }
                    $('#slider-wrap ul#slider').css('left', -(sliderWidth*pos));

                    //*> optional
                    countSlides();
                    pagination();
                }




                /************************
                 //*> OPTIONAL SETTINGS
                 ************************/
                function countSlides(){
                    $('#counter').html(pos+1 + ' / ' + totalSlides);
                }

                function pagination(){
                    $('#pagination-wrap ul li').removeClass('active');
                    $('#pagination-wrap ul li:eq('+pos+')').addClass('active');
                }
            }
        }

    </script>
</div>

</body>
</html>

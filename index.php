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
    <link rel="stylesheet" type="text/css" href="css/main_map.css">
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

        </div>
        <div id="map"></div>

    </div>

    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?=$appKey?>"></script>
    <script>
        var autoSlider;
        //current position
        var pos = 0;
        //number of slides
        var totalSlides;
        //get the slide width
        var sliderWidth;
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
        var dealType;
        var type;
        var direction;
        var exp;
        var area_m2;
        var area_py;
        // 검색 결과 목록이나 마커를 클릭했을 때 장소명을 표출할 인포윈도우를 생성합니다
        var infowindow = new kakao.maps.InfoWindow({zIndex:1});
        <?php
        while($row = mysqli_fetch_array($result)) {

        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
        $price = $row['price'];
        $id = $row['id'];
        $dealType = $row['deal_type'];
        $title = $row['title'];
        $direction = $row['direction'];
        $exp = $row['explanation'];
        $exp = str_replace("\r\n", "\\n", $exp);
        $type = $row['type'];
        $area_m2 = $row['area_m2'];
        $area_py = $row['area_py'];
        ?>

        lat = <?=$latitude?>;
        long = <?=$longitude?>;
        price = "<?=$price?>";
        id = "<?=$id?>";
        dealType = "<?=$dealType?>";
        title = "<?=$title?>";
        type = "<?=$type?>";
        direction = "<?=$direction?>";
        exp = '<?php echo $exp?>';
        exp = exp.replace(/\n/gi,'\\\\n');
        area_m2 = "<?=$area_m2?>";
        area_py = "<?=$area_py?>";
        // 마커가 표시될 위치입니다
        markerPosition  = new kakao.maps.LatLng(lat, long);


        var tmp = parseInt(price);
        if (tmp/100000000 > 0){
            //억 이상
            price = parseInt(tmp/100000000) + " 억 ";
            tmp = tmp % 100000000;
            if(tmp/10000000 > 0) {
                price += parseInt(tmp / 10000000) + " 천만";
            }
        }else if (tmp/10000000 > 0){
            //억 미만 천만 이상
            price = parseInt(tmp/10000000) + " 천 ";
            tmp = tmp % 10000000;
            if(tmp/1000000 > 0) {
                price += parseInt(tmp / 1000000) + " 백만";
            }
        }else{
            //천만 미만
            if(tmp/1000000 > 0){
                price = parseInt(tmp/1000000) + " 백 ";
                tmp = tmp % 1000000;
                if(tmp/100000 > 0) {
                    price += parseInt(tmp / 100000) + " 십만";
                }
            }else{
                price = parseInt(tmp/100000) + " 십만";
            }
        }


        // 마커를 생성합니다
        marker = new kakao.maps.Marker({
            position: markerPosition
        });
        // 커스텀 오버레이에 표시할 내용입니다
        // HTML 문자열 또는 Dom Element 입니다
        var content = '<div class="customoverlay">' +
            '  <a onclick="display_detail('+ '\'' + id + '\', ' + '\'' + price + '\', '  + '\'' + title + '\', '  + '\'' + type + '\', ' + '\'' + direction + '\', ' + '\'' + dealType + '\', ' + '\'' + exp + '\', ' + '\'' + area_m2 + '\', ' + '\'' + area_py + '\', ' +
            ');"  target="_blank">' +
            '     <span class="title">'+price+'</span>' +
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
            if(autoSlider !== undefined){
                clearInterval(autoSlider);
            }
        });
        function display_detail(id, price, title, type, direction, dealType, exp, area_m2, area_py){
            document.getElementById('detail').style.display = 'block';
            clearInterval(autoSlider);
            var getId;
            $('#detail *').remove();
            var img_exist = false;
            var cnt = 0;
            <?php
            while($row = mysqli_fetch_array($img_res)) {
                $hid = $row['id'];
            ?>
                getId = <?=$hid?>;
                if(getId == id){
                    if(!img_exist){
                        $('#detail').append($('<div id="wrapper"></div>'));
                        $('#wrapper').append($('<div id="slider-wrap"></div>'));
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
                pos = 0;
                //number of slides
                totalSlides = $('#slider-wrap ul li').length;
                //get the slide width
                sliderWidth = $('#slider-wrap').width();

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
                autoSlider = setInterval(slideRight, 3000);

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

            }
            /*   detail   */
            $('#detail').append($('<div id="info"></div>'));
            //type 12345 아파트 주택 원룸 오피스텔 건물
            if(type == "1"){
                type = "아파트";
            }else if(type == "2"){
                type = "주택";
            }else if(type == "3"){
                type = "원룸";
            }else if(type == "4"){
                type = "오피스텔";
            }else if(type == "5"){
                type = "건물";
            }
            //direction 1234 동서남북
            if(direction == "1"){
                direction = "동향";
            }else if(direction == "2"){
                direction = "서향";
            }else if(direction == "3"){
                direction = "남향";
            }else if(direction == "4"){
                direction = "북향";
            }
            //dealtype 123 월전매
            if(dealType == "1"){
                dealType = "월세";
            }else if(dealType == "2"){
                dealType = "전세";
            }else if(dealType == "3"){
                dealType = "매매";
            }
            price = dealType + "&nbsp&nbsp&nbsp" + price;
            exp = exp.replace(/\\n/gi,'<br>');

            $('#info').append($('<div id="inf_type"><span id="type">'+type+'</span><span id="inf_dir">'+ direction+'</span><span id="inf_area">'+area_m2+' m<sup>2</sup> / '+ area_py+ ' 평</span></div>'));
            $('#info').append($('<div id="inf_title">'+title+'</div>'));
            $('#info').append($('<div id="inf_price">'+price+'</div>'));
            $('#info').append($('<div id="inf_exp">'+exp+'</div>'));
        }

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

    </script>
</div>

</body>
</html>

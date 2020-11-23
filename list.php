<?php
$conn = mysqli_connect(
    'localhost',
    'root',
    'my7073319',
    'realestates',
    3307);
$query1 = "SELECT * from house where deal_type = 1";
$query2 = "SELECT * from house where deal_type = 2";
$query3 = "SELECT * from house where deal_type = 3";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>매물 리스트</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
                
            //검색하고 나서 결과를 보여줄때 검색 조건을 그대로 노출
            if("${dealType}" == 1){ //dealType 이 월세 일 경우 셋팅
                //라디오 버튼 값으로 선택
                $('input:radio[name="dealType"][value=1]').prop('checked', true);
                $( "#jeonse" ).hide();
                $( "#sell" ).hide();
                $( "#monthly" ).show();
            }
            
            //라디오 버튼 변경시 이벤트
            $("input[name='dealType']:radio").change(function () {
                     //라디오 버튼 값을 가져온다.
                    var dealType = this.value;
                                    
                    if(dealType == 1){
                        $( "#jeonse" ).hide();
                        $( "#sell" ).hide();
                        $( "#monthly" ).show();
                    }else if(dealType == 2){
                        $( "#jeonse" ).show();
                        $( "#sell" ).hide();
                        $( "#monthly" ).hide();
                    }else if(dealType == 3) {
                        $( "#jeonse" ).hide();
                        $( "#sell" ).show();
                        $( "#monthly" ).hide();
                    }                         
                });
            });
    </script>
</head>
<body>
    <h1>매물 리스트</h1>
    <input type="radio" name="dealType" value=1 checked>월세
    <input type="radio" name="dealType" value=2>전세
    <input type="radio" name="dealType" value=3>매도
    <br>
    <br>
    <span id="monthly">
        월세 매물 : 
        <dl>
        <?php
            $result1 = mysqli_query($conn,$query1);
            while($row = mysqli_fetch_array($result1)){
                ?>
                <span id="item">
                    <dt>매물 번호 : <?=$row['id']?></dt>
                    <dt>타입 : <?=$row['type']?></dt>
                    <dt>주소 : <?=$row['address']?></dt>
                    <dd>월세가 : <?=$row['price']?></dd>
                    <dd>보증금 : <?=$row['deposit']?></dd>
                    <dd>면적 m^2 : <?=$row['area_m2']?></dd>
                    <dd>면적 평 : <?=$row['area_py']?></dd>
                    <dd>설명 : <?=$row['explanation']?></dd>
                </span>
                <?php
            }
        ?>
        </dl>
    </span>
    <span id="jeonse" style="display:none">
        전세 매물 : 
        <dl>
        <?php
            $result2 = mysqli_query($conn,$query2);
            while($row = mysqli_fetch_array($result2)){
                ?>
                <span id="item">
                    <dt>매물 번호 : <?=$row['id']?></dt>
                    <dt>타입 : <?=$row['type']?></dt>
                    <dt>주소 : <?=$row['address']?></dt>
                    <dd>전세가 : <?=$row['price']?></dd>
                    <dd>면적 m^2 : <?=$row['area_m2']?></dd>
                    <dd>면적 평 : <?=$row['area_py']?></dd>
                    <dd>설명 : <?=$row['explanation']?></dd>
                </span>
                <?php
            }
        ?>
        </dl>
    </span>
    <span id="sell" style="display:none">
        매도 매물 : 
        <?php
            $result3 = mysqli_query($conn,$query3);
            while($row = mysqli_fetch_array($result3)){
                ?>
                <span id="item">
                    <dt>매물 번호 : <?=$row['id']?></dt>
                    <dt>타입 : <?=$row['type']?></dt>
                    <dt>주소 : <?=$row['address']?></dt>
                    <dd>매매가 : <?=$row['price']?></dd>
                    <dd>면적 m^2 : <?=$row['area_m2']?></dd>
                    <dd>면적 평 : <?=$row['area_py']?></dd>
                    <dd>설명 : <?=$row['explanation']?></dd>
                </span>
                <?php
            }
        ?>
    </span>
</body>
</html>
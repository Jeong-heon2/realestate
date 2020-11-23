<?php
header('Content-Type: text/html; charset=utf-8');
require('connection.php');
/*settype($_POST['id'],'integer');
settype($_POST['direction'], 'integer');
settype($_POST['deal_type'], 'integer');
settype($_POST['type'], 'integer');
var_dump($_POST['direction']);*/
$filtered = array(
    'title'=>mysqli_real_escape_string($conn, $_POST['title']),
    'id'=>mysqli_real_escape_string($conn, $_POST['id']),
    'price'=>mysqli_real_escape_string($conn, $_POST['price']),
    'area_m2'=>mysqli_real_escape_string($conn, $_POST['area_m2']),
    'area_py'=>mysqli_real_escape_string($conn, $_POST['area_py']),
    'address'=>mysqli_real_escape_string($conn, $_POST['address']),
    'address_detail'=>mysqli_real_escape_string($conn, $_POST['address_detail']),
    'latitude'=>mysqli_real_escape_string($conn, $_POST['latitude']),
    'longitude'=>mysqli_real_escape_string($conn, $_POST['longitude']),
    'direction'=>mysqli_real_escape_string($conn, $_POST['direction']),
    'deal_type'=>mysqli_real_escape_string($conn, $_POST['deal_type']),
    'type'=>mysqli_real_escape_string($conn, $_POST['type']),
    'explanation'=>mysqli_real_escape_string($conn, $_POST['explanation']),
    'memo'=>mysqli_real_escape_string($conn, $_POST['memo']),

);
$sql = "
INSERT INTO house
(id, title, price, area_m2, area_py, address, address_detail, latitude, longitude,
direction, deal_type, type, explanation, memo)
VALUES(
'{$filtered['id']}',
'{$filtered['title']}',
'{$filtered['price']}',
'{$filtered['area_m2']}',
'{$filtered['area_py']}',
'{$filtered['address']}',
'{$filtered['address_detail']}',
'{$filtered['latitude']}',
'{$filtered['longitude']}',
'{$filtered['direction']}',
'{$filtered['deal_type']}',
'{$filtered['type']}',
'{$filtered['explanation']}',
'{$filtered['memo']}'
)
";

$result = mysqli_query($conn, $sql);
if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
    error_log(mysqli_error($conn));
    echo $conn -> error;
    echo '<a href="index.php">돌아가기</a>';
} else {
    header('Location: /dadepo/index.php');
}
?>

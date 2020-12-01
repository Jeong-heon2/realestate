<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('세션이 만료되었습니다. 다시 로그인 해주세요');";
    echo "window.location.replace('login.php');</script>";
    exit;
}

if(isset($_GET['id'])){
    require('connection.php');
    $sql = "delete from house where id = ".$_GET['id'];
    $result = mysqli_query($conn, $sql);
    if($result === false){
        echo '처리하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
        error_log(mysqli_error($conn));
        echo $conn -> error;
        echo '<a href="index.php">돌아가기</a>';
    } else {
        header('Location: /dadepo/index.php');
    }
}else{
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('잘못된 접근입니다.');";
    echo "window.location.replace('index.php');</script>";
    exit;
}
?>
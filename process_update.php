<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('세션이 만료되었습니다. 다시 로그인 해주세요');";
    echo "window.location.replace('login.php');</script>";
    exit;
}
require('connection.php');
$old_id = $_POST['old_id'];
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
$dot = "'";
$sql = "update house set title = ".$dot.$filtered['title'].$dot.", id = ".$filtered['id'].", price = ".$filtered['price'].", area_m2 = ".$filtered['area_m2'].
", area_py = ".$filtered['area_py'].", address = ".$dot.$filtered['address'].$dot.", address_detail = ".$dot.$filtered['address_detail'].$dot.
    ", latitude = ".$filtered['latitude'].", longitude = ".$filtered['longitude'].", direction = ".$filtered['direction'].", deal_type = ".$filtered['deal_type'].
    ", type = ".$filtered['type'].", explanation = ".$dot.$filtered['explanation'].$dot.", memo = ".$dot.$filtered['memo'].$dot.
    "where id = ".$old_id;
;

$result = mysqli_query($conn, $sql);
if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
    error_log(mysqli_error($conn));
    echo $conn -> error;
    echo '<a href="insert.php">돌아가기</a>';
} else {

    if(isset($_FILES)){
        try{
            upload();
        }catch (Exception $e){
            echo $e->getMessage();
            echo '<a href="insert.php">돌아가기</a>';
        }

    }else{
        echo "no";
    }

    header('Location: /dadepo/index.php');
}
function upload(){
    for($i = 0; $i < count($_FILES['upload']['name']); $i++){
        /*** check if a file was uploaded ***/
        if(is_uploaded_file($_FILES['upload']['tmp_name'][$i]) && getimagesize($_FILES['upload']['tmp_name'][$i]) != false)
        {
            /***  get the image info. ***/
            $size = getimagesize($_FILES['upload']['tmp_name'][$i]);
            /*** assign our variables ***/
            $type = $size['mime'][$i];
            $imgfp = fopen($_FILES['upload']['tmp_name'][$i], 'rb');
            $size = $size[3];
            $name = $_FILES['upload']['name'][$i];
            $maxsize = 99999999;

            /***  check the file is less than the maximum file size ***/
            if($_FILES['upload']['size'][$i] < $maxsize )
            {
                /*** connect to db ***/
                $dbh = new PDO("mysql:host=localhost;dbname=dadepo", 'root', '111111');

                /*** set the error mode ***/
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                /*** our sql query ***/
                $stmt = $dbh->prepare("INSERT INTO image (id , image) VALUES (? ,?)");
                $id = (int)$_POST['id'];
                var_dump($id);

                /*** bind the params ***/
                $stmt->bindParam(1, $id);
                $stmt->bindParam(2, $imgfp, PDO::PARAM_LOB);

                /*** execute the query ***/
                $stmt->execute();
            }
            else
            {
                /*** throw an exception is image is not of type ***/
                throw new Exception("File Size Error");
            }
        }
        else
        {
            // if the file is not less than the maximum allowed, print an error
            throw new Exception("Unsupported Image Format!");
            echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
            error_log(mysqli_error($conn));
            echo $conn -> error;
            echo '<a href="insert.php">돌아가기</a>';
        }
    }

}

?>
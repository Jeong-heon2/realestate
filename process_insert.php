<?php
header('Content-Type: text/html; charset=utf-8');
require('connection.php');
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
        }
    }
    /*
    for($i = 0; $i < count($_FILES['upload']['name']); $i++){

        $uploadfile = $_FILES['upload']['name'][$i];

        if(move_uploaded_file($_FILES['upload']['tmp_name'][$i],$uploadfile)){
            echo "파일이 업로드 되었습니다.<br />";
            echo "<img src ={$_FILES['upload']['name'][$i]} style='width:100px'> <p>";
            echo "1. file name : {$_FILES['upload']['name'][$i]}<br />";
            echo "2. file type : {$_FILES['upload']['type'][$i]}<br />";
            echo "3. file size : {$_FILES['upload']['size'][$i]} byte <br />";
            echo "4. temporary file size : {$_FILES['upload']['size'][$i]}<br />";
        } else {
            echo "파일 업로드 실패 !! 다시 시도해주세요.<br />";
        }
    }*/
}

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
    echo '<a href="insert.php">돌아가기</a>';
} else {
    header('Location: /dadepo/index.php');
}
?>

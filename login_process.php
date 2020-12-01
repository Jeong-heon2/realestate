<?php
//iv vector
define('KEY', '1234567890123456');
define('KEY_128', substr(KEY, 0, 128 / 8));
define('KEY_256', substr(KEY, 0, 256 / 8));

if(isset($_POST['pwd'])){
    $pwd = $_POST['pwd'];


    $pwd = openssl_encrypt($pwd, 'AES-256-CBC', KEY_256, 0, KEY_128);


    $key = file_get_contents("keys/password", true);



    if($pwd == $key){
        /* If success */
        session_start();
        $_SESSION['user_id'] = "admin";
        $_SESSION['user_name'] = "admin";

    }else{
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('아이디 또는 비밀번호가 잘못되었습니다.');";
        echo "window.location.replace('login.php');</script>";
        exit;
    }
}else{
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('잘못된 접근입니다. ')";
    echo "window.location.replace('login.php');</script>";
    exit;
}
?>
<meta http-equiv="refresh" content="0;url=index.php" />


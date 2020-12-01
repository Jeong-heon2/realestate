<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/login.css" type="text/css">

</head>
<body>
<?php if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) { ?>
    <form name="login_form" action="login_process.php" method="post" >
        <input id="iv" type="hidden" name="iv_base64">
        <input id="key" type="hidden" name="key_base64">
        <div id="login_box">
            <h2>관리자 로그인</h2>
            <ul id="input_button">
                <li id="id_pass">
                    <ul>
                        <br>
                        <li id="pass">
                            <span>PW</span>
                            <input id="pwd" type="password" name="pwd">
                        </li> <!-- pass -->
                    </ul>
                </li>
                <li id="login_btn">
                    <button type="button" id="btn_pwd" onclick="encrypt()">로그인</button>
                </li>
            </ul>
        </div> <!-- login_box -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
        <script>
            document.addEventListener('keydown', function(event) {
                if (event.code === "Enter") {
                    event.preventDefault();
                };
            }, true);
            function encrypt(){
                var data = document.getElementById('pwd').value;

                var key = CryptoJS.enc.Hex.parse("1234567811111111abcdefabcd123123");
                var iv =  CryptoJS.enc.Hex.parse("abcd1231231234567811111111abcdef");

                function Encrypt(value) {
                    var encrypted = CryptoJS.AES.encrypt(value, key, {iv:iv,mode: CryptoJS.mode.CBC,padding: CryptoJS.pad.Pkcs7});
                    encrypted = encrypted.ciphertext.toString(CryptoJS.enc.Base64);
                    return encodeURIComponent(encrypted);
                }

                document.getElementById("pwd").value = Encrypt(data);
                document.login_form.setAttribute("method", "post");
                document.login_form.submit();

            }

        </script>

    </form>
<?php } else {
    echo "<p>이미 로그인하고 있습니다. ";
    echo "<a href=\"index.php\">[돌아가기]</a> ";
} ?>

</body>
</html>
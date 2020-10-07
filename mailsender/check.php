<?php
session_start();
if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] == $_POST['captcha']){
echo 1;
} else{
echo 0;
}
?>
<?php
// punycode
require_once('idna_convert.class.php');
$idn = new idna_convert(array('idn_version'=>2008));


$mainMail = "mayru@yandex.ru";//mayru@yandex.ru

if(!$_POST["email"]){
	$_POST["email"] = $mainMail;
}

function clearData($d){
	trim(strip_tags($d));
	return $d;
}


if(strpos(getenv("HTTP_REFERER"), $_SERVER["HTTP_HOST"])){
	//if(empty($_POST["name"]) or empty($_POST["email"]) or empty($_POST["textarea"]))
	$name = clearData($_POST["fio"]);
	$textarea = clearData($_POST["comments"]);
	$link = $_POST["link"];
	$body = '';
	
	
	if($_POST["title"]){
		$title = clearData($_POST["title"]);
		$body .= "<h3>{$title}</h3>";
	}
	
	
	
	$body .= "<p><strong>Имя отправителя:</strong> ". $name;
	
	/*if($_POST["fio"]){
		$fio = clearData($_POST["fio"]);
		$body .= "<p><strong>ФИО:</strong> " . $fio;
	}*/
	
	if($_POST["phone"]){
		$tel = clearData($_POST["phone"]);
		$body .= "<p><strong>Телефон:</strong> " . $tel;
	}
	
	if($_POST["email"]){
		$email = clearData($_POST["email"]);
		$body .= "<p><strong>E-mail:</strong> " . $email;
	}
	
	/*if($_POST["telemail"]){
		$telemail = clearData($_POST["telemail"]);
		$body .= "<p><strong>Телефон/E-mail:</strong> " . $telemail;
	}*/
    
	if($_POST["time"]){
		$time = clearData($_POST["time"]);
		$body .= "<p><strong>Время:</strong> " . $time;
	}
	
	if($_POST["comments"]){
		$body .= "<p><strong>Текст письма(комментарий):</strong> " . $textarea;
	}
	/*foreach($_POST as $name=>$val){
		echo $name." - ".$val."<br>";
	}*/


	////////////////////////////////////
	$title = "Письмо с сайта: ". $idn->decode($_SERVER["HTTP_HOST"]);

	$headers =  'From: '. $email."\n";
	$headers .= 'Content-type: text/html; charset=utf-8';

	mail($mainMail, $title, $body, $headers);

	echo "<h2 style='margin-bottom:5px; margin-top:0;'>Отправлено</h2><p><strong>При необходимости мы с Вами свяжемся!</strong></p>";
}

?>
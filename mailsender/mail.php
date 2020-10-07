<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/mailsender/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/mailsender/class.freakmailer.php');

// punycode
require_once('idna_convert.class.php');
$idn = new idna_convert(array('idn_version'=>2008));

$mailer = new FreakMailer();


function clearData($d){
	trim(strip_tags($d));
	return $d;
}


if(strpos(getenv("HTTP_REFERER"), $_SERVER["HTTP_HOST"])){
	//if(empty($_POST["name"]) or empty($_POST["email"]) or empty($_POST["textarea"]))
	$name = clearData($_POST["name"]);
	$textarea = clearData($_POST["comments"]);
	$link = $_POST["link"];
	$body = '';
	
	
	/*if($_POST["title"]){
		$title = clearData($_POST["title"]);
		$body .= "<h3>{$title}</h3>";
	}*/
	
	
	$mailer->Subject = "Письмо с сайта: ". $idn->decode($_SERVER["HTTP_HOST"]);
	
	$body .= "<p><strong>Имя отправителя:</strong> ". $name;
	
	if($_POST["name"]){
		$name = clearData($_POST["name"]);
	}
	if($_POST["phone"]){
		$phone = clearData($_POST["phone"]);
	}
	if($_POST["email"]){
		$email = clearData($_POST["email"]);
	}
	/*if($_POST["telemail"]){
		$telemail = clearData($_POST["telemail"]);
		$body .= "<p><strong>Телефон/E-mail:</strong> " . $telemail;
	}*/
	if($_POST["time"]){
		$time = clearData($_POST["time"]);
	}
	if($_POST["comments"]){
		$comments = $_POST["comments"];
	}
	
	
	
	$htmlBody = "
<h3>На сайте заполнили форму</h3>
<p><strong>Имя отправителя:</strong> $name <br>
<strong>Телефон:</strong> $phone <br>
<strong>Текст сообщения:</strong> $comments</p>";

	$mailer->Body = $htmlBody;
	$mailer->isHTML(true);
	$mailer->CharSet = 'utf-8';
	
	//$mailer->AddAddress('test@ya.ru', 'Администратор');
	$mailer->AddAddress('test@ya.ru', 'Администратор');
	//$mailer->AddBCC('test@ya.ru', 'Администратор');
	
	if(!$mailer->Send()){
		echo 'Не могу отослать письмо! Что-то пошло не так';
	} else{
		echo "<h2 style='margin-bottom:5px; margin-top:0;'>Отправлено</h2><p><strong>При необходимости мы с Вами свяжемся!</strong></p>";
	}
	
	$mailer->ClearAddresses();
	$mailer->ClearAttachments();
	
} else{
	echo "Таким способом письма нельзя отправлять.";
}




?>
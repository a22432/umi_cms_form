<?php

require($_SERVER['DOCUMENT_ROOT']."/mailsender/config.php");
require($_SERVER['DOCUMENT_ROOT']."/mailsender/recaptchalib.php");

require_once($_SERVER['DOCUMENT_ROOT'].'/mailsender/class.freakmailer.php');


require_once('idna_convert.class.php');
$idn = new idna_convert(array('idn_version'=>2008));

$mailer = new FreakMailer();

function clearData($d){
	trim(strip_tags($d));
	return $d;
}


$data = $_POST;

$re = new RECaptcha( $conf_reCaptcha['private_key'] );
$reResult = $re->verifyResponse($_SERVER['REMOTE_ADDR'], $data['g-recaptcha-response']);

if($reResult->success){
	//exit('Вы человек');
	
	//if(empty($_POST["name"]) or empty($_POST["email"]) or empty($_POST["textarea"]))
	
	$mailer->Subject = "Письмо с сайта: ". $idn->decode($_SERVER["HTTP_HOST"]);
	
	if($_POST["phone"]){
		$phone = clearData($_POST["phone"]);
	}
	
	$htmlBody = "
<h3>На сайте заполнили форму - Обратный звонок</h3>
<p><strong>Телефон для связи:</strong> $phone</p>";

	$mailer->Body = $htmlBody;
	$mailer->isHTML(true);
	$mailer->CharSet = 'utf-8';
	
	//$mailer->AddAddress('test@ya.ru', 'Администратор');
	$mailer->AddAddress('test@ya.ru', 'Администратор');
	//$mailer->AddBCC('test@ya.ru', 'Администратор');
	
	if(!$mailer->Send()){
		echo 'Не могу отослать письмо! Что-то пошло не так';
	} else{
		echo "Ваше уведомление отправлено!";
	}
	
	$mailer->ClearAddresses();
	$mailer->ClearAttachments();
	
	
} else{
	exit('Спам');
}

?>
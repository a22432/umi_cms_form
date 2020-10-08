<?php
require_once($_SERVER['DOCUMENT_ROOT']."/mailsender/config.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/mailsender/class.freakmailer.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/mailsender/idna_convert.class.php');
$idn = new idna_convert(array('idn_version'=>2008));

$mailer = new FreakMailer();

function clearData($d){
	trim(strip_tags($d));
	return $d;
}


$data = $_POST;



//Выполняем проверку после отправки формы


if(isset($_POST['g-recaptcha-response'])) {
    $secretKey = $conf_reCaptcha['private_key'];
    $response = $_POST['g-recaptcha-response'];
    $remoteIp = $_SERVER['REMOTE_ADDR'];
 
 
    $reCaptchaValidationUrl = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remoteip=$remoteIp");
    $reCaptchaValid = json_decode($reCaptchaValidationUrl, TRUE);
 
 	$result = array();
	$result['result'] = "Что-то пошло не так.";
	

    if($reCaptchaValid['success'] == 1) {
        //Проверка пройдена - здесь выполняем нужный нам код
		$mailer->Subject = "Письмо с сайта: ". $idn->decode($_SERVER["HTTP_HOST"]);
	
		if($_POST["name"]){
			$name = clearData($_POST["name"]);
		}
		if($_POST["product_name"]){
			$product_name = clearData($_POST["product_name"]);
		}
		if($_POST["product_price"]){
			$product_price = clearData($_POST["product_price"]);
		}
		if($_POST["email"]){
			$email = clearData($_POST["email"]);
		}
		if($_POST["phone"]){
			$phone = clearData($_POST["phone"]);
		}
		if($_POST["message"]){
			$message = clearData($_POST["message"]);
		}
		
		$htmlBody .= "<h3>На сайте {$idn->decode($_SERVER['HTTP_HOST'])} заполнили форму ОСТАВИТЬ ЗАЯВКУ.</h3> <p>";
		
		if($name){
			$htmlBody .= "<strong>Имя отправителя:</strong> $name<br>";
		}
		if($product_name){
			$htmlBody .= "<strong>Выбрали товар:</strong> $product_name<br>";
		}
		if($product_price){
			$htmlBody .= "<strong>Цена:</strong> $product_price<br>";
		}
		if($email){
			$htmlBody .= "<strong>Email:</strong> $email<br>";
		}
		if($phone){
			$htmlBody .= "<strong>Телефон:</strong> $phone<br>";
		}
		if($message){
			$htmlBody .= "<strong>Комментарий:</strong> $message<br> ";
		}
		
		
		// Прикрепляем к письму файлы (если есть) из формы
		foreach($_FILES as $k => $v){
			$tmpName = $_FILES[$k]['tmp_name'];
			if (file($tmpName)) {
				/* Reading file ('rb' = read binary)  */
				$file = fopen($tmpName,'rb');
				$data = fread($file,filesize($tmpName));
				fclose($file); 
				$data = chunk_split(base64_encode($data)); 
				
				$mailer->AddAttachment($tmpName, $_FILES[$k]['name']);
				$id_attach = md5('my-attach-' . $_FILES[$k]['name']);
				$mailer->AddEmbeddedImage($tmpName, $id_attach, $_FILES[$k]['name']);
				
				$htmlBody .= "<div><strong>Прикреплённая картинка:</strong> <img src='cid:$id_attach' style='max-width:150px; max-height:150px;'/></div>";
				
			}
		}
		
		
		$htmlBody .= "</p>";
	
		$mailer->Body = $htmlBody;
		$mailer->isHTML(true);
		$mailer->CharSet = 'utf-8';
		
		$mailer->AddAddress('test@yandex.ru', 'Администратор');
		$mailer->AddBCC('test@yandex.ru', 'Администратор');
		if($email){
			$mailer->setFrom($email, $name);
		}
		//$mailer->AddAddress('test@yandex.ru', 'Администратор');
		//$mailer->AddBCC('test@yandex.ru', 'Администратор');
		
		$result['recapcha'] = true; // капча пройдена
		
		if(!$mailer->Send()){
			$result['result'] = "Не могу отослать письмо! Что-то пошло не так. Попробуйте изменить письмо и отправить снова.";
		} else{
			$result['result'] = "Спасибо за Ваше обращение. В ближайшее время с Вами свяжется для уточнения деталей.";
		}
		
		//$mailer->ClearAddresses();
		//$mailer->ClearAttachments();
	

    } else {
		//Проверка не пройдена - Здесь мы сообщаем об этом
		$result['result'] = "Проверьте капчу.";
		$result['recapcha'] = false;
    }
	echo json_encode($result);
}
?>
<?php
// Мои настройки по умолчанию

// Настройки Email
//$site['from_name'] = 'Администрация'; // from (от) имя
$site['from_email'] = 'noreplay@gmail.com'; // from (от) email адрес по умолчанию от кого, должна быть доменная почта, для MAIL.RU имеет значение
// На всякий случай указываем настройки
// для дополнительного (внешнего) SMTP сервера.
$site['smtp_mode'] = 'disabled'; // enabled or disabled (включен или выключен)
$site['smtp_host'] = null;
$site['smtp_port'] = null;
$site['smtp_username'] = null;


$conf_reCaptcha["public_key"] = '6Lf618UZAAAAAI0GCul5jFcz4CPmHb2VCvw10EV';
$conf_reCaptcha["private_key"] = '6Lf618UZAAAAAL_IsFAZry5lMX93FXG_PUYNaPaGi';


?>
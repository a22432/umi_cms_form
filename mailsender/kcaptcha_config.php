<?php

# KCAPTCHA файл конфигурации

$alphabet = "0123456789abcdefghijklmnopqrstuvwxyz"; # Не меняйте это значение, без изменения в папке fonts

# Символы на картинке CAPTCHA
$allowed_symbols = "02345689heika"; #Цифры
//$allowed_symbols = "23456789abcdeghkmnpqsuvxyz"; # Алфавит + Цифры без: o=0, 1=l, i=j, t=f

# Папка 'fonts'
$fontsdir = 'fonts';	

# CAPTCHA количество символов
$length = mt_rand(2,3); # В данном случае от 5 до 6
//$length = 6;

# CAPTCHA размеры рисунка (Не меняйте этот параметр - он оптимален)
$width = 130;
$height = 50;

# symbol's vertical fluctuation amplitude divided by 2
$fluctuation_amplitude = 0;

# Без пробелов между символами: true | С пробелами: false
$no_spaces = false;

# Показывать url сайта
$show_credits = false; # Добавить url сайта = true | Не добавлять - false (Занимает 12 px внизу картинки)
$credits = ''; # Если значение пустое будет выведен URL сайта, если нет - Ваш текст (АНГЛИЙСКИЙ)

# CAPTCHA image colors (RGB, 0-255)
$foreground_color = array(0, 0, 0);
$background_color = array(255,255,255);
//$foreground_color = array(mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
//$background_color = array(mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));

# JPEG quality of CAPTCHA image (bigger is better quality, but larger file size)
$jpeg_quality = 100;
?>
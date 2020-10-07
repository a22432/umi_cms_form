<?php

# KCAPTCHA ���� ������������

$alphabet = "0123456789abcdefghijklmnopqrstuvwxyz"; # �� ������� ��� ��������, ��� ��������� � ����� fonts

# ������� �� �������� CAPTCHA
$allowed_symbols = "02345689heika"; #�����
//$allowed_symbols = "23456789abcdeghkmnpqsuvxyz"; # ������� + ����� ���: o=0, 1=l, i=j, t=f

# ����� 'fonts'
$fontsdir = 'fonts';	

# CAPTCHA ���������� ��������
$length = mt_rand(2,3); # � ������ ������ �� 5 �� 6
//$length = 6;

# CAPTCHA ������� ������� (�� ������� ���� �������� - �� ���������)
$width = 130;
$height = 50;

# symbol's vertical fluctuation amplitude divided by 2
$fluctuation_amplitude = 0;

# ��� �������� ����� ���������: true | � ���������: false
$no_spaces = false;

# ���������� url �����
$show_credits = false; # �������� url ����� = true | �� ��������� - false (�������� 12 px ����� ��������)
$credits = ''; # ���� �������� ������ ����� ������� URL �����, ���� ��� - ��� ����� (����������)

# CAPTCHA image colors (RGB, 0-255)
$foreground_color = array(0, 0, 0);
$background_color = array(255,255,255);
//$foreground_color = array(mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
//$background_color = array(mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));

# JPEG quality of CAPTCHA image (bigger is better quality, but larger file size)
$jpeg_quality = 100;
?>
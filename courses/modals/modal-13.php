<?php
if (isset($_GET['ajax'])&&$_GET['ajax']=='true') {
	$points = '';
} else {
	$points = '../';
}
$content = '<h1>КУРС «НАРАЩИВАНИЕ РЕСНИЦ». «КЛАССИЧЕСКОЕ НАРАЩИВАНИЕ РЕСНИЦ, ОСНОВЫ И БАЗОВЫЕ ПРАВИЛА».</h1>
				<p style="text-align:center;"><strong>ПРОГРАММА</strong></p>
				<p><strong>1 ДЕНЬ</strong></p>
				<p>10.00-13.00 Теоретический блок</p>
				<ul>
				<li>Строение глаза</li>
				<li>Строение натуральной ресницы</li>
				<li>Строение ресницы в коже</li>
				<li>Фазы роста ресниц</li>
				<li>Характеристики натуральных ресниц</li>
				<li>Заболевания глаз/ противопоказания</li>
				<li>Виды наращивания ресниц</li>
				<li>Материалы для наращивания ресниц. Обзор и назначение</li>
				<li>Анатомические особенности глаз.</li>
				<li>Моделирование взгляда. Эффекты наращивания ресниц</li>
				</ul>
				<p>13.00-13.30 - перерыв</p>
				<ul>
				<li>- теоретический блок</li>
				</ul>
				<p>&nbsp;</p>
				<ul>
				<li>Подбор и совмещение изгибов</li>
				<li>Широко расставленные и близкопосаженные глаза: способы коррекцииТехника наращивания ресниц</li>
				<li>Площадь соприкосновения искусственной с натуральной</li>
				<li>Отступ от века</li>
				<li>Принцип параллельности</li>
				<li>Этапы проведения процедуры</li>
				<li>Карта клиента</li>
				<li>Снятие наращенных ресниц</li>
				<li>Этапы проведения процедуры для гелевого и кремового ремувера</li>
				<li>Коррекция наращенных ресниц, этапы проведения коррекции</li>
				<li>Способы снятия одиночной ресницы</li>
				<li>Декорирование ресниц</li>
				</ul>
				<p>16.30-18.00 - практический блок на тренажере<br> ⠀<br> <strong>2 ДЕНЬ</strong><br> ⠀<br> 10.00-13.30 Практика классического наращивания ресниц на 1ой модели</p>
				<p>13.30-14.00 Перерыв</p>
				<p>14.00-18.00 Практика классического наращивания ресниц на 2-ой модели<br> </p>
				<br>
				<p>Стоимость курса «КЛАССИЧЕСКОЕ НАРАЩИВАНИЕ РЕСНИЦ, ОСНОВЫ И БАЗОВЫЕ ПРАВИЛА» - 11000 рублей</p>
				<p>При бронировании курса сегодня до 00:00 в размере 5000 рублей у нас действует акционная скидка на его приобретение. Размер скидки - 2100 рублей! Итого стоимость курса для вас будет 8900 рублей.
                </p>
				<a class="card__order" href="https://auth.robokassa.ru/Merchant/Index.aspx?MerchantLogin=Channail4&InvId=0&Culture=ru&Encoding=utf-8&Description=%D0%91%D1%80%D0%BE%D0%BD%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5%20%D0%9A%D1%83%D1%80%D1%81%D0%B0%20%C2%AB%D0%9A%D0%9B%D0%90%D0%A1%D0%A1%D0%98%D0%A7%D0%95%D0%A1%D0%9A%D0%9E%D0%95%20%D0%9D%D0%90%D0%A0%D0%90%D0%A9%D0%98%D0%92%D0%90%D0%9D%D0%98%D0%95%20%D0%A0%D0%95%D0%A1%D0%9D%D0%98%D0%A6,%20%D0%9E%D0%A1%D0%9D%D0%9E%D0%92%D0%AB%20%D0%98%20%D0%91%D0%90%D0%97%D0%9E%D0%92%D0%AB%D0%95%20%D0%9F%D0%A0%D0%90%D0%92%D0%98%D0%9B%D0%90%C2%BB&OutSum=5000&shp_item=6&SignatureValue=22696510b045fd416f275d90f0bfba5c">Бронировать</a>
				<p>Нажимая кнопку «Забронировать», вы даете свое <a class="paymentTermsLink" href="'.$points.'agreement.html" target="_blank">согласие на обработку персональных данных</a> в соответствии с нашей <a class="paymentTermsLink" href="'.$points.'privacy.html" target="_blank">политикой защиты персональной информации </a>и заключаете <a class="paymentTermsLink" href="'.$points.'oferta_ip.html" target="_blank">договор купли - продажи</a>.<br> Информация о каждом из выбранных курсов (продолжительность, содержание и программа, стоимость) указана в описании к соответствующему курсу.<br>
				Отношения по приобретению онлайн курсов регулируются нормами Гражданского кодекса Российской Федерации и Закона о защите прав потребителей.</p>';

if (isset($_GET['ajax'])&&$_GET['ajax']=='true') {
	echo ($content);
} else {
	$pre_content = '<!DOCTYPE html>
<html lang="ru-RU">
<head>
	<meta charset="UTF-8">
	<title>Школа маникюра ООО"ШАННЭЙЛ 4"</title>
	<meta content="website" property="og:type">
	<meta content="Школа маникюра ШАННЭЙЛ 4" property="og:site_name">
	<meta name="description" content="Авторская школа маникюра в Москве Кутикульное Царство. Очное и онлайн обучение маникюрному икусству.">
	<meta property="og:description" content="Школа маникюра ШАННЭЙЛ 4. Авторская школа маникюра в Москве Кутикульное Царство. Очное и онлайн обучение маникюрному икусству.">
	<link href=\'../css/style.css\' rel=\'stylesheet\' type=\'text/css\'>
	<link href=\'index.html\' rel=\'shortlink\'>
	<link href="../img/favicon.jpg" rel="icon" >
	<meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport">
</head>
<body class="home modal--overflow">
	<main>
		<div class="overlay open">
		<div class="modal open elementor elementor-271" id="modal1">
	        <div class="modal__content">';
	$post_content = '
	</div></div></div></main>
</body>
</html>';
	echo ($pre_content.$content.$post_content);
}
?>

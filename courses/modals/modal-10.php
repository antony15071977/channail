<?php
if (isset($_GET['ajax'])&&$_GET['ajax']=='true') {
	$points = '';
} else {
	$points = '../';
}
$content = '<h1>АНАТОМИЧЕСКОЕ КОМБИ + ИДЕАЛЬНЫЙ ФРЕНЧ</h1>
					<p>Новый курс включает в себя освоение безопасного, атравматичного, анатомического способа комбинированного маникюра (1 форма анатомической фрезы+ твизеры). Помимо маникюра, мастер освоит идеальный френч.</p>
					<p>&nbsp;</p>
					<p><strong>Для кого:</strong> мастеров, владеющих аппаратным маникюром.</p>
					<p><strong>Продолжительность:</strong> 1 день.</p>
					<p><strong>Длительность:</strong> с 10:00 до 18:00/19:00</p>
					<p><strong>ПРОГРАММА</strong></p>
					<p><strong>&nbsp;</strong></p>
					<ul>
					<li>10:00 до 13:00 &ndash; теория</li>
					<li>13:00 &ndash; 13:30- перерыв</li>
					<li>13:30 &ndash; 18:00 -практика, отработка на модели (10 пальцев)</li>
					</ul>
					<p>&nbsp;</p>
					<p><strong>После курса вы:</strong></p>
					<ul>
					<li>Будете работать в запатентованной технологии анатомической фрезой</li>
					<li>Добьетесь приостановки роста околоногтевой кожи</li>
					<li>Повысите квалификацию</li>
					<li>Научитесь быстрому, качественному и анатомическому комби</li>
					<li>Освоите рисованный френч с идеальными бликами, выравниванием и апексом Проработаете выравнивание ногтевой пластины с повреждениями и дефектами</li>
					</ul>
					<p>&nbsp;</p>
					<p>Стоимость курса «АНАТОМИЧЕСКОЕ КОМБИ + ИДЕАЛЬНЫЙ ФРЕНЧ» - 13000 рублей</p>
					<p>При бронировании курса сегодня до 00:00 в размере 5000 рублей у нас действует акционная скидка на его приобретение. Размер скидки - 3000 рублей! Итого стоимость курса для вас будет 10000 рублей.
                </p>
					<a class="card__order" href="https://auth.robokassa.ru/Merchant/Index.aspx?MerchantLogin=Channail4&InvId=0&Culture=ru&Encoding=utf-8&Description=%D0%91%D1%80%D0%BE%D0%BD%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5%20%D0%9A%D1%83%D1%80%D1%81%D0%B0%20%C2%AB%D0%90%D0%9D%D0%90%D0%A2%D0%9E%D0%9C%D0%98%D0%A7%D0%95%D0%A1%D0%9A%D0%9E%D0%95%20%D0%9A%D0%9E%D0%9C%D0%91%D0%98%20+%20%D0%98%D0%94%D0%95%D0%90%D0%9B%D0%AC%D0%9D%D0%AB%D0%99%20%D0%A4%D0%A0%D0%95%D0%9D%D0%A7%C2%BB&OutSum=5000&shp_item=5&SignatureValue=1c35fe165dadf143774ed0a88adc7c1d">Бронировать</a>
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

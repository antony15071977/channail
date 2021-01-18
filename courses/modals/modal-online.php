<?php
if (isset($_GET['ajax'])&&$_GET['ajax']=='true') {
	$points = '';
} else {
	$points = '../';
}
$content = '<h1>Онлайн обучение</h1>
				<p>В нашей школе есть онлайн курсы. Уроки созданы с эффектом офлайна. Мы сделали все для того, чтобы вы не чувствовали никаких барьеров, а усвоение материала происходило так, будто вы стоите рядом и наблюдаете.</p>
				<p>Вы освоите новый запатентованный мокрый вид маникюра – «слайсинг». Научитесь работать крючковыми ножницами, делать идеальное покрытие и овладеете несколькими видами комби. </p>
				<p>Курс подходит как для абсолютных новичков в nail сфере, так и для мастеров с опытом, желающих освоить новую технику. Всех учеников, в независимости от стажа, ждет полная перезагрузка 100% новизной. </p>
				<p>Онлайн курсы в CHANNAIL – это удобное и современное обучение атравматичному маникюру. </p>
				<p>Оплачивая выбранный онлайн курс, вы заключаете договор купли - продажи и приобретаете право доступа к видео-урокам сроком на 21 день со дня оплаты.</p>
				<p>Информация о каждом из онлайн курсов (продолжительность, содержание и программа, стоимость) указана в описании к соответствующему курсу.</p>
				<p>Отношения по приобретению онлайн курсов регулируются нормами Гражданского кодекса Российской Федерации и Закона о защите прав потребителей.</p>
				<p>Осваивай технику маникюра будущего, когда тебе это удобно!</p>
				<a class="card__order" href="'.$points.'../online/index.html">Подробнее</a>';

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

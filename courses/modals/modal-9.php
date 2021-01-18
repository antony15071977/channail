<?php
if (isset($_GET['ajax'])&&$_GET['ajax']=='true') {
	$points = '';
} else {
	$points = '../';
}
$content = '<h1>ФРАНЧАЙЗИНГ</h1>
					<p>Собственный бизнес через франчайзинг с Channail4.У вас есть возможность открыть собственный конкурентноспособный бизнес, основанный на запатентованной технологии &laquo;Глубокая нить&raquo;: учебный центр или салон красоты.</p>
					<p><strong>Что такое франчайзинг? </strong></p>
					<p>Официальное разрешение на использование знака обслуживания, фирменного стиля, маркетинга, деловой репутации и бизнес-модели школы Channail4. Заключается договор франчайзинга &ldquo;под ключ&rdquo; или с частичным использованием бренда Channail4.</p>
					<p>Это Ваша возможность открыть свой бизнес &ldquo;Глубокой нити&rdquo; в любом городе!</p>	
					<p>Более подробно узнать о франчайзинге с нами вы можете по ссылке ниже.</p>
					<a class="card__order" href="https://topfranchise.ru/lending/channail4/" target="_blank" rel="nofollow">Подробнее о франчайзинге</a>';

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

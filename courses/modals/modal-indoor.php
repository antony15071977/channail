<?php
$content = '<h1>Очное обучение (МОСКВА)</h1>
				<p><strong>ЯНВАРЬ</strong></p>
				<p>МОСКВА</p>
				<p>Основа слайсинга + Мокасиновая стопа 1:0 - 20-24.01;
				<br />Анатомическая фреза - 18-19.01;
				<br />Марафон перфекциониста - 25-28.01;
				<br /> Мокасиновая стопа 2:0 - 15.01, 31.10;
				<p><strong>ФЕВРАЛЬ</strong></p>
				<p>МОСКВА</p>
				<p>Основа слайсинга + Мокасиновая стопа 1:0 - 24-28.02;
				<br />Анатомическая фреза - 1-2.02, 10-11.02, 22-23.02;
				<br />Марафон перфекциониста - 15-18.02;
				<br /> Мокасиновая стопа 2:0 - 3.02, 19.02;
				<p><strong>МАРТ</strong></p>
				<p>МОСКВА</p>
				<p>Анатомическая фреза - 8-9.03; 25-26.03;
				<br />Марафон перфекциониста - 1-4.03;
				<br />Мокасиновая стопа 2:0 - 5.03, 18.03;
				<p><strong>АПРЕЛЬ</strong></p>
				<p>МОСКВА</p>
				<p>Основа слайсинга + Мокасиновая стопа 1:0 - 14-18.04;</p>';

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

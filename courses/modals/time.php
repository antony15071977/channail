<?php
$content = '<h1>Очное обучение (МОСКВА)</h1>
				<p><strong>АПРЕЛЬ</strong></p>
				<p>Анатомическая фреза - 26-27.04;
				<br />Мокасиновая стопа 2:0 - 29.04;
				<p><strong>МАЙ</strong></p>
				<p>Основа слайсинга + Мокасиновая стопа 1:0 - 17-21.05;
				<br />Анатомическая фреза - 6-7.05, 12-13.05, 26-27.05;
				<br />Мокасиновая стопа 2:0 - 14.05, 28.05;
				<br />Марафон перфекциониста - 4-7.05,  24-27.05;
				<p><strong>ИЮНЬ</strong></p>
				<p>Основа слайсинга + Мокасиновая стопа 1:0 - 7-11.06;
				<br />Анатомическая фреза - 31.05-1.06,  16-17.06, 23-24.06;
				<br />Мокасиновая стопа 2:0 - 2.06,  25.06;
				<br />Марафон перфекциониста - 21-24.06;
				<p><strong>ИЮЛЬ</strong></p>
				<p>Основа слайсинга + Мокасиновая стопа 1:0 - 12-16.07;
				<br />Анатомическая фреза - 1-2.07,  7-8.07, 21-22.07, 28-29.07;
				<br />Мокасиновая стопа 2:0 - 9.07,  23.07;
				<br />Марафон перфекциониста - 5-8.07,  26-29.07;
				<p><strong>АВГУСТ</strong></p>
				<p>Основа слайсинга + Мокасиновая стопа 1:0 - 30.08- 3.09;
				<br />Анатомическая фреза - 14-15.08, 18-19.08, 25-26.08;
				<br />Мокасиновая стопа 2:0 - 20.08;
				<br />Марафон перфекциониста - 23-26.08;</p>
				<br>
				<br>
				<h1>Выездное обучение</h1>
				<p>СОЧИ</p>
				<p><strong>АВГУСТ</strong></p>
				<p>Анатомическая фреза - 6-7.08;
				<br />Мокасиновая стопа 2:0 - 8.08;
				<br />Марафон перфекциониста - 2-5.08;</p>
				<p>АЛМАТЫ</p>
				<p><strong>ОКТЯБРЬ</strong></p>
				<p>Анатомическая фреза - 8-9.10;
				<br />Мокасиновая стопа 2:0 - 10.10;
				<br />Марафон перфекциониста - 4-7.10;</p>
				<br>
				<br>
				';

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
	<link href=\'../../css/style.css\' rel=\'stylesheet\' type=\'text/css\'>
	<link href="../../img/favicon.jpg" rel="icon" >
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

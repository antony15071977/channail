<?php
$content = '<h1>Выездное расписание</h1>
				<p><strong>ФЕВРАЛЬ</strong></p>
				<p>ДНЕПРОПЕТРОВСК</p>
				<p>Анатомическая фреза - 11-12.02</p>

				<p><strong>МАРТ</strong></p>
				<p>СОЧИ</p>
				<p>Анатомическая фреза - 19-20.03;
				<br/> Марафон перфекциониста - 15-18.03;
				<br/> Мокасиновая стопа 2:0 - 21.03</p>
				<br/>
				<p>АЛМАТЫ</p>
				<p>Анатомическая фреза - 2-3.04;
				<br/>
				Марафон перфекциониста - 29-1.04;
				<br/>
				Мокасиновая стопа 2:0 - 4.04;
				<br/>
				<p>НУР-СУЛТАН</p>
				<p>Анатомическая фреза - 11-12.04;
				<br/>
				Марафон перфекциониста - 7-10.04;
				<br/>
				Мокасиновая стопа - 13.04;</p>';

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

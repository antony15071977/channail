<?php
if (isset($_GET['ajax'])&&$_GET['ajax']=='true') {
	$img = 'img';
} else {
	$img = '../img';
}
$content = '<h2 class="modal_h2">Салон<br>CHANNAIL</h2>
<p>Запись в салоны CHANNAIL4 открыта!</p>
<p>Москва</p>
<p>Помимо обычного маникюра и педикюра, салон CHANNAIL4 предоставляет эксклюзивную услугу анатомической техники маникюра &laquo;Глубокая нить&raquo;, после которой запускается процесс приостановки роста околоногтевой кожи.</p>
<p>Ваша кутикула постепенно завернется в красивый валик, покрытие не будет отрастать 3 недели, маникюр в целом будет носиться дольше и лучше.</p>
<p>Результаты после слайсинга и анатомической фрезы:</p>
<ul>
<li>Приостановка роста околоногтевой кожи</li>
</ul>
<p>У вас перестанет расти кутикула, исчезнут заусенцы, полностью прекратится&nbsp;рубцевание</p>
<ul>
<li>Тройная носибельность</li>
</ul>
<p>Ваш маникюр будет свежим на протяжении 3-х недель</p>
<ul>
<li>Не отрастает покрытие</li>
</ul>
<p>Гель лак вкладывается настолько глубоко, что до следующего маникюра не появляется голый ноготь</p>
<ul>
<li>Смена анатомического строения прилипшей кутикулы на красивый овал</li>
</ul>
<p>За 3-4 сеанса мокрая кутикула примет форму красивого кармана</p>
<img src="'.$img.'/salon1.png" class="modal_img modal_float">
<p>Наш мастер:</p>
<p>Дзахмишева Нина Владимировна</p>
<p>Опыт 4 года.</p>
<p>Мастер проведет для вас эксперимент. В первый сеанс сделает на одной руке сухой вид (анатомическую фрезу), на другой мокрый вид (слайсинг). К следующей записи вы самостоятельно увидите какую технику маникюра предпочитает ваша кожа.</p>
<p>Адрес: Пресненская набережная 8 строение 1, Башня Москва &laquo;Город столиц&raquo;, 51 этаж, офис 513м.</p>
<p>Запись ведется по указанным на сайте контактам</p>
<img src="'.$img.'/salon2.png" class="modal_img modal_float" style="width: 45%; min-width: 259px;">';

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
	<div class="overlay open"><div class="modal open" id="modal1">
	<div class="modal__content">';
	$post_content = '</div>
	</div></div></main>
</body>
</html>';
	echo ($pre_content.$content.$post_content);
}
?>




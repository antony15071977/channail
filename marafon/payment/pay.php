<?php 
if(isset($_GET["course_name"]) && isset($_GET["price"]) && isset($_GET["url"])){
	$course_name = $_GET["course_name"];
	$price = $_GET["price"];
	$InvId = (isset($_GET['InvId'])) ? '&InvId='.$_GET['InvId'] : '';
	$Culture = (isset($_GET['Culture'])) ? '&Culture='.$_GET['Culture'] : '';
	$Encoding = (isset($_GET['Encoding'])) ? '&Encoding='.$_GET['Encoding'] : '';
	$Description = (isset($_GET['Description'])) ? '&Description='.$_GET['Description'] : '';
	$OutSum = (isset($_GET['OutSum'])) ? '&OutSum='.$_GET['OutSum'] : '';
	$shp_item = (isset($_GET['shp_item'])) ? '&shp_item='.$_GET['shp_item'] : '';
	$SignatureValue = (isset($_GET['SignatureValue'])) ? '&SignatureValue='.$_GET['SignatureValue'] : '';
	$url = $_GET["url"].$InvId.$Culture.$Encoding.$Description.$OutSum.$shp_item.$SignatureValue;
}
?>
<!DOCTYPE html>
<html lang="ru-RU">
<head>
	<meta charset="UTF-8">
	<title>Страница платежа ООО'ШАННЭЙЛ 4'</title>
	<meta name="description" content="Страница платежа ООО'ШАННЭЙЛ 4'">
	<link href='css/styling.css' rel='stylesheet' type='text/css'>
	<link href="img/favicon.jpg" rel="icon" >
	<meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport">
</head>
<body class="home">
	<div class="main-wrapper">
		<div class="top-box">
			<img class="top-box_logo" src="img/logo.png">
			<h1 class="top-box_h1">Бронирование</h1>
			<h2 class="top-box_h2"><?= $course_name; ?></h2>
			<h2 class="top-box_h2" >Стоимость - <span style="font-weight: bold;"><?= $price; ?> р.</span></h2>
			<br>
			<hr class="top-box_hr">
			<a class="card__order" href="<?= $url; ?>">Бронировать</a>
			<p class="top-box_p">Нажимая кнопку «Забронировать», вы даете свое <a class="paymentTermsLink" href="https://channail4.ru/courses/agreement.html" target="_blank">согласие на обработку персональных данных</a> в соответствии с нашей <a class="paymentTermsLink" href="https://channail4.ru/courses/privacy.html" target="_blank">политикой защиты персональной информации </a>и заключаете <a class="paymentTermsLink" href="https://channail4.ru/courses/oferta_ooo.html" target="_blank">договор купли - продажи</a>.<br> Информация о каждом из выбранных курсов (продолжительность, содержание и программа, стоимость) указана в описании к соответствующему курсу.<br>
				Отношения по приобретению онлайн курсов регулируются нормами Гражданского кодекса Российской Федерации и Закона о защите прав потребителей.</p>			
		</div>
		<p class="footer_heading">Мы находимся здесь</p>
		<div class="footer">
			<div class="footer_agree-container">
				<a class="footer_agree" href="https://goo.gl/maps/hRANBzD7e9aQiMZa6" rel="nofollow" target="_blank">Москва, Пресненская набережная д.8, строение 1, Офис 513М, 51 этаж.<br>Башня - Город Столиц.<br>м.Деловой центр</a>
			</div>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.6543120327906!2d37.53695611619116!3d55.74713509989625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54bdc5428a163%3A0x3b0b79e32bc6df32!2zZ29yb2QgU3RvbGl0cywg0J_RgNC10YHQvdC10L3RgdC60LDRjyDQvdCw0LEuLCA4INGB0YLRgNC-0LXQvdC40LUgMSwg0JzQvtGB0LrQstCwLCDQoNC-0YHRgdC40Y8sIDEyMzMxNw!5e0!3m2!1sru!2sua!4v1593369982099!5m2!1sru!2sua" width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
			<div class="footer_agree-container">
				<a href="https://channail4.ru/courses/agreement.html" target="_blank" class="footer_agree">Согласие на обработку персональных данных</a>
				<a href="https://channail4.ru/courses/oferta_ooo.html" target="_blank" class="footer_agree">Договор оферты</a>
				<a href="https://channail4.ru/courses/privacy.html" target="_blank" class="footer_agree">Политика защиты персональной информации</a>
			</div>
			<p class="footer_heading">Контакты</p>
			<p class="pre-instrument-info"><strong>ООО &laquo;ШАННЭЙЛ 4 НЭЙЛ КУТЮР&raquo;&nbsp; </strong></p>
				<p class="pre-instrument-info">Юр. адрес: 123112, г. Москва,&nbsp; набережная Пресненская&nbsp; д.8, стр.1, комн.2, ч.пом.513м, э.51</p>
				<p class="pre-instrument-info">ИНН 9703001389</p>
				<p class="pre-instrument-info">КПП 770301001</p>
				<p class="pre-instrument-info">ОГРН 1197746551540</p>
				<p class="pre-instrument-info">Телефон: +7 (985) 586-14-15</p>
				<p class="pre-instrument-info">Email: <a href="mailto:channail4school@yandex.ru" class="elementor-heading-title elementor-size-default">channail4school@yandex.ru</a></p>
				<p class="pre-instrument-info"><strong>Генеральный директор Креминская Ирина Юрьевна</strong></p>
				<br>
			<p class="pre-instrument-info"><strong>ИП КРЕМИНСКАЯ И.Ю.</strong></p>
				<p class="pre-instrument-info">Адрес: г.Москва, поселок Толстопальцево, ул.Ленина, д.28, кв.1</p>
				<p class="pre-instrument-info">ИНН 972703148973</p>
				<p class="pre-instrument-info">ОКПО:2000553389</p>
				<p class="pre-instrument-info">ОГРНИП: 319774600726296</p>
				<p class="pre-instrument-info">Расчетный счет: 40802810738000074331</p>
				<p class="pre-instrument-info">Банк: ПАО Сбербанк</p>
				<p class="pre-instrument-info">БИК: 044525225</p>
				<p class="pre-instrument-info">Корр. счет: 30101810400000000225</p>
				<p class="pre-instrument-info">Телефон: (898551715449), 89855861415</p>
				<p class="pre-instrument-info">Email: <a href="mailto:channail4school@yandex.ru" class="elementor-heading-title elementor-size-default">channail4school@yandex.ru</a></p>
				
			<div class="socials block-messenger">
				<div class="row row-small">
					<div class="col-xs-12">					<a href="tel:+79855861415" class="button btn-link btn-link-block btn-socials  btn-link-styled" rel="nofollow" target="_blank">
							<img src="img/tel.png" class="iconsoc btn-link-tel">
							<span>Позвонить</span>
						</a>
					</div>
				</div>
				<div class="row row-small">
					<div class="col-xs-12">					<a href="https://wa.me/79855861415?text=Здравствуйте%2C%20хотела%20бы%20узнать%20" aria-label="Задать вопрос в WhatsApp" class="button btn-link btn-link-block btn-socials btn-link-styled" rel="nofollow" target="_blank">
							<img src="img/whats.png" class="iconsoc btn-link-whatsapp">
							<span>Задать вопрос в WhatsApp</span>
						</a>
					</div>
				</div>
				<div class="row row-small">
					<div class="col-xs-12">					<a href="https://www.instagram.com/chan_nail4school/" aria-label="Задать вопрос в Instagram" class="button btn-link btn-link-block btn-socials btn-link-styled" rel="nofollow" target="_blank">
							<img src="img/insta.png" class="iconsoc btn-link-inst">
							<span>Задать вопрос в Instagram</span>
						</a>
					</div>
				</div>
			</div>
		</div>		
	</div>
</body>
</html>
<?php
if (isset($_GET['ajax'])&&$_GET['ajax']=='true') {
	$points = '';
	$Js = '<script src="js/jquery.mask.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>	
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(\'input[type="tel"]\').mask("+0(000)000-00-00",{placeholder:"0(000)000-00-00 "});
			});
	</script>
	<script src="js/mailingScript.js"></script>';
} else {
	$points = '../';
	$Js = '<script src="../js/mailingScriptNotPopup.js"></script>';
}
$content = '<div class="elementor-widget-wrap">
	<div class="elementor-element elementor-element-4e26648 elementor-widget elementor-widget-heading">
		<div class="elementor-widget-container">
			<div class="elementor-heading-title elementor-size-default">
				Оставьте заявку
			</div>
		</div>
	</div>
	<div class="elementor-element elementor-element-12bacf8 elementor-widget elementor-widget-divider">
		<div class="elementor-widget-container">
			<div class="elementor-divider">
				<span class="elementor-divider-separator"></span>
			</div>
		</div>
	</div>
	<div class="elementor-element elementor-element-8d7cafd elementor-widget elementor-widget-heading">
		<div class="elementor-widget-container">
			<div class="elementor-heading-title elementor-size-default">
				Мы свяжемся с Вами и ответим на все интересующие Вас вопросы
			</div>							
		</div>
	</div>
	<div class="elementor-element elementor-element-e71864d elementor-button-align-stretch elementor-widget elementor-widget-form">			
		<div class="elementor-widget-container">
			<div class="form-result-error d-none">Ошибка отправления, попробуйте еще раз!</div>
			<form class="elementor-form" action="'.$points.'ajax-form.php" method="post" id="feedback3">
				<div class="elementor-form-fields-wrapper elementor-labels-">
					<div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-name elementor-col-100 elementor-field-required">
						<label for="name" class="control-label">Имя</label>
						<input class="elementor-field elementor-size-md elementor-field-textual form-control" value="" name="name" placeholder="Имя" required="required" minlength="2" maxlength="30" size="1" type="text" id="name" title="Введите минимум 2 символа, максимум 30!">

					</div>
					<div class="elementor-field-type-email elementor-field-group elementor-column elementor-field-group-email elementor-col-100 elementor-field-required">
						<label for="email" class="control-label">Email</label>
						<input class="elementor-field elementor-size-md elementor-field-textual form-control" id="email" value="" name="email" placeholder="YourMail@yandex.ru" required="required" size="1" type="email" title="Введите валидный email!">

					</div>
					<div class="elementor-field-type-tel elementor-field-group elementor-column elementor-field-group-field_1 elementor-col-100 elementor-field-required">
						<label for="phone" class="control-label">Телефон</label>
						<input id="phone" class="elementor-field elementor-size-md elementor-field-textual form-control" name="phone"  placeholder="" required minlength="16" title="+7 либо 8(000)(000)-(00)-(00)" size="1" type="tel">

					</div>

					<div class="form-submit elementor-field-group elementor-column elementor-field-type-submit elementor-col-100">
						<button class="form-submit3 elementor-button elementor-size-lg" type="submit"><span><span class="elementor-button-text">Оставить заявку</span></span></button>
					</div>
					<div class="elementor-field-group elementor-column elementor-field-type-submit elementor-col-100">
						<div class="elementor-element elementor-element-8d7cafd elementor-widget elementor-widget-heading" style="width: 100%;">
							<div class="elementor-widget-container">
								<div class="elementor-heading-title elementor-size-default">
									Либо можете прямо сейчас связаться с нами, используя телефон, Direct Instagram или WhatsApp
								</div>
								<div class="container block-item has-pb-1 has-pt-1" style="max-width: 1080px;">
									<div class="row">
										<div class="col-xs-12 col-sm-10 col-md-8 col-md-offset-2 b-9679784">
											<div class="socials block-messenger" block_id="9679784" index="8">
												<div class="row row-small">
													<div class="col-xs-12">
														<a href="tel:+79855861415"  class="button btn-link btn-link-block btn-socials btn-link-tel btn-link-styled" rel="nofollow" target="_blank"><!----> 
															<img src="'.$points.'img/tel.png" class="iconsoc">
															<span>Позвонить</span>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="container block-item has-pb-1 has-pt-1" style="max-width: 1080px;">
									<div class="row">
										<div class="col-xs-12 col-sm-10 col-md-8 col-md-offset-2 b-9679784">
											<div class="socials block-messenger" block_id="9679784" index="8">
												<div class="row row-small">
													<div class="col-xs-12">
														<a href="https://wa.me/79855861415?text=Здравствуйте%2C%20хотела%20бы%20узнать%20" aria-label="Задать вопрос в WhatsApp" class="button btn-link btn-link-block btn-socials btn-link-whatsapp btn-link-styled" rel="nofollow" target="_blank"><!----> 
															<img src="'.$points.'img/whats.png" class="iconsoc">
															<span>Задать вопрос в WhatsApp</span>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="container block-item has-pb-1 has-pt-1" style="max-width: 1080px;">
									<div class="row">
										<div class="col-xs-12 col-sm-10 col-md-8 col-md-offset-2 b-9679784">
											<div class="socials block-messenger" block_id="9679784" index="8">
												<div class="row row-small">
													<div class="col-xs-12">
														<a href="https://www.instagram.com/chan_nail4school/" aria-label="Задать вопрос в Instagram" class="button btn-link btn-link-block btn-socials btn-link-inst btn-link-styled" rel="nofollow" target="_blank"><!----> 
															<img src="'.$points.'img/insta.png" class="iconsoc"> 
															<span>Задать вопрос в Instagram</span>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</form>
			<div class="form-result-success d-none">
				<div>Форма успешно отправлена. Чтобы продолжить просмотр сайта, закройте это модальное окно.
				</div>
			</div>
		</div>
	</div>
	<div class="elementor-element elementor-element-82baddc elementor-widget elementor-widget-heading" data-element_type="widget" data-id="82baddc" data-widget_type="heading.default">
		<div class="elementor-widget-container">
			<div class="elementor-heading-title elementor-size-default">
				Нажимая кнопку "Оставить заявку" Вы даете <a class="paymentTermsLink" style="color:#888;text-decoration:underline;" href="'.$points.'agreement.html" target="_blank">согласие на обработку персональных данных</a> в соответствии с нашей <a class="paymentTermsLink" style="color:#888;text-decoration:underline;" href="'.$points.'privacy.html" target="_blank">политикой защиты персональной информации </a>
			</div>
		</div>
	</div>
</div>'.$Js;

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
	<script src="../js/jquery.min.js"></script>
</head>
<body class="home modal--overflow">
	<main>
		<div class="overlay open">
		<div class="modal open elementor elementor-271" id="modal1">
	        <div class="modal__content">';
	$post_content = '
	</div></div></div></main>
	<script src="../js/jquery.mask.min.js"></script>
	<script src="../js/jquery.validate.min.js"></script>	
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(\'input[type="tel"]\').mask("+0(000)000-00-00",{placeholder:"0(000)000-00-00 "});
			});
	</script>
</body>
</html>';
	echo ($pre_content.$content.$post_content);
}
?>

<?php
if (isset($_GET['ajax'])&&$_GET['ajax']=='true') {
	$points = '';
	$Js = '<script src="js/jquery.validate.min.js"></script>	
	<script src="js/mailingScriptReview.js"></script>';
} else {
	$points = '../';
	$Js = '<script src="../js/mailingScriptReview.js"></script>';
}
$content = '<div class="elementor-widget-wrap">
				<div class="loading-overlay" style="display: none;">
            		<div class="overlay-content">
            		<img src="'.$points.'img/load.gif">
            		</div>
        		</div>
	<div class="elementor-element elementor-element-4e26648 elementor-widget elementor-widget-heading">
		<div class="elementor-widget-container">
			<div class="elementor-heading-title elementor-size-default">
				Оставьте Ваш отзыв
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
				Отзыв будет опубликован после прохождения модерации
			</div>							
		</div>
	</div>
	<div class="elementor-element elementor-element-e71864d elementor-button-align-stretch elementor-widget elementor-widget-form">			
		<div class="elementor-widget-container">
			<div class="form-result-error d-none">Ошибка отправления, попробуйте еще раз!</div>
			<form class="elementor-form" action="'.$points.'ajax-review.php" method="post" id="feedback3">
				<div class="elementor-form-fields-wrapper elementor-labels-">
					<div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-name elementor-col-100 elementor-field-required">
						<label for="name" class="control-label">Имя</label>
						<input class="elementor-field elementor-size-md elementor-field-textual form-control" value="" name="name" placeholder="Имя" required="required" minlength="2" maxlength="30" size="1" type="text" id="name" title="Введите минимум 2 символа, максимум 30!">

					</div>
					<div class="elementor-field-type-email elementor-field-group elementor-column elementor-field-group-email elementor-col-100 elementor-field-required">
						<label for="email" class="control-label">Email</label>
						<input class="elementor-field elementor-size-md elementor-field-textual form-control" id="email" value="" name="email" placeholder="YourMail@yandex.ru" required="required" size="1" type="email" title="Введите валидный email!">

					</div>
					<div class="elementor-field-type-email elementor-field-group elementor-column elementor-field-group-email elementor-col-100 elementor-field-required">
						<label for="comment" class="control-label">Ваш комментарий здесь:</label>
						<textarea class="elementor-field elementor-size-md elementor-field-textual form-control"  name="comment" id="comment" rows="8" required="required" cols="80" maxlength="600" minlength="10" placeholder="Помните о правилах и этикете. Минимум 10, максимум 600 символов."></textarea>

					</div>
					<div class="elementor-field-type-email elementor-field-group elementor-column elementor-field-group-email elementor-col-100 elementor-field-required">
						<label for="avatar" class="control-label">Фото (вертикальной ориентации) обязательно для отзыва (формат только jpg или png)</label>
						<br/>
						<div class="form__input-file elementor-field elementor-size-md elementor-field-textual form-control">
							<div id="image" class="upload-file-container">
							</div>
							<label for="avatar">
				                <span>Выбрать фото</span>
				            </label>                    	
                    	</div>
                    	<input type="file" name="avatar" class="visually-hidden photo" id="avatar" />
					</div>

					<div class="form-submit elementor-field-group elementor-column elementor-field-type-submit elementor-col-100">
						<button class="form-submit3 elementor-button elementor-size-lg" type="submit"><span><span class="elementor-button-text">Оставить отзыв</span></span></button>
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
				Нажимая кнопку "Оставить отзыв" Вы даете <a class="paymentTermsLink" style="color:#888;text-decoration:underline;" href="'.$points.'agreement.html" target="_blank">согласие на обработку персональных данных</a> в соответствии с нашей <a class="paymentTermsLink" style="color:#888;text-decoration:underline;" href="'.$points.'privacy.html" target="_blank">политикой защиты персональной информации </a>
			</div>
		</div>
	</div>
</div>
<script>function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(\'#image\').css(\'background\', \'transparent url(\'+e.target.result +\') center top / cover no-repeat\');
            $(\'#image\').css(\'width\', \'200px\');
            $(\'#image\').css(\'height\', \'300px\');
             $(\'#image\').css(\'margin\', \'0px auto 20px\');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
$("#avatar").change(function(){
    readURL(this);
});</script>'.$Js;

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
	<meta name="description" content="Авторская школа маникюра в Москве Кутикульное Царство. Очное и онлайн обучение маникюрному искусству.">
	<meta property="og:description" content="Школа маникюра ШАННЭЙЛ 4. Авторская школа маникюра в Москве Кутикульное Царство. Очное и онлайн обучение маникюрному искусству.">
	<link href=\'../css/style.css\' rel=\'stylesheet\' type=\'text/css\'>
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
</body>
</html>';
	echo ($pre_content.$content.$post_content);
}
?>

$(document).ready(function() {
	$('form.elementor-form').each(function() {
		$(this).validate({
			//Правила валидации
			rules: {
				name: {
					required: true,
				},
				comment: {
					required: true,
				},
				email: {
					required: true,
					email: true
				},
			},
			//Сообщения об ошибках
			messages: {
				name: {
					required: "Обязательно укажите имя",
				},
				email: {
					required: "Обязательно укажите Email",
				},
				comment: {
					required: "Текст отзыва обязателен",
				},
			},
			/*Отправка формы в случае успеха валидации*/
			submitHandler: function(form) {
				sendAjaxForm($(form).prop('id')); //Вызываем функцию отправки формы
			}
		});
	})

	function sendAjaxForm(formId) {
		var formRg = $('#feedback3')[0];
		var formData = new FormData(formRg);
		$.ajax({
			url: '/courses/review/ajax-review.php', //url страницы (ajax-form.php)
			type: "POST", //метод отправки
			data: formData,
			dataType: "json",
        	cache: false,
        	contentType: false,
        	processData: false, // Сериализуем объекты формы
        	beforeSend: function() {
	            $('.loading-overlay').show();
	        },
	        complete: function() {
	            $('.loading-overlay').hide();
	        },
			success: function(data) { 
				if (data.result == "success") {
					var formParent = $('#' + formId).parent();
					$('.form-result-success', formParent).removeClass('d-none').addClass('d-success');
					$('#' + formId)[0].reset();
					setTimeout(function() {
						$('.form-result-success', formParent).removeClass('d-success').addClass('d-none');
					}, 4000);
				} 
				if (data.result == "error") {
					var formParent = $('#' + formId).parent();
					$('.form-result-error', formParent).removeClass('d-none').addClass('d-flex');
					$('input').on('focus', function() {
						$('.form-result-error', formParent).removeClass('d-flex').addClass('d-none');
						});
				}
			},
			error: function(data) { // Данные не отправлены
				//Ваш код если ошибка
				var formParent = $('#' + formId).parent();
				$('.form-result-error', formParent).removeClass('d-none').addClass('d-flex');
				$('input').on('focus', function() {
					$('.form-result-error', formParent).removeClass('d-flex').addClass('d-none');
				});
			}
		});
	}
});




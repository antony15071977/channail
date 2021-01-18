$(".modal").each(function() {
	$(this).wrap('<div class="overlay"></div>')
});
$(".open-modal").on('click', function(e) {
	e.preventDefault();
	e.stopImmediatePropagation;
	$('.home').addClass('modal--overflow');
	var $this = $(this),
		modal = $($this).data("modal");
		$url = $(this).data("url");
		close = $(".close-modal");
		$(modal).parents(".overlay").addClass("open");
	$.ajax({
		url: $url,
		cache: false,
		async: false,
		data: {ajax: true},
		success: function(dataResult) {
			$('.modal__content').html(dataResult);
		}
	});
	
	setTimeout(function() {
		$(modal).addClass("open");
		close.css("display", "block");
	}, 350);
	$(document).on('click', function(e) {
		var target = $(e.target);
		if ($(target).hasClass("overlay")) {
			$(target).find(".modal").each(function() {
				close.css("display", "none");
				$(this).removeClass("open");
				$('.home').removeClass('modal--overflow');
			});
			setTimeout(function() {
				$(target).removeClass("open");
				$('.modal__content').html('');
			}, 350);
		}
	});
});
$(".modal").on('click', ".close-modal", function(e) {
	e.preventDefault();
	e.stopImmediatePropagation;
	var $this = $(this),
		modal = $($this).data("modal");
	close.css("display", "none");
	$(modal).removeClass("open");
	$('.home').removeClass('modal--overflow');
	setTimeout(function() {
		$(modal).parents(".overlay").removeClass("open");
		$('.modal__content').html('');
	}, 350);
});


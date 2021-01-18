$(document).ready(function(){
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
	$.ajax({
		url: $url,
		cache: false,
		data: {ajax: true},
		success: function(dataResult) {
			$('.modal__content').html(dataResult);
		}
	});
	$(modal).parents(".overlay").addClass("open");
	setTimeout(function() {
		$(modal).addClass("open");
		$(modal).css("display", "block");
		$('.close-modal').css("display", "block");
	}, 350);
	$(document).on('click', function(e) {
		var target = $(e.target);
		if ($(target).hasClass("overlay")) {
			$(target).find(".modal").each(function() {
				$('.home').removeClass('modal--overflow');
			});
			setTimeout(function() {
				$(this).removeClass("open");
				$(target).removeClass("open");
				$(modal).css("display", "none");
				$('.close-modal').css("display", "none");
				$('.modal__content').html('');
			}, 350);
		}
	});
});
$('.close-modal').on('click', function(e) {
	e.preventDefault();
	e.stopImmediatePropagation;
	var $this = $(this),
		modal = $($this).data("modal");
	$('.home').removeClass('modal--overflow');
	setTimeout(function() {
		$(modal).parents(".overlay").removeClass("open");
		$(modal).css("display", "none");
		$(modal).removeClass("open");
		$('.close-modal').css("display", "none");
		$('.modal__content').html('');
	}, 350);
});
});

$(document).ready(function () {
	$('.panel-heading').click(function (e) {
		e.preventDefault();
	e.stopImmediatePropagation;
		$(this).toggleClass('in').next().slideToggle();
		$('.panel-heading').not(this).removeClass('in').next().slideUp();
	});
	$('.accordeon_tumbler').click(function (e) {
		e.preventDefault();
	e.stopImmediatePropagation;
		$(this).toggleClass('in').next().slideToggle();
		$('.accordeon_tumbler').not(this).removeClass('in').next().slideUp();
	});

	$('.interview_text_points').on('click', function(e) {
		$(e.target).animate({
	      	      opacity: 0 
	    });
      $('.interview_text_hidden').slideToggle(function() {
        $(e.target).text($(this).is(':visible') ? 'Скрыть' : '...');
        $(e.target).animate({
	      	      opacity: 1 
	    });
      });
	});
});
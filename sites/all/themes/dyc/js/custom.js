(function ($) {
	//add drupal 7 code
	Drupal.behaviors.myfunction = {
	        attach: function(context, settings) {
	//end drupal calls
			// Hide all answers on the FAQ page
			$('.answer').hide();

			// Show each answer when it's question is clicked and hide it back again 
			$('.question').toggle(
			function(){
				$(this).parent().children('.answer').slideDown();
			},
			function(){
				$(this).parent().children('.answer').slideUp();
			});
		}
	}
})(jQuery);

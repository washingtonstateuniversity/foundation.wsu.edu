(function($,window){

	var $people = $('#people-list').find('.wsuwp_uc_person');

	$('#filter-people').on('keyup', function() {
		var re = new RegExp(jQuery(this).val(), "i");

		$people.show().filter( function() {
			return !re.test(jQuery(this).find('.article-title, .person-title, .person-office, .person-phone, .person-email').text());
		}).hide();
	});
}(jQuery, window));
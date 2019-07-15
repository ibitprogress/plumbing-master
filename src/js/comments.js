function Open_C(event){
	$('.com-fade_in').on('click',function(){
		// $('.back_call_div').css({"display":"block"});
		$('.comments').fadeIn();
		// Close();
		closeBackCall_C();
	});
};



function closeBackCall_C(){
	$(document).mouseup(function (e){
		var div = $('.comments');
		var button = $('.com-fade_in');
		if (!div.is(e.target) && !button.is(e.target) && div.has(e.target).length === 0 ) {
			div.fadeOut();
		}
	});
};


$(document).ready(function(){
	 Open_C();

});




function Open(event){
	$('.back-call').on('click',function(){
		// $('.back_call_div').css({"display":"block"});
		$('.back_call_div').fadeIn();
		// Close();
		closeBackCall();
	});
	
};



function closeBackCall(){
	$(document).mouseup(function (e){
		var div = $('.back_call_div');
		var button = $('.back-call');
		if (!div.is(e.target) && !button.is(e.target) && div.has(e.target).length === 0 ) {
			div.fadeOut();
		}
	});
};


$(document).ready(function(){
	 Open();

});

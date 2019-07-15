$(".admin-open-nav").on("click", function(){
	if ($(this).attr('data-move') == ">") {
		$(".admin-nav ul").toggleClass("hidden-sm").toggleClass("hidden-xs");
		$(".admin-nav").animate({
			width: "30%"
		}, 1000);
		$(this).attr('data-move', '<').css("background-color", '#3AA4FF');
	} else if ($(this).attr('data-move') == "<") {
		$(".admin-nav ul").toggleClass("hidden-sm").toggleClass("hidden-xs");
		$(".admin-nav").animate({
			width: "12%"
		}, 1000);
		$(this).attr('data-move', ">").css("background-color", '#23282d');
	}
});

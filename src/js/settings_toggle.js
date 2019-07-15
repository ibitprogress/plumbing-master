$(document).ready(function(){
	$(".settings").on("click", function(){
		if($(this).attr("data-status") == "hidden") {
			$(".toggle").show();
			$(this).attr("data-status", "visible");
		} else if ($(this).attr("data-status") == "visible") {
			$(".toggle").hide();
			$(this).attr("data-status", "hidden");
		}
		
	})	
});
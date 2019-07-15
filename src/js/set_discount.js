var userid;
var user;
$(".setdiscount").on("click", function(){
	$(".admin-hidden-user-main-title").text($(this).attr("data-name"));
	$(".admin-hidden-user-main input").val($(this).attr("data-discount"));
	userid = $(this).attr("data-id");
	but = $(this);
	$(".admin-hidden-wrapper").css("display", "block");
});

$(".admin-hidden-user-main-button").on("click", function(){
	var discount = $(".admin-hidden-user-main input").val();
	$.ajax({
        url: '../../apps/set_discount.php',
        type: "POST",
        data: ({
            user: userid,
            discount: discount
        }),
        success: function() {
            $(".admin-hidden-wrapper").css("display", "none");
    		but.attr("data-discount", discount);
        }
    })
});

$(".admin-hidden-user-main input").on("input", function(){
	var discount = parseInt($(".admin-hidden-user-main input").val());
	if (discount >= 0 && discount <= 100) {
		$(".admin-hidden-user-main-button").css("opacity", "1").css("cursor", "pointer").removeAttr("disabled");
	} else {
		$(".admin-hidden-user-main-button").attr("disabled", "true").css("cursor", "default").css("opacity", "0.3");
	}
});

$(".admin-modal-user-close").on("click", function(){
	userid = 0;
	user = 0;
	$(".admin-hidden-wrapper").css("display", "none");
});
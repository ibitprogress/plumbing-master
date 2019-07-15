$(document).ready(function(){
	var images = parseInt($("#countimages").val());
	var isdel = 0;
	var setdel = function() {
		if (images > 1) {
			if (isdel == 0) {
				isdel = 1;
				$(".admin-delete-picture").append('<i class="fa fa-trash" aria-hidden="true"></i>');
				$(".admin-delete-picture i").on("click", function(){
					$(".imagenum"+images).html("");
					images = images - 1;
					if (images == 1) {
						$(".admin-delete-picture").html("");
						isdel = 0;
					}
				});
			}
		} else {
			$(".admin-delete-picture").html("");
			isdel = 0;
		}
	}

	var width = $(".admin-main-new-goods-bot-picture label").width();
	$(".admin-new-picture").css("margin-left", width/2);
	$(".admin-delete-picture").css("margin-left", "30px");

	$(".admin-new-picture i").on("click", function(){
		images = images + 1;
		var input = '<div class="imagenum'+images+'"><label for="picture'+images+'">Зображення №'+ images +'</label>';
		input += '<input data-id="'+images+'" type="file" name="picture'+images+'" id="picture'+images+'" hidden></i>';
		input += "</div>";
		$(".admin-pictures-list").append(input);
		setdel();
	});
	setdel();

	$("input[type=file]").on("click", function(){
		var image = $(this).attr("id");
		$("."+image).attr("value", "").attr("name", "deleted");
	})
});
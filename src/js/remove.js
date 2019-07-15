$(".removegoods i").on("click", function(){
    var t = $(this);
    var goods = t.attr("data-id");
    $.ajax({
        url: "../../apps/remove.php",
        method: "POST",
        data: ({
            goods: goods
        }),
        success: function(data){
            console.log(data);
            t.parent().parent().parent().parent().remove();
            data = JSON.parse(data);
            function removeinfo(){
				$("#error-info").remove();
			}
            var text = '<div id="error-info"> Видалено </div>';
            $("#countg").text("").append("<img src='../src/img/cart.png'> " + data[0] + " товарів");
			$("#summ").text("").append("всього: " + data[1] + " грн");
            $("body").append(text);
            if (data[0] == 0) {
                $(".makeorder").remove();
            }
            setTimeout(removeinfo, 2000);
        }
    })
});
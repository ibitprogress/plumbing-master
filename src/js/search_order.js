var kek;
function createEl( data ) {
    kek = data;
    var _info = '№'+data.id+
                '<div class="admin-main-list-actions-example admin-main-list-actions-example">'+
				''+data.date+''+
				'</div>'+
                '<br>'+
                'Замовник: '+ data.full_name +
                '<br>'+
                'Номер телефона: '+ data.phone +
                '<br>'+
                'E-mail: ' + data.email +
                '<br>'+
                'Спосіб оплати: '+ data.method +
                '<br>'+
                'Спосіб отримання: '+ data.dmethod + data.option+
                '<br>'+
                'Список замовлення:'+
                '<br>';
    for (var i = 0; i < data.basket.length; i++) {
        _info += i+1+') '+data.basket[i].name +' | '+data.basket[i].cost+' Грн.'+'<br>';
    }
    _info += "Загальна сума замовлення: " +data.sum+" Грн."
    return _info;
}

$("#ordernumsearch").on("click", function(){
    var orderId = parseInt($("#ordernum").val());
    $.ajax({
        url: "../../apps/getorder.php",
        method: "POST",
        data: ({id: orderId}),
        success: function(data) {
            data = JSON.parse(data);
            if (data == "error") {
                var _error = "<center>Замовлення №"+orderId+" не існує</center>"
                $(".admin-order-info").html("").append(_error);
            } else {
                var info = createEl(data);
                $(".admin-order-info").html("").append(info);
            }
        }
    })
});
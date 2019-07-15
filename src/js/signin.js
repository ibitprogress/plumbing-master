$(".btn-signin-user").on("click", function(){
    var username = $("#id_username").val();
    var password = $("#id_password").val();
    $.ajax({
        url: "../../apps/signin.php",
        method: "POST",
        data: ({
            email: username,
            password: password,
        }),
        success: function(data) {
            function remove() {
                $("#error-info").remove();
            }
            data = JSON.parse(data);
            console.log(data);
            if (data == "success") {
                location.reload();                
            } else if (data == "wrongpassword") {
                var text = '<div id="error-info"> Неправильний пароль </div>';
            } else if (data == "wronguser") {
                var text = '<div id="error-info"> Користувач не існує </div>';
            }
            $("body").append(text);
            setTimeout(remove, 2000);
        }
    });
});
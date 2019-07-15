$(document).ready(function(){
    function check(){
        var name = $(".admin-main-new-goods-top-name input").val()
        var descr = $(".admin-main-content textarea").val()
        if ( name.length === 0 ) {
            $(".admin-main-new-goods-submit button").attr("disabled", "true").css("cursor", "default").css("opacity", "0.3");
            $(".admin-main-new-goods-submit-g button").attr("disabled", "true").css("cursor", "default").css("opacity", "0.3");

        } else if ( name.length > 0 ) {
            $(".admin-main-new-goods-submit button").css("opacity", "1").css("cursor", "pointer").removeAttr("disabled");
            $(".admin-main-new-goods-submit-g button").css("opacity", "1").css("cursor", "pointer").removeAttr("disabled");
        }
    }

    setInterval(check, 500); 
});
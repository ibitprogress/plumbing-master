$(".show-full-image").on("click", function(){
	var src = $(this).attr("data-src");
	console.log(src);
	$(".goods-img img").attr("src", src);
})
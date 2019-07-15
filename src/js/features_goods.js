$("#categoryselect").on("change", function(){
	var _option = $(this).val();
	$.ajax({
		url: "../../apps/get_features.php",
		method: "POST",
		data: ({
			category: _option
		}),
		success: function(data) {
            $(".featurescontainer").html("");
		    data = JSON.parse(data);
			var _features = [];
			var _options = [];
			data[0].forEach(function(__features){
				_features.push(__features);
			});
			data[1].forEach(function(__options){
				_options.push(__options);
			});
			_options.forEach(function(___option, index){
				var optionInput = '<select name="feature'+(index+1)+'"><option value=0>'+_features[index].feature+'</option>';
				___option.forEach(function(____option){
					optionInput += '<option value='+____option.id+'>'+____option.option+'</option>';
                });
                optionInput += '</select><br>';
                $(".featurescontainer").append(optionInput);
			});
		}
	});
});
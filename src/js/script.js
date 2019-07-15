$(document).ready(function(){
	var pass = $('.pass');
	var cpass= $('.conf_pass');
	if (pass == cpass){
		var u = pass.length
    var p = cpass.length
    if ( u === 0 || p === 0) {
      $("#id_submit").attr("disabled", "true").css("cursor", "default").css("opacity", "0.3");
    } else if ( u > 0 && p > 0) {
      $("#id_submit").css("opacity", "1").css("cursor", "pointer").removeAttr("disabled");
    }
	}

    // double range
    $( function() {
	    $( "#slider-range" ).slider({
	      range: true,
	      min: 0,
	      max: 15000,
	      values: [ 0, 15000 ],
	      slide: function( event, ui ) {
	        $('#price-from').val( ui.values[ 0 ]);
	        $('#price-to').val( ui.values[ 1 ] );
	      }
	    });
    	$( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) + $( "#slider-range" ).slider( "values", 1 ) );
    	
    	$('#price-from').on("input", function(){
    		var pFrom = $('#price-from').val();
    		var pTo = $('#price-to').val();

    		if(parseInt(pFrom) > parseInt(pTo)){
    			pFrom = pTo;
    			$('#price-from').val(pFrom);
    		}
    		$('#slider-range').slider('values',0, pFrom);
    	});
    	$('#price-to').on("input", function(){
    		var pFrom = $('#price-from').val();
    		var pTo = $('#price-to').val();

    		if(pTo > 1000){
    			$('#price-to').val(1000)
    		} 

    		if(parseInt(pFrom) > parseInt(pTo)){
    			pTo = pFrom;
    			$('#price-from').val(pTo);
    		}
    		$('#slider-range').slider('values', 1, pTo);
    	});
    	

  	});

  // Carousel
    $('.carousel').carousel();


});
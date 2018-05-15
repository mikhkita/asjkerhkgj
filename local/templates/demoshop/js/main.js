$( document ).ready(function() {
  	$( "#accordion" ).accordion({
	  	active: 2,
	  	collapsible: true,
	  	heightStyle: "content"
    });
	$(" #hider ").click(function(){
    	if ($(" #search ").hasClass("show-s")){
    		$(" #search ").removeClass("show-s");
    	} else {
    		$(" #search ").addClass("show-s")
    	}
	});
	$( " .single-slide " ).slick({
   		infinite: true,
   		speed: 500,
   		slidesToScroll: 1,
   		arrows: false
 	});
});


